<!--start tickets-->
<div class="kt-row">

    <?php

    use samyar\Notification;

    $notifications = Notification::where([
        'status' => 'publish',
        'order'=>'DESC',
        'order_by'=>'id'
    ])
    ?>

    <div class="column kt-col-xs-12 kt-col-md-12 dashboard-notifications">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="fas fa-bell"></i>
                <h5 class="dashboard-posts-title"><?php _e("Announcements and news", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list dashboard-notifications-items">
                <?php if ($notifications) { ?>
                    <?php foreach ($notifications as $notification) {


                        if ($notification->type === "" || $notification->type === "notification") {
                            if ($notification->user_type === "" || $notification->user_type === "all") {
                                ?>
                                <div class="alert alert-light" id="<?= $notification->id ?>">
                                    <span class="text-dark btn-toggler" data-id="alert_<?= $notification->id ?>"><i class="fas fa-bell"></i><?= $notification->title ?></span>
                                    <div class="hide" id="alert_<?= $notification->id ?>">
                                        <hr>
                                        <?php echo apply_filters( 'the_content', $notification->content ); ?>
                                    </div>
                                </div>
                                <?php
                            } elseif ($notification->user_type === "agents" && kando_user_is_representation()) {
                                ?>
                                <div class="alert alert-light" id="<?= $notification->id ?>">
                                    <span class="text-dark btn-toggler" data-id="alert_<?= $notification->id ?>"><?= $notification->title ?></span>
                                    <div class="hide" id="alert_<?= $notification->id ?>">
                                        <hr>
                                        <?php echo apply_filters( 'the_content', $notification->content ); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    } ?>
                <?php } else { ?>
                    <span class="news-notfound"><?php _e("No announcement has been published yet.", SAMYAR_TEXT_DOMAIN); ?></span>
                <?php } ?>

            </div>

        </div>
    </div>

</div>
<!--start tickets-->