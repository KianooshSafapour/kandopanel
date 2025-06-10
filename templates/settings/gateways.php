<?php
defined('ABSPATH') || exit('No Access!');
$custom_gateway = kando_get_option('zaringate-gateways', "RND");
$default_gateway = kando_get_option('default-gateway', "zarinpal");
$gateway_style = kando_get_option('gateway-style', "2");
?>
<div class="samyar-settings-area samyar-settings-gateways">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="credit-card"></span></span>
        <strong><?php _e('GATEWAYS', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e('General Settings', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Cart-to-Cart', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Zarinpal', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Zibal', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Bitpay', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Nextpay', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Mrpardakht', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Vandar', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Mellat', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <?php do_action('kando_settings_gateway_title'); ?>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <label class="uk-form-label"><?php _e('Gateway list Style', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
                <div uk-form-custom="target: > * > span:first-child">
                    <select name="gateway-style">
                        <option value=""><?php _e('Please select Gateway list Style.', SAMYAR_TEXT_DOMAIN); ?></option>

                            <option value="1" <?php selected($gateway_style, 1); ?>><?php _e('Style 1', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="2" <?php selected($gateway_style, 2); ?>><?php _e('Style 2', SAMYAR_TEXT_DOMAIN); ?></option>

                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>
            </div>

            <?php
            $gateway_array = array('zarinpal','zibal', 'bitpay', 'nextpay', 'mrpardakht', 'vandar', 'mellat');
            $gateway_array = apply_filters('kando_gateways_list', $gateway_array);
            ?>
            <div class="uk-margin">
                <label class="uk-form-label"><?php _e('Default Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                <div uk-form-custom="target: > * > span:first-child">
                    <select name="default-gateway">
                        <option value=""><?php _e('Please select default gateway.', SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php foreach ($gateway_array as $gateway) { ?>
                            <option value="<?= $gateway; ?>" <?php selected($default_gateway, $gateway); ?>><?php _e($gateway . ' Gateway', SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php } ?>
                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Minimum Charge Amount (', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?>)</label>
                    <input type="number" class="uk-input" name="min-charge-credit" min="100" value="<?php echo esc_attr(kando_get_option('min-charge-credit', 1000)); ?>"
                           placeholder="<?php _e('Minimum Charge', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Maximum Charge Amount (', SAMYAR_TEXT_DOMAIN); ?><?php kando_get_currency_base_text(true); ?>)</label>
                    <input type="number" class="uk-input" name="max-charge-credit" value="<?php echo esc_attr(kando_get_option('max-charge-credit', 1000000)); ?>"
                           placeholder="<?php _e('Maximum Charge', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <hr>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Minimum Charge Amount (USD)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" class="uk-input" name="usd-min-charge-credit" min="0" value="<?php echo esc_attr(kando_get_option('usd-min-charge-credit', 1)); ?>"
                           placeholder="<?php _e('Minimum Charge', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Maximum Charge Amount (USD)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" class="uk-input" name="usd-max-charge-credit" min="0" value="<?php echo esc_attr(kando_get_option('usd-max-charge-credit', 1000)); ?>"
                           placeholder="<?php _e('Maximum Charge', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <hr>
                <div class="uk-margin-small">
                    <div class="uk-alert-primary" uk-alert>
                        <?php _e('In this section, you can specify the tax percentage. This percentage will be added to the amounts and then sent to the gateway.', SAMYAR_TEXT_DOMAIN); ?>
                    </div>
                    <label class="uk-form-label"><?php _e('Tax Percentage', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" class="uk-input" name="tax-percent" min="0" max="100" value="<?php echo esc_attr(kando_get_option('tax-percent', 0)); ?>"
                           placeholder="<?php _e('Tax Percentage', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Cart-to-Cart', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="cart-to-cart-active"
                                   value="1" <?php echo checked(kando_get_option('cart-to-cart-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Bank Name', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="card-bank" value="<?php echo esc_attr(kando_get_option('card-bank', '')); ?>"
                           placeholder="<?php _e('Bank Name', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Card Owner Name', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="card-name" value="<?php echo esc_attr(kando_get_option('card-name', '')); ?>"
                           placeholder="<?php _e('Card Owner Name', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Card Number', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="card-number" value="<?php echo esc_attr(kando_get_option('card-number', '')); ?>"
                           placeholder="<?php _e('Card Number', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Account Number', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="card-account-number" value="<?php echo esc_attr(kando_get_option('card-account-number', '')); ?>"
                           placeholder="<?php _e('Account Number', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label"><?php _e('Shaba Number', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="card-shaba-number" value="<?php echo esc_attr(kando_get_option('card-shaba-number', '')); ?>"
                           placeholder="<?php _e('Shaba Number', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Zarinpal Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zarinpal-active"
                                   value="1" <?php echo checked(kando_get_option('zarinpal-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Zarinpal Sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zarinpal-sandbox"
                                   value="1" <?php echo checked(kando_get_option('zarinpal-sandbox'), 1); ?>>
                            <?php _e('Active Sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="zarinpal-merchant" value="<?php echo esc_attr(kando_get_option('zarinpal-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://www.zarinpal.com" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Use Zaringate', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="use-zaringate"
                                   value="1" <?php echo checked(kando_get_option('use-zaringate', $options->samyar_default('use-zaringate')), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Select Custom Gateway (if use Zaringate)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="zaringate-gateways">
                            <option value=""><?php _e('Please select custom gateway.', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="RND" <?php selected($custom_gateway, 'RND'); ?>><?php _e('Random', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="ASAN" <?php selected($custom_gateway, 'ASAN'); ?>><?php _e('Persian Switch', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="SEP" <?php selected($custom_gateway, 'SEP'); ?>><?php _e('Saman', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="SAD" <?php selected($custom_gateway, 'SAD'); ?>><?php _e('Sadad', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="PEC" <?php selected($custom_gateway, 'PEC'); ?>><?php _e('Parsian', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="FAN" <?php selected($custom_gateway, 'FAN'); ?>><?php _e('Fanavard Card', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label for="zarinpal-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="zarinpal-order" value="<?php echo esc_attr(kando_get_option('zarinpal-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Zibal Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zibal-active"
                                   value="1" <?php echo checked(kando_get_option('zibal-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="zibal-merchant" value="<?php echo esc_attr(kando_get_option('zibal-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Zibal Sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zibal-sandbox"
                                   value="1" <?php echo checked(kando_get_option('zibal-sandbox'), 1); ?>>
                            <?php _e('Active Sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://zibal.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="zibal-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="zibal-order" value="<?php echo esc_attr(kando_get_option('zibal-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Bitpay Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="bitpay-active"
                                   value="1" <?php echo checked(kando_get_option('bitpay-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="bitpay-merchant" value="<?php echo esc_attr(kando_get_option('bitpay-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Bitpay Sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="bitpay-sandbox"
                                   value="1" <?php echo checked(kando_get_option('bitpay-sandbox'), 1); ?>>
                            <?php _e('Active Sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://bitpay.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="bitpay-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="bitpay-order" value="<?php echo esc_attr(kando_get_option('bitpay-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Nextpay Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="nextpay-active"
                                   value="1" <?php echo checked(kando_get_option('nextpay-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="nextpay-api-key" value="<?php echo esc_attr(kando_get_option('nextpay-api-key')); ?>"
                           placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://nextpay.org" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="nextpay-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="nextpay-order" value="<?php echo esc_attr(kando_get_option('nextpay-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Mrpardakht Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="mrpardakht-active"
                                   value="1" <?php echo checked(kando_get_option('mrpardakht-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mrpardakht-api-key" value="<?php echo esc_attr(kando_get_option('mrpardakht-api-key')); ?>"
                           placeholder="<?php _e('Mrpardakht Pin', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Mrpardakht Sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="mrpardakht-sandbox"
                                   value="1" <?php echo checked(kando_get_option('mrpardakht-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://aqayepardakht.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="mrpardakht-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="mrpardakht-order" value="<?php echo esc_attr(kando_get_option('mrpardakht-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('vandar Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="vandar-active"
                                   value="1" <?php echo checked(kando_get_option('vandar-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="vandar-api" value="<?php echo esc_attr(kando_get_option('vandar-api')); ?>"
                           placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('vandar sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="vandar-sandbox"
                                   value="1" <?php echo checked(kando_get_option('vandar-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://vandar.io" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="vandar-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="vandar-order" value="<?php echo esc_attr(kando_get_option('vandar-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Mellat Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="mellat-active"
                                   value="1" <?php echo checked(kando_get_option('mellat-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mellat-terminal-id" value="<?php echo esc_attr(kando_get_option('mellat-terminal-id')); ?>"
                           placeholder="<?php _e('mellat Terminal ID', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mellat-username" value="<?php echo esc_attr(kando_get_option('mellat-username')); ?>"
                           placeholder="<?php _e('mellat Username', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mellat-password" value="<?php echo esc_attr(kando_get_option('mellat-password')); ?>"
                           placeholder="<?php _e('mellat Password', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="http://www.behpardakht.com/" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="mellat-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="mellat-order" value="<?php echo esc_attr(kando_get_option('mellat-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <?php do_action('kando_settings_gateway_content') ?>
    </ul>
</div>