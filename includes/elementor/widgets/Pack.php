<?php

namespace kandoElementor\Widgets;


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use samyar\Category;
use samyar\priceController;
use samyar\Provider;
use samyar\Service;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class kandoPack extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_name()
    {
        return 'kando-pack';
    }

    /**
     * Retrieve the widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_title()
    {
        return __('kando pack', SAMYAR_TEXT_DOMAIN);
    }

    /**
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-price-table';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @return array Widget categories.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_categories()
    {
        return ['kando-category'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @return array Widget scripts dependencies.
     * @since 1.0.0
     *
     * @access public
     *
     */


    public function get_style_depends() {
        return [ 'kando-elements-css' ];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls ()
    {
//		$options = new DAI_Options_Manager();
//		$popup_image = kando_get_option( 'popup-image');
//		if(isset($popup_image) && !empty($popup_image) && is_numeric($popup_image)){
//			$popup_image  = kando_get_option( 'popup-image');
//			$popup_image = wp_get_attachment_url( $popup_image );
//		}else{
//			$popup_image  = dai_default('popup-image');
//		}

        $categories = Category::where( ['order'=>'ASC','order_by'=>'sort','status'=> 1 ] );
        $cats=[];

        foreach($categories as $category){
            $cats[$category->id] = $category->name;
        }

        $servs = [];
        $services = Service::where(['status' => 1]);
        if($services){
            foreach ($services as $service):
                if($service->add_type === "api"){
                    $provider = Provider::find($service->api_provider_id);
                }
                if (($service->add_type === "api" && ($provider && $provider->status === "1")) || $service->add_type === "manual") :
                    $servs[$service->id]= $service->name;
                endif;
            endforeach;
        }


        $this->start_controls_section(
            'content_section',
            [
                'label' => __('settings', SAMYAR_TEXT_DOMAIN),
            ]
        );
/*
        $this->add_control(
            'pack-category-id',
            [
                'label' => __('Category', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::SELECT2,
                'options' => $cats,
                'default' => '',
                'description' => "دسته سرویس را انتخاب کنید",
            ]
        );
*/
        $this->add_control(
            'service-id',
            [
                'label' => __('Service', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::SELECT2,
                'options' => $servs,
                'default' => '',
                'description' => __('Select the service', SAMYAR_TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'pack-title',
            [
                'label' => __('Package Title', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'description' => __('Example: View Order', SAMYAR_TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'pack-number',
            [
                'label' => __('Package Number', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'pack-content',
            [
                'label' => __('Package Content', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::WYSIWYG,
                'description' => __('Package description', SAMYAR_TEXT_DOMAIN),
            ]
        );
        $this->add_control(
            'pack-price',
            [
                'label' => __('pack price', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
            ]
        );

//        $this->add_control(
//            'pack-price-by-discounted',
//            [
//                'label' => __('pack price by Discounted', SAMYAR_TEXT_DOMAIN),
//                'type' => Controls_Manager::TEXT,
//                'description' => "اگر فروش ویژه ندارید خالی بگذارید",
//            ]
//        );

        $this->add_control(
            'pack-icon',
            [
                'label' => __('pack icon', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'icon-color',
            [
                'label' => __('Icon Color', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
//                'default' => "#cd2653",
            ]
        );

        $this->add_control(
            'button-color',
            [
                'label' => __('Button Color', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => "#cd2653",
            ]
        );
        $this->add_control(
            'button-title-color',
            [
                'label' => __('Button Title Color', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => "#ffffff",
            ]
        );

        $this->end_controls_section();


    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $pack_api_id = isset($settings['service-id']) && !empty($settings['service-id']) ? $settings['service-id'] : "";
        $pack_title = isset($settings['pack-title']) && !empty($settings['pack-title']) ? $settings['pack-title'] : "";
        $pack_number = isset($settings['pack-number']) && !empty($settings['pack-number']) ? kando_english_number($settings['pack-number']) : "";
        $pack_content = isset($settings['pack-content']) && !empty($settings['pack-content']) ? $settings['pack-content'] : "";

        // Find the service
        $service = Service::find($pack_api_id);

        if (!$service) {
            echo __('Service not found.', SAMYAR_TEXT_DOMAIN);
            return;
        }

        $services = [$service];

        // Calculate prices
        $user_id = get_current_user_id();
        if (empty($services)) {
            echo __('No services available for price calculation.', SAMYAR_TEXT_DOMAIN);
            return;
        }

        $prices = priceController::calculatePricesBatch($services, $user_id);
        $amount = $prices[$pack_api_id]['price'] ?? 0;

        if ($service->type === "package" || $service->type === "custom_comments_package") {
            $pack_price = $amount;
        } else {
            $pack_price = ($amount / 1000) * (int)$pack_number;
        }

        $pack_price = isset($pack_price) && is_numeric($pack_price) ? $pack_price : 0;
        $last_price = priceController::kandoFormatPrice((float)$pack_price);

        $pack_price_by_discounted = isset($settings['pack-price-by-discounted']) && !empty($settings['pack-price-by-discounted']) ? $settings['pack-price-by-discounted'] : "";
        $pack_icon = isset($settings['pack-icon']) && !empty($settings['pack-icon']) ? $settings['pack-icon'] : "";
        $icon_color = isset($settings['icon-color']) && !empty($settings['icon-color']) ? $settings['icon-color'] : "";
        $button_color = isset($settings['button-color']) && !empty($settings['button-color']) ? $settings['button-color'] : "#CD2653";
        $button_title_color = isset($settings['button-title-color']) && !empty($settings['button-title-color']) ? $settings['button-title-color'] : "#FFFFFF";

        $link = add_query_arg([
            'service-id' => $pack_api_id,
            'number' => $pack_number
        ], home_url('kando-send-pack'));
        ?>

        <div class="kando-elementor-pack product-plan">
            <div class="itemPack ofh">
                <div class="ipTopSide">
                    <span class="iptsCircle bgPurple2 brs50"></span>
                    <div class="iptsIconCircle brs50">
                        <i style="color:<?php echo esc_attr($icon_color) ?>" class="<?php echo esc_attr($pack_icon['value']) ?>"></i>
                    </div>
                    <div class="iptsTitle relative">
                        <h5 class="blue3 bold iptstCount dIb"><?php echo esc_attr($pack_number) ?></h5>
                        <h5 class="bold iptstCountSubtitle Black1"><?php echo esc_attr($pack_title) ?></h5>
                    </div>
                </div>
                <div class="ipBottomSide">
                    <?php echo $pack_content ?>
                    <?php if (!empty($pack_price_by_discounted)) { ?>
                        <!-- <div class="bgGray5 db smallBtn black text-center relative before ipbPrice oldprice"><?php echo esc_attr($pack_price) ?><span class="">تومان</span></div> -->
                    <?php } ?>
                    <div class="bgBlue6 db smallBtn blue3 text-center relative before ipbPrice bold"><?php echo $last_price['price_for_show_formatted'] ?></div>

                    <a class="bgPink1 db smallBtn White text-center relative before bold kt-modal-button samyar-show-package-form"
                       data-modal="send-package"
                       data-price="<?php echo $pack_price ?>"
                       data-title="<?php echo esc_attr($pack_title) ?>"
                       data-service="<?php echo esc_attr($pack_api_id) ?>"
                       data-quantity="<?php echo esc_attr($pack_number) ?>"
                       style="background:<?php echo esc_attr($button_color) ?>;color:<?php echo esc_attr($button_title_color) ?>"
                       href="#"><?php _e('Order', SAMYAR_TEXT_DOMAIN) ?></a>
                </div>
            </div>
        </div>
        <?php
    }

}
