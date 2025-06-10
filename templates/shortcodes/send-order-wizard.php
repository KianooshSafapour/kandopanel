<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
$options   = settingsController::getInstance();
$categories = kando_get_category_by_enable_service();;
?>
<script type="text/javascript">
    jQuery(document).ready((function ($) {
        $(".kando-form-wizard fieldset:first").fadeIn("slow");
        var min,max;

        $(document).on("change", "#select-order-service select", function () {
            let _service_type = $(this).children("option:selected").attr("data-type");
            min = $(this).children("option:selected").attr("data-min");
            max = $(this).children("option:selected").attr("data-max");
            switch (_service_type) {

                case "subscriptions":
                    $j(".new-order-form input[name=sub_expiry]").val('');

                    $j(".new-order-form .order-default-link").addClass("d-none");
                    $j(".new-order-form .order-default-quantity").addClass("d-none");
                    $j(".new-order-form #result_total_charge").addClass("d-none");

                    $j(".new-order-form .order-comments").addClass("d-none");
                    $j(".new-order-form .order-usernames").addClass("d-none");
                    $j(".new-order-form .order-hashtags").addClass("d-none");
                    $j(".new-order-form .order-username").addClass("d-none");
                    $j(".new-order-form .order-hashtag").addClass("d-none");
                    $j(".new-order-form .order-media").addClass("d-none");

                    $j(".new-order-form .order-subscriptions").removeClass("d-none");


                    break;


                case "custom_comments":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-comments textarea").attr("required", "required");


                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");

                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input[name=quantity]").attr("disabled", true);

                    $(".new-order-form .order-subscriptions").removeAttr("required");
                    break;

                case "custom_comments_package":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-comments-custom-package").attr("required", "required");


                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-default-quantity input").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");
                    $(".new-order-form .order-subscriptions").removeAttr("required");
                    break;

                case "mentions_with_hashtags":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-usernames textarea").attr("required", "required");
                    $(".new-order-form .order-hashtags input").attr("required", "required");


                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");

                    $(".new-order-form .order-subscriptions").removeAttr("required");

                    break;
                case "mentions":
                    $j(".new-order-form .order-default-link").removeClass("d-none");
                    $j(".new-order-form .order-default-quantity").removeClass("d-none");
                    $j(".new-order-form .order-usernames-custom").removeClass("d-none");
                    $j(".new-order-form #result_total_charge").removeClass("d-none");

                    $j(".new-order-form .order-comments").addClass("d-none");
                    $j(".new-order-form .order-username").addClass("d-none");
                    $j(".new-order-form .order-usernames").addClass("d-none");
                    $j(".new-order-form .order-hashtags").addClass("d-none");
                    $j(".new-order-form .order-hashtag").addClass("d-none");
                    $j(".new-order-form .order-media").addClass("d-none");
                    $j(".new-order-form .order-subscriptions").addClass("d-none");
                    break;
                case "mentions_custom_list":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-usernames-custom").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input[name=quantity]").attr("disabled", true);

                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");

                    $(".new-order-form .order-subscriptions").removeAttr("required");

                    break;

                case "mentions_hashtag":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-hashtag input").attr("required", "required");


                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");
                    $(".new-order-form .order-subscriptions").removeAttr("required");

                    break;

                case "mentions_user_followers":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-username input").attr("required", "required");


                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");
                    $(".new-order-form .order-subscriptions").removeAttr("required");
                    break;

                case "mentions_media_likers":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-media input").attr("required", "required");


                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-subscriptions").removeAttr("required");

                    break;

                case "package":
                    $(".new-order-form .order-default-link input").attr("required", "required");



                    $(".new-order-form .order-default-quantity input").removeAttr("required");
                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");
                    $(".new-order-form .order-subscriptions").removeAttr("required");
                    let table = $('.samyar_order_table');
                    // sendOrderFormData(service_id, 1000, table);
                    break;

                case "comment_likes":
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");
                    $(".new-order-form .order-username input").attr("required", "required");


                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");
                    $(".new-order-form .order-subscriptions").removeAttr("required");

                    break;

                default:
                    $(".new-order-form .order-default-link input").attr("required", "required");
                    $(".new-order-form .order-default-quantity input").attr("required", "required");



                    $(".new-order-form .order-comments textarea").removeAttr("required");
                    $(".new-order-form .order-usernames textarea").removeAttr("required");
                    $(".new-order-form .order-hashtags input").removeAttr("required");
                    $(".new-order-form .order-username input").removeAttr("required");
                    $(".new-order-form .order-hashtag input").removeAttr("required");
                    $(".new-order-form .order-media input").removeAttr("required");

                    $(".new-order-form .order-subscriptions").removeAttr("required");

                    break;
            }
        })


        $(".kando-form-wizard .btn-next").on("click", (function () {
            var fieldset = $(this).parents("fieldset"),
                error = true,
                btn = $(this),
                stepActive = $(this).parents(".kando-form-wizard").find(".kando-form-wizard-step.active");


            // fieldset.find(".required").each((function () {
            //     $(this).val() === "" ? ($(this).addClass("input-error"), error = false) : $(this).removeClass("input-error")
            // }));

            // fieldset.find(".required").each((function () {
            //     var thisValue = $(this).val();
            //     console.log(thisValue);
            //     if (!thisValue) {
            //         // error = false;
            //         $(this).addClass("input-error");
            //         return false;
            //     // } else {
            //     //     error = true;
            //     //     $(this).removeClass("input-error");
            //     }
            //     // return error;
            // }));



            fieldset.find("[required]").each((function () {
                var thisValue = $(this).val();
                if (thisValue === "0" || thisValue === null || !thisValue) {
                    error = false;
                    $(this).addClass("input-error");
                } else {
                    error = true;
                    $(this).removeClass("input-error");
                }
                return error;
            }));

            var quantity = $('.ajaxQuantity').val();

            if(parseInt(quantity) < parseInt(min)){
                $('.alert-warning').show();
                $('.ajaxQuantity').addClass("input-error");
                return false;
            }

            if(parseInt(quantity) > parseInt(max)){
                $('.alert-warning').show();
                $('.ajaxQuantity').addClass("input-error");
                return false;
            }


            error && fieldset.fadeOut(400, (function () {
                stepActive.removeClass("active").addClass("activated").next().addClass("active"),
                    $(this).next().fadeIn();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(".kando-form-wizard").offset().top
                }, 1000);
            }))
        }));


        $(".kando-form-wizard .btn-previous").on("click", (function () {
            var stepActive = $(this).parents(".kando-form-wizard").find(".kando-form-wizard-step.active");
            $(this).parents("fieldset").fadeOut(400, (function () {
                stepActive.removeClass("active").prev().removeClass("activated").addClass("active"),
                    $(this).prev().fadeIn()
            }))
        }));

        //removed
    }))
