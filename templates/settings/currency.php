<?php

use kandopanel\currencyController;

defined('ABSPATH') || exit('No Access!');

$base_rate = $options->get_option( 'base_rate','IRT');
$currency_decimal = $options->get_option( 'currency_decimal',2);
?>
<style>

</style>
<div class="samyar-settings-area samyar-settings-currency">

	<h3 class="samyar-settings-title">
		<span class="samyar-title-icon"><span uk-icon="credit-card"></span></span>
		<strong><?php _e( 'currency', SAMYAR_TEXT_DOMAIN ); ?></strong>
	</h3>

    <?php
    $currencies = currencyController::getInstance()->get_all_currencies();
    ?>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e( 'Please select Base Rate currency.', SAMYAR_TEXT_DOMAIN ); ?></label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="base_rate" class="base_rate">
                <option value=""><?php _e( 'Please select item.', SAMYAR_TEXT_DOMAIN ); ?></option>
                <?php foreach ($currencies as $currency_code => $currency_info){

                    ?>
                    <option value="<?php echo esc_attr($currency_code) ?>" <?php selected( $base_rate, $currency_code ); ?>><?php echo $currency_code ?> (<?php echo $currency_info['symbol'] ?>)</option>
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
			<label class="uk-form-label" for="samyar-new-currecry-rate">نرخ دلار را اینجا به تومان وارد نمایید(تنها عدد)(راهنما: 1 دلار مساوی با چند تومان است؟)</label>
			<input type="number" class="uk-input" id="samyar-new-currecry-rate" name="new-currecry-rate" value="<?php echo esc_attr($options->get_option('new-currecry-rate',1)); ?>">
		</div>
	</div>

    <div class="uk-margin">
        <label class="uk-form-label">فعالسازی تغییر ارز توسط کاربر(اگر فعال باشد کاربر می تواند نرخ را تغییر دهد و مبلغ سرویس ها رو با ارز دلخواه ببینه)</label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-switch-currency" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-switch-currency" value="1" <?php echo checked( $options->get_option( 'enable-switch-currency',0), 1 ); ?>>فعال</label>
        </div>

    </div>

    <!--
    <div class="uk-margin usd-rate" style="<?php if($base_rate==="USD"): ?>display:block<?php else: ?>display:none<?php endif; ?>">
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-new-currecry-rate">مکان اعشار ارز(راهنما: اگر قیمت 0/1234 باشد و شما 0.00 را انتخاب نمایید. قیمت نمایشی -> 0/12)</label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="currency_decimal">
                    <option value="0">0</option>
                    <option value="1" <?php selected( $currency_decimal, 1 ); ?>>0.0</option>
                    <option value="2" <?php selected( $currency_decimal, 2 ); ?>>0.00</option>
                    <option value="3" <?php selected( $currency_decimal, 3 ); ?>>0.000</option>
                    <option value="4" <?php selected( $currency_decimal, 4 ); ?>>0.0000</option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="uk-margin afn-rate" style="<?php if($base_rate==="AFN"): ?>display:block<?php else: ?>display:none<?php endif; ?>">
        <div class="uk-margin">
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-new-currecry-rate">نرخ دلار را اینجا به افغانی وارد نمایید(تنها عدد)(راهنما: 1 دلار مساوی با چند افغانی است؟)</label>
                <input type="number" class="uk-input" id="samyar-new-currecry-rate" name="usd-afn-currecry-rate" step=".01" value="<?php echo esc_attr($options->get_option('usd-afn-currecry-rate',1)); ?>">
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-new-currecry-rate">نرخ افغانی را اینجا به تومان وارد نمایید(تنها عدد)(راهنما: 1 افغانی مساوی با چند تومان است؟)</label>
                <input type="number" class="uk-input" id="samyar-new-currecry-rate" name="afn-irt-currecry-rate" value="<?php echo esc_attr($options->get_option('afn-irt-currecry-rate',1)); ?>">
            </div>
        </div>
    </div>
    -->

</div>