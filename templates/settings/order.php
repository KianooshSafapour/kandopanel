<?php
defined('ABSPATH') || exit('No Access!');
$dashboard_image = kando_get_option('dashboard-image', SAMYAR_DIR_IMG . '/dashboard-welcome.png');
if (isset($dashboard_image) && !empty($dashboard_image) && is_numeric($dashboard_image)) {
    $dashboard_image = wp_get_attachment_url($dashboard_image);
}
?>
<div class="samyar-settings-area samyar-settings-order">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong><?php _e("Order", SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p><?php _e("If you enable this option, users must first charge their wallet before submitting an order.", SAMYAR_TEXT_DOMAIN); ?></p>
            <p><b><?php _e("Note: This only applies to logged-in users.", SAMYAR_TEXT_DOMAIN); ?></b></p>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable wallet charge before submitting an order", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-wallet-charge" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-wallet-charge"
                           value="1" <?php echo checked(kando_get_option('enable-wallet-charge', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                </label>
            </div>

        </div>
        <hr>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable order confirmation", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-agree-order" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-agree-order"
                           value="1" <?php echo checked(kando_get_option('enable-agree-order', 1), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                </label>
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label"
                   for="samyar-agree-order-text"><?php _e("Order confirmation text", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-agree-order-text" name="samyar-agree-order-text"
                   value="<?php echo esc_attr(kando_get_option('samyar-agree-order-text', __("I have read and agree to the [term].", SAMYAR_TEXT_DOMAIN))); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"
                   for="samyar-agree-order-link"><?php _e("Link to terms and conditions for order confirmation", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-agree-order-link" name="samyar-agree-order-link"
                   value="<?php echo esc_attr(kando_get_option('samyar-agree-order-link', "")); ?>">
        </div>
        <hr>
        <div class="uk-alert-primary" uk-alert>
            <p><?php _e("For this section to work properly, you need to enter the session ID of an Instagram account (we recommend creating a new account specifically for this purpose) in the settings below.", SAMYAR_TEXT_DOMAIN); ?></p>
            <p><?php _e("To do this, go to the Instagram website in the Chrome browser, log in to your account, and then follow the instructions in the image below to find your session ID and enter it in the section below.", SAMYAR_TEXT_DOMAIN); ?></p>
            <p><a href="<?= SAMYAR_DIR_IMG ?>/document/link-proccess.gif"
                  target="_blank"><?php _e("Guide image", SAMYAR_TEXT_DOMAIN); ?></a></p>
        </div>
        <!--
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable link check button in order submission", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-process-link" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-process-link" value="1" <?php echo checked(kando_get_option('enable-process-link', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="process-link-sessionid"><?php _e("Session ID (sessionid)", SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="text" class="uk-input" id="process-link-sessionid" name="process-link-sessionid"
                       value="<?php echo esc_attr(kando_get_option('process-link-sessionid', "")); ?>">
            </div>
            <label class="uk-form-label"><?php _e("Enable saving Instagram information when submitting an order via link (follower and following count for profiles, and like, view, comment count for posts)", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="save-link-info" value="0">
                    <input class="uk-checkbox" type="checkbox" name="save-link-info" value="1" <?php echo checked(kando_get_option('save-link-info', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>
        </div>
        -->
        <hr>
        <div class="uk-alert-primary" uk-alert>
            <p><?php _e("If you select 10 minutes in the settings, the user will have 10 minutes to cancel their order, otherwise it will be sent to the provider.", SAMYAR_TEXT_DOMAIN); ?></p>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable delay for sending orders to providers", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="delay-sending-order" value="0">
                    <input class="uk-checkbox" type="checkbox" name="delay-sending-order"
                           value="1" <?php echo checked(kando_get_option('delay-sending-order', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                </label>
            </div>

            <?php
            $delay_time_order = (int)kando_get_option('delay-time-order', 10);

            ?>
            <div class="uk-margin">
                <label class="uk-form-label"><?php _e("Select delay time", SAMYAR_TEXT_DOMAIN); ?></label>
                <div uk-form-custom="target: > * > span:first-child">
                    <select name="delay-time-order">
                        <option <?php if ($delay_time_order === 5): ?> selected <?php endif; ?>
                                value="5"><?php _e("5 minutes", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option <?php if ($delay_time_order === 10): ?> selected <?php endif; ?>
                                value="10"><?php _e("10 minutes", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option <?php if ($delay_time_order === 15): ?> selected <?php endif; ?>
                                value="15"><?php _e("15 minutes", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option <?php if ($delay_time_order === 20): ?> selected <?php endif; ?>
                                value="20"><?php _e("20 minutes", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option <?php if ($delay_time_order === 30): ?> selected <?php endif; ?>
                                value="30"><?php _e("30 minutes", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>
            </div>


        </div>
        <hr>
        <div class="uk-margin">


            <?php
            $order_style = (int)kando_get_option('order-style', 2);

            ?>
            <div class="uk-margin">
                <label class="uk-form-label"><?php _e("Order display template", SAMYAR_TEXT_DOMAIN); ?><span
                            class="new-option">(<?php _e("New", SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                <div uk-form-custom="target: > * > span:first-child">
                    <select name="order-style">
                        <option <?php if ($order_style === 1): ?> selected <?php endif; ?>
                                value="1"><?php _e("Style 1", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option <?php if ($order_style === 2): ?> selected <?php endif; ?>
                                value="2"><?php _e("Style 2", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>
            </div>


        </div>
        <hr>

        <div class="uk-margin">

            <div class="uk-alert-primary" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php _e("From this section, you can set the starting order ID.", SAMYAR_TEXT_DOMAIN); ?></p>
                <p><?php _e("For example, you might want your order IDs to start from 10000. You can set it here.", SAMYAR_TEXT_DOMAIN); ?></p>
                <p><?php _e("Just enter the starting number and click Apply.", SAMYAR_TEXT_DOMAIN); ?></p>
            </div>


            <div class="uk-child-width-1-2 uk-text-center" uk-grid>
                <div>

                    <input type="text" class="uk-input" id="samyar-start-order-id"
                           placeholder="<?php _e("Enter the starting number", SAMYAR_TEXT_DOMAIN); ?>" value="">

                </div>
                <div>
                    <div class="uk-child-width-1-2 uk-text-center" uk-grid>
                        <div>
                            <button class="uk-button uk-button-default" type="button"
                                    id="kando-set-start-order-id"><?php _e("Apply", SAMYAR_TEXT_DOMAIN); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="uk-margin">
                <label class="uk-form-label"><?php _e("Enable bulk order submission", SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-send-order-mass" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-send-order-mass"
                               value="1" <?php echo checked(kando_get_option('enable-send-order-mass', 1), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                    </label>
                </div>

            </div>

            <div class="uk-margin">
                <label class="uk-form-label"><?php _e("Enable admin notes in order submission form", SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-note-for-admin" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-note-for-admin"
                               value="1" <?php echo checked(kando_get_option('enable-note-for-admin', 1), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                    </label>
                </div>

            </div>

            <div class="uk-margin">
                <label class="uk-form-label"><?php _e("Enable brand display in order submission form", SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-show-brands" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-show-brands"
                               value="1" <?php echo checked(kando_get_option('enable-show-brands', 1), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                    </label>
                </div>

            </div>

            <div class="uk-margin">
                <label class="uk-form-label"><?php _e("Only display logos in the brand list (hide titles)", SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-only-logo-brand" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-only-logo-brand" value="1" <?php echo checked( kando_get_option( 'enable-only-logo-brand',0), 1 ); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
                </div>

            </div>

            <div class="uk-margin">
                <div class="uk-alert-primary" uk-alert>
                    <p><?php _e("If this option is enabled, if a user orders a service like likes for their profile link, they cannot use the same service for the same profile link again until the order is completed.", SAMYAR_TEXT_DOMAIN); ?></p>
                </div>
                <label class="uk-form-label"><?php _e("Enable prevention of duplicate orders for the same link", SAMYAR_TEXT_DOMAIN); ?></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-sending-duplicate-order" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-sending-duplicate-order"
                               value="1" <?php echo checked(kando_get_option('enable-sending-duplicate-order', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                    </label>
                </div>

            </div>
            <hr>
            <div class="uk-margin">

                <div class="uk-alert-primary" uk-alert>
                    <?php _e("In this section, you can specify that if the quantity or amount of the order exceeds a certain value, it will not be sent to the API and will wait for your action.", SAMYAR_TEXT_DOMAIN); ?>
                    <p><?php _e("To disable, leave it blank and save.", SAMYAR_TEXT_DOMAIN); ?></p>
                </div>


                <div class="uk-margin">
                    <label class="uk-form-label"
                           for="numbers-awaiting-action"><?php _e("Maximum order quantity for sending to API (leave blank to disable)", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" step="100" class="uk-input" id="numbers-awaiting-action"
                           name="numbers-awaiting-action"
                           value="<?php echo esc_attr(kando_get_option('numbers-awaiting-action', "")); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label"
                           for="price-awaiting-action"><?php _e("Maximum order amount for sending to API (leave blank to disable)", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" step="100" class="uk-input" id="price-awaiting-action"
                           name="price-awaiting-action"
                           value="<?php echo esc_attr(kando_get_option('price-awaiting-action', "")); ?>">
                </div>
                <hr>
            </div>
            <hr>
            <div class="uk-margin">

                <div class="uk-alert-primary" uk-alert>
                    <?php _e("In this section, you can enable that users must charge their account to a certain amount before submitting a free order.", SAMYAR_TEXT_DOMAIN); ?>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e("Enable charge before submitting a free order", SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="charge-before-free-order" value="0">
                            <input class="uk-checkbox" type="checkbox" name="charge-before-free-order"
                                   value="1" <?php echo checked(kando_get_option('charge-before-free-order', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>

                <div class="uk-margin">
                    <label class="uk-form-label"
                           for="numbers-awaiting-action"><?php _e("Enter the amount in this section", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" step="100" class="uk-input" id="charge-before-free-order-price"
                           name="charge-before-free-order-price"
                           value="<?php echo esc_attr(kando_get_option('charge-before-free-order-price', "")); ?>">
                </div>
                <hr>
            </div>
            <hr>
            <div class="uk-margin">

                <div class="uk-alert-primary" uk-alert>
                    <?php _e("In this section, you can specify a gift amount for users.", SAMYAR_TEXT_DOMAIN); ?>
                    <p><?php _e("Example: If a user requests 1000 followers and you specify 20% here, 1200 followers will be sent to the API.", SAMYAR_TEXT_DOMAIN); ?></p>
                    <p><?php _e("Note: This does not apply to certain service types (custom_comments, mentions_custom_list, mentions, package) because it may cause issues.", SAMYAR_TEXT_DOMAIN); ?></p>
                </div>


                <div class="uk-margin">
                    <label class="uk-form-label"
                           for="gift-percent-quantity"><?php _e("Enter the desired gift percentage (numbers only)", SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" min="0" max="100" class="uk-input" id="gift-percent-quantity"
                           name="gift-percent-quantity"
                           value="<?php echo esc_attr(kando_get_option('gift-percent-quantity', "")); ?>">
                </div>
                <hr>
            </div>
            <hr>
            <div class="uk-alert-primary" uk-alert>
                <?php _e("This time is for limiting refill submissions.", SAMYAR_TEXT_DOMAIN); ?>
                <p><?php _e("If you set it to 1 month, the user will be able to refill within 30 days after submitting the order.", SAMYAR_TEXT_DOMAIN); ?></p>
            </div>
            <div class="uk-margin">

                <?php
                $refill_period = (int)kando_get_option('refill-period', 30);
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e("Refill time limit", SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="refill-period">
                            <option <?php if ($refill_period === 30): ?> selected <?php endif; ?>
                                    value="30"><?php _e("1 month", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($refill_period === 60): ?> selected <?php endif; ?>
                                    value="60"><?php _e("2 months", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($refill_period === 90): ?> selected <?php endif; ?>
                                    value="90"><?php _e("3 months", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($refill_period === 180): ?> selected <?php endif; ?>
                                    value="180"><?php _e("6 months", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($refill_period === 360): ?> selected <?php endif; ?>
                                    value="360"><?php _e("12 months", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>

                <div class="uk-margin">
                    <div class="uk-alert-primary" uk-alert>
                        <?php _e("In this section, you can activate the automatic resend order refill.If enabled, based on the number of days you select below, the system will check the orders and automatically resend any order that is eligible for a refill.", SAMYAR_TEXT_DOMAIN); ?>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label"><?php _e("Enable auto send refill", SAMYAR_TEXT_DOMAIN); ?></label>
                        <div class="uk-margin-small">
                            <label>
                                <input class="uk-checkbox" type="hidden" name="enable-auto-send-refill" value="0">
                                <input class="uk-checkbox" type="checkbox" name="enable-auto-send-refill"
                                       value="1" <?php echo checked(kando_get_option('enable-auto-send-refill', 0), 1); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?>
                            </label>
                        </div>

                    </div>
                </div>

                <?php
                $checked_for_days = (int)kando_get_option('checked-for-days', 30);
                ?>

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e("How many days back should the orders be checked?", SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="checked-for-days">
                            <option <?php if ($checked_for_days === 30): ?> selected <?php endif; ?>
                                    value="30"><?php _e("30 days", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($checked_for_days === 60): ?> selected <?php endif; ?>
                                    value="60"><?php _e("60 days", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($checked_for_days === 90): ?> selected <?php endif; ?>
                                    value="90"><?php _e("90 days", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Enabling order cancellation for the user', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="enable-cancel-order" value="0">
                            <input class="uk-checkbox" type="checkbox" name="enable-cancel-order" value="1" <?php echo checked(kando_get_option('enable-cancel-order', 1), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>