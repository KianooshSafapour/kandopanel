<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Attach;
use samyar\Message;
use samyar\Order;
use samyar\Payment;
use samyar\Ticket;

$ticket_id = $_GET['id'];
if (isset($_GET['notification-id'])) {
    $notification_id = $_GET['notification-id'];
    $notification = \samyar\Notification::find_where(['id' => $_GET['notification-id'], 'seen' => 0]);
    if ($notification) {
        $notification->update(['seen' => 1]);
    }
}

$ticket = Ticket::find($ticket_id);
$messages = Message::where([
    'ticket_id' => $ticket_id,
    'order' => 'DESC',
    'order_by' => 'id',
]);
//اگر مدیر و ارسال کننده تیکت باشه تیکت رو بهش نشون بده
if (kando_user_can('show_user_tickets') || $ticket->uid == get_current_user_id() || $ticket->send_to == get_current_user_id()):
    ?>


    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-4">
            <div class="show-ticket-info">
                <form method="POST" class="samyar-form show-ticket-form">
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <?php if (kando_user_can('show_user_info_ticket')): ?>
                            <?php
                            $selected_value = $ticket->status;
                            ?>
                            <label><?php _e("Change status:", SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="ticket-status">
                                <option value="waiting" <?php selected($selected_value, 'waiting'); ?>><?php _e("Awaiting reply", SAMYAR_TEXT_DOMAIN) ?></option>
                                <option value="answered" <?php selected($selected_value, 'answered'); ?>><?php _e("Answered", SAMYAR_TEXT_DOMAIN) ?></option>
                                <option value="in_progress" <?php selected($selected_value, 'in_progress'); ?>><?php _e("In progress", SAMYAR_TEXT_DOMAIN) ?></option>
                                <option value="closed" <?php selected($selected_value, 'closed'); ?>><?php _e("Closed", SAMYAR_TEXT_DOMAIN) ?></option>
                            </select>
                            <?php
                            // دریافت لیست کاربران (مدیران و کاربران با متای user_is_supporter)
                            $users_list = kando_get_supporters_and_admins();

                            // مقدار انتخاب شده (فرض کنید از یک متغیر مانند $selected_user_id می‌آید)
                            $selected_user_id = isset($_POST['assign-to']) ? (int)$_POST['assign-to'] : 0;
                            ?>
                            <!--
                        <label><?php _e("Assign to:", SAMYAR_TEXT_DOMAIN); ?></label>

                        <select class="assign-to" name="assign-to" multiple>

                            <?php if (!empty($users_list)) : ?>
                                <?php foreach ($users_list as $user) : ?>
                                    <option value="<?php echo esc_attr($user['ID']); ?>" <?php selected($selected_user_id, $user['ID']); ?>>
                                        <?php echo esc_html($user['display_name'] . ' (' . $user['user_login'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
-->
                        <?php endif; ?>
                    </div>
                </form>
                <ul>
                    <li class="kando-flex">
                        <span class="title"><i
                                    class="fas fa-ticket"></i><?php _e('Ticket id:', SAMYAR_TEXT_DOMAIN) ?></span>
                        <h5><?php echo esc_attr($ticket->id) ?></h5>
                    </li>
                    <?php if (kando_user_can('show_user_info_ticket')): ?>
                        <?php
                        if ($ticket->send_to) {
                            $mobile = get_user_meta($ticket->send_to, 'mobile', true);
                            $email = get_user_by('ID', $ticket->send_to)->user_email;
                        } else {
                            $mobile = get_user_meta($ticket->uid, 'mobile', true);
                            $email = get_user_by('ID', $ticket->uid)->user_email;
                        }

                        ?>
                        <li class="kando-flex">
                        <span class="title"><i
                                    class="fas fa-mobile"></i><?php _e('Mobile:', SAMYAR_TEXT_DOMAIN) ?></span>
                            <h5><?php echo $mobile ?></h5>
                        </li>

                        <?php if (!empty($email)): ?>
                            <li class="kando-flex">
                            <span class="title"><i
                                        class="fas fa-envelope-open-text"></i><?php _e('Email:', SAMYAR_TEXT_DOMAIN) ?></span>
                                <h5><?php echo $email ?></h5>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($ticket->order_id): ?>
                        <li class="kando-flex">
        <span class="title">
            <i class="fas fa-shopping-basket"></i>
            <?php _e('Order ID(s):', SAMYAR_TEXT_DOMAIN); ?>
        </span>
                            <h5>
                                <?php
                                // تبدیل رشته order_id به آرایه
                                $order_ids = explode(',', $ticket->order_id);

                                // ایجاد آرایه‌ای از لینک‌ها
                                $order_links = array_map(function ($order_id) {
                                    return '<a target="_blank" href="' . esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($order_id))) . '">' . esc_html($order_id) . '</a>';
                                }, $order_ids);

                                // نمایش لینک‌ها با جداکننده کاما
                                echo implode(', ', $order_links);
                                ?>
                            </h5>
                        </li>
                    <?php endif; ?>


                    <li class="kando-flex">
                    <span class="title"><i
                                class="fas fa-calendar-plus"></i><?php _e('Create Date:', SAMYAR_TEXT_DOMAIN) ?></span>
                        <h5><?= date_i18n(get_option('date_format') . " " . get_option('time_format'), strtotime($ticket->created_at)) ?></h5>
                    </li>
                    <li class="kando-flex">
                    <span class="title"><i
                                class="fas fa-calendar-edit"></i><?php _e('Update Date:', SAMYAR_TEXT_DOMAIN) ?></span>
                        <h5><?= date_i18n(get_option('date_format') . " " . get_option('time_format'), strtotime($ticket->update_at)) ?></h5>
                    </li>
                    <li class="kando-flex">
                        <span class="title"><i
                                    class="fas fa-comments-alt"></i><?php _e('Cont message:', SAMYAR_TEXT_DOMAIN) ?></span>
                        <h5><?php echo count($messages) ?></h5>
                    </li>

                </ul>


                <?php if (kando_user_can('delete_user_ticket')): ?>
                    <a href="#"
                       class="button button-red ticket-delete-button"><?php _e("Delete ticket", SAMYAR_TEXT_DOMAIN); ?></a>
                <?php endif; ?>
                <?php if ($ticket->status !== "closed"): ?>
                    <a href="#"
                       class="button button-blue ticket-close-button"><?php _e("Close the ticket", SAMYAR_TEXT_DOMAIN); ?></a>
                <?php endif; ?>


            </div>

            <?php if (kando_user_can('show_user_info_order')): ?>
                <?php if ($ticket->order_id) {
                    $order_ids = explode(',', $ticket->order_id);
                    foreach ($order_ids as $order_id) {
                        ?>
                        <div class="show-ticket-info">


                            <?php
                            // دریافت اطلاعات سفارش
                            $order = Order::find($order_id);

                            if ($order) {
                                ?>
                                <ul>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-shopping-basket"></i><?php _e('Order ID:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><a target="_blank"
                                               href="<?= esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($order->id))) ?>"><?= esc_html($order->id) ?></a>
                                        </h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-user"></i><?php _e('User ID:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo esc_attr($order->uid); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-link"></i><?php _e('Link:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo esc_url($order->link); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-hashtag"></i><?php _e('Quantity:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo esc_attr($order->quantity); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-money-bill-wave"></i><?php _e('Charge:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo esc_attr($order->charge); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-calendar-plus"></i><?php _e('Create Date:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo date_i18n(get_option('date_format') . " " . get_option('time_format'), strtotime($order->created_at)); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-calendar-edit"></i><?php _e('Update Date:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo date_i18n(get_option('date_format') . " " . get_option('time_format'), strtotime($order->update_at)); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-info-circle"></i><?php _e('Status:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo samyar_order_status_title(esc_attr($order->status)); ?></h5>
                                    </li>
                                    <li class="kando-flex">
                                                <span class="title"><i
                                                            class="fas fa-sticky-note"></i><?php _e('Note:', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <h5><?php echo esc_attr($order->note); ?></h5>
                                    </li>
                                </ul>
                            <?php } else { ?>
                                <p><?php _e('Order not found.', SAMYAR_TEXT_DOMAIN); ?></p>
                            <?php } ?>


                        </div>
                        <?php
                    }
                } ?>
            <?php endif; ?>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-8">
            <h5 class="ticket-single-title">
                <span>#<?php echo esc_attr($ticket->id) ?></span><?php echo esc_attr($ticket->title) ?></h5>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-8">
            <div class="ticket-single-form-holder">
                <?php
                // فرم را نمایش بده اگر:
                // 1. وضعیت تیکت "closed" نیست (یعنی باز است)
                // یا
                // 2. کاربر دسترسی ویژه برای دیدن اطلاعات را دارد (حتی اگر تیکت بسته باشد)
                if ($ticket->status !== "closed" || kando_user_can('show_user_info_ticket')) {
                    ?>
                    <form class="ticket-single-form" method="POST" enctype="multipart/form-data" data-ticket-id="<?php echo esc_attr($ticket->id); ?>">
                        <div class="ticket-single-form-errors"></div>
                        <div class="ticket-single-form-loading"></div>

                        <div class="clearfix">
                            <textarea class="ticket-single-form-text" placeholder="<?php _e("your answer", SAMYAR_TEXT_DOMAIN); ?>"></textarea>

                            <?php
                            if (kando_get_option('enable-ticket-attach', 1) == 1) {
                                ?>
                                <input type="file" name="ticket-single-form-file" id="ticket-single-form-file" accept="image/gif, image/jpeg, image/png">
                                <label for="ticket-single-form-file" class="button button-blue"><?php _e("File upload", SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php } ?>

                            <input type="submit" class="button button-green ticket-single-form-submit" value="<?php _e("Post a reply", SAMYAR_TEXT_DOMAIN); ?>">
                        </div>
                    </form>
                    <?php
                } else {
                    // در غیر این صورت (یعنی تیکت بسته است و کاربر دسترسی ویژه ندارد)
                    // پیام "تیکت بسته است" را نمایش بده
                    ?>
                    <div class="kt-row">
                        <div class="column kt-col-xs-12">
                            <div class="alert alert-danger" role="alert">
                                <?php _e('Ticket is closed', SAMYAR_TEXT_DOMAIN); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
            <div class="ticket-single-replies">

                <?php if ($messages): ?>
                    <?php foreach ($messages as $message):
                        $user = get_user_by('id', $message->uid);

                        $attach = Attach::find_where(['message_id' => $message->id]);
                        ?>
                        <?php $type = samyar_user_is_admin($user->ID) ? 'ticket-single-reply-admin' : "ticket-single-reply-user"; ?>

                        <div class="ticket-single-reply <?php echo $type ?> message-<?= $message->id ?>">
                            <div class="ticket-single-image">
                                <?php

                                $avatar = get_user_meta($user->ID, 'avatar_url', true);
                                if ($avatar && !empty($avatar)) {
                                    $avatar_url = '<img width="64" src="' . $avatar . '">';
                                } else {
                                    $avatar_url = get_avatar($user->ID, 64);
                                }

                                echo $avatar_url;
                                ?>
                            </div>
                            <div class="ticket-single-desc-holder">
                                <div class="ticket-single-top-holder">
                                    <h4 class="ticket-single-author"><?php echo esc_attr($user->display_name) ?></h4>
                                    <span class="ticket-single-date"><?php
                                        $date_format = get_option('date_format');
                                        $time_format = get_option('time_format');
                                        echo date_i18n($date_format . ' ' . $time_format, strtotime($message->created_at)) ?></span>
                                </div>
                                <div class="ticket-single-text-holder">
                                    <p><?php echo $message->text ?></p>

                                    <?php if (kando_user_can('approve_cart_to_cart_ticket')): {
                                        if ($ticket->payment_id):
                                            $payment = Payment::find($ticket->payment_id);
                                            if ($payment && $payment->gateway === "card_to_card" && $payment->status === "2"):
                                                ?>
                                                <br>
                                                <?php _e("If it is approved, click on the button below and charge the user account:", SAMYAR_TEXT_DOMAIN); ?>
                                                <br>
                                                <a href="#"
                                                   class="button button-red kt-ajax-button approve-cart-to-cart"
                                                   data-amount="<?= $payment->amount ?>"
                                                   style="margin-right: 5px;margin-top: 10px"
                                                   data-uid="<?= $ticket->uid ?>"
                                                   data-payment="<?= $payment->id ?>"
                                                   data-wpel-link="internal"><?php _e("Card to card verification", SAMYAR_TEXT_DOMAIN); ?></a>
                                            <?php endif; ?>
                                        <?php endif;
                                    } endif; ?>

                                    <textarea style="display: none"><?php echo strip_tags($message->text); ?></textarea>
                                    <?php if ($attach):

                                        if ($attach->attach_id) {
                                            $attachment_url = wp_get_attachment_url($attach->attach_id);
                                            $file_path = get_post_meta($attach->attach_id, '_wp_attached_file', true);
                                            if (!empty($file_path)) {

                                                $file_name = basename($file_path);

                                            }
                                        } else {
                                            $attachment_url = $attach->file_url;
                                            $file_name = $attach->file_name;
                                        }
                                        ?>
                                        <a href="<?php echo esc_attr($attachment_url) ?>" target="_blank"
                                           class="button button-blue ticket-single-attached-file"
                                           data-wpel-link="internal"><i
                                                    class="elegant-icon icon_paperclip"></i><?php echo esc_attr($file_name) ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (kando_user_can('delete_update_ticket_message')): ?>
                                        <a href="#" class="button button-violet float-left kt-ajax-button edit-message"
                                           style="margin-right: 5px;margin-top: 10px" data-id="<?= $message->id ?>"
                                           data-wpel-link="internal">
                                            <i class="fal fa-pencil-alt"></i>
                                        </a>
                                        <a href="#" class="button button-red float-left kt-ajax-button delete-message"
                                           style="margin-right: 5px;margin-top: 10px" data-id="<?= $message->id ?>"
                                           data-wpel-link="internal">
                                            <i class="fal fa-trash-alt"></i>
                                        </a>
                                        <a href="#" class="button button-orange float-left kt-ajax-button cancel-update"
                                           style="margin-top: 10px;display: none" data-id="<?= $message->id ?>"
                                           data-wpel-link="internal">
                                            <?php _e("Cancel", SAMYAR_TEXT_DOMAIN); ?>
                                        </a>
                                        <a href="#" class="button button-green float-left kt-ajax-button update-message"
                                           style="margin-left: 5px;margin-top: 10px;display: none"
                                           data-id="<?= $message->id ?>" data-wpel-link="internal">
                                            <?php _e("Update", SAMYAR_TEXT_DOMAIN); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            $ticket_signature = get_user_meta($user->ID, 'ticket_signature', true);
                            if ($ticket_signature):
                                echo '<div class="ticket-signature">';
                                echo wpautop(wp_kses_post($ticket_signature));
                                echo '</div>';
                            endif;
                            ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

<?php
endif;
?>
<script>
    jQuery(document).ready(function ($) {
        $('.assign-to').select2({
            language: "fa",
            placeholder: kando_data.langs.select_user,
            allowClear: true
        });
    });
</script>
