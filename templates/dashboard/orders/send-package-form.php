<?php

use samyar\Number2Word;
use samyar\Service;
use samyar\walletController;

$options = settingsController::getInstance();
if (isset($_POST['service_id']) && !empty($_POST['service_id'])) {
    $service = Service::find($_POST['service_id']);
}
if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
    $quantity = $_POST['quantity'];
}

if (isset($_POST['title']) && !empty($_POST['title'])) {
    $title = $_POST['title'];
}

if (isset($_POST['price']) && !empty($_POST['price'])) {
    $price = $_POST['price'];
}
//var_dump($service->type);

?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 pack-right">
        <div class=" kt-col-xs-12 kt-col-md-12">

            <div class="dashboard-box dashboard-box-green">
                <a class="dashboard-box-inner" href="#" data-wpel-link="internal">
				<span class="dashboard-box-text">
                    <span class="woocommerce-Price-amount amount"><?= esc_attr($quantity) ?>&nbsp;</span><small><?= esc_attr($title) ?></small>
                </span>


                </a>
            </div>
        </div>
        <div class=" kt-col-xs-12 kt-col-md-12" style="margin-top:10px">
            <div class="dashboard-box dashboard-box-profit">
                <a class="dashboard-box-inner" href="#" data-wpel-link="internal">
                <span class="dashboard-box-text">
                    &lt;<span class="woocommerce-Price-amount amount"><?php echo number_format_i18n(esc_attr((int)$price)) ?>&nbsp;</span><small>تومان</small>
                </span>

                    <i class="fal fa-money-bill dashboard-box-icon"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="column kt-col-xs-12 kt-col-md-7 pack-left">
        <form method="POST" class="samyar-form new-order-form">
            <?php wp_nonce_field('new_order_nonce', 'new_order_nonce'); ?>
            <input type="hidden" name="action" value="samyar_order_add">
            <input type="hidden" name="cate_id" value="<?= esc_attr($service->cate_id) ?>"/>
            <input type="hidden" name="service" value="<?= esc_attr($service->id) ?>"/>
            <input type="hidden" name="quantity" value="<?= esc_attr($quantity) ?>"/>

            <div id="insert-order-data">
                <div class="order-default-link">
                    <label>لینک</label>
                    <input type="text" name="link" dir="ltr" placeholder="لینک را وارد کنید"/>
                    <?php
                    $enable_process_link = $options->get_option('enable-process-link', "1");
                    ?>
                    <?php if ($enable_process_link == 1 || $enable_process_link === "1"): ?>
