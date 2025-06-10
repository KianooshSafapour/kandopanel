<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Notification;

// * paginate
$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//Current page number

$user_id = get_current_user_id();
$items_per_page = get_user_meta($user_id, 'items_per_page', true);
$items_per_page = $items_per_page ?: 30; // Default value 10

$limit = $items_per_page; //Number of items to display


$offset = ( $limit * $paged ) - $limit;

$notifications = Notification::where( ['type' => ['operator' => 'IN', 'value' => ['notification', 'alert'],],'order'=>'DESC','order_by'=>'id', 'limit' => $limit, 'offset' => $offset ] );;
$title = __("Notifications", SAMYAR_TEXT_DOMAIN);
if ( kando_user_can('show_notifications') ):
    ?>
    <div class="woocommerce-MyAccount-content">
        <div class="woocommerce-notices-wrapper"></div>
        <div class="tickets-navigation">
            <!--        <span class="button button-default">--><?php //echo $title ?><!--</span>-->
            <a href="<?php echo esc_attr( home_url( 'dashboard/?action=notifications&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal"><?php _e('Send Notification', SAMYAR_TEXT_DOMAIN); ?></a>
        </div>
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="elegant-icon icon_lightbulb_alt"></i>
                <h5 class="dashboard-posts-title"><?php _e('Notifications', SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">

                <?php if ( $notifications ): ?>
                    <?php foreach ( $notifications as $notification ): ?>
                        <a href="<?php echo esc_attr( home_url( 'dashboard/?action=notifications&section=edit&id='.$notification->id ) ) ?>" class="dashboard-post" data-wpel-link="internal" style="width: 90%;">
                            <div class="dashboard-post-date">
                                <span class="dashboard-post-date-day"><?php echo date_i18n('d',strtotime($notification->created_at)) ?></span>
                                <span class="dashboard-post-date-month"><?php echo date_i18n('M Y',strtotime($notification->created_at)) ?></span>
                                <span class="button button-<?php if($notification->type==="notification" || $notification->type===""){echo'violet';}else{echo'red';} ?> badge-error-orders" style="margin-top: 4px;">
                                <?php if($notification->type==="notification" || $notification->type===""){echo __('Notification', SAMYAR_TEXT_DOMAIN);}else{echo __('Alert', SAMYAR_TEXT_DOMAIN);} ?>
                            </span>
                            </div>
                            <div class="dashboard-post-inner">
                                <div class="dashboard-post-title"><?php echo esc_attr($notification->title) ?></div>
                                <?php
                                switch ($notification->status){
                                    case 'pending':
                                        echo '<span class="dashboard-post-status dashboard-post-status-not-replied">'. __('Not Published', SAMYAR_TEXT_DOMAIN) .'</span>';
                                        break;
                                    case 'publish':
                                        echo '<span class="dashboard-post-status dashboard-post-status-replied">'. __('Published', SAMYAR_TEXT_DOMAIN) .'</span>';
                                        break;
                                }
                                ?>
                            </div>
                            <span class="button button-aqua btn-small delete-notification" data-id="<?=$notification->id?>" data-tooltip="<?php _e('Delete', SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
                        </a>
                    <?php endforeach; ?>
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
                            $total  = Notification::count( ['type' => ['operator' => 'IN', 'value' => ['notification', 'alert'],]] );
                            samyar_pagination( $total,$limit, $paged )
                            ?>
                        </div>
                    </div>


                <?php else: ?>
                    <span class="services-notfound"><?php _e('No notifications have been sent yet.', SAMYAR_TEXT_DOMAIN); ?></span>
                <?php endif; ?>
            </div>
            <a href="<?php echo esc_attr( home_url( 'dashboard/?action=notifications&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
        </div>
    </div>
<?php
endif;