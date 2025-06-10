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
				<li>نکات مربوط به این قسمت را می توانید اینجا بخوانید</li>
			</ul>
		</div>
	</div>
	<div class="column kt-col-xs-12 kt-col-md-7 float-left">
		<div class="new-api-form-outer">
			<h4 class="new-ticket-title">ویرایش ارائه دهنده </h4>
			<span class="new-ticket-text">اطلاعات را اصلاح کرده و بر روی ارسال کلیک کنید و منتظر بمانید</span>
			<form method="POST" class="samyar-form new-api-provider-form">
				<input type="hidden" name="action" value="samyar_api_provider_edit">
				<input type="hidden" name="provider_id" value="<?php echo esc_attr($provider->id) ?>">
				<div class="new-api-provider-form-errors"></div>
				<div class="samyar-form-loading"></div>
				<div class="clearfix">
					<input type="text" name="name" value="<?php echo esc_attr($provider->name) ?>" placeholder="نام"/>
					<input type="text" name="url" dir="ltr" value="<?php echo esc_attr($provider->url) ?>" placeholder="لینک"/>
					<input type="text" name="api-key" id="api-key-edit" disabled="disabled" dir="ltr" placeholder="کلید API" value="<?=($provider->api_key)? kando_hide_api_key($provider->api_key) : ''?>"/>
                    <div class="kt-col-xs-12">
                        <div class="kt-wc-coupon-box"><a href="#" class="show-api-input">برای تغییر کلید api اینجا کلیک کنید</a></div>
                    </div>
                    <label>نرخ دلخواه سود برای این ارائه دهنده (به درصد)</label>
                    <input type="number" min="0" max="1000" step="1" name="custom-rate" id="custom-rate" dir="ltr" placeholder="سود دلخواه(درصد)" value="<?= ($provider->custom_rate) ?: '' ?>"/>
                    <label>قیمت های این ارائه دهنده به کدام ارز است؟</label>
                    (<span><a href="#" id="inquiry_rate">استعلام نرخ</a></span>)
                    <select name="base-currency">
                        <option <?php if(esc_attr( $provider->base_currency )=="USD") echo 'selected' ?> value="USD">دلار</option>
                        <option <?php if(esc_attr( $provider->base_currency )=="IRT") echo 'selected' ?> value="IRT">تومان</option>
                        <option <?php if(esc_attr( $provider->base_currency )=="IRR") echo 'selected' ?> value="IRR">ریال</option>
                    </select>
                    <select name="status">
                        <option <?php if(esc_attr( $provider->status )==1) echo 'selected' ?> value="1">فعال</option>
                        <option <?php if(esc_attr( $provider->status )==0) echo 'selected' ?> value="0">غیر فعال</option>
                    </select>
					<textarea class="new-api-form-text" name="description" style="margin-bottom: 10px;" placeholder="توضیحات"><?php echo esc_attr($provider->description) ?></textarea>
                    <label>آدرس سایت ارائه دهنده را در این قسمت وارد نمایید(این مورد برای دسترسی سریع به سایت ارائه دهنده قرار داده شده)</label>
                    <input type="text" name="site_link" dir="ltr" value="<?php echo esc_attr($provider->site_link) ?>" placeholder="آدرس سایت"/>
					<input type="submit" class="button button-green new-ticket-form-submit" value="بروزرسانی"/>
				</div>
			</form>
		</div>
	</div>

</div>
<?php
else:

endif;