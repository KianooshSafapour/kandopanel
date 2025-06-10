<?php
/*
Template Name: process payment page
*/

use samyar\logController;
use samyar\paymentController;
use samyar\priceController;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!isset($_REQUEST['payment_id']) || empty($_REQUEST['payment_id'])) {
    wp_safe_redirect(home_url());
    exit;
}

$options = settingsController::getInstance();
$payment = false;
$result = [
    'success' => false,
    'data' => __("There is no active gateway", SAMYAR_TEXT_DOMAIN)
];

$Payment = paymentController::getInstance();
$result = $Payment->verifyPay($_REQUEST);

$site_favicon = kando_get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = kando_get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}


// اگر کاربر وارد شده باشه و همچنین پرداختش موفق به هدایت بشه به صفحه ارسال سفارش جدید
if (is_user_logged_in() && $result['success'] && $result['order_type'] === "order") {
    wp_safe_redirect(home_url('dashboard/?action=orders&section=new&order_id=' . $result['order_id']));
    exit; // اضافه شده
}

$page_title = get_the_title();
$site_name = get_bloginfo('name');
$page_url = get_permalink();
$custom_title = $page_title . ' - ' . $site_name; // فرمت: "عنوان صفحه - نام سایت"
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $site_favicon ?>" sizes="32x32"/>

    <title><?=$custom_title?></title>
    <?php

    echo '<meta name="title" content="' . esc_attr($page_title) . ' - ' . esc_attr($site_name) . '">';
    echo '<meta property="og:title" content="' . esc_attr($page_title) . ' - ' . esc_attr($site_name) . '">';
    echo '<meta property="og:url" content="' . esc_url($page_url) . '">';


    // جلوگیری از ایندکس شدن توسط ربات‌ها (در همه صفحات)
    echo '<meta name="robots" content="noindex, nofollow">';
    echo '<meta name="googlebot" content="noindex, nofollow">';
    echo '<meta name="bingbot" content="noindex, nofollow">';
    ?>
    <link rel='stylesheet' id='samyar-styles-css' href='<?= SAMYAR_DIR_CSS . '/style.css?ver=' . SAMYAR_THEME_VER ?>'
          media='all'/>
    <link rel='stylesheet' id='samyar-styles-css' href='<?= SAMYAR_DIR_CSS . '/style-rtl.css?ver=' . SAMYAR_THEME_VER ?>'
          media='all'/>
    <?php //wp_head(); ?>
