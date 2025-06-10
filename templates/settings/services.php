<?php
defined('ABSPATH') || exit('No Access!');
?>
<div class="samyar-settings-area samyar-settings-services">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong><?php _e('Services', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <?php
    $select_service_order = kando_get_option('select_service_order', 'price');
    ?>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Select service sorting method', SAMYAR_TEXT_DOMAIN); ?></label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="select_service_order">
                <option <?php if ($select_service_order === "price"): ?> selected <?php endif; ?> value="price"><?php _e('Price (Low to High)', SAMYAR_TEXT_DOMAIN); ?></option>
                <option <?php if ($select_service_order === "order"): ?> selected <?php endif; ?> value="order"><?php _e('Manual Sorting (Available in Add/Edit each service)', SAMYAR_TEXT_DOMAIN); ?></option>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Enable display of estimated order completion time', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-average-time" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-average-time" value="1" <?php echo checked(kando_get_option('enable-average-time', 1), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>
    </div>

    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Show order button for non-logged-in users', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-order-btn-notloginuser" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-order-btn-notloginuser" value="1" <?php echo checked(kando_get_option('enable-order-btn-notloginuser', 1), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <?php _e('Note 1: All numbers will be rounded up.<br>Examples:<br>If you set the rounding to thousands, prices will be displayed as follows:<br>152342 -> 153000<br>47523 -> 48000<br>3823 -> 4000<br>252 -> 300', SAMYAR_TEXT_DOMAIN); ?>
        </div>


        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Enable price rounding', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="round-price" value="0">
                    <input class="uk-checkbox" type="checkbox" name="round-price" value="1" <?php echo checked(kando_get_option('round-price', 0), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>

        </div>


        <div class="uk-margin">
            <?php
            $round_price_number = kando_get_option('round-price-number', 10);
            ?>
            <label class="uk-form-label"><?php _e('Round to which digit', SAMYAR_TEXT_DOMAIN); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="round-price-number">
                    <option value="10" <?php if ($round_price_number == 10): ?> selected <?php endif; ?>><?php _e('Tens', SAMYAR_TEXT_DOMAIN); ?></option>
                    <option value="100" <?php if ($round_price_number == 100): ?> selected <?php endif; ?>><?php _e('Hundreds', SAMYAR_TEXT_DOMAIN); ?></option>
                    <option value="1000" <?php if ($round_price_number == 1000): ?> selected <?php endif; ?>><?php _e('Thousands', SAMYAR_TEXT_DOMAIN); ?></option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>

        <!--
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Select rounding type', SAMYAR_TEXT_DOMAIN); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="round-price-type">
                    <option value="up" <?php if (kando_get_option('round-price-type', "down") === "up"): ?> selected <?php endif; ?>><?php _e('Up', SAMYAR_TEXT_DOMAIN); ?></option>
                    <option value="down" <?php if (kando_get_option('round-price-type', "down") === "down"): ?> selected <?php endif; ?>><?php _e('Down', SAMYAR_TEXT_DOMAIN); ?></option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>
-->
    </div>
    <hr>
    <div class="uk-margin">


        <?php
        $service_style = (int)kando_get_option('service-style', 2);

        ?>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Service display template', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="service-style">
                    <option <?php if ($service_style === 1): ?> selected <?php endif; ?> value="1"><?php _e('Style 1', SAMYAR_TEXT_DOMAIN); ?></option>
                    <option <?php if ($service_style === 2): ?> selected <?php endif; ?> value="2"><?php _e('Style 2', SAMYAR_TEXT_DOMAIN); ?></option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>


    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="samyar-service-load-cat-number"><?php _e('How many categories to load per request when loading services', SAMYAR_TEXT_DOMAIN); ?></label>
        <input type="text" class="uk-input ltr" id="samyar-service-load-cat-number" name="service-load-cat-number"
               value="<?php echo esc_attr(kando_get_option('service-load-cat-number', 20)); ?>">
    </div>
    <hr>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Enable the new tag for new services (for 7 days)', SAMYAR_TEXT_DOMAIN); ?></label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-new-tag-service" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-new-tag-service" value="1" <?php echo checked(kando_get_option('enable-new-tag-service', 1), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
        </div>

    </div>
</div>