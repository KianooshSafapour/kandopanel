<?php

use samyar\Number2Word;
use samyar\Service;
use samyar\walletController;
use samyar\priceController;

$options = settingsController::getInstance();

// دریافت داده‌های فرم
$service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
$title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
$price = isset($_POST['price']) ? $_POST['price'] : 0;

// یافتن سرویس
$service = $service_id ? Service::find($service_id) : null;

if (!$service) {
    echo __('Service not found.', SAMYAR_TEXT_DOMAIN);
    return;
}

// محاسبه قیمت‌ها با استفاده از priceController::calculatePricesBatch
$user_id = get_current_user_id();
$services = [$service];
$prices = priceController::calculatePricesBatch($services, $user_id);
$service_price = $prices[$service_id]['price'] ?? 0;

// محاسبه قیمت کل
$total_service = ($service_price / 1000) * $quantity;

// محاسبه کیف پول و مبلغ قابل پرداخت
$wallet = walletController::getInstance();
$wallet_data = $wallet->calculate_wallet_payment($total_service);
$total_payment = $wallet_data['total_payment'];

// تبدیل عدد به حروف
$number = new Number2Word();
$total_payment_words = $number->numberToWords(round($total_payment));
$stranslates = \samyar\serviceController::getInstance()->get_translates();
?>

