<?php

namespace kandoElementor\Widgets;


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
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
                'description' => "سرویس را انتخاب کنید",
            ]
        );

        $this->add_control(
            'pack-title',
            [
                'label' => __('pack title', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'description' => "مثال: سفارش ویو",
            ]
        );
        $this->add_control(
            'pack-content',
            [
                'label' => __('pack content', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::WYSIWYG,
                'description' => "توضیحات بسته",
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
                        'label' => __('pack price by Discounted', SAMYAR_TEXT_DOMAIN),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'description' => "اگر فروش ویژه ندارید خالی بگذارید",
                    ],
                ],
            ]
        );

        $this->add_control(
            'pack-discount-percent',
            [
                'label' => __('pack discount percent', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'description' => "این مقدار نشانگر این است که بر همه موارد این درصد تخفیف اعمال شده است(می توانید خالی بگذارید)",
            ]
        );

        $this->add_control(
            'subtext-number',
            [
                'label' => __('subtext number', SAMYAR_TEXT_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'description' => "این حرف پشت تعداد قرار می گیرد مثلا 1000 لایک،ویو یا غیره",
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
        $pack_api_id = isset($settings['service-id']) && !empty($settings['service-id']) ? $settings['service-id'] : "";
        $pack_title = isset($settings['pack-title']) && !empty($settings['pack-title']) ? $settings['pack-title'] : "";
        $pack_discount_percent = isset($settings['pack-discount-percent']) && !empty($settings['pack-discount-percent']) ? $settings['pack-discount-percent'] : "";
        $packs = isset($settings['packs']) && !empty($settings['packs']) ? $settings['packs'] : [];
        $pack_content = isset($settings['pack-content']) && !empty($settings['pack-content']) ? $settings['pack-content'] : "";
        $subtext_number = isset($settings['subtext-number']) && !empty($settings['subtext-number']) ? $settings['subtext-number'] : "";

        $button_color = isset($settings['button-color']) && !empty($settings['button-color']) ? $settings['button-color'] : "#CD2653";
        $button_title_color = isset($settings['button-title-color']) && !empty($settings['button-title-color']) ? $settings['button-title-color'] : "#FFFFFF";

//        $last_price = !empty($pack_price_by_discounted) ? $pack_price_by_discounted : $pack_price;

        $link = add_query_arg(array(), home_url('kando-send-pack'));

        ?>
        <div style="text-align: center">
        <?php if (!empty($pack_discount_percent)) { ?>

        <span class="kando-elementor-pack2 off">
            <span><?php echo esc_attr($pack_discount_percent) ?><i>٪</i></span>
        <div> تــخــفـیــف  </div>به مدت محدود </span>

    <?php } ?>
        <div class="kando-elementor-pack2 pckg" id="viewplans">

            <div class="pckg-head">
                <h2 class="pckg-title"><?php echo esc_attr($pack_title) ?></h2>
                <div>
            <span class="comboChooser">
                <select name="<?php echo $element_id ?>_combo" class="fl_combo <?php echo $element_id ?>combo niceSelect">
                    <?php foreach ($packs as $i => $pack) {
                        $last_price1 = !empty($pack['pack-price-by-discounted']) ? $pack['pack-price-by-discounted'] : $pack['pack_price'];

                        ?>
                        <option data-price="<?php echo number_format_i18n((int)$last_price1) ?> <?=kando_get_currency_base_text()?>" value="<?php echo $pack['pack_number'] ?>"><?php echo $pack['pack_number'] ?>  <?php echo esc_attr($subtext_number) ?> </option>
                    <?php } ?>
                                    </select>
            </span>
                </div>
            </div>

            <div class="pckg-price">
                <?php
                $last_price = !empty($packs[0]['pack-price-by-discounted']) ? $packs[0]['pack-price-by-discounted'] : $packs[0]['pack_price'];
                ?>
                <?php
                $oldPrice = $packs[0]['pack_price'] == $last_price ? 0 : $packs[0]['pack_price'];
                ?>
                <span class="oldPrice" id="<?php echo $element_id ?>_oldPrice" style="text-decoration: line-through;<?php if($oldPrice == 0): ?>display: none<?php endif; ?>">
                    <?php echo number_format_i18n(esc_attr((int)$oldPrice)) ?></span>
                <span>

                    <i style="font-style: normal" id="<?php echo $element_id ?>_newPrice"><?php echo number_format_i18n(esc_attr((int)$last_price)) ?></i>
            <sup><?=kando_get_currency_base_text()?></sup>
        </span>
            </div>

            <div class="normal-text">
                <?php echo $pack_content ?>
            </div>

            <form id="form_<?php echo $element_id ?>" action="#" method="get">
                <div class="pckg_view-foot"><input class="btn btn-blue-bg kt-modal-button samyar-show-package-form" data-modal="send-package" data-price="<?php echo esc_attr($last_price) ?>" data-title="<?php echo esc_attr($pack_title) ?>" data-service="<?php echo esc_attr($pack_api_id) ?>" data-quantity="<?php echo esc_attr($packs[0]['pack_number']) ?>" style="background:<?php echo esc_attr($button_color) ?>;color:<?php echo esc_attr($button_title_color) ?>;border-radius: 3px;" type="submit" value="سفارش">
            </form>

        </div>
         </div>
        <?php
        $v_pcks = [];
        foreach ($packs as $i => $pack) {
            $v_pcks[$pack['pack_number']] = [
                'count' => isset($pack['pack_number']) ? $pack['pack_number'] : "",
                'Fprice' => isset($pack['pack-price-by-discounted']) ? $pack['pack-price-by-discounted'] : "",
                'price' => isset($pack['pack_price']) ? $pack['pack_price'] : "",
            ];
        }
        $v_pcks = json_encode($v_pcks);
        ?>
        <script>
            jQuery(document).ready(function ($) {
                // $('.niceSelect').niceSelect();
                $(document).on('change', '.niceSelect', function () {
                    $(this).niceSelect('update');
                });
            });
            var pcks_<?php echo $element_id ?> = <?php echo $v_pcks;?>;

            function formatNumber(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length> Number("1") ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }

            jQuery(document).on('change', '.<?php echo $element_id ?>combo', function ($) {
                var $value = jQuery(this).val();

                jQuery('.<?php echo $element_id ?>combo').val(pcks_<?php echo $element_id ?>[$value].count);

                if (pcks_<?php echo $element_id ?>[$value].Fprice !== "") {//اگر فروش ویژه بود
                    $price = pcks_<?php echo $element_id ?>[$value].Fprice
                    jQuery('#<?php echo $element_id ?>_oldPrice').text(formatNumber(pcks_<?php echo $element_id ?>[$value].price));
                    jQuery('#<?php echo $element_id ?>_newPrice').text(formatNumber(pcks_<?php echo $element_id ?>[$value].Fprice));
                    jQuery('#<?php echo $element_id ?>_oldPrice').show();
                    jQuery('#form_<?php echo $element_id ?> input').attr('data-price',pcks_<?php echo $element_id ?>[$value].Fprice);
                } else {
                    $price = pcks_<?php echo $element_id ?>[$value].price

                    jQuery('#<?php echo $element_id ?>_newPrice').text(formatNumber(pcks_<?php echo $element_id ?>[$value].price));
                    jQuery('#<?php echo $element_id ?>_oldPrice').text("");
                    jQuery('#<?php echo $element_id ?>_oldPrice').hide();
                    jQuery('#form_<?php echo $element_id ?> input').attr('data-price',pcks_<?php echo $element_id ?>[$value].price);
                }


                //set for form
                jQuery('#form_<?php echo $element_id ?> input').attr('data-quantity',pcks_<?php echo $element_id ?>[$value].count);
            });
        </script>
        <?php
    }


}
