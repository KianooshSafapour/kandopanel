<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
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
            <h4 class="new-ticket-title">افزودن ارائه دهنده جدید</h4>
            <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی افزودن کلیک کنید و منتظر بمانید</span>
            <form method="POST" class="samyar-form new-api-provider-form">
                <input type="hidden" name="action" value="samyar_api_provider_add">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
	                <input type="text" name="name" placeholder="نام"/>
	                <input type="text" name="url" dir="ltr" placeholder="لینک"/>
	                <input type="text" name="api-key" dir="ltr" placeholder="کلید API"/>
                    <label>نرخ دلخواه سود برای این ارائه دهنده (به درصد)</label>
                    <input type="number" min="0" max="1000" step="1" name="custom-rate" id="custom-rate" dir="ltr" placeholder="سود دلخواه(درصد)" value=""/>
                    <label>قیمت های این ارائه دهنده به کدام ارز است؟</label>
                    (<span><a href="#" id="inquiry_rate">استعلام نرخ</a></span>)
                    <select name="base-currency">
                        <option value="IRT">تومان</option>
                        <option value="USD">دلار</option>
                        <option value="IRR">ریال</option>
                    </select>
	                <textarea class="new-api-form-text" name="description" style="margin-bottom: 10px;" placeholder="توضیحات"></textarea>
                    <label>آدرس سایت ارائه دهنده را در این قسمت وارد نمایید(این مورد برای دسترسی سریع به سایت ارائه دهنده قرار داده شده)</label>
                    <input type="text" name="site_link" dir="ltr" value="" placeholder="آدرس سایت"/>
	                <input type="submit" class="button button-green new-ticket-form-submit" value="ارسال"/>
                </div>
            </form>
        </div>
    </div>

</div>
