<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Ticket;

// * paginate
$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; // Current page number
$user_id = get_current_user_id();
$items_per_page = get_user_meta($user_id, 'items_per_page', true);
$items_per_page = $items_per_page ?: 30; // Default value is 10

$limit = $items_per_page; // Number of items to display

$offset = ( $limit * $paged ) - $limit;

$tickets = Ticket::where( [
    'status' => "waiting",
    'order'=>'DESC',
    'order_by'=>'id',
    'limit' => $limit,
    'offset' => $offset
] );
$title = __("Tickets Awaiting Response", SAMYAR_TEXT_DOMAIN);
?>
<div class="woocommerce-MyAccount-content">
    <div class="woocommerce-notices-wrapper"></div>
    <?php include_once(SAMYAR_DIR_TEMPLATE.'/dashboard/tickets/buttons.php') ?>
    <div class="dashboard-posts-box dashboard-tickets-box">
        <div class="dashboard-posts-title-holder">
            <i class="elegant-icon icon_lifesaver"></i>
            <h5 class="dashboard-posts-title"><?php _e("Tickets", SAMYAR_TEXT_DOMAIN); ?></h5>
        </div>
        <div class="dashboard-posts-list">

            <?php if ( $tickets ): ?>
                <?php foreach ( $tickets as $ticket ): ?>
                    <a href="<?php echo esc_attr( home_url( 'dashboard/?action=tickets&section=show&id='.$ticket->id ) ) ?>" class="dashboard-post" data-wpel-link="internal">
                        <div class="dashboard-post-date">
                            <span class="dashboard-post-date-day"><?php echo date_i18n('d',strtotime($ticket->created_at)) ?></span>
                            <span class="dashboard-post-date-month"><?php echo date_i18n('M Y',strtotime($ticket->created_at)) ?></span>
                        </div>
                        <div class="dashboard-post-inner">
                            <div class="dashboard-post-title"><?php echo esc_attr($ticket->title) ?></div>
                            <?php
                            switch ($ticket->status){
                                case 'waiting':
                                    echo '<span class="dashboard-post-status dashboard-post-status-not-replied">' . __("Waiting for reply", SAMYAR_TEXT_DOMAIN) . '</span>';
                                    break;
                                case 'answered':
                                    echo '<span class="dashboard-post-status dashboard-post-status-replied">' . __("Answered", SAMYAR_TEXT_DOMAIN) . '</span>';
                                    break;
                                case 'closed':
                                    echo '<span class="ticket-single-status ticket-single-status-closed">' . __("Closed", SAMYAR_TEXT_DOMAIN) . '</span>';
                                    break;
                            }
                            ?>
                        </div>
                    </a>
                <?php endforeach; ?>
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
                        $total = Ticket::count(['status' => "waiting"]);
                        samyar_pagination( $total,$limit, $paged )
                        ?>
                    </div>
                </div>


            <?php else: ?>
                <?php _e("No tickets have been submitted yet.", SAMYAR_TEXT_DOMAIN); ?>
            <?php endif; ?>
        </div>
        <a href="<?php echo esc_attr( home_url( 'dashboard/?action=tickets&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
    </div>
</div>