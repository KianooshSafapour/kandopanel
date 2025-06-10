<?php

use samyar\priceController;
use samyar\Service;

$options = settingsController::getInstance();
?>
<tr class="style2 border-left" id="order-<?php echo esc_attr($order->id) ?>">
    <?php if (isset($_GET['status']) && ($_GET['status'] === "pending" || $_GET['status'] === "inprogress" || $_GET['status'] === "processing" || $_GET['status'] === "error" || $_GET['status'] === "late_update_status")): ?>
        <td rowspan="2" data-title="<?php _e("select", SAMYAR_TEXT_DOMAIN); ?>">
            <input type="checkbox" class="kando-cb-checkbox" value="1" id="cb-select-<?php echo esc_attr($order->id) ?>"
                   name="cb-select-<?php echo esc_attr($order->id) ?>">
            <label class="kando-cb-label" for="cb-select-<?php echo esc_attr($order->id) ?>"></label>
        </td>
    <?php endif; ?>
    <td style="text-align: center;width:20px" rowspan="2" data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($order->id) ?>
    </td>
    <td class="border-left" data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        //        $service = Service::find($order->service_id);
        ?>

        <?php if ($order->service_type == "giftcart") {

            include(SAMYAR_DIR_VIEW . '/orders/gift/gift.php');

        } else { ?>

            <?php if ($order->service_id && $order->service_name) { ?>
                <h4 class="op-service-title">
                    <a href="#"><span
                                class="button button-violet mini-btn"><?php echo esc_attr($order->service_id) ?></span> <?php echo esc_attr($order->service_name) ?>
                    </a>
                </h4>
            <?php } ?>
            <?php if (kando_user_can('show_order_provider_info')) { ?>
                <ul class="">
                    <?php if ($order->api_provider_id !== "0"): ?>
                        <li class="mt-3"><span
                                    class="button button-violet mini-btn"><?php _e("Provider:", SAMYAR_TEXT_DOMAIN); ?></span>
                            &nbsp;<?php echo esc_attr($order->provider_name) ?>
                            (<?= $order->api_provider_id ?>)
                        </li>
                    <?php else: ?>
                        <li class="mt-2"><span
                                    class="button button-violet mini-btn"><?php _e("Provider:", SAMYAR_TEXT_DOMAIN); ?></span>
                            &nbsp;<?php _e("Manual", SAMYAR_TEXT_DOMAIN); ?></li>
                    <?php endif; ?>
                    <li class="mt-2">
                        <span class="button button-violet mini-btn"><?php _e("Order registration type:", SAMYAR_TEXT_DOMAIN); ?></span>
                        <?php

                        if ($order->type === 'api') {
                            //سایت کاربری که درخواست داده رو هم نشون میده
                            $site_url = get_order_meta($order->id, 'site_url', true);
                            $your_domain = get_user_meta($order->uid, "your_domain", true);
                            if ($site_url && !empty($site_url)) {
                                $site_url = '<span class="button button-green badge-error-orders">' . $site_url . '</span>';
                            } else if ($your_domain && !empty($your_domain)) {
                                $site_url = '<span class="button button-green badge-error-orders">' . $your_domain . '</span>';
                            } else {
                                $site_url = "";
                            }

                            echo ' <span class="button button-orange badge-error-orders">API</span>' . $site_url;
                        } else {
                            echo ' <span class="button button-blue badge-error-orders">' . __("Site", SAMYAR_TEXT_DOMAIN) . '</span>';
                        }
                        ?>
                    </li>
                    <li class="mt-2"><span class="button button-violet mini-btn">(<span
                                    style=""><?php _e("cost", SAMYAR_TEXT_DOMAIN); ?></span>/<span
                                    style=""><?php _e("Profit", SAMYAR_TEXT_DOMAIN); ?></span>):</span> (<span
                                style="color:#3ca235"><?php echo priceController::kandoFormatPrice($order->profit)['price_for_show_formatted'] ?></span>/<span
                                style="color:#f58"><?php echo priceController::kandoFormatPrice($order->formal_charge)['price_for_show_formatted'] ?></span>)
                    </li>
                </ul>
            <?php } ?>
        <?php } ?>
    </td>
    <td data-title="<?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format . ' ' . $time_format, strtotime($order->created_at))
        ?>
    </td>
    <td data-title="<?php _e("status", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        if (kando_is_normal_user() && in_array($order->status, ['fail', 'error'])) {
            $order->status = 'processing';
        }
        ?>
        <span style="display: inline-block;" class="button order-status <?= samyar_status_color($order->status) ?>">
                                <?php echo samyar_order_status_title(esc_attr($order->status)); ?>
                            </span>
        <?php if (kando_is_normal_user() && ($order->status === "awaiting")): ?>
            <span class="button button-red repayment-order kt-modal-button" data-modal="repayment"
                  data-id="<?php echo esc_attr($order->id) ?>"><?php _e("Repayment", SAMYAR_TEXT_DOMAIN); ?></span>
        <?php endif; ?>
        <?php
        if (samyar_is_admin() || kando_is_supporter()) {
            if ($order->update_at) {
                echo '<br>';
//                echo '<br><span class="order_status_data">'.kando_date_ago($order->update_at)."&nbsp".__("It was checked", SAMYAR_TEXT_DOMAIN).'</span>';
                echo '<span class="order_status_data">' . sprintf(__('%s It was checked', SAMYAR_TEXT_DOMAIN), kando_date_ago($order->update_at, false)) . '</span>';
            }
        }

        if ($order->admin_note) {
            echo '<br><span class="order_status_data">' . $order->admin_note . '</span>';
        }

        ?>
    </td>
    <?php if (kando_user_can('show_order_user_info')) { ?>
        <td data-title="<?php _e("User information", SAMYAR_TEXT_DOMAIN); ?>">
            <?php
            $user = get_user_by('id', $order->uid);
            if ($user) {
                echo $user->display_name;
                echo "<br>";
                echo get_user_meta($user->ID, 'mobile', true);
            } else {
                _e("does not exist", SAMYAR_TEXT_DOMAIN);
            }

            ?>
        </td>
    <?php } ?>
    <?php if (kando_user_can('show_order_provider_id')) { ?>
        <td data-title="<?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?>"
        >
            <?php echo ($order->api_order_id == "0" || $order->api_order_id == "-1") ? "" : $order->api_order_id ?>
        </td>
        <td data-title="<?php _e("API response", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo esc_attr($order->note) ?>
        </td>
    <?php } ?>
    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">


        <?php if ($order->status === "awaiting_cancel") { ?>
            <?php
            $delay_time_order = (int)kando_get_option('delay-time-order', 10);
            $date2 = new DateTime(date("Y-m-d H:i:s", strtotime("+$delay_time_order minute", strtotime($order->created_at))));
            ?>
            <span class="wating-timer" id="wating-timer-<?= $order->id ?>"></span>
            <script type="text/javascript">
                kando_count_time("<?php echo $date2->format('Y m d H:i:s') ?>", "wating-timer-<?=$order->id?>", <?php _e("Opportunity to cancel the order", SAMYAR_TEXT_DOMAIN); ?>,)
            </script>
            <span class="button button-red btn-small cancel-order" data-id="<?php echo esc_attr($order->id) ?>"
                  data-tooltip="<?php _e("cancel", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-ban"></i></span>
            <span class="button button-aqua btn-small fast-send-order" data-id="<?php echo esc_attr($order->id) ?>"
                  data-tooltip="<?php _e("send now", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-share-square"></i></span>
        <?php } ?>

        <?php if (kando_user_can('edit_order')) { ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($order->id))) ?>">
                                    <span class="button button-default btn-small"
                                          data-tooltip="<?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?>">
                                        <i class="fal fa-edit"></i>
                                    </span>
            </a>
        <?php } ?>
        <?php if (kando_user_can('delete_order')) { ?>
            <?php
            $status = ["pending", "error", "awaiting"];
            if (in_array($order->status, $status, true)) {
                ?>
                <span class="button button-aqua btn-small delete-order" data-id="<?php echo esc_attr($order->id) ?>"
                      data-tooltip="<?php _e("remove", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-trash"></i></span>
            <?php } ?>
        <?php } ?>
        <?php if (kando_user_can('show_order_approve')) { ?>
            <?php if ($order->status === "error"): ?>
                <span class="button button-red btn-small resend-order" data-id="<?php echo esc_attr($order->id) ?>"
                      data-tooltip="<?php _e("Resend", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-redo"></i></span>
                <?php if ($order->error_to_pending == 0) { ?>
                    <span class="button button-red btn-small auto-to-pending"
                          data-id="<?php echo esc_attr($order->id) ?>"
                          data-tooltip="<?php _e("Enable Automatic Resend (Every 5 Minutes)", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-sync"></i></span>
                <?php } ?>
            <?php endif; ?>
            <!--                                                        <a href=""><span class="button button-red btn-small">ارسال مجدد</span></a>-->
            <!--                        <a href=""><span class="button button-aqua btn-small">ویرایش</span></a>-->

            <?php if ((int)$order->api_order_id > 0 && (int)$order->api_provider_id > 0): ?>
                <span class="button button-blue btn-small kt-modal-button kando-show-info" data-modal="info"
                      data-order="<?php echo esc_attr($order->id) ?>" data-type="status"
                      data-tooltip="<?php _e("Checking the status of the order in the provider", SAMYAR_TEXT_DOMAIN); ?>"><i
                            class="fas fa-info-circle"></i></span>
            <?php endif; ?>


            <?php
            //اگر وضعیت در انتظار اقدام هست دکمه تایید رو نشون بده
            if ($order->status == "awaiting_action") {
                ?>
                <a href="#"><span class="button button-blue btn-small kando-approve-awaiting-action"
                                  data-id="<?php echo esc_attr($order->id) ?>"
                                  data-tooltip="<?php _e('Approve', SAMYAR_TEXT_DOMAIN) ?>"><i class="far fa-check"></i></span></a>
            <?php } ?>

        <?php } ?>
        <!--end-->
        <span class="button button-red btn-small kt-modal-button kando-show-info" data-modal="info"
              data-order="<?php echo esc_attr($order->id) ?>" data-type="payments"
              data-tooltip="<?php _e("Transaction history", SAMYAR_TEXT_DOMAIN); ?>"><i
                    class="fal fa-envelope-open-dollar"></i></span>

        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new&order-id=' . esc_attr($order->id))) ?>"><span
                    class="button button-violet btn-small"
                    data-tooltip="<?php _e("Send a ticket related to this order", SAMYAR_TEXT_DOMAIN); ?>"><i
                        class="fal fa-ticket"></i></span></a>


        <!--هر 24 ساعت نمایش داده میشه و کاربر اگر ارسال کنه این دکمه ناپدید میشه-->
        <?php
        $refil_enable = kando_refill_enable($order->id);
        if ($refil_enable) {
            ?>
            <a href="#"><span class="button button-blue btn-small kando-send-refill"
                              data-id="<?php echo esc_attr($order->id) ?>"
                              data-tooltip="<?php _e('Refill', SAMYAR_TEXT_DOMAIN) ?>"><i
                            class="far fa-repeat-alt"></i></span></a>
        <?php } ?>
    </td>
