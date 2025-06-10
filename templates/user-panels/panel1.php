<?php


use samyar\walletController;

get_header();
$options = settingsController::getInstance();


$wallet = walletController::getInstance();
$user_credit = $wallet->getUserCredit(get_current_user_id());

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
                                <?= walletController::getInstance()->getUserCreditByCurrency(get_current_user_id()) ?>
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
                <?php

                //                    else{
                //	                    $action = "dashboard";
                //                    }
                switch ($action) {
                    case "dashboard":
                        include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/dashboard.php');
                        break;
                    case "orders":
                        switch ($section) {
                            case "new":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/add.php');
                                break;
                            case "edit":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/admin/edit.php');
                                break;
                            case "user-orders":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/admin/user-orders.php');
                                break;
                            case "dripfeed":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/dripfeed.php');
                                break;
                            case "subscriptions":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/subscriptions.php');
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/orders.php');
                        }

                        break;
                    case "refill":
                        switch ($section) {
                            case "edit":
                                if (kando_user_can('edit_order')):
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/refill/edit.php');
                                endif;
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/refill/orders.php');
                        }

                        break;
                    case "notifications":
                        if (kando_user_can('show_notifications')):
                            switch ($section) {
                                case "new":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/notification/add.php');
                                    break;
                                case "edit":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/notification/edit.php');
                                    break;
                                default:
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/notification/notifications.php');
                            }
                        endif;
                        break;
                    case "social":
                        if (kando_user_can('show_brands')):
                            switch ($section) {
                                case "new":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/social/add.php');
                                    break;
                                case "edit":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/social/edit.php');
                                    break;
                                default:
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/social/socials.php');
                            }
                        endif;
                        break;
                    case "categories":
                        if (kando_user_can('show_categories')):
                            switch ($section) {
                                case "new":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/categories/add.php');
                                    break;
                                case "edit":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/categories/edit.php');
                                    break;
                                default:
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/categories/categories.php');
                            }
                        endif;
                        break;

                    case "services":
                        switch ($section) {
                            case "new":
                                if (kando_user_can('add_service')):
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/add.php');
                                endif;
                                break;
                            case "edit":
                                if (kando_user_can('edit_service')):
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/edit.php');
                                endif;
                                break;
                            case "log":
                                if (kando_user_can('show_service_log')):
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/service_log.php');
                                endif;
                                break;
                            case "all":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/services-all.php');
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/services.php');
                        }
                        break;
                    case "payments":
                        switch ($section) {
                            case "payments":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/payment/payments.php');
                                break;
//                                case "process":
//                                    include_once(SAMYAR_DIR_TEMPLATE.'/dashboard/payment/process_payment.php');
//                                    break;
                            case "users-payment":
                                if (samyar_is_admin()):
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/payment/users-payment.php');
                                endif;
                                break;
                            case "all":
                                if (samyar_is_admin()):
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/payment/all-payments.php');
                                endif;
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/payment/payments.php');
                        }

                        break;
                    case "tickets":
                        switch ($section) {
                            case "new":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/tickets/add.php');
                                break;
                            case "show":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/tickets/show.php');
                                break;
                            case "waiting":
//									if ( samyar_is_admin() ):
//										include_once( SAMYAR_DIR_TEMPLATE.'/dashboard/tickets/admin/waiting-tickets.php' );
//									endif;
//									break;
                            case "answered":
//									if ( samyar_is_admin() ):
//										include_once( SAMYAR_DIR_TEMPLATE.'/dashboard/tickets/admin/answered-tickets.php' );
//									endif;
//									break;
                            case "closed":
//									if ( samyar_is_admin() ):
//										include_once( SAMYAR_DIR_TEMPLATE.'/dashboard/tickets/admin/closed-tickets.php' );
//									endif;
//									break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/tickets/tickets.php');
                        }
                        break;
                    case "add-credit":
                        switch ($section) {
                            case "cart-to-cart":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/wallet/cart-to-cart.php');
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/wallet/add.php');
                        }

                        break;

                    case "providers":
                        if (kando_user_can('show_providers')):
                            switch ($section) {
                                case "new":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/add.php');
                                    break;
                                case "edit":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/edit.php');
                                    break;
                                case "sync-services":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/sync-services.php');
                                    break;
                                case "service-list":
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/service-list.php');
                                    break;
                                default:
                                    include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/providers.php');
                            }
                        endif;
                        break;
//						case "api":
//							include_once( SAMYAR_DIR_TEMPLATE.'/dashboard/api.php' );
//							break;
                    case "edit-profile":
                        switch ($section) {
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/profile/edit.php');
                        }

                        break;
                    case "api":
                        switch ($section) {
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/api/api.php');
                        }

                        break;
                    case "timeline":
                        if (samyar_is_admin()):
                            include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/timeline.php');
                        endif;
                        break;
                    case "get-package":
                        include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/packages/packages.php');

                        break;
                    case "updates":
                        include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/updates/updates.php');

                        break;
                    case "bulk-update-price":
                        if (kando_user_can('show_bulk_update_price')):
                            include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/services/bulk/bulk-update-price.php');
                        endif;
                        break;
                    case "dripfeeds":
                        switch ($section) {
                            case "dripfeeds":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/dripfeeds.php');
                                break;
                            case "drips":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/drips.php');
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/dripfeeds.php');
                                break;
                        }

                        break;
                    case "subscriptions":
                        switch ($section) {
                            case "subscriptions":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/subscriptions/subscriptions.php');
                                break;
                            case "childs":
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/subscriptions/childs.php');
                                break;
                            default:
                                include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/orders/subscriptions/subscriptions.php');
                                break;
                        }

                        break;
                    case "verify-mobile":
                        include_once(SAMYAR_DIR_TEMPLATE . '/dashboard/verify-mobile.php');
                        break;
                    default:
                        do_action('panel_page_list');
                        break;
                }
                ?>

            </div>
        </div>
    </div>
<?php get_footer() ?>