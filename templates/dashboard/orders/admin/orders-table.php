<?php
use samyar\Provider;
use samyar\Service;

if ($orders):
    ?>
    <table class="shop_table shop_table_responsive">
        <thead>
        <tr>
            <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
            <th><span class="nobr"><?php _e("Registration Date", SAMYAR_TEXT_DOMAIN); ?></span></th>
            <th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
            <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
            <?php if (samyar_is_admin()): ?>
                <th><span class="nobr"><?php _e("User Information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("API Response", SAMYAR_TEXT_DOMAIN); ?></span></th>
            <?php endif; ?>
            <th><span class="nobr"><?php _e("Actions", SAMYAR_TEXT_DOMAIN); ?></span></th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($orders as $order):
            if ($order->api_provider_id !== "0") {
                $provider = Provider::find($order->api_provider_id);
            }
            include(SAMYAR_DIR_TEMPLATE.'/dashboard/orders/order.php');
        endforeach; ?>
        </tbody>
    </table>

<?php
else:
    ?>
    <span class="orders-notfound"><?php _e("No orders found", SAMYAR_TEXT_DOMAIN); ?></span>
<?php
endif;
?>