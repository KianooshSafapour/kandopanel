<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\orderController;
use samyar\Provider;
use samyar\Service;

$title =  __("Your orders", SAMYAR_TEXT_DOMAIN);
?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('orders'); ?>
    </div>
</div>
<?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/buttons.php') ?>

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
                            <option value="username">نام کاربری</option>
                            <option value="email">ایمیل کاربر</option>
                            <option value="mobile">شماره همراه</option>
                            <option value="provider">ارائه دهنده</option>
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
            <a class="nav-link <?= (!isset($_GET['section'])) ? 'active' : '' ?>" href="<?= home_url('dashboard/?action=orders') ?>">
                <i class="far fa-list-ul" style="margin-right:5px;"></i><?php _e('All', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-light badge-error-orders">' . get_count_orders('all') . '</span>' ?></a></li>
        <?php
        $status_array = order_status_array();
        //		$number_error_orders = get_count_orders('error');
        if (!empty($status_array)) {
            $orders_counts = get_user_order_counts();
            foreach ($status_array as $row_status) {
                if (kando_is_normal_user() && ($row_status === 'error' || $row_status === 'late_update_status' || $row_status === 'custom_order')) {
                    continue;
                }

                switch ($row_status) {
                    case 'all':
                        $icon = "far fa-list-ul";
                        $color = "button-light";
                        break;
                    case 'processing':
                        $icon = "far fa-chart-line";
                        $color = "button-light";
                        break;
                    case 'awaiting':
                    case 'pending':
                        $icon = "far fa-clock";
                        $color = "button-blue";
                        break;
                    case 'inprogress':
                        $icon = "far fa-spinner";
                        $color = "button-default";
                        break;
                    case 'completed':
                        $icon = "far fa-check";
                        $color = "button-green";
                        break;
                    case 'partial':
                        $icon = "far fa-hourglass-half";
                        $color = "button-orange";
                        break;
                    case 'canceled':
                        $icon = "far fa-times-circle";
                        $color = "button-aqua";
                        break;
                    case 'refunded':
                        $icon = "far fa-undo-alt";
                        $color = "button-red";
                        break;
                    case 'error':
                        $icon = "far fa-exclamation-triangle";
                        $color = "button-red";
                        break;
                    case 'late_update_status':
                        $icon = "far fa-exclamation-triangle";
                        $color = "button-red";
                        break;
                    case 'custom_order':
                        $icon = "far fa-hand-point-up";
                        $color = "button-red";
                        break;
                    default:
                        $icon = "";
                        break;
                }
                ?>
                <li class="list-inline-item nav-select">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === $row_status) ? 'active' : '' ?>"
                       href="<?= home_url('dashboard/?action=orders&status=' . $row_status) ?>"><i class="<?= $icon ?>"
                                                                                                   style="margin-right:5px;margin-top: 3px;"></i><?= samyar_order_status_title($row_status) ?>
                        <?php
                        //						if ( $row_status === 'error' && isset($number_error_orders)) {
                        echo '<span class="button ' . $color . ' badge-error-orders">' .  $orders_counts[$row_status] . '</span>';
                        //						}
                        ?>
                    </a>
                </li>
            <?php }
        } ?>
    </ul>
</div>
<?php
$order_class = new orderController();
$count = $order_class->get_orders_late_update_status(true);
if ($count):
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                برخی سفارشات بیش از 1 روز هست که وضعیت آنها تغییر نکرده است. بیایید به آنها رسیدگی کنیم، وگرنه نوبت به بررسی وضعیت، سفارش های جدید نخواهد رسید.
                <br>
                (
                <strong style="font-weight:900">قابل توجه اینکه تنها سفارشاتی که به ارائه دهنده ارسال شده اند بررسی میشن و اونایی که شناسه سفارش در API نگرفتن بررسی نمیشن حتی اگر چند روز از تاریخ ثبت سفارش گذشته باشه</strong>
                )
                <br>
                <a style="margin-top:20px" href="<?php echo esc_attr(home_url('dashboard/?action=orders&status=late_update_status')) ?>" class="button button-red" data-wpel-link="internal">مشاهده سفارش ها</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_bag"></i>
        <h5 class="dashboard-posts-title"><?php _e("Orders", SAMYAR_TEXT_DOMAIN); ?></h5>
        <?php if (isset($_GET['status']) && ($_GET['status'] === "pending"|| $_GET['status'] === "inprogress" || $_GET['status'] === "processing" || $_GET['status'] === "error" || $_GET['status'] === "late_update_status")): ?>
            <div class="float-left kt-hidden-lg">
                <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-0" name="cb-select-all-0">
                <label class="kando-cb-label" for="cb-select-all-0"></label>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] === "error"): ?>
            <a href="#" style="float: left;margin-right: 5px" class="button button-red kt-ajax-button samyar-resend-orders" data-wpel-link="internal"><?php _e("Resend all errors", SAMYAR_TEXT_DOMAIN); ?></a>
        <?php endif; ?>
    </div>
    <div class="dashboard-posts-list" style="padding-top: 10px;">
        <?php
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
        $limit = 30; //تعداد قابل نمایش
        $offset = ($limit * $paged) - $limit;

        if (isset($_GET['status']) && $_GET['status'] === "late_update_status") {//بررسی سفارش هایی که 1 روز از آپدیتشون گذشته
            $order_class = new orderController();
            $orders = $order_class->get_orders_late_update_status();
        }else if(isset($_GET['status']) && $_GET['status'] === "custom_order"){
            $order_class = new orderController();
            $orders = $order_class->get_orders_custom(false);
        } else {

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


            $orders = Order::where($query);
        }
        if ($orders):
            ?>
            <?php if (isset($_GET['status']) && ($_GET['status'] === "pending" || $_GET['status'] === "inprogress" || $_GET['status'] === "processing" ||  $_GET['status'] === "error" || $_GET['status'] === "late_update_status")): ?>
            <div class="kt-row" style="margin-bottom: 10px">
                <div class="column kt-col-xs-6 kt-col-md-3 float-right">
                    <select name="change_selected" class="kando_change_selected" style="padding: 7px 15px;">
                        <option value="change-status"><?php _e("Change of status", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="delete"><?php _e("remove", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                </div>
                <div class="column kt-col-xs-6 kt-col-md-3 float-right">
                    <a href="#" style="margin-right: 5px" class="button button-red kando-change-status"><?php _e("apply", SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
            </div>

        <?php endif; ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <?php
                    $cb_status = ['pending','inprogress','processing','error','late_update_status'];
                    if (isset($_GET['status']) && in_array($_GET['status'],$cb_status)): ?>
                        <th id="cb">
                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1" name="cb-select-all-1">
                            <label class="kando-cb-label" for="cb-select-all-1"></label>
                        </th>
                    <?php endif; ?>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("status", SAMYAR_TEXT_DOMAIN); ?></span></th>
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
                foreach ($orders as $order):
                    if (!is_null($order->api_provider_id) && $order->api_provider_id>0) {
                        $provider = Provider::find($order->api_provider_id);
                    }
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

            $total = get_count_orders($status, $uid);
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
    <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>
