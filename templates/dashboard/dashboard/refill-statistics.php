<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="elegant-icon icon_piechart"></i>
                <h5 class="dashboard-posts-title"><?php _e("Statistics of refill orders", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row dashboard-boxs">
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
                                                <div class="d-flex order-lg-2 ml-left">
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
                </div>
            </div>
        </div>
    </div>
</div>
