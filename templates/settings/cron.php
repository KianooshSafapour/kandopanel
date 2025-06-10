<?php
defined('ABSPATH') || exit('No Access!');

$status_cron = $options->get_option('status-cron', 'mints1daily');
?>
<div class="samyar-settings-area samyar-settings-cron">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="future"></span></span>
        <strong><?php _e('cronjob', SAMYAR_TEXT_DOMAIN); ?></strong>
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

        <div class="uk-alert-primary" uk-alert>
            <p>از این بخش می توانید لینک اختصاصی کرون جاب خود را ایجاد نمایید</p>
            <p>برای این مورد تنها کافی است که بر روی تولید لینک کرون جاب جدید کلیک کنید تا لینک ها برای شما ساخته و کد کرون جاب نمایش داده شود</p>
        </div>


        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default" type="button" id="kando-genrate-cronjob-link">تولید لینک کرون جاب جدید</button>
                </div>
            </div>
        </div>
        <?php
        $cronjob_key = get_option('cronjob_key');
        if($cronjob_key){
            $order_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=order&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $status_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=status&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $multi_status_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=multi_status&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $update_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=update&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $refill_order_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=refill_order&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $refill_status_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=refill_status&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $dripfeed_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=dripfeed&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $subscriptions_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=subscriptions&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $hidden=false;
        }else{
            $order_link="";
            $status_link="";
            $multi_status_link="";
            $update_link="";
            $refill_order_link="";
            $refill_status_link="";
            $dripfeed_link="";
            $subscriptions_link="";
            $hidden=true;
        }


        ?>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label">لینک کرون جاب ارسال سفارش (هر یک دقیقه 1 بار تنظیم شود)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-order-cronjob" readonly value="<?=$order_link?>">
                    <a href="<?=$order_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label">لینک کرون جاب دریافت وضعیت ها(هر 5 دقیقه یک بار تنظیم شود)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-status-cronjob" readonly value="<?=$status_link?>">
                    <a href="<?=$status_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label">لینک کرون جاب دریافت وضعیت ها به صورت گروهی(هر 5 دقیقه یک بار تنظیم شود)<span class="new-option">(جدید)</span></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-multi-status-cronjob" readonly value="<?=$multi_status_link?>">
                    <a href="<?=$multi_status_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"> لینک کرون جاب بروزرسانی خودکار ارائه دهندگان(هر 12 ساعت یک بار تنظیم شود)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-autosync-cronjob" readonly value="<?=$update_link?>">
                    <a href="<?=$update_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"> لینک کرون جاب ارسال سفارش جبران ریزش (هر 1 دقیقه یک بار تنظیم شود) (refill order)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-refill-order-cronjob" readonly value="<?=$refill_order_link?>">
                    <a href="<?=$refill_order_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"> لینک کرون جاب دریافت وضعیت سفارش های جبران ریزش(هر 1 دقیقه یک بار تنظیم شود) (refill)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-refill-status-cronjob" readonly value="<?=$refill_status_link?>">
                    <a href="<?=$refill_status_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"> لینک کرون جاب دریافت وضعیت سفارش های چندبخشی(هر 1 دقیقه یک بار تنظیم شود) (refill)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-dripfeed-cronjob" readonly value="<?=$dripfeed_link?>">
                    <a href="<?=$dripfeed_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"> لینک کرون جاب دریافت وضعیت اشتراک ها(هر 1 دقیقه یک بار تنظیم شود) (subscriptions)</label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-subscriptions-cronjob" readonly value="<?=$subscriptions_link?>">
                    <a href="<?=$subscriptions_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: کپی"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b>توجه: </b>اگر بررسی وضعیت ها به صورت گروهی فعال نیست تعداد را تنظیم کنید(توصیه ما این هست که حداکثر 100 بزارید و فاصله زمانی بین هر درخواست رو 5 دقیقه بزارید)<br>
            </p>
            <p> ویژگی وضعیت سفارشات چندگانه، جهت بررسی وضعیت گروهی سفارشات، ویژگی خوبی است که فشار از روی سرور را تا اندازه بسیار زیادی پایین خواهد آورد ولی متاسفانه برخی ارائه دهندگان از این مورد
                پشتیبانی نمی کنند، توصیه ما این هست که به این ارائه دهندگان درخواست کنید که این مورد رو اضافه کنن تا هر دو از مزیت این مورد استفاده کنید(اگر به مستندات api سایتتون مراجعه کنید دستورات
                این مورد رو با عنوان وضعیت سفارش چندگانه می بینید)</p>
            <p>به همین خاطر ما در این بخش انتخاب این مورد رو به عهده خودتون گذاشتیم ، اگر مطمئن هستید که همه ارائه دهندگانی که از آنها استفاده می کنید از این قابلیت پشتیبانی می کنن(باید در مستندات
                سایتشون ببینید) کافی است که تیک بررسی وضعیت ها به صورت گروهی رو تیک بزنید وگرنه تیکش رو بردارید.</p>
        </div>
    </div>
    <!--
    <div class="uk-margin">
        <label class="uk-form-label">بررسی وضعیت ها به صورت گروهی</label>
        <div class="uk-margin-small">
            <label>
                <input class="uk-checkbox" type="hidden" name="enable-group-status-orders" value="0">
                <input class="uk-checkbox" type="checkbox" name="enable-group-status-orders" value="1" <?php echo checked($options->get_option('enable-group-status-orders', 1), 1); ?>>فعال</label>
        </div>

    </div>
    -->
    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-cron-status-number">در هر بار درخواست، وضعیت چند سفارش بررسی شود</label>
            <input type="number" class="uk-input" id="samyar-cron-status-number" name="cron-status-number" min="15" value="<?php echo esc_attr($options->get_option('cron-status-number', 15)); ?>">
        </div>
    </div>


</div>
