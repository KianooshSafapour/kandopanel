<?php

use samyar\Social;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
$socials = Social::where( ['order'=>'ASC','order_by'=>'sort' ] );
?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 float-left">
        <div class="new-ticket-help">
            <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
            <ul>
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
            <h4 class="new-ticket-title">افزودن دسته جدید</h4>
            <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی افزودن کلیک کنید</span>
            <form method="POST" class="samyar-form new-category-form">
                <input type="hidden" name="action" value="samyar_category_add">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
	                <input type="text" name="name" placeholder="نام"/>
	                <input type="text" name="icon" dir="ltr" placeholder="ex: fab fa-instagram or knd icon-aparat"/>
                    <input type="text" name="sort" placeholder="مرتب سازی"/>
                    <select name="social_id" id="samyar_select_social">
                        <option value="0">لطفا برند مرتبط به این دسته را انتخاب نمایید</option>
                        <?php foreach ($socials as $social): ?>
                            <option value="<?php echo esc_attr($social->id) ?>"><?php echo esc_attr($social->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>نوع لینک سرویس های این دسته(ضروری نیست)</label>
                    <input type="radio" value="default" id="default" name="link-type" checked>
                    <label class="link-type" style="margin: 10px 12px;" for="default">پیشفرض</label>

                    <a href="#" class="button button-green show-other-types">
                        مشاهده دیگر نوع ها
                        <i class="fal fa-chevron-down"></i>
                    </a>
                    <?php

                    $types = get_link_types();

                    foreach ($types as $brand => $data) {
                        ?>
                        <fieldset class="link-type-fieldset">
                            <legend><?=kando_persian_text($brand)?></legend>
                            <?php
                            $checked="";
                            foreach ($data as $k => $t) {
                                ?>
                                <input type="radio" value="<?= $k ?>" id="<?= $k ?>" name="link-type">
                                <label class="link-type" for="<?= $k ?>"><?= $t ?></label>
                                <?php
                            }
                            ?>
                        </fieldset>
                        <?php
                    }
                    ?>
                    <label>توضیحات</label>
                    <?php wp_editor('','description', array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
	                <input type="submit" class="button button-green new-ticket-form-submit" value="ارسال"/>
                </div>
            </form>
        </div>
    </div>

</div>
