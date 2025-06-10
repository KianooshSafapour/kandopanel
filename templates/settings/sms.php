<?php
defined('ABSPATH') || exit('No Access!');

$sms_provider = kando_get_option('sms-provider');
?>
<style>
    .smsir, .melipayamak, .farazsms, .hide-info, .hide-info-api {
        display: none;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        // Function to show/hide items based on selected value
        function showSelectedPattern(selectedValue) {
            if (selectedValue === 'farazsms') {
                $('.farazsms').show();
                $('.melipayamak, .smsir').hide();

                $('.hide-info').show();
                $('.hide-info-api').hide();

            } else if (selectedValue === 'melipayamak') {
                $('.melipayamak').show();
                $('.farazsms, .smsir').hide();

                $('.hide-info').show();
                $('.hide-info-api').hide();
            } else if (selectedValue === 'sms.ir') {
                $('.smsir').show();
                $('.farazsms, .melipayamak').hide();

                $('.hide-info').hide();
                $('.hide-info-api').show();
            } else {
                // If no option is selected, hide all items
                $('.farazsms, .melipayamak, .smsir').hide();
            }
        }

        // When the page loads
        $(window).on('load', function() {
            // Show/hide items based on the initial selection
            var initialSelectedValue = $('select[name="sms-provider"]').val();
            showSelectedPattern(initialSelectedValue);

            // When the select changes
            $('select[name="sms-provider"]').change(function() {
                // Get the selected value
                var selectedValue = $(this).val();
                // Call the function to show/hide items based on the selected value
                showSelectedPattern(selectedValue);
            });
        });
    });
