<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Order;
use samyar\Provider;
use samyar\Service;

if (kando_user_can('edit_order')) {

    $order_id = $_GET['id'];
    $order = Order::find($order_id);
    if ($order && $order->service_type == "giftcart") {
        include_once('gift-edit.php');
    } else {
        include_once('order-edit.php');
    }

}