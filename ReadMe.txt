/**************************************
* CHARSET IN FILE: UTF-8
* Payer Financial Services AB
* Payment gateway | OpenCart 2.x
* Senast uppdaterad: 21-04-2015
*
* * * * * * * * * * * * * * * * * * * *
* 
* Payer avsäger sig allt ansvar och lämnar inga garantier för funktionen i tillhandahållen modul.
* Modulerna har en grundkonfiguration som ibland behöver anpassas för att bäst lämpas den enskilda butiken.
* För att säkerställa en betalning hänvisas ni till Payers administratörsvy.
*
* Var exempelvis noga med att testa modulerna innan skarp lansering. Kontrollera fraktavgifter, momssatser och externa rabattmoduler etc.
*
* För support - kontakta teknik@payer.se
*
* * * * * * * * * * * * * * * * * * * *
* 
* Payer disclaims any responsibility and makes no warranty for the functionality of the supplied module.
* The modules have a basic configuration that sometimes needs to be adapted to perfectly apply the individual store.
* For confirmation of the payment you are referred to Payer's admin interface.
*
* For example - make sure to test the modules before the live launch. Doublecheck the shipping charges, VAT-rates and external discount modules etc.
*
* For support - contact teknik@payer.se
* 
***************************************/



ALL MODULES ARE WITHOUT ANY WARRANTY - USE AT OWN RISK

These modules are known to work with opencart v.2.x
	
	
===============================================
   OPENCART 2.x PAYER.SE PAYMENT MODULE 
===============================================


Supported OpenCart Versions:
================
All v2.x versions 


What does it do:
================
This contrib adds support for Payer.se payment integration. 
The checkout button will redirect the customer to the gateway site. 
From there, the customer enters the payment details and pays. 
Once payment is completed, the page will redirect back to your site to complete the order.


Requirements:
==============
  * You will of course need to have a Payer.se account.
  * You will need to have SEK installed as a store currency.


Main features:
==============
  * Debug Mode (emails request vars to store owner)
  * Test mode Support
  * Supported Currencies check and auto-convert
  * Full support of error messages.


How to install it:
==================
1) Upload and merge admin, catalog and image folders in your root map of opencart.
2) From the admin menu, go to 'Extensions->Payment'.
3) Install the module, and click edit to configure.


Testing:
===================
Payer offers a test account to use for their backend:

Test Account url: https://secure.payer.se/adminweb/inloggning/inloggning.php
Test Agent ID: TESTINSTALLATION
Test Password: dPS6td4iHG5h

On the OpenCart side, you can use:

Agent ID: TESTINSTALLATION
KEY A: j3qh0b3B22sIyWulCZKeFJvIMx9mylLId2Qd4JEUAWtYJOacDKg9kCGWZE0oQKWUCDXwcshCfArOerQI2XGcpdYfIXtoyg02JWnLfuekVvZ1NGyFt5HJ8vOGj9VIeUzO
KEY B: mzuP5yWQWzesjrRlfQToHSf1B2xjNseZRyFLWrsIRw12NIcTpW9XFdN76afIsjyaI4Muk543qTT5sWNHJLueP8aK8gjqqHrYB5jLYcEfWn0eaNMJo7O55PF3VOicmA2N

In test mode, Use 4111111111111111 as the credit card number with any valid exp date and 123 for cvv.


Support Thread:
===============
http://forum.opencart.com/