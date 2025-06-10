<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 float-left">
        <div class="new-ticket-help">
            <img src="<?php use samyar\Order;
            use samyar\Service;

            echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
            <ul>
                <li>نکات مربوط به این قسمت را می توانید اینجا بخوانید</li>

            </ul>
        </div>
    </div>
    <div class="column kt-col-xs-12 kt-col-md-7 float-left">
        <div class="new-api-form-outer">
            <h4 class="new-ticket-title">ویرایش سفارش</h4>
            <span class="new-ticket-text">اطلاعات را وارد کرده و بر روی ارسال کلیک کنید</span>
            <form method="POST" class="samyar-form update-order-form">
                <input type="hidden" name="action" value="samyar_order_edit">
                <input type="hidden" name="id" value="<?php echo esc_attr( $order->id ) ?>">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>شناسه سفارش</label>
                            <input type="text" disabled value="<?php echo esc_attr( $order->id ) ?>" placeholder="شناسه سفارش"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>شناسه سفارش (OrderID) API</label>
                            <input type="text" disabled value="<?php echo esc_attr( $order->api_provider_id ) ?>" placeholder="شناسه سفارش(OrderID) API"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>نوع</label>
	                        <?php if ($order->api_provider_id !== "0"): ?>
                                <input type="text" disabled value="api" placeholder="نوع"/>
	                        <?php else: ?>
                                <input type="text" disabled value="دستی" placeholder="نوع"/>
	                        <?php endif; ?>

                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>کاربر</label>
                            <?php $user_info = get_user_by( 'id', $order->uid ) ?>
                            <input type="text" disabled value="<?= ( ! empty( $user_info ) ) ? $user_info->user_email : '' ?>" placeholder="ایمیل"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>سرویس</label>
                            <?php
                            $service = Service::find( $order->service_id );
                            ?>
                            <input type="text" disabled value="<?= ( ! empty( $service ) ) ? $service->name : '' ?>" placeholder="سرویس"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>تعداد</label>
                            <input type="text" name="quantity" disabled value="<?php echo esc_attr( $order->quantity ) ?>" placeholder="تعداد"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-6">
                            <label>مبلغ</label>
                            <input type="text" name="charge" disabled value="<?php echo number_format( esc_attr( $order->charge ) ) ?>" placeholder="مبلغ"/>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label>شروع شمارنده</label>
                            <input type="number" name="start_counter" value="<?php echo esc_attr( $order->start_counter ) ?>" placeholder="شروع"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4">
                            <label>باقی مانده</label>
                            <input type="number" name="remains" value="<?php echo esc_attr( $order->remains ) ?>" placeholder="پایان"/>
                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-4" id="select-status-for-edit-order">
                            <label>وضعیت</label>
                            <select name="status" class="form-control square">
                                <?php
                                if ( in_array( $order->status, [ 'pending', 'processing', 'inprogress' ] ) ) {
                                    $order_status_array = [ 'pending', 'processing', 'inprogress', 'completed', 'partial', 'canceled' ];
                                }

                                if ( $order->status === 'canceled' ) {
                                    $order_status_array = [ 'canceled','pending', 'processing', 'inprogress', 'completed' ];
                                }

                                if ( $order->status === 'completed' ) {
                                    $order_status_array = [ 'completed', 'canceled', 'partial','pending', 'processing', 'inprogress' ];
                                }

                                if ( $order->status === 'partial' ) {
                                    $order_status_array = [ 'canceled', 'partial','completed','pending', 'processing', 'inprogress'];
                                }

                                if ( $order->status === 'error' ) {
                                    $order_status_array = [ 'canceled', 'error', 'partial', 'completed','pending', 'processing', 'inprogress' ];
                                }

                                if ( $order->status === 'awaiting_cancel' ) {
                                    $order_status_array = [ 'canceled','pending', 'processing', 'inprogress','completed' ];
                                }

                                if ( $order->status === 'awaiting_action' ) {
                                    $order_status_array = [ 'canceled','pending', 'processing', 'inprogress','completed' ];
                                }

                                if ( ! empty( $order_status_array ) ) {
                                    foreach ( $order_status_array as $status ) {
                                        ?>
                                        <option value="<?= $status ?>" <?= ( $order->status && $status === $order->status ) ? 'selected' : '' ?> ><?= samyar_order_status_title( $status ) ?></option>
                                    <?php }
                                } ?>
                            </select>


                        </div>
                        <div class="column kt-col-xs-12 kt-col-md-12 refund" style="display: none">
                            <input type="hidden" name="refund" value="0">
                            <input type="checkbox" value="1" id="refund" name="refund" checked>
                            <label style="margin: 20px 0;font-size: 15px;font-weight: bold;" class="publish-notification" for="refund">مبلغ سفارش به کیف پول واریز شود</label>
                        </div>
                    </div>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>لینک</label>
                            <input type="text" dir="ltr" name="link" value="<?php echo esc_attr( $order->link ) ?>" placeholder="لینک"/>
                        </div>
                    </div>

                    <div class="kt-row">
                        <div class="column kt-col-xs-12 kt-col-md-12">
                            <label>توضیحات(می توانید توضیحات کوتاهی در مورد علت لغو سفارش به کاربر نشان دهید. این توضیح زیر وضعیت نمایش داده خواهد شد)</label>
                            <textarea name="admin_note"><?php echo esc_attr( $order->admin_note ) ?></textarea>
                        </div>
                    </div>

                    <?php
                    if (!empty(esc_attr($order->comments))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label>کامنت ها</label>
                                <textarea name="comments"><?php echo nl2br(json_decode($order->comments, true)) ?></textarea>
                            </div>
                        </div>
                   <?php }  ?>
                    <?php
                    if (!empty(esc_attr($order->usernames))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label>نام کاربری ها</label>
                                <textarea name="usernames"><?php echo nl2br($order->usernames) ?></textarea>
                            </div>
                        </div>
                    <?php }  ?>
                    <?php
                    if (!empty(esc_attr($order->usernames))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label>mentions usernames</label>
                                <textarea name="mentions_usernames"><?php echo nl2br(json_decode($order->usernames, true)) ?></textarea>
                            </div>
                        </div>
                    <?php }  ?>
                    <?php
                    if (!empty(esc_attr($order->hashtags))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label>هشتگ ها</label>
                                <textarea name="hashtags"><?php echo nl2br($order->hashtags) ?></textarea>
                            </div>
                        </div>
                    <?php }  ?>
                    <?php
                    if (!empty(esc_attr($order->hashtag))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label>هشتگ</label>
                                <textarea name="hashtag"><?php echo nl2br($order->hashtag) ?></textarea>
                            </div>
                        </div>
                    <?php }  ?>
                    <?php
                    if (!empty(esc_attr($order->hashtags))) { ?>
                        <div class="kt-row">
                            <div class="column kt-col-xs-12 kt-col-md-12">
                                <label>نام کاربری</label>
                                <textarea name="username"><?php echo nl2br($order->username) ?></textarea>
                            </div>
                        </div>
                    <?php }  ?>

                    <input type="submit" class="button button-green new-ticket-form-submit" value="بروزرسانی"/>
                </div>
            </form>
        </div>
    </div>

</div>