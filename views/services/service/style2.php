<?php
/** @var TYPE_NAME $service */

use samyar\priceController;

?>

<?php
if ($categories) {
    foreach ($categories as $cate_id => $category) { ?>
        <div class="service-card" data-category="<?= $category['category_id'] ?>"
             data-platform="<?= $category['category_platform'] ?>">
            <div class="card-header">
                <div class="right-group">
                    <?php if (kando_user_can('edit_service')): ?>

                        <input type="checkbox" value="1" class="kando-cb-checkbox"
                               id="cb-select-category-<?= $category['category_id'] ?>"
                               name="cb-select-all-<?= $category['category_id'] ?>">
                        <label class="kando-cb-label" for="cb-select-category-<?= $category['category_id'] ?>"></label>

                    <?php endif; ?>
                    <h5 class="dashboard-posts-title">
                        <?php if ($category['category_icon']): ?>
                            <i class="<?php echo $category['category_icon']; ?>"></i>&nbsp;
                        <?php endif; ?>
                        <?php echo $category['category_name']; ?>
                        <?php if (kando_user_can('edit_service')):
                            if ($category['category_status'] === "0"): ?>
                                <span style="color:#ff7070"><?php _e("(Inactive)", SAMYAR_TEXT_DOMAIN); ?></span>
                            <?php endif;

                        endif; ?>

                    </h5>
                </div>
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

            <?php
            if (count($category['services']) > 0):

                $user_id = get_current_user_id(); // شناسه کاربر وارد شده
                $prices = priceController::calculatePricesBatch($category['services'], $user_id);
                $OriginalPrices = priceController::calculateOriginalPricesBatch($category['services']);


                // ادغام دو لیست بر اساس شناسه
                $mergedList = [];
                foreach ($category['services'] as $service) {
                    $id = $service->id;
                    if (isset($prices[$id])) {
                        // ایجاد یک شیء جدید با ترکیب اطلاعات سرویس و قیمت
                        $mergedItem = (object)array_merge((array)$service, $prices[$id]);
                        $mergedList[] = $mergedItem;
                    } else {
                        // اگر قیمتی برای این شناسه وجود نداشت، فقط سرویس را اضافه کنید
                        $mergedList[] = $service;
                    }
                }


                /** @var TYPE_NAME $settings */
                if ($settings['sort_by'] === "price") {
                    usort($mergedList, "kando_com_price2");
                } else {
                    usort($mergedList, "kando_com_order2");
                }


                foreach ($mergedList as $service) {


                    $provider_currency = $service->provider_currency ?? $service->currency ?? '';


                    $service_fav = esc_attr($service->is_favorite);
                    $active = "";
                    if ($service_fav) {
                        $active = 'active';
                    }

                    ?>


                    <div class="service-item" data-category="<?= $category['category_id'] ?>"
                         data-service-id="<?php echo esc_attr($service->id); ?>"
                         data-service-name="<?php echo esc_attr($service->name); ?>"
                         data-status="<?php echo esc_attr($service->status); ?>"
                         data-fav="<?= $service_fav ?>">
                        <div class="right-group">
                            <?php if (kando_user_can('edit_service')): ?>
                                <div class="services-item-cb">
                                    <input type="checkbox" class="kando-cb-checkbox" value="1"
                                           id="cb-select-<?php echo esc_attr($service->id); ?>"
                                           name="cb-select-<?php echo esc_attr($service->id); ?>">
                                    <label class="kando-cb-label"
                                           for="cb-select-<?php echo esc_attr($service->id); ?>"></label>
                                </div>
                            <?php endif; ?>


                            <div class="services-item-top">
                                <div class="sit-first">
                                    <div class="services-id">
                                        <?php if(is_user_logged_in()): ?>
                                        <button data-service-id="<?php echo esc_attr($service->id); ?>"
                                                class="btn btn-dark btn-rounded btn-sm favorite favorite-btn d-flex align-items-center justify-content-center <?= $active ?>">
                                            <i class="fas fa-heart"></i>
                                        </button>
                    <?php endif; ?>
                                    </div>
                                    <div class="services-title">
                  <span>
                  <span class="st-id"><?php echo esc_attr($service->id); ?></span>
                      <?php
                      $cancel = $service->cancel ? "⛔" : "";
                      $refill = $service->refill ? '<span class="text-success">♻</span>' : '';
                      $new= "";
                      if(kando_get_option('enable-new-tag-service', 1)=='1'){
                          // تبدیل تاریخ به timestamp
                          $created_timestamp = strtotime($service->created_at);

                          // محاسبه تاریخ 7 روز بعد
                          $seven_days_later = strtotime('+7 days', $created_timestamp);

                          // تاریخ فعلی
                          $current_timestamp = current_time('timestamp'); // استفاده از تابع وردپرس برای دریافت زمان فعلی

                          $new = $current_timestamp < $seven_days_later ? '<span class="button service-tag button-red">' . __('new', SAMYAR_TEXT_DOMAIN) . '</span>' : '';
                      }
                      ?>
                  <a href="<?php echo home_url('dashboard/?action=orders&section=new&service_id='.esc_attr($service->id)); ?>"><span
                              class="ss-name"><?php echo esc_attr($service->name); ?><?= $cancel ?><?= $refill ?><?= $new ?></span> </a>
                  </span>
                                    </div>
                                </div>

                                <div class="sib-first">
               <span class="min">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                       fill="currentColor">
                     <path d="M20 4V16H23L19 21L15 16H18V4H20ZM12 18V20H3V18H12ZM14 11V13H3V11H14ZM14 4V6H3V4H14Z"></path>
                  </svg>
                  <span><?php _e("Min:", SAMYAR_TEXT_DOMAIN); ?></span>
                  <strong><?php echo esc_attr($service->min); ?></strong>
               </span>
                                    <span class="max">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                       fill="currentColor">
                     <path d="M19 3L23 8H20V20H18V8H15L19 3ZM14 18V20H3V18H14ZM14 11V13H3V11H14ZM12 4V6H3V4H12Z"></path>
                  </svg>
                  <span><?php _e("Max:", SAMYAR_TEXT_DOMAIN); ?></span>
                  <strong> <?php echo esc_attr($service->max); ?></strong>
               </span>

                                    <?php

                                    if ($settings['enable_average_time'] == 1 && !empty(kando_get_service_ave_time($service->id))) { ?>
                                        <span class="avg c-pointer" data-toggle="tooltip" data-placement="top"
                                              title=""
                                              data-original-title="<?php _e("The average time is based on 10 latest completed orders per 1000 quantity.", SAMYAR_TEXT_DOMAIN); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                       fill="currentColor">
                     <path d="M6 4H4V2H20V4H18V6C18 7.61543 17.1838 8.91468 16.1561 9.97667C15.4532 10.703 14.598 11.372 13.7309 12C14.598 12.628 15.4532 13.297 16.1561 14.0233C17.1838 15.0853 18 16.3846 18 18V20H20V22H4V20H6V18C6 16.3846 6.81616 15.0853 7.8439 14.0233C8.54682 13.297 9.40202 12.628 10.2691 12C9.40202 11.372 8.54682 10.703 7.8439 9.97667C6.81616 8.91468 6 7.61543 6 6V4ZM8 4V6C8 6.68514 8.26026 7.33499 8.77131 8H15.2287C15.7397 7.33499 16 6.68514 16 6V4H8ZM12 13.2219C10.9548 13.9602 10.008 14.663 9.2811 15.4142C9.09008 15.6116 8.92007 15.8064 8.77131 16H15.2287C15.0799 15.8064 14.9099 15.6116 14.7189 15.4142C13.992 14.663 13.0452 13.9602 12 13.2219Z"></path>
                  </svg>
                  <span><?php _e("Average time:", SAMYAR_TEXT_DOMAIN); ?></span>
                  <strong>
													<?php echo kando_get_service_ave_time($service->id); ?>
										  </strong>
               </span>

                                    <?php } ?>


                                    <span class="badgearea">
                                 <?php if (kando_user_can('show_service_type')): ?>
                                     <span class="avg c-pointer">

                  <span><?php _e("Provider:", SAMYAR_TEXT_DOMAIN); ?></span>
                  <strong>
                                                    <?php if ($service->api_provider_id): ?>
                                                        <?= esc_attr($service->provider_name); ?>(<?= $service->api_provider_id; ?>)
                                                        <?php if (kando_user_can('show_service_type') && $service->api_service_id): ?>
                                                            <?php echo '<b><span data-tooltip="' . __("Service ID in Provider", SAMYAR_TEXT_DOMAIN) . '" class="button button-default badge-error-orders">' . esc_attr($service->api_service_id) . '</span></b>'; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?>
                                                    <?php endif; ?>

										  </strong>
               </span>
                                 <?php endif; ?>



                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="services-item-bottom">
                            <div class="sit-last">

                                <?php if (kando_user_can('show_original_price') && $service->original_price): ?>
                                    <div class="button button-default"
                                         data-tooltip="<?php _e("Price in Provider", SAMYAR_TEXT_DOMAIN); ?> (<?php echo $service->original_price; ?> <?php echo $provider_currency; ?>)">
                                        <?php echo $OriginalPrices[$service->id]['price_for_show_formatted']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="services-rate">
                                    <?php echo $prices[$service->id]['price_for_show_formatted']; ?>
                                </div>
                            </div>
                            <div class="sib-last">
                                <?php if (kando_user_can('edit_service')): ?>
                                    <label class="custom-switch">
                                        <input type="checkbox" name="disable-service" data-type="service"
                                               data-id="<?php echo esc_attr($service->id); ?>"
                                               class="ajax-switch custom-switch-input"
                                               data-toggle="collapse"
                                               aria-expanded="false" <?php echo checked($service->status, 1); ?>>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                <?php endif; ?>

                                <?php if (kando_user_can('edit_service')): ?>
                                    <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=edit&id=' . esc_attr($service->id))); ?>"><span
                                                class="button button-default"
                                                data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                    class="fal fa-edit"></i></span></a>
                                <?php endif; ?>
                                <?php if (kando_user_can('show_service_log')): ?>
                                    <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=log&id=' . esc_attr($service->id))); ?>"><span
                                                class="button button-default"
                                                data-tooltip="<?php _e("Service Report", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                    class="fal fa-clipboard-list"></i></span></a>
                                <?php endif; ?>
                                <?php if (kando_user_can('delete_service')): ?>
                                    <span class="button button-aqua delete-service"
                                          data-id="<?php echo esc_attr($service->id); ?>"
                                          data-tooltip="<?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><i
                                                class="fal fa-trash"></i></span>
                                <?php endif; ?>
                                <?php if (is_user_logged_in() || $settings['enable_order_btn_notloginuser'] == 1): ?>
                                    <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new&cat_id=' . esc_attr($cate_id) . '&service-id=' . esc_attr($service->id))); ?>"
                                       rel="nofollow"><span
                                                class="button button-default kt-modal-button samyar-show-order-form"
                                                data-modal="send-package"
                                                data-service="<?php echo esc_attr($service->id); ?>"
                                                data-cat="<?php echo esc_attr($cate_id); ?>" data-type="fast-order"
                                                data-tooltip="<?php _e("Order", SAMYAR_TEXT_DOMAIN); ?>"><?php _e("Order", SAMYAR_TEXT_DOMAIN); ?></span></a>
                                <?php endif; ?>
                                <?php if ($service->description):
                                    $description = kando_filter_description($service->description);
                                    ?>
                                    <span class="kt-modal-button button button-blue samyar-show-description-service"
                                          data-modal="show-description"
                                          data-desc="<?= esc_html($description); ?>"
                                          data-id="<?php echo esc_attr($service->id); ?>"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php if ($settings['representation_active']==1 && $settings['show_price_representation']==1 && $service->disable_representation === "0"):
                        $RepresentationPrices = priceController::calculateRepresentationPrices($service,[$service]);
                        ?>
                        <div class="services-item-footer">
                            <span class="item"><?php _e('Golden Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $RepresentationPrices['gold']['price_for_show_formatted'] ?? '' ?>)</span>
                            <span class="item"><?php _e('Silver Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $RepresentationPrices['silver']['price_for_show_formatted'] ?? '' ?>)</span>
                            <span class="item"><?php _e('Bronze Package:', SAMYAR_TEXT_DOMAIN); ?> (<?= $RepresentationPrices['bronze']['price_for_show_formatted'] ?? '' ?>)</span>
                        </div>
                    <?php endif; ?>
                    </div>


                <?php } ?>

            <?php else: ?>
                <span class="services-notfound"><?php _e("No service has been added yet", SAMYAR_TEXT_DOMAIN); ?></span>
            <?php endif; ?>

        </div>

    <?php }
} else {
    include('not-found.php');
}

?>
