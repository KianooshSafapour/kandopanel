<?php
defined('ABSPATH') || exit('No Access!');

$status_cron = kando_get_option('status-cron', 'mints1daily');
?>
<div class="samyar-settings-area samyar-settings-minor-cleaning">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="future"></span></span>
        <strong><?php _e('Minor Cleaning', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            <?php _e('In this section, you can keep orders for a specified period and delete the rest of the items.', SAMYAR_TEXT_DOMAIN); ?>
            <br>
            <?php _e('You can do this to lighten your site.', SAMYAR_TEXT_DOMAIN); ?>
            <br>
            <?php _e('Please note that the deleted data cannot be recovered.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-order-remains-day"><?php _e('Please enter the number of days for which you want to keep the orders (e.g., if you enter 60, orders from the last 60 days will be retained, and the rest will be deleted).', SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-order-remains-day" name="samyar-order-remains-day" value="">
        </div>
        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-minor-data" data-type="order" type="button"><?php _e('Delete Other Orders', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">

        <div class="uk-alert-danger" uk-alert>
            <?php _e('In this section, you can keep transactions for a specified period and delete the rest of the items.', SAMYAR_TEXT_DOMAIN); ?>
            <br>
            <?php _e('You can do this to lighten your site.', SAMYAR_TEXT_DOMAIN); ?>
            <br>
            <?php _e('Please note that the deleted data cannot be recovered.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-transaction-remains-day"><?php _e('Please enter the number of days for which you want to keep the transactions (e.g., if you enter 60, transactions from the last 60 days will be retained, and the rest will be deleted).', SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="text" class="uk-input" id="samyar-transaction-remains-day" name="samyar-transaction-remains-day" value="">
        </div>
        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-minor-data" data-type="transaction" type="button"><?php _e('Delete Other Transactions', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>

    </div>
    <hr>
</div>