<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use kandopanel\currencyController;
use Morilog\Jalali\Jalalian;
use samyar\Order;
use samyar\orderController;
use samyar\Provider;
use samyar\Service;
use samyar\smsController;

$title = __("Your orders", SAMYAR_TEXT_DOMAIN);
?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('orders'); ?>
    </div>
</div>
<?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/buttons.php') ?>

<div class="kt-row">
    <div class="kt-col-xs-12 kt-col-md-12 float-right">
        <form method="GET" class="samyar-form filter-orders-form" action="<?= home_url("/dashboard") ?>"
              style="display: none">
            <input type="hidden" name="action" value="orders">
            <div class="new-api-provider-form-errors"></div>
            <div class="samyar-form-loading"></div>
            <div class="clearfix">
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <input type="text" name="query" id="query-input"
                           placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                    <input type="text" name="date-query" id="query-input-date" class="hasDatepicker" style="display: none"
                           placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <select name="filter_type" id="filter-type">
                        <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="order-id"><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="link"><?php _e("order link", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="service-id"><?php _e("Service ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="order-date"><?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php if (kando_user_can('show_order_user_info')): ?>
                            <option value="api-order-id"><?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="username"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile number", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="provider"><?php _e("Provider", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                    <input type="submit" class="button button-green sen "
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
               href="<?= home_url('dashboard/?action=orders') ?>">
                <i class="far fa-list-ul" style="margin-right:5px;"></i><?php _e('All', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-light badge-error-orders">' . get_count_orders('all') . '</span>' ?>
            </a></li>
        <?php
        $color = "button-default";
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
                        echo '<span class="button ' . $color . ' badge-error-orders">' . $orders_counts[$row_status] . '</span>';
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
    <!--
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px; text-align: center;">
                <?php _e('Some orders have not had their status updated for more than 1 day. Let\'s take care of them, otherwise, new orders will not be reviewed.', SAMYAR_TEXT_DOMAIN); ?>
                <br>
                (
                <strong style="font-weight: 900;">
                    <?php _e('Please note that only orders that have been sent to the provider are reviewed, and those that have not received an order ID in the API will not be reviewed, even if several days have passed since the order was registered.', SAMYAR_TEXT_DOMAIN); ?>
                </strong>
                )
                <br>
                <a style="margin-top: 20px;"
                   href="<?php echo esc_attr(home_url('dashboard/?action=orders&status=late_update_status')); ?>"
                   class="button button-red" data-wpel-link="internal">
                    <?php _e('View orders', SAMYAR_TEXT_DOMAIN); ?>
                </a>
            </div>
        </div>
    </div>
    -->
<?php endif; ?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_bag"></i>
        <h5 class="dashboard-posts-title"><?php _e("Orders", SAMYAR_TEXT_DOMAIN); ?></h5>
        <?php if (isset($_GET['status']) && ($_GET['status'] === "pending" || $_GET['status'] === "inprogress" || $_GET['status'] === "processing" || $_GET['status'] === "error" || $_GET['status'] === "late_update_status")): ?>
            <div class="float-left kt-hidden-lg">
                <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-0" name="cb-select-all-0">
                <label class="kando-cb-label" for="cb-select-all-0"></label>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] === "error"): ?>
            <a href="#" style="float: left;margin-right: 5px"
               class="button button-red kt-ajax-button samyar-resend-orders"
               data-wpel-link="internal"><?php _e("Resend all errors", SAMYAR_TEXT_DOMAIN); ?></a>
        <?php endif; ?>
    </div>
    <div class="dashboard-posts-list" style="padding-top: 10px;">
        <?php
        global $wpdb;

        // * paginate
        $paged = max(1, get_query_var('paged')); // شماره صفحه فعلی با حداقل مقدار 1

        $user_id = get_current_user_id();
        $items_per_page = get_user_meta($user_id, 'items_per_page', true) ?: 30; // مقدار پیش‌فرض 30

        // جداول با prefix دیتابیس
        $table_orders = $wpdb->prefix . 'samyar_orders';
        $table_services = $wpdb->prefix . 'samyar_services';
        $table_api_provider = $wpdb->prefix . 'samyar_api_provider';

        // شرط‌ها
        $where_conditions = [];

        // اگر کاربر عادی بود فقط سفارش‌های خودش را ببینید
        if (kando_is_normal_user()) {
            $where_conditions[] = "o.uid = " . intval(get_current_user_id());
        }

        // فیلتر وضعیت
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $status = sanitize_text_field($_GET['status']);
            $where_conditions[] = $status === "custom_order"
                ? "o.api_provider_id = 0"
                : "o.status = '$status'";
        } else {
            // نمایش همه وضعیت‌ها به جز "awaiting"
            $where_conditions[] = "o.status <> 'awaiting'";
        }

        // فیلتر جستجو
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search_query = sanitize_text_field($_GET['query']);
            $search_query = smsController::getInstance()->EnglishNumberMobile($search_query);
            $filter_type = sanitize_text_field($_GET['filter_type'] ?? '');

            switch ($filter_type) {
                case 'order-id':
                    $where_conditions[] = "o.id = " . (int)$search_query;
                    break;
                case 'api-order-id':
                case 'link':
                    $where_conditions[] = $filter_type === 'api-order-id'
                        ? "o.api_order_id = '$search_query'"
                        : "o.link LIKE '%" . $wpdb->esc_like($search_query) . "%'";
                    break;
                case 'service-id':
                    $where_conditions[] = "o.service_id = " . (int)$search_query;
                    break;
                case 'username':
                case 'email':
                    if (kando_user_can('show_order_user_info')) {
                        $user = $filter_type === 'username'
                            ? get_user_by('login', $search_query)
                            : get_user_by('email', $search_query);
                        if ($user) {
                            $where_conditions[] = "o.uid = " . $user->ID;
                        } else {
                            // اگر کاربر یافت نشد، شرط غیرممکن اضافه کنید
                            $where_conditions[] = "1 = 0";
                        }
                    }
                    break;
                case 'mobile':
                    if (kando_user_can('show_order_user_info')) {
                        $user = kandoGetUserByMobile($search_query);
                        $where_conditions[] = $user ? "o.uid = " . $user->ID : "1 = 0";
                    }
                    break;
                case 'provider':
                    if (kando_user_can('show_order_user_info')) {
                        $where_conditions[] = "o.api_provider_id = " . (int)$search_query;
                    }
                    break;
            }
        }

        // فیلتر تاریخ
        if (!empty($_GET['date-query'] ?? null) && ($_GET['filter_type'] ?? null) === 'order-date') {
            $jalaliDate = convertPersianNumbersToEnglish(sanitize_text_field($_GET['date-query']));

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $jalaliDate)) {
                try {
                    $gregorianDate = Jalalian::fromFormat('Y-m-d', $jalaliDate)
                        ->toCarbon()
                        ->format('Y-m-d');
                    $where_conditions[] = "DATE(o.created_at) = '{$gregorianDate}'";
                } catch (Exception $e) {
                    error_log('Jalali date conversion failed: ' . $e->getMessage());
                }
            }
        }

        // حذف سفارش‌های چند بخشی
        $where_conditions[] = "o.main_order_id IS NULL";

        // ساخت شرط WHERE
        $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

        // کوئری اصلی
        $sql = "SELECT 
    o.*, 
    s.name AS service_name, 
    s.type AS service_type, 
    s.cancel AS service_cancel,
    p.name AS provider_name,
    p.url AS provider_url,
    p.api_key AS provider_api_key
