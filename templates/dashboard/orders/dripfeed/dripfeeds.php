<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\orderController;
use samyar\Provider;
use samyar\Service;

$title = __("Your drip feeds orders", SAMYAR_TEXT_DOMAIN);
?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('dripfeed'); ?>
    </div>
</div>

<div class="tickets-navigation">
    <!--	<span class="button button-default">--><?php //echo $title ?><!--</span>-->
    <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')) ?>" class="button button-light"
       data-wpel-link="internal"><?php _e("Add order", SAMYAR_TEXT_DOMAIN); ?></a>
    <a href="#" class="button button-blue kando-show-order-filter"
       data-wpel-link="internal"><?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?></a>

</div>

<div class="kt-row">
    <div class="kt-col-xs-12 kt-col-md-12 float-right">
        <form method="POST" class="samyar-form filter-orders-form" style="display: none">
            <input type="hidden" name="action" value="samyar_filter_orders_form">
            <div class="new-api-provider-form-errors"></div>
            <div class="samyar-form-loading"></div>
            <div class="clearfix">
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <select name="filter_type">
                        <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="order-id"><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="api-order-id"><?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="link"><?php _e("order link", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="service-id"><?php _e("Service ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php if (kando_user_can('show_order_user_info')): ?>
                            <option value="username"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User Email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile Number", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="provider"><?php _e("Provider", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php endif; ?>
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

<div class="page-options d-flex tabs-wrapper">
    <ul class="list-inline mb-0 order_btn_group nav">
        <li class="list-inline-item nav-select" style="margin-left: -5px;">
            <a class="nav-link <?= (!isset($_GET['section'])) ? 'active' : '' ?>"
               href="<?= home_url('dashboard/?action=dripfeeds') ?>">
                <i class="far fa-list-ul" style="margin-right:5px;"></i><?php _e('All', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-light badge-error-orders">' . get_count_dripfeed_orders('all') . '</span>' ?>
            </a></li>
        <?php
        $status_array = array(
            'active',
            'completed',
            'canceled',
        );
        //		$number_error_orders = get_count_orders('error');
        if (!empty($status_array)) {
            foreach ($status_array as $row_status) {

                switch ($row_status) {
                    case 'all':
                        $icon = "far fa-list-ul";
                        $color = "button-light";
                        break;
                    case 'active':
                        $icon = "far fa-chart-line";
                        $color = "button-light";
                        break;
                    case 'completed':
                        $icon = "far fa-check";
                        $color = "button-green";
                        break;
                    case 'canceled':
                        $icon = "far fa-times-circle";
                        $color = "button-aqua";
                        break;
                    default:
                        $icon = "";
                        break;
                }
                ?>
                <li class="list-inline-item nav-select">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === $row_status) ? 'active' : '' ?>"
                       href="<?= home_url('dashboard/?action=dripfeeds&status=' . $row_status) ?>"><i
                                class="<?= $icon ?>"
                                style="margin-right:5px;margin-top: 3px;"></i><?= samyar_order_status_title($row_status) ?>
                        <?php
                        //						if ( $row_status === 'error' && isset($number_error_orders)) {
                        echo '<span class="button ' . $color . ' badge-error-orders">' . get_count_dripfeed_orders($row_status) . '</span>';
                        //						}
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
        <h5 class="dashboard-posts-title"><?php _e("Drip feeds Orders", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list" style="padding-top: 10px;">
        <?php
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
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $query['status'] = $_GET['status'];
        } else {
            $query['status'] = [
                'operator' => '<>',
                'value' => "awaiting",
            ];
        }

        if (isset($_GET['user']) && !empty($_GET['user'])) {
            $query['uid'] = $_GET['user'];
        }

        //میخوایم بگیم که اون سفارش هایی که مربوط به چند بخشی هست رو اینجا نشون نده
        $query['main_order_id'] = NULL;
        $query['is_drip_feed'] = 1;


        $orders = Order::where($query);

        if ($orders):
            ?>
            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Update date", SAMYAR_TEXT_DOMAIN); ?></span></th>

                    <?php if (kando_user_can('show_order_user_info')) { ?>
                        <th><span class="nobr"><?php _e("User Information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <?php if (kando_user_can('show_order_provider_id')) { ?>
                        <th><span class="nobr"><?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("API Response", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>

                    <th><span class="nobr"><?php _e("status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>

                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($orders as $order):
                    if ($order->api_provider_id !== "0") {
                        $provider = Provider::find($order->api_provider_id);
                    }
                    include('order.php');


                endforeach; ?>
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

                    $total = get_count_dripfeed_orders($status, $uid);
                    samyar_pagination($total, $limit, $paged)
                    ?>
                </div>
            </div>


        <?php
        else:
            ?>
            <span class="orders-notfound"><?php _e("No drop feed order has been added yet", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')) ?>"
       class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>
