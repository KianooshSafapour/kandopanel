<?php
defined('ABSPATH') || exit('No Access!');


$site_favicon = $options->get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = $options->get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}


$site_logo = $options->get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = $options->get_option('site-logo');
    $site_logo = wp_get_attachment_url($site_logo);
}


$site_mobile_logo = $options->get_option('site-mobile-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_mobile_logo) && !empty($site_mobile_logo) && is_numeric($site_mobile_logo)) {
    $site_mobile_logo = $options->get_option('site-mobile-logo');
    $site_mobile_logo = wp_get_attachment_url($site_mobile_logo);
}
?>
<div class="samyar-settings-area samyar-settings-general">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong>عمومی</strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی عنوان سایت در هدر (کنار لوگو)</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-site-title" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-site-title" value="1" <?php echo checked( $options->get_option( 'enable-site-title',1), 1 ); ?>>فعال</label>
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-support-phone">شماره تماس پشتیبانی</label>
            <input type="text" class="uk-input" id="samyar-support-phone" name="support-phone" value="<?php echo esc_attr($options->get_option('support-phone', "")); ?>">
        </div>
        <!--
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-default-title">عنوان سایت</label>
            <input type="text" class="uk-input" id="samyar-website-title" name="website-title" value="<?php echo esc_attr($options->get_option('website-title', "")); ?>">
        </div>



        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-support-email">ایمیل پشتیبانی</label>
            <input type="text" class="uk-input" id="samyar-support-email" name="support-email" value="<?php echo esc_attr($options->get_option('support-email', "")); ?>">
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-start-working-hours">ساعات کاری</label>
            <input type="text" class="uk-input" id="samyar-start-working-hours" name="start-working-hours" placeholder="شروع از ساعت"
                   value="<?php echo esc_attr($options->get_option('start-working-hours', "")); ?>">
            <div class="uk-margin">
                <input type="text" class="uk-input" id="samyar-end-working-hours" name="end-working-hours" placeholder="تا ساعت"
                       value="<?php echo esc_attr($options->get_option('end-working-hours', "")); ?>">
            </div>
        </div>
        -->
        <!--        <div class="uk-margin">-->
        <!--            <label class="uk-form-label" for="samyar-popup-default-content">شعار سایت</label>-->
        <!--            <input type="text" class="uk-input" id="samyar-popup-default-content" name="popup-default-content" value="-->
        <?php //echo esc_attr( $options->get_option( 'popup-default-content',"") ); ?><!--">-->
        <!--        </div>-->
        <div class="uk-margin">
            <label class="uk-form-label">نشانک</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-favicon" value="<?php echo esc_attr($site_favicon); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-site-favicon" readonly value="<?php echo esc_attr($site_favicon); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-favicon" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($site_favicon); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                uk-icon="link"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label">لوگو سایت</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-logo" value="<?php echo esc_attr($site_logo); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-site-logo" readonly value="<?php echo esc_attr($site_logo); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-logo" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($site_logo); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                uk-icon="link"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label">لوگو موبایل</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input type="hidden" name="site-mobile-logo" value="<?php echo esc_attr($site_mobile_logo); ?>">
                    <input type="text" class="samyar-upload-file uk-input" dir="ltr" id="samyar-site-mobile-logo" readonly value="<?php echo esc_attr($site_mobile_logo); ?>">
                    <a href="#" class="samyar-remove" data-toggle="site-mobile-logo" uk-tooltip="title: حذف"><span uk-icon="trash"></a>
                    <a href="<?php echo esc_attr($site_mobile_logo); ?>" class="samyar-url" uk-tooltip="title: مشاهده" target="_blank"><span
                                uk-icon="link"></a>
                </div>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label">شبکه های اجتماعی سایت</label>
        </div>
        <div class="uk-margin">
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title">اینستاگرام</label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-instagram-url" name="instagram-url" value="<?php echo esc_attr($options->get_option('instagram-url', "")); ?>">
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title">تلگرام</label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-telegram-url" name="telegram-url" value="<?php echo esc_attr($options->get_option('telegram-url', "")); ?>">
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title">توییتر</label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-twitter-url" name="twitter-url" value="<?php echo esc_attr($options->get_option('twitter-url', "")); ?>">
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="samyar-popup-default-title">لینکدین</label>
                <input type="text" class="uk-input" dir="ltr" id="samyar-linkedin-url" name="linkedin-url" value="<?php echo esc_attr($options->get_option('linkedin-url', "")); ?>">
            </div>
        </div>

        <?php
        $samyar_header = $options->get_option('samyar-header', 0);
        $headers = kando_get_header_list();
        ?>
        <div class="uk-margin">
            <label class="uk-form-label">انتخاب سربرگ(سربرگ های ساخته شده هدرساز)</label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="samyar-header">
<!--                    <option --><?php //if ($samyar_header == 0): ?><!-- selected --><?php //endif; ?><!-- value="0">هیچ کدام</option>-->
                    <?php foreach ($headers as $key=>$header): ?>
                        <option value="<?= $key ?>" <?php selected( $samyar_header, $key ); ?>><?= $header ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>


        <?php
        $samyar_footer = $options->get_option('samyar-footer', 0);
        $footers = kando_get_footer_list();
        ?>
        <div class="uk-margin">
            <label class="uk-form-label">انتخاب فوتر(فوتر های ساخته شده با فوتر ساز)</label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="samyar-footer">
