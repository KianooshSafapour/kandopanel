<?php
use kandopanel\currencyController;
use samyar\orderController;
use samyar\userController;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$options = settingsController::getInstance();
$dashboard_image = kando_get_option('dashboard-image', SAMYAR_DIR_IMG . '/dashboard-welcome.png');
if (isset($dashboard_image) && !empty($dashboard_image) && is_numeric($dashboard_image)) {
    $dashboard_image = wp_get_attachment_url($dashboard_image);
}

$priceSettings = [
    'base_currency_data' => currencyController::getInstance()->getCurrencyByCode(get_option('base_currency', "IRT")),
    'user_currency_data' => currencyController::getInstance()->getCurrencyByCode(currencyController::getInstance()->getUserCurrency()),
];
?>
<?php
$order_class = new orderController();
$count = $order_class->get_orders_late_update_status(true);
if ($count):
    ?>
<!--
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                <?php _e("Some orders have not been updated for more than 1 day. Let's process them, otherwise new orders will not be reviewed.", SAMYAR_TEXT_DOMAIN); ?>
                <a style="margin-top:20px"
                   href="<?php echo esc_attr(home_url('dashboard/?action=orders&status=late_update_status')) ?>"
                   class="button button-red" data-wpel-link="internal"><?php _e("View Orders", SAMYAR_TEXT_DOMAIN); ?></a>
            </div>
        </div>
    </div>
    -->
<?php endif;

$userController = new userController();
if (!$userController->exist_mobile() && $userController->enable_sms()) {
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                <?php _e("Unfortunately, you have not entered your phone number. Please enter and verify your phone number in your profile before proceeding.", SAMYAR_TEXT_DOMAIN); ?>
                <br>
                <a style="margin-top:20px" href="<?php echo esc_attr(home_url('dashboard/?action=edit-profile')) ?>"
                   class="button button-red" data-wpel-link="internal"><?php _e("Go to Profile", SAMYAR_TEXT_DOMAIN); ?></a>
            </div>
        </div>
    </div>
    <?php
}

if ($userController->exist_mobile() && !$userController->approved_mobile()) {
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <div class="alert alert-warning" role="alert" style="font-size: 14px;text-align: center">
                <?php _e("Unfortunately, you have not verified your phone number. Please verify your phone number in your profile before proceeding.", SAMYAR_TEXT_DOMAIN); ?>
                <br>
                <a style="margin-top:20px" href="<?php echo esc_attr(home_url('dashboard/?action=edit-profile')) ?>"
                   class="button button-red" data-wpel-link="internal"><?php _e("Go to Profile", SAMYAR_TEXT_DOMAIN); ?></a>
            </div>
        </div>
    </div>
    <?php
}

kando_show_alerts('dashboard');
$enable_welcome = kando_get_option('enable-welcome', 1);

if ($enable_welcome === "1") {
    ?>
    <!--start welcome-->
    <div class="dashboard-welcome-box">
        <div class="dashboard-welcome-box-inner clearfix">
            <i class="dashboard-welcome-close"></i>

            <img src="<?= $dashboard_image ?>"/>
            <div class="dashboard-welcome-box-desc">
                <h4><?php echo str_replace("کندو پنل", "<span>Kando Panel</span>", __(kando_get_option('welcome-title', "Welcome to the <span>Kando Panel</span> dashboard!"), SAMYAR_TEXT_DOMAIN)); ?></h4>
                <div class="dashboard-welcome-box-text">
                    <p><?php echo __(kando_get_option('welcome-content', "You can place orders here and also submit your issues via tickets."), SAMYAR_TEXT_DOMAIN); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!--end welcome-->
<?php } ?>
<?php include 'dashboard/notifications.php'; ?>
<?php include 'dashboard/statistics.php'; ?>
<?php include 'dashboard/chart.php'; ?>
<?php include 'dashboard/order-statistics.php'; ?>
<?php include 'dashboard/refill-statistics.php'; ?>
<?php include 'dashboard/packages-statistics.php'; ?>
<?php //include('dashboard/favorite-service.php'); ?>
<?php include 'dashboard/tickets.php'; ?>
