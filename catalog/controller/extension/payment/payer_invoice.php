<?php

class ControllerExtensionPaymentPayerinvoice extends Controller {

	public $pname = 'payer_invoice';

	public function index() {
		require_once(DIR_APPLICATION . "controller/extension/payment/payerapi/payread_post_api.php");
		$payer = new payread_post_api();
		$payer->add_payment_method('invoice');
		$payer->setClientVersion("opencart_2.0:$this->pname:v1.21");

		$this->load->language("extension/payment/$this->pname");
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['error'] = (isset($this->session->data['error'])) ? $this->session->data['error'] : NULL;
		unset($this->session->data['error']);
		$data['back'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=checkout/payment');

		$data['fields'] = array();

		$this->load->model('checkout/order');
		$this->load->model('setting/extension');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$order_totals = $this->model_setting_extension->getExtensions('total');

		$i = 1;
		$order_total_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND code NOT IN ('total','tax') ORDER BY sort_order");
		foreach ($order_total_query->rows as $total) {
			if ($total['code']=='sub_total') {
				// ADD THE INDIVIDUAL PRODUCTS FROM FROM DATABASE
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$this->session->data['order_id'] . "' and quantity > 0");
				foreach ($order_product_query->rows as $order_product) {
					$qty = $order_product['quantity'] == 0 ? 1 : $order_product['quantity'];
					$taxprc = $order_product['total']==0 ? 0 : 100.0*$order_product['tax']/$order_product['total'];
					$payer->add_freeform_purchase(
							$i++,//LineNumber
							$order_product['name'],
							round(($order_product['total']+$order_product['tax'])/$qty, 2),
							round($taxprc, 0), // VAT%(moms%)
							$qty
					);
				}				
			} else {
				// ADD THE OTHER LINES AND CALCULATE VAT
				$addVAT=25.0;
				$payer->add_freeform_purchase(
						$i++,//LineNumber
						$total['title'],
						round($total['value']*(100.0+$addVAT)/100.0, 2),
						$addVAT, // VAT%(moms%)
						1 // QTY
				);
			}
		}

		// Check for supported language, otherwise convert to default.
		$supported_languages = array('sv', 'en');
		if (in_array($this->config->get('config_language'), $supported_languages)) {
			$lang = $this->config->get('config_language');
		} else {
			$lang = 'sv';
		}

		$ts = date('YmdHis');
		$ref = "ID-" . $order_info['order_id'] . "-$ts";

		$payer->add_buyer_info($order_info['firstname'], $order_info['lastname'], $order_info['payment_address_1'], $order_info['payment_address_2'], $order_info['payment_postcode'], $order_info['payment_city'], $order_info['payment_iso_code_2'], $order_info['telephone'], '', /* phone work */ $order_info['telephone'], /* phone mobile */ $order_info['email'], '', /* organisation */ '', /* theOrgNr */ $order_info['customer_id'], $order_info['order_id'], '' /* theOptions */);

		$payer->setAgent($this->config->get('payment_' . $this->pname . '_mid'));
		$payer->setKeyA($this->config->get('payment_' . $this->pname . '_key'));
		$payer->setKeyB($this->config->get('payment_' . $this->pname . '_keyb'));

		$payer->set_language($lang);
		$payer->set_currency($order_info['currency_code']);
		$payer->set_test_mode($this->config->get('payment_' . $this->pname . '_test') == '1');
		$payer->set_reference_id($ref);

		$payer->set_success_redirect_url(HTTPS_SERVER . 'index.php?route=checkout/success');
		$payer->set_authorize_notification_url(HTTPS_SERVER . 'index.php?route=extension/payment/' . $this->pname . '/callback&mode=auth&order_id=' . $order_info['order_id']);
		$payer->set_settle_notification_url(HTTPS_SERVER . 'index.php?route=extension/payment/' . $this->pname . '/callback&mode=settle&order_id=' . $order_info['order_id']);
		$payer->set_redirect_back_to_shop_url(HTTPS_SERVER . 'index.php?route=checkout/checkout');

		if ($this->config->get('payment_' . $this->pname . '_debug')) {
			$payer->set_debug_mode("verbose");
		}

		$data['fields']['payread_agentid'] = $payer->get_agentid();
		$data['fields']['payread_xml_writer'] = $payer->get_api_version();
		$data['fields']['payread_data'] = $payer->get_xml_data();
		$data['fields']['payread_checksum'] = $payer->get_checksum();
		$data['fields']['payread_charset'] = $payer->get_charset();
		$data['action'] = $payer->get_server_url();

		$this->id = 'payment';

		return $this->load->view('extension/payment/' . $this->pname, $data);
	}

	public function confirm() {
		return;
	}

