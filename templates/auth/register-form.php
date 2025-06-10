<?php
defined('ABSPATH') || exit('No Access!');
$enable_custom_username = settingsController::getInstance()->get_option('enable-custom-username', 0);
?>
<form class="form w-100" method="post" novalidate="novalidate" id="kt_sign_up_form"
      action="">
    <?php wp_nonce_field('user_registration_nonce', 'user_registration_nonce'); ?>
    <input type="hidden" name="action" value="kandopanel_user_registration">
    <input type="hidden" name="redirect" value="<?=$redirect?>">
    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3"><?php _e('Register',SAMYAR_TEXT_DOMAIN)?></h1>
        <!--end::Title-->
        <!--begin::Subtitle-->
        <div class="text-gray-500 fw-semibold fs-6"><?php _e('Register in',SAMYAR_TEXT_DOMAIN)?> <?= get_bloginfo('name') ?></div>
        <!--end::Subtitle=-->
    </div>
    <!--begin::Heading-->
    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::full name-->
        <input type="text" placeholder="<?php _e('full name',SAMYAR_TEXT_DOMAIN)?>" name="full_name"
               value="" autocomplete="off"
               class="form-control bg-transparent"/>
        <!--end::full name-->
    </div>
    <!--begin::Input group=-->

    <?php if($enable_custom_username){ ?>
    <div class="fv-row mb-8">

        <input type="text" placeholder="<?php _e('username',SAMYAR_TEXT_DOMAIN)?>" name="username"
               value="" autocomplete="off"
               class="form-control bg-transparent"/>

    </div>
    <?php }else{ ?>
        <div class="fv-row mb-8">
            <!--begin::full name-->
            <input type="tel" placeholder="<?php _e('phone number',SAMYAR_TEXT_DOMAIN)?>" name="phone_number"
                   value="" autocomplete="off"
                   class="form-control bg-transparent"/>
            <!--end::full name-->
        </div>
    <?php } ?>

    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::ایمیل-->
        <input type="email" placeholder="<?php _e('email',SAMYAR_TEXT_DOMAIN)?>" name="email" value=""
               autocomplete="off"
               class="form-control bg-transparent"/>
        <!--end::ایمیل-->
    </div>
    <!--begin::Input group-->
    <div class="fv-row mb-8" data-password-meter="true">
        <!--begin::Wrapper-->
        <div class="mb-1">
            <!--begin::Input wrapper-->
            <div class="position-relative mb-3">
                <input class="form-control bg-transparent ltr" type="password"
                       placeholder="<?php _e('password',SAMYAR_TEXT_DOMAIN)?>"
                       name="password" autocomplete="off"/>
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 start-0 ms-7"
                      data-password-meter-control="visibility">
												<i class="ki-outline fas fa-eye-slash fs-2"></i>
												<i class=" ki-outline fas fa-eye fs-2 d-none"></i>
											</span>
            </div>
            <!--end::Input wrapper-->
            <!--begin::Meter-->
            <div class="d-flex align-items-center mb-3" data-password-meter-control="highlight">
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
            </div>
            <!--end::Meter-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Hint-->
        <div class="text-muted">
            <?php _e('Use 8 or more characters with a mix of letters, numbers & symbols.',SAMYAR_TEXT_DOMAIN)?>
        </div>
        <!--end::Hint-->
    </div>
    <!--end::Input group=-->
    <!--end::Input group=-->
    <!--
   <div class="fv-row mb-8">

        <input placeholder="<?php _e('password confirm',SAMYAR_TEXT_DOMAIN)?>" name="password_confirm" type="password"
               autocomplete="off" class="form-control bg-transparent ltr"/>

    </div>
    -->
    <!--end::Input group=-->
    <div class="fv-row mb-3">
        <!--begin::password-->
        <div id="captchaContainer">
            <?php if($google_captcha_enable): ?>
                <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
            <?php endif; ?>
        </div>
        <!--end::password-->
    </div>
    <!--begin::Accept-->
    <div class="fv-row mb-8">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="toc" value="1"/>
            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1"><?php _e('I accept the rules and regulations of the site',SAMYAR_TEXT_DOMAIN)?></span>
        </label>
    </div>
    <!--end::Accept-->
    <!--begin::ثبت button-->
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary" disabled>
            <!--begin::Indicator label-->
            <span class="indicator-label"><?php _e('Register',SAMYAR_TEXT_DOMAIN)?></span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress"><?php _e('Please wait ...',SAMYAR_TEXT_DOMAIN)?><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::ثبت button-->
    <!--begin::Sign up-->
    <div class="text-gray-500 text-center fw-semibold fs-6"><?php _e('Already registered?',SAMYAR_TEXT_DOMAIN)?><a href="<?= home_url('/login') ?>"
           class="link-primary fw-semibold"><?php _e('Login',SAMYAR_TEXT_DOMAIN)?></a></div>
    <!--end::Sign up-->
</form>