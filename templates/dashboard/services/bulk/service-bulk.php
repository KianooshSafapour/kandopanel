<?php
/** @var TYPE_NAME $service */

use samyar\priceController;

?>

<form method="POST" class="samyar-form bulk-update-price-form">
    <input type="hidden" name="action" value="samyar_bulk_update_price">
    <div class="new-api-provider-form-errors"></div>
    <div class="samyar-form-loading"></div>

<?php
if ($categories) {
    foreach ($categories as $cate_id => $category) { ?>
        <div class="dashboard-posts-box dashboard-tickets-box service-category"
             data-category="<?= $category['category_id'] ?>" data-platform="<?= $category['category_platform'] ?>">
            <div class="dashboard-posts-title-holder">
                <h5 class="dashboard-posts-title">
                    <?php if ($category['category_icon']): ?>
                        <i class="<?php echo $category['category_icon']; ?>"></i>&nbsp;
                    <?php endif; ?>
                    <?php echo $category['category_name']; ?>
                    <?php if ($category['category_status'] === "0"): ?>
                        <span style="color:#ff7070"><?php _e("(Inactive)", SAMYAR_TEXT_DOMAIN); ?></span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class="dashboard-posts-list">
                <?php
                /** @var TYPE_NAME $settings */
                if ($settings['sort_by'] === "price") {
                    usort($category['services'], "kando_com_price2");
                } else {
                    usort($category['services'], "kando_com_order2");
                }

                if (count($category['services']) > 0):
                    ?>
                    <table class="shop_table shop_table_responsive">
                        <thead>
                        <tr>
                            <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Custom Price", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $user_id = get_current_user_id(); // شناسه کاربر وارد شده
                        $prices = priceController::calculatePricesBatch($category['services'], $user_id);
                        $OriginalPrices = priceController::calculateOriginalPricesBatch($category['services']);

                        foreach ($category['services'] as $service):


                            $service = (object)$service;

                            $provider_currency = $service->provider_currency ?? $service->currency ?? '';
                            if ($provider_currency === 'IRT') {
                                $provider_currency_data = $settings['IRT_currency_data'];
                            } else {
                                $provider_currency_data = ['currency_code' => "USD", 'value_currency' => 1];
                            }
                            $service_fav = esc_attr($service->is_favorite);
                            $active = "";
                            if ($service_fav) {
                                $active = 'active';
                            }
                            ?>
                            <tr id="service-<?php echo esc_attr($service->id); ?>"
                                data-category="<?= $category['category_id'] ?>"
                                data-service-id="<?php echo esc_attr($service->id); ?>"
                                data-service-name="<?php echo esc_attr($service->name); ?>"
                                data-status="<?php echo esc_attr($service->status); ?>"
                                data-fav="<?= $service_fav ?>"
                            >


                                <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo esc_attr($service->id); ?>
                                </td>
                                <td data-title="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php
                                    $cancel = $service->cancel ? "⛔" : "";
                                    $refill = $service->refill ? '<span class="text-success">♻</span>' : '';

                                    // تبدیل تاریخ به timestamp
                                    $created_timestamp = strtotime($service->created_at);

                                    // محاسبه تاریخ 7 روز بعد
                                    $seven_days_later = strtotime('+7 days', $created_timestamp);

                                    // تاریخ فعلی
                                    $current_timestamp = current_time('timestamp'); // استفاده از تابع وردپرس برای دریافت زمان فعلی

                                    $new = $current_timestamp < $seven_days_later ? '<span class="button service-tag button-red">' . __('new', SAMYAR_TEXT_DOMAIN) . '</span>' : '';
                                    ?>
                                    <?php echo esc_attr($service->name); ?><?= $cancel ?><?= $refill ?><?= $new ?>
                                </td>

                                <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php if ($service->description):
                                        $description = kando_filter_description($service->description);
                                        ?>
                                        <span class="kt-modal-button button button-blue samyar-show-description-service"
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
                                            <span data-tooltip="<?php
                                            echo sprintf(
                                                __('Price at the provider (%s %s)', SAMYAR_TEXT_DOMAIN),
                                                esc_html($service->original_price),
                                                esc_html($provider_currency)
                                            );
                                            ?>">
        <i class="fal fa-info-circle"></i>
    </span>
                                        </b>
                                    <?php endif; ?>
                                    <?php if ($settings['representation_active'] && $settings['show_price_representation'] && $service->disable_representation === "0"): ?>
                                        <?php if ($settings['show_price_representation_type'] == 1): ?>
                                            <div class="custom-popup"><i class="fal fa-info-circle"
                                                                         style="color: #8d81e6;margin-right: 7px;"></i>
                                                <span class="popuptext" id="myPopup">
                    <?php _e("Representation Prices:", SAMYAR_TEXT_DOMAIN); ?> <br>
                    <span style="padding-right:10px;float: right;text-align: right;">
                        <?php _e("Golden Representation:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->gold_price ?>) <br>
                        <?php _e("Silver Representation:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->silver_price ?>)<br>
                        <?php _e("Bronze Representation:", SAMYAR_TEXT_DOMAIN); ?> (<?= $service->bronze_price ?>) <br>
                    </span>
                </span>
                                            </div>
                                        <?php else: ?>
                                            <ul class="order-details">
                                                <li style="text-align: center;"><?php _e("Representation Prices", SAMYAR_TEXT_DOMAIN); ?></li>
                                                <li style="font-size: 11px;"><?php _e("Golden Representation:", SAMYAR_TEXT_DOMAIN); ?>
                                                    (<?= $service->gold_price; ?>
                                                    )
                                                </li>
                                                <li style="font-size: 11px;"><?php _e("Silver Representation:", SAMYAR_TEXT_DOMAIN); ?>
                                                    (<?= $service->silver_price; ?>)
                                                </li>
                                                <li style="font-size: 11px;"><?php _e("Bronze Representation:", SAMYAR_TEXT_DOMAIN); ?>
                                                    (<?= $service->bronze_price; ?>
                                                    )
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>

                                <td data-title="<?php _e("Custom Price", SAMYAR_TEXT_DOMAIN); ?>">
                                    <div class="kt-col-xs-12 kt-col-md-12">

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text currency"><?=get_option('site_currency', 'IRT')?></span>
                                            </div>
                                            <input type="number" step="0.01" class="form-control" name="price[<?php echo esc_attr($service->id); ?>]" value="<?php echo esc_attr(priceController::removeTrailingDecimalZeros($service->price)); ?>" placeholder="<?php _e('Price', SAMYAR_TEXT_DOMAIN); ?>" />
                                        </div>



                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <span class="services-notfound"><?php _e("No service has been added yet", SAMYAR_TEXT_DOMAIN); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php }
}
?>
    <input type="submit" class="button button-green new-ticket-form-submit bulk-update-price-btn" style="" value="<?php _e('Update', SAMYAR_TEXT_DOMAIN); ?>"/>
</form>
