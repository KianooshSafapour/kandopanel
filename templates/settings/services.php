<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );
?>
<div class="samyar-settings-area samyar-settings-services">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="settings"></span></span>
        <strong>سرویس ها</strong>
    </h3>

    <?php
    $select_service_order = $options->get_option('select_service_order','price');
    ?>
    <div class="uk-margin">
        <label class="uk-form-label">انتخاب روش مرتب سازی سرویس ها</label>
        <div uk-form-custom="target: > * > span:first-child">
            <select name="select_service_order">
                <option <?php if ($select_service_order === "price"): ?> selected <?php endif; ?> value="price">هزینه کم به زیاد</option>
                <option <?php if ($select_service_order === "order"): ?> selected <?php endif; ?> value="order">مرتب سازی دستی(در افزودن/ویرایش هر سرویس وجود دارد)</option>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی نمایش زمان تقریبی انجام سفارش</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-average-time" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-average-time" value="1" <?php echo checked( $options->get_option( 'enable-average-time',1), 1 ); ?>>فعال</label>
            </div>

        </div>
    </div>

    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">نمایش دکمه سفارش برای کاربران وارد نشده</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-order-btn-notloginuser" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-order-btn-notloginuser" value="1" <?php echo checked( $options->get_option( 'enable-order-btn-notloginuser',1), 1 ); ?>>فعال</label>
            </div>

        </div>
    </div>
<hr>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            نکته 1 : همه اعداد رو به بالا رند خواهند شد<br>

            مثال ها:
            اگر شما در تنظیمات تعداد عدد را روی هزارگان بگذارید قیمت ها به این صورت در خواهند آمد:<br>
            152342 -> 153000 <br>
            47523 ->48000 <br>
            3823 -> 4000 <br>
            252 -> 300 <br>

        </div>


        <div class="uk-margin">
            <label class="uk-form-label">فعالسازی رند کردن قیمت ها</label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="round-price" value="0">
                    <input class="uk-checkbox" type="checkbox" name="round-price" value="1" <?php echo checked( $options->get_option( 'round-price',0), 1 ); ?>>فعال</label>
            </div>

        </div>


        <div class="uk-margin">
            <?php
            $round_price_number = $options->get_option( 'round-price-number',10);
            ?>
            <label class="uk-form-label">تا چند عدد رند شوند</label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="round-price-number">
                    <option value="10" <?php if ($round_price_number == 10): ?> selected <?php endif; ?>>دهگان</option>
                    <option value="100" <?php if ($round_price_number == 100): ?> selected <?php endif; ?>>صدگان</option>
                    <option value="1000" <?php if ($round_price_number == 1000): ?> selected <?php endif; ?>>هزارگان</option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>

        <!--
        <div class="uk-margin">
            <label class="uk-form-label">انتخاب نوع رند کردن</label>
            <div uk-form-custom="target: > * > span:first-child">
                <select name="round-price-type">
                    <option value="up" <?php if ($options->get_option( 'round-price-type',"down") === "up"): ?> selected <?php endif; ?>>به بالا</option>
                    <option value="down" <?php if ($options->get_option( 'round-price-type',"down") === "down"): ?> selected <?php endif; ?>>به پایین</option>
                </select>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <span></span>
                    <span uk-icon="icon: chevron-down"></span>
                </button>
            </div>
        </div>
-->
    </div>


</div>