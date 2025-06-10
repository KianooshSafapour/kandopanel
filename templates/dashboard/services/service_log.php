<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$service_id = $_GET['id'];
$service = \samyar\Service::find($service_id);
?>

<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <?php kando_show_alerts('credit'); ?>
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="fal fa-clipboard-list"></i>
                <h5 class="dashboard-posts-title"><?php _e('Service Report "', SAMYAR_TEXT_DOMAIN); ?><?= $service->name ?>"</h5>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row">

                    <div class="column kt-col-md-12">
                        <!-- آمار سفارشات -->
                        <style>
                            @-webkit-keyframes pulse-1 {
                                0% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(115, 103, 240, 0.4);
                                }
                                70% {
                                    -webkit-box-shadow: 0 0 0 10px rgba(115, 103, 240, 0);
                                }
                                100% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(115, 103, 240, 0);
                                }
                            }

                            @-webkit-keyframes pulse-2 {
                                0% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(255, 159, 67, 0.4);
                                }
                                70% {
                                    -webkit-box-shadow: 0 0 0 10px rgba(255, 159, 67, 0);
                                }
                                100% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(255, 159, 67, 0);
                                }
                            }

                            @-webkit-keyframes pulse-3 {
                                0% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(234, 84, 85, 0.4);
                                }
                                70% {
                                    -webkit-box-shadow: 0 0 0 10px rgba(234, 84, 85, 0);
                                }
                                100% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(234, 84, 85, 0);
                                }
                            }

                            @-webkit-keyframes pulse-4 {
                                0% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(40, 199, 111, 0.4);
                                }
                                70% {
                                    -webkit-box-shadow: 0 0 0 10px rgba(40, 199, 111, 0);
                                }
                                100% {
                                    -webkit-box-shadow: 0 0 0 0 rgba(40, 199, 111, 0);
                                }
                            }

                            .align-items-center {
                                -ms-flex-align: center !important;
                                align-items: center !important;
                                display: flex;
                                justify-content: center;
                            }

                            .d-flex {
                                display: -ms-flexbox !important;
                                display: flex !important;
                            }

                            .dashboard-box-orders .stamp-1 {
                                background: rgba(115, 103, 240, .15) !important;
                                border-radius: 100%;
                                border: 1px solid rgba(115, 103, 240, .25);
                                animation: 2s pulse-1 infinite;
                            }

                            .dashboard-box-orders .stamp {
                                color: #6b6b6b;
                                font-size: 30px;
                                background: #fff;
                            }

                            .dashboard-box-orders .stamp-md {
                                min-width: 3.5rem !important;
                                height: 3.5rem !important;
                                line-height: 3.8rem !important;
                            }

                            .stamp {
                                color: #fff;
                                background: #868e96;
                                display: inline-block;
                                min-width: 2rem;
                                height: 2rem;
                                padding: 0 .25rem;
                                line-height: 2rem;
                                text-align: center;
                                border-radius: 3px;
                                font-weight: 600;
                            }

                            .text-white {
                                color: #fff !important;
                            }

                            .ml-auto, .mx-auto {
                                margin-right: auto !important;
                            }

                            .d-flex {
                                display: -ms-flexbox !important;
                                display: flex !important;
                            }

                            .order-lg-2 {
                                -ms-flex-order: 2;
                                order: 2;
                            }

                            .text-right {
                                text-align: left !important;
                            }

                            .ml-2, .mx-2 {
                                margin-right: 0.5rem !important;
                            }

                            .d-lg-block {
                                display: block !important;
                            }

                            .dashboard-box-orders .number {
                                font-size: 20px;
                                font-weight: 500;
                            }

                            .text-right {
                                text-align: left !important;
                            }

                            .m-0 {
                                margin: 0 !important;
                            }

                            .text-muted {
                                color: #9aa0ac !important;
                            }

                            small, .small {
                                font-size: 87.5%;
                                font-weight: 400;
                            }

                            small {
                                font-size: 80%;
                            }

                            .dashboard-box-orders .stamp-1 .feather, .dashboard-box-orders .stamp-1 .far {
                                color: #7367F0 !important;
                            }

                            .dashboard-box-orders {
                                border: 1px solid #e1e1e1;
                                border-radius: .2rem;
                                -webkit-box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .1);
                                box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .1);
                                -webkit-transition: all .3s ease-in-out;
                                -o-transition: all .3s ease-in-out;
                                -moz-transition: all .3s ease-in-out;
                                transition: all .3s ease-in-out;
                                position: relative;
                                width: 100%;
                            }

                            .blink_me {
                                animation: blinker 1s linear infinite;
                            }

                            @keyframes blinker {
                                50% {
                                    opacity: 0;
                                }
                            }

                            .red_border {
                                border: 1px solid #cc0909;
                            }

                            .yellow_border {
                                border: 1px solid #ffd04a;
                            }
                        </style>
                        <div class="kt-row dashboard-boxs">
                            <?php
                            $status_array = order_status_array();
                            if (!empty($status_array)) {
                                foreach ($status_array as $row_status) {
                                    if (kando_is_normal_user() && ($row_status === 'error' || $row_status === 'late_update_status' || $row_status === 'awaiting_action')) {
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
                                        default:
                                            $icon = "";
                                            break;
                                    }
                                    ?>
                                    <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                        <div class="dashboard-box dashboard-box-orders <?php if ($row_status === "error"): ?>red_border<?php endif ?> <?php if ($row_status === "error" && get_count_orders($row_status) > 0): ?>blink_me<?php endif ?> <?php if ($row_status === "awaiting_action"): ?>yellow_border<?php endif ?> <?php if ($row_status === "awaiting_action" && get_count_orders($row_status) > 0): ?>blink_me<?php endif ?>">
                    <span class="dashboard-box-inner">
                        <div class="d-flex align-items-center">
              <span class="stamp stamp-1 stamp-md bg-danger-gradient text-white mr-3">
              <i class="<?= $icon ?>"></i>
            </span>
                            <div class="d-flex order-lg-2 ml-left">
                                <div class="ml-2 d-lg-block text-right">
                                    <h4 class="m-0 text-right number"><?= get_count_service_orders($row_status, $service_id) ?></h4>
                                    <small class="text-muted "><?php _e(samyar_order_status_title($row_status), SAMYAR_TEXT_DOMAIN); ?></small>
                                </div>
                            </div>
                        </div>
                    </span>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <!-- اتمام آمار سفارشات -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

