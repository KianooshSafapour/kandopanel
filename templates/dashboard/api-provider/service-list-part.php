<div class="dashboard-posts-box dashboard-tickets-box" style="margin-top: 10px">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title">
            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-category-<?= $c ?>"
                   name="cb-select-category-<?= $c ?>">
            <label class="kando-cb-label" for="cb-select-category-<?= $c ?>"></label>
        </h5>
        <h5 class="dashboard-posts-title"><?php echo $category_name ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php

        if ($services):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th id="cb">
                        <!--                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-category--->
                        <?php //= $c
                        ?><!--"-->
                        <!--                                   name="cb-select-category---><?php //= $c
                        ?><!--">-->
                        <!--                            <label class="kando-cb-label" for="cb-select-category--->
                        <?php //= $c
                        ?><!--"></label>-->
                    </th>
                    <th><span class="nobr"><?php _e('ID', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Name', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Price', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?></span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($services as $service):

                    $cancel = $service['cancel'] ?? 0;

                    $added_to_site = "";
                    if (in_array($service['service'], $services_in_site)) {
                        $added_to_site = "added";
                    }
                    ?>
                    <tr id="service-<?php echo esc_attr($service['service']) ?>">

                        <td class="<?= $added_to_site ?>" data-title="<?php _e("Select", SAMYAR_TEXT_DOMAIN); ?>">
                            <input type="checkbox" class="kando-cb-checkbox" value="1"
                                   id="cb-select-<?php echo esc_attr($service['service']); ?>"
                                   name="services[<?php echo esc_attr($service['service']); ?>]">
                            <label class="kando-cb-label"
                                   for="cb-select-<?php echo esc_attr($service['service']); ?>"></label>
                        </td>
                        <td data-title="<?php _e('ID', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($service['service']) ?>
                        </td>
                        <td data-title="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($service['name']) ?>
                        </td>
                        <td data-title="<?php _e('Description', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php if (isset($service['desc']) && $service['desc']):
                                $description = kando_filter_description($service['desc']);
                                ?>
                                <span class="kt-modal-button button button-default samyar-show-description-service-local"
                                      data-modal="show-description"
                                      data-desc="<?php echo esc_html($description) ?>"><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></span>

                            <?php
                            else:
                                echo "-";
                            endif; ?>
                        </td>
                        <td data-title="<?php _e('Price', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            if ($provider->base_currency === "USD"){
                            //                                echo number_format_i18n( esc_attr( str_replace(array(',','،'), '', $service['rate'])  ))
                            ?><!--&nbsp;--><?php //get_currency_text( $provider->base_currency );
                            //                             echo esc_attr( str_replace(array(',','،'), '', $service['rate'])  )
                            ?><!--&nbsp;--><?php //get_currency_text( $provider->base_currency );
                            echo esc_attr(str_replace(array('.'), '/', $service['rate'])) ?>
                            &nbsp;<?php get_currency_text($provider->base_currency);
                            } else {
                                echo number_format_i18n(esc_attr(str_replace(array(',', '،'), '', $service['rate']))) ?>&nbsp;<?php get_currency_text($provider->base_currency);
                            }

                            ?>
                        </td>
                        <td data-title="<?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?>">
                            <div class="header-phone-holder">
                                <i class="kt-modal-buttonactive" data-modal="service"></i>
                            </div>

                            <span class="kt-modal-button button button-default btn-small add_service_from_list"
                                  data-modal="service" data-tooltip="<?php _e('Add', SAMYAR_TEXT_DOMAIN); ?>"
                                  data-provider="<?php echo esc_attr($provider->id) ?>"
                                  data-service="<?php echo esc_attr($service['service']) ?>"
                                  data-name="<?php echo esc_attr($service['name']) ?>"
                                  data-category="<?php echo esc_attr($service['category']) ?>"
                                  data-rate="<?php echo esc_attr(str_replace(array(',', '،'), '', $service['rate'])) ?>"
                                  data-min="<?php echo esc_attr($service['min']) ?>"
                                  data-max="<?php echo esc_attr($service['max']) ?>"
                                  data-type="<?php echo esc_attr(strtolower(str_replace(" ", "_", $service['type']))) ?>"
                                  data-desc="<?= esc_html(kando_filter_description($service['desc'], true))  ?>"
                                  data-dripfeed="<?php echo esc_attr($service['dripfeed']) ?>"
                                  data-refill="<?php echo esc_attr($service['refill']) ?>"
                                  data-cancel="<?php echo esc_attr($cancel) ?>"
                                  data-brand="<?php echo esc_attr($service['brand']) ?>"
                                  data-currency="<?php get_currency_text($provider->base_currency) ?>"
                            ><i class="fal fa-plus"></i></span>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        else:
            ?>
            <span class="services-notfound"><?php _e('No services available for this category', SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
</div>