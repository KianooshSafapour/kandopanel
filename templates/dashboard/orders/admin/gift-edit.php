<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 float-left">
        <div class="new-ticket-help">
            <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
            <ul>
                <li>نکات مربوط به این قسمت را می توانید اینجا بخوانید</li>

            </ul>
        </div>
    </div>
    <div class="column kt-col-xs-12 kt-col-md-7 float-left">
        <div class="new-api-form-outer">
            <h4 class="new-ticket-title">ویرایش سفارش</h4>
            <span class="new-ticket-text">اطلاعات را ویرایش کرده و بر روی بروزرسانی کلیک کنید</span>
            <form method="POST" class="samyar-form update-order-form">
                <input type="hidden" name="action" value="giftcart_order_update">
                <input type="hidden" name="id" value="<?php echo esc_attr($order->id) ?>">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>شناسه سفارش</label>
                            <input type="text" disabled value="<?php echo esc_attr($order->id) ?>" placeholder="شناسه سفارش"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>شناسه سفارش (OrderID) API</label>
                            <input type="text" disabled value="<?php echo esc_attr($order->api_provider_id) ?>" placeholder="شناسه سفارش(OrderID) API"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <!--                        <div class="column kt-col-xs-12 kt-col-md-12">-->
                        <!--                            <label>نوع</label>-->
                        <!--                            <input type="text" disabled value="-->
                        <?php //= ( ! empty( $order->api_order_id ) && $order->api_order_id != 0 ) ? "API" : "دستی" ?><!--" placeholder="نوع"/>-->
                        <!--                        </div>-->
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>کاربر</label>
                            <?php $user_info = get_user_by('id', $order->uid) ?>
                            <input type="text" disabled value="<?= (!empty($user_info)) ? $user_info->user_email : '' ?>" placeholder="ایمیل"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>گیفت کارت</label>
                            <?php

                            $product = \giftCard\Gift::find($order->service_id);
                            ?>
                            <input type="text" disabled value="<?= (!empty($product)) ? $product->name : '' ?>" placeholder="گیفت کارت"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>نوع گیفت کارت</label>
                            <?php

                            $variant = \giftCard\giftVariant::find_where(['api_variant_id' => $order->api_service_id]);
                            ?>
                            <input type="text" disabled value="<?= (!empty($variant)) ? $variant->title : '' ?>" placeholder="نوع گیفت کارت"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label>تعداد</label>
                            <input type="text" name="quantity" disabled value="<?php echo esc_attr($order->quantity) ?>" placeholder="تعداد"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label>مبلغ</label>
                            <input type="text" name="charge" disabled value="<?php echo number_format(esc_attr($order->charge)) ?>" placeholder="مبلغ"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label>وضعیت</label>
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
                        <?php
                        //                        $serials = get_order_meta($order->id,'serials',true);
                        //                        if($serials){
                        ?>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>سریال ها</label>
                            <textarea>
                                <?php
                                //                                if(is_array($serials)){
                                //                                    foreach ($serials as $serial){
                                //                                        echo $serial;
                                //                                        echo "<br>";
                                //                                    }
                                //                                }else{
                                //                                    print_r($serials);
                                //                                }

                                ?>
                            </textarea>
                        </div>
                        <!--                        --><?php //} ?>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <a href="#" id="addSerial" class="button button-green new-ticket-form-submit">افزودن اطلاعات گیفت کارت</a>
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
                                            <label>عنوان</label>
                                            <input type="text" name="serial[<?= $key ?>][title]" value="<?= esc_attr($serial['title']) ?>" placeholder="عنوان"/>
                                        </div>
                                        <div class="column kt-col-xs-12 kt-col-md-9">
                                            <label>سریال</label>
                                            <input type="text" name="serial[<?= $key ?>][serial]" value="<?= esc_attr($serial['serial']) ?>" placeholder="سریال"/>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <input type="submit" class="button button-green new-ticket-form-submit" value="بروزرسانی"/>
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
            $('#serialContainer').append('<div class="kt-col-md-12"><div class="column kt-col-xs-12 kt-col-md-3"><label>عنوان</label><input type="text" name="serial[' + $key + '][title]" value="" placeholder="عنوان"/></div><div class="column kt-col-xs-12 kt-col-md-6"><label>سریال</label><input type="text" name="serial[' + $key + '][serial]" value="" placeholder="سریال"/></div><div class="column kt-col-xs-12 kt-col-md-3"></div></div>');
        });
    });
</script>