<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;
use samyar\Service;
use samyar\Category;
use samyar\Udisableservice;
use TenQuality\WP\Database\QueryBuilder;

$options      = settingsController::getInstance();

//$cate_args = ['order' => 'ASC', 'order_by' => 'sort'];
//if (!samyar_is_admin()) {
//    $cate_args['status'] = 1;
//}
//$categories = Category::where($cate_args);

$enable_average_time = $options->get_option( 'enable-average-time',1);
$sort_by = $options->get_option('select_service_order','price');


$categories = wp_cache_get( 'kando_service_list' );
if ( false === $categories ) {
    $query = QueryBuilder::create();
    $query->select( 'category.id as `category_id`' );
    $query->select( 'category.name as `category_name`' );
    $query->select( 'category.icon as `category_icon`' );
    $query->select( 'category.status as `category_status`' );
    $query->select( 'service.*' );
//->select( 'provider.status as `provider_status`' );
//->select( 'provider.id as `provider_id`' );
    $query->from( 'samyar_categories as `category`' );
    $query->join( 'samyar_services as `service`',[
        [
            'raw' => 'service.cate_id = category.id',
        ],
    ]);
    $query->order_by( 'category.sort' );
    if(kando_is_normal_user()){//اگر کاربر عادی هست
        $query->where(['service.status' => 1] );
        $query->where(['category.status' => 1] );
    }else{//اگر مدیر هست
        if(isset($_GET['active']) && $_GET['active']==0){
            $query->where(['service.status' => 0] );
        }else if(isset($_GET['active']) && $_GET['active']==1){
            $query->where(['service.status' => 1] );
        }
    }
    $services = $query->get();


//اینجا می یایم و سرویسی که برای این کاربر غیر فعال شده رو حذف می کنیم
//این ویژگی در ورژن 12 اضافه شده
    $disable_user_service = [];
    if(is_user_logged_in()){
        $disable_services = Udisableservice::where(['uid'=>get_current_user_id()]);
        foreach($disable_services as $disable_service){
            $disable_user_service[]=$disable_service->service_id;
        }
    }


//لیست ارائه دهنده ها رو بگیر
    $providers_list=[];
//$providers = Provider::all();
    $providers = Provider::builder()
        ->select( 'id' )
        ->select( 'name' )
        ->select( 'status' )
        ->select( 'base_currency' )
        ->get();
    foreach ($providers as $provider){
        $providers_list[$provider->id] = $provider;
    }

    $categories=[];
    foreach ($services as $serv){
        $categories[$serv->category_id]['category_name'] = $serv->category_name;
        $categories[$serv->category_id]['category_status'] = $serv->category_status;
        $categories[$serv->category_id]['category_icon'] = $serv->category_icon;
        if(!in_array($serv->id, $disable_user_service, true)){
            $categories[$serv->category_id]['services'][$serv->id] = $serv;
            if($serv->api_provider_id !== "0"){
                $categories[$serv->category_id]['services'][$serv->id]->provider_status = (int)$providers_list[$serv->api_provider_id]->status;
                $categories[$serv->category_id]['services'][$serv->id]->provider = $providers_list[$serv->api_provider_id];
            }else{
                $categories[$serv->category_id]['services'][$serv->id]->provider_status = 1;//اگر سرویس دستی هست
            }


                $categories[$serv->category_id]['services'][$serv->id]->service_price = calculate_service_price($serv->id);



            $categories[$serv->category_id]['services'][$serv->id]->ordering = $serv->sort;
        }

    }




    wp_cache_set( 'kando_service_list', $categories );
}

?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('services'); ?>
    </div>
</div>
<div class="tickets-navigation">
    <!--	<span class="button button-default">سرویس ها</span>-->
    <?php if (kando_user_can('add_service')): ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=new')) ?>" class="button button-light" data-wpel-link="internal">افزودن سرویس</a>
    <?php endif; ?>
    <?php if (kando_user_can('edit_service')): ?>
        <a href="#" class="button button-red kando-show-services-filter" data-wpel-link="internal">فیلتر</a>
        <a href="#" class="button button-red kando-change-service-status" data-wpel-link="internal">تغییر وضعیت/حذف</a>

        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=all&active=0')) ?>" style="float: left;margin-right: 5px" class="button button-red" data-wpel-link="internal">سرویس های غیر فعال</a>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=all&active=1')) ?>" style="float: left;margin-right: 5px" class="button button-green" data-wpel-link="internal">سرویس های فعال</a>
    <?php endif; ?>
    <a href="#" class="button button-blue kando-show-services-search" data-wpel-link="internal"><?php _e("Search", SAMYAR_TEXT_DOMAIN); ?></a>
</div>
<div class="kt-row">
    <div class=" kt-col-xs-12 kt-col-md-12 float-right">
        <form method="POST" class="samyar-form filter-services-form" style="display: none">
            <input type="hidden" name="action" value="samyar_filter_services_form">
            <div class="new-api-provider-form-errors"></div>
            <div class="samyar-form-loading"></div>
            <div class="clearfix">
                <div class="column kt-col-xs-12 kt-col-md-10 float-right">
                    <input type="text" name="search" placeholder="<?php _e("Enter part of the title and press enter", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                    <input type="submit" class="button button-green sen" style="height: 46px;" value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
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
                    <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                    <select name="filter_type">
                        <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="provider-id"><?php _e("Provider ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="service-id"><?php _e("Service ID", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="provider-service-id"><?php _e("The service identifier in the provider", SAMYAR_TEXT_DOMAIN); ?></option>
                    </select>
                </div>
                <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                    <input type="submit" class="button button-green sen" value="<?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="kando-services-box">
<?php foreach ($categories as $key => $cat){ ?>

    <div class="dashboard-posts-box dashboard-tickets-box">
        <div class="dashboard-posts-title-holder">
            <h5 class="dashboard-posts-title">
                <?php
                if($cat['category_icon']):
                    echo '<i class="'.$cat['category_icon'].'"></i>&nbsp;';
                endif;
                ?>
                <?php echo $cat['category_name'] ?>
                <?php if ($cat['category_status'] === "0"): ?><span style="color:#ff7070">(دسته غیر فعال)</span><?php endif; ?>
            </h5>
        </div>
        <div class="dashboard-posts-list">
            <?php
            if($sort_by==="price"){
                usort($cat['services'], "kando_com_price");
            }else{
                usort($cat['services'], "kando_com_order");
            }


            if (count($cat['services']) > 0):
                ?>

                <table class="shop_table shop_table_responsive">
                    <thead>
                    <tr>

                        <?php if(kando_user_can('edit_service')): ?>
                        <th id="cb">
                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1" name="cb-select-all-1">
                            <label class="kando-cb-label" for="cb-select-all-1"></label>
                        </th>
                        <?php endif; ?>
                        <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <?php if (kando_user_can('show_original_price')): ?>
                            <th><span class="nobr">قیمت اصلی</span></th>
                        <?php endif; ?>
                        <?php if (kando_user_can('show_service_type')): ?>
                            <th><span class="nobr">نوع</span></th>
                        <?php endif; ?>
                        <th><span class="nobr"><?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <?php if($enable_average_time==1){ ?>
                        <th><span class="nobr"><?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <?php } ?>
                        <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>

                            <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php
                    foreach ($cat['services'] as $id => $service):
                        if($service->provider_status===1){
                            include('service.php');
                        }
                        endforeach; ?>
                    </tbody>
                </table>
            <?php
            else:
                ?>
                <span class="services-notfound"><?php _e("No service has been added yet", SAMYAR_TEXT_DOMAIN); ?></span>
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
<?php } ?>
</div>
