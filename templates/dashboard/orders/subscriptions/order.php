<?php

use samyar\Service;

$options = settingsController::getInstance();
?>
<tr id="order-<?php echo esc_attr($order->id) ?>">

    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($order->id) ?>
    </td>
    <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $service = Service::find($order->service_id);
        ?>
        <ul class="order-details">
            <?php if ($service): ?>
                <li><?php _e("Service", SAMYAR_TEXT_DOMAIN); ?>: <?php echo esc_attr($service->id) ?>
                    - <?php echo esc_attr($service->name) ?></li>
            <?php endif; ?>
            <?php if (kando_user_can('show_order_provider_info')): ?>
                <?php if ($order->api_provider_id !== "0" && $provider): ?>
                    <li><?php _e("Provider", SAMYAR_TEXT_DOMAIN); ?>: <?php echo esc_attr($provider->name) ?>
                        (<?= $provider->id ?>)
                    </li>
                <?php else: ?>
                    <li><?php _e("Provider", SAMYAR_TEXT_DOMAIN); ?>: <?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?></li>
                <?php endif; ?>

                <li>
                    <?php _e("Add Order Type", SAMYAR_TEXT_DOMAIN); ?>:
                    <?php
                    if ($order->type === 'api') {
                        $site_url = get_order_meta($order->id, 'site_url', true);
                        $your_domain = get_user_meta($order->uid, "your_domain", true);
                        if ($site_url && !empty($site_url)) {
                            $site_url = '<span class="button button-green badge-error-orders">' . $site_url . '</span>';
                        } else if ($your_domain && !empty($your_domain)) {
                            $site_url = '<span class="button button-green badge-error-orders">' . $your_domain . '</span>';
                        } else {
                            $site_url = "";
                        }
                        echo ' <span class="button button-orange badge-error-orders">API</span>' . $site_url;
                    } else {
                        echo ' <span class="button button-blue badge-error-orders">' . __("Site", SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </li>
            <?php endif; ?>

            <li><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?>: <?php echo esc_attr($order->username) ?>
            <li><?php _e("Quantity", SAMYAR_TEXT_DOMAIN); ?>: <?= $order->sub_min ?>/<?= $order->sub_max ?>
            <li><?php _e("Posts", SAMYAR_TEXT_DOMAIN); ?>:
                <strong>
                    <?php
                    $real_posts = ($order->sub_response_posts > 0) ? $order->sub_response_posts : 0;
                    ?>
                    <a href="<?= esc_attr(home_url('dashboard/?action=subscriptions§ion=childs&main-id=' . esc_attr($order->id))) ?>"><?= $real_posts ?></a>
                    / <?= ($order->sub_posts == -1) ? "∞" : $order->sub_posts ?>
                </strong>
            </li>
            <?php
            if (!empty($order->sub_expiry) && strtotime($order->sub_expiry) != "") {
                $database_date = $order->sub_expiry;
                $target_timezone = 'Asia/Tehran';
                $expiry = date_i18n('Y-m-d H:i:s', strtotime($database_date) + (get_option('gmt_offset') * HOUR_IN_SECONDS), false, true, $target_timezone);
                $expiry = date("Y-m-d", strtotime($expiry));
            } else {
                $expiry = "";
            }
            ?>
            <li><?php _e("Delay", SAMYAR_TEXT_DOMAIN); ?>:
                <strong><?= ($order->sub_delay == "" || $order->sub_delay == 0) ? __("No Delay", SAMYAR_TEXT_DOMAIN) : $order->sub_delay . " " . __("Minutes", SAMYAR_TEXT_DOMAIN) ?></strong>
            </li>
            <li><?php _e("Expiry", SAMYAR_TEXT_DOMAIN); ?>: <strong><?= $expiry ?></strong></li>

            <?php if ($order->user_note && kando_user_can('show_order_provider_info')): ?>
                <li><?php _e("User Message", SAMYAR_TEXT_DOMAIN); ?>:
                    <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                            data-tooltip="<?php _e("Click to view orders", SAMYAR_TEXT_DOMAIN); ?>" data-type="order"
                            data-info="user-note"
                            data-order="<?= $order->id ?>"><?php _e("View Orders", SAMYAR_TEXT_DOMAIN); ?>
                    </button>
                </li>
            <?php endif; ?>

            <?php if ($order->is_drip_feed || $service->type === "subscriptions") { ?>
                <!--                <li>-->
                <!--                    --><?php
//                    echo '<a href="' . esc_attr(home_url('dashboard/?action=subscriptions§ion=subscription&main-id=' . esc_attr($order->id))) . '" class="button button-blue badge-error-orders" data-tooltip="' . __("Click to view orders", SAMYAR_TEXT_DOMAIN) . '" data-type="order" data-info="comments" data-order="' . $order->id . '">' . __("Click", SAMYAR_TEXT_DOMAIN) . '</a>';
//                    ?>
                <!--                </li>-->
            <?php } ?>

        </ul>
    </td>

    <?php if (kando_user_can('show_order_user_info')): ?>
        <td data-title="<?php _e("User Information", SAMYAR_TEXT_DOMAIN); ?>">
            <?php
            $user = get_user_by('id', $order->uid);
            if ($user) {
                echo $user->display_name;
                echo "<br>";
                echo get_user_meta($user->ID, 'mobile', true);
            } else {
                echo __("Not Available", SAMYAR_TEXT_DOMAIN);
            }
            ?>
        </td>
        <td data-title="<?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo ($order->api_order_id == 0 || $order->api_order_id == -1) ? "" : $order->api_order_id ?>
        </td>
        <td data-title="<?php _e("API Response", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo esc_attr($order->note) ?>
        </td>
    <?php endif; ?>
    <td data-title="<?php _e("Creation Date", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo date_i18n('d M Y, H:i', strtotime($order->created_at)) ?>
    </td>
    <td data-title="<?php _e("Update Date", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo date_i18n('d M Y, H:i', strtotime($order->update_at)) ?>
    </td>
    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (kando_is_normal_user() && in_array($order->status, ['fail', 'error'])) {
            $order->status = 'processing';
        }
        ?>
        <span style="display: inline-block;" class="button order-status <?= samyar_status_color($order->status) ?>">
            <?php echo samyar_order_status_title(esc_attr($order->status)); ?>
        </span>
        <?php if (kando_is_normal_user() && ($order->status === "awaiting")): ?>
            <span class="button button-red repayment-order kt-modal-button" data-modal="repayment"
                  data-id="<?php echo esc_attr($order->id) ?>"><?php _e("Repay", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php endif; ?>
    </td>
    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if ($order->status === "awaiting_cancel") { ?>
            <?php
            $delay_time_order = (int)kando_get_option('delay-time-order', 10);
            $date2 = new DateTime(date("Y-m-d H:i:s", strtotime("+$delay_time_order minute", strtotime($order->created_at))));
            ?>
            <span class="wating-timer" id="wating-timer-<?= $order->id ?>"></span>
            <script type="text/javascript">
                kando_count_time("<?php echo $date2->format('Y m d H:i:s') ?>", "wating-timer-<?=$order->id?>", "<?php _e("Time remaining to cancel the order", SAMYAR_TEXT_DOMAIN); ?>",)
            </script>
            <span class="button button-red btn-small cancel-order" data-id="<?php echo esc_attr($order->id) ?>"
                  data-tooltip="<?php _e("Cancel", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-ban"></i></span>
            <span class="button button-aqua btn-small fast-send-order" data-id="<?php echo esc_attr($order->id) ?>"
                  data-tooltip="<?php _e("Send Now", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-share-square"></i></span>
        <?php } ?>

        <?php if (kando_user_can('edit_order')): ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=orders§ion=edit&id=' . esc_attr($order->id))) ?>">
                <span class="button button-default btn-small" data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>">
                    <i class="fal fa-edit"></i>
                </span>
            </a>
            <?php
            $status = ["pending", "error", "awaiting"];
            if (in_array($order->status, $status, true)) {
                ?>
                <span class="button button-aqua btn-small delete-order" data-id="<?php echo esc_attr($order->id) ?>"
                      data-tooltip="<?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
            <?php } ?>
            <?php if ($order->status === "error"): ?>
                <span class="button button-red btn-small resend-order" data-id="<?php echo esc_attr($order->id) ?>"
                      data-tooltip="<?php _e("Resend", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-redo"></i></span>
            <?php endif; ?>

            <?php if ((int)$order->api_order_id > 0 && (int)$order->api_provider_id > 0): ?>
                <span class="button button-blue btn-small kt-modal-button kando-show-info" data-modal="info"
                      data-order="<?php echo esc_attr($order->id) ?>" data-type="status"
                      data-tooltip="<?php _e("Check order status with provider", SAMYAR_TEXT_DOMAIN); ?>"><i
                            class="fas fa-info-circle"></i></span>
            <?php endif; ?>
        <?php endif; ?>
        <span class="button button-red btn-small kt-modal-button kando-show-info" data-modal="info"
              data-order="<?php echo esc_attr($order->id) ?>" data-type="payments"
              data-tooltip="<?php _e("Transaction History", SAMYAR_TEXT_DOMAIN); ?>"><i
                    class="fal fa-envelope-open-dollar"></i></span>

        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets§ion=new&order-id=' . esc_attr($order->id))) ?>"><span
                    class="button button-violet btn-small"
                    data-tooltip="<?php _e("Send a ticket related to this order", SAMYAR_TEXT_DOMAIN); ?>"><i
                        class="fal fa-ticket"></i></span></a>
    </td>
</tr>