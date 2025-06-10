<?php
/*
Template Name: page Login
*/
if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
}
// دریافت URL لوگو از هویت سایت
$site_logo = settingsController::getInstance()->get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = wp_get_attachment_url($site_logo);
}


$options = settingsController::getInstance();
$google_captcha_enable = esc_attr(kando_get_option('google-captcha-enable', 0));
$siteKey = esc_attr(kando_get_option('google-captcha-key', ""));
$secretKey = esc_attr(kando_get_option('google-captcha-secret-key', ""));

//redirect
$redirect = "";
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirect = $_GET['redirect'];
}


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl" style="direction: rtl" data-theme="dark">
<!--begin::Head-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- For Resposive Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" <?php body_class(''); ?>>
<!--begin::Theme mode setup on page load-->
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
        } else {
            if (localStorage.getItem("data-theme") !== null) {
                themeMode = localStorage.getItem("data-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->

<!--end::Main--><!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::احراز هویت - ورود -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-center flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px w-xs-300px p-10">
                    <div class="back-btn">
                        <a href="<?=home_url()?>" class="button gray ripple-effect"><?php _e('Return to home',SAMYAR_TEXT_DOMAIN)?>  <i class="fa fas fa-chevron-left"></i></a>
                    </div>
                    <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 w-100">
                        <!--begin::Logo-->
                        <a href="<?= home_url() ?>" class="mb-0 mb-lg-12">
                            <?php if (!empty($site_logo)): ?>
                                <img class="h-60px h-lg-75px" src="<?= esc_url($site_logo) ?>"
                                     alt="<?= get_bloginfo('name') ?>"/>
                            <?php endif; ?>

                        </a>

                        <!--end::Logo-->
                        <!--begin::Form-->
                        <?php
                        $action = $_GET['action'] ?? 'login';
                        $step = $_GET['step'] ?? '';
                        switch ($action) {
                            case 'login':
                                require_once get_parent_theme_file_path('templates/auth/login-form.php');
                                break;
                            case 'register':
                                require_once get_parent_theme_file_path('templates/auth/register-form.php');
                                break;
                            case 'forget-password-mobile':
                                if (settingsController::getInstance()->get_option('enable-sms', 0) == 1) {
                                    if (!$step) {
                                        require_once get_parent_theme_file_path('templates/auth/forget-mobile/forget-password-mobile-form-step1.php');
                                    } else {
                                        require_once get_parent_theme_file_path('templates/auth/forget-mobile/forget-password-mobile-form-step2.php');
                                    }
                                }
                                break;
                            case 'forget-password-email':
                                if (!$step) {
                                    require_once get_parent_theme_file_path('templates/auth/forget-email/forget-password-email-form-step1.php');
                                } else {
                                    require_once get_parent_theme_file_path('templates/auth/forget-email/forget-password-email-form-step2.php');
                                }

//                                require_once get_parent_theme_file_path('templates/auth/forget-password-email-form.php');
                                break;
                            case 'login-by-otp':
                                if (settingsController::getInstance()->get_option('enable-sms', 0) == 1) {
                                    require_once get_parent_theme_file_path('templates/auth/login-by-otp.php');
                                }
                                break;
                        }
                        ?>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-wrap px-5">
                <!--begin::Links-->
                <div class="d-flex fw-semibold text-primary fs-base">
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
        <!--begin::کناری-->
        <?php
        $login_background = kando_get_option('login-background', SAMYAR_DIR_IMG . '/auth/auth-bg.png');
        if (isset($login_background) && !empty($login_background) && is_numeric($login_background)) {
            $login_background = wp_get_attachment_url($login_background);
        }


        $login_item_pic = kando_get_option('login-item-pic', SAMYAR_DIR_IMG . '/auth/auth-screens.png');
        if (isset($login_item_pic) && !empty($login_item_pic) && is_numeric($login_item_pic)) {
            $login_item_pic = wp_get_attachment_url($login_item_pic);
        }


        ?>
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
             style="background-image: url(<?= $login_background ?>)">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">

                <!--begin::Image-->
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                     src="<?= $login_item_pic ?>" alt=""/>
                <!--end::Image-->
                <!--begin::Title-->
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                    <?= get_bloginfo('name') ?>
                </h1>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="d-none d-lg-block text-white fs-base text-center">
                    <?= get_bloginfo('description') ?>
                </div>
                <!--end::Text-->

            </div>
            <!--end::Content-->
        </div>
        <!--end::کناری-->
    </div>
    <!--end::احراز هویت - ورود-->
</div>
</body>
<!--end::Body-->

<?php wp_footer(); ?>
</html>