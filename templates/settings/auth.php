<?php
defined('ABSPATH') || exit('No Access!');
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
        <li><a href="#"><?php _e('Security', SAMYAR_TEXT_DOMAIN); ?></a></li>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Send verification code and validate mobile number during registration and login', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-otp-register" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-otp-register"
                                   value="1" <?php echo checked(kando_get_option('enable-otp-register', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Send verification code and validate mobile number during order submission', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-otp-order" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-otp-order"
                                   value="1" <?php echo checked(kando_get_option('enable-otp-order', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>


                <?php
                $rest_password_type = kando_get_option('rest-password-type', 'active-code');
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Password recovery type', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="rest-password-type">
                            <option <?php if ($rest_password_type === "active-code"): ?> selected <?php endif; ?>
                                    value="active-code"><?php _e('Send verification code to mobile or email and allow the customer to set a custom password', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($rest_password_type === "random-pass"): ?> selected <?php endif; ?>
                                    value="random-pass"><?php _e('Send a random password to the user\'s mobile or email', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-redirect-register"><?php _e('The link you want the user to be redirected to after registration', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input ltr" id="samyar-redirect-register" name="redirect-register"
                           value="<?php echo esc_attr(kando_get_option('redirect-register', home_url('dashboard'))); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-redirect-login"><?php _e('The link you want the user to be redirected to after login', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input ltr" id="samyar-redirect-login" name="redirect-login"
                           value="<?php echo esc_attr(kando_get_option('redirect-login', home_url('dashboard'))); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-redirect-logout"><?php _e('The link you want the user to be redirected to after logout', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input ltr" id="samyar-redirect-logout" name="redirect-logout"
                           value="<?php echo esc_attr(kando_get_option('redirect-logout', home_url('login'))); ?>">
                </div>
                <hr>
                <div class="uk-alert-primary uk-alert" uk-alert="">
                    <p style="margin-top: 0">
                        <?php _e("This section is for when you want to replace the default Condopanel login and registration with your own custom login and registration (for example, using the Digits plugin).", SAMYAR_TEXT_DOMAIN); ?>
                    <p>
                </div>

                <?php
                $samyar_login_page = kando_get_option('samyar-login-page', 0);
                $pages = kando_get_published_pages();
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e("Select Login Page", SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="samyar-login-page">
                            <option value=""><?php _e("Please select an item.", SAMYAR_TEXT_DOMAIN); ?></option>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?= $page->ID ?>" <?php selected( $samyar_login_page, $page->ID ); ?>><?= esc_html($page->post_title) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
                <hr>
                <?php
                $samyar_register_page = kando_get_option('samyar-register-page', 0);
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e("Select Register Page", SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="samyar-register-page">
                            <option value=""><?php _e("Please select an item.", SAMYAR_TEXT_DOMAIN); ?></option>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?= $page->ID ?>" <?php selected( $samyar_register_page, $page->ID ); ?>><?= esc_html($page->post_title) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>

                <div class="uk-margin">
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0">
                        <p><b><?php _e('What is Google Captcha?', SAMYAR_TEXT_DOMAIN); ?>:</b> <?php _e('To prevent bots from repeatedly submitting forms to find user or admin passwords, Google has designed a form checker. By enabling this, you can prevent such activities and ensure the security of user login and registration. We highly recommend enabling this feature.', SAMYAR_TEXT_DOMAIN); ?></p>
                        <b><?php _e('To get Google Captcha, first turn on your VPN and then click the link below:', SAMYAR_TEXT_DOMAIN); ?></b><br><br>
                        <a href="https://www.google.com/recaptcha/admin" target="_blank"><?php _e('Create Google Captcha', SAMYAR_TEXT_DOMAIN); ?></a>
                        <br>
                        <p><b><?php _e('Note: You must select version 2.', SAMYAR_TEXT_DOMAIN); ?></b></p>
                        </p>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Enable Google Captcha', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="google-captcha-enable" value="0">
                            <input class="uk-checkbox" type="checkbox" name="google-captcha-enable"
                                   value="1" <?php echo checked(kando_get_option('google-captcha-enable', 0), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="google-captcha-key"><?php _e('Site key', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="text" dir="ltr" class="uk-input" id="google-captcha-key" name="google-captcha-key"
                               value="<?php echo esc_attr(kando_get_option('google-captcha-key', "")); ?>">
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="google-captcha-secret-key"><?php _e('Secret key', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="text" dir="ltr" class="uk-input" id="google-captcha-secret-key"
                               name="google-captcha-secret-key"
                               value="<?php echo esc_attr(kando_get_option('google-captcha-secret-key', "")); ?>">
                    </div>
                </div>
                <?php do_action('kando_auth_settings') ?>
            </div>
        </li>
        <!--
        <li>

            <div class="uk-margin">
                <label class="uk-form-label">Enable animated background</label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-animation-background" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-animation-background" value="1" <?php echo checked(kando_get_option('enable-animation-background', 0), 1); ?>>Active</label>
                </div>

            </div>

            <div class="uk-margin">
                <?php
        $background1 = kando_get_option('background1', SAMYAR_DIR_IMG . '/backgrounds/background1.jpeg');
        if (isset($background1) && !empty($background1) && is_numeric($background1)) {
            $background1 = kando_get_option('background1');
            $background1 = wp_get_attachment_url($background1);
        }
        ?>
                <label class="uk-form-label">First image</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background1" value="<?php echo esc_attr($background1); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background1); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: Delete"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background1); ?>" class="samyar-url" uk-tooltip="title: View" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
        $background2 = kando_get_option('background2', SAMYAR_DIR_IMG . '/backgrounds/background2.jpeg');
        if (isset($background2) && !empty($background2) && is_numeric($background2)) {
            $background2 = kando_get_option('background2');
            $background2 = wp_get_attachment_url($background2);
        }
        ?>
                <label class="uk-form-label">Second image</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background2" value="<?php echo esc_attr($background2); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background2); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: Delete"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background2); ?>" class="samyar-url" uk-tooltip="title: View" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
        $background3 = kando_get_option('background3', "");
        if (isset($background3) && !empty($background3) && is_numeric($background3)) {
            $background3 = kando_get_option('background3');
            $background3 = wp_get_attachment_url($background3);
        }
        ?>
                <label class="uk-form-label">Third image</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background3" value="<?php echo esc_attr($background3); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background3); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: Delete"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background3); ?>" class="samyar-url" uk-tooltip="title: View" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
        $background4 = kando_get_option('background4', "");
        if (isset($background4) && !empty($background4) && is_numeric($background4)) {
            $background4 = kando_get_option('background4');
            $background4 = wp_get_attachment_url($background4);
        }
        ?>
                <label class="uk-form-label">Fourth image</label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="background4" value="<?php echo esc_attr($background4); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-site-logo" readonly value="<?php echo esc_attr($background4); ?>">
                        <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: Delete"><span uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($background4); ?>" class="samyar-url" uk-tooltip="title: View" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>
        </li>
        -->
        <li>

            <div class="uk-margin">
                <?php
                $login_background = kando_get_option('login-background', SAMYAR_DIR_IMG . '/auth/auth-bg.png');


                if (isset($login_background) && !empty($login_background) && is_numeric($login_background)) {
                    $login_background = kando_get_option('login-background');
                    $login_background = wp_get_attachment_url($login_background);
                }
                ?>
                <label class="uk-form-label"><?php _e('Login background image', SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="login-background" value="<?php echo esc_attr($login_background); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-login-background"
                               readonly value="<?php echo esc_attr($login_background); ?>">
                        <a href="#" class="samyar-remove" data-toggle="login-background" uk-tooltip="title: Delete"><span
                                    uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($login_background); ?>" class="samyar-url"
                           uk-tooltip="title: View" target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <?php
                $login_item_pic = kando_get_option('login-item-pic', SAMYAR_DIR_IMG . '/auth/auth-screens.png');
                if (isset($login_item_pic) && !empty($login_item_pic) && is_numeric($login_item_pic)) {
                    $login_item_pic = kando_get_option('login-item-pic');
                    $login_item_pic = wp_get_attachment_url($login_item_pic);
                }
                ?>
                <label class="uk-form-label"><?php _e('Login item image', SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <div class="samyar-upload-file-wrapper">
                        <input type="hidden" name="login-item-pic" value="<?php echo esc_attr($login_item_pic); ?>">
                        <input type="text" dir="ltr" class="samyar-upload-file uk-input" id="samyar-login-item-pic"
                               readonly value="<?php echo esc_attr($login_item_pic); ?>">
                        <a href="#" class="samyar-remove" data-toggle="login-item-pic" uk-tooltip="title: Delete"><span
                                    uk-icon="trash"></a>
                        <a href="<?php echo esc_attr($login_item_pic); ?>" class="samyar-url" uk-tooltip="title: View"
                           target="_blank"><span
                                    uk-icon="link"></a>
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Use username instead of mobile number during registration (by default, the mobile number is used as the username. If you enable this feature, the mobile number field will be removed from the registration form and replaced with a username field)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-custom-username" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-custom-username"
                                   value="1" <?php echo checked(kando_get_option('enable-custom-username', 0), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Use email instead of mobile number for guest user', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-verification" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-verification"
                                   value="1" <?php echo checked(kando_get_option('enable-email-verification', 0), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>
            </div>


        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-times_can_attempt_log_in"><?php _e('How many times can the user attempt to log in?', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input ltr" id="samyar-times_can_attempt_log_in" name="times_can_attempt_log_in"
                           value="<?php echo esc_attr(kando_get_option('times_can_attempt_log_in', 5)); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-how_minutes_blocked"><?php _e('After unsuccessful attempts, how many minutes will it remain blocked?', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input ltr" id="samyar-how_minutes_blocked" name="how_minutes_blocked"
                           value="<?php echo esc_attr(kando_get_option('how_minutes_blocked',15)); ?>">
                </div>

                <?php do_action('kando_auth_settings') ?>
            </div>
        </li>

    </ul>
</div>