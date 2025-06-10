<?php
defined('ABSPATH') || exit('No Access!');
$style = $options->get_option('style');
$font = $options->get_option('font', $options->samyar_default('font'));
?>
<div class="samyar-settings-area samyar-settings-styles">
    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="paint-bucket"></span></span>
        <strong><?php _e('Styles', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Font', SAMYAR_TEXT_DOMAIN); ?></label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="font-family">
                <option value=""><?php _e('Please select an item.', SAMYAR_TEXT_DOMAIN); ?></option>
                <option value="IRANSans" <?php selected($font, 'IRANSans'); ?>>IRANSans</option>
                <option value="iranyekan" <?php selected($font, 'iranyekan'); ?>>IRANYekan</option>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>

</div>