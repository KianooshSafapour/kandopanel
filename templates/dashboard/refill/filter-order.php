<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_bag"></i>
        <h5 class="dashboard-posts-title"><?php _e("Results", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php

        use samyar\Provider;
        use samyar\Service;

        if ($orders):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if (kando_user_can('show_order_user_info')) { ?>
                        <th><span class="nobr"><?php _e("User information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <?php if (kando_user_can('show_order_provider_id')) { ?>
                        <th><span class="nobr"><?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e("API response", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($orders as $refill_order):

                    include(SAMYAR_DIR_TEMPLATE.'/dashboard/refill/order.php');
                endforeach; ?>
                </tbody>
            </table>

        <?php
        else:
            ?>
            <span class="orders-notfound"><?php _e("Order not found", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>

</div>