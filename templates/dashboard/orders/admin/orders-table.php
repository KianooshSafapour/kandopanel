<?php

use samyar\Provider;
use samyar\Service;

if ($orders):
    ?>

    <table class="shop_table shop_table_responsive">
        <thead>
        <tr>
            <th><span class="nobr">شناسه</span></th>
            <th><span class="nobr">تاریخ ثبت</span></th>
            <th><span class="nobr">جزییات</span></th>
            <th><span class="nobr">وضعیت</span></th>
            <?php if (samyar_is_admin()): ?>
                <th><span class="nobr">اطلاعات کاربر</span></th>
                <th><span class="nobr">شناسه سفارش در API</span></th>
                <th><span class="nobr">پاسخ API</span></th>
            <?php endif; ?>
            <th><span class="nobr">عملیات ها</span></th>
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
    <span class="orders-notfound">سفارشی یافت نشد</span>
<?php
endif;
?>
