# Payer OpenCart Module

This is the payment module to get started with Payers payment services in OpenCart.

For more information about our payment services, please visit [www.payer.se](http://www.payer.se).

## Requirements

  * [OpenCart](http://www.opencart.com): Version 2.1
  * [Payer Configuration](https://payer.se) - Missing the configuration file? Contact the [Customer Service](mailto:kundtjanst@payer.se).

## Installation

  1. Place the `admin`, `catalog` and `images` folders in the root of your OpenCart installation.
  2. From the OpenCart administration page, go to `Extensions`and then `Payment`.
  3. Install and configure the module.   

## Configuration

You need to have your `PayReadConf` file available. Replace that file with the placeholder in the `catalog/controller/payment/payerapi` folder.

## Environment

You can switch between the `test` and `live` environment in the payment method interface through the `Payment Modules` section in OpenCart administration. 

**Note:** Remember to turn off the test environment before you go in production mode.

## Support

For questions regarding your payment module integration, please contact the Payer [Technican Support](mailto:teknik@payer.se). 