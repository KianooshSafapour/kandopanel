<?php

use kandopanel\currencyController;

$brands = \samyar\Social::where(['status' => 1]);
$categoriess = \samyar\Category::where(['status' => 1]);
?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12 dashboard-notifications">
        <div class="dashboard-posts-box dashboard-tickets-box margin-top-0">
            <div class="dashboard-posts-list dashboard-notifications-items">
                <div class="kt-col-lg-2 kt-col-sm-3 kt-col-xs-12 ml-10 mb-sm-10 align-items-center">
                    <select class="form-control form-select" id="sel_platforms">
                        <option value="all"><?php _e("All Platforms", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php foreach ($brands as $brand) { ?>
                            <option value="<?= $brand->id ?>"><?= $brand->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="kt-col-lg-2 kt-col-sm-3 kt-col-xs-12 ml-10 mb-sm-10 align-items-center">
                    <input type="text" name="search" class="input-text"
                           placeholder="<?php _e("Search Service ID or Service Name", SAMYAR_TEXT_DOMAIN); ?>"
                           id="searchService" value=""/>
                </div>
                <div class="kt-col-lg-2 kt-col-sm-3 kt-col-xs-12 ml-10 mb-sm-10 align-items-center">
                    <select class="form-control form-select" id="sel_category">
                        <option value="all"><?php _e("All Categories", SAMYAR_TEXT_DOMAIN); ?></option>
                        <option value="fav"><?php _e("Favorite services", SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php foreach ($categoriess as $category) { ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php if (kando_user_can('edit_service')): ?>
                    <div class="kt-col-lg-2 kt-col-sm-3 kt-col-xs-12 ml-10 mb-sm-10 align-items-center">
                        <select class="form-control form-select" id="activeService">
                            <option value="all"><?php _e("all status", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="1"><?php _e("Active services", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="0"><?php _e("Inactive services", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                    </div>
                <?php endif; ?>
                <?php
                $enable_switch_currency = settingsController::getInstance()->get_option('enable-switch-currency', 0);
                if ($enable_switch_currency == "1") {
                    $selected_currency = currencyController::getInstance()->getUserCurrency();
                    $currencies = currencyController::getInstance()->get_all_currencies();
                    $selected_currency_symbol = currencyController::getInstance()->getUserCurrency();
                    ?>
                    <div class="kt-col-lg-2 kt-col-sm-3 kt-col-xs-12 ml-10 mb-sm-10 align-items-center">
                        <select id="currency-select" class="form-control form-select">
                            <?php foreach ($currencies as $key => $value) : ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($selected_currency, $key); ?>><?php echo esc_attr($value['symbol']); ?> <?php echo esc_html($value['currency_code']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php } ?>
                <div class="kt-col-lg-1 kt-col-sm-12 kt-col-xs-12 ml-10 mb-sm-10 align-items-center">
                    <i class="fal fa-info-circle" id="infoIcon"></i>

                    <div class="main_category hidden" id="mainCategory">
                        <div class="service_type text_color">
                            <p>
                                <span>⛔</span>
                                <?php echo esc_html__('Cancel Button Available', SAMYAR_TEXT_DOMAIN); ?>
                            </p>
                            <p class="rba_btn">
                                <span class="text-success">♻</span>
                                <?php echo esc_html__('Refill Button Available', SAMYAR_TEXT_DOMAIN); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
