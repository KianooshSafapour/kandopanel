<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
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
            <h4 class="new-ticket-title"><?php _e('Add New Provider', SAMYAR_TEXT_DOMAIN); ?></h4>
            <span class="new-ticket-text"><?php _e('Enter the information, click on add, and wait', SAMYAR_TEXT_DOMAIN); ?></span>
            <form method="POST" class="samyar-form new-api-provider-form">
                <input type="hidden" name="action" value="samyar_api_provider_add">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <input type="text" name="name" placeholder="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <input type="text" name="url" dir="ltr" placeholder="<?php _e('Link', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <input type="text" name="api-key" dir="ltr" placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <label><?php _e('Desired profit rate for this provider (in percentage)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="number" min="0" max="1000" step="1" name="custom-rate" id="custom-rate" dir="ltr" placeholder="<?php _e('Desired Profit (Percentage)', SAMYAR_TEXT_DOMAIN); ?>" value=""/>
                    <label><?php _e('In which currency are the prices of this provider?', SAMYAR_TEXT_DOMAIN); ?></label>
                    (<span><a href="#" id="inquiry_rate"><?php _e('Inquire Rate', SAMYAR_TEXT_DOMAIN); ?></a></span>)
                    <select name="base-currency">
                        <option value="IRT"><?php _e('Toman', SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="USD"><?php _e('Dollar', SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                    <textarea class="new-api-form-text" name="description" style="margin-bottom: 10px;" placeholder="<?php _e('Description', SAMYAR_TEXT_DOMAIN); ?>"></textarea>
                    <label><?php _e('Enter the provider\'s website address here (this is for quick access to the provider\'s website)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" name="site_link" dir="ltr" value="" placeholder="<?php _e('Website Address', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Submit', SAMYAR_TEXT_DOMAIN); ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>