<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Provider;
use samyar\Service;
use samyar\Udisableservice;
use TenQuality\WP\Database\QueryBuilder;

$options = settingsController::getInstance();
$cate_args = ['order' => 'ASC', 'order_by' => 'sort'];
if (kando_is_normal_user()) {
    $cate_args['status'] = 1;
}

if (isset($atts['cat'])) {

    $category_id = esc_attr($atts['cat']);
    $enable_average_time = $options->get_option('enable-average-time', 1);
    $sort_by = $options->get_option('select_service_order', 'price');


    $query = QueryBuilder::create();
    $query->select('category.id as `category_id`');
    $query->select('category.name as `category_name`');
    $query->select('category.icon as `category_icon`');
    $query->select('category.status as `category_status`');
    $query->select('service.*');
//->select( 'provider.status as `provider_status`' );
//->select( 'provider.id as `provider_id`');
    $query->from('samyar_categories as `category`');
    $query->join('samyar_services as `service`', [
        [
            'raw' => 'service.cate_id = category.id',
        ],
    ]);
    $query->order_by('category.sort');
    if (kando_is_normal_user()) {
        $query->where(['service.status' => 1]);
        $query->where(['category.status' => 1]);
    }
    $query->where(['category.id' => $category_id]);
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
        $categories[$serv->category_id]['category_icon'] = $serv->category_icon;
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


    if (count($categories) > 0):
        foreach ($categories as $key => $cat) {
            ?>
            <div class="dashboard-posts-box dashboard-tickets-box" style="margin-top: 10px">
                <div class="dashboard-posts-title-holder">
                    <h5 class="dashboard-posts-title">
                        <?php
                        if($cat['category_icon']):
                            echo '<i class="'.$cat['category_icon'].'"></i>&nbsp;';
                        endif;
                        ?>
                        <?php echo $cat['category_name'] ?>
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
                                <?php if ($enable_average_time == 1) { ?>
                                    <th><span class="nobr"><?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?></span></th>
                                <?php } ?>
                                <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>

                                <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>

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
                        <span class="services-notfound"><?php _e("No service has been added yet.", SAMYAR_TEXT_DOMAIN); ?></span>
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
            <?php
        }
    else:
        ?>
        <span class="services-notfound"><?php _e("There is no service for this category", SAMYAR_TEXT_DOMAIN); ?></span>
    <?php
    endif;
} else {
    $categories = Category::where($cate_args);
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li><?php _e("You can read the tips related to this part here", SAMYAR_TEXT_DOMAIN); ?></li>

                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e("Services", SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e("Please select your desired category and click on receive services", SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" class="samyar-form get-service-list-category-form">
                    <input type="hidden" name="action" value="samyar_get_services_for_category">
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <select name="cate_id">
                            <option value="0"><?php _e("Please select your desired category", SAMYAR_TEXT_DOMAIN); ?></option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr($category->name) ?> <?php if ($category->status === "0"): ?><?php _e("(inactive category)", SAMYAR_TEXT_DOMAIN); ?><?php endif; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e("Get services", SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12" id="services-result"></div>
    </div>
<?php }