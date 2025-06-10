<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="woocommerce-MyAccount-content">
    <div class="woocommerce-notices-wrapper"></div>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li><b>نوع اطلاعیه:</b> این اطلاعیه در باکس اطلاعیه ها در داشبرد نمایش داده خواهد شد</li>
                    <li><b>نوع هشدار:</b> هشدار یک باکس رنگی به همراه متن است که می توانید در مکان های مختلف از سایت،برای کاربران قرار دهید</li>
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-ticket-form-outer">
                <h4 class="new-ticket-title">افزودن اطلاعیه و هشدار</h4>
                <span class="new-ticket-text">متن اطلاعیه را نوشته و منتشر کنید</span>
                <form method="POST" enctype="multipart/form-data" class="new-notification-form">
                    <input type="hidden" name="action" value="samyar_notification_add">
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <label>نوع:</label>
                        <select name="type" id="notification-type" style="margin-bottom: 15px">
                            <option value="notification">اطلاعیه</option>
                            <option value="alert">هشدار</option>
                        </select>
                        <div class="kt-col-xs-12">
                            <input type="text" class="new-ticket-form-title" name="notification-title" placeholder="عنوان" style="margin-bottom: 15px;">
                        </div>
                        <label>برای چه نوع کاربری نمایش داده شود؟</label>
                        <select name="user-type" style="margin-bottom: 15px">
                            <option value="all">همه کاربران</option>
                            <option value="agents">نمایندگان</option>
                        </select>

                        <div class="kt-col-xs-12" id="alert-section" style="display: none">
                            <label>در چه مکانی نمایش داده شود؟</label>
                            <select name="location" style="margin-bottom: 15px">
                                <option value="dashboard">داشبرد</option>
                                <option value="credit">شارژ اعتبار</option>
                                <option value="order">افزودن سفارش</option>
                                <option value="orders">سفارشات</option>
                                <option value="services">سرویس ها</option>
                                <option value="ticket">افزودن تیکت</option>
                                <option value="tickets">تیکت ها</option>
                                <option value="profile">ویرایش پروفایل</option>
                            </select>

                            <label>رنگ پس زمینه هشدار:</label>
                            <select name="background-color" style="margin-bottom: 15px">
                                <option value="success">سبز</option>
                                <option value="info">آبی</option>
                                <option value="warning">زرد</option>
                                <option value="danger">قرمز</option>
                                <option value="primary">بنفش</option>
                                <option value="secondary">خاکستری</option>
                                <option value="dark">تاریک</option>
                                <option value="light">روشن</option>
                            </select>
                        </div>
                        <div class="kt-col-xs-12">
                        <?php wp_editor('', 'notification-content'); ?>
                        </div>
                        <div class="kt-col-xs-12">
                        <input type="checkbox" value="1" id="publish-notification" name="publish-notification"><label style="margin: 20px 0;" class="publish-notification" for="publish-notification">منتشر
                            شود</label>
                        </div>
                        <input type="submit" class="button button-green notification-form-submit" value="ارسال اطلاعیه">
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>