</script>
<div class="samyar-settings-area samyar-settings-sms">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="phone"></span></span>
        <strong><?php _e('SMS', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b><?php _e('Watch the instructional video for Kandopanel SMS settings:', SAMYAR_TEXT_DOMAIN); ?></b><br><br>
                <a href="https://www.aparat.com/v/Rx4nF" target="_blank"><?php _e('Kandopanel SMS Settings Instructional Video', SAMYAR_TEXT_DOMAIN); ?></a>
                <br>
            </p>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Enable SMS Service', SAMYAR_TEXT_DOMAIN); ?></label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-sms" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-sms" value="1" <?php echo checked(kando_get_option('enable-sms', 1), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
        </div>

    </div>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e('FarazSMS Gateway Settings', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('SMS Templates', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Additional Settings', SAMYAR_TEXT_DOMAIN); ?></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('SMS Provider', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="sms-provider">
                            <option value=""><?php _e('Please select an item.', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="farazsms" <?php selected($sms_provider, 'farazsms'); ?>><?php _e('FarazSMS', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="melipayamak" <?php selected($sms_provider, 'melipayamak'); ?>><?php _e('Melipayamak', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="sms.ir" <?php selected($sms_provider, 'sms.ir'); ?>><?php _e('SMS.ir', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>

                    <div class="samyar-description farazsms">
                        <span uk-icon="info"></span>
                        <a href="https://farazsms.com/?ref=42" style="color: #F56640 !important;position: relative;top: -7px;" target="_blank"><?php _e('You can register on FarazSMS using this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                    </div>

                    <div class="samyar-description melipayamak">
                        <span uk-icon="info"></span>
                        <a href="https://www.melipayamak.com/" style="color: #F56640 !important;position: relative;top: -7px;" target="_blank"><?php _e('You can register on Melipayamak using this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                    </div>

                    <div class="samyar-description smsir">
                        <span uk-icon="info"></span>
                        <a href="https://app.sms.ir/auth/sign-up?ref=P0HAD" style="color: #F56640 !important;position: relative;top: -7px;" target="_blank"><?php _e('You can register on SMS.ir using this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                    </div>

                </div>

                <div class="uk-margin hide-info">
                    <label class="uk-form-label" for="samyar-sms-username"><?php _e('SMS Username', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-username" name="sms-username" value="<?php echo esc_attr(kando_get_option('sms-username')); ?>">
                </div>
                <div class="uk-margin hide-info">
                    <label class="uk-form-label" for="samyar-sms-password"><?php _e('SMS Password', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="password" class="uk-input" id="samyar-sms-password" name="sms-password" value="<?php echo esc_attr(kando_get_option('sms-password')); ?>">
                </div>

                <div class="uk-margin hide-info-api">
                    <label class="uk-form-label" for="samyar-sms-apikey"><?php _e('SMS API Key', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-apikey" name="sms-apikey" value="<?php echo esc_attr(kando_get_option('sms-apikey')); ?>">
                </div>


                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-sender"><?php _e('SMS Sender', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-sender" name="sms-sender" value="<?php echo esc_attr(kando_get_option('sms-sender')); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-phonebook-id"><?php _e('SMS Phonebook ID', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-phonebook-id" name="sms-phonebook-id" value="<?php echo esc_attr(kando_get_option('sms-phonebook-id')); ?>">
                </div>
                <div class="uk-margin">
                    <div class="uk-alert-danger" uk-alert>
                        <p style="margin-top: 0">
                            <b><?php _e('Last error received from the SMS panel:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <br>
                            <?php
                            $faraz_sms_error = get_option('faraz_sms_error');
                            if (!$faraz_sms_error) {
                                echo __('No errors have occurred yet.', SAMYAR_TEXT_DOMAIN);
                            } else {
                                echo $faraz_sms_error;
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </li>
        <li>

            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-verification-pattern"><?php _e('SMS Verification Pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your verification code: %verification-code%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your verification code: {0}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your verification code: #verification-code#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-verification-pattern" name="sms-verification-pattern" value="<?php echo esc_attr(kando_get_option('sms-verification-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-verification-pattern"><?php _e('SMS New Password Pattern', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your new password: %new-password%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('After logging in, you can change your password in the profile edit section.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your new password: {0}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('After logging in, you can change your password in the profile edit section.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your new password: #new-password#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('After logging in, you can change your password in the profile edit section.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>

                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-sendNewPass-pattern" name="sms-sendNewPass-pattern" value="<?php echo esc_attr(kando_get_option('sms-sendNewPass-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-new-registration-pattern"><?php _e('Send SMS to admin after new user registration', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('A new user with the name %fullname% and phone number %mobile-number% has registered on your site.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('A new user with the name {0} and phone number {1} has registered on your site.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('A new user with the name #fullname# and phone number #mobile-number# has registered on your site.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-new-registration-pattern" name="sms-new-registration-pattern" value="<?php echo esc_attr(kando_get_option('sms-new-registration-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-user-pass-pattern"><?php _e('Send username and password to guest user', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Dear user, your login information for the site:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Username: %username%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Password: %password%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Dear user, your login information for the site:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Username: {0}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Password: {1}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Dear user, your login information for the site:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Username: #username#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Password: #password#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-user-pass-pattern" name="sms-user-pass-pattern" value="<?php echo esc_attr(kando_get_option('sms-user-pass-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-welcome-pattern"><?php _e('Send welcome SMS to user', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('%fullname% dear, welcome to our site', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('{0} dear, welcome to our site', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('#fullname# dear, welcome to our site', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-welcome-pattern" name="sms-welcome-pattern" value="<?php echo esc_attr(kando_get_option('sms-welcome-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-pattern"><?php _e('Send SMS to admin after order', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new order has been placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: %order-id%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Service: %service-name%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Quantity: %quantity%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Amount: %amount%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new order has been placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: {0}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Service: {1}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Quantity: {2}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Amount: {3}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new order has been placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: #order-id#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Service: #service-name#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Quantity: #quantity#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Amount: #amount#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-order-to-admin-pattern" name="send-order-to-admin-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-order-to-admin-pattern')); ?>">
                    <div class="uk-margin">
                        <label class="uk-form-label"><?php _e('Send SMS to admin if order is sent via API', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                        <div class="uk-margin-small">
                            <label>
                                <input class="uk-checkbox" type="checkbox" name="send-order-to-admin-by-api-pattern"
                                       value="1" <?php echo checked(kando_get_option('send-order-to-admin-by-api-pattern'), 1); ?>>
                                <?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?>
                            </label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-for-custom-pattern"><?php _e('Send SMS to admin when a user places a manual order', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new manual order has been placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: %order-id%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Service: %service-name%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Quantity: %quantity%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Amount: %amount%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new manual order has been placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: {0}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Service: {1}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Quantity: {2}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Amount: {3}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new manual order has been placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: #order-id#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Service: #service-name#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Quantity: #quantity#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Amount: #amount#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-order-to-admin-for-custom-pattern" name="send-order-to-admin-for-custom-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-order-to-admin-for-custom-pattern')); ?>">
                </div>

                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-add-credit-pattern"><?php _e('Send SMS to admin when a user recharges their wallet', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A user with the name %fullname% has recharged their wallet with %amount%', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A user with the name {0} has recharged their wallet with {1}', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A user with the name #fullname# has recharged their wallet with #amount#', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-add-credit-pattern" name="sms-add-credit-pattern" value="<?php echo esc_attr(kando_get_option('sms-add-credit-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-pattern"><?php _e('Send SMS to user after order', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your order has been successfully placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: %order-id%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your order has been successfully placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: {0}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your order has been successfully placed:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Order ID: #order-id#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-order-to-user-pattern" name="send-order-to-user-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-order-to-user-pattern')); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-new-status-pattern"><?php _e('Send SMS for order status change', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('The status of your order for the service %service-name% with the quantity %number% has changed to %newstatus%.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('The status of your order for the service {0} with the quantity {1} has changed to {2}.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('The status of your order for the service #service-name# with the quantity #number# has changed to #newstatus#.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-new-status-pattern" name="sms-new-status-pattern" value="<?php echo esc_attr(kando_get_option('sms-new-status-pattern')); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-credit-not-enough-pattern"><?php _e('Send SMS for insufficient credit to API user', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Insufficient credit to place an order for the amount %order-price%', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your current balance: %balance%', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Insufficient credit to place an order for the amount {0}', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your current balance: {1}', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Insufficient credit to place an order for the amount #order-price#', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your current balance: #balance#', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-credit-not-enough-pattern" name="sms-credit-not-enough-pattern" value="<?php echo esc_attr(kando_get_option('sms-credit-not-enough-pattern')); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-newticket-to-admin-pattern"><?php _e('Send SMS to admin for new ticket', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new ticket with ID %ticket-id% has been created for you.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new ticket with ID {0} has been created for you.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new ticket with ID #ticket-id# has been created for you.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-new-ticket-to-admin-pattern" name="send-new-ticket-to-admin-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-new-ticket-to-admin-pattern')); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-newticket-to-user-pattern"><?php _e('Send SMS to user for new ticket', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new ticket with ID %ticket-id% has been created for you by the admin.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new ticket with ID {0} has been created for you by the admin.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new ticket with ID #ticket-id# has been created for you by the admin.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-new-ticket-to-user-pattern" name="send-new-ticket-to-user-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-new-ticket-to-user-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-new-answer-to-admin-pattern"><?php _e('Send SMS to admin for new answer', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new answer has been sent for the ticket with ID %ticket-id%.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new answer has been sent for the ticket with ID {0}.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new answer has been sent for the ticket with ID #ticket-id#.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-new-answer-to-admin-pattern" name="send-new-answer-to-admin-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-new-answer-to-admin-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-new-answer-to-admin-pattern"><?php _e('Send SMS to user for new answer', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new answer has been sent for the ticket with ID %ticket-id%.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new answer has been sent for the ticket with ID {0}.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello dear user', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('A new answer has been sent for the ticket with ID #ticket-id#.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="<?php _e('Enter pattern code here', SAMYAR_TEXT_DOMAIN); ?>" id="samyar-send-new-answer-to-user-pattern" name="send-new-answer-to-user-pattern"
                           value="<?php echo esc_attr(kando_get_option('send-new-answer-to-user-pattern')); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-credit-threshold-pattern"><?php _e('Send SMS to user when credit reaches the threshold specified in their profile', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Dear user, your credit on the site has fallen below %credit_threshold%. To recharge your credit, please use the link below:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Current credit: %balance%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('%credit_link%', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Dear user, your credit on the site has fallen below {0}. To recharge your credit, please use the link below:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Current credit: {1}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('{2}', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Dear user, your credit on the site has fallen below #credit_threshold#. To recharge your credit, please use the link below:', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Current credit: #balance#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('#credit_link#', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-credit-threshold-pattern" name="sms-credit-threshold-pattern" value="<?php echo esc_attr(kando_get_option('sms-credit-threshold-pattern')); ?>">
                </div>

                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-provider-credit-not-enough-pattern"><?php _e('Send SMS to Admin for insufficient credit in provider', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your credit with the provider named %provider-name%, ID %provider-id% is insufficient to place an order. Please increase this provider credit.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your credit with the provider named {0}, ID {1} is insufficient to place an order. Please increase this provider credit.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site URL', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b><?php _e('Sample Pattern:', SAMYAR_TEXT_DOMAIN); ?></b><br>
                            <?php _e('Hello admin', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your credit with the provider named #rovider-name#, ID #provider-id# is insufficient to place an order. Please increase this provider credit.', SAMYAR_TEXT_DOMAIN); ?><br>
                            <?php _e('Your site name', SAMYAR_TEXT_DOMAIN); ?><br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-provider-credit-not-enough-pattern" name="sms-provider-credit-not-enough-pattern" value="<?php echo esc_attr(kando_get_option('sms-provider-credit-not-enough-pattern')); ?>">
                </div>


            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Enable checking Afghanistan phone numbers instead of Iran (only for Afghan users)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="check-afghanistan-mobile" value="0">
                            <input class="uk-checkbox" type="checkbox" name="check-afghanistan-mobile" value="1" <?php echo checked(kando_get_option('check-afghanistan-mobile', 0), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>
            </div>
        </li>
    </ul>
</div>