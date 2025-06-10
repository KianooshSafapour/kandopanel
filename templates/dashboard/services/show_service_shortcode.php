<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use kandopanel\currencyController;
use samyar\priceController;

$options = settingsController::getInstance();
$enable_average_time = kando_get_option('enable-average-time', 1);

$stranslates = \samyar\serviceController::getInstance()->get_translates();

// استفاده از حافظه موقت برای جلوگیری از فراخوانی مکرر تنظیمات
//$singlePriceSettings = wp_cache_get('singlePriceSettings', 'single_service_shortcode_cache');
//
//if (false === $singlePriceSettings) {
    $settings = [
        'enable_average_time' => kando_get_option('enable-average-time', 1),
        'enable_order_btn_notloginuser' => kando_get_option('enable-order-btn-notloginuser', 1),
        'representation_active' => kando_get_option('representation-active', 0),
        'show_price_representation' => kando_get_option('show-price-representation', 0),
        'show_price_representation_type' => kando_get_option('show-price-representation-type', 1),
        'user_currency_data' => currencyController::getInstance()->getCurrencyByCode(currencyController::getInstance()->getUserCurrency()),
        'base_currency_data' => currencyController::getInstance()->getCurrencyByCode(get_option('base_currency', "IRT")),
        'user_prices' => [],
    ];
//
//    // ذخیره تنظیمات در حافظه موقت به مدت 12 ساعت
//    wp_cache_set('singlePriceSettings', $singlePriceSettings, 'single_service_shortcode_cache', HOUR_IN_SECONDS);
//}

