<?php

/**
 * @deprecated 1.5.0 This file is deprecated, use moduleFrontController instead
 */

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');
include(dirname(__FILE__).'/../../init.php');

$context = Context::getContext();
$cart = $context->cart;
$pagoenlinea = Module::getInstanceByName('pagoenlinea');

if ($cart->id_customer == 0 OR $cart->id_address_delivery == 0 OR $cart->id_address_invoice == 0 OR !$pagoenlinea->active)
	Tools::redirect('index.php?controller=order&step=1');

// Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
$authorized = false;
foreach (Module::getPaymentModules() as $module)
	if ($module['name'] == 'pagoenlinea')
	{
		$authorized = true;
		break;
	}
if (!$authorized)
	die($pagoenlinea->l('This payment method is not available.', 'validation'));

$customer = new Customer((int)$cart->id_customer);

if (!Validate::isLoadedObject($customer))
	Tools::redirect('index.php?controller=order&step=1');

$currency = $context->currency;
$total = (float)($cart->getOrderTotal(true, Cart::BOTH));

$pagoenlinea->validateOrder($cart->id, Configuration::get('PS_OS_PAGOENLINEA'), $total, $pagoenlinea->displayName, NULL, array(), (int)$currency->id, false, $customer->secure_key);

$order = new Order($pagoenlinea->currentOrder);
Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$pagoenlinea->id.'&id_order='.$pagoenlinea->currentOrder.'&key='.$customer->secure_key);
