<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\priceController;
use samyar\Service;

?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 float-left">
        <div class="new-ticket-help">
            <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
            <ul>
                <li><?php _e("You can read the tips related to this section here", SAMYAR_TEXT_DOMAIN); ?></li>
            </ul>
        </div>
    </div>
    <div class="column kt-col-xs-12 kt-col-md-7 float-left">
        <div class="new-api-form-outer">
            <h4 class="new-ticket-title"><?php _e("Edit Order", SAMYAR_TEXT_DOMAIN); ?></h4>
            <span class="new-ticket-text"><?php _e("Enter the information and click on submit", SAMYAR_TEXT_DOMAIN); ?></span>
            <form method="POST" class="samyar-form update-order-form">
                <input type="hidden" name="action" value="samyar_order_edit">
                <input type="hidden" name="id" value="<?php echo esc_attr($order->id) ?>">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" disabled dir="ltr" value="<?php echo esc_attr($order->id) ?>"
                                   placeholder="<?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" disabled dir="ltr" value="<?php echo esc_attr($order->api_order_id) ?>"
                                   placeholder="<?php _e("API Order ID", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php if ($order->api_provider_id !== "0"): ?>
                                <input type="text" disabled value="api"
                                       placeholder="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>"/>
                            <?php else: ?>
                                <input type="text" disabled value="<?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?>"
                                       placeholder="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>"/>
                            <?php endif; ?>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e("User", SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php
                            $user_text = "";
                            $user_info = get_user_by('id', $order->uid);
                            if ($user_info) {
                                $user_text .= $user_info->display_name;
                                $user_text .= " - ";
                                $user_text .= get_user_meta($user_info->ID, 'mobile', true);
                                $user_text .= " - ";
                                $user_text .= $user_info->user_email;
                            } else {
                                _e("does not exist", SAMYAR_TEXT_DOMAIN);
                            }
                            ?>
                            <input type="text" disabled
                                   value="<?= $user_text ?>"
                                   placeholder="<?php _e("User Info", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Provider", SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php
                            $providers = \samyar\Provider::all();
                            ?>
                            <select name="api_provider_id" class="form-control square select2">
                                <?php foreach ($providers as $provider) : ?>
                                    <option value="<?= esc_attr($provider->id) ?>" <?php selected($order->api_provider_id, $provider->id); ?>>
                                        <?= esc_html($provider->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Service", SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php
                            $services = (new Service())->getServicesByProvider($order->api_provider_id);
                            $prices = priceController::calculatePricesBatch($services, $order->uid);
                            ?>
                            <select name="service_id" class="form-control square">
                                <?php foreach ($services as $service) : ?>
                                    <option value="<?= esc_attr($service->id) ?>" <?php selected($order->service_id, $service->id); ?>>
                                        <?= esc_html($service->name) ?>
                                        (<?= $prices[$service->id]['price_for_show_formatted'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <input type="hidden" name="calculate-price-difference" value="0">
                            <input type="checkbox" value="1" id="calculate-price-difference" name="calculate-price-difference">
                            <label style="margin: 20px 0;font-size: 15px;font-weight: bold;"
                                   for="calculate-price-difference"><?php _e("Increase/decrease user credit for service price difference", SAMYAR_TEXT_DOMAIN); ?></label>
                        </div>
                    </div>

                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Quantity", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="quantity" dir="ltr" disabled
                                   value="<?php echo esc_attr($order->quantity) ?>"
                                   placeholder="<?php _e("Quantity", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency api_currency"><?= $order->order_currency ?></span>
                                </div>
                                <input type="text" class="form-control" disabled dir="ltr"
                                       placeholder="<?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?>"
                                       value="<?php echo \kandopanel\currencyController::getInstance()->numberFormat($order->charge, $order->order_currency, true) ?>">
                            </div>


                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Cost", SAMYAR_TEXT_DOMAIN); ?></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency api_currency"><?= $order->order_currency ?></span>
                                </div>
                                <input type="text" class="form-control" disabled dir="ltr"
                                       placeholder="<?php _e("Cost", SAMYAR_TEXT_DOMAIN); ?>"
                                       value="<?php echo \kandopanel\currencyController::getInstance()->numberFormat($order->formal_charge, $order->order_currency, true) ?>">
                            </div>

                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e("Profit", SAMYAR_TEXT_DOMAIN); ?></label>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency api_currency"><?= $order->order_currency ?></span>
                                </div>
                                <input type="text" class="form-control" disabled dir="ltr"
                                       placeholder="<?php _e("Profit", SAMYAR_TEXT_DOMAIN); ?>"
                                       value="<?php echo \kandopanel\currencyController::getInstance()->numberFormat($order->profit, $order->order_currency, true) ?>">
                            </div>

                        </div>
                    </div>

                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label><?php _e("Start Counter", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="number" name="start_counter" dir="ltr"
                                   value="<?php echo esc_attr($order->start_counter) ?>"
                                   placeholder="<?php _e("Start", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label><?php _e("Remaining", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="number" name="remains" value="<?php echo esc_attr($order->remains) ?>"
                                   dir="ltr"
                                   placeholder="<?php _e("End", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4" id="select-status-for-edit-order">
                            <label><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="status" class="form-control square">
                                <?php
                                if (in_array($order->status, ['pending', 'processing', 'inprogress'])) {
                                    $order_status_array = ['pending', 'processing', 'inprogress', 'completed', 'partial', 'canceled'];
                                }

                                if ($order->status === 'canceled') {
                                    $order_status_array = ['canceled', 'pending', 'processing', 'inprogress', 'completed'];
                                }

                                if ($order->status === 'completed') {
                                    $order_status_array = ['completed', 'canceled', 'partial', 'pending', 'processing', 'inprogress'];
                                }

                                if ($order->status === 'partial') {
                                    $order_status_array = ['canceled', 'partial', 'completed', 'pending', 'processing', 'inprogress'];
                                }

                                if ($order->status === 'error') {
                                    $order_status_array = ['canceled', 'error', 'partial', 'completed', 'pending', 'processing', 'inprogress'];
                                }

                                if ($order->status === 'awaiting_cancel') {
                                    $order_status_array = ['canceled', 'pending', 'processing', 'inprogress', 'completed'];
                                }

                                if ($order->status === 'awaiting_action') {
                                    $order_status_array = ['canceled', 'pending', 'processing', 'inprogress', 'completed'];
                                }

                                if (!empty($order_status_array)) {
                                    foreach ($order_status_array as $status) {
                                        ?>
                                        <option value="<?= $status ?>" <?= ($order->status && $status === $order->status) ? 'selected' : '' ?> ><?= samyar_order_status_title($status) ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12 refund" style="display: none">
                            <input type="hidden" name="refund" value="0">
                            <input type="checkbox" value="1" id="refund" name="refund" checked>
                            <label style="margin: 20px 0;font-size: 15px;font-weight: bold;"
                                   class="publish-notification"
                                   for="refund"><?php _e("Refund the order amount to the wallet", SAMYAR_TEXT_DOMAIN); ?></label>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e("Link", SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" dir="ltr" name="link" value="<?php echo esc_attr($order->link) ?>"
                                   placeholder="<?php _e("Link", SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>

                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e("Description (You can provide a brief explanation about the reason for canceling the order to the user. This description will be shown below the status)", SAMYAR_TEXT_DOMAIN); ?></label>
                            <textarea name="admin_note"><?php echo esc_attr($order->admin_note) ?></textarea>
                        </div>
                    </div>

                    <?php if (!empty(esc_attr($order->comments))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Comments", SAMYAR_TEXT_DOMAIN); ?></label>
                                <textarea
                                        name="comments"><?php echo nl2br(json_decode($order->comments, true)) ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty(esc_attr($order->usernames))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Usernames", SAMYAR_TEXT_DOMAIN); ?></label>
                                <textarea name="usernames"><?php echo nl2br($order->usernames) ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty(esc_attr($order->usernames))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Mentions Usernames", SAMYAR_TEXT_DOMAIN); ?></label>
                                <textarea
                                        name="mentions_usernames"><?php echo nl2br(json_decode($order->usernames, true)) ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty(esc_attr($order->hashtags))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Hashtags", SAMYAR_TEXT_DOMAIN); ?></label>
                                <textarea name="hashtags"><?php echo nl2br($order->hashtags) ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty(esc_attr($order->hashtag))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Hashtag", SAMYAR_TEXT_DOMAIN); ?></label>
                                <textarea name="hashtag"><?php echo nl2br($order->hashtag) ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty(esc_attr($order->hashtags))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?></label>
                                <textarea name="username"><?php echo nl2br($order->username) ?></textarea>
                            </div>
                        </div>
                    <?php } ?>

                    <input type="submit" class="button button-green new-ticket-form-submit"
                           value="<?php _e("Update", SAMYAR_TEXT_DOMAIN); ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        // Apply Select2 to the desired Selects
        $('select[name="api_provider_id"]').select2();
        $('select[name="service_id"]').select2();

        // Provider change event
        $('select[name="api_provider_id"]').on('change', function () {
            var providerId = $(this).val(); // Get the selected provider ID

            // Send AJAX request
            $.ajax({
                url: kando_data.ajaxurl, // Endpoint URL
                type: 'POST',
                data: {
                    action: 'get_services_by_provider', // Action name
                    provider_id: providerId // Provider ID
                },
                beforeSend: function () {
                    // Show loading (optional)
                    $('select[name="service_id"]').html('<option value=""><?php _e("Loading...", SAMYAR_TEXT_DOMAIN); ?></option>');
                },
                success: function (response) {
                    if (response.success) {
                        var services = response.data; // Get the list of services
                        var options = '<option value=""><?php _e("Select a service", SAMYAR_TEXT_DOMAIN); ?></option>';

                        // Build new options for the services Select
                        $.each(services, function (index, service) {
                            options += '<option value="' + service.id + '">' + service.name + '</option>';
                        });

                        // Update the services Select
                        $('select[name="service_id"]').html(options);
                    } else {
                        // Show error if unsuccessful
                        console.error(response.data);
                    }
                },
                error: function (xhr, status, error) {
                    // Show error if something goes wrong
                    console.error('<?php _e("Error fetching services: ", SAMYAR_TEXT_DOMAIN); ?>' + error);
                }
            });
        });
    });
</script>