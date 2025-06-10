<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


use samyar\Payment;
use samyar\Pmeta;
use samyar\priceController;

?>
<?php if (kando_user_can('show_payment_filter')): ?>

    <div class="tickets-navigation">
        <a href="#" class="button button-blue kando-show-payment-filter" data-wpel-link="internal"><?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?></a>
    </div>

    <div class="kt-row">
        <div class="kt-col-xs-12 kt-col-md-12 float-right" style="margin-top:5px;">
            <form method="POST" class="samyar-form filter-payments-form"  style="display: none">
                <input type="hidden" name="action" value="samyar_filter_payments_form_all">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                        <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                        <select name="filter_type">
                            <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="transaction-id"><?php _e("Transaction id", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="username"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                        <input type="submit" class="button button-green sen" value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                    <div class="column kt-col-xs-6 kt-col-md-3 float-right">
                        <input type="hidden" name="success-status" value="0">
                        <input type="checkbox" value="1" id="success-status" name="success-status">
                        <label style="margin: 20px 0;font-size: 15px;font-weight: bold;" class="publish-notification" for="success-status"><?php _e("Only Successful Ones", SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="column kt-col-xs-6 kt-col-md-3 float-right">
                        <input type="hidden" name="success-add-credit" value="0">
                        <input type="checkbox" value="1" id="success-add-credit" name="success-add-credit">
                        <label style="margin: 20px 0;font-size: 15px;font-weight: bold;" class="publish-notification" for="success-add-credit"><?php _e("Only Deposits", SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<div class="page-options d-flex tabs-wrapper">
    <ul class="list-inline mb-0 order_btn_group nav">
        <li class="list-inline-item nav-select" style="margin-left: -5px;">
            <a class="nav-link <?= (!isset($_GET['section'])) ? 'active' : '' ?>" href="<?= home_url('dashboard/?action=payments') ?>">
                <?php _e('All', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-light badge-error-orders">' . get_count_payments_all('all') . '</span>' ?></a></li>
        <?php
        $gateway_array = array('bitpay', 'zarinpal', 'zibal', 'wallet', 'card_to_card');
        $gateway_array = apply_filters('kando_gateways_list',$gateway_array);
        //		$number_error_orders = get_count_orders('error');
        if (!empty($gateway_array)) {
            foreach ($gateway_array as $row_gateway) {

                switch ($row_gateway) {
                    case 'all':
                        $text = __("All", SAMYAR_TEXT_DOMAIN);
                        $color = "button-light";
                        break;
                    case 'bitpay':
                        $text = __("Bitpay", SAMYAR_TEXT_DOMAIN);
                        $color = "button-red";
                        break;
                    case 'zarinpal':
                        $text = __("Zarinpal", SAMYAR_TEXT_DOMAIN);
                        $color = "button-orange";
                        break;
                    case 'zibal':
                        $text = __("Zibal", SAMYAR_TEXT_DOMAIN);
                        $color = "button-green";
                        break;
                    case 'nextpay':
                        $text = __("Nextpay", SAMYAR_TEXT_DOMAIN);
                        $color = "button-blue";
                        break;
                    case 'mrpardakht':
                        $text = __("Mrpardakht", SAMYAR_TEXT_DOMAIN);
                        $color = "button-blue";
                        break;
                    case 'wallet':
                        $text = __("Wallet", SAMYAR_TEXT_DOMAIN);
                        $color = "button-aqua";
                        break;
                    case 'card_to_card':
                        $text = __("Card to card", SAMYAR_TEXT_DOMAIN);
                        $color = "button-blue";
                        break;
                    default:
                        $result =[];
                        $result = apply_filters('kando_payment_list',$result,$row_gateway);
                        $text = $result['text'];
                        $color = $result['color'];
                        break;
                }
                ?>
                <?php if(get_count_payments($row_gateway)>0): ?>
                <li class="list-inline-item nav-select">
                    <a class="nav-link <?= (isset($_GET['gateway']) && $_GET['gateway'] === $row_gateway) ? 'active' : '' ?>"
                       href="<?= home_url('dashboard/?action=payments&gateway=' . $row_gateway) ?>">
                        <?= $text ?>
                        <?php echo '<span class="button ' . $color . ' badge-error-orders">' . get_count_payments_all($row_gateway) . '</span>'; ?>
                    </a>
                </li>
                <?php endif; ?>
            <?php }
        } ?>
    </ul>
</div>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_creditcard"></i>
        <h5 class="dashboard-posts-title"><?php _e("Payments", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        //		$payments = Payment::all();
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی

        $user_id = get_current_user_id();
        $items_per_page = get_user_meta($user_id, 'items_per_page', true);
        $items_per_page = $items_per_page ?: 30; // مقدار پیش‌فرض 10

        $limit = $items_per_page; //تعداد قابل نمایش


        $offset = ($limit * $paged) - $limit;

        $query = ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset];

        if (kando_is_normal_user()) {
            $query['uid'] = get_current_user_id();
        }

        if (isset($_GET['gateway']) && !empty($_GET['gateway'])) {
            $query['gateway'] = $_GET['gateway'];
        }

        $payments = Payment::where($query);
        if ($payments):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Gateway", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("User information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <!--                    <th><span class="nobr">عملیات ها</span></th>-->
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($payments as $payment):
                    ?>
                    <tr id="order-<?php echo esc_attr($payment->id) ?>">
                        <td data-title="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php if ($payment->status == 1): ?>
                                <?php if ($payment->payment_type == "add-credit"): ?>
                                    <span style="color: #00a699;font-size: 20px;" data-tooltip="<?php _e("Add funds", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-plus"></i></span>
                                <?php elseif ($payment->payment_type == "decrease-credit"): ?>
                                    <span style="color: #e60921;font-size: 20px;" data-tooltip="<?php _e("Decrease credit", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-minus"></i></span>
	                            <?php elseif ($payment->payment_type == "set-credit"): ?>
                                    <span style="color: #00a699;font-size: 20px;" data-tooltip="<?php _e("Set credit", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-credit-card"></i></span>
                                <?php elseif ($payment->payment_type == "order"): ?>
                                    <span style="color: #e60921;font-size: 20px;"><i class="fal fa-minus" data-tooltip="<?php _e("Credit reduction for order", SAMYAR_TEXT_DOMAIN); ?>"></i></span>
                                <?php elseif ($payment->payment_type == "refund"): ?>
                                    <span style="color: #00a699;font-size: 23px" data-tooltip="<?php _e("Refund", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-undo"></i></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($payment->id) ?>
                        </td>
                        <td data-title="<?php _e("Gateway", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php

                            switch ($payment->gateway) {
                                case 'bitpay':
                                    $text = __("Bitpay", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-red";
                                    break;
                                case 'zarinpal':
                                    $text = __("Zarinpal", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-orange";
                                    break;
                                case 'zibal':
                                    $text = __("Zibal", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-green";
                                    break;
                                case 'nextpay':
                                    $text = __("Nextpay", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-blue";
                                    break;
                                case 'mrpardakht':
                                    $text = __("Mrpardakht", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-blue";
                                    break;
                                case 'wallet':
                                    $text = __("Wallet", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-aqua";
                                    break;
                                case 'card_to_card':
                                    $text = __("Card to card", SAMYAR_TEXT_DOMAIN);
                                    $color = "button-blue";
                                    break;
                                default:
                                    $result = [];
                                    $result = apply_filters('kando_payment_list',$result,$payment->gateway);
                                    $text = $result['text'];
                                    $color = $result['color'];
                                    break;
                            }
                            ?>

                            <?php echo '<span class="button ' . $color . ' badge-error-orders">' . $text . '</span>'; ?>


                        </td>
                        <td data-title="<?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo priceController::kandoFormatPrice($payment->amount)['price_for_show_formatted'] ?>
                        </td>
                        <td data-title="<?php _e("User information", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            $user = get_user_by('id', $payment->uid);
                            echo $user->display_name;
                            echo "<br>";
                            echo get_user_meta($user->ID, 'mobile', true);
                            ?>
                        </td>
                        <td data-title="<?php _e("Date", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            $date_format = get_option('date_format');
                            $time_format = get_option('time_format');
                            echo date_i18n($date_format.' '.$time_format, strtotime($payment->created_at))
                            ?>
                        </td>
                        <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($payment->note) ?>
                            <?php if ($payment->order_id && $payment->status === "1" && ($payment->payment_type === "decrease-credit" || $payment->payment_type === "refound")): ?>
                                (<a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($payment->order_id))) ?>"><?php _e("Order", SAMYAR_TEXT_DOMAIN); ?></a>)
                            <?php endif ?>

                            <?php
                            $coupon_code = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'coupon_code']);
                            if ($coupon_code):
                                $original_price = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'original_price']);
                                $price_by_discount = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'price_by_discount']);
                                ?>
                                <span class="button button-green badge-error-orders" style="margin-right: 0;"> <?php _e("Amount charged:", SAMYAR_TEXT_DOMAIN); ?>  <?= number_format_i18n((int)$original_price->meta_value) ?> <?php kando_get_currency_base_text() ?></span><br>
                                <?php _e("discount:", SAMYAR_TEXT_DOMAIN); ?> <?= number_format_i18n((int)$original_price->meta_value - (int)$price_by_discount->meta_value) ?> تومان <br>
                                <?php _e("Amount paid:", SAMYAR_TEXT_DOMAIN); ?> <?= number_format_i18n((int)$price_by_discount->meta_value) ?> تومان <br>
                                <?php _e("Gift code:", SAMYAR_TEXT_DOMAIN); ?> <?= $coupon_code->meta_value ?><br>

                            <?php
                            endif ?>
                            <?php
                            $ref_id = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'ref_id']);
                            if ($ref_id) {
                                ?>
                              <?php _e("Tracking ID:", SAMYAR_TEXT_DOMAIN); ?> <?= $ref_id->meta_value ?><br>
                            <?php }
                            ?>
                        </td>
                        <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            switch ($payment->status) {
                                case 0:
                                    echo "<span style='color: #f58'>"._e("Unsuccessful", SAMYAR_TEXT_DOMAIN)."</span>";
                                    break;
                                case 1:
                                    echo "<span style='color: #7ccc77'>"._e("Successful", SAMYAR_TEXT_DOMAIN)."</span>";
                                    break;
                                case 2:
                                    echo "<span style='color: #7793cc'>"._e("Awaiting confirmation", SAMYAR_TEXT_DOMAIN)."</span>";
                                    break;
                            }
                            ?>
                        </td>
                        <!--                        <td data-title="عملیات ها">-->
                        <!--							--><?php //if ( $payment->status == 0 ):
                        ?>
                        <!--                                <input type="submit" class="button button-green alt" name="woocommerce_checkout_place_order" id="place_order" value="پرداخت" data-value="پرداخت"/>-->
                        <!--							--><?php //endif;
                        ?>
                        <!--                        </td>-->
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table-footer-container">
                <div class="item-right">
                    <label>
                        <select name="kando_select_item_per_page">
                            <option value="10" <?php selected($items_per_page, 10); ?>>10</option>
                            <option value="25" <?php selected($items_per_page, 25); ?>>25</option>
                            <option value="50" <?php selected($items_per_page, 50); ?>>50</option>
                            <option value="100" <?php selected($items_per_page, 100); ?>>100</option>
                        </select>
                    </label>
                </div>
                <div class="item-center">
                    <?php
                    if (isset($_GET['gateway']) && !empty($_GET['gateway'])) {
                        $gateway = $_GET['gateway'];
                    } else {
                        $gateway = 'all';
                    }
                    $total = get_count_payments_all($gateway);
                    samyar_pagination($total, $limit, $paged)
                    ?>
                </div>
            </div>


        <?php
        else:
            ?>
            <span class="payments-notfound"><?php _e("No transaction has been done yet.", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
</div>
