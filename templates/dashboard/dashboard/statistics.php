<?php
use kandopanel\packageController;
use samyar\Order;
use samyar\orderController;
use samyar\priceController;
use samyar\Ticket;
use samyar\ticketController;
use samyar\walletController;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="elegant-icon icon_piechart"></i>
                <h5 class="dashboard-posts-title"><?php _e("Statistics", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row dashboard-boxs">
                    <div class="kt-row dashboard-boxs">

                        <?php if (!samyar_is_admin()) { ?>
                            <!--start statics-->

                            <?php
                            $package = packageController::getInstance();

                            $order = orderController::getInstance();
                            $order_number = $order->countOrder(get_current_user_id());

                            $text = __("Regular User", SAMYAR_TEXT_DOMAIN);
                            $icon = "/svg/author.svg";
                            $bgcolor = "#0f1c70";

                            $giving_representation = $package->kando_user_has_package(get_current_user_id());//آیا اصلا نمایندگی بهش داده شده

                            //می یاد بررسی میکنه ببینه بسته خریداری شده چی هست؟
                            $representation_level = $package->kando_get_package_type(get_current_user_id());

                            //می یاد بررسی میکنه ببینه که آیا هنوز نمایندگیش اعتبار داره یا نه

                            if ($giving_representation) {
                                switch ($representation_level) {
                                    case '1'://طلایی
                                        $text = __("Golden Package", SAMYAR_TEXT_DOMAIN);
                                        $icon = "/svg/author_golden.svg";
                                        $bgcolor = "#7d4309";
                                        break;
                                    case '2'://نقره ای
                                        $text = __("Silver Package", SAMYAR_TEXT_DOMAIN);
                                        $icon = "/svg/author_diamond.svg";
                                        $bgcolor = "#08506e";
                                        break;
                                    case '3'://برنزی
                                        $text = __("Bronze Package", SAMYAR_TEXT_DOMAIN);
                                        $icon = "/svg/author_bronze.svg";
                                        $bgcolor = "#4b2607";
                                        break;
                                    default://عادی
                                        $text = __("Regular User", SAMYAR_TEXT_DOMAIN);
                                        $icon = "/svg/author.svg";
                                        $bgcolor = "#0f1c70";
                                        break;
                                }
                            }

                            $representation_active = kando_get_option('representation-active', 0);
                            ?>
                            <?php if ($representation_active || $representation_active === "1"): ?>
                                <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                    <div class="dashboard-box" style="background-color:<?= $bgcolor ?>">
                <span class="dashboard-box-inner" style="text-align: center;display: block;">
                    <span class="dashboard-box-text"><span><img width="56%" src="<?= SAMYAR_DIR_IMG . $icon ?>"/></span></span>
                    <h5 class="dashboard-box-title"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>: <?= $text ?></h5>
                </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                <div class="dashboard-box dashboard-box-default">
                                    <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=orders')) ?>"
                                       data-wpel-link="internal">
                                        <span class="dashboard-box-text"><span><?= $order_number ?></span></span>
                                        <h5 class="dashboard-box-title"><?php _e("Orders", SAMYAR_TEXT_DOMAIN); ?></h5>
                                        <i class="elegant-icon icon_toolbox_alt dashboard-box-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <?php
                            $enable_show_cost_user = kando_get_option('enable-show-cost-user', 1);
                            if ($enable_show_cost_user || $enable_show_cost_user === "1"): ?>

                                <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                    <div class="dashboard-box dashboard-box-blue">
                                        <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=payments')) ?>"
                                           data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?php echo samyar_get_cost_for_user() ?></span>
                </span>
                                            <h5 class="dashboard-box-title"><?php _e("Amount of Cost", SAMYAR_TEXT_DOMAIN); ?></h5>
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

                            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                <div class="dashboard-box dashboard-box-violet">
                                    <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=add-credit')) ?>"
                                       data-wpel-link="internal">
				<span class="dashboard-box-text">
                    <span class="woocommerce-Price-amount amount"><?= walletController::getInstance()->getUserCredit(get_current_user_id())['price_for_show_formatted'] ?></span>
                </span>
                                        <h5 class="dashboard-box-title"><?php _e("Balance", SAMYAR_TEXT_DOMAIN); ?></h5>
                                        <i class="elegant-icon icon_wallet dashboard-box-icon"></i>
                                    </a>
                                    <a href="<?= esc_attr(home_url('dashboard/?action=add-credit')) ?>"
                                       class="dashboard-add-credit-button elegant-icon icon_plus" data-wpel-link="internal"></a>
                                </div>
                            </div>

                            <!--end statics-->
                        <?php } ?>
                        <?php if (samyar_is_admin()) { ?>
                            <!--start statics for admin-->
                            <!-- آمار کلی-->

                            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                <div class="dashboard-box dashboard-box-default">
                                    <a class="dashboard-box-inner" href="<?= esc_attr(admin_url('users.php')) ?>" data-wpel-link="internal">
                                        <span class="dashboard-box-text"><span><?= count_users()['total_users'] ?></span></span>
                                        <h5 class="dashboard-box-title"><?php _e("Number of Users", SAMYAR_TEXT_DOMAIN); ?></h5>
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
                                       href="<?= esc_attr(home_url('dashboard/?action=orders§ion=user-orders')) ?>"
                                       data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?php echo $count_orders ?> </span>
                </span>
                                        <h5 class="dashboard-box-title"><?php _e("Orders", SAMYAR_TEXT_DOMAIN); ?></h5>
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
                    <span class="woocommerce-Price-amount amount"><?php echo priceController::kandoFormatPrice(Total_users_money_balance())['price_for_show_formatted'] ?> </span>
                </span>
                                        <h5 class="dashboard-box-title"><?php _e("Total Users Balance", SAMYAR_TEXT_DOMAIN); ?></h5>
                                        <i class="elegant-icon icon_wallet dashboard-box-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                <div class="dashboard-box dashboard-box-violet">
                                    <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=providers')) ?>"
                                       data-wpel-link="internal">
				<span class="dashboard-box-text">
                    <span class="woocommerce-Price-amount amount"><?php echo priceController::kandoFormatPrice((int)Total_providers_money_balance())['price_for_show_formatted']?> </span>
                </span>
                                        <h5 class="dashboard-box-title"><?php _e("Total Providers Balance", SAMYAR_TEXT_DOMAIN); ?></h5>
                                        <i class="elegant-icon icon_wallet dashboard-box-icon"></i>
                                    </a>
                                </div>
                            </div>



                            <!--آمار تیکت ها-->

                            <?php
                            $count = Ticket::count();
                            ?>
                            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                <div class="dashboard-box dashboard-box-tickets">
                                    <a class="dashboard-box-inner" href="<?= esc_attr(home_url('dashboard/?action=tickets')) ?>"
                                       data-wpel-link="internal">
                                        <span class="dashboard-box-text"><span><?= $count ?></span></span>
                                        <h5 class="dashboard-box-title"><?php _e("Tickets", SAMYAR_TEXT_DOMAIN); ?></h5>
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
                    <span><?= $waiting_count ?> </span>
                </span>
                                        <h5 class="dashboard-box-title"><?php _e("Response", SAMYAR_TEXT_DOMAIN); ?></h5>
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
                    <span><?= $answered_count ?> </span>
                </span>
                                        <h5 class="dashboard-box-title"><?php _e("Answered", SAMYAR_TEXT_DOMAIN); ?></h5>
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
                                       href="<?= esc_attr(home_url('dashboard/?action=tickets§ion=closed')) ?>"
                                       data-wpel-link="internal">
                                        <span class="dashboard-box-text"><span><?= $closed_count ?></span></span>
                                        <h5 class="dashboard-box-title"><?php _e("Closed", SAMYAR_TEXT_DOMAIN); ?></h5>
                                        <i class="fal fa-ticket dashboard-box-icon"></i>
                                    </a>
                                </div>
                            </div>




                            <?php do_action('kando_dashboard_stats') ?>
                            <!--end statics for admin-->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>