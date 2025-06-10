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
            <table class="form-table">

                <tr valign="top">
                    <th scope="row">
                        <?php echo esc_html__('Status', SAMYAR_TEXT_DOMAIN); ?>
                    </th>
                    <td>
                        <?php
                        //						$connected = true;
                        if ($connected) {
                            ?>
                            <span class="status positive"><?php echo esc_html__('CONNECTED', SAMYAR_TEXT_DOMAIN); ?></span>
                            <?php
                        } else {
                            ?>
                            <span class="status neutral"><?php echo esc_html__('NOT CONNECTED', SAMYAR_TEXT_DOMAIN); ?></span>
                            <?php if (!empty($message)) { ?>
                                <div class="uk-alert-danger" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p><?php echo $message ?></p>
                                </div>
                            <?php } ?>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <div class="uk-alert-primary" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php _e('note: after add API Key refresh page for connect status', SAMYAR_TEXT_DOMAIN); ?></p>
            </div>
            <div class="uk-margin-small">
                <input type="text" class="uk-input" name="api-url" value="<?php echo esc_attr($options->get_option('api-url')); ?>"
                       placeholder="<?php _e('API url', SAMYAR_TEXT_DOMAIN); ?>">
            </div>
            <div class="uk-margin-small">
                <input type="text" class="uk-input" name="api-key" value="<?php echo esc_attr($options->get_option('api-key')); ?>"
                       placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>">
            </div>
            <div class="samyar-description">
                <span uk-icon="info"></span>
                <a href="#" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
            </div>


        </div>


    </div>

</div>