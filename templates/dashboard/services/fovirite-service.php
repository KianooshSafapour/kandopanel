<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\Provider;
use samyar\Service;

?>

<?php
$options = settingsController::getInstance();
$enable_average_time = $options->get_option( 'enable-average-time',1);
$services_args = ['order' => 'ASC', 'order_by' => 'id', 'status' => 1];
$services = Service::where($services_args);
?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title">سرویس های محبوب</h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        $count_fav_service = [];
        foreach ($services as $service):

            //بررسی کن ببین این سرویس آیا ارائه دهندش فعال هست یا نه
            // اگر فعال هست سرویس رو به کاربر نشون بده
            //اگر با api اضاف شده
            if ($service->api_provider_id === "0") {// اگر دستی باشه
                $orders = Order::where(['service_id' => $service->id]);
                $count_fav_service[$service->id] = count($orders);
            } else {//اگر با api اضافه شده باشه
                $provider = Provider::find($service->api_provider_id);
                if ($provider->status === "1") {
                    $orders = Order::where(['service_id' => $service->id]);
                    $count_fav_service[$service->id] = count($orders);
                }
            }

        endforeach;

        if (count($count_fav_service) > 0):
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
                arsort($count_fav_service);
                $counter = 1;
                foreach ($count_fav_service as $id => $count):
                    if ($counter <= 5) {
                        $service = Service::find($id);
                        include('service.php');
                        $counter++;
                    }

                endforeach; ?>
                </tbody>
            </table>
        <?php
        else:
            ?>
            <span class="services-notfound">تاکنون سرویس ای اضافه نشده است.</span>
        <?php
        endif;
        ?>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        $(document).on("mouseover", ".custom-popup", function () {
            $(this).find('.popuptext').css("visibility", "visible");
            $(this).find('.popuptext').css("-webkit-animation", "fadeIn 1s");
            $(this).find('.popuptext').css("animation", "fadeIn 1s");
        });

        $(".custom-popup").mouseout(function(){
            $(this).find('.popuptext').css("visibility", "hidden");
            $(this).find('.popuptext').css("-webkit-animation", "fadeOut 1s");
            $(this).find('.popuptext').css("animation", "fadeOut 1s");
        });
    });

</script>

