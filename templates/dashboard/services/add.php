<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Provider;

$categories = Category::where(['order' => 'ASC', 'order_by' => 'sort']);
$providers = Provider::all();
$site_currency = get_option('site_currency','IRT');
?>
<style type="text/css">
    .shop_table.shop_table_responsive tbody tr:nth-child(odd) td{
        padding: 4px !important;
    }
    .select2-container {
        margin-top: 10px;
    }

    .select2-selection.select2-selection--single {
        height: 51px;
        background: #fff;
        background-position-x: 0%;
        background-position-y: 0%;
        background-repeat: repeat;
        background-image: none;
        border: 1px solid #ededed;
        border-radius: 3px;
        color: #7f8187;
        font-family: "IRANSans";
        font-size: 13px;
        width: 100%;
        -webkit-transition: color .15s ease-in-out, background .15s ease-in-out, border .15s ease-in-out;
        transition: color .15s ease-in-out, background .15s ease-in-out, border .15s ease-in-out;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        text-indent: .01px;
        text-overflow: "";
    }

    .select2-dropdown {
        background: #fff;
        border: 1px solid #ededed;
    }

    .select2-selection__rendered {
        padding: 13px 15px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }

    .select2-container--open .select2-dropdown {
        top: 21px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: 1px solid #ededed;
    }

    .select2-container--default .select2-selection--multiple {
        /*height: 40px;*/
        border: 1px solid #ededed;
    }

    .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__clear {
        color: #c2c2c2;
    }

