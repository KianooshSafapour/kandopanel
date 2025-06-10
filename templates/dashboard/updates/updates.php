<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Supdate;
?>
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

        $updates = Supdate::where(['order' => 'DESC', 'order_by' => 'date', 'limit' => $limit, 'offset' => $offset]);

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
                    $total = Supdate::count();
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
