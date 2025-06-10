<?php
defined('ABSPATH') || exit('No Access!');
$dashboard_image = kando_get_option('dashboard-image', SAMYAR_DIR_IMG . '/dashboard-welcome.png');
if (isset($dashboard_image) && !empty($dashboard_image) && is_numeric($dashboard_image)) {
    $dashboard_image = wp_get_attachment_url($dashboard_image);
}
?>
<div class="samyar-settings-area samyar-settings-dashboard">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong><?php _e('Dashboard', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <?php
    $select_user_panel = kando_get_option('select_user_panel', 'panel2');
    ?>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Select Dashboard Template for Users', SAMYAR_TEXT_DOMAIN); ?></label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="select_user_panel">
                <option <?php if ($select_user_panel === "panel1"): ?> selected <?php endif; ?> value="panel1"><?php _e('User Panel 1 (Horizontal Menu)', SAMYAR_TEXT_DOMAIN); ?></option>
                <option <?php if ($select_user_panel === "panel2"): ?> selected <?php endif; ?> value="panel2"><?php _e('User Panel 2 (Vertical Menu)', SAMYAR_TEXT_DOMAIN); ?></option>
                <?php do_action('select_user_panel_option', $select_user_panel); ?>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>
    <?php
    $select_admin_panel = kando_get_option('select_admin_panel', $select_user_panel);
    ?>
    <div class="uk-margin">
        <label class="uk-form-label"><?php _e('Select Dashboard Template for Admin', SAMYAR_TEXT_DOMAIN); ?></label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="select_admin_panel">
                <option <?php if ($select_admin_panel === "panel1"): ?> selected <?php endif; ?> value="panel1"><?php _e('User Panel 1 (Horizontal Menu)', SAMYAR_TEXT_DOMAIN); ?></option>
                <option <?php if ($select_admin_panel === "panel2"): ?> selected <?php endif; ?> value="panel2"><?php _e('User Panel 2 (Vertical Menu)', SAMYAR_TEXT_DOMAIN); ?></option>
                <?php do_action('select_admin_panel_option', $select_admin_panel); ?>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>

    <?php
    do_action('kando_after_select_dashboard');
    ?>

    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Enable Welcome Message', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-welcome" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-welcome" value="1" <?php echo checked(kando_get_option('enable-welcome', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Welcome Image', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="dashboard-image" value="<?php echo esc_attr($dashboard_image); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-dashboard-image" readonly value="<?php echo esc_attr($dashboard_image); ?>">
                    <a href="#" class="samyar-remove" data-toggle="dashboard-image" uk-tooltip="title: <?php _e('Delete', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($dashboard_image); ?>" class="samyar-url" uk-tooltip="title: <?php _e('View', SAMYAR_TEXT_DOMAIN); ?>" target="_blank"><span uk-icon="link"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-welcome-title"><?php _e('Welcome Message Title', SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-website-title" name="welcome-title" value="<?php echo esc_attr(kando_get_option('welcome-title', __('Welcome to <span>Kando Panel</span> User Panel!', SAMYAR_TEXT_DOMAIN))); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-welcome-content"><?php _e('Welcome Message Content', SAMYAR_TEXT_DOMAIN); ?></label>
            <?php wp_editor(kando_get_option('welcome-content', __('You can place orders in this section and also submit your issues through tickets.', SAMYAR_TEXT_DOMAIN)), 'welcome-content'); ?>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Enable Display of User Costs in Dashboard', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-show-cost-user" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-show-cost-user" value="1" <?php echo checked(kando_get_option('enable-show-cost-user', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Enable Saving Updates', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-show-updates-menu" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-show-updates-menu" value="1" <?php echo checked(kando_get_option('enable-show-updates-menu', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></label>
            </div>
        </div>
    </div>
</div>