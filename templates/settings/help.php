<?php defined('ABSPATH') || exit('No Access!'); ?>
<div class="samyar-settings-area samyar-settings-help">
    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="lifesaver"></span></span>
        <strong><?php _e('Help', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <style>
        .uk-accordion-title{
            font-size: .9rem;
            text-decoration: auto;
        }
        ul.uk-accordion li {
            border: 1px solid #e5eaf7;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
    <div class="samyar-other-products">

        <ul uk-accordion>

            <li>
                <a class="uk-accordion-title" href="#">مستندات کندوپنل</a>
                <div class="uk-accordion-content">
                    <p>آموزش کامل کار با قالب کندوپنل رو می تونید در لینک زیر مشاهده کنید</p>
                    <p><a target="" href="https://wp-bazar.com/kandopanel-document/">مستندات کندوپنل</a></p>
                </div>
            </li>
            <li>
                <a class="uk-accordion-title" href="#">شورتکدهای قالب چی هستن؟</a>
                <div class="uk-accordion-content">
                    <ul>
                        <li>شورتکد [send_order_wizard] برای ثبت سفارش چند مرحله ای</li>
                        <li>شورتکد [send_order_form] برای افزودن فرم سفارش در هر مکانی</li>
                        <li>شورتکد [orders_list] برای افزودن فرم دریافت لیست سفارشات در هر مکانی</li>
                        <li>شورتکد [samyar_services_list] برای نمایش لیست همه سرویس ها</li>
                        <li>شورتکد [samyar_services cat=150] برای نمایش لیست سرویس ها به صورت انتخاب دسته(عدد 150 مثال هست و باید شناسه دسته را جایگزین 150 کنید)</li>
                        <li>&nbsp;شورتکد [show_user_total] برای نمایش تعداد کاربران سایت</li>
                        <li>شورتکد [show_orders_total] برای نمایش تعداد سفارش های کامل شده سایت</li>
                        <li>شورتکد [show_answered_tickets_total] برای نمایش تعداد تیکت های بسته شده سایت</li>
                        <li>شورتکد [show_services_total] برای نمایش تعداد سرویس های فعال سایت</li>
                        <li>شورتکد [show_user_credit] برای نمایش اعتبار کاربر</li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="uk-accordion-title" href="#">بعد از ویرایش فوتر هدر من ناپدید شد. چطور درستش کنم؟</a>
                <div class="uk-accordion-content">
                    <p>برای حل این مورد به ویرایش فوتر مراجعه کنید و بر روی کنار دکمه ذخیره یک فلش وجود داره بر روی فلش کنارش بزنید و سپس بر روی شرایط نمایش (conditions) برید و شروط نمایش رو همگی حذف کنید و ذخیره کنید و کلا برای ذخیره فوتر لازم نیست شرطی قرار بدین و فقط ذخیره کنید</p>
                </div>
            </li>
            <li>
                <a class="uk-accordion-title" href="#">به ویرایش المنتور میرم و هر چی منتظر می مونم صفحه ویرایش باز نمیشه، چیکار کنم؟</a>
                <div class="uk-accordion-content">
                    <p>برای این مورد ابتدا در بخش تنظیمات کندوپنل -> عمومی ->پیشوند در لینک api سایت شما مطمئن بشید که حتما چیزی وارد شده باشه سپس در منوی وردپرس به تنظیمات -> پیوندهای یکتا برید و بر روی دکمه ذخیره بزنید تا لینک ها بازسازی بشن و می بینید که مشکل شما برطرف میشه</p>
                </div>
            </li>
            <li>
                <a class="uk-accordion-title" href="#">من می خوام به کاربر یک لینک بدم که به محض کلیک بر روی لینک فقط نیاز باشه روی پرداخت بزنه و پرداخت کنه، چطور انجامش بدم؟</a>
                <div class="uk-accordion-content">
                    <p>برای این مورد فقط کافیه لینک رو به صورت زیر تنظیم کنید وبهش بدین</p>
                    <ul>
                        <li dir="ltr" style="text-align: left">
                            <?php echo htmlentities('https://yoursite.ir/dashboard/?action=orders&section=new&cat_id=1&service_id=10&link=https://instagram.com/farstheme/&quantity=1000'); ?>
                        </li>
                    </ul>
                    <p>به جای https://yoursite.ir آدرس سایت خودتون رو قرار بدین</p>
                    <p>به جای cat_id شناسه دسته قرار بدین</p>
                    <p>به جای service_id شناسه سرویس قرار بدین</p>
                    <p>به جای link لینک مورد نظر کاربر قرار بدین</p>
                    <p>به جای quantity تعداد مورد نظر کاربر قرار بدین</p>
                </div>
            </li>
        </ul>

    </div>
</div>