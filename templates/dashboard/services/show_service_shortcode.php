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
$enable_average_time = $options->get_option('enable-average-time', 1);
$cate_args = ['order' => 'ASC', 'order_by' => 'sort'];
if (kando_is_normal_user()) {
    $cate_args['status'] = 1;
}

if (isset($atts['id'])) {

    $service_id = esc_attr($atts['id']);
    $service = \samyar\Service::find($service_id);
    if ($service):

            ?>
            <div class="dashboard-tickets-box" style="margin-top: 10px">





                        <table class="shop_table shop_table_responsive">
                            <thead>
                            <tr>
                                <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                                <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                                <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
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

                            <!--start service-->
                            <?php

                            $enable_order_btn_notloginuser = $options->get_option('enable-order-btn-notloginuser', 1);
                            ?>
                            <tr id="service-<?php echo esc_attr($service->id) ?>">

                                <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo esc_attr($service->id) ?>
                                </td>
                                <td data-title="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo esc_attr($service->name) ?>
                                </td>

                                <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php if ($service->description): ?>
                                        <span class="kt-modal-button button button-default samyar-show-description-service" data-modal="show-description"
                                              data-desc="" data-id="<?php echo esc_attr($service->id) ?>"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span>

                                    <?php
                                    else:
                                        echo "-";
                                    endif; ?>
                                </td>



                                <td data-title="<?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo kandoConvertCurrency(calculate_service_price($service->id)) ?>
                                    <?php //echo kando_number_format_currency($service->service_price, true) ?>

                                    <?php
                                    $representation_active = !empty($options->get_option('representation-active')) ? $options->get_option('representation-active') : 0;
                                    if ($representation_active):
                                        $show_price_representation = $options->get_option('show-price-representation', 0);
                                        $show_price_representation_type = $options->get_option('show-price-representation-type', 1);
                                        ?>
                                        <?php if (($show_price_representation == 1 || $show_price_representation === "1") && $service->disable_representation === "0"): ?>
                                        <?php if ($show_price_representation_type == 1 || $show_price_representation_type === "1"): ?>
                                            <div class="custom-popup"><i class="fal fa-info-circle" style="color: #8d81e6;margin-right: 7px;"></i>
                                                <span class="popuptext" id="myPopup">
                                        قیمت نمایندگی ها: <br>
                                        <span style="padding-right:10px;float: right;text-align: right;">
                                        نمایندگی طلایی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 1), true) ?> ) <br>
                                        نمایندگی نقره ای: (<?= kando_number_format_currency(calculate_representation_price($service->id, 2), true) ?> )<br>
                                        نمایندگی برنزی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 3), true) ?> ) <br>
                                        </span>

                                    </span>
                                            </div>
                                        <?php else: ?>
                                            <ul class="order-details">
                                                <li style="text-align: center;">قیمت نمایندگی ها</li>
                                                <li style="font-size: 11px;">نمایندگی طلایی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 1), true) ?> )</li>
                                                <li style="font-size: 11px;">نمایندگی نقره ای: (<?= kando_number_format_currency(calculate_representation_price($service->id, 2), true) ?> )</li>
                                                <li style="font-size: 11px;">نمایندگی برنزی: (<?= kando_number_format_currency(calculate_representation_price($service->id, 3), true) ?> )</li>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                </td>
                                <td data-title="<?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php echo esc_attr($service->max) ?>/<?php echo esc_attr($service->min) ?>
                                </td>
                                <?php if ($enable_average_time == 1) { ?>
                                    <td data-title="<?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?>">
                                        <?php echo get_average_time($service->id) ?>
                                    </td>
                                <?php } ?>
                                <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php

                                        switch ($service->status) {
                                            case 0:
                                                echo "<span style='color: #f58'>".__("Inactive", SAMYAR_TEXT_DOMAIN)."</span>";
                                                break;
                                            case 1:
                                                echo "<span style='color: #7ccc77'>".__("Active", SAMYAR_TEXT_DOMAIN)."</span>";
                                                break;
                                        }


                                    ?>
                                </td>

                                <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">
                                    <?php if (is_user_logged_in() || $enable_order_btn_notloginuser == 1) { ?>
                                        <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new&cat_id=' . esc_attr($service->cate_id) . '&service-id=' . esc_attr($service->id))) ?>" rel="nofollow"><span
                                                    class="button button-default btn-small kt-modal-button samyar-show-order-form" data-modal="send-package" data-service="<?php echo esc_attr($service->id) ?>"
                                                    data-cat="<?php echo esc_attr($service->cate_id) ?>" data-type="fast-order" data-tooltip="<?php _e("Order", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-shopping-cart"></i></span></a>
                                    <?php } ?>

                                </td>

                            </tr>

                            <!--end service-->
                            </tbody>
                        </table>


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
        <span class="services-notfound"><?php _e("There is no service", SAMYAR_TEXT_DOMAIN); ?></span>
    <?php
    endif;
}