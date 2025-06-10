<tr id="order-<?php echo esc_attr($package->id) ?>">

    <td data-title="<?php _e('ID', SAMYAR_TEXT_DOMAIN) ?>">
        <?php echo esc_attr($package->id) ?>
    </td>
    <td data-title="<?php _e('Package', SAMYAR_TEXT_DOMAIN) ?>">
        <?php
        switch ($package->package_id) {
            case 1:
                $title = __("Golden Representative", SAMYAR_TEXT_DOMAIN);
                break;
            case 2:
                $title = __("Silver Representative", SAMYAR_TEXT_DOMAIN);
                break;
            case 3:
                $title = __("Bronze Representative", SAMYAR_TEXT_DOMAIN);
                break;
        }
        ?>

        <?php echo $title; ?>
    </td>
    <td data-title="<?php _e('Amount', SAMYAR_TEXT_DOMAIN) ?>">
        <?php echo number_format_i18n(esc_attr((int)$package->amount)) ?> <?php kando_get_currency_base_text() ?>
    </td>
    <td data-title="<?php _e('User Information', SAMYAR_TEXT_DOMAIN) ?>">
        <?php
        $user = get_user_by('id', $package->uid);
        echo $user->display_name;
        echo "<br>";
        echo get_user_meta($user->ID, 'mobile', true);
        ?>
    </td>
    <td data-title="<?php _e('Start Date', SAMYAR_TEXT_DOMAIN) ?>">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format . ' ' . $time_format, strtotime($package->start_date));
        ?>
    </td>
    <td data-title="<?php _e('End Date', SAMYAR_TEXT_DOMAIN) ?>">
        <?php echo date_i18n($date_format . ' ' . $time_format, strtotime($package->end_date)) ?>
    </td>

    <td data-title="<?php _e('Status', SAMYAR_TEXT_DOMAIN) ?>">
        <?php
        global $wpdb;
        $sql = "SELECT * FROM `{$wpdb->prefix}samyar_package_order` WHERE id = {$package->id} AND NOW() between `start_date` and `end_date` ";
        $get_packages = $wpdb->get_results($sql);

        if ($get_packages) {
            echo '<span class="button button-green badge-error-orders">' . __("Valid", SAMYAR_TEXT_DOMAIN) . '</span>';
        } else {
            echo '<span class="button button-default badge-error-orders">' . __("Expired", SAMYAR_TEXT_DOMAIN) . '</span>';
        }
        ?>
    </td>
    <td data-title="<?php _e('Actions', SAMYAR_TEXT_DOMAIN) ?>">
        <span class="button button-red btn-small kt-modal-button kando-show-info" data-modal="info" data-order="<?php echo esc_attr($package->id) ?>" data-type="package_payments"
              data-tooltip="<?php _e('Transaction History', SAMYAR_TEXT_DOMAIN) ?>"><i class="fal fa-envelope-open-dollar"></i></span>
    </td>
</tr>