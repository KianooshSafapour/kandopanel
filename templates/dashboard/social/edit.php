<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Social;

$social_id = $_GET['id'];
$social = Social::find($social_id);
if($social):
?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li>نکات مربوط به این قسمت را می توانید اینجا بخوانید</li>
                    <li>برای استفاده از آیکون شبکه های اجتماعی ایرانی از فونت آیکون های زیر استفاده کنید:</li>
                    <li>knd icon-gap</li>
                    <li>knd icon-eitaa</li>
                    <li>knd icon-rubika</li>
                    <li>knd icon-soroush</li>
                    <li>knd icon-aparat</li>
                    <li>knd icon-bale</li>
                    <li>knd icon-x</li>
                    <li>knd icon-threads</li>
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title">ویرایش دسته</h4>
                <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی افزودن کلیک کنید</span>
                <form method="POST" class="samyar-form new-social-form">
                    <input type="hidden" name="action" value="samyar_social_edit">
                    <input type="hidden" name="id" value="<?php echo esc_attr($social->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <input type="text" name="name" value="<?php echo esc_attr($social->name) ?>" placeholder="نام"/>
                        <label>آیکون</label>
                        <input type="text" name="icon" dir="ltr" value="<?php echo esc_attr($social->icon) ?>" placeholder="ex: fab fa-instagram or knd icon-aparat"/>
                        <div class="kt-col-xs-12">
                            <div class="kt-wc-coupon-box"><a href="https://fontawesome.com/v5/search">لیست آیکون ها</a></div>
                        </div>
                        <input type="text" name="sort" value="<?php echo esc_attr($social->sort) ?>" placeholder="مرتب سازی"/>
                        <select name="status">
                            <option <?php if(esc_attr( $social->status )==1) echo 'selected' ?> value="1">فعال</option>
                            <option <?php if(esc_attr( $social->status )==0) echo 'selected' ?> value="0">غیر فعال</option>
                        </select>

                        <input type="submit" class="button button-green new-ticket-form-submit" value="بروزرسانی"/>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php
else:

endif;