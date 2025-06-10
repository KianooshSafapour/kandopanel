<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Provider;
use samyar\Service;
use samyar\Smeta;

$options = settingsController::getInstance();
$categories = Category::where(['order' => 'ASC', 'order_by' => 'sort']);
$providers = Provider::all();

$service_id = $_GET['id'];
$service = Service::find($service_id);

$currency = "";
$api_currency_display = "none";
$manual_currency_display = "none";
$USD_rate = $options->get_option('new-currecry-rate');//نرخ دلار رو از تنظیمات می گیریم
$convert_to_toman = "";

$is_service_free = get_service_meta($service->id, 'is-service-free', true);
$is_free_number = get_service_meta($service->id, 'is-free-number', true);


if ($service):
    ?>
    <div class="kt-row">
        <form method="POST" class="samyar-form new-service-form">
            <div class="column kt-col-xs-12 kt-col-md-5 float-left">
                <div class="new-ticket-help">
                    <ul>
                        <li>اگر قیمت را پر نمایید همین قیمت به صورت قیمت نهایی محصول به مشتری نمایش داده خواهد شد</li>
                        <li>اگر قیمت را خالی بگذارید و نرخ سود را به صورت درصد وارد نمایید قیمت نهایی بر اساس اضافه کردن نرخ این سود به قیمت اصلی محاسبه خواهد شد</li>
                        <li>اگر قیمت و نرخ سود را خالی بگذارید قیمت نهایی محصول با نرخ عمومی که در تنظیمات قالب مشخص شده است محاسبه خواهد شد</li>
                    </ul>
                </div>
                <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                    <label>قیمت اصلی(قیمتی که شما خرید می کنید)</label>
                    <?php
                    if ($service->add_type === "manual") {
                        switch ($service->manual_currency) {
                            case "USD":

                                $original_price = number_format($service->original_price, 4);
                                $convert_to_toman = number_format($service->original_price * $USD_rate, 0);
                                break;
                            case "IRR":
                            case "IRT":
                                $original_price = number_format($service->original_price, 0, '', '');
                                break;
                            default:
                                $original_price = "";
                                break;
                        }
                    } else {
                        $provider = Provider::find($service->api_provider_id);
                        switch ($provider->base_currency) {
                            case "USD":

                                $original_price = number_format($service->original_price, 4);
                                $convert_to_toman = number_format($service->original_price * $USD_rate, 0);
                                break;
                            case "IRR":
                            case "IRT":
                                $original_price = number_format($service->original_price, 0, '', '');
                                break;
                            default:
                                $original_price = "";
                                break;
                        }
                    }

                    ?>
                    <input type="text" name="original_price" step="any" style="padding: 9px 15px;float: right;width: calc(100% - 150px);margin-left: 10px;"
                           value="<?php echo esc_attr($original_price) ?>" placeholder="قیمت اصلی"/>
                    <?php
                    if ($service->add_type === "manual") {//اگر دستی بود
                        $manual_currency_display = 'block';
                    } else {
                        if ($service->api_provider_id && $service->api_provider_id !== "0") {//اگر api بود
                            $api_currency_display = 'block';
                            $provider = Provider::find($service->api_provider_id);
                            $currency = get_currency_text($provider->base_currency, false);
                        }
                    }
                    ?>
                    <span id="api_currency" style="font-size: 20px;display:<?= $api_currency_display ?>"><?= $currency ?></span>
                    <select id="manual_currency" style='width: 20%;padding: 9px;display:<?= $manual_currency_display ?>' name="manual_currency">
                        <option <?= ($service->manual_currency === 'USD' ? 'selected' : '') ?> value="USD">دلار</option>
                        <option <?= ($service->manual_currency === 'IRT' ? 'selected' : '') ?> value="IRT">تومان</option>
                        <option <?= ($service->manual_currency === 'IRR' ? 'selected' : '') ?> value="IRR">ریال</option>
                    </select>
                    <?php if (!empty($convert_to_toman)): ?>
                        <span style="font-size:13px;float: right;">تبدیل به <?php kando_get_currency_base_text(true) ?>: <b><?= $convert_to_toman ?><?php kando_get_currency_base_text(true) ?> </b>    </span>
                    <?php endif; ?>
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
                    <input type="checkbox" value="1" id="is-service-free" <?php if ($is_service_free): ?>checked<?php endif; ?> name="is-service-free">
                    <label style="margin: 20px 0;" for="is-service-free">این سرویس رایگان است</label>
                    <div class="kt-col-xs-12 service-free" <?php if (!$is_service_free): ?>style="display: none;"<?php endif; ?>>
                        <div class="kt-col-xs-3 kt-col-md-2" style="margin-top: 11px;font-size: 14px;">
                            کاربر روزی
                        </div>
                        <div class="service-rate-padding kt-col-xs-3 kt-col-md-2">
                            <input type="number" name="is-free-number" placeholder="" value="<?= $is_free_number ?>"/>
                        </div>
                        <div class="service-rate-padding kt-col-xs-6 kt-col-md-8" style="margin-top: 11px;font-size: 14px;">
                            بار قادر به ارسال سفارش رایگان باشد.
                        </div>
                    </div>
                </div>
                <?php
                $representation_active = !empty($options->get_option('representation-active')) ? $options->get_option('representation-active') : 0;
                if ($representation_active):
                    ?>
                    <div class="kt-col-xs-12 service-rate not-free" style="margin-top:15px;<?php if ($is_service_free): ?>display: none;<?php endif; ?>">
                        <?php
                        $disable_representation = $service->disable_representation;
                        ?>
                        <input type="hidden" value="0" name="disable-representation">
                        <input type="checkbox" value="1" <?php if ($disable_representation): ?>checked<?php endif; ?> id="disable-representation" name="disable-representation">
                        <label style="margin: 20px 0;" for="disable-representation">قیمت های نمایندگی برای این سرویس غیر فعال شود</label>
                    </div>
                <?php endif; ?>
                <div class="kt-col-xs-12 service-rate not-free" style="margin-top:15px;<?php if ($is_service_free): ?>display: none;<?php endif; ?>">
                    <div class="kt-col-xs-3 kt-col-md-3">
                        نوع(قیمت در سایت)
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        قیمت دلخواه (<?php kando_get_currency_base_text(true) ?>)
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        نرخ دلخواه (درصد)
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        نرخ عمومی در تنظیمات (درصد)
                    </div>
                </div>
                <?php
                //دریافت تنظیمات عمومی

                $representation_level_0 = !empty($options->get_option('representation-level-0')) ? $options->get_option('representation-level-0') : 0;
                $representation_level_1 = !empty($options->get_option('representation-level-1')) ? $options->get_option('representation-level-1') : 0;
                $representation_level_2 = !empty($options->get_option('representation-level-2')) ? $options->get_option('representation-level-2') : 0;
                $representation_level_3 = !empty($options->get_option('representation-level-3')) ? $options->get_option('representation-level-3') : 0;
                ?>
                <div class="kt-col-xs-12 service-rate not-free" <?php if ($is_service_free): ?>style="display:none"<?php endif; ?>>
                    <div class="kt-col-xs-3 kt-col-md-3" style="">
                        کاربر عادی
                        <br>(<?= kando_number_format_currency((calculate_representation_price($service->id, 0)),true) ?>)
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="price" placeholder="قیمت" value="<?php echo esc_attr($service->price) ?>"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="profit_rate" placeholder="نرخ سود" value="<?php echo esc_attr($service->profit_rate) ?>"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_0 ?>"/>
                    </div>
                </div>

                <!-- شروع قیمت های نمایندگی -->
                <?php

                if ($representation_active):
                    ?>
                    <?php
                    $representation_rates = [
                        '1' => [
                            'price' => "",
                            'profit_rate' => ""
                        ],
                        '2' => [
                            'price' => "",
                            'profit_rate' => ""
                        ],
                        '3' => [
                            'price' => "",
                            'profit_rate' => ""
                        ]
                    ];
                    if ($service->representation_rates) {
                        $representation_rates = json_decode($service->representation_rates, true);
                    }

                    ?>
                    <span class="representation-rates  not-free" <?php if ($disable_representation || $is_service_free): ?>style="display:none"<?php endif; ?>>
                <div class="kt-col-xs-12 service-rate">
                    <div class="kt-col-xs-3 kt-col-md-3" style="">
                        نمایندگی برنزی
                        <br>(<?= kando_number_format_currency((calculate_representation_price($service->id, 3)),true) ?> <?php kando_get_currency_base_text(true) ?>)
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[3][price]" placeholder="قیمت" value="<?= esc_attr($representation_rates[3]['price']) ?>"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[3][profit_rate]" placeholder="نرخ سود" value="<?= esc_attr($representation_rates[3]['profit_rate']) ?>"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_3 ?>"/>
                    </div>
                </div>
                <div class="kt-col-xs-12 service-rate">
                    <div class="kt-col-xs-3 kt-col-md-3" style="">
                        نمایندگی نقره ای
                       <br>( <?= kando_number_format_currency((calculate_representation_price($service->id, 2)),true) ?> <?php kando_get_currency_base_text(true) ?>)
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[2][price]" placeholder="قیمت" value="<?= esc_attr($representation_rates[2]['price']) ?>"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[2][profit_rate]" placeholder="نرخ سود" value="<?= esc_attr($representation_rates[2]['profit_rate']) ?>"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_2 ?>"/>
                    </div>
                </div>
                <div class="kt-col-xs-12 service-rate">
                    <div class="kt-col-xs-3 kt-col-md-3" style="">
                        نمایندگی طلایی
                          <br>(<?= kando_number_format_currency((calculate_representation_price($service->id, 1)),true) ?> <?php kando_get_currency_base_text(true) ?>)
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[1][price]" placeholder="قیمت" value="<?= esc_attr($representation_rates[1]['price']) ?>"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[1][profit_rate]" placeholder="نرخ سود" value="<?= esc_attr($representation_rates[1]['profit_rate']) ?>"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_1 ?>"/>
                    </div>
                </div>
            </span>
                    <!-- پایان قیمت های نمایندگی -->
                <?php endif; ?>
            </div>
            <div class="column kt-col-xs-12 kt-col-md-6 float-left">
                <div class="new-api-form-outer">
                    <h4 class="new-ticket-title">ویرایش سرویس</h4>
                    <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی ارسال کلیک کنید</span>

                    <input type="hidden" name="action" value="samyar_service_edit">
                    <input type="hidden" name="id" value="<?php echo esc_attr($service->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <input type="text" class="text-emoji" name="name" value="<?php echo esc_attr($service->name) ?>" placeholder="نام خدمت" data-emojiable="true"/>
                        <label>لطفا دسته ای انتخاب نمایید</label>
                        <select name="cate_id">
                            <?php foreach ($categories as $category): ?>
                                <option <?php if ($category->id == $service->cate_id): ?>selected<?php endif; ?>
                                        value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <input type="text" name="min" value="<?php echo esc_attr($service->min) ?>" placeholder="حداقل تعداد"/>
                            </div>
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <input type="text" name="max" value="<?php echo esc_attr($service->max) ?>" placeholder="حداکثر تعداد"/>
                            </div>
                        </div>
                        <label>لطفا نوع سرویس را انتخاب نمایید</label>
                        <select name="type" id="select-service-type">
                            <?php
                            $service_type_array = array(
                                'default' => "پیشفرض",
                                'subscriptions' => "subscriptions",
                                'custom_comments' => "custom_comments",
                                'custom_comments_package' => 'custom_comments_package',
                                'mentions_with_hashtags' => 'mentions_with_hashtags',
                                'mentions' => 'mentions',
                                'mentions_custom_list' => 'mentions_custom_list',
                                'mentions_hashtag' => 'mentions_hashtag',
                                'mentions_user_followers' => 'mentions_user_followers',
                                'mentions_media_likers' => 'mentions_media_likers',
                                'package' => 'package',
                                'comment_likes' => 'comment_likes',
                                'poll' => 'Poll',
                                'comment_replies' => 'Comment Replies',
                                'invites_from_groups' => 'Invites From Groups'
                            );
                            $service_type_array = apply_filters( 'kando_type_list',$service_type_array );
                            foreach ($service_type_array as $type => $service_type) {
                                ?>
                                <option value="<?= $type ?>" <?= ($service->type && $service->type == $type) ? 'selected' : '' ?>><?= $service_type ?></option>
                            <?php } ?>
                        </select>
                        <?php do_action('kando_service_form_after_type',esc_attr($service->id),$service->type); ?>
                        <label>سرمایه گذاری قطره ای</label>
                        <select name="dripfeed">
                            <option value="0" <?php if ($service->dripfeed === "0"): ?>selected<?php endif; ?>>غیرفعال</option>
                            <option value="1" <?php if ($service->dripfeed === "1"): ?>selected<?php endif; ?>>فعال</option>
                        </select>
                        <label>نوع</label>
                        <select name="add_type" id="service_add_type_select">
                            <option value="manual" <?php if ($service->add_type === "manual"): ?>selected<?php endif; ?>>دستی</option>
                            <option value="api" <?php if ($service->add_type === "api"): ?>selected<?php endif; ?>>API</option>
                        </select>
                        <div class="kt-row" id="add_type_api" <?php if ($service->add_type === "manual"): ?>style="display: none"<?php endif; ?>>
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <label>انتخاب ارائه دهنده api</label>
                                <select name="api_provider_id">
                                    <option value="0">انتخاب ارائه دهنده</option>
                                    <?php foreach ($providers as $provider): ?>
                                        <option <?php if ($service->api_provider_id == $provider->id): ?>selected<?php endif; ?>
                                                value="<?php echo esc_attr($provider->id) ?>"><?php echo esc_attr($provider->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <label>شناسه سرویس را وارد کنید</label>
                                <input type="text" name="api_service_id" value="<?php echo esc_attr($service->api_service_id) ?>" placeholder="شناسه سرویس (ServiceID) API"/>
                            </div>
                        </div>
                        <!--
                        <label>قیمت اصلی(قیمتی که شما خرید می کنید)</label>
                        <input type="text" name="original_price" style="padding: 9px 15px;float: right;width: calc(100% - 150px);margin-left: 10px;"
                               value="<?php echo esc_attr($service->original_price) ?>" placeholder="قیمت اصلی"/>
						<?php
                        if ($service->add_type === "manual") {//اگر دستی بود
                            $manual_currency_display = 'block';
                        } else {
                            if ($service->api_provider_id && $service->api_provider_id !== "0") {//اگر api بود
                                $api_currency_display = 'block';
                                $provider = Provider::find($service->api_provider_id);
                                $currency = get_currency_text($provider->base_currency, false);
                            }
                        }
                        ?>
                        <span id="api_currency" style="font-size: 20px;display:<?= $api_currency_display ?>"><?= $currency ?></span>
                        <select id="manual_currency" style='width: 20%;display:<?= $manual_currency_display ?>' name="manual_currency">
                            <option <?= ($service->manual_currency === 'USD' ? 'selected' : '') ?> value="USD">دلار</option>
                            <option <?= ($service->manual_currency === 'IRT' ? 'selected' : '') ?> value="IRT">تومان</option>
                            <option <?= ($service->manual_currency === 'IRR' ? 'selected' : '') ?> value="IRR">ریال</option>
                        </select>


                        <label style="float: right;">قیمت (قیمتی که می خواهید در سایت بفروشید)</label>
                        <input type="text" name="price" value="<?php echo esc_attr($service->price) ?>" placeholder="قیمت"/>

                        <label>نرخ سود(درصد) مخصوص این سفارش(اگر می خواهید از پیشفرض استفاده کنید خالی بگذارید)</label>
                        <input type="number" name="profit_rate" placeholder="نرخ سود" value="<?php echo esc_attr($service->profit_rate) ?>"/>
-->
                        <label>وضعیت</label>
                        <select name="status">
                            <option value="1" <?php if ($service->status === "1"): ?>selected<?php endif; ?>>فعال</option>
                            <option value="0" <?php if ($service->status === "0"): ?>selected<?php endif; ?>>غیرفعال</option>
                        </select>
                        <label>مرتب سازی</label>
                        <input type="text" name="sort" value="<?php echo esc_attr($service->sort) ?>" placeholder="مرتب سازی"/>
                        <label>درصد تعداد هدیه(تنها عدد)</label>
                        <input type="number" min="0" max="100" name="gift-percent-quantity" value="<?php echo $service->gift_percent_quantity ?>" placeholder="درصد"/>
                        <label>جبران ریزش(refill)</label>
                        <select name="refill" id="refill_enable">
                            <option value="0" <?php if ($service->refill === "0"): ?>selected<?php endif; ?>>غیرفعال</option>
                            <option value="1" <?php if ($service->refill === "1"): ?>selected<?php endif; ?>>فعال</option>
                        </select>
                        <div class="refill_type_container" <?php if ($service->refill == 0): ?>style="display:none"<?php endif; ?>>
                            <label>نوع جبران ریزش</label>
                            <select name="refill_type">
                                <option value="custom" <?php if ($service->refill_type === "custom"): ?>selected<?php endif; ?>>دستی</option>
                                <option value="api" <?php if ($service->refill_type === "api"): ?>selected<?php endif; ?>>بوسیله API</option>
                            </select>


                            <label>محدودیت زمانی جبران ریزش</label>
                            <select name="refill_period">
                                <option <?php if ($service->refill_period == 30): ?> selected <?php endif; ?> value="30">1 ماه</option>
                                <option <?php if ($service->refill_period == 60): ?> selected <?php endif; ?> value="60">2 ماه</option>
                                <option <?php if ($service->refill_period == 90): ?> selected <?php endif; ?> value="90">3 ماه</option>
                                <option <?php if ($service->refill_period == 180): ?> selected <?php endif; ?> value="180">6 ماه</option>
                                <option <?php if ($service->refill_period == 360): ?> selected <?php endif; ?> value="360">12 ماه</option>
                            </select>

                        </div>


                        <label>نوع لینک سرویس(ضروری نیست)</label>
                        <input type="radio" value="default" id="default" name="link-type" <?php checked( $service->link_type,"default" ); ?>>
                        <label class="link-type" style="margin: 10px 12px;" for="default">پیشفرض</label>

                        <a href="#" class="button button-green show-other-types">
                            مشاهده دیگر نوع ها
                            <i class="fal fa-chevron-down"></i>
                        </a>

                        <?php

                        $types = get_link_types();

                        foreach ($types as $brand => $data) {
                            ?>

                            <fieldset class="link-type-fieldset">
                                <legend><?=kando_persian_text($brand)?></legend>
                                <?php
                                $checked="";
                                foreach ($data as $k => $t) {
                                    ?>
                                    <input type="radio" value="<?= $k ?>" id="<?= $k ?>" <?php checked( $service->link_type,$k ); ?> name="link-type">
                                    <label class="link-type" for="<?= $k ?>"><?= $t ?></label>
                                    <?php
                                }
                                ?>
                            </fieldset>
                            <?php
                        }
                        ?>

                        <label>توضیحات</label>
                        <?php wp_editor($service->description, 'description', array(
                            'media_buttons' => false,
                            'drag_drop_upload' => false
                        )); ?>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="بروزرسانی"/>
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
<?php
endif;
