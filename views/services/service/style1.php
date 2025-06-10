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
                <?php if (kando_user_can('edit_service')): ?>
                    <label class="custom-switch">
                        <input type="checkbox" name="disable-category" data-type="category"
                               data-id="<?php echo esc_attr($category['category_id']); ?>"
                               class="ajax-switch custom-switch-input"
                               data-toggle="collapse"
                               aria-expanded="false" <?php echo checked($category['category_status'], 1); ?>>
                        <span class="custom-switch-indicator"></span>
                    </label>
                <?php endif; ?>
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
                            <?php if (kando_user_can('edit_service')): ?>
                                <th id="cb">
                                    <input type="checkbox" value="1" class="kando-cb-checkbox"
                                           id="cb-select-category-<?= $category['category_id'] ?>"
                                           name="cb-select-category-<?= $category['category_id'] ?>">
                                    <label class="kando-cb-label"
                                           for="cb-select-category-<?= $category['category_id'] ?>"></label>
                                </th>
                            <?php endif; ?>
                            <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php if (kando_user_can('show_service_type')): ?>
                                <th><span class="nobr">نوع</span></th>
                            <?php endif; ?>
                            <th><span class="nobr"><?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php if ($settings['enable_average_time'] == 1): ?>
                                <th>
                                    <span class="nobr"><?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?></span>
                                </th>
                            <?php endif; ?>
                            <?php if (kando_user_can('edit_service')) { ?>
                                <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php } ?>
                            <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>
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
                                <?php if (kando_user_can('edit_service')): ?>
                                    <td data-title="<?php _e("Select", SAMYAR_TEXT_DOMAIN); ?>">
                                        <input type="checkbox" class="kando-cb-checkbox" value="1"
                                               id="cb-select-<?php echo esc_attr($service->id); ?>"
                                               name="cb-select-<?php echo esc_attr($service->id); ?>">
                                        <label class="kando-cb-label"
                                               for="cb-select-<?php echo esc_attr($service->id); ?>"></label>
                                    </td>
                                <?php endif; ?>

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

                                <?php if (kando_user_can('show_service_type')): ?>
                                    <td data-title="<?php _e('Type', SAMYAR_TEXT_DOMAIN); ?>">
                                        <?php if ($service->api_provider_id): ?>
                                            <li>
                                                <?= esc_attr($service->provider_name); ?>
                                                (<?= $service->api_provider_id; ?>)
                                                <?php if (kando_user_can('show_service_type') && $service->api_service_id): ?>
                                                    <?php echo '<br><b>' . esc_attr($service->api_service_id) . ' <span data-tooltip="' . esc_attr(__('Service ID in the provider', SAMYAR_TEXT_DOMAIN)) . '"><i class="fal fa-info-circle"></i></span> </b>'; ?>
                                                <?php endif; ?>
                                            </li>
                                        <?php else: ?>
                                            <li><?php _e('Manual', SAMYAR_TEXT_DOMAIN); ?></li>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>

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
                                                <li style="font-size: 11px;"><?php _e('Golden Package:', SAMYAR_TEXT_DOMAIN); ?>
                                                    (<?= $service->gold_price; ?>)
                                                </li>
                                                <li style="font-size: 11px;"><?php _e('Silver Package:', SAMYAR_TEXT_DOMAIN); ?>
                                                    (<?= $service->silver_price; ?>)
                                                </li>
                                                <li style="font-size: 11px;"><?php _e('Bronze Package:', SAMYAR_TEXT_DOMAIN); ?>
                                                    (<?= $service->bronze_price; ?>)
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>

                                <td data-title="<?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo esc_attr($service->max); ?>/<?php echo esc_attr($service->min); ?>
                                </td>

                                <?php if ($settings['enable_average_time'] == 1): ?>
                                    <td data-title="<?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?>">
                                        <?php echo get_average_time($service->id); ?>
                                    </td>
                                <?php endif; ?>

                                <?php if (kando_user_can('edit_service')) { ?>
                                    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">

                                        <label class="custom-switch">
                                            <input type="checkbox" name="disable-service" data-type="service"
                                                   data-id="<?php echo esc_attr($service->id); ?>"
                                                   class="ajax-switch custom-switch-input"
                                                   data-toggle="collapse"
                                                   aria-expanded="false" <?php echo checked($service->status, 1); ?>>
                                            <span class="custom-switch-indicator"></span>
                                        </label>

                                    </td>
                                <?php } ?>
                                <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php if (is_user_logged_in() || $settings['enable_order_btn_notloginuser'] == 1): ?>
                                        <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new&cat_id=' . esc_attr($cate_id) . '&service-id=' . esc_attr($service->id))); ?>"
                                           rel="nofollow"><span
                                                    class="button button-default kt-modal-button samyar-show-order-form"
                                                    data-modal="send-package"
                                                    data-service="<?php echo esc_attr($service->id); ?>"
                                                    data-cat="<?php echo esc_attr($cate_id); ?>" data-type="fast-order"
                                                    data-tooltip="<?php _e("Order", SAMYAR_TEXT_DOMAIN); ?>"><?php _e("Order", SAMYAR_TEXT_DOMAIN); ?></span></a>
                                    <?php endif; ?>
                                    <?php if (kando_user_can('edit_service')): ?>
                                        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=edit&id=' . esc_attr($service->id))); ?>"><span
                                                    class="button button-default btn-small"
                                                    data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                        class="fal fa-edit"></i></span></a>
                                    <?php endif; ?>
                                    <?php if (kando_user_can('show_service_log')): ?>
                                        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=log&id=' . esc_attr($service->id))); ?>"><span
                                                    class="button button-default btn-small"
                                                    data-tooltip="<?php _e("Service Report", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                        class="fal fa-clipboard-list"></i></span></a>
                                    <?php endif; ?>
                                    <?php if (kando_user_can('delete_service')): ?>
                                        <span class="button button-aqua btn-small delete-service"
                                              data-id="<?php echo esc_attr($service->id); ?>"
                                              data-tooltip="<?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                    class="fal fa-trash"></i></span>
                                    <?php endif; ?>
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
} else {
    include('not-found.php');
}
?>