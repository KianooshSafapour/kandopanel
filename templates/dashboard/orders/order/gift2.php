<?php
$gift = "";
$variant = "";

if (class_exists('\giftCard\Gift')) {
    $gift = \giftCard\Gift::find($order->service_id);
}

//if(class_exists('\giftCard\giftProduct')){
//    $variant = \giftCard\giftProduct::find_where(['api_variant_id'=>$order->api_service_id]);
//}
if (class_exists('\giftCard\giftVariant')) {
    $variant = \giftCard\giftVariant::find($order->api_service_id);
}
$serials = get_order_meta($order->id, 'serials', true);
$serials = unserialize($serials);
$serials = is_array($serials) ? $serials : [];
?>
<ul class="order-details">
    <?php if (!empty($gift)): ?>
        <li>گیفت کارت: <?php echo esc_attr($gift->id) ?>&nbsp;-&nbsp;<?php echo esc_attr($gift->name) ?></li>
    <?php endif; ?>
    <?php if (!empty($variant)): ?>
        <li>نوع گیفت کارت: &nbsp;<?php echo esc_attr($variant->title) ?></li>
    <?php endif; ?>
    <li>تعداد: <?php echo esc_attr($order->quantity) ?></li>
    <li>
        مبلغ: <?php echo number_format_i18n(esc_attr((int)$order->charge)) ?> <?php kando_get_currency_base_text() ?></li>
    <?php if (samyar_is_admin()): ?>
        <li>(<span style="color:#f58">هزینه</span>/<span style="color:#3ca235">سود</span>): (<span
                    style="color:#3ca235"><?php echo number_format_i18n(esc_attr((int)$order->profit)) ?></span>/<span
                    style="color:#f58"><?php echo number_format_i18n(esc_attr((int)$order->formal_charge)) ?></span>) <?php kando_get_currency_base_text() ?>
        </li>
    <?php endif; ?>
    <?php if ($order->user_note && samyar_is_admin()): ?>
        <li>پیام کاربر:
            <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                    data-tooltip="برای مشاهده پیام کاربر کلیک کنید" data-type="order"
                    data-info="user-note" data-order="<?= $order->id ?>">کلیک کنید
            </button>
        </li>
    <?php endif; ?>

    <?php

    if (count($serials) > 1) { ?>
        <li>جزییات سفارش:
            <button class="button button-orange kt-ajax-button gift_cards_csv" data-order="<?= $order->id ?>">دانلود
                فایل CSV
            </button>
        </li>
    <?php } else {
        ?>
        <li>جزییات سفارش:
            <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                    data-tooltip="برای جزییات سفارش کلیک کنید" data-type="gift_cards"
                    data-info="gift-cards" data-order="<?= $order->id ?>">کلیک کنید
            </button>
        </li>
        <?php
    } ?>
</ul>