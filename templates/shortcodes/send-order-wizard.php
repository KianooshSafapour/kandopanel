<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\categoryController;

$options   = settingsController::getInstance();
$categories = kando_get_category_by_enable_service();

$ctranslates = categoryController::getInstance()->get_translates();
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

        var catId = "<?= isset($cat_id) ? $cat_id : '' ?>";
        var GetQuantity = "<?= isset($_GET['quantity']) ? $_GET['quantity'] : '' ?>";
    }))
</script>


<div class="kando-form-wizard">

    <header>
        <h5 class="kando-form-wizard-title-1"><?php _e("Instant Purchase", SAMYAR_TEXT_DOMAIN) ?></h5>
        <p class="kando-form-wizard-title-2"><?php _e("The Fastest Way to Buy", SAMYAR_TEXT_DOMAIN) ?></p>
    </header>

    <form role="form" id="form" class="new-order-form" action="" method="post">
        <?php wp_nonce_field('new_order_nonce', 'new_order_nonce'); ?>
        <input type="hidden" name="action" value="samyar_order_add">
        <div class="kando-form-wizard-steps">
            <div class="kando-form-wizard-progress"></div>

            <div class="kando-form-wizard-step active">
                <span class="f-w-s-bg"></span>
                <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/Bag.svg" alt="" class="f-w-s-icon Bag-filter"/>
                <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/form-wizard-step-arrow.png" class="f-w-s-arrow" alt="">
                <p class="f-w-s-text"><?php _e("Select Service", SAMYAR_TEXT_DOMAIN) ?></p>
            </div>
            <?php if (!is_user_logged_in()): ?>
                <div class="kando-form-wizard-step">
                    <span class="f-w-s-bg"></span>
                    <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/user.svg" alt="" class="f-w-s-icon user-filter"/>
                    <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/form-wizard-step-arrow.png" class="f-w-s-arrow" alt="">
                    <p class="f-w-s-text"><?php _e("Account Verification", SAMYAR_TEXT_DOMAIN) ?></p>
                </div>
            <?php endif; ?>
            <div class="kando-form-wizard-step">
                <span class="f-w-s-bg"></span>
                <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/Document.svg" alt="" class="f-w-s-icon Document-filter"/>
                <p class="f-w-s-text"><?php _e("Order Information", SAMYAR_TEXT_DOMAIN) ?></p>
            </div>
        </div>

        <fieldset class="service-selection fieldset" style="display: contents">
            <div class="loading-wrapper">
                <div class="loader"><?php _e("Please wait...", SAMYAR_TEXT_DOMAIN) ?></div>
            </div>

            <div class="form-group">
                <div class="custom-select">
                    <div class="custom-select-wrapper">
                        <select class="custom-select" name="cate_id" id="samyar_select_category" required="required">
                            <?php if ($categories): ?>
                                <option value="0" selected><?php _e("Please select a category.", SAMYAR_TEXT_DOMAIN) ?></option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr(categoryController::getInstance()->get_title($ctranslates,$category)) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value=""><?php _e("No categories available for order.", SAMYAR_TEXT_DOMAIN) ?></option>
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
                    <h5 class="s-d-title"><?php _e("Service Description:", SAMYAR_TEXT_DOMAIN) ?></h5>
                    <p class="s-d-text"></p>
                </div>
            </div>

            <div class="form-group">
                <div class="enter-user-id order-default-link">
                    <input type="text" name="link" placeholder="<?php _e("Enter your post link or page ID", SAMYAR_TEXT_DOMAIN) ?>" class="e-u-form ltr">
                </div>
            </div>

            <?php
            $enable_process_link = kando_get_option('enable-process-link', "1");
            ?>
            <?php if ($enable_process_link == 1 || $enable_process_link === "1"): ?>
                <!--
            <div class="form-group fx-o">
                <div class="buttons-id">
                    <button type="button" class="btn n-c-i-button kt-ajax-button process-link" style="background: #c73636;">
                        <?php _e("Check Link", SAMYAR_TEXT_DOMAIN) ?>
                    </button>
                </div>
            </div>
            -->
            <?php endif; ?>

            <div class="process-link-result"></div>

            <div class="form-group">
                <div class="custom-number">
                    <div class="c-n-wrapper order-default-quantity">
                        <input class="c-n-input ltr ajaxQuantity" min="0" name="quantity" placeholder="<?php _e("Desired Quantity", SAMYAR_TEXT_DOMAIN) ?>" type="number">
                    </div>
                    <div class="alert alert-warning" style="display:none">
                        <div class="l-f-arrow"></div>
                        <p class="l-f"><?php _e("Please respect the minimum and maximum quantity.", SAMYAR_TEXT_DOMAIN) ?></p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="order-comments c-n-wrapper d-none">
                    <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?> <?php _e("(1 per line)", SAMYAR_TEXT_DOMAIN) ?></label>
                    <textarea rows="10" name="comments" class="form-control square c-n-textarea ajax_custom_comments"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="order-comments-custom-package c-n-wrapper d-none">
                    <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?> <?php _e("(1 per line)", SAMYAR_TEXT_DOMAIN) ?></label>
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
                    <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?> <?php _e("(1 per line)", SAMYAR_TEXT_DOMAIN) ?></label>
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
                    <label for=""><?php _e("Hashtag", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input class="form-control square c-n-input" type="text" name="hashtag">
                </div>
            </div>

            <div class="form-group">
                <div class="order-username c-n-wrapper d-none">
                    <label for=""><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input class="form-control square c-n-input" name="username" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="order-media c-n-wrapper d-none">
                    <label for=""><?php _e("Media URL", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input class="form-control square c-n-input" name="media_url" type="link">
                </div>
            </div>

            <div class="form-group">
                <div class="order-poll c-n-wrapper d-none">
                    <label for=""><?php _e("Answer Number", SAMYAR_TEXT_DOMAIN) ?></label>
                    <input class="form-control square" type="text" dir="ltr" name="answer_number">
                </div>
            </div>

            <div class="form-group">
                <div class="order-groups c-n-wrapper d-none">
                    <label for=""><?php _e("Groups", SAMYAR_TEXT_DOMAIN) ?> <?php _e("(1 per line)", SAMYAR_TEXT_DOMAIN) ?></label>
                    <textarea rows="10" name="groups" class="form-control square c-n-textarea"></textarea>
                </div>
            </div>

            <!-- Subscriptions -->
            <div class="row order-subscriptions d-none">
                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="text" name="sub_username">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("New Posts", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="number" placeholder="<?php _e("Minimum 1 post", SAMYAR_TEXT_DOMAIN) ?>" name="sub_posts">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Old Posts", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="number" placeholder="" name="sub_old_posts">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label><?php _e("Quantity", SAMYAR_TEXT_DOMAIN) ?></label>
                        <input class="form-control square c-n-input" type="number" name="sub_min" placeholder="<?php _e("Min", SAMYAR_TEXT_DOMAIN) ?>">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group c-n-wrapper">
                        <label>&nbsp;</label>
                        <input class="form-control square c-n-input" type="number" name="sub_max" placeholder="<?php _e("Max", SAMYAR_TEXT_DOMAIN) ?>">
                    </div>
                </div>

                <div class="kt-col-md-6">
                    <div class="form-group">
                        <div class="custom-select">
                            <label><?php _e("Delay", SAMYAR_TEXT_DOMAIN) ?> (<?php _e("Minutes", SAMYAR_TEXT_DOMAIN) ?>)</label>
                            <div class="custom-select-wrapper">
                                <select name="sub_delay" class="form-control square">
                                    <option value="0"><?php _e("No Delay", SAMYAR_TEXT_DOMAIN) ?></option>
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drip-feed Section -->
            <div class="row drip-feed-option c-n-wrapper d-none">
                <div class="kt-col-md-12">
                    <div class="form-label"><?php _e("Drip-feed", SAMYAR_TEXT_DOMAIN) ?>
                        <label class="custom-switch">
                            <span class="custom-switch-description m-r-20">
                                <i class="fas fa-question-circle" data-tooltip="<?php _e("What is Drip-feed?", SAMYAR_TEXT_DOMAIN) ?>"></i>
                            </span>
                            <input type="hidden" name="is_drip_feed" value="0">
                            <input type="checkbox" name="is_drip_feed" value="1" class="is_drip_feed custom-switch-input" data-tooltip="<?php _e("What is Drip-feed?", SAMYAR_TEXT_DOMAIN) ?>" data-toggle="collapse" data-target="#drip-feed" aria-expanded="false" aria-controls="drip-feed">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <div class="row collapse" id="drip-feed">
                        <div class="kt-col-md-6" style="padding-left: 3px">
                            <label><?php _e("Runs", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square c-n-input ajaxDripFeedRuns" type="number" name="runs" value="1">
                        </div>

                        <div class="kt-col-md-6" style="padding-right: 3px">
                            <label><?php _e("Interval (in minutes)", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square c-n-input" min="0" step="1" type="number" name="interval" value="10">
                        </div>

                        <div class="kt-col-md-12">
                            <label><?php _e("Total Quantity", SAMYAR_TEXT_DOMAIN) ?></label>
                            <input class="form-control square c-n-input" name="total_quantity" type="number" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="final-price">
                    <span class="final-price-price-is"><?php _e("Calculated Price:", SAMYAR_TEXT_DOMAIN) ?></span>
                    <br>
                    <span class="final-price-number">0</span>
<!--                    <span class="final-price-toman">--><?php //= kando_get_currency_base_text() ?><!--</span>-->
                </div>
            </div>

            <div class="form-group">
                <div class="kando-form-wizard-buttons">
                    <button type="button" class="btn btn-next kt-ajax-button"><?php _e("Continue Purchase", SAMYAR_TEXT_DOMAIN) ?></button>
                </div>
            </div>
        </fieldset>

        <?php if (!is_user_logged_in()): ?>
            <?php
            $enable_otp_order = (bool)kando_get_option('enable-otp-order', 1);
            $email_verification = (bool)kando_get_option('enable-email-verification', 0);
            $note = __("Note: If you don't need to confirm the mobile number for each order, just register on the site and log in to your account.", SAMYAR_TEXT_DOMAIN);
            if($email_verification){
                $note = __("Note: If you don't need to confirm the email for each order, just register on the site and log in to your account.", SAMYAR_TEXT_DOMAIN);
            }
            ?>
            <fieldset class="check-id fieldset">
                <div class="loading-wrapper">
                    <div class="loader"><?php _e("Please wait...", SAMYAR_TEXT_DOMAIN) ?></div>
                </div>
                <?php if ($enable_otp_order): ?>
                    <p style="margin-top:20px;color:#AF0000"><?php echo $note; ?></p>
                <?php endif; ?>
                <?php if($email_verification){ ?>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="<?php _e("Email", SAMYAR_TEXT_DOMAIN) ?>" class="order-phone-number required ltr" id="email" required="required">
                    </div>

                <?php }else{ ?>
                    <div class="form-group">
                        <input type="tel" name="mobile" placeholder="<?php _e("Mobile Number", SAMYAR_TEXT_DOMAIN) ?>" class="order-phone-number required ltr" id="mobile-number" required="required">
                    </div>
                <?php } ?>
                <?php if ($enable_otp_order === "1" || $enable_otp_order): ?>
                    <div class="form-group fx-o">
                        <div class="buttons-id">
                            <a type="button" style="border-radius: 5px;padding: 6px 18px" class="btn n-c-i-button kt-ajax-button samyar-wizard-verify-send">
                                <?php _e("Send Verification Code", SAMYAR_TEXT_DOMAIN) ?>
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="verify-code" placeholder="<?php _e("Verification Code", SAMYAR_TEXT_DOMAIN) ?>" id="verify-code" class="order-phone-number required ltr" required="required">
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <div class="kando-form-wizard-buttons">
                        <button type="button" class="btn btn-previous">
                            <img src="<?= SAMYAR_DIR_IMG ?>/form-wizard/right-arrow.svg" alt="" class="right-arrow-filter">
                        </button>
                        <button type="button" class="btn btn-next kt-ajax-button"><?php _e("Confirm details and proceed", SAMYAR_TEXT_DOMAIN); ?></button>
                    </div>
                </div>

            </fieldset>
        <?php endif; ?>
        <fieldset class="order-information">

            <div class="loading-wrapper">
                <div class="loader"><?php _e("Please wait...", SAMYAR_TEXT_DOMAIN); ?></div>
            </div>


            <div class="form-group">
                <table class="shop_table"></table>

            </div>

            <div class="form-group">
                <?php include (SAMYAR_DIR_TEMPLATE.'/gateways-list/gateways-list.php') ?>
            </div>


            <?php
            $enable_agree_order = kando_get_option('enable-agree-order', "1");
            $agree_order_text = kando_get_option('samyar-agree-order-text', __("I have read and agree to [term].", SAMYAR_TEXT_DOMAIN));
            $link = kando_get_option('samyar-agree-order-link', "");

            // تعیین URL بر اساس وجود یا عدم وجود لینک
            $url = empty($link)
                ? __("Rules and regulations", SAMYAR_TEXT_DOMAIN)
                : sprintf(
                    '<a class="terms-tag" href="%s" target="_blank">%s</a>',
                    esc_url($link),
                    __("Rules and regulations", SAMYAR_TEXT_DOMAIN)
                );

            // جایگزینی [term] با URL
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
                    <button type="submit" class="btn btn-submit kt-ajax-button" id="place_order"><?php _e("Continue and pay online", SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>


        </fieldset>

    </form>

</div>

<script>
    jQuery(function($) {
        var $form = $('.kando-form-wizard');
        if (!$form.length) return;

        kandoSetDefaultGateway($form);
        kandoToggleCardSelect($form);
        // روش صحیح: تابع را مستقیماً پاس دهید، نه نتیجه آن را
        $(document).on("change", '.kando-form-wizard #payment_method', function() {
            kandoToggleCardSelect($form);
        });

        $(document).on("change", '.kando-form-wizard input[name="payment_method"]', function() {
            kandoToggleCardSelect($form);
        });
    });
</script>
