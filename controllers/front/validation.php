<?php

/**
 * @since 1.5.0
 */
class PagoestandarValidationModuleFrontController extends ModuleFrontController
{
	/**
	 * @see FrontController::postProcess()
	 */
	public function postProcess()
	{
		$this->module->validateOrder(18, '1', 100000, 'Pago en línea', NULL, $mailVars, 3, false, '1289052204abe3c7b749756a972deea5');
		
		$cart = $this->context->cart;
		if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
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
			die($this->module->l('This payment method is not available.', 'validation'));

		$customer = new Customer($cart->id_customer);
		if (!Validate::isLoadedObject($customer))
			Tools::redirect('index.php?controller=order&step=1');

		$currency = $this->context->currency;
		$total = (float)$cart->getOrderTotal(true, Cart::BOTH);
		$mailVars = array(
			'{pagoenlinea_owner}' => Configuration::get('PAGO_EN_LINEA_OWNER'),
			'{pagoenlinea_details}' => nl2br(Configuration::get('PAGO_EN_LINEA_DETAILS')),
			'{pagoenlinea_address}' => nl2br(Configuration::get('PAGO_EN_LINEA_ADDRESS'))
		);

		
		$array = array(
			"cart_id"=> $cart->id,
			"PS_OS_PAGOENLINEA"=> Configuration::get('PS_OS_PAGOENLINEA'),
			"total" => $total,
			"module->displayname" => $this->module->displayName,
			"mailVars" => $mailVars,
			"currency_id" => (int)$currency->id,
			"customer_scure_key" => $customer->secure_key,
		);
		print_r($array);

		$this->module->validateOrder(18, '1', 100000, 'Pago en línea', NULL, $mailVars, 3, false, '1289052204abe3c7b749756a972deea5');
		
		// $this->module->validateOrder($cart->id, Configuration::get('PS_OS_PAGOENLINEA'), $total, $this->module->displayName, NULL, $mailVars, (int)$currency->id, false, $customer->secure_key);		
		//Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
	}
}

// http://localhost/mirringamirronga/www/index.php?fc=module&module=pagoenlinea&controller=validation&id_lang=4
// http://localhost/mirringamirronga/www/index.php?controller=order-confirmation&id_cart=16&id_module=3&id_order=9&key=1289052204abe3c7b749756a972deea5

/*
Array
(
    [cart_id] => 18
    [PS_OS_PAGOENLINEA] => 10
    [total] => 100000
    [module->displayname] => Pago en línea
    [mailVars] => Array
        (
            [{pagoenlinea_owner}] => field-titularcuenta
            [{pagoenlinea_details}] => field-detalles
            [{pagoenlinea_address}] => field-direccion-sucursal
        )

    [currency_id] => 3
    [customer_scure_key] => 1289052204abe3c7b749756a972deea5
)

*/