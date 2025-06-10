<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Provider;


$categories = Category::where(['order' => 'ASC', 'order_by' => 'sort']);
$providers = Provider::all();
?>
<div class="kt-row">
    <form method="POST" class="samyar-form new-service-form">
        <div class="column kt-col-xs-12 kt-col-md-6 float-left">
            <div class="new-ticket-help">
                <ul>
                    <li>اگر قیمت را پر نمایید همین قیمت به صورت قیمت نهایی محصول به مشتری نمایش داده خواهد شد</li>
                    <li>اگر قیمت را خالی بگذارید و نرخ سود را به صورت درصد وارد نمایید قیمت نهایی بر اساس اضافه کردن نرخ این سود به قیمت اصلی محاسبه خواهد شد</li>
                    <li>اگر قیمت و نرخ سود را خالی بگذارید قیمت نهایی محصول با نرخ عمومی که در تنظیمات قالب مشخص شده است محاسبه خواهد شد</li>
                </ul>
            </div>
            <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                <label>قیمت اصلی(قیمتی که شما خرید می کنید)</label>
                <input type="number" name="original_price" step="any" style="padding: 9px 15px;float: right;width: calc(100% - 150px);margin-left: 10px;" placeholder="قیمت اصلی"/>
                <span id="manual_currency">
                        <select id="manual_currency" name="manual_currency" style="display:block;width: 20%;padding: 9px;">
                        <option value="USD">دلار</option>
                        <option value="IRT">تومان</option>
                        <option value="IRR">ریال</option>
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
                <label style="margin: 20px 0;" for="is-service-free">این سرویس رایگان است</label>
                <div class="kt-col-xs-12 service-free" style="display: none;">
                    <div class="kt-col-xs-3 kt-col-md-2" style="margin-top: 11px;font-size: 14px;">
                        کاربر روزی
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="is-free-number" placeholder=""/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-6 kt-col-md-7" style="margin-top: 11px;font-size: 14px;">
                        بار قادر به ارسال سفارش رایگان باشد.
                    </div>
                </div>
            </div>

            <div class="kt-col-xs-12 service-rate not-free" style="margin-top:15px">
                <input type="hidden" value="0" name="disable-representation">
                <input type="checkbox" value="1" id="disable-representation" name="disable-representation">
                <label style="margin: 20px 0;" for="disable-representation">قیمت های نمایندگی برای این سرویس غیر فعال شود</label>
            </div>
            <div class="kt-col-xs-12 service-rate not-free" style="margin-top:15px">
                <div class="kt-col-xs-3 kt-col-md-3">
                    نوع
                </div>
                <div class="kt-col-xs-3 kt-col-md-3">
                    قیمت دلخواه (تومان)
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
            $options = settingsController::getInstance();
            $representation_level_0 = !empty($options->get_option('representation-level-0')) ? $options->get_option('representation-level-0') : 0;
            $representation_level_1 = !empty($options->get_option('representation-level-1')) ? $options->get_option('representation-level-1') : 0;
            $representation_level_2 = !empty($options->get_option('representation-level-2')) ? $options->get_option('representation-level-2') : 0;
            $representation_level_3 = !empty($options->get_option('representation-level-3')) ? $options->get_option('representation-level-3') : 0;
            ?>
            <div class="kt-col-xs-12 service-rate not-free">
                <div class="kt-col-xs-3 kt-col-md-3" style="margin-top: 7px;">
                    کاربر عادی
                </div>
                <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                    <input type="number" name="price" placeholder="قیمت"/>
                </div>
                <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                    <input type="number" name="profit_rate" placeholder="نرخ سود"/>
                </div>
                <div class="kt-col-xs-3 kt-col-md-3">
                    <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_0 ?>"/>
                </div>
            </div>

            <!-- شروع قیمت های نمایندگی -->
            <span class="representation-rates not-free">
                <div class="kt-col-xs-12 service-rate">
                    <div class="kt-col-xs-3 kt-col-md-3" style="margin-top: 7px;">
                        نمایندگی برنزی
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[3][price]" placeholder="قیمت"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[3][profit_rate]" placeholder="نرخ سود"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_3 ?>"/>
                    </div>
                </div>
                <div class="kt-col-xs-12 service-rate">
                    <div class="kt-col-xs-3 kt-col-md-3" style="margin-top: 7px;">
                        نمایندگی نقره ای
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[2][price]" placeholder="قیمت"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[2][profit_rate]" placeholder="نرخ سود"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_2 ?>"/>
                    </div>
                </div>
                <div class="kt-col-xs-12 service-rate">
                    <div class="kt-col-xs-3 kt-col-md-3" style="margin-top: 7px;">
                        نمایندگی طلایی
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[1][price]" placeholder="قیمت"/>
                    </div>
                    <div class="service-rate-padding kt-col-xs-3 kt-col-md-3">
                        <input type="number" name="representation-level[1][profit_rate]" placeholder="نرخ سود"/>
                    </div>
                    <div class="kt-col-xs-3 kt-col-md-3">
                        <input type="number" disabled placeholder="نرخ سود" value="<?= $representation_level_1 ?>"/>
                    </div>
                </div>
            </span>
            <!-- پایان قیمت های نمایندگی -->
        </div>
        <div class="column kt-col-xs-12 kt-col-md-6 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title">افزودن سرویس جدید</h4>
                <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی افزودن کلیک کنید</span>

                <input type="hidden" name="action" value="samyar_service_add">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <input type="text" name="name" placeholder="نام خدمت" data-emojiable="true" class="text-emoji"/>
                    <label>لطفا دسته ای انتخاب نمایید</label>
                    <select name="cate_id">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>حداقل تعداد</label>
                            <input type="text" name="min" placeholder="حداقل تعداد"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>حداکثر تعداد</label>
                            <input type="text" name="max" placeholder="حداکثر تعداد"/>
                        </div>
                    </div>
                    <label>لطفا نوع سرویس را انتخاب نمایید</label>
                    <select name="type" id="select-service-type">
                        <?php
                        $service_type_array = array(
                            'default' => "پیشفرض",
                            'subscriptions' => "subscriptions",
                            'custom_comments' => "custom comments",
                            'custom_comments_package' => 'custom comments package',
                            'mentions_with_hashtags' => 'mentions with hashtags',
                            'mentions' => 'mentions',
                            'mentions_custom_list' => 'mentions custom list',
                            'mentions_hashtag' => 'mentions hashtag',
                            'mentions_user_followers' => 'mentions user followers',
                            'mentions_media_likers' => 'mentions media likers',
                            'package' => 'package',
                            'comment_likes' => 'comment likes',
                            'poll' => 'Poll',
                            'comment_replies' => 'Comment Replies',
                            'invites_from_groups' => 'Invites From Groups'
                        );
                        $service_type_array = apply_filters( 'kando_type_list',$service_type_array );
                        foreach ($service_type_array as $type => $service_type) {
                            ?>
                            <option value="<?= $type ?>"><?= $service_type ?></option>
                        <?php } ?>
                    </select>
                    <?php do_action('kando_service_form_after_type',$service_id="",$service_type=""); ?>
                    <label>سرمایه گذاری قطره ای</label>
                    <select name="dripfeed">
                        <option value="0">غیرفعال</option>
                        <option value="1">فعال</option>
                    </select>
                    <label>نوع</label>
                    <select name="add_type" id="service_add_type_select">
                        <option value="manual">دستی</option>
                        <option value="api">API</option>
                    </select>
                    <div class="kt-row" id="add_type_api" style="display: none">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>انتخاب ارائه دهنده api</label>
                            <select name="api_provider_id">
                                <?php foreach ($providers as $provider): ?>
                                    <option value="<?php echo esc_attr($provider->id) ?>"><?php echo esc_attr($provider->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>شناسه سرویس را وارد کنید</label>
                            <input type="text" name="api_service_id" placeholder="شناسه سرویس (ServiceID) API"/>
                        </div>
                    </div>
                    <label>مرتب سازی</label>
                    <input type="text" name="sort" placeholder="مرتب سازی"/>
                    <label>درصد تعداد هدیه(تنها عدد)</label>
                    <input type="number" min="0" max="100" name="gift-percent-quantity" placeholder="درصد"/>
                    <label>جبران ریزش(refill)</label>
                    <select name="refill" id="refill_enable">
                        <option value="0">غیرفعال</option>
                        <option value="1">فعال</option>
                    </select>
                    <div class="refill_type_container" style="display:none">
                        <label>نوع جبران ریزش</label>
                        <select name="refill_type">
                            <option value="custom">دستی</option>
                            <option value="api">بوسیله API</option>
                        </select>


                        <label>محدودیت زمانی جبران ریزش</label>
                        <select name="refill_period">
                            <option value="30">1 ماه</option>
                            <option value="60">2 ماه</option>
                            <option value="90">3 ماه</option>
                            <option value="180">6 ماه</option>
                            <option value="360">12 ماه</option>
                        </select>
                    </div>

                    <label>نوع لینک سرویس های این دسته(ضروری نیست)</label>
                    <input type="radio" value="default" id="default" name="link-type" checked>
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
                                <input type="radio" value="<?= $k ?>" id="<?= $k ?>" name="link-type">
                                <label class="link-type" for="<?= $k ?>"><?= $t ?></label>
                                <?php
                            }
                            ?>
                        </fieldset>
                        <?php
                    }
                    ?>

                    <label>توضیحات</label>
                    <?php wp_editor('', 'description', array(
                        'media_buttons' => false,
                        'drag_drop_upload' => false
                    )); ?>
                    <input type="submit" class="button button-green new-ticket-form-submit" value="ارسال"/>
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