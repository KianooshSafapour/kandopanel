<?php

use kandoNumber\numberOrder;
use samyar\logController;
use samyar\Number2Word;
use samyar\Order;
use samyar\Payment;
use samyar\paymentController;
use samyar\Service;
use samyar\smsController;
use samyar\walletController;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!isset($_REQUEST['payment_id']) || empty($_REQUEST['payment_id'])) {
    wp_redirect(home_url());
}
$options = settingsController::getInstance();
$payment = false;
$result = [
    'success' => false,
    'data' => "درگاه فعالی وجود ندارد"
];

switch ($_REQUEST['gateway']) {
    case 'bitpay':
        $bitpay = \samyar_bitpay::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $bitpay->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'idpay':
        $idpay = \samyar_idpay::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $idpay->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'payir':
        $payir = \samyar_payir::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $payir->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'zarinpal':
        $zarinpal = \samyar_zarinpal::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $zarinpal->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'zibal':
        $zibal = \samyar_zibal::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $zibal->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'nextpay':
        $nextpay = \samyar_nextpay::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $nextpay->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'mrpardakht':
        $mrpardakht = \samyar_mrpardakht::get_instance();
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        $result = $mrpardakht->back($payment->amount, $_REQUEST);
        $pay = new paymentController();
        $result = $pay->final_proccess_payment($result, $payment);
        break;
    case 'wallet':
        $payment_id = (int)$_REQUEST['payment_id'];
        $payment = Payment::find($payment_id);
        //اگر پرداخت سفارشی بهش ضمیمه بود
        if ($payment->order_id && !is_null($payment->order_id) && $payment->status == 0) {//اگر این پرداخت هنوز تایید نشده بود و همچنین سفارش بهش متصل بود

            if ($payment->order_type === "number") {
                $order = numberOrder::find($payment->order_id);
            } else {
                $order = Order::find($payment->order_id);
            }


            $wallet = walletController::getInstance();


            if (round($wallet->getUserCredit(get_current_user_id())) >= round($order->charge)) {//چک می کنیم ببینیم مبلغ سفارش بیشتر از کیف پول نباشه


                if ($payment->order_type === "number") {
                    $result = apply_filters('kando_number_after_success_order', $order->id, $payment->id);
                } else {
                    $wallet->DecreaseUserCredit(get_current_user_id(), round($order->charge));//کاهش مبلغ سفارش از اعتبار

                    //ذخیره اطلاعات پرداخت
                    //وضعیت پرداخت رو به موفق تغییر بده
                    $payment->update([
                        'status' => 1,
                    ]);

                    $delay_sending_order = $options->get_option('delay-sending-order', 0);
                    if ($delay_sending_order == 1 || $delay_sending_order === "1") {
                        //سفارش با موفقیت تغییر وضعیت داد
                        $order->update([
                            'status' => 'awaiting_cancel',
                        ]);
                    } else {
                        //سفارش با موفقیت تغییر وضعیت داد
                        $order->update([
                            'status' => 'pending',
                        ]);
                    }

                    $result['success'] = true;
                    $result['order_id'] = $order->id;
                    $result['gateway'] = "کیف پول";
                    $result['price'] = round($order->charge);


                    //ارسال پیامک مدیر
                    $options = settingsController::getInstance();
                    $sms = new smsController();
                    $pattern_code = $options->get_option('send-order-to-admin-pattern');
                    if (!empty($pattern_code)) {
                        $check_service = Service::find($order->service_id);
                        $input_data = array("order-id" => $order->id, "service-name" => $check_service->name, "quantity" => $order->quantity, "amount" => number_format_i18n(round($order->charge)));
                        if (get_admins_mobile_number()) {
                            foreach (get_admins_mobile_number() as $number) {
                                $sms->sendSms($number, $pattern_code, $input_data);
                            }
                        }
                    }


//ارسال پیامک به کاربر
                    $pattern_code_order_to_user = $options->get_option('send-order-to-user-pattern');
                    if (!empty($pattern_code_order_to_user)) {
                        $input_data_order_to_user = array("order-id" => $order->id);
                        $mobile = get_user_meta($order->uid, 'mobile', true);
                        $sms->sendSms($mobile, $pattern_code_order_to_user, $input_data_order_to_user);
                    }

                    do_action('kando_after_success_send_order', $order->uid, $order->id, $order->service_id, $order->quantity, number_format_i18n(round($order->charge)));


                }


            }

        }
        break;
}
if (!$payment) {//اگر هیچ پرداختی پیدا نشد به صفحه اصلی ریدایرکت کن
    wp_redirect(home_url());
}
?>
<style>
    .mln {
        margin: 8px 0;
        font-size: 1.2em;
        font-weight: 500;
        border-bottom: 1px solid #f0eeee;
        padding-bottom: 20px;
    }

    /*h2 {*/
    /*    text-align: center;*/
    /*    margin-top: 20px;*/
    /*}*/

    .c-checkout-alert__icon.success {
        /*font-size: 5rem !important;*/
        /*background-color: #d2f3f7;*/
        color: #4ac9dd;
    }

    .c-checkout-alert__icon.failed {
        /*background-color: rgba(251, 52, 73, .18);*/
        color: #ff637d
    }

    .payment-status.success {
        color: #4ac9dd;
    }

    .payment-status.failed {
        color: #ff637d
    }

    .c-checkout-alert__icon {
        margin: 0 auto 6px;
        /*padding: 27px;*/
        /*border-radius: 50%;*/
        width: 138px;
        height: 86px;
    }

    .c-checkout-alert__icon i {
        font-size: 100px;
        line-height: 34px;
        position: relative;
        right: -14px;
    }

    .c-checkout-alert__title h4 {
        color: #737373;
        font-size: 21px;
        line-height: 38px;
        font-weight: 700;
        letter-spacing: -.5px;
        text-align: center;
        margin: 20px 0 10px 0;
    }

    .c-checkout-alert__highlighted--success {
        color: #00bfd6;
        background-color: #ebfdff;
    }

    .c-checkout-alert__highlighted {
        border-radius: 8px;
        padding: 3px 5px 0;
        margin: 0 5px;
    }
