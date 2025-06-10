<?php

use samyar\smartPanelApi;

defined('ABSPATH') || exit('No Access!');
$lists = array();
$api = new smartPanelApi();
$connected = false;
//if ( $connected ) {
$balance = $api->balance();
if (is_null($balance) || isset($balance->error)) {
    $connected = false;
} else {
    $connected = true;
}
//print_r($balance);

//}

?>
<div class="samyar-settings-area samyar-settings-api samyar-active">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="rss"></span></span>
        <strong><?php _e('API', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <div class="uk-margin">
        <div class="uk-margin">
            <div class="uk-alert-primary" uk-alert>
                <p><?php _e('From this section, you can temporarily disable receiving orders from the API so that orders sent to your site via the API are not received.', SAMYAR_TEXT_DOMAIN); ?></p>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('API Activation', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-api" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-api"
                           value="1" <?php echo checked(kando_get_option('enable-api', 1), 1); ?>> <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>
        </div>

    </div>

</div>