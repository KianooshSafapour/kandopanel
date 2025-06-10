<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );

$sms_provider = $options->get_option( 'sms-provider' );
?>
<style>
    .smsir,.melipayamak,.farazsms,.hide-info,.hide-info-api{
        display: none;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        // تعریف تابع برای نمایش و مخفی کردن آیتم‌ها
        function showSelectedPattern(selectedValue) {
            if(selectedValue === 'farazsms') {
                $('.farazsms').show();
                $('.melipayamak, .smsir').hide();


                $('.hide-info').show();
                $('.hide-info-api').hide();


            } else if(selectedValue === 'melipayamak') {
                $('.melipayamak').show();
                $('.farazsms, .smsir').hide();

                $('.hide-info').show();
                $('.hide-info-api').hide();
            } else if(selectedValue === 'sms.ir') {
                $('.smsir').show();
                $('.farazsms, .melipayamak').hide();

                $('.hide-info').hide();
                $('.hide-info-api').show();
            } else {
                // در صورتی که هیچ گزینه‌ای انتخاب نشده باشد، همه آیتم‌ها را مخفی کنید
                $('.farazsms, .melipayamak, .smsir').hide();
            }
        }

        // وقتی صفحه لود شد
        $(window).on('load', function() {
            // نمایش و مخفی کردن آیتم‌ها بر اساس انتخاب اولیه
            var initialSelectedValue = $('select[name="sms-provider"]').val();
            showSelectedPattern(initialSelectedValue);

            // وقتی تغییری در select اتفاق افتاد
            $('select[name="sms-provider"]').change(function() {
                // مقدار انتخاب شده را بگیرید
                var selectedValue = $(this).val();
                // فراخوانی تابع برای نمایش و مخفی کردن آیتم‌ها بر اساس مقدار انتخاب شده
                showSelectedPattern(selectedValue);
            });
        });
    });

