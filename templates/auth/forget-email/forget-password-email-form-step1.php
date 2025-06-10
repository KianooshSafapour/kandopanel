<?php
defined('ABSPATH') || exit('No Access!');
?>
<form class="form w-100" id="kt_password_reset_by_email_form" novalidate="novalidate">
    <?php wp_nonce_field('forgot_password_by_email_action', 'forgot_password_by_email_nonce'); ?>
    <input type="hidden" name="action" value="kandopanel_forgot_password_by_otp_email">
    <!--begin::Heading-->
    <div class="text-center mb-10">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3"><?php _e('forget password',SAMYAR_TEXT_DOMAIN)?></h1>
        <!--end::Title-->
        <!--begin::Link-->
        <div class="text-gray-500 fw-semibold fs-6"><?php _e('please enter Email',SAMYAR_TEXT_DOMAIN)?></div>
        <!--end::Link-->
    </div>
    <!--begin::Heading-->
    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::email-->
        <input type="email" id="userEmail" placeholder="<?php _e('Email',SAMYAR_TEXT_DOMAIN)?>" name="email"
               class="form-control bg-transparent"/>
        <!--end::email-->
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
    <!--begin::Actions-->
    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
        <button type="submit" id="kt_forget_send_verify_code_email_submit" class="btn btn-primary me-4">
            <!--begin::Indicator label-->
            <span class="indicator-label"><?php _e('send verify Code',SAMYAR_TEXT_DOMAIN)?></span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress"><?php _e('Please wait ...',SAMYAR_TEXT_DOMAIN)?><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
        <a href="<?= home_url('/login') ?>" class="btn btn-light"><?php _e('Cancel',SAMYAR_TEXT_DOMAIN)?></a>
        <a href="<?= add_query_arg(['action'=>'forget-password-email'], home_url('/login')) ?>" class="btn btn-light"><?php _e('forget password by mobile',SAMYAR_TEXT_DOMAIN)?></a>
    </div>
    <!--end::Actions-->
</form>