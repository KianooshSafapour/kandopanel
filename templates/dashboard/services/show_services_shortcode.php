<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\categoryController;
use samyar\Service;
use samyar\serviceController;

$options = settingsController::getInstance();
$cate_args = ['order' => 'ASC', 'order_by' => 'sort'];
if (kando_is_normal_user()) {
    $cate_args['status'] = 1;
}

//get translate
$ctranslates = categoryController::getInstance()->get_translates();
$stranslates = \samyar\serviceController::getInstance()->get_translates();
if (isset($atts['cat'])) {

    $categoryModel = new Category();
    $serviceModel = new Service();
    $category_id = isset($atts['cat'])?$atts['cat']:"";
    $service_style = isset($atts['style'])?$atts['style']:"";


    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $is_admin = current_user_can('administrator');
    $user_id = get_current_user_id();

    // Get categories
    $selected_categories = $categoryModel->get_category($category_id);


    // Get services for each category
    $category_ids = array_column($selected_categories, 'id');
    $services = $serviceModel->get_services_by_category_ids($category_ids, $is_admin, $user_id);

    // Get service metas for each service
    $service_ids = array_column($services, 'id');
    $all_service_metas = $serviceModel->get_service_metas_bulk($service_ids);



    $service_metas_by_service_id = [];
    foreach ($all_service_metas as $service_id => $metas) {
        $service_metas_by_service_id[$service_id][] = $metas;
    }


    // دریافت علاقه‌مندی‌های کاربر (اگر وارد سیستم شده باشد)
    $user_favorites = [];
    if ($user_id) {
        $user_favorites = $serviceModel->getUserServiceFavorites($user_id);
    }


    // Format data for view
    $categories = array_reduce($selected_categories, function ($carry, $category) use ($ctranslates){
        $carry[$category->id] = [
            'category_id' => $category->id,
            'category_name' => categoryController::getInstance()->get_title($ctranslates,$category),
            'category_description' => categoryController::getInstance()->get_description($ctranslates,$category),
            'category_icon' => $category->icon,
            'category_image' => $category->image,
            'category_status' => $category->status,
            'category_platform' => $category->social_id,
            'services' => [],
        ];
        return $carry;
    }, []);


    foreach ($services as $service) {
        $service_metas = $service_metas_by_service_id[$service->id] ?? [];

        // بررسی آیا سرویس مورد علاقه کاربر است
        $is_favorite = in_array($service->id, $user_favorites);

        $categories[$service->cate_id]['services'][] = (object)[
            'id' => $service->id,
            'name' => serviceController::getInstance()->get_title($stranslates,$service),
            'description' => serviceController::getInstance()->get_description($stranslates,$service),
            'min' => $service->min,
            'max' => $service->max,
            'status' => $service->status,
            'price' => $service->price,
            'profit_rate' => $service->profit_rate,
            'currency' => $service->manual_currency,
            'original_price' => $service->original_price,
            'disable_representation' => $service->disable_representation,
            'gold_price' => $service->gold_price,
            'silver_price' => $service->silver_price,
            'bronze_price' => $service->bronze_price,
//                'provider_id' => $service->api_provider_id,
            'provider_name' => $service->provider_name,
            'provider_currency' => $service->provider_currency,
            'provider_custom_rate' => $service->provider_custom_rate,
            'api_service_id' => $service->api_service_id,
            'api_provider_id' => $service->api_provider_id,
            'cancel' => $service->cancel,
            'refill' => $service->refill,
            'add_type' => $service->add_type,
            'manual_currency' => $service->manual_currency,
            'created_at' => $service->created_at,
//                'metas' => $service_metas,
            "is_favorite" => $is_favorite, // اضافه کردن وضعیت علاقه‌مندی
        ];
    }

    $settings = [
        'enable_average_time' => kando_get_option('enable-average-time', 1),
        'sort_by' => kando_get_option('select_service_order', 'price'),
        'enable_order_btn_notloginuser' => kando_get_option('enable-order-btn-notloginuser', 1),
        'representation_active' => kando_get_option('representation-active', 0),
        'show_price_representation' => kando_get_option('show-price-representation', 0),
        'show_price_representation_type' => kando_get_option('show-price-representation-type', 1),
    ];

    if ($service_style) {
        $selected_style = $service_style;
    } else {
        $selected_style = (int)kando_get_option('service-style', 2);
    }



    if (count($categories) > 0):

        if ($selected_style == 1) {
            include(SAMYAR_DIR_VIEW . '/services/service/style1.php');
        } else {
            include(SAMYAR_DIR_VIEW . '/services/service/style2.php');
        }
        ?>

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
                                <option value="<?php echo esc_attr($category->id) ?>"><?php echo esc_attr(categoryController::getInstance()->get_title($ctranslates,$category)) ?><?php if ($category->status === "0"): ?><?php _e("(inactive category)", SAMYAR_TEXT_DOMAIN); ?><?php endif; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="button button-green new-ticket-form-submit"
                               value="<?php _e("Get services", SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12" id="services-result"></div>
    </div>
<?php }