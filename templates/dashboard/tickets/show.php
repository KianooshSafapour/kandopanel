<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Attach;
use samyar\Message;
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
    <div class="ticket-single-top-area clearfix">
        <div class="ticket-single-title-holder">
            <h4 class="ticket-single-title">
                <span>#<?php echo esc_attr($ticket->id) ?></span><?php echo esc_attr($ticket->title) ?></h4>
            <span class="ticket-single-count">
    					<?php echo count($messages) ?><?php _e("message", SAMYAR_TEXT_DOMAIN); ?>
    				</span>
            <?php
            switch ($ticket->status) {
                case 'waiting':
                    echo '<span class="ticket-single-status ticket-single-status-not-replied">' . __("Awaiting reply", SAMYAR_TEXT_DOMAIN) . '</span>';
                    break;
                case 'answered':
                    echo '<span class="ticket-single-status ticket-single-status-replied">' . __("Answered", SAMYAR_TEXT_DOMAIN) . '</span>';
                    break;
                case 'closed':
                    echo '<span class="ticket-single-status ticket-single-status-closed">' . __("closed", SAMYAR_TEXT_DOMAIN) . '</span>';
                    break;
            }
            ?>
        </div>
        <?php if (kando_user_can('delete_user_ticket')): ?>
            <a href="#"
               class="button button-red ticket-delete-button"><?php _e("Delete ticket", SAMYAR_TEXT_DOMAIN); ?></a>
        <?php endif; ?>
        <?php if ($ticket->status !== "closed"): ?>
            <a href="#"
               class="button button-blue ticket-close-button"><?php _e("Close the ticket", SAMYAR_TEXT_DOMAIN); ?></a>
        <?php endif; ?>
        <a href="#"
           class="button button-green ticket-single-reply-button"><?php _e("Post a reply", SAMYAR_TEXT_DOMAIN); ?></a>
    </div>
    <div class="ticket-single">


        <div class="ticket-single-reply ticket-single-reply-user" style="background-color: #F4F3FB;">
            <div class="ticket-single-desc-holder">
                <div class="ticket-single-text-holder" style="fill: #8478D8;color: #8478D8;">
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
                        <?php _e("User information:", SAMYAR_TEXT_DOMAIN); ?>
                        ( <?php _e("Mobile:", SAMYAR_TEXT_DOMAIN); ?><?php echo $mobile ?><?php if (!empty($email)): ?> | <?php _e("Email", SAMYAR_TEXT_DOMAIN); ?> <?= $email ?><?php endif; ?>)
                        <?php if ($ticket->order_id): ?>
                            <br>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($ticket->order_id): ?>

                        <?php _e("Order ID(s):", SAMYAR_TEXT_DOMAIN); ?>
                        <?php echo '<a target="_blank" href="' . esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($ticket->order_id))) . '">' . $ticket->order_id . '</a>' ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <div class="ticket-single-form-holder">
            <form class="ticket-single-form" method="POST" enctype="multipart/form-data"
                  data-ticket-id="<?php echo esc_attr($ticket->id) ?>">

                <div class="ticket-single-form-errors"></div>
                <div class="ticket-single-form-loading"></div>


                <div class="clearfix">
                    <textarea class="ticket-single-form-text"
                              placeholder="<?php _e("your answer", SAMYAR_TEXT_DOMAIN); ?>"></textarea>

                    <?php

                    if (kando_get_option('enable-ticket-attach', 1) == 1) {
                        ?>
                        <input type="file" name="ticket-single-form-file" id="ticket-single-form-file"
                               accept="image/gif, image/jpeg, image/png">
                        <label for="ticket-single-form-file"
                               class="button button-blue"><?php _e("File upload", SAMYAR_TEXT_DOMAIN); ?></label>

                    <?php } ?>
                    <input type="submit" class="button button-green ticket-single-form-submit"
                           value="<?php _e("Post a reply", SAMYAR_TEXT_DOMAIN); ?>">

                </div>
            </form>
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
                                            <a href="#" class="button button-red kt-ajax-button approve-cart-to-cart"
                                               data-amount="<?= $payment->amount ?>"
                                               style="margin-right: 5px;margin-top: 10px" data-uid="<?= $ticket->uid ?>"
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
                                    <a href="<?php echo esc_attr($attachment_url) ?>"
                                       class="button button-blue ticket-single-attached-file" data-wpel-link="internal"><i
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
<?php
endif;