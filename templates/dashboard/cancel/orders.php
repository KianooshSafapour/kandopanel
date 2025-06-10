<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Cancel;
use samyar\Order;
use samyar\orderController;
use samyar\Provider;
use samyar\Refill;
use samyar\Service;

$title =  __('your cancel orders', SAMYAR_TEXT_DOMAIN);
?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('cancel '); ?>
    </div>
</div>

<div class="tickets-navigation">
    <a href="#" class="button button-blue kando-show-cancel-order-filter" data-wpel-link="internal"><?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?></a>
</div>

<div class="kt-row">
    <div class="kt-col-xs-12 kt-col-md-12 float-right">
        <form method="POST" class="samyar-form filter-cancel-orders-form" style="display: none">
            <input type="hidden" name="action" value="samyar_filter_cancel_orders_form">
            <div class="new-api-provider-form-errors"></div>
            <div class="samyar-form-loading"></div>
            <div class="clearfix">
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <select name="filter_type">
                        <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="id"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php if (kando_user_can('show_order_user_info')): ?>
                            <option value="api-order-id"><?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="api-provider-id"><?php _e("Provider id", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="service-id"><?php _e("Service id", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="username"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                    <input type="submit" class="button button-green sen" value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="page-options d-flex tabs-wrapper">
    <ul class="list-inline mb-0 order_btn_group nav">
        <li class="list-inline-item nav-select" style="margin-left: -5px;">
            <a class="nav-link <?= (!isset($_GET['section'])) ? 'active' : '' ?>" href="<?= home_url('dashboard/?action=cancel') ?>">
                <i class="far fa-list-ul" style="margin-right:5px;"></i><?php _e('All', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-light badge-error-orders">' . get_count_cancel_orders('all') . '</span>' ?></a></li>
        <?php
        $status_array = cancel_order_status_array();
        //		$number_error_orders = get_count_orders('error');
        if (!empty($status_array)) {
            foreach ($status_array as $row_status) {
                if (kando_is_normal_user() && ($row_status === 'error')) {
                    continue;
                }

                switch ($row_status) {
                    case 'all':
                        $icon = "far fa-list-ul";
                        $color = "button-light";
                        break;

                    case 'pending':
                        $icon = "far fa-clock";
                        $color = "button-blue";
                        break;
                    case 'success':
                        $icon = "far fa-check";
                        $color = "button-green";
                        break;
                    case 'error':
                        $icon = "far fa-exclamation-triangle";
                        $color = "button-red";
                        break;

                    default:
                        $icon = "";
                        break;
                }
                ?>
                <li class="list-inline-item nav-select">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === $row_status) ? 'active' : '' ?>" href="<?= home_url('dashboard/?action=cancel&status=' . $row_status) ?>">
                        <i class="<?= $icon ?>" style="margin-right:5px;margin-top: 3px;"></i>
                        <?= samyar_order_status_title($row_status) ?>
                        <?php
                        echo '<span class="button ' . $color . ' badge-error-orders">' . get_count_cancel_orders($row_status) . '</span>';
                        ?>
                    </a>
                </li>
            <?php }
        } ?>
    </ul>
</div>

<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_bag"></i>
        <h5 class="dashboard-posts-title"><?=$title?></h5>
        <?php if (isset($_GET['status']) && ($_GET['status'] === "pending" || $_GET['status'] === "error")): ?>
            <div class="float-left kt-hidden-lg">
                <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-0" name="cb-select-all-0">
                <label class="kando-cb-label" for="cb-select-all-0"></label>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] === "error"): ?>
            <a href="#" style="float: left;margin-right: 5px" class="button button-red kt-ajax-button samyar-resend-cancel-orders" data-wpel-link="internal"><?php _e("Resend all errors", SAMYAR_TEXT_DOMAIN); ?></a>
        <?php endif; ?>
    </div>
    <div class="dashboard-posts-list" style="padding-top: 10px;">
        <?php
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
        $limit = 30; //تعداد قابل نمایش
        $offset = ($limit * $paged) - $limit;



            $query = ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset];

            if (kando_is_normal_user()) {
                $query['uid'] = get_current_user_id();
            }
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                $query['status'] = $_GET['status'];
            }

            $cancel_orders = Cancel::where($query);

        if ($cancel_orders):
            ?>


            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if (kando_user_can('show_order_user_info')) { ?>
                        <th><span class="nobr"><?php _e("User information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <?php if (kando_user_can('show_order_provider_id')) { ?>
                        <th><span class="nobr"><?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("API response", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($cancel_orders as $cancel_order):
                    include('order.php');
                endforeach; ?>
                </tbody>
            </table>
            <?php
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                $status = $_GET['status'];
            } else {
                $status = 'all';
            }

            if (isset($_GET['user']) && !empty($_GET['user'])) {
                $uid = $_GET['user'];
            } else {
                $uid = "";
            }

            $total = get_count_cancel_orders($status, $uid);
            samyar_pagination($total, $limit, $paged)
            ?>
        <?php
        else:
            ?>
            <span class="orders-notfound"><?php _e("No orders have been added yet.", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
</div>