FROM $table_orders o
LEFT JOIN $table_services s ON o.service_id = s.id
LEFT JOIN $table_api_provider p ON o.api_provider_id = p.id AND COALESCE(o.api_provider_id, 0) > 0
$where_clause
ORDER BY o.id DESC
LIMIT $items_per_page OFFSET " . (($paged - 1) * $items_per_page);

        $orders = $wpdb->get_results($sql);

        // بررسی خطا
        if ($wpdb->last_error) {
            error_log($wpdb->last_error);
            $orders = [];
        }

        //        }
        if ($orders):
            ?>
            <?php if (isset($_GET['status']) && ($_GET['status'] === "pending" || $_GET['status'] === "inprogress" || $_GET['status'] === "processing" || $_GET['status'] === "error" || $_GET['status'] === "late_update_status")): ?>
            <div class="kt-row" style="margin-bottom: 10px">
                <div class="column kt-col-xs-6 kt-col-md-3 float-right">
                    <select name="change_selected" class="kando_change_selected" style="padding: 7px 15px;">
                        <option value="change-status"><?php _e("Change of status", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="enable-automatic-resend"><?php _e("Enable Automatic Resend", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="delete"><?php _e("remove", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                </div>
                <div class="column kt-col-xs-6 kt-col-md-3 float-right">
                    <a href="#" style="margin-right: 5px"
                       class="button button-red kando-change-status"><?php _e("apply", SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
            </div>

        <?php endif; ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <?php
                    $cb_status = ['pending', 'inprogress', 'processing', 'error', 'late_update_status'];
                    if (isset($_GET['status']) && in_array($_GET['status'], $cb_status)): ?>
                        <th id="cb">
                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1"
                                   name="cb-select-all-1">
                            <label class="kando-cb-label" for="cb-select-all-1"></label>
                        </th>
                    <?php endif; ?>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?></span></th>
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
                $style = (int)kando_get_option('order-style', 2);
                foreach ($orders as $order):
                    if ($style === 1) {
                        include(SAMYAR_DIR_VIEW . '/orders/order/style1.php');
                    } else {
                        include(SAMYAR_DIR_VIEW . '/orders/order/style2.php');
                    }
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
                    // ساخت شرط WHERE نهایی برای شمردن تعداد
                    $where_clause_count = '';
                    if (!empty($where_conditions)) {
                        $where_clause_count = 'WHERE ' . implode(' AND ', $where_conditions);
                    }

                    // کوئری SQL برای شمردن تعداد نتایج
                    $sql_count = "
            SELECT COUNT(o.id) AS total
            FROM $table_orders o
            LEFT JOIN $table_services s ON o.service_id = s.id
            $where_clause_count
        ";

                    // اجرای کوئری شمردن تعداد
                    $total_result = $wpdb->get_var($sql_count);

                    // اگر خطایی رخ داد
                    if ($wpdb->last_error) {
                        error_log($wpdb->last_error);
                        $total_result = 0;
                    }

                    // تعداد کل نتایج
                    $total = (int)$total_result;
                    if ($total > 0) {
                        samyar_pagination($total, $items_per_page, $paged);
                    }
                    ?>
                </div>
            </div>

        <?php
        else:
            ?>
            <span class="orders-notfound"><?php _e("Order not found", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')) ?>"
       class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>

<script>
    jQuery(document).ready(function ($) {
        $(document).on("change", "#filter-type", function () {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            var inputElement = $('#query-input');
            var inputDateElement = $('#query-input-date');

            inputDateElement.hide();
            // اضافه کردن کلاس متناسب با انتخاب کاربر
            if (selectedValue === 'order-date') {
                inputDateElement.show();
                inputElement.hide();
            }else{
                inputElement.show();
                inputDateElement.hide();
            }
        });
    });
</script>