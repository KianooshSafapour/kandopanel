<?php
defined('ABSPATH') || exit('No Access!');
?>
<div class="samyar-settings-area samyar-settings-ticket">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="lifesaver"></span></span>
        <strong><?php _e('Ticket Settings', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label"><?php _e('Enable attachment upload in tickets', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <label>
                    <input class="uk-checkbox" type="hidden" name="enable-ticket-attach" value="0">
                    <input class="uk-checkbox" type="checkbox" name="enable-ticket-attach"
                           value="1" <?php echo checked(kando_get_option('enable-ticket-attach', 1), 1); ?>><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                </label>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar_max_open_tickets_per_user"><?php _e('max open tickets per user', SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input ltr" id="max_open_tickets_per_user" name="max_open_tickets_per_user"
                   value="<?php echo esc_attr(kando_get_option('max_open_tickets_per_user', 3)); ?>">
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar_min_time_replies_input"><?php _e('Minimum time between replies (seconds)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-form-controls">
                <input type="number" class="uk-input uk-form-width-small ltr" id="samyar_min_time_replies_input" name="samyar_min_time_between_replies"
                       value="<?php echo esc_attr(kando_get_option('samyar_min_time_between_replies', 30)); ?>" min="0">
                <small class="uk-text-meta"><?php _e('Enter 0 to disable this limit. Recommended: 15-60 seconds.', SAMYAR_TEXT_DOMAIN); ?></small>
            </div>
        </div>

    </div>


</div>