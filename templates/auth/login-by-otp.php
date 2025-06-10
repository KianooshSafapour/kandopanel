<?php
defined('ABSPATH') || exit('No Access!');

$mobile = isset($_GET['mobile'])?$_GET['mobile']:"";
if ($mobile) {
?>
<form class="form w-100" id="kt_login_otp_form" novalidate="novalidate">
    <?php wp_nonce_field('login_otp_nonce', 'login_otp_nonce'); ?>
    <input type="hidden" name="action" value="kandopanel_login_by_otp">
    <input type="hidden" name="mobile" value="<?=esc_attr($mobile)?>">
    <!--begin::Heading-->
    <div class="text-center mb-10">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3"><?php _e('Login By Otp',SAMYAR_TEXT_DOMAIN)?></h1>
        <!--end::Title-->
        <!--begin::Link-->
        <div class="text-gray-500 fw-semibold fs-6"><?php _e('Please enter the code to be sent to the mobile phone and click on verify',SAMYAR_TEXT_DOMAIN)?></div>
        <!--end::Link-->
    </div>
    <!--begin::Heading-->
    <!--begin::Input group=-->
    <div class="fv-row mb-8">
            <div class="verify-code-group grid-row aic jcc ltr">
                <label>
                    <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="1" name="code[1]">
                </label>
                <label>
                    <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="2" name="code[2]">
                </label>
                <label>
                    <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="3" name="code[3]">
                </label>
                <label>
                    <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="4" name="code[4]">
                </label>
                <label>
                    <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="5" name="code[5]">
                </label>
            </div>
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
    <div class="d-grid mb-5">
        <button type="submit" id="kt_verify_code_submit" class="btn btn-primary me-4">
            <!--begin::Indicator label-->
            <span class="indicator-label"><?php _e('Validity check',SAMYAR_TEXT_DOMAIN)?></span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress"><?php _e('Please wait ...',SAMYAR_TEXT_DOMAIN)?><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>

    <div class="d-grid mb-5">
        <button type="submit" id="kt_repeat_submit" class="btn btn-primary me-4">
            <!--begin::Indicator label-->
            <span class="indicator-label"><?php _e('Resend',SAMYAR_TEXT_DOMAIN)?></span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress"><?php _e('Please wait ...',SAMYAR_TEXT_DOMAIN)?><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--begin::Actions-->
    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
        <a href="<?= home_url('/login') ?>" class="btn btn-light"><?php _e('Cancel',SAMYAR_TEXT_DOMAIN)?></a>
    </div>
    <!--end::Actions-->
</form>
    <?php
}