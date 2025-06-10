<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$id = $_GET['id'];
$notification = \samyar\Notification::find($id);
$publish = $notification->status == "publish" ? "checked" : "";
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
                <h4 class="new-ticket-title">ویرایش اطلاعیه و هشدار</h4>
                <span class="new-ticket-text">متن اطلاعیه را نوشته و منتشر کنید</span>
                <form method="POST" enctype="multipart/form-data" class="new-notification-form">
                    <input type="hidden" name="action" value="samyar_notification_edit">
                    <input type="hidden" name="notification-id" value="<?= $id ?>">
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <select name="type" id="notification-type" style="margin-bottom: 15px">
                            <option value="notification" <?php if ($notification->type==="notification"): ?> selected <?php endif; ?>>اطلاعیه</option>
                            <option value="alert"<?php if ($notification->type==="alert"): ?> selected <?php endif; ?>>هشدار</option>
                        </select>
                        <div class="kt-col-xs-12">
                            <input type="text" class="new-ticket-form-title" name="notification-title" value="<?= $notification->title ?>" placeholder="عنوان" style="margin-bottom: 15px;">
                        </div>
                        <label>برای چه نوع کاربری نمایش داده شود؟</label>
                        <select name="user-type" style="margin-bottom: 15px">
                            <option value="all"<?php if ($notification->type==="all"): ?> selected <?php endif; ?>>همه کاربران</option>
                            <option value="agents"<?php if ($notification->type==="agents"): ?> selected <?php endif; ?>>نمایندگان</option>
                        </select>
                        <div class="kt-col-xs-12" id="alert-section" style="display: <?php if($notification->type==="alert"): ?>block<?php else: ?>none<?php endif; ?>">
                            <label>در چه مکانی نمایش داده شود؟</label>
                            <select name="location" style="margin-bottom: 15px">
                                <option value="dashboard"<?php if ($notification->location==="all"): ?> selected <?php endif; ?>>داشبرد</option>
                                <option value="credit"<?php if ($notification->location==="credit"): ?> selected <?php endif; ?>>شارژ اعتبار</option>
                                <option value="order"<?php if ($notification->location==="order"): ?> selected <?php endif; ?>>افزودن سفارش</option>
                                <option value="orders"<?php if ($notification->location==="orders"): ?> selected <?php endif; ?>>سفارشات</option>
                                <option value="services"<?php if ($notification->location==="services"): ?> selected <?php endif; ?>>سرویس ها</option>
                                <option value="ticket"<?php if ($notification->location==="ticket"): ?> selected <?php endif; ?>>افزودن تیکت</option>
                                <option value="tickets"<?php if ($notification->location==="tickets"): ?> selected <?php endif; ?>>تیکت ها</option>
                                <option value="profile"<?php if ($notification->location==="profile"): ?> selected <?php endif; ?>>ویرایش پروفایل</option>
                            </select>

                            <label>رنگ پس زمینه هشدار:</label>
                            <select name="background-color" style="margin-bottom: 15px">
                                <option value="success"<?php if ($notification->background_color==="success"): ?> selected <?php endif; ?>>سبز</option>
                                <option value="info"<?php if ($notification->background_color==="info"): ?> selected <?php endif; ?>>آبی</option>
                                <option value="warning"<?php if ($notification->background_color==="warning"): ?> selected <?php endif; ?>>زرد</option>
                                <option value="danger"<?php if ($notification->background_color==="danger"): ?> selected <?php endif; ?>>قرمز</option>
                                <option value="primary"<?php if ($notification->background_color==="primary"): ?> selected <?php endif; ?>>بنفش</option>
                                <option value="secondary"<?php if ($notification->background_color==="secondary"): ?> selected <?php endif; ?>>خاکستری</option>
                                <option value="dark"<?php if ($notification->background_color==="dark"): ?> selected <?php endif; ?>>تاریک</option>
                                <option value="light"<?php if ($notification->background_color==="light"): ?> selected <?php endif; ?>>روشن</option>
                            </select>
                        </div>
                        <div class="kt-col-xs-12">
                            <?php wp_editor($notification->content, 'notification-content'); ?>
                        </div>
                        <div class="kt-col-xs-12">
                            <input type="checkbox" value="1" id="publish-notification" name="publish-notification" <?= $publish ?>><label style="margin: 20px 0;" class="publish-notification"
                                                                                                                                          for="publish-notification">منتشر شود</label>
                        </div>
                        <input type="submit" class="button button-green notification-form-submit" value="ویرایش اطلاعیه">
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>