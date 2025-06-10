<?php
defined('ABSPATH') || exit('No Access!');

use samyar\smartPanelApi;

$lists = array();
$api = new smartPanelApi();
$connected = false;

$balance = $api->balance();

if (is_null($balance) || isset($balance->error)) {
    $connected = false;
} else {
    $connected = true;
}
?>
<div class="samyar-settings-area samyar-settings-spsync">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="refresh"></span></span>
        <strong><?php _e('API', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b><?php _e('Watch the tutorial video for synchronizing Smart Panel data with Kando Panel from the link below:', SAMYAR_TEXT_DOMAIN); ?></b><br><br>
                <a href="https://www.aparat.com/v/zyDnx?playlist=36127006"
                   target="_blank"><?php _e('Tutorial Video for Synchronizing Smart Panel and Kando Panel', SAMYAR_TEXT_DOMAIN); ?></a>
                <br>
            </p>
        </div>
    </div>

    <div class="uk-margin">
        <div class="uk-margin">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <?php echo esc_html__('Status:', SAMYAR_TEXT_DOMAIN); ?>
                    </th>
                    <td>
                        <?php
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
                                    <p><?php echo $message; ?></p>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <?php if ($connected) { ?>
                        <th scope="row">
                            <?php echo esc_html__('Credit:', SAMYAR_TEXT_DOMAIN); ?>
                        </th>
                        <td><?php echo $balance->balance; ?></td>
                    <?php } ?>
                </tr>
            </table>
            <div class="uk-alert-primary" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php _e('Note: After adding the API Key, refresh the page to check the connection status.', SAMYAR_TEXT_DOMAIN); ?></p>
            </div>
            <div class="uk-margin-small">
                <input type="text" dir="ltr" class="uk-input" name="api-url"
                       value="<?php echo esc_attr(kando_get_option('api-url')); ?>"
                       placeholder="<?php _e('API URL', SAMYAR_TEXT_DOMAIN); ?>">
            </div>
            <div class="uk-margin-small">
                <input type="text" dir="ltr" class="uk-input" name="api-key"
                       value="<?php echo esc_attr(kando_get_option('api-key')); ?>"
                       placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>">
            </div>
            <div class="uk-alert-primary" uk-alert>
                <p>
                    <b><?php _e('Attention:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('Due to encryption differences between the two systems, user passwords are not transferred. Transferred users must reset their passwords and set a new one.', SAMYAR_TEXT_DOMAIN); ?>
                </p>
            </div>

            <?php if ($connected) { ?>
                <div class="samyar-description">
                    <a class="samyar-save uk-button uk-button-danger" id="smartpanel-sync-users"
                       style="color:#fff !important">
                        <span uk-icon="users"
                              style="color:#fff !important;float:right;margin-top: 8px;margin-left: 10px;"></span>
                        <?php _e('Start User Sync', SAMYAR_TEXT_DOMAIN); ?>
                        <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg"
                             style="position: relative;left: -10px;top: 7px;" width="26" height="26" alt="loader">
                    </a>
                    <a class="samyar-save uk-button uk-button-danger" id="smartpanel-sync-services"
                       style="color:#fff !important">
                        <span uk-icon="list"
                              style="color:#fff !important;float:right;margin-top: 8px;margin-left: 10px;"></span>
                        <?php _e('Start Service Sync', SAMYAR_TEXT_DOMAIN); ?>
                        <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg"
                             style="position: relative;left: -10px;top: 7px;" width="26" height="26" alt="loader">
                    </a>
                </div>
            <?php } ?>

            <div class="uk-margin-small" id="user_sync_stat" style="display: none">
            </div>

            <div class="uk-alert-danger" id="user_sync_errors" style="display: none" uk-alert>
            </div>
        </div>
    </div>
</div>