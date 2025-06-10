<?php
defined('ABSPATH') || exit('No Access!');

$status_cron = kando_get_option('status-cron', 'mints1daily');
?>
<div class="samyar-settings-area samyar-settings-remove">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="future"></span></span>
        <strong><?php _e('Remove Info', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>

    <!--
    <div class="uk-margin">
        <div uk-form-custom="target: > * > span:first-child">
            <label class="uk-form-label" for="samyar-cron-status-number"><?php _e('How often should the order status be checked?', SAMYAR_TEXT_DOMAIN); ?></label>
            <select name="status-cron">
                <option value="mints1daily" <?php selected($status_cron, 'mints1daily'); ?>><?php _e('Every 1 minute', SAMYAR_TEXT_DOMAIN); ?></option>
                <option value="mints5daily" <?php selected($status_cron, 'mints5daily'); ?>><?php _e('Every 5 minutes', SAMYAR_TEXT_DOMAIN); ?></option>
            </select>
            <button class="uk-button uk-button-default" type="button" tabindex="-1">
                <span></span>
                <span uk-icon="icon: chevron-down"></span>
            </button>
        </div>
    </div>
-->

    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete all important site data, including categories, services, providers, orders, transactions, notifications, tickets, coupons, purchased user packages, and update notifications.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="all" type="button"><?php _e('Delete All Data', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only categories and related services.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="category" type="button"><?php _e('Delete Categories and Related Services', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only services.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="services" type="button"><?php _e('Delete Services', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only providers and their related services.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="providers" type="button"><?php _e('Delete Providers and Related Services', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only orders.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="orders" type="button"><?php _e('Delete Orders', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only transactions.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="transactions" type="button"><?php _e('Delete Transactions', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only notifications.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="notification" type="button"><?php _e('Delete Notifications', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only tickets.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="tickets" type="button"><?php _e('Delete Tickets', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete only gift coupons.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="coupons" type="button"><?php _e('Delete Coupons', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete all purchased user representation packages.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="packages" type="button"><?php _e('Delete All Purchased User Packages', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can clear custom prices and representative prices entered during service editing so that you can use general rates for services.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="prices" type="button"><?php _e('Clear Custom Service Prices and Representative Prices', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-danger" uk-alert>
            <?php _e('From this section, you can delete all notifications related to price changes and service activation/deactivation.', SAMYAR_TEXT_DOMAIN); ?>
        </div>

        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default kando-remove-data" data-type="updates" type="button"><?php _e('Delete Price Change Notifications', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>