<!--                    <option --><?php //if ($samyar_footer == 0): ?><!-- selected --><?php //endif; ?><!-- value="0">هیچ کدام</option>-->
                    <?php foreach ($footers as $key=>$footer): ?>
                        <option value="<?= $key ?>" <?php selected( $samyar_footer, $key ); ?>><?= $footer ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-copyright">متن کپی رایت</label>
            <input type="text" class="uk-input" id="samyar-copyright" name="copyright" value="<?php echo esc_attr($options->get_option('copyright', "تمامی حقوق مادی و معنوی این وبسایت متعلق به <a href=\"http://127.0.0.1/kandopanel\" data-wpel-link=\"internal\">کندو پنل</a> می باشد و هر گونه کپی برداری پیگرد قانونی دارد.")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-index-title">عنوان در صفحه اصلی پیشفرض قالب</label>
            <input type="text" class="uk-input" id="samyar-index-title" name="index-title" value="<?php echo esc_attr($options->get_option('index-title', " فروشگاه خدمات شبکه های اجتماعی کندوپنل ")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-index-content">توضیحات در صفحه اصلی پیشفرض قالب</label>
            <input type="text" class="uk-input" id="samyar-index-content" name="index-content" value="<?php echo esc_attr($options->get_option('index-content', " حساب شبکه های اجتماعی شما می‌تواند رشد کند. درآمد شما می‌تواند چند برابر شود. فقط کافی است مسیر درست را بشناسید. کافی است از خدمات مناسب در مکان مناسب استفاده نمایید. ما در این مسیر همراه شما هستیم. ")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-url-api-slug">پیشوند در لینک api سایت شما</label>
            <input type="text" dir="ltr" class="uk-input" id="samyar-url-api-slug" name="url-api-slug" value="<?php echo esc_attr($options->get_option('url-api-slug', "kando")); ?>">
            <strong style="color:#f0506e"><b>توجه</b>: بعد از تغییر این عبارت، از پیشخوان وردپرس به منوی <b>تنظیمات->پیوندهای یکتا</b> وارد شوید و بدون تغییر، دکمه ذخیره را بزنید تا لینک جدید باز تولید شود.(اگر انجام ندین صفحه ساز المنتور به مشکل می خوره)</strong>

            <div class="uk-alert-danger" uk-alert>
                این عبارت در لینک api شما قرار خواهد گرفت مثال: yoursite.ir/<b>kando</b>/api/v1
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی منوی کاربری مخصوص موبایل</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-mobile-menu" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-mobile-menu" value="1" <?php echo checked( $options->get_option( 'enable-mobile-menu',1), 1 ); ?>>فعال</label>
            </div>

        </div>


        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی شمسی ساز(تبدیل همه تاریخ ها به شمسی)</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-jalali-date" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-jalali-date" value="1" <?php echo checked( $options->get_option( 'enable-jalali-date',1), 1 ); ?>>فعال</label>
            </div>

        </div>


        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی آپلود ضمیمه ها در رسانه های وردپرس</label>
            <div class="uk-alert-danger" uk-alert>
                در حالت پیشفرض رسانه ها(تصاویر و ضمیمه های تیکت)در پوشه مخصوص که برای قالب در نظر گرفته شده آپلود میشوند ولی شما با فعال سازی این مورد می توانید کاری کنید که در رسانه های وردپرس اضافه شده تا بتوانید آنها رو مدیریت کنید. اگر اطلاعی در این مورد ندارید به صورت غیر فعال قرار دهید
            </div>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-upload-wp-media" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-upload-wp-media" value="1" <?php echo checked( $options->get_option( 'enable-upload-wp-media',0), 1 ); ?>>فعال</label>
            </div>

        </div>

        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی کش یک ساعته برای کش سرویس ها برای api</label>
            <div class="uk-alert-danger" uk-alert>
               لیست سرویس ها رو برای کاربرانی که از طریق api به سایت شما درخواست ارسال میکنند به مدت 1 ساعت کش خواهند شد<br>دلیل این کار این هست که درخواست های مکرر کاربران باعث بالاتر رفتن منابع سرور شما میکند و با این کار بار روی سرور را کاهش خواهید داد و از کند شدن سایت خود جلوگیری می کنید
            </div>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-cached-api-services" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-cached-api-services" value="1" <?php echo checked( $options->get_option( 'enable-cached-api-services',0), 1 ); ?>>فعال</label>
            </div>

        </div>


        <?php
        $languages = kando_get_available_languages();
        $base_language = $options->get_option( 'base-language','fa_IR');
        ?>
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e( 'Please select Base Language.', SAMYAR_TEXT_DOMAIN ); ?></label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="base-language" class="base-language">
                    <option value=""><?php _e( 'Please select item.', SAMYAR_TEXT_DOMAIN ); ?></option>
                    <?php foreach ($languages as $lang_code => $lang_name){ ?>
                        <option value="<?php echo esc_attr($lang_code) ?>" <?php selected( $base_language, $lang_code ); ?>><?php echo $lang_name ?></option>
                    <?php } ?>

                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی تغییر زبان توسط کاربر(اگر فعال باشد کاربر می تواند زبان را تغییر دهد و پنل کاربری رو با زبان دلخواه ببینه)</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-switch-language" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-switch-language" value="1" <?php echo checked( $options->get_option( 'enable-switch-language',0), 1 ); ?>>فعال</label>
            </div>

        </div>
<hr>
        <div class="uk-margin">
            <label class="uk-form-label">در لیست برندها تنها لوگو ها نمایش داده شود(عنوان ها مخفی می شود)</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-only-logo-brand" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-only-logo-brand" value="1" <?php echo checked( $options->get_option( 'enable-only-logo-brand',0), 1 ); ?>>فعال</label>
            </div>

        </div>
    </div>
</div>