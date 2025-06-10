<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;
use samyar\Service;
use samyar\Category;
use samyar\Udisableservice;

$options = settingsController::getInstance();

$cate_args = ['order' => 'ASC', 'order_by' => 'sort'];
if (!kando_user_can('show_bulk_update_price')) {
    $cate_args['status'] = 1;
}
$categories = Category::where($cate_args);


?>

<div class="kt-row">
    <div class=" kt-col-xs-12 kt-col-md-12 float-right">
        <form method="POST" class="samyar-form filter-services-form" style="display: none">
            <input type="hidden" name="action" value="samyar_filter_services_form">
            <div class="new-api-provider-form-errors"></div>
            <div class="samyar-form-loading"></div>
            <div class="clearfix">
                <div class="column kt-col-xs-12 kt-col-md-10 float-right">
                    <input type="text" name="search" placeholder="قسمتی از عنوان را وارد کنید و اینتر بزنید">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                    <input type="submit" class="button button-green sen" style="height: 46px;" value="جستجو">
                </div>
            </div>
        </form>
    </div>
    <div class="kt-col-xs-12 kt-col-md-12 float-right" style="margin-top:5px;">
        <form method="POST" class="samyar-form filter-services-form2" style="display: none">
            <input type="hidden" name="action" value="samyar_filter_services_form2">
            <div class="new-api-provider-form-errors"></div>
            <div class="samyar-form-loading"></div>
            <div class="clearfix">
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <input type="text" name="query" placeholder="اینجا وارد کنید">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <select name="filter_type">
                        <option value="0">نوع فیلتر را انتخاب کنید</option>
                        <option value="provider-id">شناسه ارائه دهنده</option>
                        <option value="service-id">شناسه سرویس</option>
                        <option value="provider-service-id">شناسه سرویس در ارائه دهنده</option>
                    </select>
                </div>
                <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                    <input type="submit" class="button button-green sen" value="فیلتر کن">
                </div>
            </div>
        </form>
    </div>
</div>
<form method="POST" class="samyar-form bulk-update-price-form">
    <input type="hidden" name="action" value="samyar_bulk_update_price">
    <div class="new-api-provider-form-errors"></div>
    <div class="samyar-form-loading"></div>

    <div class="kando-services-box">
        <?php foreach ($categories as $category):
            $services_args = ['cate_id' => $category->id, 'order' => 'ASC', 'order_by' => 'id'];
            if (!kando_user_can('show_bulk_update_price')) {
                $services_args['status'] = 1;
            }
            $services = Service::where($services_args);


            ?>

            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <h5 class="dashboard-posts-title"><?php echo $category->name ?> <?php if ($category->status === "0"): ?><span style="color:#ff7070">(دسته غیر فعال)</span><?php endif; ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <?php
                    $service_list = [];
                    foreach ($services as $service):

                        //می یاد بررسی میکنه که مرتب سازی بر چه اساسی هست
                        //بر اساس قیمت کم با بالا
                        //یا بر اساس مرتب سازی دستی
                        $sort_by = $options->get_option('select_service_order', 'price');


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
                    if (is_user_logged_in()) {
                        $disable_services = Udisableservice::where(['uid' => get_current_user_id()]);
                        foreach ($disable_services as $disable_service) {
                            unset($service_list[$disable_service->service_id]);
                        }
                    }


                    if (count($service_list) > 0):
                        ?>

                        <table class="shop_table shop_table_responsive">
                            <thead>
                            <tr>
                                <th><span class="nobr">شناسه</span></th>
                                <th><span class="nobr">نام</span></th>
                                <th><span class="nobr">توضیحات</span></th>
                                <th><span class="nobr">قیمت اصلی</span></th>
                                <th><span class="nobr">نوع</span></th>
                                <th><span class="nobr">قیمت فروش فعلی</span></th>
                                <th><span class="nobr">قیمت دلخواه</span></th>


                            </tr>
                            </thead>

                            <tbody>

                            <?php
                            //بر اساس قیمت مرتب سازی کردیم
                            asort($service_list);

                            foreach ($service_list as $id => $price):

                                $service = Service::find($id);

                                include('service-bulk.php');
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

                    $(".custom-popup").mouseout(function () {
                        $(this).find('.popuptext').css("visibility", "hidden");
                        $(this).find('.popuptext').css("-webkit-animation", "fadeOut 1s");
                        $(this).find('.popuptext').css("animation", "fadeOut 1s");
                    });
                });

            </script>
        <?php endforeach; ?>
    </div>
    <input type="submit" class="button button-green new-ticket-form-submit bulk-update-price-btn" style="" value="بروزرسانی"/>
</form>
