<?php
defined('ABSPATH') || exit('No Access!');
?>
<form class="form w-100" method="post" novalidate="novalidate" id="kt_sign_in_form" action="">
    <?php wp_nonce_field('user_login_nonce', 'user_login_nonce'); ?>
    <input type="hidden" name="action" value="kandopanel_user_login">
    <input type="hidden" name="redirect" value="<?=$redirect?>">
    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3"><?php _e('Login',SAMYAR_TEXT_DOMAIN)?></h1>
        <!--end::Title-->
        <!--begin::Subtitle-->
        <div class="text-gray-500 fw-semibold fs-6">
            <?php _e('Register if you have not already registered',SAMYAR_TEXT_DOMAIN)?>
        </div>
        <!--end::Subtitle=-->
    </div>
    <!--begin::Heading-->

    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::ایمیل-->
        <input type="email" placeholder="<?php _e('mobile or username or email',SAMYAR_TEXT_DOMAIN)?>" value="" name="log"
               autocomplete="off"
               class="form-control bg-transparent"/>
        <!--end::ایمیل-->
    </div>
    <!--end::Input group=-->
    <div class="fv-row mb-3">
        <!--begin::password-->
        <input type="password" placeholder="<?php _e('Password',SAMYAR_TEXT_DOMAIN)?>" name="pwd" autocomplete="off"
               class="form-control bg-transparent ltr"/>
        <!--end::password-->
    </div>
    <div class="fv-row mb-3">
        <!--begin::password-->
        <div id="captchaContainer">
            <?php if($google_captcha_enable): ?>
                <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
            <?php endif; ?>
        </div>
        <!--end::password-->
    </div>
    <!--end::Input group=-->
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
        <div></div>
        <!--begin::Link-->
        <?php
        if (settingsController::getInstance()->get_option('enable-sms', 0) == 1) {
        $forget_page = add_query_arg(['action'=>'forget-password-mobile'], home_url('/login'));
        }else{
            $forget_page = add_query_arg(['action'=>'forget-password-email'], home_url('/login'));
        }
        ?>
        <a href="<?= $forget_page ?>"
           class="link-primary"><?php _e('Forgot your password?',SAMYAR_TEXT_DOMAIN)?></a>
        <!--end::Link-->
    </div>
    <!--end::Wrapper-->

    <!--begin::ثبت button-->
    <div class="d-grid mb-5">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
            <!--begin::Indicator label-->
            <span class="indicator-label"><?php _e('Login',SAMYAR_TEXT_DOMAIN)?></span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress"><?php _e('Please wait ...',SAMYAR_TEXT_DOMAIN)?><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::ثبت button-->
    <?php if(settingsController::getInstance()->get_option('enable-sms', 0)==1){ ?>
    <!--begin::ثبت button-->
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_in_by_otp_submit" class="btn btn-primary">
            <!--begin::Indicator label-->
            <span class="indicator-label"><?php _e('Login By Otp',SAMYAR_TEXT_DOMAIN)?></span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress"><?php _e('Please wait ...',SAMYAR_TEXT_DOMAIN)?><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::ثبت button-->
    <?php } ?>
    <!--begin::Sign up-->
    <div class="text-gray-500 text-center fw-semibold fs-6"><?php _e('still not registered?',SAMYAR_TEXT_DOMAIN)?>

        <a href="<?= add_query_arg(['action'=>'register'], home_url('/login')) ?>" class="link-primary"><?php _e('Register',SAMYAR_TEXT_DOMAIN)?></a></div>
    <!--end::Sign up-->
</form>
