<tr id="category-<?php echo esc_attr($update->id) ?>">
    <td data-title="<?php _e('ID', SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($update->service_id) ?>
    </td>
    <td data-title="<?php _e('Service', SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($update->service_name) ?>
    </td>
    <td data-title="<?php _e('Date', SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format . ' ' . $time_format, strtotime($update->date)) ?>
    </td>
    <td data-title="<?php _e('Category', SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (!is_null($update->cate_id) || !empty($update->cate_id)) {
            $cate_info = samyar\Category::find($update->cate_id);
            if ($cate_info) {
                echo $cate_info->name;
            } else {
                echo '-';
            }
        } else {
            echo '-';
        }
        ?>
    </td>
    <td data-title="<?php _e('Title', SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        switch ($update->update_type) {
            case 'disable':
                $update_title = __('Service disabled', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-default badge-error-orders">' . $update_title . '</span>';
                break;
            case 'enable':
                $update_title = __('Service enabled', SAMYAR_TEXT_DOMAIN);
                echo '<span class="button button-green badge-error-orders">' . $update_title . '</span>';
                break;
            case 'increase_amount':
                if ($update->info) {
                    $update_title = sprintf(
                        __("Rate increased from %s to %s", SAMYAR_TEXT_DOMAIN),
                        number_format($update->info['price_before']),
                        number_format($update->info['price_after'])
                    );
                    echo '<span class="button button-blue badge-error-orders">' . $update_title . '</span>';
                }

                break;
            case 'decrease_amount':
                if ($update->info) {
                    $update_title = sprintf(
                        __("Rate decreased from %s to %s", SAMYAR_TEXT_DOMAIN),
                        number_format($update->info['price_before']),
                        number_format($update->info['price_after'])
                    );
                    echo '<span class="button button-orange badge-error-orders">' . $update_title . '</span>';
                }

                break;
        }
        ?>
    </td>
    <?php if (samyar_user_is_admin(get_current_user_id())): ?>
        <td data-title="<?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?>">
            <span class="button button-aqua btn-small delete-update" data-id="<?php echo esc_attr($update->id) ?>"
                  data-tooltip="<?php _e('Delete', SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
        </td>
    <?php endif; ?>
</tr>
