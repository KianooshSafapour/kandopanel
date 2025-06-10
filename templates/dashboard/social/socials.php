<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
use samyar\Social;
?>
<div class="tickets-navigation">
    <!--	<span class="button button-default">Categories</span>-->
    <a href="<?php echo esc_attr( home_url( 'dashboard/?action=social&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal"><?php _e("Add Brand", SAMYAR_TEXT_DOMAIN); ?></a>
</div>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="fas fa-copyright"></i>
        <h5 class="dashboard-posts-title"><?php _e("Brands", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        // * paginate
        $paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//شماره صفحه فعلی

        $user_id = get_current_user_id();
        $items_per_page = get_user_meta($user_id, 'items_per_page', true);
        $items_per_page = $items_per_page ?: 30; // مقدار پیش‌فرض 10

        $limit = $items_per_page; //تعداد قابل نمایش

        $offset = ( $limit * $paged ) - $limit;

        $socials = Social::where( ['order'=>'ASC','order_by'=>'sort', 'limit' => $limit, 'offset' => $offset ] );
        if ($socials):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Icon", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Sorting", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <!--					<th><span class="nobr">Number of Services</span></th>-->
                    <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Actions", SAMYAR_TEXT_DOMAIN); ?></span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ( $socials as $social ):
                    ?>
                    <tr id="social-<?php echo esc_attr($social->id) ?>">
                        <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($social->id) ?>
                        </td>
                        <td data-title="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($social->name) ?>
                        </td>
                        <td data-title="<?php _e("Icon", SAMYAR_TEXT_DOMAIN); ?>">
                            <i class="<?php echo esc_attr($social->icon) ?>"></i>
                        </td>
                        <td data-title="<?php _e("Sorting", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($social->sort) ?>
                        </td>
                        <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
                            <label class="custom-switch">
                                <input type="checkbox" name="disable-social" data-type="social" data-id="<?php echo esc_attr($social->id) ?>" class="ajax-switch custom-switch-input" data-toggle="collapse" aria-expanded="false" <?php echo checked($social->status, 1); ?>>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td data-title="<?php _e("Actions", SAMYAR_TEXT_DOMAIN); ?>">
                            <a href="<?php echo esc_attr(home_url('dashboard/?action=social&section=edit&id='. esc_attr($social->id) )) ?>"><span class="button button-default btn-small" data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-edit"></i></span></a>
                            <span class="button button-aqua btn-small delete-social" data-id="<?php echo esc_attr($social->id) ?>" data-tooltip="<?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
                        </td>
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
                    $total = Social::count();
                    samyar_pagination( $total,$limit, $paged )
                    ?>
                </div>
            </div>


        <?php
        else:
            ?>
            <span class="services-notfound"><?php _e("No brands have been added yet.", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
    <a href="<?php echo esc_attr( home_url( 'dashboard/?action=social&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>