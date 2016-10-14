<?php


include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../init.php');

// El Id del estado a cambiar
// este lo podemos ver desde el administrador: Pedidos/Estados
$estado_aceptado = 2;
// Id del carrito este se puede enviar por parametro para que sea retornado
$id_carrito=  $_POST['id_carrito'];

$cart = new Cart((int)$id_carrito);
$order = new Order((int)Order::getOrderByCartId($cart->id));

$history = new OrderHistory();
$history->id_order = (int)$order->id;
$history->changeIdOrderState($estado_aceptado, $order, true);
$history->addWithemail(true);

print_r('ok');

?>
