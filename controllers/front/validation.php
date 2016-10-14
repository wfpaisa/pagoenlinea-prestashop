<?php

/**
 * @since 1.5.0
 */
class PagoenlineaValidationModuleFrontController extends ModuleFrontController
{
	/**
	 * @see FrontController::postProcess()
	 */
	public function postProcess()
	{

		// El Id del estado a comprobar
		// este lo podemos ver desde el administrador: Pedidos/Estados
		$estado_pendiente = 15;
		
		$cart = $this->context->cart;
		if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
			Tools::redirect('index.php?controller=order&step=1');

		// Compruebe que esta opción de pago está disponible en caso de que el cliente cambia su dirección justo antes del final del proceso de compra
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


		// Guarda el estado de la orden
		$this->module->validateOrder($cart->id, $estado_pendiente, $total, $this->module->displayName, NULL, $mailVars, (int)$currency->id, false, $customer->secure_key);		

		// Redirige al usuario mostrando `themes/default-bootstrap/order-confirmation.tpl` y dentro pagoenlinea.php->hookPaymentReturn->`/views/templates/hook/payment_return.tpl`.
		Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
	}
}
