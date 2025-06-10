<?php


use kandopanel\packageController;
use samyar\Notification;
use samyar\Order;
use samyar\orderController;
use samyar\Ticket;
use samyar\ticketController;
use samyar\userController;
use samyar\walletController;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$options = settingsController::getInstance();
$dashboard_image = $options->get_option('dashboard-image', SAMYAR_DIR_IMG . '/dashboard-welcome.png');
if (isset($dashboard_image) && !empty($dashboard_image) && is_numeric($dashboard_image)) {
    $dashboard_image = wp_get_attachment_url($dashboard_image);
}
?>
<?php
$order_class = new orderController();
$count = $order_class->get_orders_late_update_status(true);
if ($count):
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                برخی سفارشات بیش از 1 روز هست که وضعیت آنها تغییر نکرده است. بیایید به آنها رسیدگی کنیم، وگرنه نوبت به
                بررسی وضعیت، سفارش های جدید نخواهد رسید.
                <a style="margin-top:20px"
                   href="<?php echo esc_attr(home_url('dashboard/?action=orders&status=late_update_status')) ?>"
                   class="button button-red" data-wpel-link="internal">مشاهده
                    سفارش ها</a>
            </div>
        </div>
    </div>
<?php endif;

$userController = new userController();
if (!$userController->exist_mobile()) {
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                متاسفانه شماره همراه خود را وارد نکرده اید، لطفا قبل از هر چیز با مراجعه به پروفایل، شماره همراه خود را
                وارد و تایید نمایید.
                <br>
                <a style="margin-top:20px" href="<?php echo esc_attr(home_url('dashboard/?action=edit-profile')) ?>"
                   class="button button-red" data-wpel-link="internal">رفتن به پروفایل</a>
            </div>
        </div>
    </div>
    <?php
}

if ($userController->exist_mobile() && !$userController->approved_mobile()) {
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                متاسفانه شماره همراه خود را تایید نکرده اید، لطفا قبل از هر چیز با مراجعه به پروفایل، شماره همراه خود را
                تایید نمایید.
                <br>
                <a style="margin-top:20px" href="<?php echo esc_attr(home_url('dashboard/?action=edit-profile')) ?>"
                   class="button button-red" data-wpel-link="internal">رفتن به پروفایل</a>
            </div>
        </div>
    </div>
    <?php
}


kando_show_alerts('dashboard');
$enable_welcome = $options->get_option('enable-welcome', 1);

