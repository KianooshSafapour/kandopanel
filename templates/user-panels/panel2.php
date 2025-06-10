<?php

use kandopanel\currencyController;
use samyar\walletController;


$options = settingsController::getInstance();

$site_favicon = kando_get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = kando_get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}


$site_logo = kando_get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = kando_get_option('site-logo');
    $site_logo = wp_get_attachment_url($site_logo);
}


$site_mobile_logo = kando_get_option('site-mobile-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_mobile_logo) && !empty($site_mobile_logo) && is_numeric($site_mobile_logo)) {
    $site_mobile_logo = kando_get_option('site-mobile-logo');
    $site_mobile_logo = wp_get_attachment_url($site_mobile_logo);
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- For Resposive Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= $site_favicon ?>" sizes="32x32"/>
    <?php wp_head(); ?>

    <script type="text/javascript">

        Date.prototype.getUTCLocalDate = function () {
            var target = new Date(this.valueOf());
            var offset = target.getTimezoneOffset();
            var Y = target.getUTCFullYear();
            var M = target.getUTCMonth();
            var D = target.getUTCDate();
            var h = target.getUTCHours();
            var m = target.getUTCMinutes();
            var s = target.getUTCSeconds();

            console.log(target);

            return new Date(Date.UTC(Y, M, D, h, offset + m, s));
        };

        function kando_count_time($date, $id, $for) {
            var countDownDate = new Date($date).getTime();


            var x = setInterval(function () {

                // Get today's date and time
                // var now = new Date();

                let now = new Date();
                now.setHours(now.getHours() + 1); //اختلاف ساعت ایران رو درست میکنه


                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                // document.getElementById("demo").innerHTML =  minutes + " دقیقه " + seconds + " ثانیه ";


                if (days === 0 && hours === 0) {
                    document.getElementById($id).innerHTML = minutes + " <?php _e("minutes", SAMYAR_TEXT_DOMAIN); ?> " + seconds + " <?php _e("seconds", SAMYAR_TEXT_DOMAIN); ?> <br> " + $for + " ";
                } else if (days === 0) {
                    document.getElementById($id).innerHTML = hours + " <?php _e("hours", SAMYAR_TEXT_DOMAIN); ?> "
                        + minutes + " <?php _e("minutes", SAMYAR_TEXT_DOMAIN); ?> " + seconds + " <?php _e("seconds", SAMYAR_TEXT_DOMAIN); ?> <br> " + $for + " ";
                } else {
                    document.getElementById($id).innerHTML = days + " <?php _e("days", SAMYAR_TEXT_DOMAIN); ?> " + hours + " <?php _e("hours", SAMYAR_TEXT_DOMAIN); ?> "
                        + minutes + " <?php _e("minutes", SAMYAR_TEXT_DOMAIN); ?> " + seconds + " <?php _e("seconds", SAMYAR_TEXT_DOMAIN); ?> <br> " + $for + " ";
                }


                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById($id).innerHTML = "";
                }
            }, 1000);
        }

    </script>
    <link rel='stylesheet' id='kando-panel2-styles-css'
          href='<?= SAMYAR_DIR_CSS ?>/panel2.css?ver=<?= SAMYAR_THEME_VER ?>' media='all'/>
</head>

<body <?php body_class(); ?>>

<?php
$header_notification_active = kando_get_option('header-notification-active', 0);
$header_notification_id = kando_get_option('header-notification-id', "");
$header_notification_title = kando_get_option('header-notification-title', "");
$header_notification_btn_title = kando_get_option('notification-btn-title', "");
$header_notification_btn_url = kando_get_option('notification-btn-url', "");

