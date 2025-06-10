<?php

use samyar\userController;

if (!is_user_logged_in()):
    $userClass = new userController();
    $options = settingsController::getInstance();
    $google_captcha_enable = esc_attr($options->get_option('google-captcha-enable', 0));
    $siteKey = esc_attr($options->get_option('google-captcha-key', ""));
    $secretKey = esc_attr($options->get_option('google-captcha-secret-key', ""));
    ?>
    <div class="kt-modal-inner kt-login-modal">
        <i class="kt-modal-close"></i>
        <div class="kt-modal-content">
            <div class="tabs-style2 align-right kt-modal-tabs" id="kando-login-tab">
                <ul class="tabs-title-holder">
                    <li class="tab-title" id="tab-login-mobile"><h4 class="tab-title-inner">ورود با شماره همراه</h4></li>
                    <li class="tab-title" id="tab-login-email"><h4 class="tab-title-inner">ورود با ایمیل یا نام کاربری</h4></li>
                </ul>
                <div class="tabs-content-holder">
                    <div class="tabs-content-inner">
                        <div class="tab-content tab-login-mobile">
                            <div class="tab-content-inner">
                                <div class="login-form">


                                    <form class="kt-login-form" action="<?php echo home_url() ?>" method="post">
                                        <input type="hidden" name="action" value="kando_ajax_login">
                                        <input type="hidden" id="login-type" name="type" value="mobile">
                                        <div class="kt-login-form-errors"></div>

                                        <div class="step1">
                                            <input type="text" class="kt-login-email ltr" style="display: none" name="email" placeholder="ایمیل یا نام کاربری">
                                            <input type="text" class="kt-login-mobile ltr" name="mobile" placeholder="شماره همراه">
                                            <div class="action-link kt-register-btn">
                                                ساخت حساب جدید
                                                <i class="fal fa-angle-left"></i>
                                            </div>
                                            <div class="action-link kt-forget-btn">
                                                بازیابی رمز عبور
                                                <i class="fal fa-angle-left"></i>
                                            </div>
                                            <button class="button kt-ajax-button button-green w-100" id="kando_user_process">ادامه</button>
                                        </div>


                                        <div class="step2" style="display: none">
                                            <div class="kt-login-form-errors"></div>
                                            <div class="kt-login-password-holder"><input type="password" class="kt-login-password" name="password" placeholder="کلمه عبور"><a href="#" class="kt-forget-btn" tabindex="-1">بازیابی
                                                    رمز
                                                    عبور</a></div>


                                            <?php if ($userClass->enable_sms()): ?>
                                                <div class="action-link kt-send-otp">
                                                    ورود با رمز یکبار مصرف
                                                    <i class="fal fa-angle-left"></i>
                                                    <div class="fa-3x" style="font-size: 1em;display:none">
                                                        <i class="fas fa-spinner fa-pulse"></i>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($google_captcha_enable): ?>
                                                <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                                            <?php endif; ?>
                                            <div style="clear: both">
                                                <input type="checkbox" class="kt-login-remember" name="remember" id="kt-login-remember"/>
                                                <label class="kt-login-remember-label" for="kt-login-remember">مرا به خاطر بسپار</label>
                                                <button class="button kt-ajax-button button-default kt-login-submit" name="kt_login_submit">ورود به سایت</button>
                                            </div>


                                        </div>
                                    </form>

                                    <?php include(SAMYAR_DIR_TEMPLATE . '/auth/otp-form.php') ?>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tabs-style2 align-right kt-modal-tabs" id="kando-register-tab" style="display: none">
                <ul class="tabs-title-holder">
                    <li class="tab-title w-100" id="tab-login-mobile"><h4 class="tab-title-inner">ثبت نام</h4></li>
                </ul>
                <div class="tabs-content-holder">
                    <div class="tabs-content-inner">
                        <div class="tab-content tab-login-mobile">
                            <div class="tab-content-inner">
                                <div class="login-form">

                                    <form class="kt-register-form" action="<?php echo home_url() ?>" method="post">
                                        <input type="hidden" id="login-type" name="type" value="mobile">
                                        <div class="kt-register-form-errors"></div>

                                        <div class="step1">
                                            <input type="text" class="kt-register-mobile ltr" name="mobile" placeholder="شماره همراه">
                                            <?php if($google_captcha_enable): ?>
                                                <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                                            <?php endif; ?>
                                            <div class="action-link kt-login-btn">
                                                رفتن به ورود
                                                <i class="fal fa-angle-left"></i>
                                            </div>
                                            <div class="action-link kt-forget-btn">
                                                بازیابی رمز عبور
                                                <i class="fal fa-angle-left"></i>
                                            </div>
                                            <button class="button kt-ajax-button button-green w-100" id="kando_user_process_for_register">ادامه</button>
                                        </div>


                                        <div class="step2" style="display: none">
                                            <input type="hidden" name="action" value="samyar_ajax_login">
                                            <div class="kt-login-form-errors"></div>
                                            <label style="font-size: 0.8rem;">نام و نام خانوادگی:</label>
                                            <input type="text" class="kt-register-name" name="name" placeholder="نام و نام خانوادگی">
                                            <div class="auth-alert"></div>
                                            <label style="font-size: 0.8rem;">رمز عبور:</label>
                                            <div class="kt-login-password-holder"><input type="password" class="kt-register-password" name="password" placeholder="کلمه عبور"></div>

                                            <?php if (!$userClass->enable_sms())://اگر پیامک فعال نبود ?>
                                                <?php if($google_captcha_enable)://اگر کپچا فعال بود ?>
                                                    <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <button class="button kt-ajax-button button-default kt-login-submit w-100" id="kando_check_password">ادامه</button>

                                        </div>
                                    </form>
                                    <?php include(SAMYAR_DIR_TEMPLATE . '/auth/otp-form.php') ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tabs-style2 align-right kt-modal-tabs" id="kando-forget-tab" style="display: none">
                <ul class="tabs-title-holder">
                    <?php if ($userClass->enable_sms()): ?>
                        <li class="tab-title" id="tab-forget-mobile"><h4 class="tab-title-inner">بازیابی با شماره همراه</h4></li>
                    <?php endif; ?>
                    <li class="tab-title <?php if (!$userClass->enable_sms()): ?>w-100<?php endif; ?>" id="tab-forget-email"><h4 class="tab-title-inner">بازیابی با ایمیل</h4></li>
                </ul>
                <div class="tabs-content-holder">
                    <div class="tabs-content-inner">
                        <div class="tab-content tab-login-mobile">
                            <div class="tab-content-inner">
                                <div class="login-form">


                                    <form class="kt-forget-form" action="<?php echo home_url() ?>" method="post">
                                        <input type="hidden" name="action" value="kando_ajax_forget">
                                        <input type="hidden" id="forget-type" name="forget_type" value="<?php if ($userClass->enable_sms()): ?>mobile<?php else: ?>email<?php endif; ?>">
                                        <div class="kt-login-form-errors"></div>

                                        <div class="step1">
                                            <input type="text" class="kt-forget-email ltr" style="<?php if ($userClass->enable_sms()): ?>display: none<?php endif; ?>" name="email" placeholder="ایمیل یا نام کاربری">
                                            <?php if ($userClass->enable_sms()): ?>
                                                <input type="text" class="kt-forget-mobile ltr" name="mobile" placeholder="شماره همراه">
                                            <?php endif; ?>
                                            <?php if($google_captcha_enable): ?>
                                                <div style="margin:10px auto" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                                            <?php endif; ?>
                                            <div class="action-link kt-login-btn">
                                                رفتن به ورود
                                                <i class="fal fa-angle-left"></i>
                                            </div>
                                            <button class="button kt-ajax-button button-green w-100" id="kando_user_process">ادامه</button>

                                        </div>
                                        <div class="step2" style="display: none">
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
                                            <div class="kt-login-password-holder"><input type="password" class="kt-login-password" style="margin: 23px 0 10px 0;" name="newPassword"
                                                                                         placeholder="کلمه عبور جدید"></div>
                                            <div class="kt-login-password-holder"><input type="password" class="kt-login-password" style="margin: 0 0 10px 0;" name="newPasswordVerify"
                                                                                         placeholder="تکرار کلمه عبور جدید"></div>
                                            <a href="#" class="button button-green kt-ajax-button kt-verify-otp-code">تغییر رمز عبور</a>
                                            <button class="button button-blue kt-ajax-button kt-verify-send-again">ارسال مجدد کد تایید</button>
                                        </div>


                                    </form>

                                    <?php include(SAMYAR_DIR_TEMPLATE . '/auth/otp-form.php') ?>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endif;