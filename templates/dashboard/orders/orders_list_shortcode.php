<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
if(!is_user_logged_in()):
    $categories = Category::where(['order' => 'ASC', 'order_by' => 'sort', 'status' => 1]);
    ?>
    <div class="kt-row">
        <form method="POST" class="samyar-form get-orders-form">
            <input type="hidden" name="action" value="samyar_get_orders">
            <div class="column kt-col-xs-12 kt-col-md-6">
                <div class="kt-row">
                    <div class="samyar-form-loading"></div>
                    <div id="order_review" class="column kt-col-xs-12 kt-col-md-12">


                        <p class="form-row form-row-first">
                            <input type="text" name="mobile" class="input-text" placeholder="<?php _e("Phone Number", SAMYAR_TEXT_DOMAIN); ?>" id="mobile-number" value=""/>
                        </p>

                        <p class="form-row form-row-last">
                            <a href="#" class="button button-red kt-ajax-button samyar-verify-send" style="margin:10px 0 20px 0;line-height: 28px;"><?php _e("Send Verification Code", SAMYAR_TEXT_DOMAIN); ?></a>
                        </p>

                        <div class="clear"></div>
                        <p class="form-row form-row-first">
                            <input type="text" name="verify-code" class="input-text" placeholder="<?php _e("Received Verification Code", SAMYAR_TEXT_DOMAIN); ?>" id="verify-code" value=""/>
                        </p>

                        <div class="form-row place-order">
                            <input type="submit" class="button button-green alt" name="get_orders" id="get_orders" value="<?php _e("Get Orders", SAMYAR_TEXT_DOMAIN); ?>" data-value="<?php _e("Get Orders", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
    <div class="dashboard-posts-box dashboard-tickets-box">

    </div>
<?php else: ?>
    <?php include_once(SAMYAR_DIR_VIEW . '/orders/orders.php'); ?>
<?php endif; ?>