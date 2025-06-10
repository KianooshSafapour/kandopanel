<?php
defined('ABSPATH') || exit('No Access!');
//$options      = settingsController::getInstance();
$cronjob_key = get_option('cronjob_key');
$crons = [
    'order' => [
        'name' => 'ارسال سفارشات',
        'start' => get_option('order_cronjob_start_date') ?? "",
        'end' => get_option('order_cronjob_end_date') ?? "",
        'run_time' => get_option('order_cronjob_run_time') ?? "",
        'status' => get_transient('order_cronjob_started'),
        'link' => home_url() . "/cron/?type=order&key=" . $cronjob_key,
    ],
    'status' => [
        'name' => 'بررسی وضعیت سفارشات',
        'start' => get_option('status_cronjob_start_date') ?? "",
        'end' => get_option('status_cronjob_end_date') ?? "",
        'run_time' => get_option('status_cronjob_run_time') ?? "",
        'status' => get_transient('status_cronjob_started'),
        'link' => home_url() . "/cron/?type=status&key=" . $cronjob_key,
    ],
    'multi_status' => [
        'name' => 'بررسی وضعیت سفارشات گروهی',
        'start' => get_option('multi_status_cronjob_start_date') ?? "",
        'end' => get_option('multi_status_cronjob_end_date') ?? "",
        'run_time' => get_option('multi_status_cronjob_run_time') ?? "",
        'status' => get_transient('multi_status_cronjob_started'),
        'link' => home_url() . "/cron/?type=multi_status&key=" . $cronjob_key,
    ],
    'update' => [
        'name' => 'بروزرسانی خدمات',
        'start' => get_option('update_cronjob_start_date') ?? "",
        'end' => get_option('update_cronjob_end_date') ?? "",
        'run_time' => get_option('update_cronjob_run_time') ?? "",
        'status' => get_option('update_cronjob_started'),
        'link' => home_url() . "/cron/?type=update&key=" . $cronjob_key,
    ],
    'refill_order' => [
        'name' => 'ارسال سفارشات جبران ریزش',
        'start' => get_option('refill_order_cronjob_start_date') ?? "",
        'end' => get_option('refill_order_cronjob_end_date') ?? "",
        'run_time' => get_option('refill_order_cronjob_run_time') ?? "",
        'status' => get_option('refill_order_cronjob_started'),
        'link' => home_url() . "/cron/?type=refill_order&key=" . $cronjob_key,
    ],
    'refill_status' => [
        'name' => 'بررسی سفارشات وضعیت جبران ریزش',
        'start' => get_option('refill_status_cronjob_start_date') ?? "",
        'end' => get_option('refill_status_cronjob_end_date') ?? "",
        'run_time' => get_option('refill_status_cronjob_run_time') ?? "",
        'status' => get_option('refill_status_cronjob_started'),
        'link' => home_url() . "/cron/?type=refill_status&key=" . $cronjob_key,
    ],
    'dripfeed' => [
	    'name' => 'بررسی سفارشات چندبخشی',
	    'start' => get_option('dripfeed_cronjob_start_date') ?? "",
	    'end' => get_option('dripfeed_cronjob_end_date') ?? "",
	    'run_time' => get_option('dripfeed_cronjob_run_time') ?? "",
	    'status' => get_option('dripfeed_cronjob_started'),
	    'link' => home_url() . "/cron/?type=dripfeed&key=" . $cronjob_key,
    ],
    'subscriptions' => [
	    'name' => 'بررسی سفارشات اشتراکی',
	    'start' => get_option('subscriptions_cronjob_start_date') ?? "",
	    'end' => get_option('subscriptions_cronjob_end_date') ?? "",
	    'run_time' => get_option('subscriptions_cronjob_run_time') ?? "",
	    'status' => get_option('subscriptions_cronjob_started'),
	    'link' => home_url() . "/cron/?type=subscriptions&key=" . $cronjob_key,
    ],
];

