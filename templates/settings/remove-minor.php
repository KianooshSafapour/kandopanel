<?php
defined('ABSPATH') || exit('No Access!');

$status_cron = $options->get_option('status-cron', 'mints1daily');
?>
<div class="samyar-settings-area samyar-settings-minor-cleaning">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="future"></span></span>
        <strong><?php _e('remove info', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            در این بخش می توانید سفارشات رو تا مدت معلوم نگه دارید و بقیه موارد رو پاکسازی کنید
            <br>
            اینکار رو می تونید برای سبک کردن سایتتون انجام بدین
            <br>
            دقت داشته باشید که اطلاعات پاک سازی خواهند شد و دیگه امکان بازگشت این اطلاعات نیست
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-order-remains-day">لطفا تعداد روز سفارشاتی که میخواهید باقی بمانند را وارد کنید(مثال: اگر 60 وارد نمایید سفارش های 60 روز اخیر باقی مانده و بقیه پاکسازی خواهند شد)</label>
            <input type="text" class="uk-input" id="samyar-order-remains-day" name="samyar-order-remains-day" value="">
        </div>
        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-minor-data" data-type="order" type="button">پاکسازی بقیه سفارشات</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            در این بخش می توانید تراکنش ها رو تا مدت معلوم نگه دارید و بقیه موارد رو پاکسازی کنید
            <br>
            اینکار رو می تونید برای سبک کردن سایتتون انجام بدین
            <br>
            دقت داشته باشید که اطلاعات پاک سازی خواهند شد و دیگه امکان بازگشت این اطلاعات نیست
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-transaction-remains-day">لطفا تعداد روز تراکنش هایی که میخواهید باقی بمانند را وارد کنید(مثال: اگر 60 وارد نمایید تراکنش های 60 روز اخیر باقی مانده و بقیه پاکسازی خواهند شد)</label>
            <input type="text" class="uk-input" id="samyar-transaction-remains-day" name="samyar-transaction-remains-day" value="">
        </div>
        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-minor-data" data-type="transaction" type="button">پاکسازی بقیه تراکنش ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
</div>
