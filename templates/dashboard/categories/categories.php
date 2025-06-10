<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
use samyar\Category;
use samyar\Social;

?>
<div class="tickets-navigation">
    <!--	<span class="button button-default">Categories</span>-->
    <a href="<?php echo esc_attr( home_url( 'dashboard/?action=categories&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal"><?php _e('Add Category', SAMYAR_TEXT_DOMAIN); ?></a>
</div>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_folder-alt"></i>
        <h5 class="dashboard-posts-title"><?php _e('Service Categories', SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        // * paginate
        $categoryController = \samyar\categoryController::getInstance();
        $paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//Current page number

        $user_id = get_current_user_id();
        $items_per_page = get_user_meta($user_id, 'items_per_page', true);
        $items_per_page = $items_per_page ?: 30; // Default value 10


        $limit = $items_per_page; //Number of items to display


        $offset = ( $limit * $paged ) - $limit;

        $categories = Category::where( ['order'=>'ASC','order_by'=>'sort', 'limit' => $limit, 'offset' => $offset ] );
        if ($categories):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e('ID', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Name', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Sort Order', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Number of Services', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Brand', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?></span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ( $categories as $category ):
                    ?>
                    <tr id="category-<?php echo esc_attr($category->id) ?>">
                        <td data-title="<?php _e('ID', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($category->id) ?>
                        </td>
                        <td data-title="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            if($category->icon):
                                echo '<i class="'.$category->icon.'"></i>&nbsp;';
                            endif;
                            ?>
                            <?php echo esc_attr($category->name) ?>
                        </td>
                        <td data-title="<?php _e('Sort Order', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($category->sort) ?>
                        </td>
                        <td data-title="<?php _e('Number of Services', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($categoryController->count_services_in_category($category->id)) ?>
                        </td>
                        <td data-title="<?php _e('Brand', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            if(!empty($category->social_id) || $category->social_id !=0):
                                $social = Social::find($category->social_id);
                                if($social):
                                    echo '<i class="'.$social->icon.'"></i>&nbsp;';
                                    echo $social->name;
                                endif;
                            endif; ?>
                        </td>
                        <td data-title="<?php _e('Description', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            if($category->description){
                                echo html_entity_decode( $category->description, ENT_QUOTES );
                            }
                            ?>
                        </td>
                        <td data-title="<?php _e('Status', SAMYAR_TEXT_DOMAIN); ?>">
                            <label class="custom-switch">
                                <input type="checkbox" name="disable-category" data-type="category" data-id="<?php echo esc_attr($category->id) ?>" class="ajax-switch custom-switch-input" data-toggle="collapse" aria-expanded="false" <?php echo checked($category->status, 1); ?>>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td data-title="<?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?>">
                            <a href="<?php echo esc_attr(home_url('dashboard/?action=categories&section=edit&id='. esc_attr($category->id) )) ?>"><span class="button button-default btn-small" data-tooltip="<?php _e('Edit', SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-edit"></i></span></a>
                            <span class="button button-aqua btn-small delete-category" data-id="<?php echo esc_attr($category->id) ?>" data-tooltip="<?php _e('Delete', SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
                            <!--                        <a href=""><span class="button button-red btn-small">Edit</span></a>-->
                            <!--                        <a href=""><span class="button button-aqua btn-small">Edit</span></a>-->
                        </td>
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
                    $total = Category::count();
                    samyar_pagination( $total,$limit, $paged )
                    ?>
                </div>
            </div>

        <?php
        else:
            ?>
            <span class="services-notfound"><?php _e('No categories have been added yet.', SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
    <a href="<?php echo esc_attr( home_url( 'dashboard/?action=categories&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>