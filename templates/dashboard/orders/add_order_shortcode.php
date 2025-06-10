<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Provider;
use samyar\Service;
use samyar\Smeta;
use samyar\Social;
use samyar\walletController;

$options = settingsController::getInstance();
$enable_average_time = $options->get_option('enable-average-time', 1);
$categories = kando_get_category_by_enable_service();


if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $order = \samyar\Order::find_where(['id'=>$order_id,'uid'=>get_current_user_id()]);
    if($order){
        $service = Service::find($order->service_id);
    }

} else {
    $order_id = "";
}

$socials = Social::where(['order' => 'ASC', 'order_by' => 'sort', 'status' => 1]);
if (isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] === "fast-order") {
    $fast_order = 1;
} else {
    $fast_order = 0;
}

if (isset($_GET['cat_id']) && !empty($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];
} elseif (!empty($order_id) && $order) {
    $cat_id = $service->cate_id;
} else {
    $cat_id = "";
}

if (isset($_GET['service_id']) && !empty($_GET['service_id'])) {
    $service_id = $_GET['service_id'];
} elseif (!empty($order_id) && $order) {
    $service_id = $service->id;
} else {
    $service_id = "";
}

$enable_send_order_mass = $options->get_option('enable-send-order-mass', 1);
if (isset($service_id) && !empty($service_id)): ?>
    <script type="text/javascript">
        jQuery(window).on('load', function () {

            <?php if(isset($service_id) && !empty($service_id)){ ?>
            jQuery("#select-order-service select")
                .val("<?=$service_id?>")
                .trigger('change');
            <?php } ?>

            <?php if(isset($_GET['quantity']) && !empty($_GET['quantity'])){ ?>
            jQuery(".ajaxQuantity").val(<?=$_GET['quantity']?>).trigger('input');
            <?php } ?>

            jQuery("#select-order-service select").change(function () {
                samyarShowServiceInfo();
            });

        });


        jQuery(function () {


            jQuery("#select-order-service select")
                .val("<?=$service_id?>")
                .trigger('change');

            jQuery("#select-order-service select").change(function () {
                samyarShowServiceInfo();
            });


        });


    </script>
<?php endif; ?>