if ($enable_welcome === "1") {
    ?>
    <!--start welcome-->
    <div class="dashboard-welcome-box">
        <div class="dashboard-welcome-box-inner clearfix">
            <i class="dashboard-welcome-close"></i>

            <img src="<?= $dashboard_image ?>"/>
            <div class="dashboard-welcome-box-desc">
                <h4><?php echo $options->get_option('welcome-title', "به پنل کاربری <span>کندو پنل</span> خوش آمدید!"); ?></h4>
                <div class="dashboard-welcome-box-text">
                    <p><?php echo $options->get_option('welcome-content', "شما می توانید در این بخش سفارش ثبت کنید و همچنین مشکلات خودتان را از طریق تیکت به ما منتقل نمایید"); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!--end welcome-->
<?php } ?>
<?php if (!samyar_is_admin()) { ?>
    <!--start statics-->
    <div class="kt-row dashboard-boxs">
        <?php
        $package = packageController::getInstance();

        $order = orderController::getInstance();
        $order_number = $order->countOrder(get_current_user_id());

        $text = "کاربر عادی";
        $icon = "/svg/author.svg";
        $bgcolor = "#0f1c70";
        //        $giving_representation = get_the_author_meta('giving_representation', get_current_user_id());//آیا اصلا نمایندگی بهش داده شده
        //        $representation_level = get_the_author_meta('representation_level', get_current_user_id());//سطحش چنده 1- طلایی 2 - نقره ای  3- برنزی


        $giving_representation = $package->kandy_calculation_representation(get_current_user_id());//آیا اصلا نمایندگی بهش داده شده

        //می یاد بررسی میکنه ببینه بسته خریداری شده چی هست؟
        $representation_level = $package->kando_get_representation_type(get_current_user_id());

        //می یاد بررسی میکنه ببینه که آیا هنوز نمایندگیش اعتبار داره یا نه

        if ($giving_representation) {
            switch ($representation_level) {
                case '1'://طلایی
                    $text = "نمایندگی طلایی";
                    $icon = "/svg/author_golden.svg";
                    $bgcolor = "#7d4309";
                    break;
                case '2'://نقره ای
                    $text = "نمایندگی نقره ای";
                    $icon = "/svg/author_diamond.svg";
                    $bgcolor = "#08506e";
                    break;
                case '3'://برنزی
                    $text = "نمایندگی برنزی";
                    $icon = "/svg/author_bronze.svg";
                    $bgcolor = "#4b2607";
                    break;
                default://عادی
                    $text = "کاربر عادی";
                    $icon = "/svg/author.svg";
                    $bgcolor = "#0f1c70";
                    break;
            }
        }

        $representation_active = $options->get_option('representation-active', 0);
        ?>
        <?php if ($representation_active || $representation_active === "1"): ?>
            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                <div class="dashboard-box" style="background-color:<?= $bgcolor ?>">
                <span class="dashboard-box-inner" style="text-align: center;display: block;">
                    <span class="dashboard-box-text"><span><img width="56%" src="<?= SAMYAR_DIR_IMG . $icon ?>"/></span></span>
                    <h5 class="dashboard-box-title">نوع: <?= $text ?></h5>
                </span>
                </div>
            </div>
        <?php endif; ?>

        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-default">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=orders')) ?>"
                   data-wpel-link="internal">
                    <span class="dashboard-box-text"><span><?= $order_number ?></span></span>
                    <h5 class="dashboard-box-title"><?php _e("orders", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="elegant-icon icon_toolbox_alt dashboard-box-icon"></i>
                </a>
            </div>
        </div>

        <?php
        $enable_show_cost_user = $options->get_option('enable-show-cost-user', 1);
        if ($enable_show_cost_user || $enable_show_cost_user === "1"): ?>

            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                <div class="dashboard-box dashboard-box-blue">
                    <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=payments')) ?>"
                       data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?php echo samyar_get_cost_for_user() ?></span>
                </span>
                        <h5 class="dashboard-box-title"><?php _e("Amount of cost", SAMYAR_TEXT_DOMAIN); ?></h5>
                        <i class="elegant-icon icon_book_alt dashboard-box-icon"></i>
                    </a>
                </div>
            </div>

        <?php endif; ?>

        <?php

        $ticket = ticketController::getInstance();
        $ticket_number = $ticket->ticketCount(get_current_user_id());
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-green">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=tickets')) ?>"
                   data-wpel-link="internal">
                    <span class="dashboard-box-text"><span><?= $ticket_number ?></span></span>
                    <h5 class="dashboard-box-title"><?php _e("Tickets", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="elegant-icon icon_lifesaver dashboard-box-icon"></i>
                </a>
            </div>
        </div>

        <?php
        $wallet = walletController::getInstance();
        $user_credit = $wallet->getUserCredit(get_current_user_id());
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-violet">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=add-credit')) ?>"
                   data-wpel-link="internal">
				<span class="dashboard-box-text">
                    <span class="woocommerce-Price-amount amount"><?= walletController::getInstance()->getUserCreditByCurrency(get_current_user_id()) ?></span>
                </span>
                    <h5 class="dashboard-box-title"><?php _e("Balance", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="elegant-icon icon_wallet dashboard-box-icon"></i>
                </a>
                <a href="<?= esc_attr(home_url('dashboard/?action=add-credit')) ?>"
                   class="dashboard-add-credit-button elegant-icon icon_plus" data-wpel-link="internal"></a>
            </div>
        </div>
    </div>
    <!--end statics-->
<?php } ?>
<?php if (samyar_is_admin()) { ?>
    <!--start statics for admin-->
    <!-- آمار کلی-->
    <div class="kt-row dashboard-boxs">
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-default">
                <a class="dashboard-box-inner" href="<?= esc_attr(admin_url('users.php')) ?>" data-wpel-link="internal">
                    <span class="dashboard-box-text"><span><?= count_users()['total_users'] ?></span></span>
                    <h5 class="dashboard-box-title">تعداد کاربران</h5>
                    <i class="fas fa-users dashboard-box-icon"></i>
                </a>
            </div>
        </div>
        <?php
        $count_orders = Order::count();
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-blue">
                <a class="dashboard-box-inner"
                   href="<?= esc_attr(home_url('dashboard/?action=orders&section=user-orders')) ?>"
                   data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?php echo $count_orders ?>&nbsp;</span>
                </span>
                    <h5 class="dashboard-box-title">سفارشات</h5>
                    <i class="fas fa-shopping-basket dashboard-box-icon"></i>
                </a>
            </div>
        </div>
        <?php

        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-green">
                <a class="dashboard-box-inner" href="<?= esc_attr(admin_url('users.php')) ?>" data-wpel-link="internal">
				<span class="dashboard-box-text">
                    <span class="woocommerce-Price-amount amount"><?php echo number_format_i18n((int)Total_users_money_balance()) ?>&nbsp;</span><small><?php kando_get_currency_base_text() ?></small>
                </span>
                    <h5 class="dashboard-box-title">موجودی کل کاربران</h5>
                    <i class="elegant-icon icon_wallet dashboard-box-icon"></i>
                </a>
            </div>
        </div>

        <?php
        $wallet = walletController::getInstance();
        $user_credit = $wallet->getUserCredit(get_current_user_id());
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-violet">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=providers')) ?>"
                   data-wpel-link="internal">
				<span class="dashboard-box-text">
                    <span class="woocommerce-Price-amount amount"><?php echo number_format_i18n((int)Total_providers_money_balance()) ?>&nbsp;</span><small><?php kando_get_currency_base_text() ?></small>
                </span>
                    <h5 class="dashboard-box-title">موجودی کل ارائه دهندگان</h5>
                    <i class="elegant-icon icon_wallet dashboard-box-icon"></i>
                </a>
            </div>
        </div>
    </div>


    <!--آمار تیکت ها-->
    <div class="kt-row dashboard-boxs">
        <?php
        $count = Ticket::count();
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-tickets">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=tickets')) ?>"
                   data-wpel-link="internal">
                    <span class="dashboard-box-text"><span><?= $count ?></span></span>
                    <h5 class="dashboard-box-title"><?php _e("tickets", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="fal fa-ticket-alt dashboard-box-icon"></i>
                </a>
            </div>
        </div>
        <?php
        $waiting_count = Ticket::count(['status' => 'waiting']);
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-tickets">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=tickets')) ?>"
                   data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?= $waiting_count ?>&nbsp;</span>
                </span>
                    <h5 class="dashboard-box-title"><?php _e("response", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="fal fa-mailbox dashboard-box-icon"></i>
                </a>
            </div>
        </div>
        <?php
        $answered_count = Ticket::count(['status' => 'answered']);
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-tickets">
                <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=tickets')) ?>"
                   data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?= $answered_count ?>&nbsp;</span>
                </span>
                    <h5 class="dashboard-box-title"><?php _e("answered", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="fal fa-mailbox dashboard-box-icon"></i>
                </a>
            </div>
        </div>
        <?php
        $closed_count = Ticket::count(['status' => 'closed']);
        ?>
        <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
            <div class="dashboard-box dashboard-box-tickets">
                <a class="dashboard-box-inner"
                   href="<?= esc_attr(home_url('dashboard/?action=tickets&section=closed')) ?>"
                   data-wpel-link="internal">
                    <span class="dashboard-box-text"><span><?= $closed_count ?></span></span>
                    <h5 class="dashboard-box-title"><?php _e("closed", SAMYAR_TEXT_DOMAIN); ?></h5>
                    <i class="fal fa-ticket dashboard-box-icon"></i>
                </a>
            </div>
        </div>

    </div>


    <?php do_action('kando_dashboard_stats') ?>
    <!--end statics for admin-->
<?php } ?>
    <!-- آمار سفارشات -->
    <style>

    </style>
    <hr style="color: #e9e9e9;border-width: 1px;margin-top: 12px;">
    <h3 style="text-align: center;margin: 20px 0 20px 0;"><?php _e("Order statistics", SAMYAR_TEXT_DOMAIN); ?></h3>
    <div class="kt-row dashboard-boxs">
        <?php
        $status_array = order_status_array();
        //		$number_error_orders = get_count_orders('error');
        if (!empty($status_array)) {
            $orders_counts = get_user_order_counts();


            foreach ($status_array as $row_status) {
                if (!samyar_is_admin() && ($row_status === 'error' || $row_status === 'late_update_status' || $row_status === 'awaiting_action' || $row_status === 'custom_order')) {
                    continue;
                }

                switch ($row_status) {
                    case 'all':
                        $icon = "far fa-list-ul";
                        $color = "button-light";
                        break;
                    case 'processing':
                        $icon = "far fa-chart-line";
                        $color = "button-light";
                        break;
                    case 'awaiting':
                    case 'pending':
                        $icon = "far fa-clock";
                        $color = "button-blue";
                        break;
                    case 'inprogress':
                        $icon = "far fa-spinner";
                        $color = "button-default";
                        break;
                    case 'completed':
                        $icon = "far fa-check";
                        $color = "button-green";
                        break;
                    case 'partial':
                        $icon = "far fa-hourglass-half";
                        $color = "button-orange";
                        break;
                    case 'canceled':
                        $icon = "far fa-times-circle";
                        $color = "button-aqua";
                        break;
                    case 'refunded':
                        $icon = "far fa-undo-alt";
                        $color = "button-red";
                        break;
                    case 'error':
                        $icon = "far fa-exclamation-triangle";
                        $color = "button-red";
                        break;
                    case 'awaiting_action':
                        $icon = "far fa-bell-exclamation";
                        $color = "button-red";
                        break;
                    case 'awaiting_cancel':
                        $icon = "far fa-alarm-snooze";
                        $color = "button-red";
                        break;
                    case 'late_update_status':
                        $icon = "far fa-calendar-exclamation";
                        $color = "button-red";
                        break;
                    case 'custom_order':
                        $icon = "far fa-hand-point-up";
                        $color = "button-red";
                        break;
                    default:
                        $icon = "";
                        break;
                }
                ?>
                <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                    <div class="dashboard-box dashboard-box-orders <?php if ($row_status === "error" || $row_status === "custom_order"): ?>red_border<?php endif ?> <?php if ($row_status === "custom_order" && get_count_orders($row_status) > 0): ?>blink_me<?php endif ?> <?php if ($row_status === "error" && get_count_orders($row_status) > 0): ?>blink_me<?php endif ?> <?php if ($row_status === "awaiting_action"): ?>yellow_border<?php endif ?> <?php if ($row_status === "awaiting_action" && get_count_orders($row_status) > 0): ?>blink_me<?php endif ?>">
                        <a class="dashboard-box-inner"
                           href="<?= home_url('dashboard/?action=orders&status=' . $row_status) ?>"
                           data-wpel-link="internal">
                            <div class="d-flex align-items-center">
              <span class="stamp stamp-1 stamp-md bg-danger-gradient text-white mr-3">
              <i class="<?= $icon ?>"></i>
            </span>
                                <div class="d-flex order-lg-2 ml-auto">
                                    <div class="ml-2 d-lg-block text-right">
                                        <h4 class="m-0  number"><?= $orders_counts[$row_status] ?></h4>
                                        <small class="text-muted "><?= samyar_order_status_title($row_status) ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php }
        } ?>


    </div>
    <!-- اتمام آمار سفارشات -->

    <hr style="color: #e9e9e9;border-width: 1px;margin-top: 12px;">
    <h3 style="text-align: center;margin: 20px 0 20px 0;"><h3
                style="text-align: center;margin: 20px 0 20px 0;"><?php _e("Statistics of refill orders", SAMYAR_TEXT_DOMAIN); ?></h3>
    </h3>
    <div class="kt-row dashboard-boxs">
        <?php
        $status_array = refill_order_status_array();
        //		$number_error_orders = get_count_orders('error');
        if (!empty($status_array)) {
            foreach ($status_array as $row_status) {
                if (!samyar_is_admin() && ($row_status === 'error')) {
                    continue;
                }

                switch ($row_status) {
                    case 'all':
                        $icon = "far fa-list-ul";
                        $color = "button-light";
                        break;
                    case 'pending':
                        $icon = "far fa-clock";
                        $color = "button-blue";
                        break;
                    case 'inprogress':
                        $icon = "far fa-spinner";
                        $color = "button-default";
                        break;
                    case 'completed':
                        $icon = "far fa-check";
                        $color = "button-green";
                        break;
                    case 'rejected':
                        $icon = "far fa-times-circle";
                        $color = "button-red";
                        break;
                    case 'error':
                        $icon = "far fa-exclamation-triangle";
                        $color = "button-red";
                        break;
                    case 'awaiting_action':
                        $icon = "far fa-bell-exclamation";
                        $color = "button-red";
                        break;
                    default:
                        $icon = "";
                        break;
                }
                ?>
                <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                    <div class="dashboard-box dashboard-box-orders <?php if ($row_status === "error"): ?>red_border<?php endif ?> <?php if ($row_status === "error" && get_count_refill_orders($row_status) > 0): ?>blink_me<?php endif ?> <?php if ($row_status === "awaiting_action"): ?>yellow_border<?php endif ?> <?php if ($row_status === "awaiting_action" && get_count_refill_orders($row_status) > 0): ?>blink_me<?php endif ?>">
                        <a class="dashboard-box-inner"
                           href="<?= home_url('dashboard/?action=refill&status=' . $row_status) ?>"
                           data-wpel-link="internal">
                            <div class="d-flex align-items-center">
              <span class="stamp stamp-1 stamp-md bg-danger-gradient text-white mr-3">
              <i class="<?= $icon ?>"></i>
            </span>
                                <div class="d-flex order-lg-2 ml-auto">
                                    <div class="ml-2 d-lg-block text-right">
                                        <h4 class="m-0  number"><?= get_count_refill_orders($row_status) ?></h4>
                                        <small class="text-muted "><?= samyar_order_status_title($row_status) ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php }
        } ?>


    </div>

    <!-- اتمام آمار سفارشات پر کردن مجدد -->
<?php if (samyar_is_admin()) { ?>
    <hr style="color: #e9e9e9;border-width: 1px;margin-top: 12px;">
    <h3 style="text-align: center;margin: 20px 0 20px 0;">آمار نمایندگی ها</h3>
    <h5 style="text-align: center;margin: 20px 0 20px 0;font-size: 11px">تعداد نمایندگی های فعال را می توانید در این
        قسمت ببینید</h5>
    <div class="kt-row dashboard-boxs">
        <?php
        $level_array = [
            '1' => ['text' => "نمایندگی طلایی", 'icon' => "/svg/author_golden.svg", 'link' => admin_url('users.php?representation=1')],
            '2' => ['text' => "نمایندگی نقره ای", 'icon' => "/svg/author_diamond.svg", 'link' => admin_url('users.php?representation=2')],
            '3' => ['text' => "نمایندگی برنزی", 'icon' => "/svg/author_bronze.svg", 'link' => admin_url('users.php?representation=3')],
        ];

        if (!empty($level_array)) {
            foreach ($level_array as $level => $val) {
                ?>
                <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                    <div class="dashboard-box dashboard-box-orders">
                        <a class="dashboard-box-inner" href="<?= $val['link'] ?>" data-wpel-link="internal">
                            <div class="d-flex align-items-center">
              <span class="stamp stamp-1 stamp-md bg-danger-gradient text-white mr-3">
              <img width="35px" style="margin-top: 7px;" src="<?= SAMYAR_DIR_IMG . $val['icon'] ?>"/>
            </span>
                                <div class="d-flex order-lg-2 ml-auto">
                                    <div class="ml-2 d-lg-block text-right">
                                        <h4 class="m-0  number"><?= kando_count_representation($level) ?></h4>
                                        <small class="text-muted "><?= $val['text'] ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
<?php } ?>


<?php //include('services/fovirite-service.php'); ?>


    <hr style="color: #e9e9e9;border-width: 1px;margin-bottom: 12px;">

<?php include 'tickets.php'; ?>
<?php include 'notifications2.php'; ?>