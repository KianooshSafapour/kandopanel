<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;
$provider_id = $_GET['id'];
$provider = Provider::find($provider_id);
if($provider):
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li><?php _e('You can read the tips related to this section here', SAMYAR_TEXT_DOMAIN); ?></li>
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e('Edit Provider', SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e('Modify the information, click on submit, and wait', SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" class="samyar-form new-api-provider-form">
                    <input type="hidden" name="action" value="samyar_api_provider_edit">
                    <input type="hidden" name="provider_id" value="<?php echo esc_attr($provider->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <input type="text" name="name" value="<?php echo esc_attr($provider->name) ?>" placeholder="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="text" name="url" dir="ltr" value="<?php echo esc_attr($provider->url) ?>" placeholder="<?php _e('Link', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="text" name="api-key" id="api-key-edit" disabled="disabled" dir="ltr" placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>" value="<?=($provider->api_key)? kando_hide_api_key($provider->api_key) : ''?>"/>
                        <div class="kt-col-xs-12">
                            <div class="kt-wc-coupon-box"><a href="#" class="show-api-input"><?php _e('Click here to change the API key', SAMYAR_TEXT_DOMAIN); ?></a></div>
                        </div>
                        <label><?php _e('Desired profit rate for this provider (in percentage)', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="number" min="0" max="1000" step="1" name="custom-rate" id="custom-rate" disabled dir="ltr" placeholder="<?php _e('Desired Profit (Percentage)', SAMYAR_TEXT_DOMAIN); ?>" value="<?= ($provider->custom_rate) ?: '' ?>"/>
                        <div class="kt-col-xs-12">
                            <div class="kt-wc-coupon-box"><a target="_blank" href="<?=home_url('wp-admin/admin.php?page=kandopanel-price-convertor')?>"><?php _e('Click here to change the desired rate for this provider', SAMYAR_TEXT_DOMAIN); ?></a></div>
                        </div>
                        <label><?php _e('In which currency are the prices of this provider?', SAMYAR_TEXT_DOMAIN); ?></label>
                        (<span><a href="#" id="inquiry_rate"><?php _e('Inquire Rate', SAMYAR_TEXT_DOMAIN); ?></a></span>)
                        <select name="base-currency">
                            <option <?php if(esc_attr( $provider->base_currency )=="USD") echo 'selected' ?> value="USD"><?php _e('Dollar', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if(esc_attr( $provider->base_currency )=="IRT") echo 'selected' ?> value="IRT"><?php _e('Toman', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <select name="status">
                            <option <?php if(esc_attr( $provider->status )==1) echo 'selected' ?> value="1"><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if(esc_attr( $provider->status )==0) echo 'selected' ?> value="0"><?php _e('Inactive', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <textarea class="new-api-form-text" name="description" style="margin-bottom: 10px;" placeholder="<?php _e('Description', SAMYAR_TEXT_DOMAIN); ?>"><?php echo esc_attr($provider->description) ?></textarea>
                        <label><?php _e('Enter the provider\'s website address here (this is for quick access to the provider\'s website)', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="text" name="site_link" dir="ltr" value="<?php echo esc_attr($provider->site_link) ?>" placeholder="<?php _e('Website Address', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Update', SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
else:

endif;