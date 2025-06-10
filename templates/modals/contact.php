<?php

$site_logo = $options->get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = $options->get_option('site-logo');
    $site_logo = wp_get_attachment_url($site_logo);
}
$website_title = $options->get_option('website-title', get_option('blogname'));
$support_phone = $options->get_option('support-phone');
$support_email = $options->get_option('support-email');
$start_working_hours = $options->get_option('start-working-hours');
$end_working_hours = $options->get_option('end-working-hours');
$now_hour = date_i18n('H');
?>
<div class="kt-modal-inner kt-contact-modal">
    <i class="kt-modal-close"></i>
    <div class="kt-modal-content">

        <div class="modal-contact-right">
            <div class="modal-contact-logo">
                <?php if (!empty($site_logo)): ?>
                    <img class="logo" src="<?= $site_logo ?>" alt="<?= get_bloginfo('name') ?>"/>
                <?php endif; ?>
            </div>
            <h3 class="modal-contact-brand"><?= get_bloginfo('name') ?></h3>
            <?php if ($start_working_hours <= $now_hour && $now_hour <= $end_working_hours): ?>
                <div class="modal-contact-online">
                    الان در دفتر هستیم.<br/> با ما تماس بگیرید.
                </div>
            <?php else: ?>
                <div class="modal-contact-online">
                    الان در دفتر نیستیم.<br/> ولی می تونید در خواست ارسال کنید.
                </div>
            <?php endif; ?>
            <div class="modal-contact-bottom">
                <div class="kt-col-xs-12 kt-col-md-12">
                    <span class="modal-contact-bottom-title">شماره تماس</span>
                </div>
                <div class="kt-col-xs-12 kt-col-md-12">
                    <span class="modal-contact-bottom-text"><?= $support_phone ?></span>
                </div>

                <div class="kt-col-xs-12 kt-col-md-12">
                    <span class="modal-contact-bottom-title">پست الکترونیکی</span>
                </div>
                <div class="kt-col-xs-12 kt-col-md-12">
                    <span class="modal-contact-bottom-text"><?= $support_email ?></span>
                </div>

            </div>
        </div>

        <div class="modal-contact-left">
            <div class="modal-contact-title">درخواست تماس</div>
            <div class="modal-contact-subtitle">لطفا اطلاعات تماس خود را وارد نمایید.</div>
            <form class="modal-contact-form clearfix">
                <div class="modal-contact-form-errors"></div>
                <input type="text" class="modal-contact-form-name" placeholder="نام و نام خانوادگی"/>
                <input type="tell" class="modal-contact-form-phone" placeholder="شماره تماس"/>
                <input type="email" class="modal-contact-form-email" placeholder="پست الکترونیکی (اختیاری)"/>
                <input type="text" class="modal-contact-form-website" placeholder="آدرس وبسایت (اختیاری)"/>


                <input type="text" class="modal-contact-form-subject clearfix" placeholder="زمینه مشاوره (اختیاری)"/>

                <button class="button button-default modal-contact-form-submit kt-ajax-button">ثبت درخواست
                </button>
            </form>

        </div>

    </div>
</div>