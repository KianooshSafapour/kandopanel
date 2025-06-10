<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$id = $_GET['id'];
$notification = \samyar\Notification::find($id);
$publish = $notification->status == "publish" ? "checked" : "";
?>
<div class="woocommerce-MyAccount-content">
    <div class="woocommerce-notices-wrapper"></div>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li><b><?php _e('Notification Type:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('This notification will be displayed in the notifications box on the dashboard.', SAMYAR_TEXT_DOMAIN); ?></li>
                    <li><b><?php _e('Alert Type:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('An alert is a colored box with text that you can place in various locations on the site for users.', SAMYAR_TEXT_DOMAIN); ?></li>
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-ticket-form-outer">
                <h4 class="new-ticket-title"><?php _e('Edit Notification and Alert', SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e('Write and publish the notification text.', SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" enctype="multipart/form-data" class="new-notification-form">
                    <input type="hidden" name="action" value="samyar_notification_edit">
                    <input type="hidden" name="notification-id" value="<?= $id ?>">
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <select name="type" id="notification-type" style="margin-bottom: 15px">
                            <option value="notification" <?php if ($notification->type==="notification"): ?> selected <?php endif; ?>><?php _e('Notification', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="alert"<?php if ($notification->type==="alert"): ?> selected <?php endif; ?>><?php _e('Alert', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <div class="kt-col-xs-12">
                            <input type="text" class="new-ticket-form-title" name="notification-title" value="<?= $notification->title ?>" placeholder="<?php _e('Title', SAMYAR_TEXT_DOMAIN); ?>" style="margin-bottom: 15px;">
                        </div>
                        <label><?php _e('Which type of users should see this?', SAMYAR_TEXT_DOMAIN); ?></label>
                        <select name="user-type" style="margin-bottom: 15px">
                            <option value="all"<?php if ($notification->type==="all"): ?> selected <?php endif; ?>><?php _e('All Users', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="agents"<?php if ($notification->type==="agents"): ?> selected <?php endif; ?>><?php _e('Agents', SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>
                        <div class="kt-col-xs-12" id="alert-section" style="display: <?php if($notification->type==="alert"): ?>block<?php else: ?>none<?php endif; ?>">
                            <label><?php _e('Where should it be displayed?', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="location" style="margin-bottom: 15px">
                                <option value="dashboard"<?php if ($notification->location==="all"): ?> selected <?php endif; ?>><?php _e('Dashboard', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="credit"<?php if ($notification->location==="credit"): ?> selected <?php endif; ?>><?php _e('Credit Charge', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="order"<?php if ($notification->location==="order"): ?> selected <?php endif; ?>><?php _e('Add Order', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="orders"<?php if ($notification->location==="orders"): ?> selected <?php endif; ?>><?php _e('Orders', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="services"<?php if ($notification->location==="services"): ?> selected <?php endif; ?>><?php _e('Services', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="ticket"<?php if ($notification->location==="ticket"): ?> selected <?php endif; ?>><?php _e('Add Ticket', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="tickets"<?php if ($notification->location==="tickets"): ?> selected <?php endif; ?>><?php _e('Tickets', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="profile"<?php if ($notification->location==="profile"): ?> selected <?php endif; ?>><?php _e('Edit Profile', SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>

                            <label><?php _e('Alert Background Color:', SAMYAR_TEXT_DOMAIN); ?></label>
                            <select name="background-color" style="margin-bottom: 15px">
                                <option value="success"<?php if ($notification->background_color==="success"): ?> selected <?php endif; ?>><?php _e('Green', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="info"<?php if ($notification->background_color==="info"): ?> selected <?php endif; ?>><?php _e('Blue', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="warning"<?php if ($notification->background_color==="warning"): ?> selected <?php endif; ?>><?php _e('Yellow', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="danger"<?php if ($notification->background_color==="danger"): ?> selected <?php endif; ?>><?php _e('Red', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="primary"<?php if ($notification->background_color==="primary"): ?> selected <?php endif; ?>><?php _e('Purple', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="secondary"<?php if ($notification->background_color==="secondary"): ?> selected <?php endif; ?>><?php _e('Gray', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="dark"<?php if ($notification->background_color==="dark"): ?> selected <?php endif; ?>><?php _e('Dark', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="light"<?php if ($notification->background_color==="light"): ?> selected <?php endif; ?>><?php _e('Light', SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>
                        </div>
                        <div class="kt-col-xs-12">
                            <?php wp_editor($notification->content, 'notification-content'); ?>
                        </div>
                        <div class="kt-col-xs-12">
                            <input type="checkbox" value="1" id="publish-notification" name="publish-notification" <?= $publish ?>><label style="margin: 20px 0;" class="publish-notification"
                                                                                                                                          for="publish-notification"><?php _e('Publish', SAMYAR_TEXT_DOMAIN); ?></label>
                        </div>
                        <input type="submit" class="button button-green notification-form-submit" value="<?php _e('Edit Notification', SAMYAR_TEXT_DOMAIN); ?>">
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>