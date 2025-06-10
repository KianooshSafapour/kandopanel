<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Provider;
$provider_id = $_GET['id'];
$provider = Provider::find($provider_id);


if($provider):
	?>
	<div class="kt-row">
		<div class="column kt-col-xs-12 kt-col-md-5 float-left">
			<div class="new-ticket-help">
				<img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
				<ul>
					<li>بروزرسانی شامل قیمت،بروزرسانی نرخ سود،حداقل و حداکثر تعداد و همچنین قابلیت هایی مثل سرمایه گذاری قطره ای است</li>
					<li><b>خدمات جدید:</b> همه خدماتی که جدیدا به این ارائه دهنده اضافه شده به سایت شما هم اضافه می شود</li>
<!--					<li><b>تبدیل نرخ ارز:</b> اگر تمایل به تغییر نرخ ارز دارید در تنظیمات قالب می تونید این کار رو انجام بدین</li>-->
<!--					<li>خدمات فعلی: همه خدماتی فعلی را از لحاظ قیمت، حداقل و حداکثر تعداد و همچنین قابلیت هایی مثل سرمایه گذاری قطره ای بروز می نماید</li>-->
				</ul>
			</div>
		</div>
		<div class="column kt-col-xs-12 kt-col-md-7 float-left">
			<div class="new-api-form-outer">
				<h4 class="new-ticket-title">همگامسازی سرویس </h4>
				<span class="new-ticket-text">اطلاعات را اصلاح کرده و بر روی ارسال کلیک کنید و منتظر بمانید</span>
				<form method="POST" class="samyar-form sync-api-provider-form">
					<input type="hidden" name="action" value="samyar_api_provider_sync">
					<input type="hidden" name="provider_id" value="<?php echo esc_attr($provider->id) ?>">
					<div class="new-api-provider-form-errors"></div>
					<div class="samyar-form-loading"></div>
					<div class="clearfix">
						<input type="text" name="name" value="<?php echo esc_attr($provider->name) ?>" disabled placeholder="نام"/>
						<input type="text" name="url" dir="ltr" value="<?php echo esc_attr($provider->url) ?>" disabled placeholder="لینک"/>
						<input type="text" name="api-key" dir="ltr" value="<?=($provider->api_key)? kando_hide_api_key($provider->api_key) : ''?>" disabled placeholder="کلید API"/>
                        <label>درخواست دارم:</label>
                        <select name="request" class="request">
                            <option value="0">خدمات فعلی بروز شود</option>
                            <option value="1">خدمات جدید اضافه شود</option>
                        </select>
                        <input type="checkbox" value="1" id="update-minmax" name="update-minmax" checked><label style="margin: 20px 0;" class="update-minmax" for="update-minmax">حداقل | حداکثر | قطره چکانی بروز شود</label>

                        <input type="checkbox" value="1" id="update-title" name="update-title"><label style="margin: 20px 0;" class="update-title" for="update-title">عنوان هم بروزرسانی شود(توجه: عنوان فعلی پاک خواهد شد)</label>
                        <input type="checkbox" value="1" id="update-description" name="update-description"><label style="margin: 20px 0;" class="update-description" for="update-description">توضیحات هم بروزرسانی شود(توجه: توضیحات فعلی پاک خواهد شد)</label>
						<input type="submit" class="button button-green new-ticket-form-submit" value="ارسال"/>
					</div>
				</form>
			</div>
		</div>

	</div>
    <div class="kt-row" id="sync-result"></div>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(document).on('change', '.request', function () {
                $(this).val();
                if($(this).val()==="0"){
                    $('.update-title,.update-description').show();
                }else{
                    $('.update-title,.update-description').hide();
                }
            })
        })

    </script>
<?php
else:

endif;

