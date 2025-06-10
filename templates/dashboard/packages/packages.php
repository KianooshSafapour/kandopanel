<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Package;
use samyar\Payment;
use samyar\Pmeta;
use samyar\walletController;

$package = new \kandopanel\packageController();

$options = settingsController::getInstance();
$representation_active = $options->get_option('representation-active', 0)
?>
<?php if ($representation_active || $representation_active === "1"): ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12">
            <?php kando_show_alerts('packages'); ?>
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="fal fa-user-crown"></i>
                    <h5 class="dashboard-posts-title">خرید بسته نمایندگی</h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row">
                        <div class="column kt-col-md-12">
                            <?php if ($package->kandy_calculation_representation(get_current_user_id())) { ?>
                                <div class="alert alert-info" role="alert">
                                    در حال حاضر شما بسته فعالی دارید و امکان خرید بسته نمایندگی جدید برای شما وجود ندارد
                                </div>
                            <?php } ?>
                            <?php echo do_shortcode('[kando_package]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (samyar_is_admin()): ?>
    <div class="kt-row">
        <div class="kt-col-xs-12 kt-col-md-12 float-right">
            <form method="POST" class="samyar-form filter-packages-form">
                <input type="hidden" name="action" value="samyar_filter_packages_form">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                        <input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-5 float-right">
                        <select name="filter_type">
                            <option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="username"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-2 float-right">
                        <input type="submit" class="button button-green sen" value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_creditcard"></i>
        <h5 class="dashboard-posts-title">تراکنش های خرید بسته نمایندگی</h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        //		$payments = Payment::all();
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
        $limit = 30; //تعداد قابل نمایش
        $offset = ($limit * $paged) - $limit;

        $query = ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset];

        if (!samyar_is_admin()) {
            $query['uid'] = get_current_user_id();
        }

        //        $query['order_type'] = 'package';

        $packages = Package::where($query);
        if ($packages):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr">شناسه</span></th>
                    <th><span class="nobr">بسته</span></th>
                    <th><span class="nobr">مبلغ پرداختی</span></th>
                    <th><span class="nobr">اطلاعات کاربر</span></th>
                    <th><span class="nobr">تاریخ شروع</span></th>
                    <th><span class="nobr">تاریخ پایان</span></th>
                    <th><span class="nobr">وضعیت</span></th>
                    <th><span class="nobr">عملیات ها</span></th>
                </tr>
                </thead>

                <tbody id="packages-body">
                <?php
                foreach ($packages as $package):
                    include('package.php');
                 endforeach; ?>
                </tbody>
            </table>
            <?php

            if (!samyar_is_admin()) {
                $count_data['uid'] = get_current_user_id();
            }
            $count_data['order_type'] = 'package';
            $total = Payment::count($count_data);
            samyar_pagination($total, $limit, $paged)
            ?>
        <?php
        else:
            ?>
            <span class="payments-notfound">تاکنون تراکنشی انجام نشده است.</span>
        <?php
        endif;
        ?>
    </div>
</div>