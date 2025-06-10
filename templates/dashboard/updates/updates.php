<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Supdate;
?>
<div class="page-options d-flex tabs-wrapper">
    <ul class="list-inline mb-0 order_btn_group nav">
        <li class="list-inline-item nav-select" style="margin-left: -5px;">
            <a class="nav-link <?= (!isset($_GET['section'])) ? 'active' : '' ?>"
               href="<?= home_url('dashboard/?action=updates') ?>"><?= '<span class="button button-light badge-error-orders">' . __('All', SAMYAR_TEXT_DOMAIN) . '</span>'; ?>
            </a></li>
        <?php
        $color = "button-default";
        $status_array = ['disable','enable','increase_amount','decrease_amount'];
        //		$number_error_orders = get_count_orders('error');
        if (!empty($status_array)) {
            foreach ($status_array as $row_status) {
                switch ($row_status) {
                    case 'all':
                        $color = "button-light";
                        $title = __("All", SAMYAR_TEXT_DOMAIN);
                        break;
                    case 'disable':
                        $color = "button-default";
                        $title = __("Disable", SAMYAR_TEXT_DOMAIN);
                        break;
                    case 'enable':
                        $color = "button-green";
                        $title = __("Enable", SAMYAR_TEXT_DOMAIN);
                        break;
                    case 'increase_amount':
                        $color = "button-blue";
                        $title = __("Increase amount", SAMYAR_TEXT_DOMAIN);
                        break;
                    case 'decrease_amount':
                        $color = "button-orange";
                        $title = __("Decrease amount", SAMYAR_TEXT_DOMAIN);
                        break;
                    default:
                        $icon = "";
                        $title = "";
                        break;
                }
                ?>
                <li class="list-inline-item nav-select">
                    <a class="nav-link <?= (isset($_GET['status']) && $_GET['status'] === $row_status) ? 'active' : '' ?>"
                       href="<?= home_url('dashboard/?action=updates&status=' . $row_status) ?>"><?= '<span class="button ' . $color . ' badge-error-orders">' . $title . '</span>'; ?>
                    </a>
                </li>
            <?php }
        } ?>
    </ul>
</div>

<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_pencil"></i>
        <h5 class="dashboard-posts-title"><?php _e('Updates', SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Current page number
        $user_id = get_current_user_id();
        $items_per_page = get_user_meta($user_id, 'items_per_page', true);
        $items_per_page = $items_per_page ?: 30; // مقدار پیش‌فرض 10

        $limit = $items_per_page; //تعداد قابل نمایش

        $offset = ($limit * $paged) - $limit;

        $query = ['order' => 'DESC', 'order_by' => 'date', 'limit' => $limit, 'offset' => $offset];
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $query['update_type'] = $_GET['status'];
        }
        $updates = Supdate::where($query);

        if ($updates):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e('ID', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Service', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Date', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Category', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if(samyar_user_is_admin(get_current_user_id())): ?>
                        <th><span class="nobr"><?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php endif; ?>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($updates as $update):
                    include('update.php');
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
                    unset($query['order']);
                    unset($query['order_by']);
                    $total = Supdate::count($query);
                    samyar_pagination($total, $limit, $paged);
                    ?>
                </div>
            </div>


        <?php
        else:
            ?>
            <span class="services-notfound"><?php _e('No updates have been added yet.', SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
</div>
