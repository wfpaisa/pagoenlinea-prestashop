<?php


include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../init.php');


$cart = new Cart((int)18);
$order = new Order((int)Order::getOrderByCartId($cart->id));

$history = new OrderHistory();
$history->id_order = (int)$order->id;
$history->changeIdOrderState(18, $order, true);
$history->addWithemail(true);

print_r('ok');

// (int)Configuration::get($state),
?>
