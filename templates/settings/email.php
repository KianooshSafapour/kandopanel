<?php
defined('ABSPATH') || exit('No Access!');

$emailController = emailController::getInstance();
?>
<div class="samyar-settings-area samyar-settings-email">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="email"></span></span>
        <strong><?php _e('EMAIL', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <!--
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b>ویدیو آموزشی مربوط به تنظیمات ایمیل کندو پنل را از لینک زیر تماشا کنید:</b><br><br>
                <a href="#" target="_blank">ویدیو آموزشی تنظیمات ایمیل کندو پنل</a>
                <br>
            </p>
        </div>
    </div>
    -->
    <div class="uk-margin">
        <label class="uk-form-label">فعالسازی سرویس ایمیل</label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-email" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-email" value="1" <?php echo checked($options->get_option('enable-email', 0), 1); ?>>فعال</label>
        </div>

    </div>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e('تنظیمات ایمیل', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('قالب های ایمیل', SAMYAR_TEXT_DOMAIN); ?></a></li>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label" for="website-title"><?php _e('email sender title', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" id="samyar-website-title" name="website-title" value="<?php echo esc_attr($options->get_option('website-title', "")); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="support-email"><?php _e('email sender', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" id="samyar-support-email" name="support-email" value="<?php echo esc_attr($options->get_option('support-email', "")); ?>">
                </div>

            </div>
        </li>
        <li>
            <div class="uk-margin">
                <!--
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-email-verification-pattern"><?php _e('email verification pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <?php wp_editor($options->get_option('email-verification-pattern',$emailController->get_email_template( 'email-verification-pattern' )),'email-verification-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-email-verification-pattern"><?php _e('email new password pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <?php wp_editor($options->get_option('email-sendNewPass-pattern',$emailController->get_email_template( 'email-sendNewPass-pattern' )),'email-sendNewPass-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>
                -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-email-new-registration-pattern">ارسال ایمیل به مدیر بعد از اینکه کاربری در سایت ثبت نام کرد </label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-new-registration" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-new-registration" value="1" <?php echo checked($options->get_option('enable-email-new-registration', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-new-registration-pattern',$emailController->get_email_template( 'email-new-registration-pattern' )),'email-new-registration-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>

                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-pattern"><?php _e('send email to admin after order', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-send-order-to-admin" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-send-order-to-admin" value="1" <?php echo checked($options->get_option('enable-email-send-order-to-admin', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-order-to-admin-pattern',$emailController->get_email_template( 'email-send-order-to-admin-pattern' )),'email-send-order-to-admin-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>

                    <div class="uk-margin">
                        <label class="uk-form-label">اگر سفارش از api هم ارسال شد به مدیر ایمیل بفرست</label>
                        <div class="uk-margin-small">
                            <label>
                                <input class="uk-checkbox" type="checkbox" name="email-send-order-to-admin-by-api-pattern"
                                       value="1" <?php echo checked($options->get_option('email-send-order-to-admin-by-api-pattern',0), 1); ?>>
                                فعال
                            </label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-for-custom-pattern">ارسال ایمیل به مدیر وقتی کاربری سفارش دستی ثبت میکند</label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-send-order-to-admin-for-custom" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-send-order-to-admin-for-custom" value="1" <?php echo checked($options->get_option('enable-email-send-order-to-admin-for-custom', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-order-to-admin-for-custom-pattern',$emailController->get_email_template( 'email-send-order-to-admin-for-custom-pattern' )),'email-send-order-to-admin-for-custom-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>

                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-email-add-credit-pattern">ارسال ایمیل به مدیر وقتی کاربر کیف پولش را شارژ می کند</label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-add-credit" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-add-credit" value="1" <?php echo checked($options->get_option('enable-email-add-credit', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-add-credit-pattern',$emailController->get_email_template( 'email-add-credit-pattern' )),'email-add-credit-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-user-pattern"><?php _e('send email to user after order pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-send-order-to-user" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-send-order-to-user" value="1" <?php echo checked($options->get_option('enable-email-send-order-to-user', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-order-to-user-pattern',$emailController->get_email_template( 'email-send-order-to-user-pattern' )),'email-send-order-to-user-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>

                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-email-new-status-pattern">ارسال ایمیل تغییر وضعیت سفارش</label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-new-status" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-new-status" value="1" <?php echo checked($options->get_option('enable-email-new-status', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-new-status-pattern',$emailController->get_email_template( 'email-new-status-pattern' )),'email-new-status-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-email-credit-not-enough-pattern">ارسال ایمیل عدم موجودی به استفاده کننده از api</label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-credit-not-enough" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-credit-not-enough" value="1" <?php echo checked($options->get_option('enable-email-credit-not-enough', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-credit-not-enough-pattern',$emailController->get_email_template( 'email-credit-not-enough-pattern' )),'email-credit-not-enough-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-newticket-to-admin-pattern"><?php _e('send email to admin for new ticket pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-new-ticket-to-admin" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-new-ticket-to-admin" value="1" <?php echo checked($options->get_option('enable-email-new-ticket-to-admin', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-new-ticket-to-admin-pattern',$emailController->get_email_template( 'email-send-new-ticket-to-admin-pattern' )),'email-send-new-ticket-to-admin-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-newticket-to-user-pattern"><?php _e('send email to user for new ticket pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-new-ticket-to-user" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-new-ticket-to-user" value="1" <?php echo checked($options->get_option('enable-email-new-ticket-to-user', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-new-ticket-to-user-pattern',$emailController->get_email_template( 'email-send-new-ticket-to-user-pattern' )),'email-send-new-ticket-to-user-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-new-answer-to-admin-pattern"><?php _e('send email to admin for new answer pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-new-answer-to-admin" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-new-answer-to-admin" value="1" <?php echo checked($options->get_option('enable-email-new-answer-to-admin', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-new-answer-to-admin-pattern',$emailController->get_email_template( 'email-send-new-answer-to-admin-pattern' )),'email-send-new-answer-to-admin-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-new-answer-to-admin-pattern"><?php _e('send email to user for new answer pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">

                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-email-new-answer-to-user" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-email-new-answer-to-user" value="1" <?php echo checked($options->get_option('enable-email-new-answer-to-user', 0), 1); ?>>فعال
                        </label>

                    </div>
                    <?php wp_editor($options->get_option('email-send-new-answer-to-user-pattern',$emailController->get_email_template( 'email-send-new-answer-to-user-pattern' )),'email-send-new-answer-to-user-pattern',array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                </div>
            </div>
        </li>
    </ul>
</div>