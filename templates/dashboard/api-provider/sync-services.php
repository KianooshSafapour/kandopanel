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
                    <li><?php _e('The update includes price, profit rate update, minimum and maximum quantity, as well as features such as drip-feed.', SAMYAR_TEXT_DOMAIN); ?></li>
                    <li><b><?php _e('New Services:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('All services recently added to this provider will also be added to your site.', SAMYAR_TEXT_DOMAIN); ?></li>
                    <!--                    <li><b>Currency Rate Conversion:</b> If you wish to change the currency rate, you can do so in the theme settings.</li>-->
                    <!--                    <li>Current Services: Updates all current services in terms of price, minimum and maximum quantity, as well as features such as drip-feed.</li>-->
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e('Service Synchronization', SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e('Modify the information, click on submit, and wait.', SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" class="samyar-form sync-api-provider-form">
                    <input type="hidden" name="action" value="samyar_api_provider_sync">
                    <input type="hidden" name="provider_id" value="<?php echo esc_attr($provider->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <input type="text" name="name" value="<?php echo esc_attr($provider->name) ?>" disabled placeholder="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="text" name="url" dir="ltr" value="<?php echo esc_attr($provider->url) ?>" disabled placeholder="<?php _e('Link', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="text" name="api-key" dir="ltr" value="<?=($provider->api_key)? kando_hide_api_key($provider->api_key) : ''?>" disabled placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <label><?php _e('I Request:', SAMYAR_TEXT_DOMAIN); ?></label>
                        <select name="request" class="request">
                            <option value="0"><?php _e('Update Current Services', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="1"><?php _e('Add New Services', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <input type="checkbox" value="1" id="update-minmax" name="update-minmax" checked><label style="margin: 20px 0;" class="update-minmax" for="update-minmax"><?php _e('Update Min | Max | Drip-feed', SAMYAR_TEXT_DOMAIN); ?></label>

                        <input type="checkbox" value="1" id="update-title" name="update-title"><label style="margin: 20px 0;" class="update-title" for="update-title"><?php _e('Update Title (Note: Current title will be deleted)', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="checkbox" value="1" id="update-description" name="update-description"><label style="margin: 20px 0;" class="update-description" for="update-description"><?php _e('Update Description (Note: Current description will be deleted)', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Submit', SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="kt-row" id="sync-result"></div>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(document).on('change', '.request', function () {
                $(this).val();
                if($(this).val()==="0"){
                    $('.update-title,.update-description').show();
                }else{
                    $('.update-title,.update-description').hide();
                }
            })
        })

    </script>
<?php
else:

endif;