<div class="kt-row kando-package-form">
    <div class="column kt-col-xs-12 kt-col-md-5 pack-right">
        <div class="kt-col-xs-12 kt-col-md-12">
            <div class="dashboard-box dashboard-box-green">
                <a class="dashboard-box-inner" href="#" data-wpel-link="internal">
                    <span class="dashboard-box-text">
                        <span class="woocommerce-Price-amount amount"><?= esc_attr($quantity) ?>&nbsp;</span>
                        <small><?= esc_attr($title) ?></small>
                    </span>
                </a>
            </div>
        </div>
        <div class="kt-col-xs-12 kt-col-md-12" style="margin-top:10px">
            <div class="dashboard-box dashboard-box-profit">
                <a class="dashboard-box-inner" href="#" data-wpel-link="internal">
                    <span class="dashboard-box-text">
                        &lt;<span
                                class="woocommerce-Price-amount amount"><?= priceController::kandoFormatPrice($total_service)['price_for_show_formatted'] ?>&nbsp;</span>
                    </span>
                    <i class="fal fa-money-bill dashboard-box-icon"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="column kt-col-xs-12 kt-col-md-7 pack-left">
        <form method="POST" class="samyar-form new-order-form kando-package-form">
            <?php wp_nonce_field('new_order_nonce', 'new_order_nonce'); ?>
            <input type="hidden" name="action" value="samyar_order_add">
            <input type="hidden" name="cate_id" value="<?= esc_attr($service->cate_id) ?>"/>
            <input type="hidden" name="service" value="<?= esc_attr($service->id) ?>"/>
            <input type="hidden" name="quantity" value="<?= esc_attr($quantity) ?>"/>

            <div id="insert-order-data">
                <div class="order-default-link">
                    <label><?php _e("Link", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" name="link" dir="ltr"
                           placeholder="<?php _e("Enter the link", SAMYAR_TEXT_DOMAIN); ?>"/>
                </div>
                <div class="process-link-result"></div>

                <?php
                // نمایش فیلدهای سفارش بر اساس نوع سرویس
                switch ($service->type) {
                    case "custom_comments":
                        ?>
                        <div class="order-comments">
                            <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                            <textarea rows="10" name="comments"
                                      class="form-control square ajax_custom_comments"></textarea>
                        </div>
                        <?php
                        break;

                    case "custom_comments_package":
                        ?>
                        <div class="order-comments-custom-package">
                            <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                            <textarea rows="10" name="comments_custom_package" class="form-control square"></textarea>
                        </div>
                        <?php
                        break;

                    case "mentions_with_hashtags":
                        ?>
                        <div class="order-usernames">
                            <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input type="text" class="form-control input-tags" dir="ltr" name="usernames"
                                   value="usenameA,usenameB,usenameC,usenameD">
                        </div>
                        <div class="order-hashtags">
                            <label for=""><?php _e("Hashtags (Format: #hashtag)", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input type="text" class="form-control input-tags" name="hashtags"
                                   value="#goodphoto,#love,#nice,#sunny">
                        </div>
                        <?php
                        break;

                    case "mentions_custom_list":
                    case "mentions":
                        ?>
                        <div class="order-usernames-custom">
                            <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                            <textarea rows="10" name="usernames_custom" dir="ltr"
                                      class="form-control square ajax_custom_lists"></textarea>
                        </div>
                        <?php
                        break;

                    case "mentions_hashtag":
                        ?>
                        <div class="order-hashtag">
                            <label for=""><?php _e("Hashtag", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square" type="text" name="hashtag">
                        </div>
                        <?php
                        break;

                    case "comment_likes":
                    case "mentions_user_followers":
                        ?>
                        <div class="order-username">
                            <label for=""><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square" dir="ltr" name="username" type="text">
                        </div>
                        <?php
                        break;

                    case "mentions_media_likers":
                        ?>
                        <div class="order-media">
                            <label for=""><?php _e("Media Url", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square" dir="ltr" name="media_url" type="link">
                        </div>
                        <?php
                        break;

                    case "package":
                        // هیچ فیلد اضافی برای پکیج‌ها نیاز نیست
                        break;
                }
                ?>
            </div>

            <div id="order_review" style="margin-top: 40px;">
                <table class="shop_table">
                    <?php
                    $basket_html = '<thead>
        <tr>
            <th class="product-name">' . __('Product', SAMYAR_TEXT_DOMAIN) . '</th>
            <th class="product-total">' . __('Price', SAMYAR_TEXT_DOMAIN) . '</th>
        </tr>
    </thead>
    <tbody>
        <tr class="cart_item">
            <td class="product-name">
                <span class="product-title">' . esc_attr(\samyar\serviceController::getInstance()->get_title($stranslates, $service)) . '&nbsp;<strong class="product-quantity"> &times; ' . $quantity . '</strong></span>
            </td>
            <td class="product-total">' . priceController::kandoFormatPrice($total_service)['price_for_show_formatted'] . '</td>
        </tr>
    </tbody>
    <tfoot>';

                    if ($wallet_data['wallet_payment'] > 0) {
                        $basket_html .= '<tr class="cart-discount">
            <th>' . __('Deduction from Wallet', SAMYAR_TEXT_DOMAIN) . '</th>
            <td class="align-left">' . priceController::kandoFormatPrice($wallet_data['wallet_payment'])['price_for_show_formatted'] . '</td>
        </tr>';
                    }

                    $basket_html .= '<tr class="order-total">
        <th>' . __('Payable Amount', SAMYAR_TEXT_DOMAIN) . '</th>
        <td><strong>' . priceController::kandoFormatPrice($total_payment)['price_for_show_formatted'] . '</strong></td>
    </tr>';

                    //                    if (round($total_payment) > 0) {
                    //                        $basket_html .= '<tr>
                    //            <th colspan="2">' . __('In Words:', SAMYAR_TEXT_DOMAIN) . ' <strong>' . esc_html($total_payment_words) . ' ' . __('Toman', SAMYAR_TEXT_DOMAIN) . '</strong></th>
                    //        </tr>';
                    //                    }

                    $basket_html .= '</tfoot>';
                    echo $basket_html;
                    ?>
                </table>

                <?php if (!is_user_logged_in()): ?>
                    <?php
                    $enable_otp_order = (bool)kando_get_option('enable-otp-order', 1);
                    if ($enable_otp_order) {
                        ?>
                        <p style="margin-top:20px;color:#AF0000">
                            <?php _e("Note: If you do not want to verify your phone number every time you place an order, simply register on the site and log in to your account.", SAMYAR_TEXT_DOMAIN); ?>
                        </p>
                    <?php } ?>
                    <div class="checkout_coupon" style="margin-top:30px">
                        <p class="form-row form-row-first">
                            <input type="text" name="mobile" dir="ltr" class="input-text"
                                   placeholder="<?php _e("Phone Number", SAMYAR_TEXT_DOMAIN); ?>" id="mobile-number"
                                   value=""/>
                        </p>
                        <?php if ($enable_otp_order) { ?>
                            <p class="form-row form-row-last">
                                <a href="#" class="button button-red kt-ajax-button samyar-verify-send"
                                   style="margin-top:-10px;line-height: 28px;"><?php _e("Send Verification Code", SAMYAR_TEXT_DOMAIN); ?></a>
                            </p>
                            <div class="clear"></div>
                            <p class="form-row form-row-first">
                                <input type="text" name="verify-code" class="input-text"
                                       placeholder="<?php _e("Received Verification Code", SAMYAR_TEXT_DOMAIN); ?>"
                                       id="verify-code" value=""/>
                            </p>
                        <?php } ?>
                    </div>

                <?php endif; ?>

                <?php
                $enable_agree_order = kando_get_option('enable-agree-order', "1");
                $agree_order_text = kando_get_option('samyar-agree-order-text', __("I have read and agree to [term].", SAMYAR_TEXT_DOMAIN));
                $link = kando_get_option('samyar-agree-order-link', "");

                if ($enable_agree_order === "1"):
                    $url = empty($link)
                        ? __("Rules and regulations", SAMYAR_TEXT_DOMAIN)
                        : sprintf('<a class="terms-tag" href="%s" target="_blank">%s</a>', esc_url($link), __("Rules and regulations", SAMYAR_TEXT_DOMAIN));
                    $text = str_replace('[term]', $url, $agree_order_text);
                    ?>
                    <input type="hidden" name="agree" value="0">
                    <input type="checkbox" value="1" id="agree" name="agree">
                    <label style="margin: 20px 0;font-size: 15px;font-weight: bold;" class="publish-notification"
                           for="agree"><?= $text ?></label>
                <?php endif; ?>

                <div id="payment" class="woocommerce-checkout-payment">

                    <?php include(SAMYAR_DIR_TEMPLATE . '/gateways-list/gateways-list.php') ?>

                    <div class="form-row place-order">
                        <button class="button button-green kt-ajax-button alt"
                                id="place_order"><?php _e("Submit Order", SAMYAR_TEXT_DOMAIN); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    jQuery(function ($) {
        var $form = $j('.kando-package-form');
        if (!$form.length) return;

        // kandoSetDefaultGateway($form);
        // kandoToggleCardSelect($form);
        // روش صحیح: تابع را مستقیماً پاس دهید، نه نتیجه آن را
        $(document).on("change", '.kando-package-form #payment_method', function () {
            kandoToggleCardSelect($form);
        });

        $(document).on("change", '.kando-package-form input[name="payment_method"]', function () {
            kandoToggleCardSelect($form);
        });
    });
</script>