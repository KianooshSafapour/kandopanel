<?php
defined('ABSPATH') || exit('No Access!');
$dashboard_image = $options->get_option('dashboard-image', SAMYAR_DIR_IMG . '/dashboard-welcome.png');
if (isset($dashboard_image) && !empty($dashboard_image) && is_numeric($dashboard_image)) {
    $dashboard_image = wp_get_attachment_url($dashboard_image);
}
?>
<div class="samyar-settings-area samyar-settings-order">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong>سفارش</strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p>اگر این گزینه رو فعال کنید کاربر برای ارسال سفارش باید ابتدا کیف پول خود را شارژ نماید.</p>
            <p><b>قابل توجه: این مورد تنها برای کاربران وارد شده به حساب ، لحاظ خواهد شد.</b></p>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی شارژ کیف پول قبل از ارسال سفارش</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-wallet-charge" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-wallet-charge" value="1" <?php echo checked($options->get_option('enable-wallet-charge', 0), 1); ?>>فعال</label>
            </div>

        </div>
        <hr>
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی تایید سفارش</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-agree-order" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-agree-order" value="1" <?php echo checked($options->get_option('enable-agree-order', 1), 1); ?>>فعال</label>
            </div>

        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-agree-order-text">متن تایید سفارش</label>
            <input type="text" class="uk-input" id="samyar-agree-order-text" name="samyar-agree-order-text"
                   value="<?php echo esc_attr($options->get_option('samyar-agree-order-text', "من [term] را خوانده و با آن موافقم.")); ?>">
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-agree-order-link">لینک قوانین و مقررات برای تایید سفارش</label>
            <input type="text" class="uk-input" id="samyar-agree-order-link" name="samyar-agree-order-link" value="<?php echo esc_attr($options->get_option('samyar-agree-order-link', "")); ?>">
        </div>
        <hr>
        <div class="uk-alert-primary" uk-alert>
            <p>برای اینکه این قسمت به خوبی کار کند، نیاز دارد که شناسه سشن مربوط به یک حساب اینستاگرام(توصیه می کنیم که یک حساب جدید مخصوص این مورد بسازید) را در تنظیمات پایین وارد نمایید.</p>
            <p>برای این مورد، در مرورگر کروم به سایت اینستاگرام رفته و به حساب کاربری خود وارد شوید سپس طبق تصویر راهنمای زیر، شناسه سشن خود را بیابید و در بخش زیر وارد نمایید.</p>
            <p><a href="<?= SAMYAR_DIR_IMG ?>/document/link-proccess.gif" target="_blank">تصویر راهنما</a></p>
        </div>
        <!--
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی دکمه بررسی لینک در ارسال سفارش</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-process-link" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-process-link" value="1" <?php echo checked($options->get_option('enable-process-link', 0), 1); ?>>فعال</label>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="process-link-sessionid">سشن آیدی (sessionid)</label>
                <input type="text" class="uk-input" id="process-link-sessionid" name="process-link-sessionid"
                       value="<?php echo esc_attr($options->get_option('process-link-sessionid', "")); ?>">
            </div>
            <label class="uk-form-label">فعالسازی ذخیره اطلاعات از اینستاگرام در هنگام ثبت سفارش از روی لینک(تعداد دنبال کننده و دنبال شونده (برای پروفایل) و تعداد لایک،ویو،کامنت(برای پست))</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="save-link-info" value="0">
                    <input class="uk-checkbox" type="checkbox" name="save-link-info" value="1" <?php echo checked($options->get_option('save-link-info', 0), 1); ?>>فعال</label>
            </div>
        </div>
        -->
        <hr>
        <div class="uk-alert-primary" uk-alert>
            <p>اگر شما در تنظیمات 10 دقیقه را انتخاب نمایید به کاربر 10 دقیقه فرصت می دهید که سفارش خودش را لغو کند و در غیر اینصورت به ارائه دهنده ارسال می شود</p>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی تاخیر برای ارسال سفارش به ارائه دهنده</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="delay-sending-order" value="0">
                    <input class="uk-checkbox" type="checkbox" name="delay-sending-order" value="1" <?php echo checked($options->get_option('delay-sending-order', 0), 1); ?>>فعال</label>
            </div>

            <?php
            $delay_time_order = (int)$options->get_option('delay-time-order', 10);

            ?>
            <div class="uk-margin">
                <label class="uk-form-label">انتخاب زمان تاخیر</label>
                <div uk-form-custom="target: > * > span:first-child">
                    <select name="delay-time-order">
                        <option <?php if ($delay_time_order === 5): ?> selected <?php endif; ?> value="5">5 دقیقه</option>
                        <option <?php if ($delay_time_order === 10): ?> selected <?php endif; ?> value="10">10 دقیقه</option>
                        <option <?php if ($delay_time_order === 15): ?> selected <?php endif; ?> value="15">15 دقیقه</option>
                        <option <?php if ($delay_time_order === 20): ?> selected <?php endif; ?> value="20">20 دقیقه</option>
                        <option <?php if ($delay_time_order === 30): ?> selected <?php endif; ?> value="30">30 دقیقه</option>
                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>
            </div>


        </div>
        <hr>
        <div class="uk-margin">

            <div class="uk-alert-primary" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>از این بخش می توانید شروع شناسه سفارش ها را تعیین کنید</p>
                <p>مثلا شاید شما دوست داشته باشید که شناسه های سفارش شما از 10000 شروع شوند پس همین جا می تونی تنظیمش کنی</p>
                <p>کافیه عدد شروع رو وارد کنی و بر روی اعمال کن کلیک کنی</p>
            </div>


            <div class="uk-child-width-1-2 uk-text-center" uk-grid>
                <div>

                    <input type="text" class="uk-input" id="samyar-start-order-id" placeholder="عدد شروع را وارد نمایید" value="">

                </div>
                <div>
                    <div class="uk-child-width-1-2 uk-text-center" uk-grid>
                        <div>
                            <button class="uk-button uk-button-default" type="button" id="kando-set-start-order-id">اعمال کن</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="uk-margin">
                <label class="uk-form-label">فعالسازی ارسال سفارش انبوه</label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-send-order-mass" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-send-order-mass" value="1" <?php echo checked($options->get_option('enable-send-order-mass', 1), 1); ?>>فعال</label>
                </div>

            </div>

            <div class="uk-margin">
                <label class="uk-form-label">فعالسازی یادداشت برای مدیر در فرم ارسال سفارش<span class="new-option">(جدید)</span></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-note-for-admin" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-note-for-admin" value="1" <?php echo checked($options->get_option('enable-note-for-admin', 1), 1); ?>>فعال</label>
                </div>

            </div>

            <div class="uk-margin">
                <label class="uk-form-label">فعالسازی نمایش برندها فرم ارسال سفارش<span class="new-option">(جدید)</span></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-show-brands" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-show-brands" value="1" <?php echo checked($options->get_option('enable-show-brands', 1), 1); ?>>فعال</label>
                </div>

            </div>

            <div class="uk-margin">
                <div class="uk-alert-primary" uk-alert>
                    <p>اگر این گزینه فعال باشد کاربر اگر به طور مثال از سرویس لایک برای لینک پروفایلش سفارش ثبت کرد تا آن سفارش تکمیل نشده نمی تونه همین سرویس لایک رو مجددا برای همین لینک پروفایل استفاده کنه</p>
                </div>
                <label class="uk-form-label">فعالسازی جلوگیری از ارسال سفارش تکراری برای لینک یکسان<span class="new-option">(جدید)</span></label>
                <div class="uk-margin-small">
                    <label>
                        <input class="uk-checkbox" type="hidden" name="enable-sending-duplicate-order" value="0">
                        <input class="uk-checkbox" type="checkbox" name="enable-sending-duplicate-order" value="1" <?php echo checked($options->get_option('enable-sending-duplicate-order', 0), 1); ?>>فعال</label>
                </div>

            </div>
            <hr>
            <div class="uk-margin">

                <div class="uk-alert-primary" uk-alert>
                    در این بخش می توانید مشخص نمایید که اگر تعداد یا مبلغ سفارش از یک مقدار بالاتر بود به api ارسال نشده و منتظر اقدام شما بماند
                    <p>برای غیر فعال کردن کافی است خالی بگذارید و ذخیره کنید</p>
                </div>


                <div class="uk-margin">
                    <label class="uk-form-label" for="numbers-awaiting-action">حداکثر تعداد سفارش برای ارسال به api (اگر میخواهید اعمال نشود خالی بگذارید)</label>
                    <input type="number" step="100" class="uk-input" id="numbers-awaiting-action" name="numbers-awaiting-action" value="<?php echo esc_attr($options->get_option('numbers-awaiting-action', "")); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="price-awaiting-action">حداکثر مبلغ سفارش برای ارسال به api (اگر میخواهید اعمال نشود خالی بگذارید)</label>
                    <input type="number" step="100" class="uk-input" id="price-awaiting-action" name="price-awaiting-action" value="<?php echo esc_attr($options->get_option('price-awaiting-action', "")); ?>">
                </div>
                <hr>
            </div>
            <hr>
            <div class="uk-margin">

                <div class="uk-alert-primary" uk-alert>
                    در این بخش می تونید فعال کنید که کاربر قبل از ارسال سفارش رایگان باید حتما حسابش رو به مبلغ فلان شارژ کرده باشه
