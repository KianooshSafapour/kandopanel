<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );
?>
<div class="samyar-settings-area samyar-settings-ticket">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="lifesaver"></span></span>
        <strong>تنظیمات تیکت</strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی آپلود ضمیمه در تیکت</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-ticket-attach" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-ticket-attach" value="1" <?php echo checked( $options->get_option( 'enable-ticket-attach',1), 1 ); ?>>فعال</label>
            </div>

        </div>
    </div>



</div>