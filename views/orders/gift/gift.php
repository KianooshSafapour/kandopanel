<?php

use samyar\priceController;

$gift = "";
$variant = "";
if(class_exists('\giftCard\Gift')){
    $gift = \giftCard\Gift::find($order->service_id);
}
if(class_exists('\giftCard\giftVariant')){
    $variant = \giftCard\giftVariant::find_where(['api_variant_id'=>$order->api_service_id]);
}

$serials = get_order_meta($order->id,'serials',true);
?>
<ul class="order-details">
    <?php if (!empty($gift)): ?>
        <li><?php _e("Gift card:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr($gift->id) ?>&nbsp;-&nbsp;<?php echo esc_attr($gift->name) ?></li>
    <?php endif; ?>
    <?php if (!empty($variant)): ?>
        <li><?php _e("Gift card type:", SAMYAR_TEXT_DOMAIN); ?>&nbsp;<?php echo esc_attr($variant->title) ?></li>
    <?php endif; ?>
    <li><?php _e("Quantity:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr($order->quantity) ?></li>
    <li><?php _e("Amount:", SAMYAR_TEXT_DOMAIN); ?> <?= priceController::kandoFormatPrice($order->charge)['price_for_show_formatted']  ?></li>
    <?php if (kando_user_can('show_order_provider_info')): ?>
        <li>(<span style="color:#f58"><?php _e("Cost", SAMYAR_TEXT_DOMAIN); ?></span>/<span style="color:#3ca235"><?php _e("Profit", SAMYAR_TEXT_DOMAIN); ?></span>): (<span
                    style="color:#3ca235"><?= priceController::kandoFormatPrice($order->profit)['price_for_show_formatted']  ?></span>/<span
                    style="color:#f58"><?= priceController::kandoFormatPrice($order->formal_charge)['price_for_show_formatted']  ?></span>)
        </li>
    <?php endif; ?>
    <?php if ($order->user_note && kando_user_can('show_order_user_info')): ?>
        <li><?php _e("User message:", SAMYAR_TEXT_DOMAIN); ?>
            <button class="button kt-modal-button button-orange kando-show-info" data-modal="info" data-tooltip="<?php _e('Click to view user message', SAMYAR_TEXT_DOMAIN); ?>" data-type="order"
                    data-info="user-note" data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
            </button>
        </li>
    <?php endif; ?>
    <?php if($serials){ ?>
        <li><?php _e("Order details:", SAMYAR_TEXT_DOMAIN); ?>
            <button class="button kt-modal-button button-orange kando-show-info" data-modal="info" data-tooltip="<?php _e('Click for order details', SAMYAR_TEXT_DOMAIN); ?>" data-type="gift_cards"
                    data-info="gift-cards" data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
            </button>
        </li>
    <?php } ?>
</ul>