<?php

use kandopanel\currencyController;
use samyar\userController;

$userController = new userController();
if (is_user_logged_in()):
//    $user = get_current_user();
    $user = get_user_by('ID', get_current_user_id());
    $mobile = get_user_meta($user->ID, 'mobile', true);
    $user_token = get_user_meta($user->ID, "api_token", true);
    $your_domain = get_user_meta($user->ID, "your_domain", true);
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <?php kando_show_alerts('profile'); ?>
        </div>
    </div>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-6">
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_profile"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Profile picture", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">

                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">
                                <form class="samyar-form kando-avatar-form" id="kando-avatar-form"
                                      enctype="multipart/form-data" action="" method="POST" autocomplete="off">
                                    <input type="hidden" name="action" value="kando-change-avatar">
                                    <input type="hidden" name="kando_avatar_nonce"
                                           value="<?php echo wp_create_nonce('kando_avatar_nonce'); ?>">
                                    <div class="new-ticket-form-errors"></div>
                                    <div class="new-ticket-form-loading"></div>
                                    <div class="my_account_info">
                                        <?php
                                        $avatar = get_user_meta(get_current_user_id(), 'avatar_url', true);
                                        if ($avatar && !empty($avatar)) {
                                            $avatar_url = '<img id="avatar" src="' . $avatar . '">';
                                        } else {
                                            $avatar_url = get_avatar(get_current_user_id(), 90);
                                        }
                                        ?>
                                        <a href="<?php echo esc_attr(home_url('dashboard')) ?>" class="myacc_gravatar"
                                           title="<?php echo $user->display_name ?>">
                                            <?php echo $avatar_url; ?></a>
                                    </div>
                                    <div class="my_account_info">
                                        <input type="file" name="kando-upload-avatar" id="kando-upload-avatar"
                                               oninput="avatar.src=window.URL.createObjectURL(this.files[0])"
                                               accept="image/gif, image/jpeg, image/png">
                                        <label for="kando-upload-avatar"
                                               class="button button-blue"><?php _e("Select image", SAMYAR_TEXT_DOMAIN); ?></label>

                                        <p style="margin-top: 15px;"><input type="submit"
                                                                            class="woocommerce-Button button button-default"
                                                                            name="save_avatar"
                                                                            value="<?php _e("Avatar update", SAMYAR_TEXT_DOMAIN); ?>">
                                        </p>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_mobile"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Change mobile", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <?php
                    if ($userController->exist_mobile() && !$userController->approved_mobile()) {
                        ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12">
                                <div class="alert alert-warning" role="alert"
                                     style="font-size: 14px;text-align: center">
                                    <?php _e("Unfortunately, you have not confirmed your mobile number, please confirm your mobile number first.", SAMYAR_TEXT_DOMAIN); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    } ?>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">


                                <p class="woocommerce-form-row form-row edit-mobile-step1">
                                    <label for="name"><?php _e("mobile number", SAMYAR_TEXT_DOMAIN); ?></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                           dir="ltr" disabled name="mobile" id="name" value="<?= $mobile ?>">
                                    <a href="" class="button button-gray kt-ajax-button samyar-verify-change-number"
                                       style="margin-top:20px"><?php _e("change number", SAMYAR_TEXT_DOMAIN); ?></a>

                                    <?php if ($userController->enable_sms() && $userController->exist_mobile() && !$userController->approved_mobile()): ?>
                                        <a href=""
                                           class="button button-green kt-ajax-button samyar-profile-verify-number"
                                           style="margin-top:20px"><?php _e("Confirmation number", SAMYAR_TEXT_DOMAIN); ?></a>
                                    <?php endif; ?>

                                </p>


                                <form class="samyar-form edit-mobile-step2" action="" method="POST" autocomplete="off"
                                      style="display:none">
                                    <input type="hidden" name="action" value="samyar_send_approve_code">
                                    <div class="samyar-form-loading"></div>
                                    <p class="woocommerce-form-row form-row">
                                        <label for="name"><?php _e("Enter your new mobile number", SAMYAR_TEXT_DOMAIN); ?></label>
                                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                               dir="ltr" name="mobile" id="mobile" value="">
                                    </p>
                                    <p><input type="submit" class="woocommerce-Button button button-default"
                                              name="save_account_details"
                                              value="<?php _e("Send verification code", SAMYAR_TEXT_DOMAIN); ?>"></p>
                                </form>
                                <form class="samyar-verify-form edit-mobile-step3" action="" method="post"
                                      style="display: none">
                                    <input type="hidden" name="action" value="samyar_process_verify_code">
                                    <input type="text" class="kt-verify-code" name="verify-code"
                                           placeholder="کد فعالسازی">
                                    <button class="button button-green kt-ajax-button samyar-verify-submit"
                                            style="margin-top:20px"
                                            name="kt_verify_submit"><?php _e("Mobile number verification", SAMYAR_TEXT_DOMAIN); ?>
                                    </button>
                                    <a href="#" class="button button-blue kt-ajax-button samyar-verify-send-again"
                                       style="margin-top:20px;width: 49%;"><?php _e("Resend", SAMYAR_TEXT_DOMAIN); ?></a>
                                    <a href="#" class="button button-gray kt-ajax-button samyar-verify-change-number"
                                       style="margin-top:20px;width: 49%;"><?php _e("change number", SAMYAR_TEXT_DOMAIN); ?></a>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_link"></i>
                    <h5 class="dashboard-posts-title"><?php _e("API key", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">
                                <form class="samyar-form create-api-key-form" action="" method="POST"
                                      autocomplete="off">
                                    <input type="hidden" name="action" value="samyar_create_api_key">
                                    <input type="hidden" name="samyar_create_api_nonce"
                                           value="<?php echo wp_create_nonce('samyar_create_api_nonce'); ?>">
                                    <div class="samyar-form-loading"></div>
                                    <p class="woocommerce-form-row form-row form-row-first">
                                        <label for="name"><?php _e("api link", SAMYAR_TEXT_DOMAIN); ?></label>
                                        <input type="text" readonly
                                               class="woocommerce-Input woocommerce-Input--text input-text" disabled
                                               dir="ltr" name="api-url" id="api-url"
                                               value="<?= get_rest_url('', 'api/v1') ?>">
                                    </p>
                                    <p class="woocommerce-form-row form-row form-row-first">
                                        <label for="name"><?php _e("Key", SAMYAR_TEXT_DOMAIN); ?></label>



                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><a class="CopyToClipBoard2" href="<?= kando_hide_api_key($user_token) ?>"><i class="fal fa-copy"></i></a></span>
                                        </div>
                                        <input type="text" class="form-control" dir="ltr" placeholder="<?php _e("Api key", SAMYAR_TEXT_DOMAIN); ?>" id="api-key" name="api-key" value="<?= kando_hide_api_key($user_token) ?>">
                                    </div>

                                    </p>

                                    <p>
                                        <input type="submit" class="woocommerce-Button button button-default"
                                               name="save_account_details"
                                               value="<?php _e("Generate New", SAMYAR_TEXT_DOMAIN); ?>">
                                    </p>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_link"></i>
                    <h5 class="dashboard-posts-title"><?php _e("IP Allowed", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">
                                <div class="alert alert-warning" role="alert"
                                     style="font-size: 14px;">
                                    <?php _e("In this section, you can add your host or server IP to prevent misuse of your API key.", SAMYAR_TEXT_DOMAIN); ?>
                                </div>

                                <form class="samyar-form update-profile-settings-form" action="" method="POST"
                                      autocomplete="off">
                                    <input type="hidden" name="action" value="save_ip_allowed">
                                    <input type="hidden" name="samyar_ip_allowed_nonce"
                                           value="<?php echo wp_create_nonce('samyar_ip_allowed_nonce'); ?>">
                                    <div class="samyar-form-loading"></div>
                                    <p class="woocommerce-form-row form-row form-row-first">
                                        <label for="ip_allowed"><?php _e("IP Allowed", SAMYAR_TEXT_DOMAIN); ?></label>
                                        <textarea
                                                dir="ltr"
                                                class="new-ticket-form-text"
                                                name="ip_allowed"
                                                placeholder="<?php _e("Enter one IP per line\nExample:\n192.168.1.1\n192.168.1.2", SAMYAR_TEXT_DOMAIN); ?>"
                                                rows="5"><?php
                                            // گرفتن لیست آی‌پی‌های مجاز
                                            $ips_allowed = get_user_meta(get_current_user_id(), 'ip_allowed', true);
                                            // اطمینان حاصل کنید که لیست آی‌پی‌ها به صورت آرایه است
                                            if (!is_array($ips_allowed)) {
                                                $ips_allowed = [];
                                            }
                                            $clean_ips = array_map('trim', $ips_allowed);
                                            // آی‌پی‌ها را به فرمت رشته با خط جدید تبدیل کنید
                                            echo implode("\n", $clean_ips);
                                            ?></textarea>

                                    </p>
                                    <p style="margin-top:10px">
                                        <input type="submit" class="woocommerce-Button button button-default"
                                               name="save_ticket_settings"
                                               value="<?php _e("Save", SAMYAR_TEXT_DOMAIN); ?>">
                                    </p>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_link"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Two-factor authentication", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">
                                <?php
                                $user_id = get_current_user_id();
                                $twofa_enabled = get_user_meta($user_id, '2fa_enabled', true);
                                $twofa_code_sent = get_user_meta($user_id, '2fa_code_sent', true);
                                $tfa_verification_code = get_user_meta($user_id, 'tfa_verification_code', true);
                                $tfa_btn = $twofa_enabled ? __('Disable', SAMYAR_TEXT_DOMAIN) : __('Enable', SAMYAR_TEXT_DOMAIN);
                                $tfa_btn_color = $twofa_enabled ? 'button-default' : 'button-green';
                                $nonce_generate = wp_create_nonce('2fa_generate_nonce');
                                $nonce_approve = wp_create_nonce('2fa_approve_nonce');

                                $method = \kandopanel\tfaController::getInstance()->getVerificationMethod($user_id);
                                ?>

                                <form class="samyar-form" id="2fa-generate-form" method="POST" autocomplete="off" style="">
                                    <input type="hidden" name="action" value="kando_2fa_generate">
                                    <input type="hidden" name="enabled" value="<?= $twofa_enabled ? '0' : '1' ?>">
                                    <?php wp_nonce_field('2fa_generate_nonce', '2fa_generate_nonce'); ?>
                                    <div class="samyar-form-loading"></div>
                                    <div class="alert alert-warning" role="alert" style="font-size: 14px;">
                                        <?php
                                            _e('Two-factor authentication adds an extra layer of protection to your account. When signing in, you’ll need to enter a verification code sent to your email or mobile number. Please make sure you have at least one of them registered.', SAMYAR_TEXT_DOMAIN);
                                         ?>

                                    </div>
                                    <p style="margin-top:10px">
                                        <input type="submit" class="woocommerce-Button button <?=$tfa_btn_color?>" name="save_ticket_settings" value="<?= $tfa_btn ?>">
                                    </p>
                                </form>

                                <form class="samyar-form" id="2fa-approve-form" method="POST" autocomplete="off" style="display: none;">
                                    <input type="hidden" name="action" value="kando_2fa_approve">
                                    <input type="hidden" name="enabled" value="<?= $twofa_enabled ? '0' : '1' ?>">
                                    <?php wp_nonce_field('2fa_approve_nonce', '2fa_approve_nonce'); ?>
                                    <div class="samyar-form-loading"></div>
                                    <div class="alert alert-warning" role="alert" style="font-size: 14px;">
                                        <?php if($method === 'email') { ?>
                                            <?php _e('Please check your email and enter the verification code.', SAMYAR_TEXT_DOMAIN); ?>
                                        <?php } elseif($method === 'sms') { ?>
                                            <?php _e('Please check your SMS messages and enter the verification code.', SAMYAR_TEXT_DOMAIN); ?>
                                        <?php } ?>
                                    </div>
                                    <label for="code"><?php _e('Code', SAMYAR_TEXT_DOMAIN); ?></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" dir="ltr" id="code" name="code" value="">
                                    <?php         $verification_method = \kandopanel\tfaController::getInstance()->getVerificationMethod($user->ID); ?>
                                    <div style="<?php if ($twofa_enabled) { ?>display: none;<?php } else { ?>display: block;<?php } ?>">
                                        <label for="code"><?php _e('Method', SAMYAR_TEXT_DOMAIN); ?></label>
                                        <select class="regular-text" id="tfa_verification_method" name="tfa_verification_method">
                                            <option value="email" <?php selected($verification_method, 'email'); ?>><?php _e('Email',SAMYAR_TEXT_DOMAIN) ?></option>
                                            <option value="sms" <?php selected($verification_method, 'sms'); ?>><?php _e('SMS',SAMYAR_TEXT_DOMAIN) ?></option>
                                        </select>
                                    </div>


                                    <p style="margin-top:10px">
                                        <input type="submit" class="woocommerce-Button button <?=$tfa_btn_color?>" name="save_ticket_settings" id="2fa-approve-form-btn" value="<?= $tfa_btn ?>">
                                        <input type="submit" class="woocommerce-Button button button-red" name="save_ticket_settings" id="resend-2fa-approve-form-btn" value="<?= __('Resend', SAMYAR_TEXT_DOMAIN) ?>">
                                    </p>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-6">
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_id"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Basic information", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">
                                <form class="samyar-form edit-profile-form" action="" method="POST" autocomplete="off">
                                    <input type="hidden" name="action" value="samyar_edit_profile">
                                    <input type="hidden" name="samyar_edit_profile_nonce"
                                           value="<?php echo wp_create_nonce('samyar_edit_profile_nonce'); ?>">
                                    <div class="samyar-form-loading"></div>
                                    <p class="woocommerce-form-row form-row form-row-one-half form-row-first">
                                        <label for="name"><?php _e("Name and lastname", SAMYAR_TEXT_DOMAIN); ?><span
                                                    class="required">*</span></label>
                                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                               name="name" id="name" value="<?php echo $user->display_name ?>">
                                    </p>


                                    <p class="woocommerce-form-row form-row form-row-one-half">
                                        <label for="account_email"><?php _e("Email address", SAMYAR_TEXT_DOMAIN); ?></label>
                                        <input type="email"
                                               class="woocommerce-Input woocommerce-Input--email input-text" dir="ltr"
                                               name="email" autocomplete="false" id="email"
                                               value="<?php echo $user->user_email ?>">
                                    </p>

                                    <p class="woocommerce-form-row form-row form-row-one-half">
                                        <?php
                                        if (!$your_domain || empty($your_domain)) {
                                            $your_domain = "";
                                        }
                                        ?>
                                        <label for="yourDomain"><?php _e("Your site address", SAMYAR_TEXT_DOMAIN); ?></label>
                                        <input type="text" class="woocommerce-Input woocommerce-Input--email input-text"
                                               dir="ltr" name="your_domain" autocomplete="false" id="your_domain"
                                               value="<?php echo $your_domain ?>">
                                    </p>

                                    <fieldset class="clearfix">
                                        <!--                                        <legend>تغییر گذرواژه</legend>-->

                                        <p class="woocommerce-form-row form-row form-row-wide form-row-one-half form-row-first">
                                            <label for="password_1"><?php _e("New password", SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="password"
                                                   class="woocommerce-Input woocommerce-Input--password input-text"
                                                   name="newPassword" id="newPassword">
                                            <span class="required"><?php _e("If you do not intend to change, leave it blank", SAMYAR_TEXT_DOMAIN); ?></span>
                                        </p>
                                        <p class="woocommerce-form-row form-row form-row-wide form-row-one-half">
                                            <label for="password_2"><?php _e("Repeat the new password", SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="password"
                                                   class="woocommerce-Input woocommerce-Input--password input-text"
                                                   name="newPasswordVerify" id="newPasswordVerify">
                                        </p>
                                    </fieldset>
                                    <div class="clear"></div>


                                    <p>
                                        <input type="submit" class="woocommerce-Button button button-default"
                                               name="save_account_details"
                                               value="<?php _e("Save changes", SAMYAR_TEXT_DOMAIN); ?>">

                                    </p>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php do_action('kando_add_profile') ?>

            <?php
            $enable_switch_language = settingsController::getInstance()->get_option('enable-switch-language', 0);
            if ($enable_switch_language == '1') {
                ?>
                <div class="dashboard-posts-box dashboard-tickets-box">
                    <div class="dashboard-posts-title-holder">
                        <i class="elegant-icon icon_globe"></i>
                        <h5 class="dashboard-posts-title"><?php _e("Language settings", SAMYAR_TEXT_DOMAIN); ?></h5>
                    </div>
                    <div class="dashboard-posts-list">
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <div class="new-api-form-outer">
                                    <?php
                                    $current_user_id = get_current_user_id();
                                    $current_language = get_user_meta($current_user_id, 'user_language', true);

                                    if (!$current_language) {
                                        $current_language = 'fa_IR';
                                    }

                                    $languages = kando_get_available_languages();
                                    ?>
                                    <form class="samyar-form update-profile-settings-form" action="" method="POST"
                                          autocomplete="off">
                                        <input type="hidden" name="action" value="kando_change_language">
                                        <?php wp_nonce_field('change_language_nonce', 'change_language_nonce'); ?>
                                        <div class="samyar-form-loading"></div>
                                        <select class="regular-text" id="language" name="language">
                                            <?php foreach ($languages as $lang_code => $lang_name) :
                                                $selected = ($lang_code == $current_language) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo esc_attr($lang_code) ?>" <?= $selected ?>><?php echo esc_html($lang_name); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p style="margin-top:10px">
                                            <input type="submit" class="woocommerce-Button button button-default"
                                                   name="save_ticket_settings"
                                                   value="<?php _e("Save", SAMYAR_TEXT_DOMAIN); ?>">
                                        </p>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            $enable_switch_currency = settingsController::getInstance()->get_option('enable-switch-currency', 0);
            if ($enable_switch_currency == "1") {
                ?>
                <div class="dashboard-posts-box dashboard-tickets-box">
                    <div class="dashboard-posts-title-holder">
                        <i class="elegant-icon icon_globe"></i>
                        <h5 class="dashboard-posts-title"><?php _e("Currency settings", SAMYAR_TEXT_DOMAIN); ?></h5>
                    </div>
                    <div class="dashboard-posts-list">
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <div class="new-api-form-outer">
                                    <?php
                                    $selected_currency = currencyController::getInstance()->getUserCurrency();
                                    $currencies = currencyController::getInstance()->get_all_currencies();

                                    $selected_currency_symbol = currencyController::getInstance()->getUserCurrency();

                                    ?>
                                    <form class="samyar-form update-profile-settings-form" action="" method="POST"
                                          autocomplete="off">
                                        <input type="hidden" name="action" value="save_user_currency">
                                        <?php wp_nonce_field('save_user_currency_nonce', 'save_user_currency_nonce'); ?>
                                        <div class="samyar-form-loading"></div>
                                        <select class="regular-text" id="currency" name="currency">
                                            <?php foreach ($currencies as $key => $value) :
                                                $selected = ($key == $selected_currency) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo esc_attr($value['currency_code']) ?>" <?php selected($selected_currency, $key); ?> <?= $selected ?>><?php echo $value['symbol']; ?>
                                                    (<?php echo $value['currency_code']; ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p style="margin-top:10px">
                                            <input type="submit" class="woocommerce-Button button button-default"
                                                   name="save_ticket_settings"
                                                   value="<?php _e("Save", SAMYAR_TEXT_DOMAIN); ?>">
                                        </p>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php if (samyar_is_admin()) {
                $ticket_signature = get_user_meta($user->ID, 'ticket_signature', true);
                ?>
                <div class="dashboard-posts-box dashboard-tickets-box">
                    <div class="dashboard-posts-title-holder">
                        <i class="elegant-icon icon_lifesaver"></i>
                        <h5 class="dashboard-posts-title"><?php _e("Ticket settings", SAMYAR_TEXT_DOMAIN); ?></h5>
                    </div>
                    <div class="dashboard-posts-list">
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <div class="new-api-form-outer">
                                    <form class="samyar-form update-profile-settings-form" action="" method="POST"
                                          autocomplete="off">
                                        <input type="hidden" name="action" value="samyar_update_ticket_settings">
                                        <input type="hidden" name="samyar_update_ticket_settings_nonce"
                                               value="<?php echo wp_create_nonce('samyar_update_ticket_settings_nonce'); ?>">
                                        <div class="samyar-form-loading"></div>
                                        <p class="woocommerce-form-row form-row form-row-first">
                                            <label for="ticket-signature"><?php _e("Ticket signature (it will be displayed under each of your answers)", SAMYAR_TEXT_DOMAIN); ?></label>
                                            <?php
                                            wp_editor($ticket_signature, 'ticket-signature');
                                            ?>
                                        </p>

                                        <p style="margin-top:10px">
                                            <input type="submit" class="woocommerce-Button button button-default"
                                                   name="save_ticket_settings"
                                                   value="<?php _e("Save", SAMYAR_TEXT_DOMAIN); ?>">
                                        </p>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_link"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Credit threshold", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <div class="new-api-form-outer">
                                <div class="alert alert-warning" role="alert"
                                     style="font-size: 14px;">
                                    <?php _e("In this section, you can set the credit threshold for receiving SMS messages. For example, if you enter 50, if your credit drops below $50, you will be sent an SMS message stating that your credit is low.", SAMYAR_TEXT_DOMAIN); ?>
                                </div>

                                <form class="samyar-form update-profile-settings-form" action="" method="POST"
                                      autocomplete="off">
                                    <input type="hidden" name="action" value="save_credit_threshold">
                                    <input type="hidden" name="samyar_credit_threshold_nonce"
                                           value="<?php echo wp_create_nonce('samyar_credit_threshold'); ?>">
                                    <div class="samyar-form-loading"></div>
                                    <p class="woocommerce-form-row form-row form-row-first">
                                        <?php
                                        $credit_threshold = get_user_meta(get_current_user_id(), 'credit_threshold', true);
                                        if (empty($credit_threshold)) {
                                            $credit_threshold = 0;
                                        }
                                        ?>
                                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                               dir="ltr" name="credit_threshold" id="name"
                                               value="<?= $credit_threshold ?>">

                                    </p>
                                    <p style="margin-top:10px">
                                        <input type="submit" class="woocommerce-Button button button-default"
                                               name="save_ticket_settings"
                                               value="<?php _e("Save", SAMYAR_TEXT_DOMAIN); ?>">
                                    </p>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php endif; ?>