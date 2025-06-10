<?php

use samyar\Service;

$options = settingsController::getInstance();
?>
<tr id="order-<?php echo esc_attr($order->id) ?>">
    <?php if (isset($_GET['status']) && ($_GET['status'] === "pending" || $_GET['status'] === "inprogress" || $_GET['status'] === "processing" || $_GET['status'] === "error" || $_GET['status'] === "late_update_status")): ?>
        <td data-title="<?php _e("select", SAMYAR_TEXT_DOMAIN); ?>">
            <input type="checkbox" class="kando-cb-checkbox" value="1" id="cb-select-<?php echo esc_attr($order->id) ?>"
                   name="cb-select-<?php echo esc_attr($order->id) ?>">
            <label class="kando-cb-label" for="cb-select-<?php echo esc_attr($order->id) ?>"></label>
        </td>
    <?php endif; ?>
    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
        <?php echo esc_attr($order->id) ?>
    </td>
    <td data-title="<?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format . ' ' . $time_format, strtotime($order->created_at))
        ?>
    </td>
    <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
        <?php
        $service = Service::find($order->service_id);
        ?>

        <?php if ($order->service_type == "giftcart") {

            include('order/gift.php');

        } else { ?>
            <ul class="order-details">
                <?php if ($service): ?>
                    <li><?php _e("Service:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr($service->id) ?>
                        &nbsp;-&nbsp;<?php echo esc_attr($service->name) ?></li>
                <?php endif; ?>
                <?php if (kando_user_can('show_order_provider_info')): ?>
                    <?php if ($order->api_provider_id !== "0" && $provider): ?>
                        <li><?php _e("Provider:", SAMYAR_TEXT_DOMAIN); ?> &nbsp;<?php echo esc_attr($provider->name) ?>
                            (<?= $provider->id ?>)
                        </li>
                    <?php else: ?>
                        <li><?php _e("Provider: Manual", SAMYAR_TEXT_DOMAIN); ?></li>
                    <?php endif; ?>

                    <li>
                        <?php _e("Order registration type:", SAMYAR_TEXT_DOMAIN); ?>
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

                <?php endif; ?>


                <li><?php _e("Link:", SAMYAR_TEXT_DOMAIN); ?><?php
                    if (filter_var($order->link, FILTER_VALIDATE_URL)) {
                        echo '&nbsp;';
                        echo '<a class="CopyToClipBoard2" href="' . $order->link . '" target="_blank"><i class="fal fa-copy"></i>&nbsp;' . samyar_truncate_string($order->link, 35) . '</a>';
                    } else {
                        echo '&nbsp;';
                        echo samyar_truncate_string($order->link, 35);
                    }
                    $followers = get_order_meta($order->id, 'followers', true);
                    $following = get_order_meta($order->id, 'following', true);
                    $likes = get_order_meta($order->id, 'like', true);
                    $views = get_order_meta($order->id, 'views', true);
                    $comments = get_order_meta($order->id, 'comments', true);
                    if ($followers) {
                        echo '<br>';
                        echo 'دنبال کننده: ' . number_format($followers);
                    }
                    if ($following) {
                        echo '<br>';
                        echo 'دنبال شونده: ' . number_format($following);
                    }
                    if ($likes) {
                        echo '<br>';
                        echo 'لایک: ' . number_format($likes);
                    }
                    if ($views) {
                        echo '<br>';
                        echo 'ویو: ' . number_format($views);
                    }
                    if ($comments) {
                        echo '<br>';
                        echo 'کامنت: ' . number_format($comments);
                    }
                    ?>

                </li>
                <?php

                //تعداد به همراه هدیه
                $quantity_by_gift = \samyar\Ometa::find_where(['order_id' => $order->id, 'meta_key' => 'quantity_by_gift']);
                if (!$quantity_by_gift) {
                    $quantity_by_gift = NULL;
                } else {
                    $quantity_by_gift = $quantity_by_gift->meta_value;
                }
                ?>
                <li><?php _e("Quantity:", SAMYAR_TEXT_DOMAIN); ?>  <?php echo esc_attr($order->quantity) ?>
                    <?php if ($quantity_by_gift !== NULL && kando_user_can('show_order_provider_info')) { ?>
                        <span style="color:#f58">(<?php _e("with a gift", SAMYAR_TEXT_DOMAIN); ?>:<?= $quantity_by_gift ?>)</span>
                    <?php } ?>
                </li>
                <li><?php _e("amount:", SAMYAR_TEXT_DOMAIN); ?><?php echo kandoConvertCurrency((int)$order->charge) ?></li>
                <?php if (kando_user_can('show_order_provider_info')): ?>
                    <li>(<span style="color:#f58"><?php _e("cost", SAMYAR_TEXT_DOMAIN); ?></span>/<span
                                style="color:#3ca235"><?php _e("Profit", SAMYAR_TEXT_DOMAIN); ?></span>): (<span
                                style="color:#3ca235"><?php echo number_format_i18n(esc_attr((int)$order->profit)) ?></span>/<span
                                style="color:#f58"><?php echo number_format_i18n(esc_attr((int)$order->formal_charge)) ?></span>) <?php kando_get_currency_base_text() ?>
                    </li>
                <?php endif; ?>
                <li><?php _e("Start counter:", SAMYAR_TEXT_DOMAIN); ?><?php echo esc_attr($order->start_counter) ?> </li>
                <li> <?php _e("remaining:", SAMYAR_TEXT_DOMAIN); ?><?php echo esc_attr($order->remains) ?> </li>
                <?php if ($order->user_note && kando_user_can('show_order_provider_info')): ?>
                    <li>
                        <?php _e("User message:", SAMYAR_TEXT_DOMAIN); ?>

                        <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                                data-tooltip="برای مشاهده پیام کاربر کلیک کنید" data-type="order"
                                data-info="user-note"
                                data-order="<?= $order->id ?>"><?php _e("click", SAMYAR_TEXT_DOMAIN); ?>
                        </button>
                    </li>
                <?php endif; ?>

                <?php
                $gift_carts = get_order_meta($order->id, 'gift_carts', true);
                $gift_carts = unserialize($gift_carts);
                if ($gift_carts): ?>
                    <li><?php _e("Order details:", SAMYAR_TEXT_DOMAIN); ?>
                        <button class="button kt-modal-button button-orange kando-show-info" data-modal="info"
                                data-tooltip="<?php _e('Click for order details', SAMYAR_TEXT_DOMAIN); ?>"
                                data-type="gift_cards"
                                data-info="gift-cards"
                                data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                        </button>
                    </li>
                <?php endif; ?>

                <?php
                switch ($order->service_type) {
                    case 'custom_comments':
                    case 'custom_comments_package':
                        ?>
                        <li><?php _e("Comments:", SAMYAR_TEXT_DOMAIN); ?>
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view comments', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="comments"
                                    data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                            </button>
                        </li>
                        <?php
                        break;
                    case 'mentions_with_hashtags':
                        ?>
                        <li><?php _e("Usernames:", SAMYAR_TEXT_DOMAIN); ?>
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view usernames', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="usernames"
                                    data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                            </button>
                        </li>
                        <li><?php _e("Hashtags:", SAMYAR_TEXT_DOMAIN); ?>
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view hashtags', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="hashtags"
                                    data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                            </button>
                        </li>
                        <?php
                        break;
                    case 'mentions_custom_list':
                    case 'mentions':
                        ?>
                        <li><?php _e("Usernames:", SAMYAR_TEXT_DOMAIN); ?>
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view usernames', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="mentions_usernames"
                                    data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                            </button>
                        </li>
                        <?php
                        break;
                    case 'mentions_hashtag':
                        ?>
                        <li><?php _e("Hashtags:", SAMYAR_TEXT_DOMAIN); ?>
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view hashtags', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="hashtag"
                                    data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                            </button>
                        </li>
                        <?php
                        break;
                    case 'mentions_user_followers':
                    case 'comment_likes':
                        ?>
                        <li><?php _e("Username:", SAMYAR_TEXT_DOMAIN); ?>
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info"
                                    data-tooltip="<?php _e('Click to view username', SAMYAR_TEXT_DOMAIN); ?>"
                                    data-type="order"
                                    data-info="username"
                                    data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
                            </button>
                        </li>
                        <?php
                        break;
                    case 'mentions_media_likers':
                        ?>
                        <li><?php _e("Media link:", SAMYAR_TEXT_DOMAIN); ?><?php
                            if (filter_var($order->media, FILTER_VALIDATE_URL)) {
                                echo '<a href="' . $order->media . '" target="_blank">' . samyar_truncate_string($order->media, 35) . '</a>';
                            } else {
                                echo samyar_truncate_string($order->media, 35);
                            }
                            ?></li>
                        <?php
                        break;
                }
                ?>

                <?php if (isset($order) && isset($service) && ($order->is_drip_feed || $service->type === "subscriptions")) { ?>
                    <li>
                        <?php _e("Order type:", SAMYAR_TEXT_DOMAIN); ?>&nbsp;
                        <?php

                        if ($order->is_drip_feed) {
                            echo '<span class="button button-orange badge-error-orders">' . __("Drip feed", SAMYAR_TEXT_DOMAIN) . '</span>';
                            echo '<a href="' . esc_attr(home_url('dashboard/?action=orders&section=dripfeed&main-id=' . esc_attr($order->id))) . '" class="button button-blue badge-error-orders" data-tooltip="' . __("Click to view orders", SAMYAR_TEXT_DOMAIN) . '" data-type="order"
                data-info="comments" data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
            </a>';
                        } elseif ($service->type === "subscriptions") {
                            echo '<span class="button button-blue badge-error-orders">' . __("Subscription", SAMYAR_TEXT_DOMAIN) . '</span>';
                            echo '<a href="' . esc_attr(home_url('dashboard/?action=orders&section=subscriptions&main-id=' . esc_attr($order->id))) . '" class="button button-blue badge-error-orders" data-tooltip="' . __("Click to view orders", SAMYAR_TEXT_DOMAIN) . '" data-type="order"
                data-info="comments" data-order="<?= $order->id ?>"><?php _e("Click", SAMYAR_TEXT_DOMAIN); ?>
            </a>';
                        }
                        ?>
                    </li>
                <?php } ?>


            </ul>
        <?php } ?>
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
        <td data-title="<?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo ($order->api_order_id == "0" || $order->api_order_id == "-1") ? "" : $order->api_order_id ?>
        </td>
        <td data-title="<?php _e("API response", SAMYAR_TEXT_DOMAIN); ?>">
            <?php echo esc_attr($order->note) ?>
        </td>
    <?php } ?>
    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">


        <?php if ($order->status === "awaiting_cancel") { ?>
            <?php
            $delay_time_order = (int)$options->get_option('delay-time-order', 10);
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
