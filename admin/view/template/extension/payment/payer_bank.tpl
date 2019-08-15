<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-payer_bank" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-payer_bank" class="form-horizontal">
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select id="payer_bank_status" name="payer_bank_status">
								<?php if (isset($payer_bank_status) && $payer_bank_status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_mid"><?php echo $entry_mid; ?></label>
						<div class="col-sm-10">
							<input type="text" id="payer_bank_mid" name="payer_bank_mid" value="<?php echo (isset($payer_bank_mid)) ? $payer_bank_mid : '' ?>" placeholder="<?php echo $entry_mid; ?>" class="form-control" />
							<?php if (isset($error_mid)) { ?>
								<div class="text-danger"><?php echo $error_mid; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_key"><?php echo $entry_key; ?></label>
						<div class="col-sm-10">
							<input type="text" name="payer_bank_key" value="<?php echo (isset($payer_bank_key)) ? $payer_bank_key : '' ?>" placeholder="<?php echo $entry_key; ?>" class="form-control" />
							<?php if (isset($error_key)) { ?>
								<div class="text-danger"><?php echo $error_key; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_keyb"><?php echo $entry_keyb; ?></label>
						<div class="col-sm-10">
							<input type="text" id="payer_bank_keyb" name="payer_bank_keyb" value="<?php echo (isset($payer_bank_keyb)) ? $payer_bank_keyb : '' ?>" placeholder="<?php echo $entry_keyb; ?>" class="form-control" />
							<?php if (isset($error_keyb)) { ?>
								<div class="text-danger"><?php echo $error_keyb; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_test"><?php echo $entry_test; ?></label>
						<div class="col-sm-10">
							<select id="payer_bank_test" name="payer_bank_test">
								<?php if (isset($payer_bank_test) && $payer_bank_test) { ?>
									<option value="1" selected="selected"><?php echo $text_yes; ?></option>
									<option value="0"><?php echo $text_no; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_yes; ?></option>
									<option value="0" selected="selected"><?php echo $text_no; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_debug"><?php echo $entry_debug; ?></label>
						<div class="col-sm-10">
							<select id="payer_bank_debug" name="payer_bank_debug">
								<?php if (isset($payer_bank_debug) && $payer_bank_debug) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_order_status_id"><?php echo $entry_order_status; ?></label>
						<div class="col-sm-10">
							<select id="payer_bank_order_status_id" name="payer_bank_order_status_id">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if (isset($payer_bank_order_status_id) && $order_status['order_status_id'] == $payer_bank_order_status_id) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
						<div class="col-sm-10">
							<select id="payer_bank_geo_zone_id" name="payer_bank_geo_zone_id">
								<option value="0"><?php echo $text_all_zones; ?></option>
								<?php foreach ($geo_zones as $geo_zone) { ?>
									<?php if ($geo_zone['geo_zone_id'] == $payer_bank_geo_zone_id) { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="payer_bank_sort_order"><?php echo $entry_sort_order; ?></label>
						<div class="col-sm-10">
							<input type="text" id="payer_bank_sort_order" name="payer_bank_sort_order" value="<?php echo (isset($payer_bank_sort_order)) ? $payer_bank_sort_order : '' ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript"><!--
	$.tabs('.tabs a');
	//--></script>
<?php
echo (isset($footer)) ? $footer : '' ?>