<?php
//اینجا می یایم مشخص می کنیم که اگر سرویس دستی و توسط خود مدیر اضافه شده
//نرخش چی باشه
use samyar\Provider;
use samyar\Smeta;

$options = settingsController::getInstance();
//if ($service->api_provider_id === "0") {// اگر دستی باشه
//    $service_list[$service->id] = [calculate_service_price($service->id)];
//    $base_currency = $service->manual_currency;
//} else {//اگر با api اضافه شده باشه
//    $provider = Provider::find($service->api_provider_id);
//    if ($provider->status === "1") {
//        $service_list[$service->id] = [calculate_service_price($service->id)];
//    }
//    $base_currency = $provider->base_currency;
//}

$enable_average_time = $options->get_option('enable-average-time', 1);
$enable_order_btn_notloginuser = $options->get_option('enable-order-btn-notloginuser', 1);
?>
<tr id="service-<?php echo esc_attr($service->id) ?>">
    <?php if (kando_user_can('edit_service')): ?>
        <td data-title="<?php _e("Select", SAMYAR_TEXT_DOMAIN); ?>">
            <input type="checkbox" class="kando-cb-checkbox" value="1" id="cb-select-<?php echo esc_attr($service->id) ?>" name="cb-select-<?php echo esc_attr($service->id) ?>">
            <label class="kando-cb-label" for="cb-select-<?php echo esc_attr($service->id) ?>"></label>
        </td>
    <?php endif; ?>

    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($service->id) ?>
    </td>
    <td data-title="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($service->name) ?>
    </td>

    <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if ($service->description): ?>
            <span class="kt-modal-button button button-default samyar-show-description-service" data-modal="show-description"
                  data-desc="" data-id="<?php echo esc_attr($service->id) ?>"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span>

        <?php
        else:
            echo "-";
        endif; ?>
    </td>
    <?php if (kando_user_can('show_original_price')): ?>
        <td data-title="قیمت اصلی">
            <?php
            echo calculate_service_orginal_price($service->id, true, true);
            ?>
        </td>
    <?php endif; ?>
    <?php if (kando_user_can('show_service_type')): ?>
        <td data-title="نوع">
            <?php if ($service->add_type === "api"): ?>
                <li><?= esc_attr($service->provider->name) ?>(<?= $service->provider->id ?>) <br> <span
                            style="font-size:11px"> شناسه سرویس در ارائه دهنده : <b><?= esc_attr($service->api_service_id) ?></b></span></li>
            <?php else: ?>
                <li> دستی</li>
            <?php endif; ?>
        </td>
    <?php endif; ?>

    <td data-title="<?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo kandoConvertCurrency($service->service_price) ?>
        <?php //echo kando_number_format_currency($service->service_price, true) ?>

        <?php
        $representation_active = !empty($options->get_option('representation-active')) ? $options->get_option('representation-active') : 0;
        if ($representation_active):
            $show_price_representation = $options->get_option('show-price-representation', 0);
            $show_price_representation_type = $options->get_option('show-price-representation-type', 1);
            ?>
            <?php if (($show_price_representation == 1 || $show_price_representation === "1") && $service->disable_representation === "0"): ?>
            <?php if ($show_price_representation_type == 1 || $show_price_representation_type === "1"): ?>
                <div class="custom-popup"><i class="fal fa-info-circle" style="color: #8d81e6;margin-right: 7px;"></i>
                    <span class="popuptext" id="myPopup">
                                        قیمت نمایندگی ها: <br>
                                        <span style="padding-right:10px;float: right;text-align: right;">
                                        نمایندگی طلایی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 1), true) ?> ) <br>
                                        نمایندگی نقره ای: (<?= kando_number_format_currency(calculate_representation_price($service->id, 2), true) ?> )<br>
                                        نمایندگی برنزی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 3), true) ?> ) <br>
                                        </span>

                                    </span>
                </div>
            <?php else: ?>
                <ul class="order-details">
                    <li style="text-align: center;">قیمت نمایندگی ها</li>
                    <li style="font-size: 11px;">نمایندگی طلایی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 1), true) ?> )</li>
                    <li style="font-size: 11px;">نمایندگی نقره ای: (<?= kando_number_format_currency(calculate_representation_price($service->id, 2), true) ?> )</li>
                    <li style="font-size: 11px;">نمایندگی برنزی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 3), true) ?> )</li>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>

    </td>
    <td data-title="<?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($service->max) ?>/<?php echo esc_attr($service->min) ?>
    </td>
    <?php if ($enable_average_time == 1) { ?>
        <td data-title="<?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo get_average_time($service->id) ?>
        </td>
    <?php } ?>
    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (kando_user_can('edit_service')) {
            ?>
            <label class="custom-switch">
                <input type="checkbox" name="disable-service" data-type="service" data-id="<?php echo esc_attr($service->id) ?>" class="ajax-switch custom-switch-input"
                       data-toggle="collapse" aria-expanded="false" <?php echo checked($service->status, 1); ?>>
                <span class="custom-switch-indicator"></span>
            </label>
            <?php
        } else {
            switch ($service->status) {
                case 0:
                    echo "<span style='color: #f58'>".__("Inactive", SAMYAR_TEXT_DOMAIN)."</span>";
                    break;
                case 1:
                    echo "<span style='color: #7ccc77'>".__("Active", SAMYAR_TEXT_DOMAIN)."</span>";
                    break;
            }
        }

        ?>
    </td>

    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if (is_user_logged_in() || $enable_order_btn_notloginuser == 1) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new&cat_id=' . esc_attr($service->cate_id) . '&service-id=' . esc_attr($service->id))) ?>" rel="nofollow"><span
                        class="button button-default btn-small kt-modal-button samyar-show-order-form" data-modal="send-package" data-service="<?php echo esc_attr($service->id) ?>"
                        data-cat="<?php echo esc_attr($service->cate_id) ?>" data-type="fast-order" data-tooltip="<?php _e("Order", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-shopping-cart"></i></span></a>
        <?php } ?>
        <?php if (kando_user_can('edit_service')){ ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=edit&id=' . esc_attr($service->id))) ?>"><span
                    class="button button-default btn-small" data-tooltip="ویرایش"><i class="fal fa-edit"></i></span></a>
        <?php } ?>
        <?php if (kando_user_can('show_service_log')){ ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=log&id=' . esc_attr($service->id))) ?>"><span
                    class="button button-default btn-small" data-tooltip="گزارش سرویس"><i class="fal fa-clipboard-list"></i></span></a>
        <?php } ?>
        <?php if (kando_user_can('delete_service')){ ?>

        <span class="button button-aqua btn-small delete-service" data-id="<?php echo esc_attr($service->id) ?>" data-tooltip="حذف"><i
                    class="fal fa-trash"></i></span>
        <?php } ?>


    </td>

</tr>