<!--                    <p>برای غیر فعال کردن کافی است خالی بگذارید و ذخیره کنید</p>-->
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">فعالسازی شارژ قبل از ارسال سفارش رایگان<span class="new-option">(جدید)</span></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="charge-before-free-order" value="0">
                            <input class="uk-checkbox" type="checkbox" name="charge-before-free-order" value="1" <?php echo checked($options->get_option('charge-before-free-order', 0), 1); ?>>فعال</label>
                    </div>

                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="numbers-awaiting-action">مبلغ را در این بخش وارد نمایید</label>
                    <input type="number" step="100" class="uk-input" id="charge-before-free-order-price" name="charge-before-free-order-price" value="<?php echo esc_attr($options->get_option('charge-before-free-order-price', "")); ?>">
                </div>
                <hr>
            </div>
            <hr>
            <div class="uk-margin">

                <div class="uk-alert-primary" uk-alert>
                    در این بخش می توانید میزان هدیه ای برای کاربر مشخص نمایید
                    <p>مثال: اگر کاربری درخواست تعداد 1000 فالوور داشت و شما در این بخش بر روی 20 درصد مشخص نمایید تعداد 1200 فالوور به api ارسال خواهد شد.</p>
                    <p>توجه: این مورد بر روی برخی سرویس های با نوع خاص(custom_comments,mentions_custom_list,mentions,package) اجرا نمی شود چون باعث</p>
                </div>


                <div class="uk-margin">
                    <label class="uk-form-label" for="gift-percent-quantity">درصد هدیه مورد نظر را وارد نمایید(تنها عدد)</label>
                    <input type="number" min="0" max="100" class="uk-input" id="gift-percent-quantity" name="gift-percent-quantity" value="<?php echo esc_attr($options->get_option('gift-percent-quantity', "")); ?>">
                </div>
                <hr>
            </div>
            <hr>
            <div class="uk-alert-primary" uk-alert>
                این زمان برای محدودیت در ارسال پر کردن مجدد هست
                <p>اگر مثلا بر روی 1 ماه بزارید کاربر تا 30 روز پس از ثبت سفارش امکان پر کردن مجدد خواهد داشت </p>
            </div>
            <div class="uk-margin">

                <?php
                $refill_period = (int)$options->get_option('refill-period', 30);
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label">محدودیت زمانی پر کردن مجدد</label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="refill-period">
                            <option <?php if ($refill_period === 30): ?> selected <?php endif; ?> value="30">1 ماه</option>
                            <option <?php if ($refill_period === 60): ?> selected <?php endif; ?> value="60">2 ماه</option>
                            <option <?php if ($refill_period === 90): ?> selected <?php endif; ?> value="90">3 ماه</option>
                            <option <?php if ($refill_period === 180): ?> selected <?php endif; ?> value="180">6 ماه</option>
                            <option <?php if ($refill_period === 360): ?> selected <?php endif; ?> value="360">12 ماه</option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>


            </div>

        </div>

    </div>
</div>