<?php
defined('ABSPATH') || exit('No Access!');
?>
<div class="samyar-settings-area samyar-settings-sync">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="sync"></span></span>
        <strong><?php _e('Automatic Synchronization', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Should minimum, maximum, and drip-feed orders be updated during automatic synchronization?', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-sync-minmax" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-sync-minmax"
                           value="1" <?php echo checked(kando_get_option('enable-sync-minmax', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                </label>
            </div>

        </div>
    </div>


</div>