if (isset($atts['id'])) {

    $service_id = esc_attr($atts['id']);
    $service = \samyar\Service::find($service_id);
    if ($service) {



                 $user_id = get_current_user_id(); // شناسه کاربر وارد شده
                 $prices = priceController::calculatePricesBatch([$service], $user_id);
                 $OriginalPrices = priceController::calculateOriginalPricesBatch([$service]);


        $provider_currency = $service->provider_currency ?? $service->currency ?? '';
        if ($provider_currency === 'IRT') {
            $provider_currency_data = $singlePriceSettings['IRT_currency_data'];
        } else {
            $provider_currency_data = ['currency_code' => "USD", 'value_currency' => 1];
        }


        ?>
        <div class="dashboard-tickets-box" style="margin-top: 10px">


        <table class="shop_table shop_table_responsive">
            <thead>
            <tr>
                <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <?php if ($singlePriceSettings['enable_average_time'] == 1) { ?>
                    <th>
                        <span class="nobr"><?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?></span>
                    </th>
                <?php } ?>
                <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>

                <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>

            </tr>
            </thead>

            <tbody>

            <!--start service-->
<tr id="service-<?php echo esc_attr($service->id); ?>">
    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($service->id); ?>
    </td>
    <td data-title="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr(serviceController::getInstance()->get_title($stranslates,$service)); ?>
    </td>

    <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if ($service->description):
        $description = kando_filter_description(serviceController::getInstance()->get_description($stranslates,$service));
        ?>
            <span class="kt-modal-button button button-default samyar-show-description-service"
                  data-modal="show-description"
                  data-desc="<?= esc_html($description) ?>"
                  data-id="<?php echo esc_attr($service->id); ?>"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>


                                <td data-title="<?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo $prices[$service->id]['price_for_show_formatted']; ?>
                                    <?php if (kando_user_can('show_original_price') && $service->original_price): ?>
                                        <br>
                                        <b>
                                            <?php echo $OriginalPrices[$service->id]['price_for_show_formatted']; ?>
                                            <span data-tooltip="<?php echo esc_attr(__('Price in the provider', SAMYAR_TEXT_DOMAIN) . ' (' . $service->original_price . ' ' . $provider_currency . ')'); ?>">
        <i class="fal fa-info-circle"></i>
    </span>
                                        </b>
                                    <?php endif; ?>
                                    <?php if ($settings['representation_active'] && $settings['show_price_representation'] && $service->disable_representation === "0"): ?>
                                        <?php if ($settings['show_price_representation_type'] == 1): ?>
                                            <div class="custom-popup"><i class="fal fa-info-circle"
                                                                         style="color: #8d81e6;margin-right: 7px;"></i>
                                                <span class="popuptext" id="myPopup">
    <?php _e('Package prices:', SAMYAR_TEXT_DOMAIN); ?> <br>
    <span style="padding-right:10px; float: right; text-align: right;">
        <?php _e('Golden Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $service->gold_price; ?>) <br>
        <?php _e('Silver Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $service->silver_price; ?>) <br>
        <?php _e('Bronze Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $service->bronze_price; ?>) <br>
    </span>
</span>
                                            </div>
                                        <?php else: ?>
                                            <ul class="order-details">
                                                <li style="text-align: center;"><?php _e('Package prices', SAMYAR_TEXT_DOMAIN); ?></li>
                                                <li style="font-size: 11px;"><?php _e('Golden Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $service->gold_price; ?>)</li>
                                                <li style="font-size: 11px;"><?php _e('Silver Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $service->silver_price; ?>)</li>
                                                <li style="font-size: 11px;"><?php _e('Bronze Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $service->bronze_price; ?>)</li>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>

    <td data-title="<?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($service->max); ?>/<?php echo esc_attr($service->min); ?>
    </td>

    <?php if ($singlePriceSettings['enable_average_time'] == 1): ?>
        <td data-title="<?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo kando_get_service_ave_time($service->id); ?>
        </td>
    <?php endif; ?>

    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if (kando_user_can('edit_service')): ?>
            <label class="custom-switch">
                <input type="checkbox" name="disable-service" data-type="service"
                       data-id="<?php echo esc_attr($service->id); ?>" class="ajax-switch custom-switch-input"
                       data-toggle="collapse" aria-expanded="false" <?php echo checked($service->status, 1); ?>>
                <span class="custom-switch-indicator"></span>
            </label>
        <?php else: ?>
            <?php switch ($service->status):
                case 0: ?>
                    <span style='color: #f58'><?php _e("Inactive", SAMYAR_TEXT_DOMAIN); ?></span>
                    <?php break; ?>
                <?php case 1: ?>
                    <span style='color: #7ccc77'><?php _e("Active", SAMYAR_TEXT_DOMAIN); ?></span>
                    <?php break; ?>
                <?php endswitch; ?>
        <?php endif; ?>
    </td>

    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">
        <?php if (is_user_logged_in() || $singlePriceSettings['enable_order_btn_notloginuser'] == 1): ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new&cat_id=' . esc_attr($service->cate_id) . '&service-id=' . esc_attr($service->id))); ?>"
               rel="nofollow"><span
                    class="button button-default kt-modal-button samyar-show-order-form"
                    data-modal="send-package" data-service="<?php echo esc_attr($service->id); ?>"
                    data-cat="<?php echo esc_attr($service->cate_id); ?>" data-type="fast-order"
                    ><?php _e("Order", SAMYAR_TEXT_DOMAIN); ?></span></a>
        <?php endif; ?>



    </td>
</tr>

            <!--end service-->
            </tbody>
        </table>


        <script>
            jQuery(document).ready(function ($) {
                $(document).on("mouseover", ".custom-popup", function () {
                    $(this).find('.popuptext').css("visibility", "visible");
                    $(this).find('.popuptext').css("-webkit-animation", "fadeIn 1s");
                    $(this).find('.popuptext').css("animation", "fadeIn 1s");
                });

                $(".custom-popup").mouseout(function () {
                    $(this).find('.popuptext').css("visibility", "hidden");
                    $(this).find('.popuptext').css("-webkit-animation", "fadeOut 1s");
                    $(this).find('.popuptext').css("animation", "fadeOut 1s");
                });
            });

        </script>
        <?php

    } else {
        ?>
        <span class="services-notfound"><?php _e("There is no service", SAMYAR_TEXT_DOMAIN); ?></span>
    <?php
    }
}