</tr>

<tr class="style2 order-<?php echo esc_attr($order->id) ?>">
    <td colspan="8" class="border-left">
        <div class="kt-row" style="margin: 0">
            <div class="kt-col-md-3 kt-col-sm-12 kt-col-xs-12 mb-3 mb-lg-0">
                <div class="op-item">

                    <div class="text">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn button-default CopyToClipBoard2"
                                        style="height: 28px;border-radius: 5px 0 0 5px;font-size: 13px;"
                                        href="<?= $order->link ?>"
                                        type="button"><i class="fal fa-copy"></i></button>
                            </div>
                            <input type="text" class="form-control" dir="ltr"
                                   style="padding: 0 0 0 5px;height: 28px;border-radius: 0 5px 5px 0;" disabled
                                   value="<?= $order->link ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-col-md-2 kt-col-sm-6 kt-col-xs-6 mb-3 mb-lg-0">
                <div class="op-item">
                    <div class="title"><?php _e("Quantity:", SAMYAR_TEXT_DOMAIN); ?></div>
                    <div class="text">
                        <?php echo esc_attr($order->quantity) ?>
                        <?php
                        //تعداد هدیه
                        $quantity_gift = \samyar\Ometa::find_where(['order_id' => $order->id, 'meta_key' => 'quantity_gift']);
                        $quantity_gift = $quantity_gift->meta_value ?? NULL;
                        ?>
                        <?php if ($quantity_gift !== NULL) { ?>
                            <span style="color:#f58">(<?php _e("Quantity gift", SAMYAR_TEXT_DOMAIN); ?>:<?php echo $quantity_gift ?>)</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="kt-col-md-2 kt-col-sm-6 kt-col-xs-6 mb-3 mb-lg-0">
                <div class="op-item">
                    <div class="title"><?php _e("Charge:", SAMYAR_TEXT_DOMAIN); ?></div>
                    <div class="text"><?php echo priceController::kandoFormatPrice($order->charge)['price_for_show_formatted'] ?></div>
                </div>
            </div>
            <div class="kt-col-md-2 kt-col-sm-6 kt-col-xs-6 mb-3 mb-lg-0">
                <div class="op-item">
                    <div class="title"><?php _e("Start count:", SAMYAR_TEXT_DOMAIN); ?></div>
                    <div class="text"><?php echo esc_attr($order->start_counter) ?></div>
                </div>
            </div>
            <div class="kt-col-md-2 kt-col-sm-6 kt-col-xs-6 mb-3 mb-lg-0">
                <div class="op-item">
                    <div class="title"><?php _e("Remains:", SAMYAR_TEXT_DOMAIN); ?></div>
                    <div class="text"><?php echo esc_attr($order->remains) ?></div>
                </div>
            </div>
            <div class="kt-col-md-2 kt-col-sm-12 kt-col-xs-12">
                <div class="op-item">
                    <div class="title">
                        <?php
                        $cancel_status = ["processing", "inprogress", "pending"];
                        if (in_array($order->status, $cancel_status, true) && $order->service_cancel):
                            ?>
                            <span class="button button-red cancel-in-order" data-id="<?php echo esc_attr($order->id) ?>"
                                  data-tooltip="<?php _e("cancel", SAMYAR_TEXT_DOMAIN); ?>"><?php _e("cancel", SAMYAR_TEXT_DOMAIN); ?></span>
                        <?php endif; ?>

                        <?php if ($order->user_note && kando_user_can('show_order_provider_info')): ?>

                            <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view the user\'s message', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="user-note"
                                    data-order="<?= $order->id ?>"><?php _e('User message', SAMYAR_TEXT_DOMAIN); ?>
                            </button>

                        <?php endif; ?>
                        <?php
                        $gift_carts = get_order_meta($order->id, 'gift_carts', true);
                        $gift_carts = unserialize($gift_carts);
                        if ($gift_carts): ?>

                            <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click for order details', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="gift_cards"
                                    data-info="gift-cards"
                                    data-order="<?= $order->id ?>"><?php _e("Order details", SAMYAR_TEXT_DOMAIN); ?>
                            </button>

                        <?php endif; ?>

                        <?php
                        switch ($order->service_type) {
                            case 'custom_comments':
                            case 'custom_comments_package':
                                ?>

                                <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                        data-tooltip="<?php _e('Click to view comments', SAMYAR_TEXT_DOMAIN); ?>"
                                        data-type="order"
                                        data-info="comments"
                                        data-order="<?= $order->id ?>"><?php _e("Comments", SAMYAR_TEXT_DOMAIN); ?>
                                </button>

                                <?php
                                break;
                            case 'mentions_with_hashtags':
                                ?>

                                <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                        data-tooltip="<?php _e('Click to view usernames', SAMYAR_TEXT_DOMAIN); ?>"
                                        data-type="order"
                                        data-info="usernames"
                                        data-order="<?= $order->id ?>"><?php _e("Usernames", SAMYAR_TEXT_DOMAIN); ?>
                                </button>


                                <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                        data-tooltip="<?php _e('Click to view hashtags', SAMYAR_TEXT_DOMAIN); ?>"
                                        data-type="order"
                                        data-info="hashtags"
                                        data-order="<?= $order->id ?>"><?php _e("Hashtags", SAMYAR_TEXT_DOMAIN); ?>
                                </button>

                                <?php
                                break;
                            case 'mentions_custom_list':
                            case 'mentions':
                                ?>

                                <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                        data-tooltip="<?php _e('Click to view usernames', SAMYAR_TEXT_DOMAIN); ?>"
                                        data-type="order"
                                        data-info="mentions_usernames"
                                        data-order="<?= $order->id ?>"><?php _e("Usernames", SAMYAR_TEXT_DOMAIN); ?>
                                </button>

                                <?php
                                break;
                            case 'mentions_hashtag':
                                ?>

                                <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                        data-tooltip="<?php _e('Click to view hashtags', SAMYAR_TEXT_DOMAIN); ?>"
                                        data-type="order"
                                        data-info="hashtag"
                                        data-order="<?= $order->id ?>"><?php _e("Hashtags", SAMYAR_TEXT_DOMAIN); ?>
                                </button>

                                <?php
                                break;
                            case 'mentions_user_followers':
                            case 'comment_likes':
                                ?>

                                <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                        data-tooltip="<?php _e('Click to view username', SAMYAR_TEXT_DOMAIN); ?>"
                                        data-type="order"
                                        data-info="username"
                                        data-order="<?= $order->id ?>"><?php _e("Username", SAMYAR_TEXT_DOMAIN); ?>
                                </button>

                                <?php
                                break;
                            case 'mentions_media_likers':
                                ?>
                                <?php _e("Media link:", SAMYAR_TEXT_DOMAIN); ?><?php
                                if (filter_var($order->media, FILTER_VALIDATE_URL)) {
                                    echo '<a href="' . $order->media . '" target="_blank">' . samyar_truncate_string($order->media, 35) . '</a>';
                                } else {
                                    echo samyar_truncate_string($order->media, 35);
                                }
                                ?>
                                <?php
                                break;
                        }
                        ?>

                        <?php if (isset($order) && !empty($order->service_name) && ($order->is_drip_feed || $order->service_type === "subscriptions")) {
                            if ($order->is_drip_feed) {
                                echo '<a href="' . esc_attr(home_url('dashboard/?action=orders&section=dripfeed&main-id=' . esc_attr($order->id))) . '" class="button button-blue badge-error-orders" data-tooltip="' . __("Click to view orders", SAMYAR_TEXT_DOMAIN) . '" data-type="order" data-info="comments" data-order="<?= $order->id ?>">' . __("Drip feed", SAMYAR_TEXT_DOMAIN) . '</a>';
                            } elseif ($order->service_type === "subscriptions") {
                                echo '<a href="' . esc_attr(home_url('dashboard/?action=orders&section=subscriptions&main-id=' . esc_attr($order->id))) . '" class="button button-blue badge-error-orders" data-tooltip="' . __("Click to view orders", SAMYAR_TEXT_DOMAIN) . '" data-type="order" data-info="comments" data-order="<?= $order->id ?>">' . __("Subscription", SAMYAR_TEXT_DOMAIN) . '</a>';
                            }
                        } ?>
                    </div>
                </div>
            </div>

        </div>
    </td>
</tr>