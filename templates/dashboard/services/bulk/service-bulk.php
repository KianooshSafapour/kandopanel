<?php
/** @var TYPE_NAME $service */

use samyar\priceController;

?>



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

                        // ادغام دو لیست بر اساس شناسه
                        $mergedList = [];
                        foreach ($category['services'] as $service) {
                            $id = $service->id;

                            // تبدیل شیء به آرایه برای تغییر نام فیلد
                            $serviceArray = (array)$service;

                            // تغییر نام فیلد price به custom_price اگر وجود داشت
                            if (isset($serviceArray['price'])) {
                                $serviceArray['custom_price'] = $serviceArray['price'];
                                unset($serviceArray['price']);
                            }

                            // اگر custom_price وجود نداشت یا null بود، مقدار 0 قرار بده
                            if (!isset($serviceArray['custom_price']) || is_null($serviceArray['custom_price'])) {
                                $serviceArray['custom_price'] = 0;
                            }

                            if (isset($prices[$id])) {
                                // ایجاد یک شیء جدید با ترکیب اطلاعات سرویس (با فیلد تغییر نام یافته) و قیمت
                                $mergedItem = (object)array_merge($serviceArray, $prices[$id]);
                                $mergedList[] = $mergedItem;
                            } else {
                                // اگر قیمتی برای این شناسه وجود نداشت، فقط سرویس (با فیلد تغییر نام یافته) را اضافه کنید
                                $mergedList[] = (object)$serviceArray;
                            }
                        }

                        /** @var TYPE_NAME $settings */
                        if ($settings['sort_by'] === "price") {
                            usort($mergedList, "kando_com_price2");
                        } else {
                            usort($mergedList, "kando_com_order2");
                        }

                        foreach ($mergedList as $service):


                            $service = (object)$service;


                            $provider_currency = $service->provider_currency ?? $service->currency ?? '';
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
                                    <?php if ($settings['representation_active']==1 && $settings['show_price_representation']==1 && $service->disable_representation === "0"):
                                        $RepresentationPrices = priceController::calculateRepresentationPrices($service,[$service]);
                                        ?>
                                        <?php if ($settings['show_price_representation_type'] == 1): ?>
                                        <div class="kando-tooltip-container">
                                            <i class="fal fa-info-circle" style="color: #8d81e6;margin-right: 7px;"></i>
                                            <div class="kando-tooltip-content">
                                                <?php _e('Package prices:', SAMYAR_TEXT_DOMAIN); ?> <br>
                                                <span>
        <?php _e('Golden Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $RepresentationPrices['gold']['price_for_show_formatted'] ?? '' ?>) <br>
        <?php _e('Silver Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $RepresentationPrices['silver']['price_for_show_formatted'] ?? '' ?>) <br>
        <?php _e('Bronze Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $RepresentationPrices['bronze']['price_for_show_formatted'] ?? '' ?>) <br>
    </span>
                                            </div>
                                        </div>

                                    <?php else:  ?>
                                        <ul class="order-details">
                                            <li style="text-align: center;"><?php _e('Package prices', SAMYAR_TEXT_DOMAIN); ?></li>
                                            <li style="font-size: 11px;"><?php _e('Golden Package:', SAMYAR_TEXT_DOMAIN); ?>
                                                (<?= $RepresentationPrices['gold']['price_for_show_formatted'] ?? '' ?>)
                                            </li>
                                            <li style="font-size: 11px;"><?php _e('Silver Package:', SAMYAR_TEXT_DOMAIN); ?>
                                                (<?= $RepresentationPrices['silver']['price_for_show_formatted'] ?? '' ?>)
                                            </li>
                                            <li style="font-size: 11px;"><?php _e('Bronze Package:', SAMYAR_TEXT_DOMAIN); ?>
                                                (<?= $RepresentationPrices['bronze']['price_for_show_formatted'] ?? '' ?>)
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
                                            <input type="number" step="0.01" class="form-control" name="price[<?php echo esc_attr($service->id); ?>]" value="<?php echo esc_attr(priceController::removeTrailingDecimalZeros($service->custom_price)); ?>" placeholder="<?php _e('Price', SAMYAR_TEXT_DOMAIN); ?>" />
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

