<?php

use samyar\Service;

$options = settingsController::getInstance();

?>
<tr id="order-<?php echo esc_attr($refill_order->id) ?>">
    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($refill_order->id) ?>
    </td>
    <td data-title="<?php _e("Date", SAMYAR_TEXT_DOMAIN); ?> ">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format . ' ' . $time_format, strtotime($refill_order->created_at)) ?>
    </td>
    <td data-title="<?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($refill_order->order_id) ?>


    </td>
    <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $service = Service::find($refill_order->service_id);
        ?>

        <ul class="order-details">
            <?php if ($service): ?>
                <li><?php _e("Service:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr($service->id) ?>
                    &nbsp;-&nbsp;<?php echo esc_attr($service->name) ?></li>
            <?php endif; ?>


            <li><?php _e("Link:", SAMYAR_TEXT_DOMAIN); ?><?php
                if (filter_var($refill_order->link, FILTER_VALIDATE_URL)) {
                    echo '<a class="CopyToClipBoard2" href="' . $refill_order->link . '" target="_blank"><i class="fal fa-copy"></i>&nbsp;' . samyar_truncate_string($refill_order->link, 35) . '</a>';
                } else {
                    echo samyar_truncate_string($refill_order->link, 35);
                }

                ?>

            </li>


        </ul>
    </td>
    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (kando_is_normal_user() && in_array($refill_order->status, ['fail', 'error'])) {
            $refill_order->status = 'pending';
        }
        ?>
        <span style="display: inline-block;"
              class="button order-status <?= samyar_status_color($refill_order->status) ?>">
                                <?php echo samyar_order_status_title(esc_attr($refill_order->status)); ?>
                            </span>
    </td>
    <?php if (kando_user_can('show_order_user_info')) { ?>
        <td data-title="<?php _e("User information", SAMYAR_TEXT_DOMAIN); ?>">
            <?php
            $user = get_user_by('id', $refill_order->uid);
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
            <?php echo ($refill_order->api_refill_id == 0 || $refill_order->api_refill_id == -1) ? "" : $refill_order->api_refill_id ?>
        </td>
        <td data-title="<?php _e("API response", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo esc_attr($refill_order->note) ?>
        </td>
    <?php } ?>
    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">


        <?php if (kando_user_can('edit_order')) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=refill&section=edit&id=' . esc_attr($refill_order->id))) ?>">
                                    <span class="button button-default btn-small"
                                          data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>">
                                        <i class="fal fa-edit"></i>
                                    </span>
            </a>
        <?php } ?>
        <?php if (kando_user_can('edit_order')) { ?>
            <?php
            $status = ["pending", "error"];
            if (in_array($refill_order->status, $status, true)) {
                ?>
                <span class="button button-aqua btn-small delete-refill-order"
                      data-id="<?php echo esc_attr($refill_order->id) ?>"
                      data-tooltip="<?php _e("remove", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
            <?php } ?>
        <?php } ?>
        <?php if (kando_user_can('show_order_approve')) { ?>
            <?php if ($refill_order->status === "error"): ?>
                <span class="button button-red btn-small resend-refill-order"
                      data-id="<?php echo esc_attr($refill_order->id) ?>"
                      data-tooltip="<?php _e("Resend", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-redo"></i></span>
            <?php endif; ?>
        <?php } ?>

        <!--
        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new&order-id=' . esc_attr($refill_order->id))) ?>"><span class="button button-violet btn-small"
                                                                                                                                  data-tooltip="ارسال تیکت مربوط به این سفارش"><i class="fal fa-ticket"></i></span></a>
        -->
    </td>

</tr>
