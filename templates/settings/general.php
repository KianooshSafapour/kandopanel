<?php
defined('ABSPATH') || exit('No Access!');


$site_favicon = kando_get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = kando_get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}


$site_logo = kando_get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = kando_get_option('site-logo');
    $site_logo = wp_get_attachment_url($site_logo);
}


$site_mobile_logo = kando_get_option('site-mobile-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_mobile_logo) && !empty($site_mobile_logo) && is_numeric($site_mobile_logo)) {
    $site_mobile_logo = kando_get_option('site-mobile-logo');
    $site_mobile_logo = wp_get_attachment_url($site_mobile_logo);
}
?>
<div class="samyar-settings-area samyar-settings-general">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong><?php _e("General", SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable site title in header (next to logo)", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-site-title" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-site-title" value="1" <?php echo checked( kando_get_option( 'enable-site-title',1), 1 ); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>
        <!--
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-support-phone"><?php _e("Support phone number", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-support-phone" name="support-phone" value="<?php echo esc_attr(kando_get_option('support-phone', "")); ?>">
        </div>
-->
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Favicon", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-favicon" value="<?php echo esc_attr($site_favicon); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-site-favicon" readonly value="<?php echo esc_attr($site_favicon); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-favicon" uk-tooltip="title: <?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($site_favicon); ?>" class="samyar-url" uk-tooltip="title: <?php _e("View", SAMYAR_TEXT_DOMAIN); ?>" target="_blank"><span uk-icon="link"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Site logo", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-logo" value="<?php echo esc_attr($site_logo); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-site-logo" readonly value="<?php echo esc_attr($site_logo); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: <?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($site_logo); ?>" class="samyar-url" uk-tooltip="title: <?php _e("View", SAMYAR_TEXT_DOMAIN); ?>" target="_blank"><span uk-icon="link"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Mobile logo", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-mobile-logo" value="<?php echo esc_attr($site_mobile_logo); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-site-mobile-logo" readonly value="<?php echo esc_attr($site_mobile_logo); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-mobile-logo" uk-tooltip="title: <?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($site_mobile_logo); ?>" class="samyar-url" uk-tooltip="title: <?php _e("View", SAMYAR_TEXT_DOMAIN); ?>" target="_blank"><span uk-icon="link"></a>
                </div>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Site social networks", SAMYAR_TEXT_DOMAIN); ?></label>
        </div>
        <div class="uk-margin">
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title"><?php _e("Instagram", SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-instagram-url" name="instagram-url" value="<?php echo esc_attr(kando_get_option('instagram-url', "")); ?>">
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title"><?php _e("Telegram", SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-telegram-url" name="telegram-url" value="<?php echo esc_attr(kando_get_option('telegram-url', "")); ?>">
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title"><?php _e("Twitter", SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-twitter-url" name="twitter-url" value="<?php echo esc_attr(kando_get_option('twitter-url', "")); ?>">
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title"><?php _e("LinkedIn", SAMYAR_TEXT_DOMAIN); ?></label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-linkedin-url" name="linkedin-url" value="<?php echo esc_attr(kando_get_option('linkedin-url', "")); ?>">
            </div>
        </div>

        <?php
        $samyar_header = kando_get_option('samyar-header', 0);
        $headers = kando_get_header_list();
        ?>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Select header (headers created with header builder)", SAMYAR_TEXT_DOMAIN); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="samyar-header">
                    <?php foreach ($headers as $key=>$header): ?>
                        <option value="<?= $key ?>" <?php selected( $samyar_header, $key ); ?>><?= $header ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>


        <?php
        $samyar_footer = kando_get_option('samyar-footer', 0);
        $footers = kando_get_footer_list();
        ?>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Select footer (footers created with footer builder)", SAMYAR_TEXT_DOMAIN); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="samyar-footer">
                    <?php foreach ($footers as $key=>$footer): ?>
                        <option value="<?= $key ?>" <?php selected( $samyar_footer, $key ); ?>><?= $footer ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-copyright"><?php _e("Copyright text", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-copyright" name="copyright" value="<?php echo esc_attr(kando_get_option('copyright', "تمامی حقوق مادی و معنوی این وبسایت متعلق به <a href=\"http://127.0.0.1/kandopanel\" data-wpel-link=\"internal\">کندو پنل</a> می باشد و هر گونه کپی برداری پیگرد قانونی دارد.")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-index-title"><?php _e("Title on the default template homepage", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-index-title" name="index-title" value="<?php echo esc_attr(kando_get_option('index-title', " فروشگاه خدمات شبکه های اجتماعی کندوپنل ")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-index-content"><?php _e("Description on the default template homepage", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-index-content" name="index-content" value="<?php echo esc_attr(kando_get_option('index-content', " حساب شبکه های اجتماعی شما می‌تواند رشد کند. درآمد شما می‌تواند چند برابر شود. فقط کافی است مسیر درست را بشناسید. کافی است از خدمات مناسب در مکان مناسب استفاده نمایید. ما در این مسیر همراه شما هستیم. ")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-url-api-slug"><?php _e("Prefix in your site's API link", SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" dir="ltr" class="uk-input" id="samyar-url-api-slug" name="url-api-slug" value="<?php echo esc_attr(kando_get_option('url-api-slug', "kando")); ?>">
            <strong style="color:#f0506e"><b><?php _e("Note", SAMYAR_TEXT_DOMAIN); ?></b>: <?php _e("After changing this term, go to the WordPress dashboard and navigate to <b>Settings->Permalinks</b>. Without making any changes, click the save button to regenerate the new link. (If you don't do this, the Elementor page builder will encounter issues.)", SAMYAR_TEXT_DOMAIN); ?></strong>

            <div class="uk-alert-danger" uk-alert>
                <?php _e("This term will be included in your API link, for example: yoursite.ir/<b>kando</b>/api/v1", SAMYAR_TEXT_DOMAIN); ?>
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable mobile-specific user menu", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-mobile-menu" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-mobile-menu" value="1" <?php echo checked( kando_get_option( 'enable-mobile-menu',1), 1 ); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>


        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable Jalali date converter (convert all dates to Jalali)", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-jalali-date" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-jalali-date" value="1" <?php echo checked( kando_get_option( 'enable-jalali-date',1), 1 ); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>


        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable uploading attachments to WordPress media", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-alert-danger" uk-alert>
                <?php _e("By default, media files (images and ticket attachments) are uploaded to a specific folder designated for the theme. However, by enabling this option, you can have them added to the WordPress media library for easier management. If you are unsure about this, leave it disabled.", SAMYAR_TEXT_DOMAIN); ?>
            </div>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-upload-wp-media" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-upload-wp-media" value="1" <?php echo checked( kando_get_option( 'enable-upload-wp-media',0), 1 ); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>

        <?php
        $languages = kando_get_available_languages();
        $base_language = kando_get_option( 'base-language','fa_IR');
        ?>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Please select base language.", SAMYAR_TEXT_DOMAIN); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="base-language" class="base-language">
                    <option value=""><?php _e("Please select an item.", SAMYAR_TEXT_DOMAIN); ?></option>
                    <?php foreach ($languages as $lang_code => $lang_name){ ?>
                        <option value="<?php echo esc_attr($lang_code) ?>" <?php selected( $base_language, $lang_code ); ?>><?php echo $lang_name ?></option>
                    <?php } ?>

                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label"><?php _e("Enable language switching by users (if enabled, users can change the language and view the user panel in their preferred language)", SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-switch-language" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-switch-language" value="1" <?php echo checked( kando_get_option( 'enable-switch-language',0), 1 ); ?>><?php _e("Enable", SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>

    </div>
</div>