$site_header_notification_bg = kando_get_option('site-header-notification-bg', SAMYAR_DIR_IMG . '/social_media_banner.png');
if (isset($site_header_notification_bg) && !empty($site_header_notification_bg) && is_numeric($site_header_notification_bg)) {
    $site_header_notification_bg = kando_get_option('site-header-notification-bg');
    $site_header_notification_bg = wp_get_attachment_url($site_header_notification_bg);
}
if ($header_notification_active):
    ?>
    <div class="kt-notice-outer" data-id="<?= esc_attr($header_notification_id) ?>">
        <div class="kt-notice-holder"
             style="background-image:url(<?= esc_attr($site_header_notification_bg) ?>);background-position:center center;background-repeat:repeat">
            <div class="wrapper">
                <div class="kt-notice-inner clearfix">
                    <i class="kt-notice-close elegant-icon icon_close"></i>
                    <div class="kt-notice-text"><?= esc_attr($header_notification_title) ?></div>
                    <?php if (!empty($header_notification_btn_title)): ?>
                        <a href="<?= esc_attr($header_notification_btn_url) ?>" class="button button-violet"
                           data-wpel-link="internal"><?= esc_attr($header_notification_btn_title) ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;
$redirect_logout = kando_get_option('redirect-logout', home_url('login'));
?>
<header class="user_header">
    <div class="container">
        <div class="my_account_menu"><i class="fal fa-bars"></i><?php _e("List", SAMYAR_TEXT_DOMAIN); ?></a></div>
        <div class="account_head_icon text_align_left">

            <?php
            $enable_switch_language = kando_get_option('enable-switch-language', 0);
            if ($enable_switch_language == '1') {

                // لیست زبان‌ها و پرچم‌ها

                $current_user_id = get_current_user_id();
                $current_language = kando_get_user_language();

                if (!$current_language) {
                    $current_language = 'fa_IR';
                }

                [$current_language, $current_country] = explode('_', $current_language);

                $languages = kando_get_available_languages();
                ?>

                <div class="up_top_setting navbar ms-auto">
                    <div class="nav-item currencyItem toggle-item">
                        <a href="#" class=" toggle-head nav-link"
                           title="<?php _e("Language", SAMYAR_TEXT_DOMAIN); ?>"><i class="fi flag-icon-squared fi-<?php echo esc_html(strtolower($current_country)); ?> fis"></i></a>
                        <div class="toggle-body">
                            <div class="top d-flex align-items-center justify-content-between mb-3">
                                <div class="toggle-title ms-3"><?php _e("Language", SAMYAR_TEXT_DOMAIN); ?></div>
                            </div>
                            <div class="currencyList" id="currencies-list">
                                <?php foreach ($languages as $lang_code => $lang_name) {
                                    [$language, $country] = explode('_', $lang_code);
                                    $country_lowercase = strtolower($country);
                                    ?>
                                    <a class="item d-flex align-items-center justify-content-start p-2 position-relative" data-language-code="<?php echo esc_html($lang_code); ?>" href="#">
                                        <div class="content">
                                            <div class="item-title mb-1 d-flex align-items-center justify-content-between">
                                                <div class="name">
                                                    <i class="fi flag-icon-squared fi-<?php echo esc_html($country_lowercase); ?> fis"></i>
                                                    <span class="cText"><?php echo esc_html($lang_name); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <a href="<?php echo esc_attr(kando_logout_url()) ?>" class="up_top_logout"
               title="<?php _e("Logout", SAMYAR_TEXT_DOMAIN); ?>"><i
                        class="fal fa-power-off"></i></a>
            <?php if (kando_count_notification() > 0) { ?>
                <a class="up_top_notify <?php if (kando_count_notification() > 0) { ?>has-notification<?php } ?>"
                   href="<?php echo esc_attr(home_url('dashboard/?action=notifications')) ?>"
                   title="<?php _e("Announcements", SAMYAR_TEXT_DOMAIN); ?>"><i
                            class="fal fa-bell"></i></a>
            <?php } ?>
            <a class="up_top_setting" href="<?php echo esc_attr(home_url('dashboard/?action=edit-profile')) ?>"
               title="<?php _e("Settings", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-cog"></i></a>
            <a class="up_top_home" href="<?= home_url(); ?>"><i class="fal fa-house-flood"></i></a>
        </div>
    </div>
</header>
<?php
$options = settingsController::getInstance();


$wallet = walletController::getInstance();
$user_credit = $wallet->getUserCredit(get_current_user_id())['price_for_show_formatted'];

$action = "";
$section = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_GET['section'])) {
    $section = $_GET['section'];
}

