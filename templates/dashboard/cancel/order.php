<?php

use samyar\Service;

$options = settingsController::getInstance();

?>
<tr id="order-<?php echo esc_attr($cancel_order->id) ?>">
    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($cancel_order->id) ?>
    </td>
    <td data-title="<?php _e("Date", SAMYAR_TEXT_DOMAIN); ?> ">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format . ' ' . $time_format, strtotime($cancel_order->created_at)) ?>
    </td>
    <td data-title="<?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($cancel_order->order_id) ?>
    </td>
    <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $service = Service::find($cancel_order->service_id);
        ?>

        <ul class="order-details">
            <?php if ($service): ?>
                <li><?php _e("Service:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr($service->id) ?>
                    &nbsp;-&nbsp;<?php echo esc_attr($service->name) ?></li>
            <?php endif; ?>


            <li><?php _e("Link:", SAMYAR_TEXT_DOMAIN); ?><?php
                if (filter_var($cancel_order->link, FILTER_VALIDATE_URL)) {
                    echo '<a class="CopyToClipBoard2" href="' . $cancel_order->link . '" target="_blank"><i class="fal fa-copy"></i>&nbsp;' . samyar_truncate_string($cancel_order->link, 35) . '</a>';
                } else {
                    echo samyar_truncate_string($cancel_order->link, 35);
                }

                ?>

            </li>


        </ul>
    </td>
    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (kando_is_normal_user() && $cancel_order->status == 'error') {
            $cancel_order->status = 'pending';
        }
        ?>
        <span style="display: inline-block;"
              class="button order-status <?= samyar_status_color($cancel_order->status) ?>">
                                <?php echo samyar_order_status_title(esc_attr($cancel_order->status)); ?>
                            </span>
    </td>
    <?php if (kando_user_can('show_order_user_info')) { ?>
        <td data-title="<?php _e("User information", SAMYAR_TEXT_DOMAIN); ?>">
            <?php
            $user = get_user_by('id', $cancel_order->uid);
            if ($user) {
                echo $user->display_name;
                echo "<br>";
                echo get_user_meta($user->ID, 'mobile', true);
            } else {
                _e("does not exist", SAMYAR_TEXT_DOMAIN);
            }

            ?>
        </td>
    <?php } ?>
    <?php if (kando_user_can('show_order_provider_id')) { ?>
        <td data-title="<?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo ($cancel_order->api_order_id == 0 || $cancel_order->api_order_id == -1) ? "" : $cancel_order->api_order_id ?>
        </td>
        <td data-title="<?php _e("API response", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo esc_attr($cancel_order->note) ?>
        </td>
    <?php } ?>
    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">


        <?php if (kando_user_can('edit_order')) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=cancel&section=edit&id=' . esc_attr($cancel_order->id))) ?>">
                                    <span class="button button-default btn-small"
                                          data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>">
                                        <i class="fal fa-edit"></i>
                                    </span>
            </a>
        <?php } ?>
        <?php if (kando_user_can('edit_order')) { ?>
            <?php
            $status = ["pending", "error"];
            if (in_array($cancel_order->status, $status, true)) {
                ?>
                <span class="button button-aqua btn-small delete-cancel-order"
                      data-id="<?php echo esc_attr($cancel_order->id) ?>"
                      data-tooltip="<?php _e("remove", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
            <?php } ?>
        <?php } ?>
        <?php if (kando_user_can('show_order_approve')) { ?>
            <?php if ($cancel_order->status === "error"): ?>
                <span class="button button-red btn-small resend-cancel-order"
                      data-id="<?php echo esc_attr($cancel_order->id) ?>"
                      data-tooltip="<?php _e("Resend", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-redo"></i></span>
            <?php endif; ?>
        <?php } ?>

        <!--
        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new&order-id=' . esc_attr($cancel_order->id))) ?>"><span class="button button-violet btn-small"
                                                                                                                                  data-tooltip="ارسال تیکت مربوط به این سفارش"><i class="fal fa-ticket"></i></span></a>
        -->
    </td>

</tr>
