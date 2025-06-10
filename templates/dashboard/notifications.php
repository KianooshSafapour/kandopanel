<?php

use samyar\Notification;

$notifications = Notification::where([
    'status' => 'publish',
    'order'=>'DESC',
    'order_by'=>'id'
])
?>
<!--start notifications-->
<div class="kt-row">
    <div class="xl-100 col-xl-12 dashboard-notifications">
        <div class="card h-100 close-in-mobile active">
            <div class="card-header"><h4 class="card-title"><?php _e("Notifications", SAMYAR_TEXT_DOMAIN); ?></h4></div>
            <div class="card-body">
                <div class="dashboard-notifications-items">
                    <div class="alert alert-light" id="16948">
                        <?php if ($notifications): ?>
                            <?php foreach ($notifications as $notification):

                                if ($notification->type === "" || $notification->type === "notification"):
                                    if ($notification->user_type === "" || $notification->user_type === "all"):
                                        ?>
                                        <span class="text-dark btn-toggler" data-id="alert_<?=$notification->ID?>"><?= $notification->title ?></span>
                                        <div class="hide" id="alert_<?=$notification->ID?>">
                                            <hr>
                                            <?php echo apply_filters( 'the_content', $notification->content ); ?>
                                        </div>
                                    <?php
                                    elseif ($notification->user_type === "agents" && kando_user_is_representation()):
                                        ?>
                                        <span class="text-dark btn-toggler" data-id="alert_<?=$notification->ID?>"><?= $notification->title ?></span>
                                        <div class="hide" id="alert_<?=$notification->ID?>">
                                            <hr>
                                            <?php echo apply_filters( 'the_content', $notification->content ); ?>
                                        </div>
                                    <?php
                                    endif;
                                endif;
                            endforeach; ?>
                        <?php else: ?>
                            <span class="news-notfound"><?php _e("No notifications have been published yet.", SAMYAR_TEXT_DOMAIN); ?></span>
                        <?php endif; ?>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!--end notifications-->