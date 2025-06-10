<?php

namespace kandoElementor\Widgets;


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
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
class kandoPack2 extends Widget_Base
{

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script( 'jquery-nice-select', SAMYAR_DIR_JS .'/jquery.nice-select.min.js', [ 'jquery','samyar-default' ], '1.0.0', true );
    }


    public function get_script_depends() {
        return [ 'jquery-nice-select' ];
    }

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
        return 'kando-pack2';
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
        return __('kando pack2', SAMYAR_TEXT_DOMAIN);
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
    protected function register_controls()
    {

        $servs = [];
        $services = Service::where(['status' => 1]);
        foreach ($services as $service):
            if($service->add_type === "api"){
                $provider = Provider::find($service->api_provider_id);
            }
            if (($service->add_type === "api" && ($provider && $provider->status === "1")) || $service->add_type === "manual") :
                $servs[$service->id]= $service->name;
            endif;
        endforeach;

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('settings', SAMYAR_TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'service-id',
            [
                'label' => __('API Service ID', SAMYAR_TEXT_DOMAIN),
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
            'pack-content',
            [
                'label' => __('Package Content', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::WYSIWYG,
                'description' => __('Package description', SAMYAR_TEXT_DOMAIN),
            ]
        );
        $this->add_control(
            'packs', [
                'label' => __('Pricing pack', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::REPEATER,
                'prevent_empty' => false,
//                'title_field' => '{{{ title }}}',
                'fields' => [
                    [
                        'name' => 'pack_number',
                        'label' => __('pack number', SAMYAR_TEXT_DOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                    ],
                    [
                        'name' => 'pack_price',
                        'label' => __('pack price', SAMYAR_TEXT_DOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                    ],
                    [
                        'name' => 'pack-price-by-discounted',
                        'label' => __('Package Price by Discounted', SAMYAR_TEXT_DOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'description' => __('Leave empty if there is no special offer', SAMYAR_TEXT_DOMAIN),
                    ],
                ],
            ]
        );

        $this->add_control(
            'pack-discount-percent',
            [
                'label' => __('Package Discount Percent', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'description' => __('This value indicates that this percentage of discount has been applied to all items (you can leave it empty)', SAMYAR_TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'subtext-number',
            [
                'label' => __('Subtext Number', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'description' => __('This text will appear after the quantity, e.g., 1000 Likes, Views, etc.', SAMYAR_TEXT_DOMAIN),
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
        $element_id = $this->get_id();

        // Extract settings
        $pack_api_id = !empty($settings['service-id']) ? $settings['service-id'] : '';
        $pack_title = !empty($settings['pack-title']) ? $settings['pack-title'] : '';
        $pack_discount_percent = !empty($settings['pack-discount-percent']) ? $settings['pack-discount-percent'] : '';
        $packs = !empty($settings['packs']) ? $settings['packs'] : [];
        $pack_content = !empty($settings['pack-content']) ? $settings['pack-content'] : '';
        $subtext_number = !empty($settings['subtext-number']) ? $settings['subtext-number'] : '';

        $button_color = !empty($settings['button-color']) ? $settings['button-color'] : '#CD2653';
        $button_title_color = !empty($settings['button-title-color']) ? $settings['button-title-color'] : '#FFFFFF';

        // Order link
        $link = add_query_arg([], home_url('kando-send-pack'));

        // Calculate prices
        $first_pack = $packs[0] ?? [];
        $last_price = !empty($first_pack['pack-price-by-discounted']) ? $first_pack['pack-price-by-discounted'] : ($first_pack['pack_price'] ?? 0);
        $old_price = ($first_pack['pack_price'] ?? 0) == $last_price ? 0 : ($first_pack['pack_price'] ?? 0);

        // Prepare data for JavaScript
        $v_pcks = [];
        foreach ($packs as $pack) {
            $v_pcks[$pack['pack_number']] = [
                'count' => $pack['pack_number'] ?? '',
                'Fprice' => $pack['pack-price-by-discounted'] ?? '',
                'price' => $pack['pack_price'] ?? '',
            ];
        }

        // Display HTML
        ?>
        <div style="text-align: center">
            <?php if (!empty($pack_discount_percent)) : ?>
                <span class="kando-elementor-pack2 off">
                <span><?php echo esc_attr($pack_discount_percent) ?><i>%</i></span>
                <div><?php _e('Discount', SAMYAR_TEXT_DOMAIN) ?></div><?php _e('For a limited time', SAMYAR_TEXT_DOMAIN) ?>
            </span>
            <?php endif; ?>

            <div class="kando-elementor-pack2 pckg" id="viewplans">
                <div class="pckg-head">
                    <h2 class="pckg-title"><?php echo esc_html($pack_title) ?></h2>
                    <div>
                    <span class="comboChooser">
                        <select name="<?php echo esc_attr($element_id) ?>_combo" class="fl_combo <?php echo esc_attr($element_id) ?>combo niceSelect">
                            <?php foreach ($packs as $pack) : ?>
                                <?php
                                $last_price1 = !empty($pack['pack-price-by-discounted']) ? $pack['pack-price-by-discounted'] : $pack['pack_price'];
                                ?>
                                <option data-price="<?php echo priceController::kandoFormatPrice($last_price1)['price_for_show_formatted'] ?>" value="<?php echo esc_attr($pack['pack_number']) ?>">
                                    <?php echo esc_html($pack['pack_number']) ?> <?php echo esc_html($subtext_number) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </span>
                    </div>
                </div>

                <div class="pckg-price">
                <span class="oldPrice" id="<?php echo esc_attr($element_id) ?>_oldPrice" style="text-decoration: line-through;<?php echo $old_price == 0 ? 'display: none' : '' ?>">
                    <?php echo priceController::kandoFormatPrice($old_price)['price_for_show_formatted'] ?>
                </span>
                    <span>
                    <i style="font-style: normal" id="<?php echo esc_attr($element_id) ?>_newPrice"><?php echo priceController::kandoFormatPrice($last_price)['price_for_show_formatted'] ?></i>
                </span>
                </div>

                <div class="normal-text">
                    <?php echo wp_kses_post($pack_content) ?>
                </div>

                <form id="form_<?php echo esc_attr($element_id) ?>" action="#" method="get">
                    <div class="pckg_view-foot">
                        <input class="btn btn-blue-bg kt-modal-button samyar-show-package-form"
                               data-modal="send-package"
                               data-price="<?php echo esc_attr($last_price) ?>"
                               data-title="<?php echo esc_attr($pack_title) ?>"
                               data-service="<?php echo esc_attr($pack_api_id) ?>"
                               data-quantity="<?php echo esc_attr($first_pack['pack_number'] ?? '') ?>"
                               style="background:<?php echo esc_attr($button_color) ?>;color:<?php echo esc_attr($button_title_color) ?>;border-radius: 3px;"
                               type="submit"
                               value="<?php _e('Order', SAMYAR_TEXT_DOMAIN) ?>">
                    </div>
                </form>
            </div>
        </div>

        <script>
            jQuery(document).ready(function ($) {
                var pcks_<?php echo esc_attr($element_id) ?> = <?php echo wp_json_encode($v_pcks) ?>;

                function formatNumber(nStr) {
                    nStr += '';
                    var x = nStr.split('.');
                    var x1 = x[0];
                    var x2 = x.length > 1 ? '.' + x[1] : '';
                    var rgx = /(\d+)(\d{3})/;
                    while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    }
                    return x1 + x2;
                }

                jQuery(document).on('change', '.<?php echo esc_attr($element_id) ?>combo', function () {
                    var $value = jQuery(this).val();
                    var selectedPack = pcks_<?php echo esc_attr($element_id) ?>[$value];

                    if (selectedPack.Fprice !== "") {
                        jQuery('#<?php echo esc_attr($element_id) ?>_oldPrice').text(formatNumber(selectedPack.price)).show();
                        jQuery('#<?php echo esc_attr($element_id) ?>_newPrice').text(formatNumber(selectedPack.Fprice));
                        jQuery('#form_<?php echo esc_attr($element_id) ?> input').attr('data-price', selectedPack.Fprice);
                    } else {
                        jQuery('#<?php echo esc_attr($element_id) ?>_newPrice').text(formatNumber(selectedPack.price));
                        jQuery('#<?php echo esc_attr($element_id) ?>_oldPrice').hide();
                        jQuery('#form_<?php echo esc_attr($element_id) ?> input').attr('data-price', selectedPack.price);
                    }

                    jQuery('#form_<?php echo esc_attr($element_id) ?> input').attr('data-quantity', selectedPack.count);
                });
            });
        </script>
        <?php
    }


}
