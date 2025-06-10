<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 float-left">
        <div class="new-ticket-help">
            <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
            <ul>
                <li><?php _e('You can read the tips related to this section here.', SAMYAR_TEXT_DOMAIN); ?></li>
            </ul>
        </div>
    </div>
    <div class="column kt-col-xs-12 kt-col-md-7 float-left">
        <div class="new-api-form-outer">
            <h4 class="new-ticket-title"><?php _e('Edit Order', SAMYAR_TEXT_DOMAIN); ?></h4>
            <span class="new-ticket-text"><?php _e('Edit the information and click on update.', SAMYAR_TEXT_DOMAIN); ?></span>
            <form method="POST" class="samyar-form update-order-form">
                <input type="hidden" name="action" value="giftcart_order_update">
                <input type="hidden" name="id" value="<?php echo esc_attr($order->id) ?>">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e('Order ID', SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" disabled value="<?php echo esc_attr($order->id) ?>" placeholder="<?php _e('Order ID', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label><?php _e('API Order ID', SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" disabled value="<?php echo esc_attr($order->api_provider_id) ?>" placeholder="<?php _e('API Order ID', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e('User', SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php $user_info = get_user_by('id', $order->uid) ?>
                            <input type="text" disabled value="<?= (!empty($user_info)) ? $user_info->user_email : '' ?>" placeholder="<?php _e('Email', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e('Gift Card', SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php
                            $product = \giftCard\Gift::find($order->service_id);
                            ?>
                            <input type="text" disabled value="<?= (!empty($product)) ? $product->name : '' ?>" placeholder="<?php _e('Gift Card', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e('Gift Card Type', SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php
                            $variant = \giftCard\giftVariant::find_where(['api_variant_id' => $order->api_service_id]);
                            ?>
                            <input type="text" disabled value="<?= (!empty($variant)) ? $variant->title : '' ?>" placeholder="<?php _e('Gift Card Type', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label><?php _e('Quantity', SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="quantity" disabled value="<?php echo esc_attr($order->quantity) ?>" placeholder="<?php _e('Quantity', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label><?php _e('Amount', SAMYAR_TEXT_DOMAIN); ?></label>
                            <input type="text" name="charge" disabled value="<?php echo number_format(esc_attr($order->charge)) ?>" placeholder="<?php _e('Amount', SAMYAR_TEXT_DOMAIN); ?>"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="status" class="form-control square">
                                <?php
                                $order_status_array = ['pending', 'processing', 'completed', 'refunded', 'canceled'];
                                if (!empty($order_status_array)) {
                                    foreach ($order_status_array as $status) {
                                        ?>
                                        <option value="<?= $status ?>" <?= ($order->status && $status === $order->status) ? 'selected' : '' ?> ><?= samyar_order_status_title($status) ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label><?php _e('Serials', SAMYAR_TEXT_DOMAIN); ?></label>
                            <textarea>
                                <?php
                                // Serial data can be added here if needed
                                ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <a href="#" id="addSerial" class="button button-green new-ticket-form-submit"><?php _e('Add Gift Card Information', SAMYAR_TEXT_DOMAIN); ?></a>
                        </div>
                        <div id="serialContainer">
                            <?php
                            $serials = get_order_meta($order->id, 'serials', true);
                            $serials = unserialize($serials);
                            $serials = is_array($serials) ? $serials : [];
                            if (count($serials)) {
                                foreach ($serials as $key => $serial) { ?>
                                    <div class="kt-col-md-12">
                                        <div class="column kt-col-xs-12 kt-col-md-3">
                                            <label><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="text" name="serial[<?= $key ?>][title]" value="<?= esc_attr($serial['title']) ?>" placeholder="<?php _e('Title', SAMYAR_TEXT_DOMAIN); ?>"/>
                                        </div>
                                        <div class="column kt-col-xs-12 kt-col-md-9">
                                            <label><?php _e('Serial', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="text" name="serial[<?= $key ?>][serial]" value="<?= esc_attr($serial['serial']) ?>" placeholder="<?php _e('Serial', SAMYAR_TEXT_DOMAIN); ?>"/>
                                        </div>
                                    </div>
                                <?php }
                            }
                            ?>
                        </div>
                    </div>
                    <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Update', SAMYAR_TEXT_DOMAIN); ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $('#addSerial').click(function (e) {
            e.preventDefault();
            var $key = Math.floor((Math.random() * 1000000000));
            $('#serialContainer').append('<div class="kt-col-md-12"><div class="column kt-col-xs-12 kt-col-md-3"><label><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></label><input type="text" name="serial[' + $key + '][title]" value="" placeholder="<?php _e('Title', SAMYAR_TEXT_DOMAIN); ?>"/></div><div class="column kt-col-xs-12 kt-col-md-6"><label><?php _e('Serial', SAMYAR_TEXT_DOMAIN); ?></label><input type="text" name="serial[' + $key + '][serial]" value="" placeholder="<?php _e('Serial', SAMYAR_TEXT_DOMAIN); ?>"/></div><div class="column kt-col-xs-12 kt-col-md-3"></div></div>');
        });
    });
</script>