<tr id="order-<?php echo esc_attr($package->id) ?>">

    <td data-title="شناسه">
        <?php echo esc_attr($package->id) ?>
    </td>
    <td data-title="بسته">
        <?php
        switch ($package->package_id) {
            case 1:
                $title = "نمایندگی طلایی";
                break;
            case 2:
                $title = "نمایندگی نقره ای";
                break;
            case 3:
                $title = "نمایندگی برنزی";
                break;
        }
        ?>

        <?php echo $title; ?>


    </td>
    <td data-title="مبلغ">
        <?php echo number_format_i18n(esc_attr((int)$package->amount)) ?> <?php kando_get_currency_base_text() ?>
    </td>
    <td data-title="اطلاعات کاربر">
        <?php
        $user = get_user_by('id', $package->uid);
        echo $user->display_name;
        echo "<br>";
        echo get_user_meta($user->ID, 'mobile', true);
        ?>
    </td>
    <td data-title="تاریخ شروع">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format.' '.$time_format, strtotime($package->start_date)) ?>
    </td>
    <td data-title="تاریخ پایان">
        <?php echo date_i18n($date_format.' '.$time_format, strtotime($package->end_date)) ?>
    </td>

    <td data-title="وضعیت">
        <?php
        global $wpdb;
        $sql = "SELECT * FROM `{$wpdb->prefix}samyar_package_order` WHERE id = {$package->id} AND NOW() between `start_date` and `end_date` ";
        $get_packages = $wpdb->get_results($sql);

        if ($get_packages) {
            echo '<span class="button button-green badge-error-orders">دارای اعتبار</span>';
        } else {
            echo '<span class="button button-default badge-error-orders">اتمام شده</span>';
        }

        ?>
    </td>
    <td data-title="عملیات ها">
                            <span class="button button-red btn-small kt-modal-button kando-show-info" data-modal="info" data-order="<?php echo esc_attr($package->id) ?>" data-type="package_payments"
                                  data-tooltip="تاریخچه تراکنش ها"><i class="fal fa-envelope-open-dollar"></i></span>
    </td>
</tr>