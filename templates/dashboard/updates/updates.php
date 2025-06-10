<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Supdate;
?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_pencil"></i>
        <h5 class="dashboard-posts-title">بروزرسانی ها</h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
        $limit = 20; //تعداد قابل نمایش
        $offset = ($limit * $paged) - $limit;

        $updates = Supdate::where(['order' => 'DESC','order_by' => 'date', 'limit' => $limit, 'offset' => $offset]);

        if ($updates):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr">شناسه</span></th>
                    <th><span class="nobr">سرویس</span></th>
                    <th><span class="nobr">تاریخ</span></th>
                    <th><span class="nobr">دسته</span></th>
                    <th><span class="nobr">عنوان</span></th>
                    <?php if(samyar_user_is_admin(get_current_user_id())): ?>
                    <th><span class="nobr">عملیات ها</span></th>
                    <?php endif; ?>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($updates as $update):
                    include('update.php');
                endforeach; ?>
                </tbody>
            </table>
            <?php
            $total = Supdate::count();
            samyar_pagination($total, $limit, $paged)
            ?>
        <?php
        else:
            ?>
            <span class="services-notfound">تاکنون بروزرسانی اضافه نشده است.</span>
        <?php
        endif;
        ?>
    </div>
</div>