$user = get_user_by('ID', get_current_user_id());

include_once(SAMYAR_DIR_TEMPLATE . '/parts/notification-sidebar.php');
?>

<div class="main-site-wrap">
    <div class="kando-site-mask"></div>
    <div class="site-wrap-outer clear">

        <div class="container-wrap page-my-account">
            <div class="container">
                <div id="content">
                    <div class="kando-panel2">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                <nav class="kando-panel2-navigation">
                                    <div class="my_account_close"><i class="fal fa-times"></i></div>
                                    <div class="my_account_info">
                                        <?php
                                        $avatar = get_user_meta(get_current_user_id(), 'avatar_url', true);
                                        if ($avatar && !empty($avatar)) {
                                            $avatar_url = '<img src="' . $avatar . '">';
                                        } else {
                                            $avatar_url = get_avatar(get_current_user_id(), 90);
                                        }
                                        ?>
                                        <a href="<?php echo esc_attr(home_url('dashboard')) ?>" class="myacc_gravatar"
                                           title="<?php echo $user->display_name ?>">
                                            <?php echo $avatar_url; ?></a>
                                        <span class="myacc_username"><?php echo $user->display_name ?></span>
                                        <span class="myacc_displayname">
                                                            <a href="<?php echo esc_attr(home_url('dashboard/?action=add-credit')) ?>"
                                                               class="panel-header-wallet" data-wpel-link="internal"
                                                               style="padding-right: 0px;">
                        <i class="elegant-icon icon_wallet"></i>
                        <span style="margin-right: 10px;"><?= walletController::getInstance()->getUserCredit(get_current_user_id())['price_for_show_formatted'] ?></span>
                    </a>
                                        </span>

                                        <style>
                                            .balance-dropdown__toggle:after {
                                                display: inline-block;
                                                content: '\f107';
                                                font-family: "FontAwesome";
                                                margin-left: 12px
                                            }

                                            .show .balance-dropdown__toggle:after {
                                                display: inline-block;
                                                content: '\f106';
                                                font-family: "FontAwesome";
                                                margin-left: 12px
                                            }

                                            /* Style The Dropdown Button */
                                            .dropbtn {
                                                background-color: #1e2f9d;
                                                color: white;
                                                padding: 16px;
                                                font-size: 16px;
                                                border: none;
                                                cursor: pointer;
                                                line-height: .5em;
                                            }

                                            /* The container <div> - needed to position the dropdown content */
                                            .balance-dropdown .dropdown {
                                                position: relative;
                                                display: inline-block;
                                            }

                                            /* Dropdown Content (Hidden by Default) */
                                            .balance-dropdown .dropdown-content {
                                                display: none;
                                                position: absolute;
                                                background-color: #f9f9f9;
                                                min-width: 90px;
                                                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                                                z-index: 1;
                                            }

                                            /* Links inside the dropdown */
                                            .balance-dropdown .dropdown-content a {
                                                color: black;
                                                padding: 12px 16px;
                                                text-decoration: none;
                                                display: block;
                                            }

                                            /* Change color of dropdown links on hover */
                                            .balance-dropdown .dropdown-content a:hover {
                                                background-color: #f1f1f1
                                            }

                                            /* Show the dropdown menu on hover */
                                            .balance-dropdown .dropdown:hover .dropdown-content {
                                                display: block;
                                            }

                                            /* Change the background color of the dropdown button when the dropdown content is shown */
                                            .balance-dropdown .dropdown:hover .dropbtn {
                                                background-color: #3e8e41;
                                            }

                                        </style>
                                        <script>
                                            jQuery(document).ready(function ($) {
                                                $('.balance-dropdown-link').on('click', function (event) {
                                                    event.preventDefault();

                                                    var currencyKey = $(this).data('rate-key');
                                                    var currencySymbol = $(this).data('rate-symbol');

                                                    // به‌روزرسانی نمایش انتخاب شده
                                                    $('.dropbtn').text(currencySymbol);

                                                    // حذف ارز انتخاب شده از لیست
                                                    $(this).parent().remove();

                                                    // ارسال درخواست AJAX برای ذخیره ارز انتخابی
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: kando_data.ajaxurl,
                                                        data: {
                                                            action: 'save_user_currency',
                                                            currency: currencyKey
                                                        },
                                                        success: function (response) {
                                                            location.reload();
                                                            // console.log('Currency saved successfully');
                                                        },
                                                        error: function (xhr, status, error) {
                                                            console.log('An error occurred: ' + error);
                                                        }
                                                    });
                                                });
                                            })
                                        </script>

                                        <?php
                                        $enable_switch_currency = settingsController::getInstance()->get_option('enable-switch-currency', 0);
                                        if ($enable_switch_currency == "1") {
                                            ?>
                                            <div class="balance-dropdown">
                                                <?php

                                                $selected_currency = currencyController::getInstance()->getUserCurrency();
                                                $currencies = currencyController::getInstance()->get_all_currencies();

                                                $selected_currency_symbol = currencyController::getInstance()->getUserCurrency();

                                                foreach ($currencies as $key => $value) {
                                                    if ($key === $selected_currency) {
                                                        $selected_currency_symbol = $value['currency_code'] . $value['symbol'];
                                                        unset($currencies[$key]);
                                                        break;
                                                    }
                                                }
                                                ?>

                                                <div class="dropdown">
                                                    <button class="dropbtn"><?php echo esc_html($selected_currency_symbol); ?></button>
                                                    <div class="dropdown-content">
                                                        <?php foreach ($currencies as $key => $value) : ?>
                                                            <a href="#" class="balance-dropdown-link"
                                                               data-rate-key="<?php echo esc_attr($key); ?>"
                                                               data-rate-symbol="<?php echo esc_attr($value['symbol']); ?>"><?php echo esc_html($value['currency_code'] . ' ' . $value['symbol']); ?></a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>


                                            </div>
                                        <?php } ?>

                                    </div>
                                    <ol class="my_account_date clear">
                                        <li>
                                            <div class="el_myc_date pre">
                                                <span><?php echo date_i18n('j', strtotime(kando_modify_get_the_date("-2", "Y-m-d"))) ?></span><span><?php echo date_i18n('F', strtotime(kando_modify_get_the_date("-2", "Y-m-d"))) ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="el_myc_date pre">
                                                <span><?php echo date_i18n('j', strtotime(kando_modify_get_the_date("-1", "Y-m-d"))) ?></span><span><?php echo date_i18n('F', strtotime(kando_modify_get_the_date("-1", "Y-m-d"))) ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="el_myc_date current">
                                                <span><?= date_i18n("j") ?></span><span><?= date_i18n("F") ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="el_myc_date next">
                                                <span><?php echo date_i18n('j', strtotime(kando_modify_get_the_date("+1", "Y-m-d"))) ?></span><span><?php echo date_i18n('F', strtotime(kando_modify_get_the_date("+1", "Y-m-d"))) ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="el_myc_date next">
                                                <span><?php echo date_i18n('j', strtotime(kando_modify_get_the_date("+2", "Y-m-d"))) ?></span><span><?php echo date_i18n('F', strtotime(kando_modify_get_the_date("+2", "Y-m-d"))) ?></span>
                                            </div>
                                        </li>
                                    </ol>

                                    <div class="my_account_cmenu">
                                        <?php
                                        $menus = kandopanel_menu_list();

                                        foreach ($menus as $menu) {
                                            $action = isset($action) && !empty($action) ? $action : "dashboard";//اگر هیچ اکشنی نبود داشبرد هست
                                            $section = isset($section) && !empty($section) ? $section : "";//اگر هیچ سکشنی نبود خالی بزار


                                            if (($menu['action'] == "orders" && $menu['section'] == "new") || $menu['action'] == "add-credit") {
                                                ?>
                                                <div class="myacc_item_menu <?php if (($action === $menu['action']) && ($section === $menu['section'])) : echo 'is-active'; endif ?>">
                                                    <a
                                                            href="<?= $menu['link'] ?>" title="<?= $menu['name'] ?>"><i
                                                                class="<?= $menu['icon'] ?>"></i><?= $menu['name'] ?>
                                                    </a>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>

                                    <ul>
                                        <?php
                                        $menus = kandopanel_menu_list();

                                        foreach ($menus as $menu) {
                                            $action = isset($action) && !empty($action) ? $action : "dashboard";//اگر هیچ اکشنی نبود داشبرد هست
                                            $section = isset($section) && !empty($section) ? $section : "";//اگر هیچ سکشنی نبود خالی بزار
                                            if (!($menu['action'] == "orders" && $menu['section'] == "new") && $menu['action'] != "add-credit") {
                                                if ($menu['enable']) {
                                                    if ($menu['for_admin'] == 0 || ($menu['for_admin'] == 1 && !empty($menu['access_key']) && kando_user_can($menu['access_key']))) {// اگر برای کاربر باشه یا برای مدیر باشه و کاربر هم مدیر باشه

                                                        ?>
                                                        <li <?php if (($action === $menu['action']) && ($section === $menu['section'])) : echo 'class="is-active"'; endif ?>>
                                                            <a href="<?= $menu['link'] ?>" data-wpel-link="internal"><i
                                                                        class="<?= $menu['icon'] ?>"></i><?= $menu['name'] ?><?php if (isset($menu['numbers']) && $menu['numbers'] > 0 && samyar_is_admin()): ?>
                                                                    <span class="button button-default badge-error-orders"><?php echo $menu['numbers']; ?></span><?php endif; ?>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                }
                                            }
                                        } ?>

                                    </ul>
                                </nav>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                                <div class="<?= $action ?>">
                                    <div class="page-inner-holder">

                                        <div class="kando-panel2-MyAccount-content">
                                            <div class="kando-panel2-notices-wrapper"></div>
                                            <?php include(SAMYAR_DIR_TEMPLATE . '/template-switcher.php') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="quick_view_wrap" id="quick_view"></div>
</div><!--#main-site-wrap-->
<?php
$options = settingsController::getInstance();
$samyar_footer = kando_get_option('samyar-footer', 0);

?>
<footer class="footer_wrap clear user_footer">
    <div class="container">
        <div class="footer_down">
            <div class="gototop"><i class="fal fa-angle-up"></i></div>
            <div class="copy_right">
                <?php
                echo kando_get_option('copyright', __("All material and intellectual rights of this website belong to <a href=\"http://127.0.0.1/kandopanel\" data-wpel-link=\"internal\">Kandopanel</a>, and any copying is legally pursued.", SAMYAR_TEXT_DOMAIN));
                ?>
            </div>
        </div>
    </div>
</footer>
<div class="kt-modal-outer-holder">
    <div class="kt-modal-overlay"></div>
    <div class="wrapper">
        <div class="kt-modal-holder">
            <div class="kt-modal-transparent-overlay"></div>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/modals/login-register.php') ?>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/modal-service.php') ?>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/modal-description.php') ?>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/notification/show.php') ?>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/modals/modal-send-package.php') ?>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/modals/info.php') ?>
            <?php include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/payment/repayment-modal.php') ?>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
<script src='<?= SAMYAR_DIR_JS ?>/panel2.js?ver=<?= SAMYAR_THEME_VER ?>' id='kando-panel2-js'></script>
<form method="post" action="" id="checkout_form" style="display: none">
    <div class="payment_info"></div>
    <input type="submit" id="payment_submit"/>
</form>

<?php
$enable_mobile_menu = kando_get_option('enable-mobile-menu', 1);
if ($enable_mobile_menu === "1" || $enable_mobile_menu) {
    include_once(SAMYAR_DIR_TEMPLATE . "/mobile-menu.php");
} ?>
</body>

</html>
