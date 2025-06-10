<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\walletController;

$wallet = walletController::getInstance();
$user_credit = $wallet->getUserCredit(get_current_user_id())['price'];

$min_charge_credit = kando_get_option('min-charge-credit', 1000);
$max_charge_credit = kando_get_option('max-charge-credit', 1000000);

$usd_min_charge_credit = kando_get_option('usd-min-charge-credit', 1);
$usd_max_charge_credit = kando_get_option('usd-max-charge-credit', 1000);


//$default_gateway = kando_get_option('default-gateway', "zarinpal");
?>

<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <?php kando_show_alerts('credit'); ?>
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="fal fa-coin"></i>
                <h5 class="dashboard-posts-title"><?php _e("Add balance", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row">
                    <div class="column kt-col-xs-12 kt-col-md-3"></div>
                    <div class="column kt-col-xs-12 kt-col-md-6 woocommerce-MyAccount-account-funds">
                        <p>
                            <?php printf(__('You already have <strong><span class="%s">%s</span></strong> in your account balance.', SAMYAR_TEXT_DOMAIN), 'woocommerce-Price-amount amount', walletController::getInstance()->getUserCredit(get_current_user_id())['price_for_show_formatted']) ?>
                        </p>
                        <div id="min-max-irt" style="display: none">
                            <span class="kando-min-payment"><?php _e("minimum payment:", SAMYAR_TEXT_DOMAIN) ?> <b><?= $min_charge_credit ?></b> تومان</span><br>
                            <span class="kando-max-payment"><?php _e("maximum payment:", SAMYAR_TEXT_DOMAIN) ?> <b><?= $max_charge_credit ?></b> تومان</span>
                        </div>

                        <div id="min-max-usd" style="display: none">
                            <span class="kando-min-payment"><?php _e("minimum payment:", SAMYAR_TEXT_DOMAIN) ?> <b><?= $usd_min_charge_credit ?></b> USD</span><br>
                            <span class="kando-max-payment"><?php _e("maximum payment:", SAMYAR_TEXT_DOMAIN) ?> <b><?= $usd_max_charge_credit ?></b> USD</span>
                        </div>

                        <span class="kando-rate-payment"></span>
                        <form method="post" class="clearfix samyar-add-credit">
                            <?php wp_nonce_field('add_credit_nonce', 'add_credit_nonce_field'); ?>
                            <input type="hidden" name="action" value="samyar_add_credit">
                            <div class="samyar-form-loading"></div>
                            <!--                            <h3><label for="topup_amount">-->
                            <?php //_e( "Add funds", SAMYAR_TEXT_DOMAIN ) ?><!--</label></h3>-->

                            <?php include (SAMYAR_DIR_TEMPLATE.'/gateways-list/gateways-list.php') ?>


                            <h4 class="mt-3"><label for="topup_amount"><?php _e( "Amount:", SAMYAR_TEXT_DOMAIN ) ?></label></h4>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency">تومان</span>
                                </div>
                                <input type="number" class="form-control" dir="ltr" id="topup_amount" name="topup_amount">

                            </div>


                            <!--
                            <input type="number" class="input-text" name="topup_amount" id="topup_amount" value="" min="<?= esc_attr($min_charge_credit) ?>" max="<?= esc_attr($max_charge_credit) ?>">
                           -->


                            <div class="kt-col-xs-12">
                                <div class="kt-wc-coupon-box"><?php _e("Do you have a gift code?", SAMYAR_TEXT_DOMAIN) ?>
                                    <a href="#"
                                       class="showcoupon"><?php _e("for insert gift code click here", SAMYAR_TEXT_DOMAIN) ?></a>
                                </div>

                                <!--                                <div class="kt-wc-coupon-box">کوپن تخفیف دارید؟ <a href="#" class="showcoupon">برای نوشتن کد اینجا کلیک کنید</a></div>-->
                                <div class="checkout_coupon" style="display:none">

                                    <p class="form-row form-row-first">
                                        <input type="text" name="coupon_code" class="input-text"
                                               placeholder="<?php _e("Gift code", SAMYAR_TEXT_DOMAIN) ?>"
                                               id="coupon_code" value=""/>
                                    </p>

                                    <p class="form-row form-row-last">
                                        <button class="button button-red apply_coupon kt-ajax-button alt"><?php _e("Checking Gift code", SAMYAR_TEXT_DOMAIN) ?></button>
                                    </p>
                                    <div class="alert alert-success apply_coupon_result"
                                         style="display:none;margin-top:10px"></div>
                                    <div class="clear"></div>
                                </div>

                                <?php
                                $enable_agree_order = kando_get_option('enable-agree-order', "1");
                                $agree_order_text = kando_get_option('samyar-agree-order-text', __("I have read and agree to [term].", SAMYAR_TEXT_DOMAIN));
                                $link = kando_get_option('samyar-agree-order-link', "");

                                // تعیین URL بر اساس وجود یا عدم وجود لینک
                                $url = empty($link)
                                    ? __("Rules and regulations", SAMYAR_TEXT_DOMAIN)
                                    : sprintf(
                                        '<a class="terms-tag" href="%s" target="_blank">%s</a>',
                                        esc_url($link),
                                        __("Rules and regulations", SAMYAR_TEXT_DOMAIN)
                                    );

                                // جایگزینی [term] با URL
                                $text = str_replace('[term]', $url, $agree_order_text);

                                if ($enable_agree_order === "1"):
                                    ?>

                                    <input type="hidden" name="agree" value="0">
                                    <input type="checkbox" value="1" id="agree-order" name="agree">
                                    <label style="margin: 20px 0;font-size: 15px;font-weight: bold;"
                                           class="publish-notification" for="agree-order"><?= $text ?></label>
                                <?php endif; ?>


                            </div>




                            <div class="form-row place-order" style="clear: both;text-align: center;margin-top: 20px">
                                <input type="submit" class="button button-green alt" style="float: inherit"
                                       id="place_order" value="<?php _e("Add balance", SAMYAR_TEXT_DOMAIN); ?>"
                                       data-value="<?php _e("Add balance", SAMYAR_TEXT_DOMAIN); ?>"/>
                            </div>
                            <!-- @TODO حتما یک کد اعتبار سنجی اضافه بشه -->

                        </form>
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        jQuery(function($) {
            var $form = $j('.samyar-add-credit');
            if (!$form.length) return;

            kandoSetDefaultGateway($form);
            kandoToggleCardSelect($form);
            // روش صحیح: تابع را مستقیماً پاس دهید، نه نتیجه آن را
            $(document).on("change", '.samyar-add-credit #payment_method', function() {
                kandoToggleCardSelect($form);
            });

            $(document).on("change", '.samyar-add-credit input[name="payment_method"]', function() {
                kandoToggleCardSelect($form);
            });



            // تابع برای بررسی و تغییر ارز
            function updateCurrency() {
                var selectedCurrency;

                // بررسی اینکه کدام استایل استفاده شده است
                if ($('#payment_method').length > 0) { // استایل select
                    var selectedOption = $('#payment_method option:selected');
                    if (!selectedOption.length || !selectedOption.data('currency')) {
                        $('#payment_method option:first').prop('selected', true);
                        selectedOption = $('#payment_method option:first');
                    }
                    selectedCurrency = selectedOption.data('currency');
                } else { // استایل radio buttons
                    var selectedRadio = $('input[name="payment_method"]:checked');
                    if (!selectedRadio.length || !selectedRadio.data('currency')) {
                        $('input[name="payment_method"]').first().prop('checked', true);
                        selectedRadio = $('input[name="payment_method"]:checked');
                    }
                    selectedCurrency = selectedRadio.data('currency');
                }

                // تغییر نمایش بر اساس ارز انتخاب شده
                if (selectedCurrency === 'USD') {
                    $('#min-max-usd').show();
                    $('#min-max-irt').hide();
                    $('.input-group-text.currency').text('USD');
                } else {
                    $('#min-max-irt').show();
                    $('#min-max-usd').hide();
                    $('.input-group-text.currency').text('تومان');
                }
            }

            // اجرای اولیه
            updateCurrency();

            // رویداد تغییر برای استایل select
            $('#payment_method').on('change', updateCurrency);

            // رویداد تغییر برای استایل radio buttons
            $('input[name="payment_method"]').on('change', updateCurrency);


        });
    </script>
<?php include(SAMYAR_DIR_TEMPLATE.'/dashboard/payment/payments.php') ?>