<?php
defined('ABSPATH') || exit('No Access!');
//$options      = settingsController::getInstance();
$cronjob_key = get_option('cronjob_key');
$crons = [
    'order' => [
        'name' => __('Send Orders', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('order_cronjob_start_date') ?? "",
        'end' => get_option('order_cronjob_end_date') ?? "",
        'run_time' => get_option('order_cronjob_run_time') ?? "",
        'status' => get_transient('order_cronjob_started'),
        'link' => home_url() . "/cron/?type=order&key=" . $cronjob_key,
    ],
    'status' => [
        'name' => __('Check Order Status', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('status_cronjob_start_date') ?? "",
        'end' => get_option('status_cronjob_end_date') ?? "",
        'run_time' => get_option('status_cronjob_run_time') ?? "",
        'status' => get_transient('status_cronjob_started'),
        'link' => home_url() . "/cron/?type=status&key=" . $cronjob_key,
    ],
    'multi_status' => [
        'name' => __('Check Group Order Status', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('multi_status_cronjob_start_date') ?? "",
        'end' => get_option('multi_status_cronjob_end_date') ?? "",
        'run_time' => get_option('multi_status_cronjob_run_time') ?? "",
        'status' => get_transient('multi_status_cronjob_started'),
        'link' => home_url() . "/cron/?type=multi_status&key=" . $cronjob_key,
    ],
    'update' => [
        'name' => __('Update Services', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('update_cronjob_start_date') ?? "",
        'end' => get_option('update_cronjob_end_date') ?? "",
        'run_time' => get_option('update_cronjob_run_time') ?? "",
        'status' => get_option('update_cronjob_started'),
        'link' => home_url() . "/cron/?type=update&key=" . $cronjob_key,
    ],
    'refill_order' => [
        'name' => __('Send Refill Orders', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('refill_order_cronjob_start_date') ?? "",
        'end' => get_option('refill_order_cronjob_end_date') ?? "",
        'run_time' => get_option('refill_order_cronjob_run_time') ?? "",
        'status' => get_option('refill_order_cronjob_started'),
        'link' => home_url() . "/cron/?type=refill_order&key=" . $cronjob_key,
    ],
    'refill_status' => [
        'name' => __('Check Refill Order Status', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('refill_status_cronjob_start_date') ?? "",
        'end' => get_option('refill_status_cronjob_end_date') ?? "",
        'run_time' => get_option('refill_status_cronjob_run_time') ?? "",
        'status' => get_option('refill_status_cronjob_started'),
        'link' => home_url() . "/cron/?type=refill_status&key=" . $cronjob_key,
    ],
    'dripfeed' => [
        'name' => __('Check Dripfeed Orders', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('dripfeed_cronjob_start_date') ?? "",
        'end' => get_option('dripfeed_cronjob_end_date') ?? "",
        'run_time' => get_option('dripfeed_cronjob_run_time') ?? "",
        'status' => get_option('dripfeed_cronjob_started'),
        'link' => home_url() . "/cron/?type=dripfeed&key=" . $cronjob_key,
    ],
    'subscriptions' => [
        'name' => __('Check Subscription Orders', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('subscriptions_cronjob_start_date') ?? "",
        'end' => get_option('subscriptions_cronjob_end_date') ?? "",
        'run_time' => get_option('subscriptions_cronjob_run_time') ?? "",
        'status' => get_option('subscriptions_cronjob_started'),
        'link' => home_url() . "/cron/?type=subscriptions&key=" . $cronjob_key,
    ],
    'cancel' => [ // Adding Cancel Cronjob
        'name' => __('Cancel Orders', SAMYAR_TEXT_DOMAIN),
        'start' => get_option('cancel_cronjob_start_date') ?? "",
        'end' => get_option('cancel_cronjob_end_date') ?? "",
        'run_time' => get_option('cancel_cronjob_run_time') ?? "",
        'status' => get_option('cancel_cronjob_started'),
        'link' => home_url() . "/cron/?type=cancel&key=" . $cronjob_key,
    ],
];

$locks = ['order', 'status', 'multi_status', 'dripfeed', 'subscriptions', 'cancel']; // Adding cancel to the list of locks
?>

<div class="samyar-settings wrap" style="margin: 10px 42px 5px 20px;">
    <div class="uk-grid-match" uk-grid>
        <div class="samyar-settings-content uk-width-4-4@m">
            <div class="uk-card uk-card-default uk-card-body">

                <div class="samyar-settings-area samyar-settings-change-log" style="display:block">
                    <h3 class="samyar-settings-title">
                        <span class="samyar-title-icon"><span uk-icon="info"></span></span>
                        <strong><?php _e('Cron Reports', SAMYAR_TEXT_DOMAIN); ?></strong>
                    </h3>
                    <div class="uk-margin">
                        <div class="uk-alert-danger uk-alert" uk-alert="">
                            <b><?php _e('Key Note:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('If you notice that a cron job has been running for a long time (e.g., 10 minutes) and has not finished, and the status is still running, this indicates that there is an error in this cron job or there is an issue connecting to a provider.', SAMYAR_TEXT_DOMAIN); ?>
                            <br>
                            <br>
                            <b><?php _e('Important Note:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('If your cron job is set up on the host, avoid clicking the "Run" button.', SAMYAR_TEXT_DOMAIN); ?>
                        </div>
                    </div>

                    <div class="samyar-other-products uk-overflow-auto" style="border: 1px solid #e3e3e3;border-radius: 8px;">
                        <table class="uk-table uk-table-middle uk-table-divider uk-table-striped">
                            <thead>
                            <tr>
                                <th class="uk-width-small"><?php _e('ID', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('Name', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('Start', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('End', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('Run Time (Seconds)', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></th>
                                <th><?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($crons as $key => $cron):
                                ?>
                                <tr id="<?= esc_attr($key) ?>">
                                    <td><?= esc_attr($key) ?></td>
                                    <td>
                                        <?= esc_attr($cron['name']) ?>
                                        <?php
                                        // Show the progress of the status cron job
                                        if ($key === "status") {
                                            $current_page = (int)get_option('cron_status_page', 1); // The page that has been checked
                                            $all_page = (int)get_option('cron_status_pages', 1); // Total number of pages
                                            echo "(";
                                            echo $all_page;
                                            echo "/";
                                            echo "<span style='color:darkred'>";
                                            echo $current_page - 1;
                                            echo "</span>";
                                            echo ")";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($cron['start']) {
                                            echo date_i18n('d M Y - H:i:s', strtotime($cron['start']));
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($cron['end']) {
                                            echo date_i18n('d M Y - H:i:s', strtotime($cron['end']));
                                        }
                                        ?></td>
                                    <td><?php
                                        if ($cron['run_time']) {
                                            echo $cron['run_time'];
                                        }
                                        ?></td>
                                    <td>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="enable-cron-<?php echo esc_attr($key) ?>" data-type="kando_enable_cron"
                                                   data-id="<?php echo esc_attr($key) ?>"
                                                   class="ajax-switch custom-switch-input"
                                                   data-toggle="collapse"
                                                   aria-expanded="false" <?php echo checked(get_option("enable-cron-" . esc_attr($key), 1), 1); ?>>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <?php if ($cron['status']): ?>
                                            <span class="uk-badge" style="background: #ee395b;"><?php _e('Running', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <?php else: ?>
                                            <span class="uk-badge"><?php _e('Completed', SAMYAR_TEXT_DOMAIN); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($key) {
                                            case 'order':
                                            case 'status':
                                            case 'multi_status':
                                            case 'dripfeed':
                                            case 'subscriptions':
                                            case 'cancel': // Adding cancel to the list of cron jobs with locks
                                                $in_progress = get_transient($key . '_cronjob_started');
                                                if ($in_progress) {
                                                    ?>
                                                    <button class="uk-button uk-button-primary kando-unlock-cronjob" data-key="<?= esc_attr($key) ?>" uk-tooltip="title: <?php _e('Unlock Cron Job', SAMYAR_TEXT_DOMAIN); ?>" style="color: #fff" target="_blank"><span uk-icon="icon: unlock"></span></button>
                                                    <?php
                                                }
                                                break;
                                        }
                                        ?>

                                        <a class="uk-button uk-button-danger" style="color: #fff" target="_blank" href="<?= esc_attr($cron['link']) ?>"><?php _e('Run', SAMYAR_TEXT_DOMAIN); ?></a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>