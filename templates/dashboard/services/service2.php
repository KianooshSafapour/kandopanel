<?php
$stranslates = \samyar\serviceController::getInstance()->get_translates();
foreach ($categories as $cate_id => $category){ ?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title">
            <?php
            if ($category['category_icon']):
                echo '<i class="' . $category['category_icon'] . '"></i>&nbsp;';
            endif;
            ?>
            <?php echo $category['category_name'] ?>
            <?php if ($category['category_status'] === "0"): ?><span
                style="color:#ff7070">(دسته غیر فعال)</span><?php endif; ?>
        </h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        if ($sort_by === "price") {
            usort($category['services'], "kando_com_price2");
        } else {
            usort($category['services'], "kando_com_order2");
        }


        if (count($category['services']) > 0):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>

                    <?php if (kando_user_can('edit_service')): ?>
                        <th id="cb">
                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1"
                                   name="cb-select-all-1">
                            <label class="kando-cb-label" for="cb-select-all-1"></label>
                        </th>
                    <?php endif; ?>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Name", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if (kando_user_can('show_service_type')): ?>
                        <th><span class="nobr">نوع</span></th>
                    <?php endif; ?>
                    <th><span class="nobr"><?php _e("Price per 1000 pcs", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Min/Max", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if ($enable_average_time == 1) { ?>
                        <th>
                            <span class="nobr"><?php _e("Estimated time to complete the order", SAMYAR_TEXT_DOMAIN); ?></span>
                        </th>
                    <?php } ?>
                    <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>

                    <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>

                </tr>
                </thead>

                <tbody>

                <?php
                foreach ($category['services'] as $id => $service):
                    $service = (OBJECT)$service;

//                    if ($service->provider_status === 1) {
                        include('show-service.php');
//                    }
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
<?php } ?>