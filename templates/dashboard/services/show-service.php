<?php
//اینجا می یایم مشخص می کنیم که اگر سرویس دستی و توسط خود مدیر اضافه شده
//نرخش چی باشه
use samyar\Provider;
use samyar\Smeta;

?>
<tr id="service-<?php echo esc_attr($service->id) ?>">
    <?php if (kando_user_can('edit_service')): ?>
        <td data-title="<?php _e("Select", SAMYAR_TEXT_DOMAIN); ?>">
            <input type="checkbox" class="kando-cb-checkbox" value="1"
                   id="cb-select-<?php echo esc_attr($service->id) ?>"
                   name="cb-select-<?php echo esc_attr($service->id) ?>">
            <label class="kando-cb-label" for="cb-select-<?php echo esc_attr($service->id) ?>"></label>
        </td>
    <?php endif; ?>

    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($service->id) ?>
    </td>
    <td data-title="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr(serviceController::getInstance()->get_title($stranslates,$service)) ?>
    </td>

    <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if ($service->description): ?>
            <span class="kt-modal-button button button-default samyar-show-description-service"
                  data-modal="show-description"
                  data-desc="<?=serviceController::getInstance()->get_description($stranslates,$service)?>"
                  data-id="<?php echo esc_attr($service->id) ?>"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span>

        <?php
        else:
            echo "-";
        endif; ?>
    </td>

    <?php if (kando_user_can('show_service_type')): ?>
        <td data-title="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>">
            <?php if ($service->provider): ?>
                <li><?= esc_attr($service->provider['name']) ?>(<?= $service->provider['id'] ?>)
                    <?php if (kando_user_can('show_service_type') && $service->api_service_id): ?>
                        <?php echo '<br><b>' . esc_attr($service->api_service_id) . ' <span data-tooltip="' . __("Service ID in Provider", SAMYAR_TEXT_DOMAIN) . '"><i class="fal fa-info-circle"></i></span> </b>' ?>
                    <?php endif; ?>
                </li>
            <?php else: ?>
                <li><?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?></li>
            <?php endif; ?>
        </td>
    <?php endif; ?>

    <td data-title="<?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $provider_currency = $service->provider['currency'];
        if(!$provider_currency){
            $provider_currency = !is_null($service->currency)?$service->currency:"";
        }
        ?>
        <?php echo kandoConvertCurrency(calculate_service_price($service->price,get_user_service_price($service->id, $use_price_list),$service->metas,$service->disable_representation,$has_package,$package_type,$service->gold_price,$service->silver_price,$service->bronze_price),$provider_currency, $user_currency_data, $IRT_rate) ?>


        <?php if (kando_user_can('show_original_price') && $service->original_price) { ?>
            <br>
            <b>
                <?php echo kandoConvertCurrency($service->original_price, $provider_currency, $user_currency_data, $IRT_rate); ?>
                <span data-tooltip="<?php
                echo sprintf(
                    __('Price at the provider (%s)', SAMYAR_TEXT_DOMAIN),
                    esc_html($service->original_price . ' ' . $provider_currency)
                );
                ?>">
        <i class="fal fa-info-circle"></i>
    </span>
            </b>
        <?php } ?>
        <?php

        if ($representation_active):
            if (($show_price_representation == 1 || $show_price_representation === "1") && $service->disable_representation === "0"):
                if ($show_price_representation_type == 1 || $show_price_representation_type === "1"): ?>
                <div class="custom-popup"><i class="fal fa-info-circle"
                                             style="color: #8d81e6;margin-right: 7px;"></i>
                    <span class="popuptext" id="myPopup">
                                        <?php _e("Package Prices:", SAMYAR_TEXT_DOMAIN); ?> <br>
                                        <span style="padding-right:10px;float: right;text-align: right;">
                                        <?php _e("Golden Package:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->gold_price ?> ) <br>
                                        <?php _e("Silver Package:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->silver_price ?> )<br>
                                        <?php _e("Bronze Package:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->bronze_price ?> ) <br>
                                        </span>
                                    </span>
                </div>
            <?php else: ?>
                <ul class="order-details">
                    <li style="text-align: center;"><?php _e("Package Prices", SAMYAR_TEXT_DOMAIN); ?></li>
                    <li style="font-size: 11px;"><?php _e("Golden Package:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->gold_price ?> )</li>
                    <li style="font-size: 11px;"><?php _e("Silver Package:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->silver_price ?> )</li>
                    <li style="font-size: 11px;"><?php _e("Bronze Package:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->bronze_price ?> )</li>
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
            <?php echo kando_get_service_ave_time($service->id) ?>
        </td>
    <?php } ?>
    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (kando_user_can('edit_service')) {
            ?>
            <label class="custom-switch">
                <input type="checkbox" name="disable-service" data-type="service"
                       data-id="<?php echo esc_attr($service->id) ?>" class="ajax-switch custom-switch-input"
                       data-toggle="collapse" aria-expanded="false" <?php echo checked($service->status, 1); ?>>
                <span class="custom-switch-indicator"></span>
            </label>
            <?php
        } else {
            switch ($service->status) {
                case 0:
                    echo "<span style='color: #f58'>" . __("Inactive", SAMYAR_TEXT_DOMAIN) . "</span>";
                    break;
                case 1:
                    echo "<span style='color: #7ccc77'>" . __("Active", SAMYAR_TEXT_DOMAIN) . "</span>";
                    break;
            }
        }

        ?>
    </td>

    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if (is_user_logged_in() || $enable_order_btn_notloginuser == 1) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new&cat_id=' . esc_attr($cate_id) . '&service-id=' . esc_attr($service->id))) ?>"
               rel="nofollow"><span
                        class="button button-default btn-small kt-modal-button samyar-show-order-form"
                        data-modal="send-package" data-service="<?php echo esc_attr($service->id) ?>"
                        data-cat="<?php echo esc_attr($cate_id) ?>" data-type="fast-order"
                        data-tooltip="<?php _e("Order", SAMYAR_TEXT_DOMAIN); ?>"><i
                            class="fal fa-shopping-cart"></i></span></a>
        <?php } ?>
        <?php if (kando_user_can('edit_service')) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=edit&id=' . esc_attr($service->id))) ?>"><span
                        class="button button-default btn-small" data-tooltip="ویرایش"><i class="fal fa-edit"></i></span></a>
        <?php } ?>
        <?php if (kando_user_can('show_service_log')) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=log&id=' . esc_attr($service->id))) ?>"><span
                        class="button button-default btn-small" data-tooltip="گزارش سرویس"><i
                            class="fal fa-clipboard-list"></i></span></a>
        <?php } ?>
        <?php if (kando_user_can('delete_service')) { ?>

            <span class="button button-aqua btn-small delete-service" data-id="<?php echo esc_attr($service->id) ?>"
                  data-tooltip="حذف"><i
                        class="fal fa-trash"></i></span>
        <?php } ?>


    </td>

</tr>