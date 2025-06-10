<?php
defined('ABSPATH') || exit('No Access!');

$email = isset($_GET['email']) ? $_GET['email'] : "";
if ($email) {
    ?>
    <form class="form w-100" id="kt_password_reset_by_email2_form" novalidate="novalidate">
        <?php wp_nonce_field('forgot_password_by_email2_action', 'forgot_password_by_email2_nonce'); ?>
        <input type="hidden" name="action" value="kandopanel_verify_forgot_password_email">
        <input type="hidden" name="email" value="<?= esc_attr($email) ?>">
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3"><?php _e('forget password', SAMYAR_TEXT_DOMAIN) ?></h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6"><?php _e('Validity check', SAMYAR_TEXT_DOMAIN) ?></div>
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

        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="false">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent ltr" type="password"
                           placeholder="<?php _e('new password', SAMYAR_TEXT_DOMAIN) ?>"
                           name="password" autocomplete="off"/>
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 start-0 ms-7"
                          data-kt-password-meter-control="visibility">
												<i class="bi bi-eye-slash fs-2"></i>
												<i class="bi bi-eye fs-2 d-none"></i>
											</span>
                </div>
                <!--end::Input wrapper-->

            </div>
            <!--end::Wrapper-->
            <!--begin::Hint-->
            <div class="text-muted">
                <?php _e('At least 8 characters', SAMYAR_TEXT_DOMAIN) ?>
            </div>
            <!--end::Hint-->
        </div>
        <!--end::Input group=-->
        <!--end::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Repeat password-->
            <input placeholder="<?php _e('password confirm', SAMYAR_TEXT_DOMAIN) ?>" name="password_confirm"
                   type="password"
                   autocomplete="off" class="form-control bg-transparent ltr"/>
            <!--end::Repeat password-->
        </div>
        <!--end::Input group=-->
        <div class="fv-row mb-3">
            <!--begin::password-->
            <div id="captchaContainer">
                <?php if ($google_captcha_enable): ?>
                    <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                <?php endif; ?>
            </div>
            <!--end::password-->
        </div>
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_forget_verify_code_email_submit" class="btn btn-primary me-4">
                <!--begin::Indicator label-->
                <span class="indicator-label"><?php _e('Validity check', SAMYAR_TEXT_DOMAIN) ?></span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress"><?php _e('Please wait ...', SAMYAR_TEXT_DOMAIN) ?><span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
            <button type="submit" id="kt_repeat_email_submit" class="btn btn-primary me-4">
                <!--begin::Indicator label-->
                <span class="indicator-label"><?php _e('Resend', SAMYAR_TEXT_DOMAIN) ?></span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress"><?php _e('Please wait ...', SAMYAR_TEXT_DOMAIN) ?><span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
            <a href="<?= home_url('/login') ?>" class="btn btn-light"><?php _e('Cancel', SAMYAR_TEXT_DOMAIN) ?></a>
        </div>
        <!--end::Actions-->
    </form>
    <?php
}