</head>
<body <?php body_class(); ?> style="background: #f4f4f4;">
<div class="page-holder">
    <div class="wrapper">
        <div class="page-content-holder"
             style="background: #fff;border: 1px solid #d3d3d3;padding: 1.0714285714rem 1.07143rem 1.07143rem;border-radius: 20px;max-width: 550px">
            <div class="dashboard-posts-list">
                <div class="kt-row" style="margin-top: 20px;">
                    <?php if ($result['success']) {
                        $log = logController::getInstance();
                        $log->add(get_current_user_id(), sprintf(__('user charged his account with the amount %s', SAMYAR_TEXT_DOMAIN), priceController::kandoFormatPrice($result['price'])['price_for_show_formatted']), 'charge');
                        ?>
                        <div class="kt-col-xs-12 kt-col-sm-12">
                            <div class="kando-checkout-alert__icon success" style="text-align: center">

                                <i class="fal fa-check-circle"></i>
                            </div>
                            <div class="kando-checkout-alert__title">
                                <?php
                                if (isset($result['success_text'])) {
                                    echo $result['success_text'];
                                }
                                ?>
                                <span style="text-align: center;margin: 10px auto;display: block;">
                        <?php if ($result['order_type'] === "number") { ?>
                            <a href="<?= home_url('dashboard/?action=numbers') ?>" style="margin-left: 5px;"
                               class="button button-blue"
                               data-wpel-link="internal"><?php _e("Buy new number", SAMYAR_TEXT_DOMAIN) ?></a>
                            <a href="<?= home_url('dashboard/?action=numbers&section=my-numbers') ?>"
                               class="button button-green"
                               data-wpel-link="internal"><?php _e("Go to my number", SAMYAR_TEXT_DOMAIN) ?></a>
                        <?php } else { ?>
                            <a href="<?= home_url('dashboard/?action=orders&section=new') ?>" style="margin-left: 5px;"
                               class="button button-blue"
                               data-wpel-link="internal"><?php _e("Add new order", SAMYAR_TEXT_DOMAIN) ?></a>
                            <a href="<?= home_url('dashboard/?action=orders') ?>" class="button button-green"
                               data-wpel-link="internal"><?php _e("Go to order list", SAMYAR_TEXT_DOMAIN) ?></a>
                        <?php } ?>

                    </span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="kt-col-xs-12 kt-col-sm-12">
                            <div class="kando-checkout-alert__icon failed" style="text-align: center">
                                <i class="fal fa-window-close"></i>
                            </div>
                            <div class="kando-checkout-alert__title"><h4><?= $result['error_text'] ?></h4></div>
                            <span style="text-align: center;margin: 10px auto;display: block;">
                            <a href="<?= home_url() ?>" style="margin-left: 5px;" class="button button-blue"
                               data-wpel-link="internal"><?php _e("Return to home", SAMYAR_TEXT_DOMAIN) ?></a>
                    </span>
                        </div>

                    <?php } ?>
                    <div class="kt-col-xs-12 kt-col-sm-12" style="margin: auto;">
                        <table>
                            <tbody>

                            <?php if (isset($result['order_id']) && !empty($result['order_id'])) { ?>
                                <tr>
                                    <td>
                                        <?php _e("Order ID:", SAMYAR_TEXT_DOMAIN) ?>
                                    </td>
                                    <td>
                                        <?php echo $result['order_id'] ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (isset($_REQUEST['payment_id']) && !isset($result['order_id'])) { ?>
                                <tr>
                                    <td>
                                        <?php _e("Factor Number:", SAMYAR_TEXT_DOMAIN) ?>
                                    </td>
                                    <td>
                                        <?php echo $_REQUEST['payment_id'] ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (isset($result['gateway']) && !empty($result['gateway'])) { ?>
                                <tr>
                                    <td>
                                        <?php _e("Gateway:", SAMYAR_TEXT_DOMAIN) ?>
                                    </td>
                                    <td>
                                        <?php echo $result['gateway'] ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (isset($result['price']) && !empty($result['price'])) { ?>
                                <tr>
                                    <td>
                                        <?php _e("Amount (without tax):", SAMYAR_TEXT_DOMAIN) ?>
                                    </td>
                                    <td>
                                        <?php
                                        //اطلاعات درگاه رو پیدا ی کنیم
                                        $gateway_info = kandopanelGetGatewayInfo(kandopanel_gateways_list(), $_REQUEST['gateway']);

                                        //اگر به دلار هست تبدیل به تومانش کن
                                        if ($gateway_info['currency'] === "USD") {
                                            echo number_format($result['price']) . ' USD';
                                        } else {
                                            echo number_format($result['price']) . " " . __('Toman', SAMYAR_TEXT_DOMAIN);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (isset($result['RefID']) && !empty($result['RefID'])) { ?>
                                <tr>
                                    <td>
                                        <?php _e("Receipt Number:", SAMYAR_TEXT_DOMAIN) ?>
                                    </td>
                                    <td>
                                        <?php echo $result['RefID'] ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (isset($result['msg']) && !empty($result['msg'])) { ?>
                                <tr>
                                    <td>
                                        <?php _e("Error Description:", SAMYAR_TEXT_DOMAIN) ?>
                                    </td>
                                    <td>
                                        <?php echo $result['msg'] ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (!$result['success'] && is_user_logged_in() && $result['order_type'] !== "number") {

                    } ?>

                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
