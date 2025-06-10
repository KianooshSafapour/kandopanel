<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );


$site_header_notification_bg = kando_get_option( 'site-header-notification-bg', SAMYAR_DIR_IMG . '/social_media_banner.png' );
if ( isset( $site_header_notification_bg ) && ! empty( $site_header_notification_bg ) && is_numeric( $site_header_notification_bg ) ) {
    $site_header_notification_bg = kando_get_option( 'site-header-notification-bg' );
    $site_header_notification_bg = wp_get_attachment_url( $site_header_notification_bg );
}
?>
<div class="samyar-settings-area samyar-settings-header-notification">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="bell"></span></span>
        <strong><?php _e("Header Notification", SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="checkbox" name="header-notification-active"
                           value="1" <?php echo checked(kando_get_option('header-notification-active'), 1); ?>><?php _e("Active", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-header-notification-id"><?php _e("Notification ID", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-header-notification-id" name="header-notification-id"
                   value="<?php echo esc_attr( kando_get_option( 'header-notification-id', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-header-notification-title"><?php _e("Notification Title", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-header-notification-title" name="header-notification-title"
                   value="<?php echo esc_attr( kando_get_option( 'header-notification-title', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-notification-btn-title"><?php _e("Notification Button Text", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-notification-btn-title" name="notification-btn-title" value="<?php echo esc_attr( kando_get_option( 'notification-btn-title', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-notification-btn-url"><?php _e("Notification Button URL", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" dir="ltr" id="samyar-notification-btn-url" name="notification-btn-url" value="<?php echo esc_attr( kando_get_option( 'notification-btn-url', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Notification Background", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-header-notification-bg" value="<?php echo esc_attr( $site_header_notification_bg ); ?>">
                    <input type="text" class="samyar-upload-file uk-input" id="samyar-site-header-notification-bg" readonly value="<?php echo esc_attr( $site_header_notification_bg ); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-header-notification-bg" uk-tooltip="title: <?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr( $site_header_notification_bg ); ?>" class="samyar-url" uk-tooltip="title: <?php _e("View", SAMYAR_TEXT_DOMAIN); ?>" target="_blank"><span
                                uk-icon="link"></a>
                </div>
            </div>
        </div>
    </div>
</div>