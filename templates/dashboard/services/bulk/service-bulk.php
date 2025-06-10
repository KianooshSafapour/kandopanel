<?php
//اینجا می یایم مشخص می کنیم که اگر سرویس دستی و توسط خود مدیر اضافه شده
//نرخش چی باشه
use samyar\Provider;
$options      = settingsController::getInstance();
if ($service->api_provider_id === "0") {// اگر دستی باشه
    $service_list[$service->id] = [calculate_service_price($service->id)];
    $base_currency = $service->manual_currency;
} else {//اگر با api اضافه شده باشه
    $provider = Provider::find($service->api_provider_id);
    if ($provider->status === "1") {
        $service_list[$service->id] = [calculate_service_price($service->id)];
    }
    $base_currency = $provider->base_currency;
}

?>
<tr id="service-<?php echo esc_attr($service->id) ?>">
    <td data-title="شناسه">
        <?php echo esc_attr($service->id) ?>
    </td>
    <td data-title="نام">
        <?php echo esc_attr($service->name) ?>
    </td>

    <td data-title="توضیحات">
        <?php if ($service->description): ?>
            <span class="kt-modal-button button button-default samyar-show-description-service" data-modal="show-description"
                  data-desc="" data-id="<?php echo esc_attr($service->id) ?>">توضیحات</span>

        <?php
        else:
            echo "-";
        endif; ?>
    </td>
    <?php if (kando_user_can('show_bulk_update_price')): ?>
        <td data-title="قیمت اصلی">
            <?php
            echo calculate_service_orginal_price($service->id, true,true);
            ?>
        </td>
    <?php endif; ?>
    <?php if (kando_user_can('show_bulk_update_price')): ?>
        <td data-title="نوع">
            <?php if ($service->add_type === "api"):
                $provider = Provider::find($service->api_provider_id);
                ?>
                <li><?= esc_attr($provider->name) ?>(<?= $provider->id ?>) <br> <span style="font-size:11px"> شناسه سرویس در ارائه دهنده : <b><?= esc_attr($service->api_service_id) ?></b></span></li>
            <?php else: ?>
                <li> دستی</li>
            <?php endif; ?>
        </td>
    <?php endif; ?>

    <td data-title="قیمت فروش فعلی">
        <?php echo kando_number_format_currency(calculate_service_price($service->id),true) ?>

        <?php
        $show_price_representation = $options->get_option('show-price-representation', 0);
        $show_price_representation_type = $options->get_option('show-price-representation-type', 1);
        ?>
        <?php if (($show_price_representation == 1 || $show_price_representation === "1") && $service->disable_representation === "0"): ?>
            <?php if ($show_price_representation_type == 1 || $show_price_representation_type === "1"): ?>
                <div class="custom-popup"><i class="fal fa-info-circle" style="color: #8d81e6;margin-right: 7px;"></i>
                    <span class="popuptext" id="myPopup">
                                        قیمت نمایندگی ها: <br>
                                        <span style="padding-right:10px;float: right;text-align: right;">
                                        نمایندگی طلایی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 1),true) ?> ) <br>
                                        نمایندگی نقره ای: (<?= kando_number_format_currency(calculate_representation_price($service->id, 2),true) ?> )<br>
                                        نمایندگی برنزی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 3),true) ?> ) <br>
                                        </span>

                                    </span>
                </div>
            <?php else: ?>

                <ul class="order-details">
                    <li style="text-align: center;">قیمت نمایندگی ها</li>
                    <li style="font-size: 11px;">نمایندگی طلایی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 1),true) ?> )</li>
                    <li style="font-size: 11px;">نمایندگی نقره ای: (<?= kando_number_format_currency(calculate_representation_price($service->id, 2),true) ?> )</li>
                    <li style="font-size: 11px;">نمایندگی برنزی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 3),true) ?> )</li>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

    </td>
    <td data-title="قیمت دلخواه">
        <div class="kt-col-xs-12 kt-col-md-12">

                <input type="number" name="price[<?php echo esc_attr($service->id)?>]" value="<?php echo esc_attr($service->price)?>"placeholder="قیمت" />

        </div>
    </td>




</tr>