<?php if(kando_get_option( 'enable-only-logo-brand',0)==1){ ?>
<style>
    .brand-company .media-body{
        display: none;
    }

    .brand-company .kt-col-md-3{
        display: flex;
        width: auto;
    }

    .brand-company .media .icon {
        margin-right: 0;
    }
</style>
<?php } ?>
<div class="kt-row kando-sendo-order-box">
    <?php $enable_show_brands = $options->get_option('enable-show-brands', 1); ?>
    <?php if (!$fast_order && $enable_show_brands == 1 && $socials) { ?>
        <div class="column kt-col-xs-12 kt-col-md-12 brand-company">

            <div class="dashboard-posts-box">
                <div class="dashboard-posts-list" style="padding: 10px 25px;">
                    <div class="kt-row">
                        <?php foreach ($socials as $social): ?>
                            <div class="kt-col-xs-6 kt-col-md-3">
                                <a href="#" class="media brand-category" data-tooltip="<?= $social->name ?>" data-id="<?= $social->id ?>">
                                    <div class="icon"><i class="<?= $social->icon ?>" aria-hidden="true"></i></div>
                                    <span class="media-body"><?= $social->name ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <div class="kt-col-xs-6 kt-col-md-3">
                            <a href="#" class="media brand-category" data-id="others" data-tooltip="<?php _e("Other", SAMYAR_TEXT_DOMAIN); ?>">
                                <div class="icon"><i class="fas fa-asterisk" aria-hidden="true"></i></div>
                                <span class="media-body"><?php _e("Other", SAMYAR_TEXT_DOMAIN); ?></span>
                            </a>
                        </div>
                        <div class="kt-col-xs-6 kt-col-md-3">
                            <a href="#" class="media brand-category" data-id="all" data-tooltip="<?php _e("All items", SAMYAR_TEXT_DOMAIN); ?>">
                                <div class="icon"><i class="fab fa-audible" aria-hidden="true"></i></div>
                                <span class="media-body"><?php _e("All items", SAMYAR_TEXT_DOMAIN); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
    <div class="column kt-col-xs-12 kt-col-md-12">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder" style="padding: 25px 30px 0px 35px;">
                <a href="#new_order" style="margin-right: 5px;border-radius: 10px 10px 0px 0px !important;"
                   class="button button-default multi-btn kando-select-order"><?php _e("single order", SAMYAR_TEXT_DOMAIN); ?></a>
                <?php if (!$fast_order && $enable_send_order_mass == 1): ?>
                    <a href="#mass-order" style="margin-right: 5px;border-radius: 10px 10px 0px 0px !important;"
                       class="button button-default kando-select-order"><?php _e("Mass", SAMYAR_TEXT_DOMAIN); ?></a>
                <?php endif; ?>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row">
                    <div class="column kt-col-xs-12">
                        <?php kando_show_alerts('order'); ?>
                    </div>
                    <?php

                    if (!empty($order_id) && $order):
                        $wallet = walletController::getInstance();
                        $user_credit = $wallet->getUserCredit(get_current_user_id());
//                            print_r($order);
                        ?>
                        <div class="column kt-col-xs-12">
                            <div class="alert alert-success" role="alert">
                                <ul>
                                    <li><h3><?php _e("Your order has been successfully received", SAMYAR_TEXT_DOMAIN); ?></h3></li>
                                    <li><?php _e('ID:', SAMYAR_TEXT_DOMAIN); ?> <strong><?= $order->id ?></strong></li>
                                    <li><?php _e('Service:', SAMYAR_TEXT_DOMAIN); ?> <strong><?= $service->name ?></strong></li>
                                    <li><?php _e('Link:', SAMYAR_TEXT_DOMAIN); ?> <strong><?= $order->link ?></strong></li>
                                    <li><?php _e('Quantity:', SAMYAR_TEXT_DOMAIN); ?> <strong><?= $order->quantity ?></strong></li>
                                    <li><?php _e('Charge:', SAMYAR_TEXT_DOMAIN); ?>
                                        <strong><?= kando_number_format_currency($order->charge, true) ?></strong>
                                    </li>
                                    <li><?php _e('Balance:', SAMYAR_TEXT_DOMAIN); ?>
                                        <strong><?= kando_number_format_currency($user_credit, true) ?></strong>
                                    </li>
                                </ul>
                            </div>
                            <?php do_action('kando_alert_after_success_order', $order); ?>
                        </div>
                    <?php
                    endif; ?>
                    <form method="POST" class="samyar-form new-order-form">
                        <?php wp_nonce_field('new_order_nonce', 'new_order_nonce'); ?>
                        <!--        <h4 style="text-align: center;margin-bottom: 40px" class="new-ticket-title">افزودن سفارش جدید</h4>-->
                        <input type="hidden" name="action" value="samyar_order_add">

                        <?php if (!$fast_order): //اگر سفارش سریع بود نشون نده ?>
                            <div class="column kt-col-xs-12 kt-col-md-5 float-left kt-hidden-xs kt-hidden-sm">
                                <div class="new-ticket-help">
                                    <!--                <img src="-->
                                    <?php //echo SAMYAR_DIR_IMG ?><!--/new-ticket-help.png"/>-->
                                    <h3 style="text-align: center"><?php _e("Service description", SAMYAR_TEXT_DOMAIN); ?></h3>
                                    <ul>
                                        <li><?php _e("The description of each service will be placed in this section", SAMYAR_TEXT_DOMAIN); ?></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php
                        $col = $fast_order ? 12 : 7;
                        ?>
                        <div class="column kt-col-xs-12 kt-col-md-<?= $col ?> float-left">

                            <div class="new-api-form-outer">

                                <!--                <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی افزودن کلیک کنید</span>-->


                                <div class="new-api-provider-form-errors"></div>
                                <div class="samyar-form-loading"></div>
                                <div class="clearfix">
                                    <!--                    <label>لطفا دسته مورد نظر خود را انتخاب نمایید</label>-->
                                    <select name="cate_id" id="samyar_select_category">
                                        <option value="0"><?php _e("Please select your desired category", SAMYAR_TEXT_DOMAIN); ?></option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo esc_attr($category->id) ?>"
                                                    data-brand="<?php if ($category->social_id): echo $category->social_id; endif; ?>"
                                                    <?php if ($category->id === $cat_id): ?>selected<?php endif; ?>><?php echo esc_attr($category->name) ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <div id="select-order-service"
                                         style="<?php if (!isset($cat_id) || empty($cat_id)): ?>display: none<?php endif; ?>">
                                        <label><?php _e("Please select the service you want", SAMYAR_TEXT_DOMAIN); ?></label>
                                        <select name="service">
                                            <?php if (isset($cat_id) && !empty($cat_id)):
                                                $serviceController = new \samyar\serviceController();
                                                $category_id = esc_attr($cat_id);
                                                $services = $serviceController->enable_services($category_id);

                                                echo "<option value='0'>".__("Please select the service you want", SAMYAR_TEXT_DOMAIN)."</option>";
                                                foreach ($services as $service): ?>
                                                    <option value="<?= $service->id ?>"
                                                            data-avaerage="<?php echo get_average_time($service->id) ?>"
                                                            data-min="<?= $service->min ?>"
                                                            data-max="<?= $service->max ?>"
                                                            data-type="<?= $service->type ?>"
                                                            data-dripfeed="<?= $service->dripfeed ?>"
                                                            data-price="<?= esc_attr(calculate_service_price($service->id)) ?>"
                                                            data-name="<?php echo $service->name ?>"
                                                            data-description=""><?php echo $service->name ?>
                                                        (<?php echo number_format_i18n(esc_attr(calculate_service_price($service->id))) ?><?php kando_get_currency_base_text(true) ?>
                                                        )
                                                    </option>
                                                <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    <?php
                                    $hidden_desc = $fast_order ? "" : "kt-hidden-md kt-hidden-lg";
                                    ?>
                                    <div class="new-ticket-help <?= $hidden_desc ?>"
                                         style="padding: 6px 30px;margin-bottom: 11px;">
                                        <ul style="margin-top: 0px;">
                                            <li><?php _e("The description of each service will be placed in this section", SAMYAR_TEXT_DOMAIN); ?></li>
                                        </ul>
                                    </div>
                                    <div id="insert-order-data" style="display: none">
                                        <div class="order-default-link">
                                            <label><?php _e("Link", SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="text" name="link" dir="ltr" placeholder="<?php _e("Enter the link", SAMYAR_TEXT_DOMAIN); ?>"
                                                   <?php if (isset($_GET['link']) && !empty($_GET['link'])): ?>value="<?= esc_attr($_GET['link']) ?>"<?php endif; ?>/>

                                            <?php
                                            //                                            $enable_process_link = $options->get_option('enable-process-link', "1");
                                            $enable_process_link = 0;//فعلا غیر فعال میشه
                                            ?>
                                            <?php if ($enable_process_link == 1 || $enable_process_link === "1"): ?>
                                                <!--                                                <button class="button button-green kt-ajax-button alt process-link" id="process-link">بررسی لینک</button>-->
                                            <?php endif; ?>
                                        </div>
                                        <div class="process-link-result"></div>

                                        <div class="order-default-quantity">
                                            <label><?php _e('Quantity', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="number" step="1" min="0" autocomplete="off" name="quantity"
                                                   class="ajaxQuantity" dir="ltr"
                                                   value="<?php echo(isset($_GET['quantity']) && !empty($_GET['quantity']) ? esc_attr($_GET['quantity']) : ""); ?>"
                                                   placeholder="<?php _e('desired quantity', SAMYAR_TEXT_DOMAIN); ?>"/>
                                        </div>
                                        <?php if ($enable_average_time == 1) { ?>
                                            <div class="order-average-time d-none">
                                                <label><?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?></label>
                                                <input type="text" id="order-average-time" class="" disabled
                                                       placeholder="<?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?>"/>
                                            </div>
                                        <?php } ?>
                                        <div class="order-comments d-none">
                                            <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                                            <textarea rows="10" name="comments"
                                                      class="form-control square ajax_custom_comments"></textarea>
                                        </div>

                                        <div class="order-comments-custom-package d-none">
                                            <label for=""><?php _e("Comments", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                                            <textarea rows="10" name="comments_custom_package"
                                                      class="form-control square"></textarea>
                                        </div>

                                        <div class="order-usernames d-none">
                                            <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?></label>
                                            <input type="text" class="form-control input-tags" dir="ltr"
                                                   name="usernames" value="usenameA,usenameB,usenameC,usenameD">
                                        </div>

                                        <div class="order-usernames-custom d-none">
                                            <label for=""><?php _e("Usernames", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                                            <textarea rows="10" name="usernames_custom" dir="ltr"
                                                      class="form-control square ajax_custom_lists"></textarea>
                                        </div>

                                        <div class="order-hashtags d-none">
                                            <label for=""><?php _e("Hashtags (Format: #hashtag)", SAMYAR_TEXT_DOMAIN) ?></label>
                                            <input type="text" class="form-control input-tags" name="hashtags"
                                                   value="#goodphoto,#love,#nice,#sunny">
                                        </div>

                                        <div class="order-hashtag d-none">
                                            <label for=""><?php _e("Hashtag", SAMYAR_TEXT_DOMAIN) ?> </label>
                                            <input class="form-control square" type="text" name="hashtag">
                                        </div>

                                        <div class="order-username d-none">
                                            <label for=""><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                                            <input class="form-control square" dir="ltr" name="username" type="text">
                                        </div>

                                        <!-- Mentions Media Likers -->
                                        <div class="order-media d-none">
                                            <label for=""><?php _e("Media Url", SAMYAR_TEXT_DOMAIN) ?></label>
                                            <input class="form-control square" name="media_url" dir="ltr" type="link">
                                        </div>


                                        <div class="order-poll d-none">
                                            <label for=""><?php _e("Answer number", SAMYAR_TEXT_DOMAIN) ?> </label>
                                            <input class="form-control square" type="text" dir="ltr"
                                                   name="answer_number">
                                        </div>

                                        <div class="order-groups d-none">
                                            <label for=""><?php _e("Groups", SAMYAR_TEXT_DOMAIN) ?><?php _e('(1 per line)', SAMYAR_TEXT_DOMAIN) ?></label>
                                            <textarea rows="10" name="groups" class="form-control square"></textarea>
                                        </div>

                                        <!-- Subscriptions  -->
                                        <div class="row order-subscriptions d-none">

                                            <div class="kt-col-md-6">

                                                <label><?php _e("Username", SAMYAR_TEXT_DOMAIN) ?></label>
                                                <input class="form-control square" type="text" name="sub_username">

                                            </div>

                                            <div class="kt-col-md-6">

                                                <label><?php _e("New posts", SAMYAR_TEXT_DOMAIN) ?></label>
                                                <input class="form-control square" type="number"
                                                       placeholder="<?php _e("minimum 1 post") ?>" name="sub_posts">

                                            </div>

                                            <div class="kt-col-md-6">

                                                <label><?php _e("Old posts", SAMYAR_TEXT_DOMAIN) ?></label>
                                                <input class="form-control square" type="number"
                                                       placeholder="<?php _e("minimum 1 post") ?>" name="sub_old_posts">

                                            </div>

                                            <div class="kt-col-md-6">

                                                <label><?php _e("Min", SAMYAR_TEXT_DOMAIN); ?></label>
                                                <input class="form-control square" type="number" name="sub_min"
                                                       placeholder="<?php _e("min", SAMYAR_TEXT_DOMAIN) ?>">

                                            </div>
                                            <div class="kt-col-md-6">

                                                <label><?php _e("Max", SAMYAR_TEXT_DOMAIN); ?></label>
                                                <input class="form-control square" type="number" name="sub_max"
                                                       placeholder="<?php _e("max", SAMYAR_TEXT_DOMAIN) ?>">

                                            </div>

                                            <div class="kt-col-md-6">

                                                <label><?php _e("Delay", SAMYAR_TEXT_DOMAIN) ?>
                                                    (<?php _e("minutes", SAMYAR_TEXT_DOMAIN) ?>)</label>
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

                                            <div class="kt-col-md-6">

                                                <label><?php _e("Expiry", SAMYAR_TEXT_DOMAIN) ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control hasDatepicker"
                                                           name="sub_expiry" onkeydown="return false" placeholder=""
                                                           id="expiry">
                                                </div>

                                            </div>

                                        </div>
                                        <?php
                                        //	                    if (get_option("enable_drip_feed", "") == 1) {
                                        ?>
                                        <div class="row drip-feed-option d-none">
                                            <div class="kt-col-md-12">

                                                <div class="form-label"><?php _e("Drip-feed", SAMYAR_TEXT_DOMAIN) ?>
                                                    <label class="custom-switch">
                                        <span class="custom-switch-description m-r-20"><i class="fas fa-question-circle"
                                                                                          data-tooltip="<?php _e("What is Drip-feed?", SAMYAR_TEXT_DOMAIN) ?>"></i></span>

                                                        <input type="hidden" name="is_drip_feed" value="0">
                                                        <input type="checkbox" name="is_drip_feed" value="1"
                                                               class="is_drip_feed custom-switch-input"
                                                               data-tooltip="<?php _e("What is Drip-feed?", SAMYAR_TEXT_DOMAIN) ?>"
                                                               data-toggle="collapse" data-target="#drip-feed"
                                                               aria-expanded="false"
                                                               aria-controls="drip-feed">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>


                                                <div class="row collapse" id="drip-feed">

                                                    <div class="kt-col-md-6" style="padding-left: 3px">

                                                        <label><?php _e("Runs", SAMYAR_TEXT_DOMAIN) ?></label>
                                                        <input class="form-control square ajaxDripFeedRuns"
                                                               type="number" name="runs" value="1">

                                                    </div>
                                                    <div class="kt-col-md-6" style="padding-right: 3px">

                                                        <label><?php _e("Interval (in minutes)", SAMYAR_TEXT_DOMAIN) ?></label>
                                                        <input class="form-control square" min="0" step="1"
                                                               type="number" name="interval" value="10">
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
                                                        <input class="form-control square" name="total_quantity"
                                                               type="number" disabled>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php //} ?>
                                    </div>
                                </div>

                            </div>

                            <div class="kt-row">
                                <div class="samyar-form-loading"></div>
                                <div id="order_review" class=" column kt-col-xs-12 kt-col-md-12 kando_show_factor"
                                     style="margin-top: 40px;display: none">
                                    <table class="shop_table">
                                        <thead>
                                        <tr>
                                            <th class="product-name"><?php _e("Service", SAMYAR_TEXT_DOMAIN); ?></th>
                                            <th class="product-total"><?php _e("Price", SAMYAR_TEXT_DOMAIN); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="cart_item">
                                            <td class="product-name">
                            <span class="product-title">
							    <?php _e("Service name", SAMYAR_TEXT_DOMAIN); ?>&nbsp;<strong class="product-quantity">&times; <?php _e('Quantity', SAMYAR_TEXT_DOMAIN); ?> </strong></span>
                                            </td>
                                            <td class="product-total">
                                                0 <?php kando_get_currency_base_text(true) ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>

                                        <tr class="cart-subtotal" style="display: none">
                                            <th> <?php _e('Total price', SAMYAR_TEXT_DOMAIN); ?></th>
                                            <td><span class=" amount">0&nbsp;<span
                                                            class=""><?php kando_get_currency_base_text(true) ?></span></span>
                                            </td>
                                        </tr>


                                        <tr class="cart-discount" style="display: none">
                                            <th>تخفیف سبد خرید</th>
                                            <td class="align-left" data-title="تخفیف سبد خرید">
                                                0 <?php kando_get_currency_base_text(true) ?></td>
                                        </tr>
                                        <tr class="order-total">
                                            <th><?php _e("Amount payable", SAMYAR_TEXT_DOMAIN); ?></th>
                                            <td><strong><span class="amount">0&nbsp;<span
                                                                class=""><?php kando_get_currency_base_text(true) ?></span></span></strong>
                                            </td>
                                        </tr>


                                        </tfoot>
                                    </table>

                                    <?php if (!is_user_logged_in()): ?>
                                        <?php

                                        //اگر مدیر در تنظیمات گفته که نیازی به تایید موبایل نیست
                                        $enable_otp_order = $options->get_option('enable-otp-order', 1);
                                        ?>
                                        <?php if ($enable_otp_order === "1" || $enable_otp_order) {// اگر تایید شماره همراه فعال هست ?>
                                            <p style="margin-top:20px;color:#AF0000"><?php _e("Note: If you don't need to confirm the mobile number for each order, just register on the site and log in to your account.", SAMYAR_TEXT_DOMAIN); ?></p>
                                        <?php } ?>
                                        <div class="checkout_coupon" style="margin-top:30px">

                                            <p class="form-row form-row-first">
                                                <input type="text" name="mobile" dir="ltr" class="input-text"
                                                       placeholder="<?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?>" id="mobile-number" value=""/>
                                            </p>
                                            <?php if ($enable_otp_order === "1" || $enable_otp_order) {// اگر تایید شماره همراه فعال هست ?>
                                                <p class="form-row form-row-last">
                                                    <a href="#"
                                                       class="button button-red kt-ajax-button samyar-verify-send"
                                                       style="margin-top:-10px;line-height: 28px;"><?php _e("Send verification code", SAMYAR_TEXT_DOMAIN); ?></a>
                                                </p>

                                                <div class="clear"></div>
                                                <p class="form-row form-row-first">
                                                    <input type="text" name="verify-code" class="input-text"
                                                           placeholder="<?php _e("Confirmation code received", SAMYAR_TEXT_DOMAIN); ?>" id="verify-code" value=""/>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    $enable_note_for_admin = $options->get_option('enable-note-for-admin', 1);

                                    if ($enable_note_for_admin == "1"):
                                        ?>
                                        <div>
                                        <textarea style="height: 110px;margin-top: 20px;" name="user_note"
                                                  class="input-text " id="user_note"
                                                  placeholder="<?php _e("Your note to the manager (not necessary)", SAMYAR_TEXT_DOMAIN); ?>"></textarea>
                                        </div>
                                    <?php endif ?>
                                    <?php
                                    $options = settingsController::getInstance();
                                    $enable_agree_order = $options->get_option('enable-agree-order', "1");
                                    $agree_order_text = $options->get_option('samyar-agree-order-text', __( "I have read and agree to [term].", SAMYAR_TEXT_DOMAIN ));

                                    $link = $options->get_option('samyar-agree-order-link', "");
                                    if (empty($link)) {
                                        $url = __( "Rules and regulations", SAMYAR_TEXT_DOMAIN );
                                    } else {
                                        $url = '<a class="terms-tag" href="' . $link . '" target="_blank">'.__("Rules and regulations", SAMYAR_TEXT_DOMAIN).'</a>';
                                    }
                                    $text = str_replace('[term]', $url, $agree_order_text);

                                    if ($enable_agree_order === "1"):
                                        ?>

                                        <input type="hidden" name="agree" value="0">
                                        <input type="checkbox" value="1" id="agree-order" name="agree">
                                        <label style="margin: 20px 0;font-size: 15px;font-weight: bold;"
                                               class="publish-notification" for="agree-order"><?= $text ?></label>
                                    <?php endif; ?>
                                    <?php
                                    $default_gateway = $options->get_option('default-gateway', "zarinpal");
                                    ?>
                                    <script>
                                        jQuery(document).ready(function ($) {
                                            if ($('input:radio[name=payment_method]').length > 0) {
                                                if ($('input:radio[value=<?=$default_gateway?>]').length > 0) {
                                                    $("input:radio[value=<?=$default_gateway?>]").attr('checked', true);
                                                } else {
                                                    $("input:radio[name=payment_method]:first").attr('checked', true);
                                                }
                                            }
                                        })
                                    </script>
                                    <div id="payment" class="woocommerce-checkout-payment">
                                        <?php
                                        //اگر اعتبار قبل از ارسال سفارش فعال بود
                                        //بهش بگو که باید قبل از ارسال سفارش کیف پول خودشون رو شارژ کنن
                                        $enable_agree_order = $options->get_option('enable-wallet-charge', "0");

                                        if ($enable_agree_order !== "1") {
                                            ?>
                                            <ul class="wc_payment_methods payment_methods methods">
                                                <?php do_action('samyar_order_payments'); ?>
                                            </ul>
                                        <?php } ?>
                                        <div class="form-row place-order">
                                            <button class="button button-green kt-ajax-button alt" id="place_order"><?php _e("Add order", SAMYAR_TEXT_DOMAIN); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                    <form method="POST" class="samyar-form mass-order-form" style="display:none">
                        <?php wp_nonce_field('new_order_mass_nonce', 'new_order_mass_nonce'); ?>
                        <input type="hidden" name="action" value="samyar_order_mass">

                        <?php if (!$fast_order && $enable_send_order_mass == 1): //اگر سفارش سریع بود نشون نده ?>
                            <div class="column kt-col-xs-12 kt-col-md-5 float-left kt-hidden-xs kt-hidden-sm">
                                <div class="new-ticket-help">
                                    <!--                <img src="-->
                                    <?php //echo SAMYAR_DIR_IMG ?><!--/new-ticket-help.png"/>-->
                                    <h3 style="text-align: center"><?php _e("Service description", SAMYAR_TEXT_DOMAIN); ?></h3>
                                    <ul>
                                        <li><?php _e("Description Here you can place your orders easily! Please be sure to check all prices and delivery times before ordering! Once an order has been submitted, it cannot be cancelled.", SAMYAR_TEXT_DOMAIN); ?></li>
                                        <li><?php _e("To send a bulk order, you must first log in to your account.", SAMYAR_TEXT_DOMAIN); ?></li>
                                        <li><?php _e("To send a bulk order, you must charge your wallet first.", SAMYAR_TEXT_DOMAIN); ?></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php
                        $col = $fast_order ? 12 : 7;
                        ?>
                        <div class="column kt-col-xs-12 kt-col-md-<?= $col ?> float-left">

                            <div class="new-api-form-outer">
                                <div class="new-api-provider-form-errors"></div>
                                <div class="samyar-form-loading"></div>
                                <div class="clearfix">

                                    <?php
                                    $hidden_desc = $fast_order ? "" : "kt-hidden-md kt-hidden-lg";
                                    ?>
                                    <div class="new-ticket-help <?= $hidden_desc ?>"
                                         style="padding: 6px 30px;margin-bottom: 11px;">
                                        <ul>
                                            <li><?php _e("Description Here you can place your orders easily! Please be sure to check all prices and delivery times before ordering! Once an order has been submitted, it cannot be cancelled.", SAMYAR_TEXT_DOMAIN); ?></li>
                                            <li><?php _e("To send a bulk order, you must first log in to your account.", SAMYAR_TEXT_DOMAIN); ?></li>
                                            <li><?php _e("To send a bulk order, you must charge your wallet first.", SAMYAR_TEXT_DOMAIN); ?></li>
                                        </ul>
                                    </div>
                                    <div id="insert-order-data">
                                        <div class="order-default-link">
                                            <textarea id="editor" rows="14" dir="ltr" name="mass_order"
                                                      class="form-control square"
                                                      placeholder="service_id|quantity|link"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="kt-row">

                                <div id="order_review" class=" column kt-col-xs-12 kt-col-md-12"
                                     style="margin-top: 5px;">
                                    <?php
                                    if ($enable_note_for_admin == "1"):
                                        ?>
                                        <div>
                                        <textarea style="height: 110px;margin-top: 20px;" name="user_note"
                                                  class="input-text " id="user_note"
                                                  placeholder="<?php _e("Your note to the manager (not necessary)", SAMYAR_TEXT_DOMAIN); ?>"></textarea>
                                        </div>
                                    <?php endif ?>
                                    <?php
                                    $options = settingsController::getInstance();
                                    $enable_agree_order = $options->get_option('enable-agree-order', "1");
                                    $agree_order_text = $options->get_option('samyar-agree-order-text', "من [term] را خوانده و با آن موافقم.");

                                    $link = $options->get_option('samyar-agree-order-link', "");
                                    if (empty($link)) {
                                        $url = "قوانین و مقررات";
                                    } else {
                                        $url = '<a class="terms-tag" href="' . $link . '" target="_blank">'._e("Rules and regulations", SAMYAR_TEXT_DOMAIN).'</a>';
                                    }
                                    $text = str_replace('[term]', $url, $agree_order_text);

                                    if ($enable_agree_order === "1"):
                                        ?>

                                        <input type="hidden" name="agree" value="0">
                                        <input type="checkbox" value="1" id="agree-mass-order" name="agree">
                                        <label style="margin: 20px 0;font-size: 15px;font-weight: bold;"
                                               class="publish-notification" for="agree-mass-order"><?= $text ?></label>
                                    <?php endif; ?>
                                    <div id="payment" class="woocommerce-checkout-payment">
                                        <div class="form-row place-order">
                                            <button class="button button-green kt-ajax-button alt" id="place_order"><?php _e("Add order", SAMYAR_TEXT_DOMAIN); ?></button>
                                        </div>
                                    </div>
                                    <div id="kando-mass-errors" style="margin-top: 12px;"></div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>