<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;
use samyar\Service;
use samyar\Category;
use samyar\Udisableservice;

$options = settingsController::getInstance();
$enable_average_time = kando_get_option( 'enable-average-time',1);
?>

<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title">جستجوی سرویس با عنوان "<?= $_POST['query'] ?>"</h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        $service_list = [];
        foreach ($services as $service):

            //می یاد بررسی میکنه که مرتب سازی بر چه اساسی هست
            //بر اساس قیمت کم با بالا
            //یا بر اساس مرتب سازی دستی
            $sort_by = kando_get_option('select_service_order', 'price');


            //بررسی کن ببین این سرویس آیا ارائه دهندش فعال هست یا نه
            // اگر فعال هست سرویس رو به کاربر نشون بده
            //اگر با api اضاف شده
            if ($service->api_provider_id === "0") {// اگر دستی باشه
                if ($sort_by === "price") {
                    $service_list[$service->id] = calculate_service_price($service->id);
                } else {
                    $service_list[$service->id] = $service->sort;
                }

            } else {//اگر با api اضافه شده باشه
                $provider = Provider::find($service->api_provider_id);
                if ($provider->status === "1") {
                    if ($sort_by === "price") {
                        $service_list[$service->id] = calculate_service_price($service->id);
                    } else {
                        $service_list[$service->id] = $service->sort;
                    }
                }
            }

        endforeach;

        //اینجا می یایم و سرویسی که برای این کاربر غیر فعال شده رو حذف می کنیم
        //این ویژگی در ورژن 12 اضافه شده
        if(is_user_logged_in()){
            $disable_services = Udisableservice::where(['uid'=>get_current_user_id()]);
            foreach($disable_services as $disable_service){
                unset($service_list[$disable_service->service_id]);
            }
        }


        if (count($service_list) > 0):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <?php if(samyar_is_admin()): ?>
                        <th id="cb">
                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1" name="cb-select-all-1">
                            <label class="kando-cb-label" for="cb-select-all-1"></label>
                        </th>
                    <?php endif; ?>
                    <th><span class="nobr">شناسه</span></th>
                    <th><span class="nobr">نام</span></th>
                    <th><span class="nobr">توضیحات</span></th>
                    <?php if (samyar_is_admin()): ?>
                        <th><span class="nobr">قیمت اصلی</span></th>
                        <th><span class="nobr">نوع</span></th>
                    <?php endif; ?>
                    <th><span class="nobr">قیمت هر 1000 عدد</span></th>
                    <th><span class="nobr">حداقل/حداکثر</span></th>
                    <?php if($enable_average_time==1){ ?>
                    <th><span class="nobr">زمان حدودی تکمیل سفارش</span></th>
                    <?php } ?>
                    <th><span class="nobr">وضعیت</span></th>

                    <th><span class="nobr">عملیات ها</span></th>

                </tr>
                </thead>

                <tbody>

                <?php
                //بر اساس قیمت مرتب سازی کردیم
                asort($service_list);

                foreach ($service_list as $id => $price):

                    $service = Service::find($id);

                    include('service.php');
                endforeach; ?>
                </tbody>
            </table>
        <?php
        else:
            ?>
            <span class="services-notfound">سرویسی یافت نشد</span>
        <?php
        endif;
        ?>
    </div>
</div>

