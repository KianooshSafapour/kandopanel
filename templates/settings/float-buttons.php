<?php
$kando_float_buttons = kando_get_option('kando-float-buttons');
$kando_float_buttons = is_array($kando_float_buttons) ? $kando_float_buttons : [];
?>
<div class="samyar-settings-area samyar-settings-float-buttons">
    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="refresh"></span></span>
        <strong><?php _e('Float Buttons Settings', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <div class="uk-margin">
        <div class="samyar-itemm uk-margin">
            <?php if (count($kando_float_buttons)): ?>
                <?php foreach ($kando_float_buttons as $key => $item): ?>
                    <?php
                    $id = $item['id'] ?? uniqid();
                    $title = $item['title'] ?? '';
                    $url = $item['url'] ?? '';
                    $icon = $item['icon'] ?? '';
                    $hover_color = $item['hover_color'] ?? 'green';
                    ?>
                    <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="margin: 15px 0;">
                        <div class="samyar-float-button-item samyar-item uk-margin">
                            <div class="samyar-actions">
                                <span class="remove" uk-icon="close"
                                      uk-tooltip="title: <?php esc_attr_e('Delete', SAMYAR_TEXT_DOMAIN); ?>"></span>
                            </div>
                            <input type="hidden" name="kando-float-buttons[<?php echo $key; ?>][id]"
                                   value="<?php echo esc_attr($id); ?>">

                            <div class="uk-margin-small">
                                <label class="uk-form-label"><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></label>
                                <input type="text" class="uk-input"
                                       name="kando-float-buttons[<?php echo $key; ?>][title]"
                                       value="<?php echo esc_attr($title); ?>"
                                       placeholder="<?php esc_attr_e('Button title', SAMYAR_TEXT_DOMAIN); ?>">
                            </div>

                            <div class="uk-margin-small">
                                <label class="uk-form-label"><?php _e('URL', SAMYAR_TEXT_DOMAIN); ?></label>
                                <input type="url" class="uk-input"
                                       name="kando-float-buttons[<?php echo $key; ?>][url]"
                                       value="<?php echo esc_attr($url); ?>"
                                       placeholder="<?php esc_attr_e('Button URL', SAMYAR_TEXT_DOMAIN); ?>">
                            </div>

                            <?php
                            if (isset($icon) && !empty($icon) && is_numeric($icon)) {
                                $icon = wp_get_attachment_url($icon);
                            }
                            ?>
                            <div class="uk-margin-small">
                                <label class="uk-form-label"><?php _e("image", SAMYAR_TEXT_DOMAIN); ?></label>
                                <div class="uk-margin-small">
                                    <div class="samyar-upload-file-wrapper">
                                        <input type="hidden" name="kando-float-buttons[<?php echo $key; ?>][icon]" value="<?php echo esc_attr($icon); ?>">
                                        <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-button-logo" readonly value="<?php echo esc_attr($icon); ?>">
                                        <a href="#" class="samyar-remove" data-toggle="button-logo" uk-tooltip="title: <?php _e("Delete", SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="trash"></a>
                                        <a href="<?php echo esc_attr($icon); ?>" class="samyar-url" uk-tooltip="title: <?php _e("View", SAMYAR_TEXT_DOMAIN); ?>" target="_blank"><span uk-icon="link"></a>
                                    </div>
                                </div>
                            </div>



                            <div class="uk-margin-small">
                                <label class="uk-form-label"><?php _e('Hover Color', SAMYAR_TEXT_DOMAIN); ?></label>
                                <div uk-form-custom="target: > * > span:first-child">
                                    <select name="kando-float-buttons[<?php echo $key; ?>][hover_color]">
                                        <option value="green" <?php selected($hover_color, 'green'); ?>><?php _e('Green', SAMYAR_TEXT_DOMAIN); ?></option>
                                        <option value="blue" <?php selected($hover_color, 'blue'); ?>><?php _e('Blue', SAMYAR_TEXT_DOMAIN); ?></option>
                                        <option value="violet" <?php selected($hover_color, 'violet'); ?>><?php _e('Violet', SAMYAR_TEXT_DOMAIN); ?></option>
                                        <option value="orange" <?php selected($hover_color, 'orange'); ?>><?php _e('Orange', SAMYAR_TEXT_DOMAIN); ?></option>
                                        <option value="red" <?php selected($hover_color, 'red'); ?>><?php _e('Red', SAMYAR_TEXT_DOMAIN); ?></option>
                                    </select>

                                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                                        <span></span>
                                        <span uk-icon="icon: chevron-down"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <a href="#"
               class="samyar-new-float-button uk-button uk-button-default uk-button-small"><?php _e('New button', SAMYAR_TEXT_DOMAIN); ?></a>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        // Template for new float button item
        const floatButtonTemplate = (key, id) => `
        <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="margin: 15px 0;">
            <div class="samyar-float-button-item samyar-item uk-margin">
                <div class="samyar-actions">
                    <span class="remove" uk-icon="close" uk-tooltip="title: ${kando_data.langs.delete_tooltip}"></span>
                </div>
                <input type="hidden" name="kando-float-buttons[${key}][id]" value="${id}">

                <div class="uk-margin-small">
                    <label class="uk-form-label">${kando_data.langs.title_label}</label>
                    <input type="text" class="uk-input" name="kando-float-buttons[${key}][title]" value="" placeholder="${kando_data.langs.title_label}">
                </div>

                <div class="uk-margin-small">
                    <label class="uk-form-label">${kando_data.langs.url_label}</label>
                    <input type="url" class="uk-input" name="kando-float-buttons[${key}][url]" value="" placeholder="${kando_data.langs.url_label}">
                </div>

        <div class="uk-margin">
            <label class="uk-form-label">${kando_data.langs.icon_label}</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="kando-float-buttons[${key}][icon]" value="">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-button-logo" readonly value="">
                    <a href="#" class="samyar-remove" data-toggle="button-logo" uk-tooltip="title: ${kando_data.langs.Delete}"><span uk-icon="trash"></a>
                    <a href="" class="samyar-url" uk-tooltip="title: ${kando_data.langs.view}" target="_blank"><span uk-icon="link"></a>
                </div>
            </div>
        </div>



                <div class="uk-margin-small">
                    <label class="uk-form-label">${kando_data.langs.hover_color_label}</label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="kando-float-buttons[${key}][hover_color]">
                        <option value="green">${kando_data.langs.green}</option>
                        <option value="blue">${kando_data.langs.blue}</option>
                        <option value="violet">${kando_data.langs.violet}</option>
                        <option value="orange">${kando_data.langs.orange}</option>
                        <option value="red">${kando_data.langs.red}</option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

        // Add new float button
        $(document).on('click', '.samyar-new-float-button', function (e) {
            e.preventDefault();
            const $key = Math.floor((Math.random() * 1000000000));
            const $id = 'float-btn-' + Math.floor((Math.random() * 1000000));

            const $html = floatButtonTemplate($key, $id);
            $(this).before($html);

        });

    });
</script>