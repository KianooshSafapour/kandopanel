<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use kandoNumber\Number;
use kandonumber\numberLand;
use kandoNumber\numberService;
use samyar\Number2Word;
use samyar\walletController;

$options = settingsController::getInstance();
$representations_attr = $options->get_option('representations');
$representations_attr = is_array($representations_attr) ? $representations_attr : [];


if (isset($_GET['package_id']) && !empty($_GET['package_id'])):
    $this_representation = $representations_attr[$_GET['package_id']];

    switch ($_GET['package_id']) {
        case 1:
            $title = "نمایندگی طلایی";
            break;
        case 2:
            $title = "نمایندگی نقره ای";
            break;
        case 3:
            $title = "نمایندگی برنزی";
            break;
    }
endif; ?>

<div class="kt-row">
    <form method="POST" class="samyar-form package-form-order">
        <!--        <h4 style="text-align: center;margin-bottom: 40px" class="new-ticket-title">افزودن سفارش جدید</h4>-->
        <input type="hidden" name="action" value="kando_package_order">
        <input type="hidden" name="package_id" value="<?= $_GET['package_id'] ?>">
        <div class="column kt-col-xs-12 kt-col-md-12 float-left">

            <?php
            $wallet = walletController::getInstance();
            $user_credit = $wallet->getUserCredit(get_current_user_id());
            if (!is_user_logged_in()) {
                $user_credit = 0;
            }

            $total_package = $this_representation['amount'];

            if ($user_credit > 0) {//اگر اعتبار در کیف پول کاربر بزرگتر از صفر بود
                //// چک می کنیم ببینیم آیا کیف پول، پول سرویس رو جواب میده یا نه
                if ($total_package > $user_credit) {//اگر مبلغ سفارش بالاتر از اعتبار کاربر بود

                    $total_payment = $total_package - $user_credit;//مبلغ قابل پرداخت
                    $wallet_payment = $user_credit; //کل کیف پول کاربر کسر میشه

                } else if ($total_package === $user_credit) {//اگر مقدار کیف پول با سرویس مساوی بود

                    $total_payment = 0; //مبلغ قابل پرداخت
                    $wallet_payment = $user_credit;//مبلغی که از کیف پول باید کسر بشه

                } else {//اگر مقدار کیف پول از مقدار سرویس بیشتر بود

                    $wallet_payment = $total_package; //مبلغی که از کیف پول باید کسر بشه
                    $total_payment = 0;//مبلغ قابل پرداخت

                }
            } else {
                $wallet_payment = 0;
                $total_payment = $this_representation['amount'];
            }

            $number2word = new Number2Word();
            ?>
            <div class="kt-row">
                <div class="samyar-form-loading"></div>
                <div id="order_review" class=" column kt-col-xs-12 kt-col-md-12" style="margin-top: 40px;">
                    <table class="shop_table">
                        <thead>
                        <tr>
                            <th class="product-name">محصول</th>
                            <th class="product-total">قیمت</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item">
                            <td class="product-name">
                            <span class="product-title">
							    خرید   <?= $title ?>&nbsp; </span>
                            </td>
                            <td class="product-total">
                                <?= number_format_i18n((int)$this_representation['amount']) ?> <?php kando_get_currency_base_text() ?>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>

                        <?php if ($wallet_payment > 0): ?>
                            <tr class="cart-discount">
                                <th>کسر از کیف پول</th>
                                <td class="align-left" data-title="اعتبار کیف پول"><?= number_format_i18n((int)$wallet_payment) ?> <?php kando_get_currency_base_text() ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr class="cart-subtotal" style="display: none">
                            <th> قیمت کل</th>
                            <td><span class=" amount"><?= number_format_i18n((int)$this_representation['amount']) ?>&nbsp;<span class=""><?php kando_get_currency_base_text() ?></span></span></td>
                        </tr>

                        <tr class="order-total">
                            <th>مبلغ قابل پرداخت</th>
                            <td><strong><span class="amount"><?= number_format_i18n((int)$total_payment) ?>&nbsp;<span class=""><?php kando_get_currency_base_text() ?></span></span></strong></td>
                        </tr>
                        <?php if (round($total_payment) > 0) { ?>
                            <tr>
                                <th colspan="2">به حروف: <strong><span class="woocommerce-Price-amount amount"><?php echo $number2word->numberToWords(round($total_payment)) ?>&nbsp;<span
                                                    class="woocommerce-Price-currencySymbol"><?php kando_get_currency_base_text() ?></span></span></strong></th>
                            </tr>
                        <?php } ?>

                        </tfoot>
                    </table>

                    <div>
                        <textarea style="height: 110px;margin-top: 20px;" name="user_note" class="input-text " id="user_note" placeholder="یادداشت شما برای مدیر(ضروری نیست)"></textarea>
                    </div>
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
                        <?php
                        $gateways = $total_payment == 0 ? false : true;
                        if ($gateways):
                            ?>
                            <ul class="wc_payment_methods payment_methods methods">
                                <?php do_action('samyar_order_payments'); ?>
                            </ul>
                        <?php endif; ?>
                        <div class="form-row place-order">
                            <button class="button button-green kt-ajax-button alt" id="place_order">ثبت سفارش</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>