<!--                        <button class="button button-green kt-ajax-button alt process-link" id="process-link">بررسی لینک</button>-->
                    <?php endif; ?>
                </div>
                <div class="process-link-result"></div>
                <?php
                switch ($service->type) {

                    case "custom_comments":
                        ?>
                        <div class="order-comments">
                            <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                            <textarea rows="10" name="comments" class="form-control square ajax_custom_comments"></textarea>
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
                            <input type="text" class="form-control input-tags" dir="ltr" name="usernames" value="usenameA,usenameB,usenameC,usenameD">
                        </div>
                        <div class="order-hashtags">
                            <label for=""><?php _e("Hashtags (Format: #hashtag)", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input type="text" class="form-control input-tags" name="hashtags" value="#goodphoto,#love,#nice,#sunny">
                        </div>
                        <?php
                        break;

                    case "mentions_custom_list":
                    case "mentions":
                        ?>
                        <div class="order-usernames-custom">
                            <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                            <textarea rows="10" name="usernames_custom" dir="ltr" class="form-control square ajax_custom_lists"></textarea>
                        </div>
                        <?php


                        break;

                    case "mentions_hashtag":
                        ?>
                        <div class="order-hashtag">
                            <label for=""><?php _e("Hashtag", SAMYAR_TEXT_DOMAIN) ?> </label>
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
                        <!-- Mentions Media Likers -->
                        <div class="order-media">
                            <label for=""><?php _e("Media Url", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square" dir="ltr" name="media_url" type="link">
                        </div>
                        <?php


                        break;

                    case "package":


                        break;


                }

                ?>

            </div>
            <div id="order_review" style="margin-top: 40px;">
                <table class="shop_table">
                    <?php
                    $basket_html = "";

                    $service_id = esc_attr($_POST['service_id']);
                    $quantity = esc_attr($_POST['quantity']);

                    $service = Service::find($service_id);
                    $price = calculate_service_price($service->id);
                    $total_service = ($price / 1000) * $quantity;


                    //گرفتن اعتبار کیف پول
                    $wallet = new walletController();
                    $data = $wallet->calculate_wallet_payment($total_service);
                    $number = new Number2Word();
                    $basket_html .= '<thead>
        <tr>
            <th class="product-name">محصول</th>
            <th class="product-total">قیمت</th>
        </tr>
        </thead>
        <tbody>
        <tr class="cart_item">
            <td class="product-name">
                            <span class="product-title">' . esc_attr($service->name) . '&nbsp;<strong class="product-quantity"> &times; ' . $quantity . '</strong>							                                </span>
            </td>
            <td class="product-total">
                <!--                                <span class="sale-price">1,500,000 تومان</span>-->
				' . number_format_i18n((int)$total_service) . ' تومان
            </td>
        </tr>
        </tbody>
        <tfoot>

        <tr class="cart-subtotal" style="display: none">
            <th> قیمت کل</th>
            <td><span class="woocommerce-Price-amount amount">' . number_format_i18n((int)$total_service) . '&nbsp;<span class="woocommerce-Price-currencySymbol">'.kando_get_currency_base_text(false).'</span></span></td>
        </tr>';
                    if ($data['wallet_payment'] > 0):
                        $basket_html .= '<tr class="cart-discount">
            <th>کسر از کیف پول</th>
            <td class="align-left" data-title="اعتبار کیف پول">' . number_format_i18n((int)$data['wallet_payment']) . ' '.kando_get_currency_base_text(false).'</td>
        </tr>';

                    endif;
                    $basket_html .= '<tr class="cart-discount" style="display: none">
            <th>تخفیف سبد خرید</th>
            <td class="align-left" data-title="تخفیف سبد خرید">0 تومان</td>
        </tr>
        <tr class="order-total">
            <th>مبلغ قابل پرداخت</th>
            <td><strong><span class="woocommerce-Price-amount amount">' . number_format_i18n((int)$data['total_payment']) . '&nbsp;<span class="woocommerce-Price-currencySymbol">'.kando_get_currency_base_text(false).'</span></span></strong></td>
        </tr>';
                    if (round($data['total_payment']) > 0) {
                        $basket_html .= '<tr><th colspan="2">به حروف: <strong><span class="woocommerce-Price-amount amount">' . $number->numberToWords(round($data['total_payment'])) . '&nbsp;<span class="woocommerce-Price-currencySymbol">'.kando_get_currency_base_text(false).'</span></span></strong></th></tr>';
                    }
                    $basket_html .= '</tfoot>';
                    echo $basket_html;
                    $gateways = $data['total_payment'] == 0 ? false : true;

                    ?>
                </table>

                <?php if (!is_user_logged_in()): ?>
                    <?php

                    //اگر مدیر در تنظیمات گفته که نیازی به تایید موبایل نیست
                    $enable_otp_order = $options->get_option('enable-otp-order', 1);
                    ?>
                    <?php if ($enable_otp_order === "1" || $enable_otp_order) {// اگر تایید شماره همراه فعال هست ?>
                        <p style="margin-top:20px;color:#AF0000">توجه: اگر می خواهید برای هر بار ارسال سفارش، نیاز به تایید شماره همراه نداشته باشید کافی است در سایت ثبت نام و وارد حساب کاربری خود
                            شوید.</p>
                    <?php } ?>
                    <div class="checkout_coupon" style="margin-top:30px">

                        <p class="form-row form-row-first">
                            <input type="text" name="mobile" dir="ltr" class="input-text" placeholder="شماره همراه" id="mobile-number" value=""/>
                        </p>
                        <?php if ($enable_otp_order === "1" || $enable_otp_order) {// اگر تایید شماره همراه فعال هست ?>
                            <p class="form-row form-row-last">
                                <a href="#" class="button button-red kt-ajax-button samyar-verify-send" style="margin-top:-10px;line-height: 28px;">ارسال کد تایید</a>
                            </p>

                            <div class="clear"></div>
                            <p class="form-row form-row-first">
                                <input type="text" name="verify-code" class="input-text" placeholder="کد تایید دریافتی" id="verify-code" value=""/>
                            </p>
                        <?php } ?>
                    </div>
                <?php endif; ?>
                <?php
                $options = settingsController::getInstance();
                $enable_agree_order = $options->get_option('enable-agree-order', "1");
                $agree_order_text = $options->get_option('samyar-agree-order-text', __( "I have read and agree to [term].", SAMYAR_TEXT_DOMAIN ));

                $link = $options->get_option('samyar-agree-order-link', "");
                if (empty($link)) {
                    $url = __( "Rules and regulations", SAMYAR_TEXT_DOMAIN );
                } else {
                    $url = '<a href="' . $link . '" target="_blank">'.__("Rules and regulations", SAMYAR_TEXT_DOMAIN).'</a>';
                }
                $text = str_replace('[term]', $url, $agree_order_text);

                if ($enable_agree_order === "1"):
                    ?>

                    <input type="hidden" name="agree" value="0">
                    <input type="checkbox" value="1" id="agree" name="agree">
                    <label style="margin: 20px 0;font-size: 15px;font-weight: bold;" class="publish-notification" for="agree"><?= $text ?></label>
                <?php endif; ?>
                <?php
                $default_gateway = $options->get_option('default-gateway', "zarinpal");
                ?>
                <script>
                    jQuery(document).ready(function ($) {
                        if ($('input:radio[name=payment_method]').length > 0) {
                            if ($('input:radio[value=<?=$default_gateway?>]').length > 0) {
                                $("input:radio[value=<?=$default_gateway?>]").attr('checked', true);
                            }else{
                                $("input:radio[name=payment_method]:first").attr('checked', true);
                            }
                        }
                    })
                </script>

                <div id="payment" class="woocommerce-checkout-payment">
                    <?php if ($gateways): ?>
                        <ul class="wc_payment_methods payment_methods methods">
                            <?php do_action('samyar_order_payments'); ?>
                        </ul>
                    <?php endif; ?>
                    <div class="form-row place-order">
                        <button class="button button-green kt-ajax-button alt" id="place_order">ثبت سفارش</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>