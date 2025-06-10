<?php

use samyar\Category;
use samyar\Provider;

if (is_user_logged_in()):
    $categories = Category::where(['order' => 'ASC', 'order_by' => 'sort', 'status' => 1]);
    $providers = Provider::all();
    ?>
    <div class="kt-modal-inner kt-service-modal">
        <i class="kt-modal-close"></i>
        <div class="kt-modal-content align-right">
            <div class="register-form">
                <form method="POST" class="samyar-form new-service-form-modal">
                    <input type="hidden" name="action" value="samyar_service_add">
                    <input type="hidden" name="api_provider_id" value="">
                    <input type="hidden" name="api_service_id" value="">
                    <input type="hidden" name="add_type" value="api">
                    <input type="hidden" name="refill_type" value="api">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <div class="kt-col-xs-12" style="margin-top:15px">
                            <input type="text" name="name" placeholder="<?php _e('Service Name', SAMYAR_TEXT_DOMAIN); ?>"/>
                            <label><?php _e('Please select a category', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="cate_id">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="kt-row">
                                <div class="column kt-col-xs-12 kt-col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?php _e('Minimum Quantity', SAMYAR_TEXT_DOMAIN); ?></span>
                                        </div>
                                        <input type="number" class="form-control" dir="ltr" placeholder="<?php _e('Minimum Quantity', SAMYAR_TEXT_DOMAIN); ?>" id="min" name="min">
                                    </div>
                                </div>
                                <div class="column kt-col-xs-12 kt-col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?php _e('Maximum Quantity', SAMYAR_TEXT_DOMAIN); ?></span>
                                        </div>
                                        <input type="number" class="form-control" dir="ltr" placeholder="<?php _e('Maximum Quantity', SAMYAR_TEXT_DOMAIN); ?>" id="max" name="max">
                                    </div>
                                </div>
                            </div>
                            <label><?php _e('Please select the service type', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="type">
                                <?php
                                $service_type_array = array(
                                    'default' => __("Default", SAMYAR_TEXT_DOMAIN),
                                    'subscriptions' => __("Subscriptions", SAMYAR_TEXT_DOMAIN),
                                    'custom_comments' => __("Custom Comments", SAMYAR_TEXT_DOMAIN),
                                    'custom_comments_package' => __('Custom Comments Package', SAMYAR_TEXT_DOMAIN),
                                    'mentions_with_hashtags' => __('Mentions with Hashtags', SAMYAR_TEXT_DOMAIN),
                                    'mentions' => __('Mentions', SAMYAR_TEXT_DOMAIN),
                                    'mentions_custom_list' => __('Mentions Custom List', SAMYAR_TEXT_DOMAIN),
                                    'mentions_hashtag' => __('Mentions Hashtag', SAMYAR_TEXT_DOMAIN),
                                    'mentions_user_followers' => __('Mentions User Followers', SAMYAR_TEXT_DOMAIN),
                                    'mentions_media_likers' => __('Mentions Media Likers', SAMYAR_TEXT_DOMAIN),
                                    'package' => __('Package', SAMYAR_TEXT_DOMAIN),
                                    'comment_likes' => __('Comment Likes', SAMYAR_TEXT_DOMAIN),
                                    'poll' => __('Poll', SAMYAR_TEXT_DOMAIN),
                                    'comment_replies' => __('Comment Replies', SAMYAR_TEXT_DOMAIN),
                                    'invites_from_groups' => __('Invites From Groups', SAMYAR_TEXT_DOMAIN)
                                );

                                foreach ($service_type_array as $type => $service_type) {
                                    ?>
                                    <option value="<?= $type ?>"><?= $service_type ?></option>
                                <?php } ?>
                            </select>
                            <label><?php _e('Dripfeed', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="dripfeed">
                                <option value="0"><?php _e('Inactive', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="1"><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>
                            <label><?php _e('Refill', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="refill">
                                <option value="0"><?php _e('Inactive', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="1"><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>
                            <label><?php _e('Brand', SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="brand" placeholder="<?php _e('Brand', SAMYAR_TEXT_DOMAIN); ?>"/>
                            <label><?php _e('Original Price (The price you purchase for)', SAMYAR_TEXT_DOMAIN); ?></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency api_currency"><?php _e('Toman', SAMYAR_TEXT_DOMAIN); ?></span>
                                </div>
                                <input type="number" step="any" class="form-control" dir="ltr" placeholder="<?php _e('Original Price', SAMYAR_TEXT_DOMAIN); ?>" id="original_price" name="original_price">
                            </div>
                        </div>
                        <style type="text/css">
                            .service-rate {
                                margin-bottom: 15px;
                            }

                            .service-rate-padding {
                                padding-left: 5px;
                            }
                        </style>
                        <script type="text/javascript">
                            jQuery(document).ready(function () {
                                jQuery(document).on("change", "#disable-representation", function () {
                                    if (jQuery(this).is(':checked')) {
                                        jQuery('.representation-rates').slideUp();
                                    } else {
                                        jQuery('.representation-rates').slideDown();
                                    }
                                });
                            });
                        </script>
                        <div class="kt-col-xs-12">
                            <div class="alert alert-info" style="font-size: 12px;" role="alert"><?php _e('If you want the amount to be calculated according to the general settings, leave the price section blank', SAMYAR_TEXT_DOMAIN); ?></div>
                        </div>

                        <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                            <input type="hidden" value="0" name="disable-representation">
                            <input type="checkbox" value="1" id="disable-representation" name="disable-representation">
                            <label for="disable-representation"><?php _e('Disable representation prices for this service', SAMYAR_TEXT_DOMAIN); ?></label>
                        </div>
                        <div class="kt-col-xs-12 service-rate not-free"
                             style="margin-top:15px;">
                            <div class="kt-col-xs-2 kt-col-md-2">
                                <?php _e('Type', SAMYAR_TEXT_DOMAIN); ?>
                            </div>
                            <div class="kt-col-xs-4 kt-col-md-4">
                                <?php _e('Price', SAMYAR_TEXT_DOMAIN); ?> (<?php kando_get_currency_base_text(true) ?>)
                            </div>
                            <div class="kt-col-xs-4 kt-col-md-4">
                                <?php _e('Rate (Percentage)', SAMYAR_TEXT_DOMAIN); ?>
                            </div>

                        </div>
                        <div class="kt-col-xs-12 service-rate not-free">
                            <div class="kt-col-xs-2 kt-col-md-2 pt13" style="">
                                <?php _e('Regular User', SAMYAR_TEXT_DOMAIN); ?>
                            </div>
                            <div class="service-rate-padding kt-col-xs-4 kt-col-md-4">
                                <input type="number" name="price" placeholder="<?php _e('Price', SAMYAR_TEXT_DOMAIN); ?>"
                                       value=""/>
                            </div>
                            <div class="service-rate-padding kt-col-xs-4 kt-col-md-4">
                                <input type="number" name="profit_rate" placeholder="<?php _e('Profit Rate', SAMYAR_TEXT_DOMAIN); ?>"
                                       value=""/>
                            </div>

                        </div>
                        <!-- شروع قیمت های نمایندگی -->
                        <?php
                        //دریافت تنظیمات عمومی
                        $representation_active = !empty(kando_get_option('representation-active')) ? kando_get_option('representation-active') : 0;
                        if ($representation_active) {


                            $representation_rates = [
                                'gold' => [
                                    'name' => __('Golden Representation', SAMYAR_TEXT_DOMAIN),
                                    'price' => "",
                                    'profit_rate' => '',
                                    'lock' => 0,
                                ],
                                'silver' => [
                                    'name' => __('Silver Representation', SAMYAR_TEXT_DOMAIN),
                                    'price' => "",
                                    'profit_rate' => '',
                                    'lock' => 0,
                                ],
                                'bronze' => [
                                    'name' => __('Bronze Representation', SAMYAR_TEXT_DOMAIN),
                                    'price' => "",
                                    'profit_rate' => '',
                                    'lock' => 0,
                                ],
                            ];

                            ?>

                            <div class="representation-rates not-free">
                                <div class="kt-col-xs-12 service-rate not-free"
                                     style="margin-top:15px;">
                                    <div class="kt-col-xs-2 kt-col-md-2">
                                        <?php _e('Type', SAMYAR_TEXT_DOMAIN); ?>
                                    </div>
                                    <div class="kt-col-xs-4 kt-col-md-4">
                                        <?php _e('Price', SAMYAR_TEXT_DOMAIN); ?> (<?php kando_get_currency_base_text(true) ?>)
                                    </div>
                                    <div class="kt-col-xs-4 kt-col-md-4">
                                        <?php _e('Discount', SAMYAR_TEXT_DOMAIN); ?>
                                    </div>

                                </div>

                                <?php foreach ($representation_rates as $key => $rate) { ?>
                                    <div class="kt-col-xs-12 service-rate pt13">
                                        <div class="kt-col-xs-2 kt-col-md-2" style="">
                                            <?= $rate['name'] ?>
                                        </div>
                                        <div class="service-rate-padding kt-col-xs-4 kt-col-md-4">
                                            <input type="number" name="<?= $key ?>_price" placeholder="<?php _e('Price', SAMYAR_TEXT_DOMAIN); ?>"
                                                   value=""/>
                                        </div>
                                        <div class="service-rate-padding kt-col-xs-4 kt-col-md-4">
                                            <input type="number" name="<?= $key ?>_profit_rate"
                                                   placeholder="<?php _e('Discount', SAMYAR_TEXT_DOMAIN); ?>"
                                                   value=""/>
                                        </div>


                                    </div>
                                <?php } ?>
                            </div>

                        <?php } ?>
                        <!-- پایان قیمت های نمایندگی -->
                        <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                            <textarea class="new-api-form-text" name="description" placeholder="<?php _e('Description', SAMYAR_TEXT_DOMAIN); ?>"></textarea>
                        </div>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Submit', SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
endif;