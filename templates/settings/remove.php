<?php
defined('ABSPATH') || exit('No Access!');

$status_cron = $options->get_option('status-cron', 'mints1daily');
?>
<div class="samyar-settings-area samyar-settings-remove">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="future"></span></span>
        <strong><?php _e('remove info', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <!--
	<div class="uk-margin">
		<div uk-form-custom="target: > * > span:first-child">
			<label class="uk-form-label" for="samyar-cron-status-number">درخواست وضعیت سفارش ها هر چند دقیقه یک بار بررسی شود</label>
			<select name="status-cron">
				<option value="mints1daily" <?php selected($status_cron, 'mints1daily'); ?>><?php _e('every 1 minutes', SAMYAR_TEXT_DOMAIN); ?></option>
				<option value="mints5daily" <?php selected($status_cron, 'mints5daily'); ?>><?php _e('every 5 minutes', SAMYAR_TEXT_DOMAIN); ?></option>
			</select>
			<button class="uk-button uk-button-default" type="button" tabindex="-1">
				<span></span>
				<span uk-icon="icon: chevron-down"></span>
			</button>
		</div>
	</div>
-->


    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید همه اطلاعات مهم سایت شامل دسته ها،سرویس ها،ارائه دهندگان،سفارشات،تراکنش ها،اطلاعیه ها،تیکت ها،کوپن ها، بسته های خریداری شده کاربران،اطلاعیه های بروزرسانی را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="all" type="button">پاکسازی تمام اطلاعات</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید تنها دسته ها و سرویس ها را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="category" type="button">پاکسازی دسته و سرویس های مرتبط</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید تنها سرویس ها را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="services" type="button">پاکسازی سرویس ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
          از این بخش می توانید تنها ارائه دهندگان و سرویس هاشون را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="providers" type="button">پاکسازی ارائه دهنده و سرویس های مربوطه</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید تنها سفارشات را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="orders" type="button">پاکسازی سفارشات</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید تنها تراکنش ها را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="transactions" type="button">پاکسازی تراکنش ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
           از این بخش می توانید تنها اطلاعیه ها را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="notification" type="button">پاکسازی اطلاعیه ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید تنها تیکت ها را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="tickets" type="button">پاکسازی تیکت ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید تنها کوپن های تخفیف را پاکسازی نمایید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="coupons" type="button">پاکسازی کوپن ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید همه بسته های نمایندگی کاربرها رو حذف کنید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="packages" type="button">پاکسازی همه بسته های خریداری شده کاربران</button>
                </div>
            </div>
        </div>

    </div>

    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید قیمت دلخواه و قیمت های نمایندگی که در ویرایش هر سرویس وارد کردین رو یکجا پاکسازی نمایید تا بتوانید از نرخ های عمومی برای سرویس ها استفاده کنید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="prices" type="button">پاکسازی قیمت های دلخواه سرویس ها و نمایندگی ها</button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            از این بخش می توانید همه اطلاعیه های مربوط به تغییرات قیمت و فعال یا غیر فعالسازی سرویس ها رو پاکسازی کنید
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="updates" type="button">پاکسازی اطلاعیه های تغییر قیمت</button>
                </div>
            </div>
        </div>

    </div>
</div>
