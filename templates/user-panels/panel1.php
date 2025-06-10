<?php


use samyar\walletController;

get_header();
$options = settingsController::getInstance();


$wallet = walletController::getInstance();
$user_credit = $wallet->getUserCredit(get_current_user_id())['price_for_show_formatted'];

$action = "";
$section = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_GET['section'])) {
    $section = $_GET['section'];
}


?>
    <div class="wrapper <?= $action ?>">
        <div class="page-inner-holder">
            <nav class="panel-header clearfix">
                <div class="panel-menu-button">
                    <i class="panel-menu-button-inner"></i>
                </div>
                <ul class="panel-header-inner">
                    <?php include(SAMYAR_DIR_TEMPLATE . '/dashboard/menu-li.php'); ?>
                </ul>

                <a href="<?php echo esc_attr(home_url('dashboard/?action=add-credit')) ?>" class="panel-header-wallet"
                   style="display: none" data-wpel-link="internal">
                    <i class="elegant-icon icon_wallet" style="margin-left: 7px;"></i>
                    <span>
                            <span class="woocommerce-Price-amount amount">
                                <?= walletController::getInstance()->getUserCredit(get_current_user_id())['price_for_show_formatted'] ?>
                            </span>
                        </span>
                </a>
                <div class="panel-responsive-menu clearfix">
                    <ul>
                        <?php include(SAMYAR_DIR_TEMPLATE . '/dashboard/menu-li.php'); ?>
                    </ul>
                </div>
            </nav>

            <div class="woocommerce-MyAccount-content">
                <div class="woocommerce-notices-wrapper"></div>
                <?php include(SAMYAR_DIR_TEMPLATE . '/template-switcher.php') ?>
            </div>
        </div>
    </div>
<?php get_footer() ?>