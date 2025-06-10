<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );
$dashboard_image = $options->get_option( 'dashboard-image',SAMYAR_DIR_IMG.'/dashboard-welcome.png');
if ( isset( $dashboard_image ) && ! empty( $dashboard_image ) && is_numeric( $dashboard_image ) ) {
	$dashboard_image = wp_get_attachment_url( $dashboard_image );
}
?>
<div class="samyar-settings-area samyar-settings-dashboard">

	<h3 class="samyar-settings-title">
		<span class="samyar-title-icon"><span uk-icon="settings"></span></span>
		<strong>پیشخوان</strong>
	</h3>

    <?php
    $select_user_panel = $options->get_option('select_user_panel','panel2');
    ?>
    <div class="uk-margin">
        <label class="uk-form-label">انتخاب قالب داشبرد برای کاربر</label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="select_user_panel">
                <option <?php if ($select_user_panel === "panel1"): ?> selected <?php endif; ?> value="panel1">پنل کاربری 1 (منو افقی)</option>
                <option <?php if ($select_user_panel === "panel2"): ?> selected <?php endif; ?> value="panel2">پنل کاربری 2 (منو عمودی)</option>
                <?php do_action('select_user_panel_option',$select_user_panel) ?>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>
    <?php
    $select_admin_panel = $options->get_option('select_admin_panel',$select_user_panel);
    ?>
    <div class="uk-margin">
        <label class="uk-form-label">انتخاب قالب داشبرد برای مدیر</label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="select_admin_panel">
                <option <?php if ($select_admin_panel === "panel1"): ?> selected <?php endif; ?> value="panel1">پنل کاربری 1 (منو افقی)</option>
                <option <?php if ($select_admin_panel === "panel2"): ?> selected <?php endif; ?> value="panel2">پنل کاربری 2 (منو عمودی)</option>
                <?php do_action('select_admin_panel_option',$select_admin_panel) ?>
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
            <label class="uk-form-label">فعالسازی خوش آمد گویی</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-welcome" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-welcome" value="1" <?php echo checked( $options->get_option( 'enable-welcome',1), 1 ); ?>>فعال</label>
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label">تصویر خوش آمدگویی</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="dashboard-image" value="<?php echo esc_attr( $dashboard_image ); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-dashboard-image" readonly value="<?php echo esc_attr( $dashboard_image ); ?>">
                    <a href="#" class="samyar-remove" data-toggle="dashboard-image" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr( $dashboard_image ); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                uk-icon="link"></a>
                </div>
            </div>
        </div>
		<div class="uk-margin">
			<label class="uk-form-label" for="samyar-welcome-title">عنوان پیامک خوش آمد گویی</label>
			<input type="text" class="uk-input" id="samyar-website-title" name="welcome-title" value="<?php echo esc_attr($options->get_option( 'welcome-title',"به پنل کاربری <span>کندو پنل</span> خوش آمدید!")); ?>">
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="samyar-welcome-content">متن خوش آمد گویی</label>
            <?php wp_editor($options->get_option( 'welcome-content',"شما می توانید در این بخش سفارش ثبت کنید و همچنین مشکلات خودتان را از طریق تیکت به ما منتقل نمایید"),'welcome-content'); ?>
		</div>

        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی نمایش میزان هزینه کاربر در داشبرد</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-show-cost-user" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-show-cost-user" value="1" <?php echo checked( $options->get_option( 'enable-show-cost-user',1), 1 ); ?>>فعال</label>
            </div>

        </div>


        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی ذخیره آپدیت ها</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-show-updates-menu" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-show-updates-menu" value="1" <?php echo checked( $options->get_option( 'enable-show-updates-menu',1), 1 ); ?>>فعال</label>
            </div>

        </div>

	</div>
</div>