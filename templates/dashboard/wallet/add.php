<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\walletController;

$wallet = walletController::getInstance();
$user_credit = $wallet->getUserCredit(get_current_user_id());

$min_charge_credit = $options->get_option('min-charge-credit', 1000);
$max_charge_credit = $options->get_option('max-charge-credit', 1000000);

$usd_min_charge_credit = $options->get_option('usd-min-charge-credit', 1);
$usd_max_charge_credit = $options->get_option('usd-max-charge-credit', 1000);


$default_gateway = $options->get_option('default-gateway', "zarinpal");
?>
<script>
    /*
    jQuery(document).ready(function ($) {
        if ($('input:radio[name=payment_method]').length > 0) {
            if ($('input:radio[value=<?=$default_gateway?>]').length > 0) {
                $("input:radio[value=<?=$default_gateway?>]").attr('checked', true);
            } else {
                $("input:radio[name=payment_method]:first").attr('checked', true);
            }
        }
    })
    */

    jQuery(document).ready(function($) {
        // گرفتن اولین آیتم و استخراج مقدار data-currency آن

        // بررسی انتخاب شده بودن گزینه
        var selectedOption = $('#payment_method option:selected');

// اگر چیزی انتخاب نشده بود، اولین گزینه را انتخاب کن
        if (!selectedOption.length || !selectedOption.data('currency')) {
            $('#payment_method option:first').prop('selected', true);
            selectedOption = $('#payment_method option:first');
        }


        var firstCurrency = selectedOption.data('currency');

        // قرار دادن مقدار استخراج شده در داخل span
        if (firstCurrency === 'USD') {
            $('#min-max-usd').show();
            $('#min-max-irt').hide();
            $('.input-group-text.currency').text('USD');
        } else {
            $('#min-max-irt').show();
            $('#min-max-usd').hide();
            $('.input-group-text.currency').text('تومان');
        }

        // تغییر مقدار span در صورت تغییر گزینه انتخابی
        $('#payment_method').on('change', function() {
            var selectedCurrency = $(this).find('option:selected').data('currency');

            if (selectedCurrency === 'USD') {
                $('#min-max-usd').show();
                $('#min-max-irt').hide();
                $('.input-group-text.currency').text('USD');
            } else {
                $('#min-max-irt').show();
                $('#min-max-usd').hide();
                $('.input-group-text.currency').text('تومان');
            }
        });
    });


</script>
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
                            <?php printf(__('You already have <strong><span class="%s">%s</span></strong> in your account balance.', SAMYAR_TEXT_DOMAIN), 'woocommerce-Price-amount amount', walletController::getInstance()->getUserCreditByCurrency(get_current_user_id())) ?>
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
                            <input type="hidden" name="action" value="samyar_add_credit">
                            <div class="samyar-form-loading"></div>
                            <!--                            <h3><label for="topup_amount">-->
                            <?php //_e( "add credit", SAMYAR_TEXT_DOMAIN ) ?><!--</label></h3>-->


                            <?php
                            $gateways = kandopanel_gateways_list();
                            usort($gateways, function($a, $b) {
                                return $a['order'] <=> $b['order'];
                            });
                            ?>
                            <select class="form-control mb-3 mt-3" id="payment_method" name="payment_method">

                                <?php foreach ($gateways as $gateway) {
                                    if ($gateway['enable']) {
                                        ?>
                                        <option data-currency="<?= $gateway['currency'] ?>" value="<?= $gateway['gateway'] ?>"><?= $gateway['title'] ?></option>
                                    <?php }
                                } ?>

                            </select>


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
                                <div class="kt-wc-coupon-box"><?php _e("Do you have a discount coupon?", SAMYAR_TEXT_DOMAIN) ?>
                                    <a href="#"
                                       class="showcoupon"><?php _e("for insert discount code click here", SAMYAR_TEXT_DOMAIN) ?></a>
                                </div>

                                <!--                                <div class="kt-wc-coupon-box">کوپن تخفیف دارید؟ <a href="#" class="showcoupon">برای نوشتن کد اینجا کلیک کنید</a></div>-->
                                <div class="checkout_coupon" style="display:none">

                                    <p class="form-row form-row-first">
                                        <input type="text" name="coupon_code" class="input-text"
                                               placeholder="<?php _e("discount code", SAMYAR_TEXT_DOMAIN) ?>"
                                               id="coupon_code" value=""/>
                                    </p>

                                    <p class="form-row form-row-last">
                                        <button class="button button-red apply_coupon kt-ajax-button alt"><?php _e("Checking discount code", SAMYAR_TEXT_DOMAIN) ?></button>
                                    </p>
                                    <div class="alert alert-success apply_coupon_result"
                                         style="display:none;margin-top:10px"></div>
                                    <div class="clear"></div>
                                </div>

                                <?php
                                $options = settingsController::getInstance();
                                $enable_agree_order = $options->get_option('enable-agree-order', "1");
                                $agree_order_text = $options->get_option('samyar-agree-order-text', __("I have read and agree to [term].", SAMYAR_TEXT_DOMAIN));

                                $link = $options->get_option('samyar-agree-order-link', "");
                                if (empty($link)) {
                                    $url = __("Rules and regulations", SAMYAR_TEXT_DOMAIN);
                                } else {
                                    $url = '<a class="terms-tag" href="' . $link . '" target="_blank">' . __("Rules and regulations", SAMYAR_TEXT_DOMAIN) . '</a>';
                                }
                                $text = str_replace('[term]', $url, $agree_order_text);

                                if ($enable_agree_order === "1"):
                                    ?>

                                    <input type="hidden" name="agree" value="0">
                                    <input type="checkbox" value="1" id="agree-order" name="agree">
                                    <label style="margin: 20px 0;font-size: 15px;font-weight: bold;"
                                           class="publish-notification" for="agree-order"><?= $text ?></label>
                                <?php endif; ?>


                            </div>

                            <!--
                            <div id="payment" class="woocommerce-checkout-payment">
                                <ul class="wc_payment_methods payment_methods methods">
                                    <?php do_action('samyar_order_payments'); ?>

                                </ul>
                            </div>
                            -->


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
