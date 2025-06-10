<!--start tickets-->
<div class="kt-row">

    <?php

    use samyar\Ticket;

    $data = [
//	    'uid'      => get_current_user_id(),
        'order' => 'DESC',
        'order_by' => 'id',
        'limit' => 5
    ];
    if (samyar_is_admin()) {
        $data['status'] = "waiting";
    } else {
        $data['uid'] = get_current_user_id();
    }

    $tickets = Ticket::where($data);
    ?>

    <div class="column kt-col-xs-12 kt-col-md-12">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="elegant-icon icon_lifesaver"></i>
                <h5 class="dashboard-posts-title"><?php _e("Tickets (last 5 tickets)", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">
                <?php if ($tickets): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=show&id=' . $ticket->id)) ?>" class="dashboard-post" data-wpel-link="internal">
                            <div class="dashboard-post-date">
                                <span class="dashboard-post-date-day"><?php echo date_i18n('d', $ticket->created_at) ?></span>
                                <span class="dashboard-post-date-month"><?php echo date_i18n('M Y', $ticket->created_at) ?></span>
                            </div>
                            <div class="dashboard-post-inner">
                                <div class="dashboard-post-title"><?php echo esc_attr($ticket->title) ?></div>
                                <?php
                                switch ($ticket->status) {
                                    case 'waiting':
                                        echo '<span class="dashboard-post-status dashboard-post-status-not-replied">'.__("Awaiting reply", SAMYAR_TEXT_DOMAIN).'</span>';
                                        break;
                                    case 'answered':
                                        echo '<span class="dashboard-post-status dashboard-post-status-replied">'.__("Answered", SAMYAR_TEXT_DOMAIN).'</span>';
                                        break;
                                }
                                ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="services-notfound"><?php _e("No support requests have been submitted yet", SAMYAR_TEXT_DOMAIN); ?>.</span>
                <?php endif; ?>


            </div>

            <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new')) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
        </div>
    </div>

</div>
<!--start tickets-->