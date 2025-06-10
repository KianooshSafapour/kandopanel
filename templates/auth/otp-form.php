<?php
defined('ABSPATH') || exit('No Access!');
?>
<form class="kt-verify-form" action="<?php echo home_url() ?>" method="post">
    <div class="kt-verify-form-errors"></div>
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

    <a href="#" class="button button-green kt-ajax-button kt-verify-otp-code">بررسی صحت کد</a>
    <button class="button button-blue kt-ajax-button kt-verify-send-again">ارسال مجدد</button>
    <div class="action-link kt-password-btn">
        رفتن به ورود با رمز عبور
        <i class="fal fa-angle-left"></i>
    </div>
</form>