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
            <div class="dashboard-posts-list">

                <div class="kt-row">


                    <!--start statics for admin-->
                    <!-- آمار کلی-->

                    <!--آمار تیکت ها-->

                    <?php
                    $data = [];
                    if (kando_user_can('show_user_tickets')) {

                    } else {
                        $data = ['uid' => get_current_user_id()];
                    }

                    $count = Ticket::count($data);
                    ?>
                    <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3 pt13">
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
                    if (kando_user_can('show_user_tickets')) {
                        $data = ['status' => 'waiting'];
                    } else {
                        $data = ['uid' => get_current_user_id(), 'status' => 'waiting'];
                    }
                    $waiting_count = Ticket::count($data);
                    ?>
                    <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3 pt13">
                        <div class="dashboard-box dashboard-box-tickets">
                            <a class="dashboard-box-inner"
                               href="<?= esc_attr(home_url('dashboard/?action=tickets&status=waiting')) ?>"
                               data-wpel-link="internal">
                <span class="dashboard-box-text">
                    <span><?= $waiting_count ?>&nbsp;</span>
                </span>
                                <h5 class="dashboard-box-title"><?php _e("Waiting for reply", SAMYAR_TEXT_DOMAIN); ?></h5>
                                <i class="fal fa-mailbox dashboard-box-icon"></i>
                            </a>
                        </div>
                    </div>
                    <?php
                    if (kando_user_can('show_user_tickets')) {
                        $data = ['status' => 'answered'];
                    } else {
                        $data = ['uid' => get_current_user_id(), 'status' => 'answered'];
                    }
                    $answered_count = Ticket::count($data);
                    ?>
                    <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3 pt13">
                        <div class="dashboard-box dashboard-box-tickets">
                            <a class="dashboard-box-inner"
                               href="<?= esc_attr(home_url('dashboard/?action=tickets&status=answered')) ?>"
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
                    if (kando_user_can('show_user_tickets')) {
                        $data = ['status' => 'closed'];
                    } else {
                        $data = ['uid' => get_current_user_id(), 'status' => 'closed'];
                    }
                    $closed_count = Ticket::count($data);
                    ?>
                    <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3 pt13">
                        <div class="dashboard-box dashboard-box-tickets">
                            <a class="dashboard-box-inner"
                               href="<?= esc_attr(home_url('dashboard/?action=tickets&status=closed')) ?>"
                               data-wpel-link="internal">
                                <span class="dashboard-box-text"><span><?= $closed_count ?></span></span>
                                <h5 class="dashboard-box-title"><?php _e("closed", SAMYAR_TEXT_DOMAIN); ?></h5>
                                <i class="fal fa-ticket dashboard-box-icon"></i>
                            </a>
                        </div>
                    </div>

                    <?php
                    if (kando_user_can('show_user_tickets')) {
                        $data = ['status' => 'in_progress'];
                    } else {
                        $data = ['uid' => get_current_user_id(), 'status' => 'in_progress'];
                    }
                    $closed_count = Ticket::count($data);
                    ?>
                    <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3 pt13">
                        <div class="dashboard-box dashboard-box-tickets">
                            <a class="dashboard-box-inner"
                               href="<?= esc_attr(home_url('dashboard/?action=tickets&status=in_progress')) ?>"
                               data-wpel-link="internal">
                                <span class="dashboard-box-text"><span><?= $closed_count ?></span></span>
                                <h5 class="dashboard-box-title"><?php _e("In progress", SAMYAR_TEXT_DOMAIN); ?></h5>
                                <i class="fal fa-ticket dashboard-box-icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