$locks = ['order','status','multi_status','dripfeed','subscriptions'];
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
                            <b>نکته کلیدی:</b> : اگر مشاهده کردید که از شروع اجرای یک کرون جاب زمانی زیادی مثلا 10 دقیقه گذشته و پایان پیدا نکرده و همچنین وضعیت هنوز در حال جرا هست این نشونه این هست که در این
                            کرون جاب خطایی وجود داره و یا برای ارتباط با یک ارائه دهنده در این کرون جاب خطایی وجود دارد
                            <br>
                            <br>
                            <b>نکته مهم:</b> اگر کرون جاب شما در هاست تنظیم شده از زدن بر روی دکمه اجرا خودداری کنید
                        </div>
                    </div>

                    <div class="samyar-other-products uk-overflow-auto" style="border: 1px solid #e3e3e3;border-radius: 8px;">
                        <table class="uk-table uk-table-middle uk-table-divider uk-table-striped">
                            <thead>
                            <tr>
                                <th class="uk-width-small">شناسه</th>
                                <th>نام</th>
                                <th>شروع</th>
                                <th>پایان</th>
                                <th>زمان اجرا(ثانیه)</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
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
                                        //نشون میده صفحه چند از چند بررسی شده
                                        if($key==="status"){
                                            $current_page = (int)get_option('cron_status_page', 1);//صفحه ای که بررسی شده
                                            $all_page = (int)get_option('cron_status_pages', 1);//تعداد کل صفحات
                                            echo "(";
                                            echo $all_page;
                                            echo "/";
                                            echo "<span style='color:darkred'>";
                                            echo $current_page-1;
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
                                        <?php if ($cron['status']): ?>
                                            <span class="uk-badge" style="background: #ee395b;">در حال اجرا</span>
                                        <?php else: ?>
                                            <span class="uk-badge">اجرا شد</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($key){
                                            case 'order':
                                                $in_progress = get_transient('order_cronjob_started');
                                                if($in_progress){
                                                    ?>
                                                    <button class="uk-button uk-button-primary kando-unlock-cronjob" data-key="<?= esc_attr($key) ?>" uk-tooltip="title: باز کردن قفل کرون جاب" style="color: #fff" target="_blank"><span uk-icon="icon: unlock"></span></button>
                                                    <?php
                                                }
                                                break;
                                            case 'status':
                                                $in_progress = get_transient('status_cronjob_started');
                                                if($in_progress){
                                                    ?>
                                                    <button class="uk-button uk-button-primary kando-unlock-cronjob" data-key="<?= esc_attr($key) ?>" uk-tooltip="title: باز کردن قفل کرون جاب" style="color: #fff" target="_blank"><span uk-icon="icon: unlock"></span></button>
                                                    <?php
                                                }
                                                break;
                                            case 'multi_status':
                                                $in_progress = get_transient('multi_status_cronjob_started');
                                                if($in_progress){
                                                    ?>
                                                    <button class="uk-button uk-button-primary kando-unlock-cronjob" data-key="<?= esc_attr($key) ?>" uk-tooltip="title: باز کردن قفل کرون جاب" style="color: #fff" target="_blank"><span uk-icon="icon: unlock"></span></button>
                                                    <?php
                                                }
                                                break;
	                                        case 'dripfeed':
		                                        $in_progress = get_transient('dripfeed_cronjob_started');
		                                        if($in_progress){
			                                        ?>
                                                    <button class="uk-button uk-button-primary kando-unlock-cronjob" data-key="<?= esc_attr($key) ?>" uk-tooltip="title: باز کردن قفل کرون جاب" style="color: #fff" target="_blank"><span uk-icon="icon: unlock"></span></button>
			                                        <?php
		                                        }
		                                        break;
	                                        case 'subscriptions':
		                                        $in_progress = get_transient('subscriptions_cronjob_started');
		                                        if($in_progress){
			                                        ?>
                                                    <button class="uk-button uk-button-primary kando-unlock-cronjob" data-key="<?= esc_attr($key) ?>" uk-tooltip="title: باز کردن قفل کرون جاب" style="color: #fff" target="_blank"><span uk-icon="icon: unlock"></span></button>
			                                        <?php
		                                        }
		                                        break;
                                        }
                                        ?>

                                        <a class="uk-button uk-button-danger" style="color: #fff" target="_blank" href="<?= esc_attr($cron['link']) ?>">اجرا</a>

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

