<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Payment;
use samyar\priceController;

?>
<?php if (kando_user_can('show_payment_filter')): ?>
    <div class="tickets-navigation">
        <a href="<?php echo esc_attr(home_url('dashboard/?action=payments&section=users-payment')) ?>"
           style="float: right;" class="button button-red"
           data-wpel-link="internal"><?php _e("Users Transactions", SAMYAR_TEXT_DOMAIN); ?></a>
    </div>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12 float-right" style="margin-top:5px;">
            <form method="POST" class="samyar-form filter-payments-form">
                <input type="hidden" name="action" value="samyar_filter_payments_form">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                        <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                        <select name="filter_type">
                            <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="transaction-id"><?php _e("Transaction ID", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User Email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                        <input type="submit" class="button button-green sen"
                               value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                </div>
            </form>
        </div>
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


            $payments = Payment::where(['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset]);
            if ($payments):
                ?>

                <table class="shop_table shop_table_responsive">
                    <thead>
                    <tr>
                        <th><span class="nobr"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Gateway", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Payment Amount", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("User Information", SAMYAR_TEXT_DOMAIN); ?></span></th>
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
                                        <span style="color: #00a699;font-size: 20px;"><i class="fal fa-plus"></i></span>
                                    <?php elseif ($payment->payment_type == "decrease-credit"): ?>
                                        <span style="color: #e60921;font-size: 20px;"><i
                                                    class="fal fa-minus"></i></span>
                                    <?php elseif ($payment->payment_type == "set-credit"): ?>
                                        <span style="color: #00a699;font-size: 20px;"
                                              data-tooltip="<?php _e("Set Credit", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                    class="fal fa-credit-card"></i></span>
                                    <?php elseif ($payment->payment_type == "order"): ?>
                                        <span style="color: #e60921;font-size: 20px;"><i
                                                    class="fal fa-minus"></i></span>
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
                                        $text = __('Bitpay', SAMYAR_TEXT_DOMAIN);
                                        $color = "button-red";
                                        break;
                                    case 'zarinpal':
                                        $text = __('Zarinpal', SAMYAR_TEXT_DOMAIN);
                                        $color = "button-orange";
                                        break;
                                    case 'zibal':
                                        $text = __('Zibal', SAMYAR_TEXT_DOMAIN);
                                        $color = "button-green";
                                        break;
                                    case 'nextpay':
                                        $text = __('Nextpay', SAMYAR_TEXT_DOMAIN);
                                        $color = "button-blue";
                                        break;
                                    case 'mrpardakht':
                                        $text = __('MrPardakht', SAMYAR_TEXT_DOMAIN);
                                        $color = "button-blue";
                                        break;
                                    case 'wallet':
                                        $text = __('Wallet', SAMYAR_TEXT_DOMAIN);
                                        $color = "button-aqua";
                                        break;
                                    case 'card_to_card':
                                        $text = __("Card to Card", SAMYAR_TEXT_DOMAIN);
                                        $color = "button-blue";
                                        break;
                                    default:
                                        $result = [];
                                        $result = apply_filters('kando_payment_list', $result, $payment->gateway);
                                        $text = $result['text'];
                                        $color = $result['color'];
                                        break;
                                }
                                ?>

                                <?php echo '<span class="button ' . $color . ' badge-error-orders">' . $text . '</span>'; ?>
                            </td>
                            <td data-title="<?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?>">
                                <?php
                                if ($payment->amount):
                                    echo priceController::kandoFormatPrice($payment->amount)['price_for_show_formatted'];
                                endif;
                                ?>
                            </td>
                            <td data-title="<?php _e("User Information", SAMYAR_TEXT_DOMAIN); ?>">
                                <?php
                                $user = get_user_by('id', $payment->uid);
                                echo $user->display_name;
                                echo "<br>";
                                echo get_user_meta($user->ID, 'mobile', true);
                                ?>
                            </td>
                            <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
                                <?php echo esc_attr($payment->note) ?>
                            </td>
                            <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
                                <?php
                                switch ($payment->status) {
                                    case 0:
                                        echo "<span style='color: #f58'>" . __("Unsuccessful", SAMYAR_TEXT_DOMAIN) . "</span>";
                                        break;
                                    case 1:
                                        echo "<span style='color: #7ccc77'>" . __("Successful", SAMYAR_TEXT_DOMAIN) . "</span>";
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
                                <option value="10" <?php selected($items_per_page, 10); ?>><?php _e("10", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="25" <?php selected($items_per_page, 25); ?>><?php _e("25", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="50" <?php selected($items_per_page, 50); ?>><?php _e("50", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="100" <?php selected($items_per_page, 100); ?>><?php _e("100", SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>
                        </label>
                    </div>
                    <div class="item-center">
                        <?php
                        $total = Payment::count();
                        samyar_pagination($total, $limit, $paged)
                        ?>
                    </div>
                </div>


            <?php
            else:
                ?>
                <span class="payments-notfound"><?php _e("No transactions have been made so far.", SAMYAR_TEXT_DOMAIN); ?></span>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php endif; ?>