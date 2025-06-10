<?php

use samyar\Category;
use samyar\Provider;

if (is_user_logged_in()):
    $categories = Category::where(['order' => 'ASC', 'order_by' => 'sort', 'status' => 1]);
    $providers = Provider::all();
    ?>
    <div class="kt-modal-inner kt-service-modal">
        <i class="kt-modal-close"></i>
        <div class="kt-modal-content">
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
                        <input type="text" name="name" placeholder="نام خدمت"/>
                        <label>لطفا دسته ای انتخاب نمایید</label>
                        <select name="cate_id">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <label>حداقل</label>
                                <input type="text" name="min" placeholder="حداقل تعداد"/>
                            </div>
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <label>حداکثر</label>
                                <input type="text" name="max" placeholder="حداکثر تعداد"/>
                            </div>
                        </div>
                        <label>لطفا نوع سرویس را انتخاب نمایید</label>
                        <select name="type">
                            <?php
                            $service_type_array = array(
                                'default' => "پیشفرض",
                                'subscriptions' => "subscriptions",
                                'custom_comments' => "custom comments",
                                'custom_comments_package' => 'custom comments package',
                                'mentions' => 'mentions',
                                'mentions_with_hashtags' => 'mentions with hashtags',
                                'mentions_custom_list' => 'mentions custom list',
                                'mentions_hashtag' => 'mentions hashtag',
                                'mentions_user_followers' => 'mentions user followers',
                                'mentions_media_likers' => 'mentions media likers',
                                'package' => 'package',
                                'comment_likes' => 'comment likes'
                            );

                            foreach ($service_type_array as $type => $service_type) {
                                ?>
                                <option value="<?= $type ?>"><?= $service_type ?></option>
                            <?php } ?>
                        </select>
                        <label>سرمایه گذاری قطره ای</label>
                        <select name="dripfeed">
                            <option value="0">غیرفعال</option>
                            <option value="1">فعال</option>
                        </select>
                        <label>پر کردن مجدد</label>
                        <select name="refill">
                            <option value="0">غیرفعال</option>
                            <option value="1">فعال</option>
                        </select>
                        <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                            <label>قیمت اصلی(قیمتی که شما خرید می کنید)</label>
                            <input type="number" name="original_price" step="any" style="padding: 9px 15px;float: right;width: calc(100% - 150px);margin-left: 10px;" placeholder="قیمت اصلی"/>
                            <span id="api_currency" class="float-right" style="font-size: 20px"></span>

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
                        <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                            <input type="hidden" value="0" name="disable-representation">
                            <input type="checkbox" value="1" id="disable-representation" name="disable-representation">
                            <label for="disable-representation">قیمت های نمایندگی برای این سرویس غیر فعال شود</label>
                        </div>
                        <div class="kt-col-xs-12 service-rate" style="margin-top:15px">
                            <div class="kt-col-xs-3 kt-col-md-3">
                                نوع
                            </div>
                            <div class="kt-col-xs-3 kt-col-md-3">
                                قیمت دلخواه (<?php kando_get_currency_base_text() ?>)
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
                        <div class="kt-col-xs-12 service-rate">
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
                        <span class="representation-rates">
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
                        <textarea class="new-api-form-text" name="description" placeholder="توضیحات"></textarea>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="ارسال"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
endif;