<?php
defined('ABSPATH') || exit('No Access!');

$status_cron = kando_get_option('status-cron', 'mints1daily');
?>
<div class="samyar-settings-area samyar-settings-cron">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="future"></span></span>
        <strong><?php _e('cronjob', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>


    <div class="uk-margin">

        <div class="uk-alert-primary" uk-alert>
            <p><?php _e('From this section, you can create your dedicated cron job link.', SAMYAR_TEXT_DOMAIN); ?></p>
            <p><?php _e('To do this, simply click on "Generate New Cron Job Link" to create the links and display the cron job code.', SAMYAR_TEXT_DOMAIN); ?></p>
        </div>


        <div>
            <div class="uk-text-center" uk-grid>
                <div>
                    <button class="uk-button uk-button-default" type="button" id="kando-genrate-cronjob-link"><?php _e('Generate New Cron Job Link', SAMYAR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
        <?php
        $cronjob_key = get_option('cronjob_key');
        if($cronjob_key){
            $order_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=order&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $status_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=status&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $multi_status_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=multi_status&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $update_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=update&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $refill_order_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=refill_order&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $refill_status_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=refill_status&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $dripfeed_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=dripfeed&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $subscriptions_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=subscriptions&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $cancel_link = "/usr/bin/wget -q -O /dev/null '".home_url()."/cron/?type=cancel&key=".$cronjob_key."' >/dev/null 2>&1 ";
            $hidden=false;
        }else{
            $order_link="";
            $status_link="";
            $multi_status_link="";
            $update_link="";
            $refill_order_link="";
            $refill_status_link="";
            $dripfeed_link="";
            $subscriptions_link="";
            $cancel_link="";
            $hidden=true;
        }


        ?>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for order submission (set to run every 1 minute)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-order-cronjob" readonly value="<?=$order_link?>">
                    <a href="<?=$order_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for status retrieval (set to run every 5 minutes)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-status-cronjob" readonly value="<?=$status_link?>">
                    <a href="<?=$status_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for bulk status retrieval (set to run every 5 minutes)', SAMYAR_TEXT_DOMAIN); ?><span class="new-option">(<?php _e('New', SAMYAR_TEXT_DOMAIN); ?>)</span></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-multi-status-cronjob" readonly value="<?=$multi_status_link?>">
                    <a href="<?=$multi_status_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for automatic provider updates (set to run every 12 hours)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-autosync-cronjob" readonly value="<?=$update_link?>">
                    <a href="<?=$update_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for refill order submission (set to run every 1 minute)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-refill-order-cronjob" readonly value="<?=$refill_order_link?>">
                    <a href="<?=$refill_order_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for refill order status retrieval (set to run every 1 minute)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-refill-status-cronjob" readonly value="<?=$refill_status_link?>">
                    <a href="<?=$refill_status_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for dripfeed order status retrieval (set to run every 1 minute)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-dripfeed-cronjob" readonly value="<?=$dripfeed_link?>">
                    <a href="<?=$dripfeed_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for subscription status retrieval (set to run every 1 minute)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-subscriptions-cronjob" readonly value="<?=$subscriptions_link?>">
                    <a href="<?=$subscriptions_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>
        <div class="uk-margin cronjob-link" <?php if($hidden){echo "style='display:none'";} ?>>
            <label class="uk-form-label"><?php _e('Cron job link for cancel requests (set to run every 1 minute)', SAMYAR_TEXT_DOMAIN); ?></label>
            <div class="uk-margin-small">
                <div class="samyar-upload-file-wrapper">
                    <input dir="ltr" type="text" class="uk-input" id="kando-cancel-cronjob" readonly value="<?=$cancel_link?>">
                    <a href="<?=$cancel_link?>" style="left: auto;right: 5px;" class="samyar-remove CopyToClipBoard" data-toggle="site-favicon" uk-tooltip="title: <?php _e('Copy', SAMYAR_TEXT_DOMAIN); ?>"><span uk-icon="copy"></a>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b><?php _e('Note:', SAMYAR_TEXT_DOMAIN); ?></b> <?php _e('If bulk status retrieval is not enabled, set the number of orders to check (we recommend setting a maximum of 100 and setting the time interval between requests to 5 minutes).', SAMYAR_TEXT_DOMAIN); ?><br>
            </p>
            <p><?php _e('The bulk order status feature is a great way to reduce server load significantly. However, unfortunately, some providers do not support this feature. We recommend requesting these providers to add this feature so that both parties can benefit from it (you can find the commands for this feature in your API documentation under "Bulk Order Status").', SAMYAR_TEXT_DOMAIN); ?></p>
            <p><?php _e('For this reason, we have left the choice of enabling this feature up to you. If you are sure that all the providers you use support this feature (you should check their documentation), simply check the "Enable Bulk Status Retrieval" option. Otherwise, uncheck it.', SAMYAR_TEXT_DOMAIN); ?></p>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label" for="samyar-cron-status-number"><?php _e('How many orders should be checked per request?', SAMYAR_TEXT_DOMAIN); ?></label>
            <input type="number" class="uk-input" id="samyar-cron-status-number" name="cron-status-number" min="15" value="<?php echo esc_attr(kando_get_option('cron-status-number', 15)); ?>">
        </div>
    </div>


</div>