</style>
<div class="kt-row">
    <form method="POST" class="samyar-form new-service-form">
        <div class="column kt-col-xs-12 kt-col-md-6 float-left">
            <div class="new-ticket-help">
                <ul>
                    <li><?php _e("If you want the prices to be calculated based on the settings, simply leave the price fields empty.", SAMYAR_TEXT_DOMAIN); ?></li>
                    <li><?php _e("If desired, you can enter a custom rate for each service.", SAMYAR_TEXT_DOMAIN); ?></li>
                </ul>
            </div>
            <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                <label><?php _e("Original Price (The price at which you purchase)", SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="number" name="original_price" step="any" dir="ltr"
                       style="padding: 9px 15px;float: right;width: calc(100% - 150px);margin-left: 10px;"
                       placeholder="<?php _e("Original Price", SAMYAR_TEXT_DOMAIN); ?>"/>
                <span id="manual_currency">
        <select id="manual_currency" name="manual_currency" style="display:block;width: 20%;padding: 9px;">
            <option value="USD"><?php _e("Dollar", SAMYAR_TEXT_DOMAIN); ?></option>
            <option value="IRT"><?php _e("Toman", SAMYAR_TEXT_DOMAIN); ?></option>
            <option value="IRR"><?php _e("Rial", SAMYAR_TEXT_DOMAIN); ?></option>
        </select>
    </span>
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

                    jQuery(document).on("change", "#is-service-free", function () {
                        if (jQuery(this).is(':checked')) {
                            jQuery('.not-free').slideUp();
                            jQuery('.service-free').slideDown();
                        } else {
                            jQuery('.not-free').slideDown();
                            jQuery('.service-free').slideUp();
                        }
                    });


                });
            </script>

            <div class="kt-col-xs-12" style="margin-top:15px">
                <input type="hidden" value="0" name="is-service-free">
                <input type="checkbox" value="1" id="is-service-free" name="is-service-free">
                <label style="margin: 20px 0;" for="is-service-free"><?php _e("This service is free", SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="kt-col-xs-12 service-free" style="display: none;">
                    <div class="kt-col-xs-3 kt-col-md-2" style="margin-top: 11px;font-size: 14px;">
                        <?php _e("Daily user", SAMYAR_TEXT_DOMAIN); ?>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="is-free-number" placeholder=""/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-6 kt-col-md-7" style="margin-top: 11px;font-size: 14px;">
                        <?php _e("can place a free order", SAMYAR_TEXT_DOMAIN); ?>.
                    </div>
                </div>
            </div>

            <?php
            $representation_active = !empty(kando_get_option('representation-active')) ? kando_get_option('representation-active') : 0;
            if ($representation_active):
                ?>
                <div class="kt-col-xs-12 service-rate not-free"
                     style="margin-top:15px;display: none;">

                    <input type="hidden" value="0" name="disable-representation">
                    <input type="checkbox" value="1"
                           id="disable-representation" name="disable-representation">
                    <label style="margin: 20px 0;" for="disable-representation"><?php _e("Disable representation prices for this service", SAMYAR_TEXT_DOMAIN); ?></label>
                </div>
            <?php endif; ?>

            <div class="kt-col-xs-12 service-rate not-free">
                <table class="shop_table shop_table_responsive">
                    <thead>
                    <tr>
                        <th><span class="nobr"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php
                                echo sprintf(
                                    __('Price (%s)', SAMYAR_TEXT_DOMAIN),
                                    $site_currency
                                );
                                ?></span></th>
                        <th><span class="nobr"><?php _e("Rate (Percentage)", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td data-title="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>"><?php _e("Regular User", SAMYAR_TEXT_DOMAIN); ?></td>
                        <td data-title="<?php
                        echo sprintf(
                            __('Price (%s)', SAMYAR_TEXT_DOMAIN),
                            $site_currency
                        );
                        ?>"><input type="number" dir="ltr" step="any" name="price" placeholder="<?php _e("Price", SAMYAR_TEXT_DOMAIN); ?>"
                                   value=""/></td>
                        <td data-title="Rate (Percentage)"><input type="number" dir="ltr" step="any" name="profit_rate" placeholder="<?php _e("Profit Rate", SAMYAR_TEXT_DOMAIN); ?>"
                                                                  value=""/></td>

                    </tr>

                    </tbody>
                </table>


            </div>

            <!-- شروع قیمت های نمایندگی -->
            <?php
            //دریافت تنظیمات عمومی

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
                    <table class="shop_table shop_table_responsive">
                        <thead>
                        <tr>
                            <th><span class="nobr"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php
                                    echo sprintf(
                                        __('Price (%s)', SAMYAR_TEXT_DOMAIN),
                                        $site_currency
                                    );
                                    ?></span></th>
                            <th><span class="nobr"><?php _e("Discount", SAMYAR_TEXT_DOMAIN); ?></span></th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($representation_rates as $key => $rate) { ?>
                            <tr>
                                <td data-title="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>"><?= $rate['name'] ?></td>
                                <td data-title="<?php
                                echo sprintf(
                                    __('Price (%s)', SAMYAR_TEXT_DOMAIN),
                                    $site_currency
                                );
                                ?>"><input type="number" dir="ltr" step="any" name="<?= $key ?>_price"
                                           placeholder="<?php _e("Price", SAMYAR_TEXT_DOMAIN); ?>"
                                           value=""/></td>
                                <td data-title="<?php _e("Discount", SAMYAR_TEXT_DOMAIN); ?>"><input type="number" dir="ltr" step="any" name="<?= $key ?>_profit_rate"
                                                                                                     placeholder="<?php _e("Discount", SAMYAR_TEXT_DOMAIN); ?>"
                                                                                                     value=""/></td>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>



                </div>

            <?php } ?>
            <!-- پایان قیمت های نمایندگی -->
        </div>
        <div class="column kt-col-xs-12 kt-col-md-6 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e("Add New Service", SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e("Enter the information and click on add", SAMYAR_TEXT_DOMAIN); ?></span>

                <input type="hidden" name="action" value="samyar_service_add">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <input type="text" name="name" placeholder="<?php _e("Service Name", SAMYAR_TEXT_DOMAIN); ?>" data-emojiable="true" class="text-emoji"/>
                    <label><?php _e("Please select a category", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select name="cate_id">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Minimum Quantity", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="min" placeholder="<?php _e("Minimum Quantity", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Maximum Quantity", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="max" placeholder="<?php _e("Maximum Quantity", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <label><?php _e("Please select service type", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select name="type" id="select-service-type">
                        <?php
                        $service_type_array = array(
                            'default' => __("Default", SAMYAR_TEXT_DOMAIN),
                            'subscriptions' => __("Subscriptions", SAMYAR_TEXT_DOMAIN),
                            'custom_comments' => __("Custom Comments", SAMYAR_TEXT_DOMAIN),
                            'custom_comments_package' => __("Custom Comments Package", SAMYAR_TEXT_DOMAIN),
                            'mentions_with_hashtags' => __("Mentions with Hashtags", SAMYAR_TEXT_DOMAIN),
                            'mentions' => __("Mentions", SAMYAR_TEXT_DOMAIN),
                            'mentions_custom_list' => __("Mentions Custom List", SAMYAR_TEXT_DOMAIN),
                            'mentions_hashtag' => __("Mentions Hashtag", SAMYAR_TEXT_DOMAIN),
                            'mentions_user_followers' => __("Mentions User Followers", SAMYAR_TEXT_DOMAIN),
                            'mentions_media_likers' => __("Mentions Media Likers", SAMYAR_TEXT_DOMAIN),
                            'package' => __("Package", SAMYAR_TEXT_DOMAIN),
                            'comment_likes' => __("Comment Likes", SAMYAR_TEXT_DOMAIN),
                            'poll' => __("Poll", SAMYAR_TEXT_DOMAIN),
                            'comment_replies' => __("Comment Replies", SAMYAR_TEXT_DOMAIN),
                            'invites_from_groups' => __("Invites From Groups", SAMYAR_TEXT_DOMAIN)
                        );
                        $service_type_array = apply_filters('kando_type_list', $service_type_array);
                        foreach ($service_type_array as $type => $service_type) {
                            ?>
                            <option value="<?= $type ?>"><?= $service_type ?></option>
                        <?php } ?>
                    </select>
                    <?php do_action('kando_service_form_after_type', $service_id = "", $service_type = ""); ?>
                    <label><?php _e("Dripfeed Investment", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select name="dripfeed">
                        <option value="0"><?php _e("Disabled", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="1"><?php _e("Enabled", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                    <label><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select name="add_type" id="service_add_type_select">
                        <option value="manual"><?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="api"><?php _e("API", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                    <div class="kt-row" id="add_type_api" style="display: none">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Select API Provider", SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="api_provider_id">
                                <?php foreach ($providers as $provider): ?>
                                    <option value="<?php echo esc_attr($provider->id) ?>"><?php echo esc_attr($provider->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Enter Service ID", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="api_service_id" placeholder="<?php _e("Service ID (ServiceID) API", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <label><?php _e("Sorting", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" name="sort" placeholder="<?php _e("Sorting", SAMYAR_TEXT_DOMAIN); ?>"/>
                    <label><?php _e("Gift Percentage Quantity (Only Number)", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" min="0" max="100" name="gift-percent-quantity" placeholder="<?php _e("Percentage", SAMYAR_TEXT_DOMAIN); ?>"/>
                    <label><?php _e("Refill", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select name="refill" id="refill_enable">
                        <option value="0"><?php _e("Disabled", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="1"><?php _e("Enabled", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>

                    <div class="refill_type_container" style="display:none">
                        <label><?php _e("Refill Type", SAMYAR_TEXT_DOMAIN); ?></label>
                        <select name="refill_type">
                            <option value="custom"><?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="api"><?php _e("Via API", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>

                        <label><?php _e("Refill Time Limit", SAMYAR_TEXT_DOMAIN); ?></label>
                        <select name="refill_period">
                            <option value="30"><?php _e("1 Month", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="60"><?php _e("2 Months", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="90"><?php _e("3 Months", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="180"><?php _e("6 Months", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="360"><?php _e("12 Months", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                    </div>
                    <label><?php _e("Cancellation", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select name="cancel" id="cancel_enable">
                        <option value="0"><?php _e("Disabled", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="1"><?php _e("Enabled", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>

                    <?php
                    $tags = \samyar\serviceTag::where(['status' => 1]);
                    ?>
                    <label><?php _e("Service Tags", SAMYAR_TEXT_DOMAIN); ?></label>
                    <select id="service-tag-select" class="form-control select2" name="tags[]" style="width: 100%;" multiple="multiple">
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?php echo esc_attr($tag->id); ?>"
                                    data-icon="<?php echo esc_attr($tag->icon); ?>"
                                    data-background-color="<?php echo esc_attr($tag->background_color); ?>">
                                <?php echo esc_attr($tag->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label><?php _e("Service Link Type (Not Required)", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="radio" value="default" id="default" name="link-type" checked>
                    <label class="link-type" style="margin: 10px 12px;" for="default"><?php _e("Default", SAMYAR_TEXT_DOMAIN); ?></label>

                    <a href="#" class="button button-green show-other-types">
                        <?php _e("View Other Types", SAMYAR_TEXT_DOMAIN); ?>
                        <i class="fal fa-chevron-down"></i>
                    </a>
                    <?php

                    $types = get_link_types();

                    foreach ($types as $brand => $data) {
                        ?>
                        <fieldset class="link-type-fieldset">
                            <legend><?= kando_persian_text($brand) ?></legend>
                            <?php
                            $checked = "";
                            foreach ($data as $k => $t) {
                                ?>
                                <input type="radio" value="<?= $k ?>" id="<?= $k ?>" name="link-type">
                                <label class="link-type" for="<?= $k ?>"><?= $t ?></label>
                                <?php
                            }
                            ?>
                        </fieldset>
                        <?php
                    }
                    ?>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Quality", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="quality" placeholder="<?php _e("Example: Real - Nice Quality", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Speed", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="speed" placeholder="<?php _e("Example: Fast | Super Fast | 50k/day", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <label><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></label>
                    <?php wp_editor('', 'description', array(
                        'media_buttons' => false,
                        'drag_drop_upload' => false
                    )); ?>

                    <?php kando_language_translations_ui(); ?>
                    <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e("Submit", SAMYAR_TEXT_DOMAIN); ?>"/>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(".text-emoji").emojioneArea({
            pickerPosition: "bottom",
            tonesStyle: "bullet"
        });

        jQuery('#refill_enable').on('change', function () {
            if (this.value == 1) {
                jQuery('.refill_type_container').slideDown(400, 'easeOutCubic');//نمایش بده
            } else {
                jQuery('.refill_type_container').slideUp(400, 'easeOutCubic');//مخفی کن
            }
        });
    });
</script>

<script>
    jQuery(document).ready(function ($) {
        $('#service-tag-select').select2({
            templateResult: formatTag, // فرمت‌دهی آیتم‌ها در dropdown
            templateSelection: formatTagSelection, // فرمت‌دهی آیتم‌های انتخاب‌شده
            // closeOnSelect: false // برای جلوگیری از بسته شدن dropdown پس از هر انتخاب
        });

        // تابع برای فرمت‌دهی آیتم‌ها در dropdown
        function formatTag(tag) {
            if (!tag.id) {
                return tag.text;
            }
            var $tag = $(
                '<span class="button service-tag ' + $(tag.element).data('background-color') + '">' +
                '<i class="' + $(tag.element).data('icon') + '"></i>' + tag.text + '</span>'
            );
            return $tag;
        }

        // تابع برای فرمت‌دهی آیتم‌های انتخاب‌شده
        function formatTagSelection(tag) {
            if (!tag.id) {
                return tag.text;
            }
            var $tag = $(
                '<span class="button service-tag ' + $(tag.element).data('background-color') + '">' +
                '<i class="' + $(tag.element).data('icon') + '"></i>' + tag.text + '</span>'
            );
            return $tag;
        }
    });
</script>