</script>


<div class="kando-form-wizard">

    <header>
        <h5 class="kando-form-wizard-title-1">خرید آنی</h5>
        <p class="kando-form-wizard-title-2">سریعترین روش خرید</p>
    </header>

    <form role="form" id="form" class="new-order-form" action="" method="post">
        <?php wp_nonce_field('new_order_nonce', 'new_order_nonce'); ?>
        <input type="hidden" name="action" value="samyar_order_add">
        <div class="kando-form-wizard-steps">
            <div class="kando-form-wizard-progress"></div>

            <div class="kando-form-wizard-step active">
                <span class="f-w-s-bg"></span>
                <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/Bag.svg" alt="" class="f-w-s-icon Bag-filter"/>
                <p class="f-w-s-text">انتخاب سرویس</p>
                <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/form-wizard-step-arrow.png" class="f-w-s-arrow" alt="">
            </div>
            <?php if (!is_user_logged_in()): ?>
                <div class="kando-form-wizard-step">
                    <span class="f-w-s-bg"></span>
                    <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/user.svg" alt="" class="f-w-s-icon user-filter"/>
                    <p class="f-w-s-text">تایید حساب</p>
                    <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/form-wizard-step-arrow.png" class="f-w-s-arrow" alt="">
                </div>
            <?php endif; ?>
            <div class="kando-form-wizard-step">
                <span class="f-w-s-bg"></span>
                <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/Document.svg" alt="" class="f-w-s-icon Document-filter"/>
                <p class="f-w-s-text">اطلاعات سفارش</p>
            </div>

        </div>

        <fieldset class="service-selection fieldset">
            <div class="loading-wrapper">
                <div class="loader">لطفاً صبر کنید...</div>
            </div>

            <div class="form-group">

                <div class="custom-select">

                    <div class="custom-select-wrapper">
                        <select class="custom-select" name="cate_id" id="samyar_select_category" required="required">
                            <?php if ($categories): ?>
                                <option value="0" selected>لطفاً یک دسته را انتخاب کنید.</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">هیچ دسته ای برای سفارش وجود ندارد.</option>
                            <?php endif; ?>

                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group wizard-select-service" id="select-order-service" style="display: none">

                <div class="custom-select">

                    <div class="custom-select-wrapper">
                        <select class="custom-select" name="service" required="required"></select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="service-description">
                    <h5 class="s-d-title">توضیحات سرویس :</h5>
                    <p class="s-d-text"></p>
                </div>
            </div>

            <div class="form-group">
                <div class="enter-user-id order-default-link">
                    <input type="text" name="link" placeholder="لینک پست یا آیدی پیج خود را وارد کنید"
                           class="e-u-form ltr">
                </div>

            </div>
            <?php
            $enable_process_link = $options->get_option('enable-process-link', "1");
            ?>
            <?php if ($enable_process_link == 1 || $enable_process_link === "1"): ?>
            <!--
            <div class="form-group fx-o">
                <div class="buttons-id">
                    <button type="button" class="btn n-c-i-button kt-ajax-button process-link" style="background: #c73636;">
                        بررسی لینک
                    </button>
                </div>

            </div>
            -->
            <?php endif; ?>
            <div class="process-link-result"></div>
            <div class="form-group">
                <div class="custom-number ">
                    <div class="c-n-wrapper order-default-quantity">
                        <input class="c-n-input ltr ajaxQuantity" min="0" name="quantity" placeholder="تعداد مورد نظر" type="number">
                    </div>
                    <div class="alert alert-warning" style="display:none"><div class="l-f-arrow"></div> <p class="l-f">لطفا حداقل و حداکثر تعداد را رعایت فرمایید</p></div>
                </div>
            </div>

            <div class="form-group">
                <div class="order-comments c-n-wrapper d-none">
                    <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                    <textarea rows="10" name="comments" class="form-control square c-n-textarea ajax_custom_comments"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="order-comments-custom-package c-n-wrapper d-none">
                    <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                    <textarea rows="10" name="comments_custom_package" class="form-control square c-n-textarea"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="order-usernames c-n-wrapper d-none">
                    <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input type="text" class="form-control input-tags c-n-input" name="usernames" value="usenameA,usenameB,usenameC,usenameD">
                </div>
            </div>

            <div class="form-group">
                <div class="order-usernames-custom c-n-wrapper d-none">
                    <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                    <textarea rows="10" name="usernames_custom" class="form-control square ajax_custom_lists c-n-textarea"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="order-hashtags c-n-wrapper d-none">
                    <label for=""><?php _e("Hashtags (Format: #hashtag)", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input type="text" class="form-control input-tags c-n-input" name="hashtags" value="#goodphoto,#love,#nice,#sunny">
                </div>
            </div>
            <div class="form-group">
                <div class="order-hashtag c-n-wrapper d-none">
                    <label for=""><?php _e("Hashtag", SAMYAR_TEXT_DOMAIN) ?> </label>
                    <input class="form-control square c-n-input" type="text" name="hashtag">
                </div>
            </div>
            <div class="form-group">
                <div class="order-username c-n-wrapper d-none">
                    <label for=""><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input class="form-control square c-n-input" name="username" type="text">
                </div>
            </div>
            <!-- Mentions Media Likers -->
            <div class="form-group">
                <div class="order-media c-n-wrapper d-none">
                    <label for=""><?php _e("Media Url", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input class="form-control square c-n-input" name="media_url" type="link">
                </div>
            </div>

            <div class="form-group">
                <div class="order-poll c-n-wrapper d-none">
                    <label for=""><?php _e("Answer number", SAMYAR_TEXT_DOMAIN) ?> </label>
                    <input class="form-control square" type="text" dir="ltr" name="answer_number">
                </div>
            </div>

            <div class="form-group">
                <div class="order-groups c-n-wrapper d-none">
                    <label for=""><?php _e("Groups", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                    <textarea rows="10" name="groups" class="form-control square c-n-textarea"></textarea>
                </div>
            </div>

            <!-- Subscriptions  -->
            <div class="row order-subscriptions d-none">

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="text" name="sub_username">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("New posts", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="number" placeholder="<?php _e("minimum 1 post") ?>" name="sub_posts">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Old posts", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="number" placeholder="" name="sub_old_posts">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Quantity", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="number" name="sub_min" placeholder="<?php _e("min", SAMYAR_TEXT_DOMAIN) ?>">
                    </div>
                </div>
                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label>&nbsp;</label>
                        <input class="form-control square c-n-input" type="number" name="sub_max" placeholder="<?php _e("max", SAMYAR_TEXT_DOMAIN) ?>">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group">
                        <div class="custom-select">
                            <label><?php _e("Delay", SAMYAR_TEXT_DOMAIN) ?> (<?php _e("minutes", SAMYAR_TEXT_DOMAIN) ?>)</label>
                            <div class="custom-select-wrapper">
                                <select name="sub_delay" class="form-control square">
                                    <option value="0"><?php _e("No delay", SAMYAR_TEXT_DOMAIN) ?></option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="60">60</option>
                                    <option value="90">90</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Expiry", SAMYAR_TEXT_DOMAIN) ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker c-n-input hasDatepicker" name="sub_expiry" onkeydown="return false" placeholder="" id="expiry">
                            <!--
                            <span class="input-group-append">
                                        <button class="btn btn-info" type="button" onclick="document.getElementById('expiry').value = ''"><i class="fe fe-trash-2"></i></button>
                                    </span>
                                    -->

                        </div>
                    </div>
                </div>

            </div>

	        <?php
	        //	                    if (get_option("enable_drip_feed", "") == 1) {
	        ?>
            <div class="row drip-feed-option c-n-wrapper d-none">
                <div class="kt-col-md-12">

                    <div class="form-label"><?php _e("Drip-feed", SAMYAR_TEXT_DOMAIN) ?>
                        <label class="custom-switch">
                                        <span class="custom-switch-description m-r-20"><i class="fas fa-question-circle"
                                                                                          data-tooltip="<?php _e("What is Drip-feed?", SAMYAR_TEXT_DOMAIN) ?>"></i></span>

                            <input type="hidden" name="is_drip_feed" value="0">
                            <input type="checkbox" name="is_drip_feed" value="1" class="is_drip_feed custom-switch-input"
                                   data-tooltip="<?php _e("What is Drip-feed?", SAMYAR_TEXT_DOMAIN) ?>" data-toggle="collapse" data-target="#drip-feed"
                                   aria-expanded="false"
                                   aria-controls="drip-feed">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>


                    <div class="row collapse " id="drip-feed">

                        <div class="kt-col-md-6" style="padding-left: 3px">

                            <label><?php _e("Runs", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square c-n-input ajaxDripFeedRuns" type="number" name="runs" value="1">

                        </div>
                        <div class="kt-col-md-6" style="padding-right: 3px">

                            <label><?php _e("Interval (in minutes)", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square c-n-input" min="0" step="1" type="number" name="interval" value="10">
                            <!--
                                                        <select name="interval" class="form-control square">
                                                            <?php
					        for ($i = 1; $i <= 60; $i++) {
						        if ($i % 10 == 0) {
							        ?>
                                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                                <?php }
					        } ?>
                                                        </select>
-->
                        </div>

                        <div class="kt-col-md-12">

                            <label><?php _e("Total Quantity", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square c-n-input" name="total_quantity" type="number" disabled>

                        </div>
                    </div>
                </div>
            </div>
	        <?php //} ?>

            <div class="form-group">

                <div class="final-price">
                    <span class="final-price-price-is"> قیمت محاسبه شده :</span>
                    <br>
                    <!--                            <del class="final-price-number" v-show="product.has_discount">{{ price }}</del>-->
                    <span class="final-price-number">0</span>
                    <span class="final-price-toman"><?=kando_get_currency_base_text()?></span>
                </div>

            </div>


            <div class="form-group">
                <div class="kando-form-wizard-buttons">
                    <button type="button" class="btn btn-next kt-ajax-button">خرید رو ادامه بده</button>
                </div>
            </div>


        </fieldset>
        <?php if (!is_user_logged_in()): ?>
            <?php

            //اگر مدیر در تنظیمات گفته که نیازی به تایید موبایل نیست
            $enable_otp_order = $options->get_option('enable-otp-order', 1);
            ?>
            <fieldset class="check-id fieldset">
                <div class="loading-wrapper">
                    <div class="loader">لطفاً صبر کنید...</div>
                </div>
                <?php if ($enable_otp_order === "1" || $enable_otp_order) {// اگر تایید شماره همراه فعال هست ?>
                <p style="margin-top:20px;color:#AF0000">توجه: اگر می خواهید برای هر بار ارسال سفارش، نیاز به تایید شماره همراه نداشته باشید کافی است در سایت ثبت نام و وارد حساب کاربری خود
                    شوید.</p>
                <?php } ?>
                <div class="form-group">
                    <input type="tel" name="mobile"
                           placeholder="شماره تلفن همراه" class="order-phone-number required ltr" id="mobile-number" required="required">
                </div>
                <?php if ($enable_otp_order === "1" || $enable_otp_order) {// اگر تایید شماره همراه فعال هست ?>
                <div class="form-group fx-o">
                    <div class="buttons-id">
                        <a type="button" class="btn n-c-i-button kt-ajax-button samyar-wizard-verify-send">
                            ارسال کد تایید
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="verify-code"
                           placeholder="کد تایید دریافتی" id="verify-code" class="order-phone-number required ltr" required="required">
                </div>
                <?php } ?>

                <div class="form-group">
                    <div class="kando-form-wizard-buttons">
                        <button type="button" class="btn btn-previous">
                            <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/right-arrow.svg" alt="" class="right-arrow-filter">
                        </button>
                        <button type="button" class="btn btn-next kt-ajax-button">تایید اطلاعات و ادامه</button>
                    </div>
                </div>

            </fieldset>
        <?php endif; ?>
        <fieldset class="order-information">

            <div class="loading-wrapper">
                <div class="loader">لطفاً صبر کنید...</div>
            </div>


            <div class="form-group">
                <table class="shop_table"></table>

            </div>

            <div class="form-group">
                <?php
                $default_gateway = $options->get_option('default-gateway', "zarinpal");
                ?>
                <script>
                    jQuery(document).ready(function ($) {
                        if ($('input:radio[name=payment_method]').length > 0) {
                            if ($('input:radio[value=<?=$default_gateway?>]').length > 0) {
                                $("input:radio[value=<?=$default_gateway?>]").attr('checked', true);
                            }else{
                                $("input:radio[name=payment_method]:first").attr('checked', true);
                            }
                        }
                    })
                </script>
                <ul class="wc_payment_methods payment_methods methods">
                    <?php do_action('samyar_order_payments'); ?>
                </ul>
            </div>


            <?php
            $options = settingsController::getInstance();
            $enable_agree_order = $options->get_option('enable-agree-order', "1");
            $agree_order_text = $options->get_option('samyar-agree-order-text', __( "I have read and agree to [term].", SAMYAR_TEXT_DOMAIN ));

            $link = $options->get_option('samyar-agree-order-link', "");
            if (empty($link)) {
                $url = __( "Rules and regulations", SAMYAR_TEXT_DOMAIN );
            } else {
                $url = '<a href="'.$link.'" target="_blank">'.__("Rules and regulations", SAMYAR_TEXT_DOMAIN).'</a>';
            }
            $text = str_replace('[term]', $url, $agree_order_text);

            if ($enable_agree_order === "1"):
                ?>

                <div class="form-group" style="clear: both;">
                    <div class="accept-rules">
                        <p>
                            <input type="hidden" name="agree" value="0">
                            <input type="checkbox" value="1" id="agree-order" name="agree">
                            <?= $text ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>





            <div class="form-group">
                <div class="kando-form-wizard-buttons">
                    <button type="button" class="btn btn-previous">
                        <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/right-arrow.svg" alt="" class="right-arrow-filter">
                    </button>
                    <button type="submit" class="btn btn-submit kt-ajax-button" id="place_order">ادامه و پرداخت آنلاین</button>
                </div>
            </div>


        </fieldset>

    </form>

</div>

