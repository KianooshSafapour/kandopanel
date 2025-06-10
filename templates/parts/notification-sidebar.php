<?php
defined('ABSPATH') || exit('No Access!');
?>

<div class="notifications-sidebar">
    <div class="notifications-sidebar-wrapper">
        <div class="header">
            <div class="title">
                <?php _e("Announcements", SAMYAR_TEXT_DOMAIN); ?>
            </div>
            <a id="notifications-collapse" href="javascript:void(0);" class="back"><i class="fa fa-arrow-left"></i></a>
            <a id="notifications-read-all" href="javascript:void(0);" class="read-all"><i class="fa fa-check-circle"></i></a></div>
        <div class="content">
            <div class="items">
                <?php
                $Notifications = \samyar\Notification::where(['for_user' => get_current_user_id(), 'seen' => 0, 'order' => 'DESC', 'order_by' => 'id',"limit"=>10]);
                if ($Notifications) {
                    foreach ($Notifications as $Notification) {
                        $link = "#";
                        if($Notification->link){
                            $link = $Notification->link.'&notification-id='.$Notification->id;
                        }
                        ?>
                        <a href="<?= esc_url($link)?>" target="_blank" class="item notify-green">
                            <div class="header">
                                <span class="icon"><i class="fas fa-envelope"></i></span>
                                <span class="title"><?= esc_attr($Notification->title)?></span>
                                <span content="<?php
                                $date_format = get_option('date_format');
                                $time_format = get_option('time_format');
                                echo date_i18n($date_format.' '.$time_format, strtotime($Notification->created_at));?>" class="time" tabindex="0"><?php kando_date_ago($Notification->created_at) ?></span>
                            </div>
                            <span class="desc"><?= esc_attr($Notification->content)?></span>
                        </a>
                    <?php }
                } else {
                    ?>
                    <span class="message-notfound"><?php _e("No new notifications available", SAMYAR_TEXT_DOMAIN); ?></span>
                    <?php
                }
                ?>


            </div>
        </div>
        <!--
        <div class="notification-footer"><a href="#" class="notification-btn btn-gray notifications-all">
                مشاهده همه
            </a></div>
            -->
    </div>

</div>
<div class="rtl-dimmer"></div>