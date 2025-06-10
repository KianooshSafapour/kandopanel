<?php
defined('ABSPATH') || exit('No Access!');
?>
<div class="samyar-settings wrap">
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <p style="margin-top: 0">
            <p class="samyar-menu-item"><b><?php _e("Note:", SAMYAR_TEXT_DOMAIN); ?></b> <?php _e("Please review the", SAMYAR_TEXT_DOMAIN); ?> <a data-toggle="help" href="<?= admin_url('admin.php?page=samyar-settings#help') ?>"><?php _e("Help Section", SAMYAR_TEXT_DOMAIN); ?></a> <?php _e("and check the FAQs before applying any settings.", SAMYAR_TEXT_DOMAIN); ?></p>
        </div>
    </div>
    <div class="uk-grid-match" uk-grid>
        <div class="samyar-side-menu uk-width-1-4@m">
            <div class="uk-card uk-card-default uk-card-body">
                <?php include( SAMYAR_DIR_TEMPLATE . '/settings/side-menu.php' ); ?>
            </div>
        </div>
        <div class="samyar-settings-content uk-width-3-4@m">
            <div class="uk-card uk-card-default uk-card-body">
                <form id="samyar-settings-form">
                    <?php
                    $options      = settingsController::getInstance();
                    include( SAMYAR_DIR_TEMPLATE . '/settings/general.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/auth.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/dashboard.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/services.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/order.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/header-notification.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/gateways.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/sms.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/email.php' );
                    //					include( SAMYAR_DIR_TEMPLATE . '/settings/styles.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/currency.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/packages.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/smartpanel-sync.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/sync.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/cron.php' );
//                    include( SAMYAR_DIR_TEMPLATE . '/settings/remove.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/remove-minor.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/info.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/help.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/backup.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/ticket.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/api.php' );
                    include( SAMYAR_DIR_TEMPLATE . '/settings/float-buttons.php' );
                    do_action('kando_add_settings_content') ?>

                    <button type="submit" class="samyar-save uk-button uk-button-primary">
                        <?php _e('Save Changes', SAMYAR_TEXT_DOMAIN); ?>
                        <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg" width="26" height="26" alt="loader">
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>