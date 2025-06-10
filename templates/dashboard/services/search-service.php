<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;
use samyar\Service;
use samyar\Category;
use samyar\Udisableservice;
use TenQuality\WP\Database\QueryBuilder;

$options = settingsController::getInstance();

//$cate_args = ['order' => 'ASC', 'order_by' => 'sort'];
//if (!samyar_is_admin()) {
//    $cate_args['status'] = 1;
//}
//$categories = Category::where($cate_args);

$enable_average_time = kando_get_option('enable-average-time', 1);
$sort_by = kando_get_option('select_service_order', 'price');


//$categories = wp_cache_get('kando_service_list');
//if (false === $categories) {
$query = QueryBuilder::create();
$query->select('category.id as `category_id`');
$query->select('category.name as `category_name`');
$query->select('category.status as `category_status`');
$query->select('service.*');
//->select( 'provider.status as `provider_status`' );
//->select( 'provider.id as `provider_id`' );
$query->from('samyar_categories as `category`');
$query->join('samyar_services as `service`', [
    [
        'raw' => 'service.cate_id = category.id',
    ],
]);
$query->order_by('category.sort');
if (kando_is_normal_user()) {//اگر کاربر عادی هست
    $query->where(['service.status' => 1]);
    $query->where(['category.status' => 1]);
} else {//اگر مدیر هست
    if (isset($_GET['active']) && $_GET['active'] == 0) {
        $query->where(['service.status' => 0]);
    } else if (isset($_GET['active']) && $_GET['active'] == 1) {
        $query->where(['service.status' => 1]);
    }
}

if (isset($_POST['filter_type'])) {


    switch ($_POST['filter_type']) {
        case 'provider-id':

            $query->where(['service.api_provider_id' => $_POST['query']]);

            break;
        case 'service-id':
            $query->where(['service.id' => $_POST['query']]);
            break;
        case 'provider-service-id':


            $query->where(['service.api_service_id' => $_POST['query']]);

            break;

    }

}
if (isset($_POST['search'])) {
    $query->keywords($_POST['search'], ['service.name']);
}

$services = $query->get();


//اینجا می یایم و سرویسی که برای این کاربر غیر فعال شده رو حذف می کنیم
//این ویژگی در ورژن 12 اضافه شده
$disable_user_service = [];
if (is_user_logged_in()) {
    $disable_services = Udisableservice::where(['uid' => get_current_user_id()]);
    foreach ($disable_services as $disable_service) {
        $disable_user_service[] = $disable_service->service_id;
    }
}


//لیست ارائه دهنده ها رو بگیر
$providers_list = [];
//$providers = Provider::all();
$providers = Provider::builder()
    ->select('id')
    ->select('name')
    ->select('status')
    ->select('base_currency')
    ->get();
foreach ($providers as $provider) {
    $providers_list[$provider->id] = $provider;
}

$categories = [];
foreach ($services as $serv) {
    $categories[$serv->category_id]['category_name'] = $serv->category_name;
    $categories[$serv->category_id]['category_status'] = $serv->category_status;
    if (!in_array($serv->id, $disable_user_service, true)) {
        $categories[$serv->category_id]['services'][$serv->id] = $serv;
        if ($serv->api_provider_id !== "0") {
            $categories[$serv->category_id]['services'][$serv->id]->provider_status = (int)$providers_list[$serv->api_provider_id]->status;
            $categories[$serv->category_id]['services'][$serv->id]->provider = $providers_list[$serv->api_provider_id];
        } else {
            $categories[$serv->category_id]['services'][$serv->id]->provider_status = 1;//اگر سرویس دستی هست
        }


        $categories[$serv->category_id]['services'][$serv->id]->service_price = calculate_service_price($serv->id);


        $categories[$serv->category_id]['services'][$serv->id]->ordering = $serv->sort;
    }

}



//    wp_cache_set('kando_service_list', $categories);
//}

//print_r($categories)
?>


<div class="kando-services-box">
    <?php foreach ($categories as $key => $cat) { ?>

        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <h5 class="dashboard-posts-title"><?php echo $cat['category_name'] ?> <?php if ($cat['category_status'] === "0"): ?><span style="color:#ff7070">(دسته غیر فعال)</span><?php endif; ?>
                </h5>
            </div>
            <div class="dashboard-posts-list">
                <?php
                if ($sort_by === "price") {
                    usort($cat['services'], "kando_com_price");
                } else {
                    usort($cat['services'], "kando_com_order");
                }


                if (count($cat['services']) > 0):
                    ?>

                    <table class="shop_table shop_table_responsive">
                        <thead>
                        <tr>
                            <?php if (kando_user_can('edit_service')): ?>
                                <th id="cb">
                                    <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1" name="cb-select-all-1">
                                    <label class="kando-cb-label" for="cb-select-all-1"></label>
                                </th>
                            <?php endif; ?>
                            <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php if (kando_user_can('show_original_price')): ?>
                                <th><span class="nobr"><?php _e("Original Price", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php endif; ?>
                            <?php if (kando_user_can('show_service_type')): ?>
                                <th><span class="nobr"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php endif; ?>
                            <th><span class="nobr"><?php _e("Price per 1000 Items", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Minimum/Maximum", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php if ($enable_average_time == 1) { ?>
                                <th><span class="nobr"><?php _e("Approximate Order Completion Time", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <?php } ?>
                            <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                            <th><span class="nobr"><?php _e("Actions", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        foreach ($cat['services'] as $id => $service):
                            if ($service->provider_status === 1) {
                                include('service.php');
                            }
                        endforeach; ?>
                        </tbody>
                    </table>
                <?php
                else:
                    ?>
                    <span class="services-notfound"><?php _e("No services have been added yet.", SAMYAR_TEXT_DOMAIN); ?></span>
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
    <?php } ?>
</div>