</script>
<div class="samyar-settings-area samyar-settings-sms">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="phone"></span></span>
        <strong><?php _e( 'SMS', SAMYAR_TEXT_DOMAIN ); ?></strong>
    </h3>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b>ویدیو آموزشی مربوط به تنظیمات پیامک کندو پنل را از لینک زیر تماشا کنید:</b><br><br>
                <a href="https://www.aparat.com/v/Rx4nF" target="_blank">ویدیو آموزشی تنظیمات پیامک کندو پنل</a>
                <br>
            </p>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">فعالسازی سرویس پیامک</label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-sms" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-sms" value="1" <?php echo checked( $options->get_option( 'enable-sms',1), 1 ); ?>>فعال</label>
        </div>

    </div>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e( 'تنظیمات درگاه فراز اس ام اس', SAMYAR_TEXT_DOMAIN ); ?></a></li>
        <li><a href="#"><?php _e( 'قالب های پیامک', SAMYAR_TEXT_DOMAIN ); ?></a></li>
        <li><a href="#"><?php _e( 'تنظیمات اضافه', SAMYAR_TEXT_DOMAIN ); ?></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e( 'SMS Provider', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="sms-provider">
                            <option value=""><?php _e( 'Please select an item.', SAMYAR_TEXT_DOMAIN ); ?></option>
                            <option value="farazsms" <?php selected( $sms_provider, 'farazsms' ); ?>><?php _e( 'farazsms', SAMYAR_TEXT_DOMAIN ); ?></option>
                            <option value="melipayamak" <?php selected( $sms_provider, 'melipayamak' ); ?>><?php _e( 'melipayamak', SAMYAR_TEXT_DOMAIN ); ?></option>
                            <option value="sms.ir" <?php selected( $sms_provider, 'sms.ir' ); ?>><?php _e( 'sms.ir', SAMYAR_TEXT_DOMAIN ); ?></option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>

                    <div class="samyar-description farazsms">
                        <span uk-icon="info"></span>
                        <a href="https://farazsms.com/?ref=42" style="color: #F56640 !important;position: relative;top: -7px;" target="_blank">از این لینک می تونید در فراز اس ام اس ثبت نام کنید.</a>
                    </div>

                    <div class="samyar-description melipayamak">
                        <span uk-icon="info"></span>
                        <a href="https://www.melipayamak.com/" style="color: #F56640 !important;position: relative;top: -7px;" target="_blank">از این لینک می تونید در ملی پیامک ثبت نام کنید.</a>
                    </div>

                    <div class="samyar-description smsir">
                        <span uk-icon="info"></span>
                        <a href="https://app.sms.ir/auth/sign-up?ref=P0HAD" style="color: #F56640 !important;position: relative;top: -7px;" target="_blank">از این لینک می تونید در sms.ir ثبت نام کنید.</a>
                    </div>

                </div>

                <div class="uk-margin hide-info">
                    <label class="uk-form-label" for="samyar-sms-username"><?php _e( 'sms username', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-username" name="sms-username" value="<?php echo esc_attr( $options->get_option( 'sms-username' ) ); ?>">
                </div>
                <div class="uk-margin hide-info">
                    <label class="uk-form-label" for="samyar-sms-password"><?php _e( 'sms password', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <input type="password" class="uk-input" id="samyar-sms-password" name="sms-password" value="<?php echo esc_attr( $options->get_option( 'sms-password' ) ); ?>">
                </div>

                <div class="uk-margin hide-info-api">
                    <label class="uk-form-label" for="samyar-sms-apikey"><?php _e( 'sms apikey', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-apikey" name="sms-apikey" value="<?php echo esc_attr( $options->get_option( 'sms-apikey' ) ); ?>">
                </div>


                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-sender"><?php _e( 'sms sender', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-sender" name="sms-sender" value="<?php echo esc_attr( $options->get_option( 'sms-sender' ) ); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-phonebook-id"><?php _e( 'sms phonebook id', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <input type="text" class="uk-input" id="samyar-sms-phonebook-id" name="sms-phonebook-id" value="<?php echo esc_attr( $options->get_option( 'sms-phonebook-id' ) ); ?>">
                </div>
                <div class="uk-margin">
                    <div class="uk-alert-danger" uk-alert>
                        <p style="margin-top: 0">
                            <b>آخرین خطای دریافتی از پنل پیامک:</b><br>
                            <br>
                            <?php
                            $faraz_sms_error = get_option( 'faraz_sms_error');
                            if(!$faraz_sms_error){
                                echo 'در حال حاضر خطایی رخ نداد است';
                            }else{
                                echo $faraz_sms_error;
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </li>
        <li>

            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-verification-pattern"><?php _e( 'sms verification pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            کد تایید شما: %verification-code%<br>
                           نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            کد تایید شما: {0}<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            کد تایید شما: #verification-code#<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-verification-pattern" name="sms-verification-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-verification-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-verification-pattern"><?php _e( 'sms new password pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            رمز عبور جدید شما: %new-password%<br>
                            پس از ورود، می توانید در ویرایش پروفایل رمز عبور را تغییر دهید.<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            رمز عبور جدید شما: {0}<br>
                            پس از ورود، می توانید در ویرایش پروفایل رمز عبور را تغییر دهید.<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            رمز عبور جدید شما: #new-password#<br>
                            پس از ورود، می توانید در ویرایش پروفایل رمز عبور را تغییر دهید.<br>
                            نام سایت شما<br>
                        </p>

                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-sendNewPass-pattern" name="sms-sendNewPass-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-sendNewPass-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-new-registration-pattern">ارسال پیامک به مدیر بعد از اینکه کاربری در سایت ثبت نام کرد </label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            کاربر جدیدی با نام %fullname% و شماره همراه %mobile-number% در سایت شما ثبت نام نمود.<br>
                            نام سایت شما
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            کاربر جدیدی با نام {0} و شماره همراه {1} در سایت شما ثبت نام نمود.<br>
                            آدرس سایت شما
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            کاربر جدیدی با نام #fullname# و شماره همراه #mobile-number# در سایت شما ثبت نام نمود.<br>
                            نام سایت شما
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-new-registration-pattern" name="sms-new-registration-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-new-registration-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-user-pass-pattern">ارسال نام کاربری و رمز عبور به کاربر مهمان <span class="new-option">(جدید)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                           کاربر عزیز، اطلاعات ورود شما به سایت:<br>
                            نام کاربری : %username%<br>
                            رمز عبور: %password%<br>
                            نام سایت شما
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            کاربر عزیز، اطلاعات ورود شما به سایت:<br>
                            نام کاربری : {0}<br>
                            رمز عبور: {1}<br>
                            آدرس سایت شما
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            کاربر عزیز، اطلاعات ورود شما به سایت:<br>
                            نام کاربری : #username#<br>
                            رمز عبور: #password#<br>
                            نام سایت شما
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-user-pass-pattern" name="sms-user-pass-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-user-pass-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-welcome-pattern">ارسال پیامک خوش آمدگویی به کاربر <span class="new-option">(جدید)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            %fullname% عزیز، به سایت ما خوش آمدید<br>
                            نام سایت شما
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            {0} عزیز، به سایت ما خوش آمدید<br>
                            آدرس سایت شما
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            #fullname# عزیز، به سایت ما خوش آمدید<br>
                            نام سایت شما
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-welcome-pattern" name="sms-welcome-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-welcome-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-pattern"><?php _e( 'send sms to admin after order pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            سفارش جدیدی ثبت شد:<br>
                            شناسه: %order-id%<br>
                            سرویس: %service-name%<br>
                            تعداد: %quantity%<br>
                            مبلغ: %amount%<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            سفارش جدیدی ثبت شد:<br>
                            شناسه: {0}<br>
                            سرویس: {1}<br>
                            تعداد: {2}<br>
                            مبلغ: {3}<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            سفارش جدیدی ثبت شد:<br>
                            شناسه: #order-id#<br>
                            سرویس: #service-name#<br>
                            تعداد: #quantity#<br>
                            مبلغ: #amount#<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-order-to-admin-pattern" name="send-order-to-admin-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-order-to-admin-pattern' ) ); ?>">
                    <div class="uk-margin">
                        <label class="uk-form-label">اگر سفارش از api هم ارسال شد به مدیر پیامک بفرست<span class="new-option">(جدید)</span></label>
                        <div class="uk-margin-small">
                            <label>
                                <input class="uk-checkbox" type="checkbox" name="send-order-to-admin-by-api-pattern"
                                       value="1" <?php echo checked($options->get_option('send-order-to-admin-by-api-pattern'), 1); ?>>
                                فعال
                            </label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-for-custom-pattern">ارسال پیامک به مدیر وقتی کاربر سفارش دستی ثبت کرد<span class="new-option">(جدید)</span></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            سفارش دستی جدیدی ثبت شد:<br>
                            شناسه: %order-id%<br>
                            سرویس: %service-name%<br>
                            تعداد: %quantity%<br>
                            مبلغ: %amount%<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            سفارش دستی جدیدی ثبت شد:<br>
                            شناسه: {0}<br>
                            سرویس: {1}<br>
                            تعداد: {2}<br>
                            مبلغ: {3}<br#
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            سفارش دستی جدیدی ثبت شد:<br>
                            شناسه: #order-id#<br>
                            سرویس: #service-name#<br>
                            تعداد: #quantity#<br>
                            مبلغ: #amount#<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-order-to-admin-for-custom-pattern" name="send-order-to-admin-for-custom-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-order-to-admin-for-custom-pattern' ) ); ?>">
                </div>

                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-add-credit-pattern">ارسال پیامک به مدیر وقتی کاربر کیف پولش را شارژ می کند</label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            کاربری با نام %fullname% اعتبار خود را %amount% <?php kando_get_currency_base_text(true) ?> شارژ کرده است.<br>
                            نام سایت شما
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            کاربری با نام {0} اعتبار خود را {1} <?php kando_get_currency_base_text(true) ?> شارژ کرده است.<br>
                            آدرس سایت شما
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            کاربری با نام #fullname# اعتبار خود را #amount# <?php kando_get_currency_base_text(true) ?> شارژ کرده است.<br>
                            نام سایت شما
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-add-credit-pattern" name="sms-add-credit-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-add-credit-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-order-to-admin-pattern"><?php _e( 'send sms to user after order pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            سفارش شما با موفقیت ثبت شد:<br>
                            شناسه سفارش: %order-id%<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            سفارش شما با موفقیت ثبت شد:<br>
                            شناسه سفارش: {0}<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            سفارش شما با موفقیت ثبت شد:<br>
                            شناسه سفارش: #order-id#<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-order-to-user-pattern" name="send-order-to-user-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-order-to-user-pattern' ) ); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-new-status-pattern">ارسال پیامک تغییر وضعیت سفارش</label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            وضعیت سفارش شما برای سرویس %service-name% و به تعداد %number% عدد به وضعیت %newstatus% تغییر کرد.<br>
                            نام سایت شما
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            وضعیت سفارش شما برای سرویس {0} و به تعداد {1} عدد به وضعیت {2} تغییر کرد.<br>
                            آدرس سایت شما
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام<br>
                            وضعیت سفارش شما برای سرویس #service-name# و به تعداد #number# عدد به وضعیت #newstatus# تغییر کرد.<br>
                            نام سایت شما
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-new-status-pattern" name="sms-new-status-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-new-status-pattern' ) ); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-sms-credit-not-enough-pattern">ارسال پیامک عدم موجودی به استفاده کننده از api</label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            عدم موجودی کافی برای ثبت سفارش به مبلغ %order-price% <?php kando_get_currency_base_text(true) ?> از طریق وبسرویس. <br>
                            اعتبار فعلی شما : %balance% <?php kando_get_currency_base_text(true) ?><br>
                            نام سایت شما
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            عدم موجودی کافی برای ثبت سفارش به مبلغ {0} <?php kando_get_currency_base_text(true) ?> از طریق وبسرویس. <br>
                            اعتبار فعلی شما : {1} <?php kando_get_currency_base_text(true) ?><br>
                            آدرس سایت شما
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            عدم موجودی کافی برای ثبت سفارش به مبلغ #order-price# <?php kando_get_currency_base_text(true) ?> از طریق وبسرویس. <br>
                            اعتبار فعلی شما : #balance# <?php kando_get_currency_base_text(true) ?><br>
                            نام سایت شما
                        </p>
                    </div>
                    <input type="text" class="uk-input" id="samyar-sms-credit-not-enough-pattern" name="sms-credit-not-enough-pattern" value="<?php echo esc_attr( $options->get_option( 'sms-credit-not-enough-pattern' ) ); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-newticket-to-admin-pattern"><?php _e( 'send sms to admin for new ticket pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            تیکت جدیدی با شناسه %ticket-id% برای شما ثبت شده است.<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            تیکت جدیدی با شناسه {0} برای شما ثبت شده است.<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            تیکت جدیدی با شناسه #ticket-id# برای شما ثبت شده است.<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-new-ticket-to-admin-pattern" name="send-new-ticket-to-admin-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-new-ticket-to-admin-pattern' ) ); ?>">
                </div>
                <hr>

                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-newticket-to-user-pattern"><?php _e( 'send sms to user for new ticket pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            تیکت جدیدی با شناسه %ticket-id% از طرف مدیریت برای شما ثبت شده است.<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            تیکت جدیدی با شناسه {0} از طرف مدیریت برای شما ثبت شده است.<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            تیکت جدیدی با شناسه #ticket-id# از طرف مدیریت برای شما ثبت شده است.<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-new-ticket-to-user-pattern" name="send-new-ticket-to-user-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-new-ticket-to-user-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-new-answer-to-admin-pattern"><?php _e( 'send sms to admin for new answer pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            پاسخ جدیدی برای تیکت به شناسه %ticket-id% برای شما ارسال شده است.<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            پاسخ جدیدی برای تیکت به شناسه {0} برای شما ارسال شده است.<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام مدیر<br>
                            پاسخ جدیدی برای تیکت به شناسه #ticket-id# برای شما ارسال شده است.<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-new-answer-to-admin-pattern" name="send-new-answer-to-admin-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-new-answer-to-admin-pattern' ) ); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label" for="samyar-send-new-answer-to-admin-pattern"><?php _e( 'send sms to user for new answer pattern', SAMYAR_TEXT_DOMAIN ); ?></label>
                    <div class="uk-alert-primary" uk-alert>
                        <p style="margin-top: 0" class="farazsms">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            پاسخ جدیدی برای تیکت به شناسه %ticket-id% برای شما ارسال شده است.<br>
                            نام سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="melipayamak">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            پاسخ جدیدی برای تیکت به شناسه {0} برای شما ارسال شده است.<br>
                            آدرس سایت شما<br>
                        </p>
                        <p style="margin-top: 0" class="smsir">
                            <b>نمونه پترن:</b><br>
                            سلام کاربر گرامی<br>
                            پاسخ جدیدی برای تیکت به شناسه #ticket-id# برای شما ارسال شده است.<br>
                            نام سایت شما<br>
                        </p>
                    </div>
                    <input type="text" class="uk-input" placeholder="کد پترن را اینجا قرار دهید" id="samyar-send-new-answer-to-user-pattern" name="send-new-answer-to-user-pattern"
                           value="<?php echo esc_attr( $options->get_option( 'send-new-answer-to-user-pattern' ) ); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label">فعالسازی بررسی شماره های افغانستان به جای ایران (تنها کاربران افغانستانی فعال کنند)</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="hidden" name="check-afghanistan-mobile" value="0">
                            <input class="uk-checkbox" type="checkbox" name="check-afghanistan-mobile" value="1" <?php echo checked( $options->get_option( 'check-afghanistan-mobile',0), 1 ); ?>>فعال</label>
                    </div>

                </div>
            </div>
        </li>
    </ul>
</div>