	public function callback() {
		$this->load->language("extension/payment/$this->pname");
		$this->load->model('checkout/order');

		$oid = $order_id = $this->request->get['order_id'];
		$order_info = $this->model_checkout_order->getOrder($order_id);

		// If there is no order info then fail.
		if (!$order_info) {
			$this->session->data['error'] = $this->language->get('error_no_order');
			$this->redirect((isset($this->session->data['guest'])) ? (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=checkout/guest_step_3') : (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=checkout/confirm'));
		}

		// If we get a successful response back...
		require_once(DIR_APPLICATION . "controller/extension/payment/payerapi/payread_post_api.php");

		$payer = new payread_post_api();

		$payer->setAgent($this->config->get('payment_' . "$this->pname" . "_mid"));
		$payer->setKeyA($this->config->get('payment_' . "$this->pname" . "_key"));
		$payer->setKeyB($this->config->get('payment_' . "$this->pname" . "_keyb"));

		$types = array("card" => "Kortbetalning", "bank" => "Direktbanksbetalning", "invoice" => "Faktura", "einvoice" => "E-Faktura", "sms" => "SMS-betalning", "phone" => "Telefonbetalning", "enter" => "Installment", "swish" => "Swish");

		if ($payer->is_valid_ip()) {
			if ($payer->is_valid_callback()) {
				if ($_GET['payer_callback_type'] == "auth") {
					die("TRUE:AUTH:ORDER:$oid");
				}
				if ($_GET['payer_callback_type'] == "settle") {
					$payread_payment_id = $_GET["payread_payment_id"];
					$payer_payment_type = $types[$_GET["payer_payment_type"]];
					if ($payer_payment_type == "") {
						$payer_payment_type = "Payment";
					}
					if ($_GET['payer_payment_type'] == "bank") {
						$paymenttype = 'Payer Bank';
					}
					elseif ($_GET['payer_payment_type'] == "card") {
						$paymenttype = 'Payer Card';
					}
					elseif ($_GET['payer_payment_type'] == "invoice") {
						$paymenttype = 'Payer Invoice';
					}
					elseif ($_GET['payer_payment_type'] == "einvoice") {
						$paymenttype = 'Payer EInvoice';
					}
					elseif ($_GET['payer_payment_type'] == "enter") {
						$paymenttype = 'Payer Installment';
					}
					elseif ($_GET['payer_payment_type'] == "swish") {
						$paymenttype = 'Payer Swish';
					}
					if ($_GET['payer_added_fee'] != "0") {
						$tax = ($_GET['payer_added_fee'] * 0.2);
						$this->db->query("INSERT INTO `" . DB_PREFIX . "order_product`(order_id, product_id, name, model, quantity, price, total, tax) VALUES('" . (int) $order_id . "', '0', 'Fakturaavgift', 'Avgift', '1', '" . ($_GET['payer_added_fee'] - $tax) . "', '" . ($_GET['payer_added_fee'] - $tax) . "', '" . $tax . "')");
						$this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = total+'" . $_GET['payer_added_fee'] . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");
						$this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET value = value+" . ($_GET['payer_added_fee'] - $tax) . ", text = (SELECT CONCAT(symbol_left,FORMAT(`" . DB_PREFIX . "order_total`.value,2),symbol_right) FROM `" . DB_PREFIX . "currency` WHERE code = (SELECT currency_code FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "')) WHERE order_id = '" . (int) $order_id . "' AND code = 'sub_total'");
						$this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET value = value+" . $tax . ", text = (SELECT CONCAT(symbol_left,FORMAT(`" . DB_PREFIX . "order_total`.value,2),symbol_right) FROM `" . DB_PREFIX . "currency` WHERE code = (SELECT currency_code FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "')) WHERE order_id = '" . (int) $order_id . "' AND code = 'tax'");
						$this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET value = value+" . $_GET['payer_added_fee'] . ", text = (SELECT CONCAT(symbol_left,FORMAT(`" . DB_PREFIX . "order_total`.value,2),symbol_right) FROM `" . DB_PREFIX . "currency` WHERE code = (SELECT currency_code FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "')) WHERE order_id = '" . (int) $order_id . "' AND code = 'total'");
					}
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('payment_' . $this->pname . '_order_status_id'), "$payer_payment_type via Payer. PaymentID:" . $payread_payment_id, true);
					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET payment_method = '" . $this->db->escape($paymenttype) . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");
					die("TRUE:SETTLE:ORDER:$oid");
				}
				die("FALSE:UNKNOWN_CALLBACK_TYPE");
			}
			die("FALSE:CALLBACK");
		}
		die("FALSE:IP:" . $_SERVER['REMOTE_ADDR']);
	}

}

?>