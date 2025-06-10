<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
use samyar\Ticket;

// * paginate

$title = __("Search Results", SAMYAR_TEXT_DOMAIN);
?>
<div class="woocommerce-MyAccount-content">
    <div class="woocommerce-notices-wrapper"></div>
    <div class="dashboard-posts-box dashboard-tickets-box">
        <div class="dashboard-posts-title-holder">
            <i class="elegant-icon icon_lifesaver"></i>
            <h5 class="dashboard-posts-title"><?=$title?></h5>
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
                            }
                            ?>
                        </div>
                    </a>
                <?php endforeach; ?>
                <?php
                $total = Ticket::count(['status' => "answered"]);
                samyar_pagination( $total,$limit, $paged )
                ?>
            <?php else: ?>
                <?php _e("No tickets have been submitted yet.", SAMYAR_TEXT_DOMAIN); ?>
            <?php endif; ?>
        </div>
        <a href="<?php echo esc_attr( home_url( 'dashboard/?action=tickets&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
    </div>
</div>