<?php
defined('ABSPATH') || exit('No Access!');
?>
<div class="samyar-settings-area samyar-settings-backup">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="database"></span></span>
        <strong><?php _e('Export and Import Settings', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Import Settings', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="uk-alert-danger uk-alert" uk-alert="">
                    <?php _e('Warning: Please proceed with caution! Note that all current values will be replaced.', SAMYAR_TEXT_DOMAIN); ?>
                </div>
                <button class="uk-button uk-button-default show-import-textarea" data-type="all" type="button"><?php _e('Import with Data', SAMYAR_TEXT_DOMAIN); ?></button>
                <!--
                <button class="uk-button uk-button-default show-import-file" data-type="all" type="button"><?php _e('Import with File', SAMYAR_TEXT_DOMAIN); ?></button>
                -->
            </div>

            <div class="uk-margin-small import-textarea">
                <label>
                    <textarea class="uk-textarea" id="import-data-text" dir="ltr"></textarea>
                    <div class="uk-margin-small">
                        <button class="uk-button uk-button-yellow" id="kando_import_btn" type="button"><?php _e('Import', SAMYAR_TEXT_DOMAIN); ?></button>
                    </div>
                </label>
            </div>

            <div class="uk-margin-small import-file">
                <input type="file" name="import-file" id="import-file">
                <div class="uk-margin-small">
                    <button class="uk-button uk-button-yellow" id="kando_import_file_btn" type="button"><?php _e('Import', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Export Settings', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="uk-alert-primary uk-alert" uk-alert="">
                    <?php _e('In this section, you can back up your site settings and use them to transfer settings from your current site to a new site.', SAMYAR_TEXT_DOMAIN); ?>
                    <?php _e('If your settings change, you can easily restore them.', SAMYAR_TEXT_DOMAIN); ?>
                    <?php _e('Simply copy this data and save it in a text file, then store it in a safe place.', SAMYAR_TEXT_DOMAIN); ?>
                </div>
                <button class="uk-button uk-button-default show-backup-textarea" data-type="all" type="button"><?php _e('Copy Settings Data', SAMYAR_TEXT_DOMAIN); ?></button>

                <?php
                $secret = md5(md5(AUTH_KEY . SECURE_AUTH_KEY) . '-samyar_options');
                $link = esc_url(admin_url('admin-ajax.php?action=kando_download_options-samyar_options' . '&secret=' . $secret));
                ?>
                <!--
                <a class="uk-button uk-button-yellow" href="<?php echo $link; ?>"><?php _e('Download Settings File', SAMYAR_TEXT_DOMAIN); ?></a>
                -->
            </div>
            <div class="uk-margin-small backup-textarea">
                <label>
                    <textarea class="uk-textarea" id="backup-data-text" dir="ltr"></textarea>
                </label>
            </div>
        </div>
    </div>
</div>