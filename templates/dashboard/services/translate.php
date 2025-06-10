<div class="kt-row">
    <?php
    $enable_switch_language = kando_get_option('enable-switch-language', 0);

    if ($enable_switch_language == '1') {
        $base_language = kando_get_option('base-language', 'fa_IR');
        $current_user_id = get_current_user_id();
        $current_language = kando_get_user_language();

        if (!$current_language) {
            $current_language = 'fa_IR';
        }

        [$current_language, $current_country] = explode('_', $current_language);
        $languages = kando_get_available_languages();
        ?>

        <div class="column kt-col-xs-12 kt-col-md-12 mb-3 mt-3 dashboard-notifications">
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_globe"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Translate", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list dashboard-notifications-items">
                    <?php foreach ($languages as $lang_code => $lang_name) {
                        // حذف زبان پایه از لیست
                        if ($lang_code === $base_language) {
                            continue;
                        }
                        [$language, $country] = explode('_', $lang_code);
                        $country_lowercase = strtolower($country);
                        ?>
                        <div class="alert alert-light" id="<?php echo esc_html($country_lowercase); ?>">
                        <span class="text-dark btn-toggler"
                              data-id="alert_<?php echo esc_html($country_lowercase); ?>">
                            <i class="fi flag-icon-squared fi-<?php echo esc_html($country_lowercase); ?> fis"></i>
                            <?php echo esc_html($lang_name); ?>
                        </span>
                            <div class="hide" id="alert_<?php echo esc_html($country_lowercase); ?>">
                                <div class="">
                                    <label><?php _e('Title', SAMYAR_TEXT_DOMAIN) ?></label>
                                    <input type="text" name="translation[<?php echo esc_attr($lang_code); ?>][title]" value="" placeholder="">
                                </div>

                                <div class="">
                                    <label><?php _e('Description', SAMYAR_TEXT_DOMAIN) ?></label>
                                    <textarea name="translation[<?php echo esc_attr($lang_code); ?>][description]" placeholder=""></textarea>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>