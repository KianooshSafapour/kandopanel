<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


use samyar\Refill;
use samyar\Service;


$order_id = $_GET['id'];
$order = Refill::find($order_id);
if ($order):
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li><?php _e("You can read the tips related to this part here", SAMYAR_TEXT_DOMAIN); ?></li>
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e('Edit Refill Order', SAMYAR_TEXT_DOMAIN) ?></h4>
                <span class="new-ticket-text"><?php _e("Enter the information and click on submit", SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" class="samyar-form update-order-refill-form">
                    <input type="hidden" name="action" value="samyar_refill_order_edit">
                    <input type="hidden" name="id" value="<?php echo esc_attr($order->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <label><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></label>
                                <input type="text" disabled value="<?php echo esc_attr($order->id) ?>"
                                       placeholder="<?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?>"/>
                            </div>
                            <div class="column kt-col-xs-12 kt-col-md-6">
                                <label><?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?></label>
                                <input type="text" disabled value="<?php echo esc_attr($order->api_order_id) ?>"
                                       placeholder="<?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?>"/>
                            </div>
                        </div>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("User", SAMYAR_TEXT_DOMAIN); ?></label>
                                <?php $user_info = get_user_by('id', $order->uid) ?>
                                <input type="text" disabled
                                       value="<?= (!empty($user_info)) ? $user_info->user_email : '' ?>"
                                       placeholder="<?php _e("Email", SAMYAR_TEXT_DOMAIN); ?>"/>
                            </div>
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Service", SAMYAR_TEXT_DOMAIN); ?></label>
                                <?php
                                $service = Service::find($order->service_id);
                                ?>
                                <input type="text" disabled value="<?= (!empty($service)) ? $service->name : '' ?>"
                                       placeholder="<?php _e("Service", SAMYAR_TEXT_DOMAIN); ?>"/>
                            </div>
                        </div>

                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-4">
                                <label><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></label>
                                <select name="status" class="form-control square">
                                    <?php

                                    $order_status_array = ['pending', 'inprogress', 'completed', 'rejected', 'error'];

                                    if (!empty($order_status_array)) {
                                        foreach ($order_status_array as $status) {
                                            ?>
                                            <option value="<?= $status ?>" <?= ($order->status && $status === $order->status) ? 'selected' : '' ?> ><?= samyar_order_status_title($status) ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Link", SAMYAR_TEXT_DOMAIN); ?></label>
                                <input type="text" dir="ltr" disabled name="link"
                                       value="<?php echo esc_attr($order->link) ?>"
                                       placeholder="<?php _e("Link", SAMYAR_TEXT_DOMAIN); ?>"/>
                            </div>
                        </div>
                        <input type="submit" class="button button-green new-ticket-form-submit"
                               value="<?php _e("Update", SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
endif;