</style>

<div class="dashboard-posts-list">
    <div class="kt-row" style="margin-top: 20px;">
        <?php if ($result['success']) {
            $log = new logController();
            $log->add(get_current_user_id(), 'کاربر حساب خود را به مبلغ ' . number_format($result['price']) . ' تومان شارژ کرد', 'charge');
            ?>
            <div class="kt-col-xs-12 kt-col-sm-12">
                <div class="c-checkout-alert__icon success" style="text-align: center">

                    <i class="fal fa-check-circle"></i>
                </div>
                <div class="c-checkout-alert__title">
                    <?php if (is_null($payment->order_id))://اگر کاربر دستی شارژ کرده ?>
                        <h4>
                            فاکتور <span class="c-checkout-alert__highlighted c-checkout-alert__highlighted--success js-checkout_dkc_sn"><?php echo $_REQUEST['payment_id'] ?></span> با
                            موفقیت
                            پرداخت
                            و حساب شما شارژ شد.
                        </h4>
                    <?php endif; ?>

                    <?php if (!is_null($payment->order_id))://اگر برای ثبت سفارش اعتبار رو شارژ کرده ?>
                        <h4>
                            سفارش <span class="c-checkout-alert__highlighted c-checkout-alert__highlighted--success js-checkout_dkc_sn"><?php echo $payment->order_id ?></span> با
                            موفقیت
                            پرداخت
                            و
                            در صف انجام قرار گرفت.
                        </h4>
                    <?php endif; ?>

                    <span style="text-align: center;margin: 10px auto;display: block;">
                        <?php if ($payment->order_type === "number") { ?>
                            <a href="<?= home_url('dashboard/?action=numbers') ?>" style="margin-left: 5px;" class="button button-blue" data-wpel-link="internal">خرید شماره جدید</a>
                            <a href="<?= home_url('dashboard/?action=numbers&section=my-numbers') ?>" class="button button-green" data-wpel-link="internal"> رفتن به شماره های من</a>
                        <?php } else { ?>
                            <a href="<?= home_url('dashboard/?action=orders&section=new') ?>" style="margin-left: 5px;" class="button button-blue" data-wpel-link="internal">ثبت سفارش جدید</a>
                            <a href="<?= home_url('dashboard/?action=orders') ?>" class="button button-green" data-wpel-link="internal"> رفتن به لیست سفارشات</a>
                        <?php } ?>

                    </span>
                </div>
            </div>
        <?php } else { ?>
            <div class="kt-col-xs-12 kt-col-sm-12">
                <div class="c-checkout-alert__icon failed" style="text-align: center">
                    <i class="fal fa-window-close"></i>
                </div>
                <div class="c-checkout-alert__title"><h4>پرداخت شما ناموفق بود</h4></div>
            </div>

        <?php } ?>
        <div class="kt-col-xs-12 kt-col-sm-12" style="margin: auto;">
            <table>
                <tbody>

                <?php if (isset($result['order_id'])) { ?>
                    <tr>
                        <td>
                            شماره سفارش:
                        </td>
                        <td>
                            <?php echo $result['order_id'] ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php if (isset($_REQUEST['payment_id']) && !isset($result['order_id'])) { ?>
                    <tr>
                        <td>
                            شماره فاکتور:
                        </td>
                        <td>
                            <?php echo $_REQUEST['payment_id'] ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php if (isset($result['gateway'])) { ?>
                    <tr>
                        <td>
                            درگاه:
                        </td>
                        <td>
                            <?php echo $result['gateway'] ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php if (isset($result['price'])) { ?>
                    <tr>
                        <td>
                            مبلغ:
                        </td>
                        <td>
                            <?php echo number_format($result['price']) ?> تومان
                        </td>
                    </tr>
                <?php } ?>

                <?php if (isset($result['RefID'])) { ?>
                    <tr>
                        <td>
                            شماره رسید:
                        </td>
                        <td>
                            <?php echo $result['RefID'] ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (isset($result['msg'])) { ?>
                    <tr>
                        <td>
                            شرح خطا:
                        </td>
                        <td>
                            <?php echo $result['msg'] ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if (!$result['success'] && is_user_logged_in() && $payment->order_type !== "number") {
            $payment = Payment::find((int)$_REQUEST['payment_id']);
            $order = Order::find_where(['id' => $payment->order_id, 'uid' => get_current_user_id()]);
            $service = Service::find($order->service_id);
            $quantity = $order->quantity;
            if ($payment->order_id):
                ?>
                <div class="kt-col-xs-12 kt-col-sm-12" style="margin: auto;">

                    <form method="POST" class="samyar-form repayment-form">
                        <input type="hidden" name="action" value="samyar_repayment">
                        <input type="hidden" name="order-id" value="<?= esc_attr($order->id) ?>"/>
                        <input type="hidden" name="service" value="<?= esc_attr($service->id) ?>"/>

                        <div id="order_review" style="margin-top: 40px;">
                            <h3 style="text-align: center">پرداخت مجدد</h3>
                            <table class="shop_table">
                                <?php
                                $basket_html = "";


                                //                    $service = Service::find($service_id);
                                $price = calculate_service_price($service->id);

                                $this_service = Service::find($service->id);

                                if ($this_service->type === "package") {
                                    $total_service = $price;
                                } else {
                                    $total_service = ($price / 1000) * $quantity;
                                }


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
            <td><span class="woocommerce-Price-amount amount">' . number_format_i18n((int)$total_service) . '&nbsp;<span class="woocommerce-Price-currencySymbol">تومان</span></span></td>
        </tr>';
                                if ($data['wallet_payment'] > 0):
                                    $basket_html .= '<tr class="cart-discount">
            <th>کسر از کیف پول</th>
            <td class="align-left" data-title="اعتبار کیف پول">' . number_format_i18n((int)$data['wallet_payment']) . ' تومان</td>
        </tr>';

                                endif;
                                $basket_html .= '<tr class="cart-discount" style="display: none">
            <th>تخفیف سبد خرید</th>
            <td class="align-left" data-title="تخفیف سبد خرید">0 تومان</td>
        </tr>
        <tr class="order-total">
            <th>مبلغ قابل پرداخت</th>
            <td><strong><span class="woocommerce-Price-amount amount">' . number_format_i18n((int)$data['total_payment']) . '&nbsp;<span class="woocommerce-Price-currencySymbol">تومان</span></span></strong></td>
        </tr>';
                                if (round($data['total_payment']) > 0) {
                                    $basket_html .= '<tr><th colspan="2">به حروف: <strong><span class="woocommerce-Price-amount amount">' . $number->numberToWords(round($data['total_payment'])) . '&nbsp;<span class="woocommerce-Price-currencySymbol">تومان</span></span></strong></th></tr>';
                                }
                                $basket_html .= '</tfoot>';
                                echo $basket_html;
                                $gateways = $data['total_payment'] == 0 ? false : true;

                                ?>
                            </table>

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
                                    <button class="button button-green kt-ajax-button alt" id="btn_repayment">پرداخت مجدد</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            <?php
            endif;
        } ?>

    </div>

</div>
