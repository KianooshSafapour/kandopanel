<?php

use kandopanel\currencyController;

defined('ABSPATH') || exit('No Access!');

$base_rate = kando_get_option('base_rate', 'IRT');
$currency_decimal = kando_get_option('currency_decimal', 2);
?>
<style>

</style>
<div class="samyar-settings-area samyar-settings-currency">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="credit-card"></span></span>
        <strong><?php _e('currency', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <?php
    $currencies = currencyController::getInstance()->get_all_currencies();
    ?>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Please select Base Rate currency.', SAMYAR_TEXT_DOMAIN); ?></label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="base_rate" class="base_rate">
                <option value=""><?php _e('Please select item.', SAMYAR_TEXT_DOMAIN); ?></option>
                <?php foreach ($currencies as $currency_code => $currency_info) { ?>
                    <option value="<?php echo esc_attr($currency_code); ?>" <?php selected($base_rate, $currency_code); ?>><?php echo $currency_code; ?> (<?php echo $currency_info['symbol']; ?>)</option>
                <?php } ?>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>

    <div class="uk-margin irt-rate" style="">
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-new-currecry-rate"><?php _e('Enter the USD rate in Tomans here (numbers only) (Hint: 1 USD equals how many Tomans?)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-alert-danger uk-alert" uk-alert="">
                <div class="kt-wc-coupon-box"><a target="_blank" href="<?= home_url('wp-admin/admin.php?page=kandopanel-price-convertor'); ?>"><?php _e('Click to change the USD rate', SAMYAR_TEXT_DOMAIN); ?></a></div>
            </div>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Enable currency switching by users (if enabled, users can change the rate and view service prices in their desired currency)', SAMYAR_TEXT_DOMAIN); ?></label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-switch-currency" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-switch-currency" value="1" <?php echo checked(kando_get_option('enable-switch-currency', 0), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
        </div>
    </div>

    <!--
    <div class="uk-margin usd-rate" style="<?php if ($base_rate === "USD") : ?>display:block<?php else : ?>display:none<?php endif; ?>">
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-new-currecry-rate"><?php _e('Currency decimal places (Hint: If the price is 0.1234 and you select 0.00, the displayed price will be 0.12)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="currency_decimal">
                    <option value="0">0</option>
                    <option value="1" <?php selected($currency_decimal, 1); ?>>0.0</option>
                    <option value="2" <?php selected($currency_decimal, 2); ?>>0.00</option>
                    <option value="3" <?php selected($currency_decimal, 3); ?>>0.000</option>
                    <option value="4" <?php selected($currency_decimal, 4); ?>>0.0000</option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="uk-margin afn-rate" style="<?php if ($base_rate === "AFN") : ?>display:block<?php else : ?>display:none<?php endif; ?>">
        <div class="uk-margin">
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-new-currecry-rate"><?php _e('Enter the USD rate in Afghanis here (numbers only) (Hint: 1 USD equals how many Afghanis?)', SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="number" class="uk-input" id="samyar-new-currecry-rate" name="usd-afn-currecry-rate" step=".01" value="<?php echo esc_attr(kando_get_option('usd-afn-currecry-rate', 1)); ?>">
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-new-currecry-rate"><?php _e('Enter the Afghani rate in Tomans here (numbers only) (Hint: 1 Afghani equals how many Tomans?)', SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="number" class="uk-input" id="samyar-new-currecry-rate" name="afn-irt-currecry-rate" value="<?php echo esc_attr(kando_get_option('afn-irt-currecry-rate', 1)); ?>">
            </div>
        </div>
    </div>
    -->

</div>