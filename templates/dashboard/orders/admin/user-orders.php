<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\Provider;
use samyar\Service;

$title = __("Users' Orders", SAMYAR_TEXT_DOMAIN);
?>
<?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/buttons.php') ?>
<?php if (samyar_is_admin()): ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12 float-right">
            <form method="POST" class="samyar-form filter-orders-form">
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
                            <option value="link"><?php _e("Order link", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="username"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                        <input type="submit" class="button button-green sen" value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="dashboard-posts-box dashboard-tickets-box">
        <div class="dashboard-posts-title-holder">
            <i class="elegant-icon icon_lifesaver"></i>
            <h5 class="dashboard-posts-title"><?php _e("Users' Orders", SAMYAR_TEXT_DOMAIN); ?></h5>
        </div>
        <div class="dashboard-posts-list">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $limit = 30;
            $offset = ($limit * $paged) - $limit;

            $query = ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset];
            $query['main_order_id'] = NULL;

            $orders = Order::where($query);
            if ($orders):
                ?>

                <table class="shop_table shop_table_responsive">
                    <thead>
                    <tr>
                        <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Registration Date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <?php if (samyar_is_admin()): ?>
                            <th><span class="nobr"><?php _e("User Information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("API Response", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <?php endif; ?>
                        <th><span class="nobr"><?php _e("Actions", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($orders as $order):
                        if ($order->api_provider_id !== "0") {
                            $provider = Provider::find($order->api_provider_id);
                        }
                        include(SAMYAR_DIR_TEMPLATE.'/dashboard/orders/order.php');
                    endforeach; ?>
                    </tbody>
                </table>
                <?php
                $status = 'all';
                $total = get_count_orders($status);
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
        <a href="<?php echo esc_attr(home_url('dashboard/?action=orders§ion=new')) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
    </div>
<?php endif; ?>