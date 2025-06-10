<?php
defined('ABSPATH') || exit('No Access!');


$site_favicon = $options->get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = $options->get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}


$site_logo = $options->get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = $options->get_option('site-logo');
    $site_logo = wp_get_attachment_url($site_logo);
}


$site_mobile_logo = $options->get_option('site-mobile-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_mobile_logo) && !empty($site_mobile_logo) && is_numeric($site_mobile_logo)) {
    $site_mobile_logo = $options->get_option('site-mobile-logo');
    $site_mobile_logo = wp_get_attachment_url($site_mobile_logo);
}
?>
<div class="samyar-settings-area samyar-settings-auth">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="user"></span></span>
        <strong><?php _e('auth', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e('general', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <!--        <li><a href="#">--><?php //_e( 'style', SAMYAR_TEXT_DOMAIN ); ?><!--</a></li>-->
        <li><a href="#"><?php _e('Customize', SAMYAR_TEXT_DOMAIN); ?></a></li>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label">ارسال کد تایید و بررسی صحت شماره همراه در ثبت نام و ورود</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-otp-register" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-otp-register"
                                   value="1" <?php echo checked($options->get_option('enable-otp-register', 1), 1); ?>>فعال</label>
                    </div>

                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">ارسال کد تایید و بررسی صحت شماره همراه در ارسال سفارش</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-otp-order" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-otp-order"
                                   value="1" <?php echo checked($options->get_option('enable-otp-order', 1), 1); ?>>فعال</label>
                    </div>

                </div>


                <?php
                $rest_password_type = $options->get_option('rest-password-type', 'active-code');
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label">نوع بازیابی رمز عبور</label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="rest-password-type">
                            <option <?php if ($rest_password_type === "active-code"): ?> selected <?php endif; ?>
                                    value="active-code">ارسال کد تایید به موبایل یا ایمیل و تعیین رمز دلخواه توسط مشتری
                            </option>
                            <option <?php if ($rest_password_type === "random-pass"): ?> selected <?php endif; ?>
                                    value="random-pass">ارسال رمز عبور رندوم به موبایل یا ایمیل کاربر
                            </option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-redirect-register">لینکی که می خواهید کاربر بعد از ثبت نام
                        به آن هدایت شود</label>
                    <input type="text" class="uk-input ltr" id="samyar-redirect-register" name="redirect-register"
                           value="<?php echo esc_attr($options->get_option('redirect-register', home_url('dashboard'))); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-redirect-login">لینکی که می خواهید کاربر بعد از ورود به آن
                        هدایت شود</label>
                    <input type="text" class="uk-input ltr" id="samyar-redirect-login" name="redirect-login"
                           value="<?php echo esc_attr($options->get_option('redirect-login', home_url('dashboard'))); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-redirect-logout">لینکی که می خواهید کاربر بعد از خروج از
                        حساب به آن هدایت شود</label>
                    <input type="text" class="uk-input ltr" id="samyar-redirect-logout" name="redirect-logout"
                           value="<?php echo esc_attr($options->get_option('redirect-logout', home_url('login'))); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0">
                        <p><b>گوگل کپچا چیست؟:</b> برای اینکه ربات ها نتونن در فرم ها، ارسال های پیاپی برای یافتن رمز
                            عبور کاربر یا مدیر انجام بدن گوگل یه چک کننده فرم طراحی کرده که با تنظیمش شما می تونید جلوی
                            این مورد رو بگیرید و دیگه از بابت ربات ها خیالتون راحت هست و امنیت ورود و ثبت نام کاربران هم
                            تامین خواهد شد. توصیه ما این هست که حتما این مورد رو فعال کنید </p>
                        <b>برای گرفتن گوگل کپچا ، ابتدا فیلتر شکن خود را روشن کرده و سپس بر روی لینک زیر کلیک
                            کنید:</b><br><br>
                        <a href="https://www.google.com/recaptcha/admin" target="_blank">ساخت گوگل کپچا</a>
                        <br>
                        <p><b>توجه کنید که باید ورژن 2 را انتخاب نمایید</b></p>
                        </p>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">فعالسازی گوگل کپچا</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="google-captcha-enable" value="0">
                            <input class="uk-checkbox" type="checkbox" name="google-captcha-enable"
                                   value="1" <?php echo checked($options->get_option('google-captcha-enable', 0), 1); ?>>فعال</label>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="google-captcha-key">کلید سایت (site key)</label>
                        <input type="text" dir="ltr" class="uk-input" id="google-captcha-key" name="google-captcha-key"
                               value="<?php echo esc_attr($options->get_option('google-captcha-key', "")); ?>">
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="google-captcha-secret-key">کلید مخفی سایت (secret key)</label>
                        <input type="text" dir="ltr" class="uk-input" id="google-captcha-secret-key"
                               name="google-captcha-secret-key"
                               value="<?php echo esc_attr($options->get_option('google-captcha-secret-key', "")); ?>">
                    </div>
                </div>
                <?php do_action('kando_auth_settings') ?>
            </div>
        </li>
        <!--
        <li>

            <div class="uk-margin">
                <label class="uk-form-label">فعالسازی پس زمینه متحرک</label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-animation-background" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-animation-background" value="1" <?php echo checked($options->get_option('enable-animation-background', 0), 1); ?>>فعال</label>
                </div>

            </div>

            <div class="uk-margin">
                <?php
        $background1 = $options->get_option('background1', SAMYAR_DIR_IMG . '/backgrounds/background1.jpeg');
        if (isset($background1) && !empty($background1) && is_numeric($background1)) {
            $background1 = $options->get_option('background1');
            $background1 = wp_get_attachment_url($background1);
        }
        ?>
                <label class="uk-form-label">تصویر اول</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background1" value="<?php echo esc_attr($background1); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background1); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background1); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
        $background2 = $options->get_option('background2', SAMYAR_DIR_IMG . '/backgrounds/background2.jpeg');
        if (isset($background2) && !empty($background2) && is_numeric($background2)) {
            $background2 = $options->get_option('background2');
            $background2 = wp_get_attachment_url($background2);
        }
        ?>
                <label class="uk-form-label">تصویر دوم</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background2" value="<?php echo esc_attr($background2); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background2); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background2); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
        $background3 = $options->get_option('background3', "");
        if (isset($background3) && !empty($background3) && is_numeric($background3)) {
            $background3 = $options->get_option('background3');
            $background3 = wp_get_attachment_url($background3);
        }
        ?>
                <label class="uk-form-label">تصویر سوم</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background3" value="<?php echo esc_attr($background3); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background3); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background3); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
        $background4 = $options->get_option('background4', "");
        if (isset($background4) && !empty($background4) && is_numeric($background4)) {
            $background4 = $options->get_option('background4');
            $background4 = wp_get_attachment_url($background4);
        }
        ?>
                <label class="uk-form-label">تصویر چهارم</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background4" value="<?php echo esc_attr($background4); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background4); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background4); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>
        </li>
        -->
        <li>

            <div class="uk-margin">
                <?php
                $login_background = $options->get_option('login-background', SAMYAR_DIR_IMG . '/auth/auth-bg.png');


                if (isset($login_background) && !empty($login_background) && is_numeric($login_background)) {
                    $login_background = $options->get_option('login-background');
                    $login_background = wp_get_attachment_url($login_background);
                }
                ?>
                <label class="uk-form-label">تصویر پس زمینه ورود</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="login-background" value="<?php echo esc_attr($login_background); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-login-background"
                               readonly value="<?php echo esc_attr($login_background); ?>">
                        <a href="#" class="samyar-remove" data-toggle="login-background" uk-tooltip="title: حذف"><span
                                    uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($login_background); ?>" class="samyar-url"
                           uk-tooltip="title: مشاهده" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
                $login_item_pic = $options->get_option('login-item-pic', SAMYAR_DIR_IMG . '/auth/auth-screens.png');
                if (isset($login_item_pic) && !empty($login_item_pic) && is_numeric($login_item_pic)) {
                    $login_item_pic = $options->get_option('login-item-pic');
                    $login_item_pic = wp_get_attachment_url($login_item_pic);
                }
                ?>
                <label class="uk-form-label">تصویر آیتم در ورود</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="login-item-pic" value="<?php echo esc_attr($login_item_pic); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-login-item-pic"
                               readonly value="<?php echo esc_attr($login_item_pic); ?>">
                        <a href="#" class="samyar-remove" data-toggle="login-item-pic" uk-tooltip="title: حذف"><span
                                    uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($login_item_pic); ?>" class="samyar-url" uk-tooltip="title: مشاهده"
                           target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label">استفاده از نام کاربری به جای شماره همراه در ثبت نام (به صورت عادی شماره همراه به جای نام کاربری در نظر گرفته می شود اگر این ویژگی رو فعال کنید شماره همراه از بخش ثبت نام حذف و نام کاربری جایگزین خواهد شد)</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-custom-username" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-custom-username"
                                   value="1" <?php echo checked($options->get_option('enable-custom-username', 0), 1); ?>>فعال</label>
                    </div>

                </div>
            </div>


        </li>
    </ul>
</div>