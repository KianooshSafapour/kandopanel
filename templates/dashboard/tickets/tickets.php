<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Ticket;

// * paginate
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
$user_id = get_current_user_id();
$items_per_page = get_user_meta($user_id, 'items_per_page', true);
$items_per_page = $items_per_page ?: 30; // مقدار پیش‌فرض 10

$limit = $items_per_page; //تعداد قابل نمایش

$offset = ($limit * $paged) - $limit;

if (kando_user_can('show_user_tickets')) {
    $query = [
//	    'status' => "waiting",
        'order' => 'DESC',
        'order_by' => 'id',
        'limit' => $limit,
        'offset' => $offset
    ];
    if (isset($_GET['status'])) {
        $query['status'] = $_GET['status'];
    }
    $tickets = Ticket::where($query);

    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 'waiting':
                $title = __("Tickets awaiting response", SAMYAR_TEXT_DOMAIN);
                break;
            case 'answered':
                $title = __("Answered tickets", SAMYAR_TEXT_DOMAIN);
                break;
            case 'closed':
                $title = __("Closed tickets", SAMYAR_TEXT_DOMAIN);
                break;
        }
    } else {
        $title = __("Tickets", SAMYAR_TEXT_DOMAIN);
    }

//	$title = "تیکت های در انتظار پاسخ";
} else {
    $query = [
        'uid' => get_current_user_id(),
        'order' => 'DESC',
        'order_by' => 'id',
        'limit' => $limit,
        'offset' => $offset
    ];

    if (isset($_GET['status'])) {
        $query['status'] = $_GET['status'];
    }

    $tickets = Ticket::where($query);
    $title = __("Your Tickets", SAMYAR_TEXT_DOMAIN);
}


?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('tickets'); ?>
    </div>
</div>
<div class="woocommerce-MyAccount-content">
    <div class="woocommerce-notices-wrapper"></div>

    <?php include_once('statistics.php') ?>
    <?php include_once('buttons.php') ?>
    <?php if (kando_user_can('show_user_tickets')): ?>
        <div class="kt-row">
            <div class="column kt-col-xs-12 kt-col-md-12 float-right">
                <form method="POST" class="samyar-form filter-tickets-form" style="display: none">
                    <input type="hidden" name="action" value="samyar_filter_tickets_form">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                            <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                            <select name="search_type">
                                <option value="0"><?php _e("Select the search type", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="ticket-id"><?php _e("Ticket ID", SAMYAR_TEXT_DOMAIN); ?></option>
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
    <?php endif; ?>


    <?php
    $admin_tickets_query = [
        'send_to' => get_current_user_id(),
        'status' => [
            'operator' => 'IN',
            'value' => ['waiting','answered'],
        ],
        'order' => 'DESC',
        'order_by' => 'id',
    ];

    $admin_tickets = Ticket::where($admin_tickets_query);
    ?>
    <?php if ($admin_tickets): ?>
        <!-- شروع تیکت های ارسالی از مدیر -->
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="elegant-icon icon_lifesaver"></i>
                <h5 class="dashboard-posts-title"><?php _e("Tickets sent by the manager", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">
                <?php foreach ($admin_tickets as $ticket): ?>
                    <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=show&id=' . $ticket->id)) ?>" class="dashboard-post" data-wpel-link="internal">
                        <div class="dashboard-post-date">
                            <span class="dashboard-post-date-day"><?php echo date_i18n('d', strtotime($ticket->created_at)) ?></span>
                            <span class="dashboard-post-date-month"><?php echo date_i18n('M Y', strtotime($ticket->created_at)) ?></span>
                            <span class="button button-blue badge-error-orders" style="margin-top: 4px;"><?php echo $ticket->id ?></span>
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
                                case 'closed':
                                    echo '<span class="ticket-single-status ticket-single-status-closed">'.__("closed", SAMYAR_TEXT_DOMAIN).'</span>';
                                    break;
                            }
                            ?>
                            <?php
                            if (kando_user_can('show_user_tickets')) {
                                $user = get_user_by('ID', $ticket->uid);
                                echo $user->display_name;
                            }
                            ?>
                        </div>

                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- پایان تیکت های ارسالی از مدیر -->
    <?php endif; ?>


    <div class="dashboard-posts-box dashboard-tickets-box">
        <div class="dashboard-posts-title-holder">
            <i class="elegant-icon icon_lifesaver"></i>
            <h5 class="dashboard-posts-title"><?= $title ?></h5>
        </div>
        <div class="dashboard-posts-list">

            <?php if ($tickets): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=show&id=' . $ticket->id)) ?>" class="dashboard-post" data-wpel-link="internal">
                        <div class="dashboard-post-date">
                            <span class="dashboard-post-date-day"><?php echo date_i18n('d', strtotime($ticket->created_at)) ?></span>
                            <span class="dashboard-post-date-month"><?php echo date_i18n('M Y', strtotime($ticket->created_at)) ?></span>
                            <span class="button button-blue badge-error-orders" style="margin-top: 4px;"><?php echo $ticket->id ?></span>
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
                                case 'closed':
                                    echo '<span class="ticket-single-status ticket-single-status-closed">'.__("closed", SAMYAR_TEXT_DOMAIN).'</span>';
                                    break;
                            }
                            ?>
                            <?php
                            if (kando_user_can('show_user_tickets')) {
                                $user = get_user_by('ID', $ticket->uid);
                                echo $user->display_name;
                            }
                            ?>
                        </div>

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
                        if (kando_user_can('show_user_tickets')) {
                            $query = [];
                            if (isset($_GET['status'])) {
                                $query['status'] = $_GET['status'];
                            }
                            $total = Ticket::count($query);
                        } else {
                            $total = Ticket::count(['uid' => get_current_user_id()]);
                        }

                        samyar_pagination($total, $limit, $paged)
                        ?>
                    </div>
                </div>


            <?php else: ?>
                <span class="services-notfound"><?php _e("No support requests have been submitted yet.", SAMYAR_TEXT_DOMAIN); ?></span>
            <?php endif; ?>
        </div>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new')) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
    </div>
</div>