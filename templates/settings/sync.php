<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );
?>
<div class="samyar-settings-area samyar-settings-sync">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="sync"></span></span>
        <strong>همگامسازی خودکار</strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">آیا در همگاسازی خودکار حداقل و حداکثر و سفارش قطره ای به روز شود</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-sync-minmax" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-sync-minmax" value="1" <?php echo checked( $options->get_option( 'enable-sync-minmax',1), 1 ); ?>>فعال</label>
            </div>

        </div>
    </div>



</div>