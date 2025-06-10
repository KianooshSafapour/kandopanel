<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );


$site_header_notification_bg = $options->get_option( 'site-header-notification-bg',SAMYAR_DIR_IMG . '/social_media_banner.png');
if ( isset( $site_header_notification_bg ) && ! empty( $site_header_notification_bg ) && is_numeric( $site_header_notification_bg ) ) {
	$site_header_notification_bg = $options->get_option( 'site-header-notification-bg' );
	$site_header_notification_bg = wp_get_attachment_url( $site_header_notification_bg );
}
?>
<div class="samyar-settings-area samyar-settings-header-notification">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="bell"></span></span>
        <strong>اطلاعیه هدر</strong>
    </h3>


    <div class="uk-margin">
	    <div class="uk-margin">
		    <label class="uk-form-label">وضعیت</label>
		    <div class="uk-margin-small">
			    <label>
				    <input class="uk-checkbox" type="checkbox" name="header-notification-active"
				           value="1" <?php echo checked($options->get_option('header-notification-active'), 1); ?>>فعال</label>
		    </div>

	    </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-header-notification-id">شناسه اطلاعیه</label>
            <input type="text" class="uk-input" id="samyar-header-notification-id" name="header-notification-id"
                   value="<?php echo esc_attr( $options->get_option( 'header-notification-id', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-header-notification-title">عنوان اطلاعیه</label>
            <input type="text" class="uk-input" id="samyar-header-notification-title" name="header-notification-title"
                   value="<?php echo esc_attr( $options->get_option( 'header-notification-title', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-notification-btn-title">متن دکمه اطلاعیه</label>
            <input type="text" class="uk-input" id="samyar-notification-btn-title" name="notification-btn-title" value="<?php echo esc_attr( $options->get_option( 'notification-btn-title', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-notification-btn-url">لینک دکمه اطلاعیه</label>
            <input type="text" class="uk-input" dir="ltr" id="samyar-notification-btn-url" name="notification-btn-url" value="<?php echo esc_attr( $options->get_option( 'notification-btn-url', "" ) ); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label">پس زمینه اطلاعیه</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-header-notification-bg" value="<?php echo esc_attr( $site_header_notification_bg ); ?>">
                    <input type="text" class="samyar-upload-file uk-input" id="samyar-site-header-notification-bg" readonly value="<?php echo esc_attr( $site_header_notification_bg ); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-header-notification-bg" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr( $site_header_notification_bg ); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                uk-icon="link"></a>
                </div>
            </div>
        </div>
    </div>
</div>