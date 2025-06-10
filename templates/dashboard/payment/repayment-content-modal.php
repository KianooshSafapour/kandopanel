<?php

use samyar\Number2Word;
use samyar\Order;
use samyar\Service;
use samyar\walletController;


if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
    $order = Order::find_where(['id'=>$_POST['order_id'],'uid'=>get_current_user_id()]);
    if(!$order){
        echo "سفارش وجود ندارد";
        wp_die();
    }else{
        $service = Service::find($order->service_id);
        $quantity = $order->quantity;
    }

}else{
    echo "شناسه سفارش وجود ندارد";
    wp_die();
}



?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <form method="POST" class="samyar-form repayment-form">
            <input type="hidden" name="action" value="samyar_repayment">
            <input type="hidden" name="order-id" value="<?= esc_attr($order->id) ?>"/>
            <input type="hidden" name="service" value="<?= esc_attr($service->id) ?>"/>

            <div id="order_review" style="margin-top: 40px;">
                <table class="shop_table">
                    <?php
                    $basket_html = "";



//                    $service = Service::find($service_id);
                    $price = calculate_service_price($service->id);
                    $total_service = ($price / 1000) * $quantity;


                    //گرفتن اعتبار کیف پول
                    $wallet =  walletController::getInstance();
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
				' . number_format_i18n((int)$total_service) . ' '.kando_get_currency_base_text(false).'
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
            <td class="align-left" data-title="تخفیف سبد خرید">0 '.kando_get_currency_base_text(false).'</td>
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
                    $gateways = $data['total_payment'] == 0 ? false : false;

                    ?>
                </table>

                <?php
                $default_gateway = kando_get_option('default-gateway', "zarinpal");
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
                        <button class="button button-green kt-ajax-button alt" id="btn_repayment" >پرداخت</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>