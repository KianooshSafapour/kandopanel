<?php

use samyar\walletController;

$options = settingsController::getInstance();
$redirect_logout = kando_get_option('redirect-logout', home_url('login'));
?>
<div class="header-user-area-btns">

    <?php if (kando_count_notification() > 0) { ?>
        <a href="#" style="" class="button button-green up_top_notify float-right"><i class="fal fa-bell"></i><span
                    class="badge"><?= kando_count_notification() ?></span></a>
    <?php } ?>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')) ?>"
       class="button button-default float-right new-order-btn"
       data-modal="login"><?php _e("Add order", SAMYAR_TEXT_DOMAIN); ?></a>
</div>
<div class="header-user-area">
    <a href="<?php echo esc_attr(home_url('dashboard')) ?>" class="header-user-area-inner" data-wpel-link="internal">
        <?php
        $avatar = get_user_meta(get_current_user_id(), 'avatar_url', true);
        if ($avatar && !empty($avatar)) {
            $avatar_url = '<img width="46" style="border-radius: 50%;" src="' . $avatar . '">';
        } else {
            $avatar_url = get_avatar(get_current_user_id(), 46);
        }

        $user = get_user_by('ID', get_current_user_id());
        echo $avatar_url;
        ?>
        <span><?php echo $user->display_name ?> <?php _e("Welcome!", SAMYAR_TEXT_DOMAIN); ?></span>
    </a>

    <div class="header-user-area-list">
        <div class="user-status">

            <!-- User Name / Avatar -->
            <div class="user-details">
                <div class="user-avatar status-online"><?php echo get_avatar(get_current_user_id(), 46); ?></div>
                <div class="user-name">
                    <?php
                    $user = get_user_by('ID', get_current_user_id());
                    ?>
                    <?php echo $user->display_name ?>
                    <br>
                    <a href="<?php echo esc_attr(home_url('dashboard/?action=add-credit')) ?>"
                       class="panel-header-wallet" data-wpel-link="internal">
                        <i class="elegant-icon icon_wallet"></i>
                        <span><?= walletController::getInstance()->getUserCredit(get_current_user_id())['price_for_show_formatted'] ?></span>
                    </a>
                </div>
            </div>

        </div>
        <?php
        $menus = kandopanel_menu_list();

        foreach ($menus as $menu) {
            $action = isset($action) && !empty($action) ? $action : "dashboard";//اگر هیچ اکشنی نبود داشبرد هست
            $section = isset($section) && !empty($section) ? $section : "";//اگر هیچ سکشنی نبود خالی بزار
            if ($menu['enable']) {
                if ($menu['for_admin'] == 0 || ($menu['for_admin'] == 1 && kando_user_can($menu['access_key']))) {// اگر برای کاربر باشه یا برای مدیر باشه و کاربر هم مدیر باشه

                    ?>

                    <a href="<?= $menu['link'] ?>" data-wpel-link="internal"><i
                                class="<?= $menu['icon'] ?>"></i><?= $menu['name'] ?><?php if (isset($menu['numbers']) && $menu['numbers'] > 0 && samyar_is_admin()): ?>
                            <span class="button button-default badge-error-orders"><?php echo $menu['numbers']; ?></span><?php endif; ?>
                    </a>

                <?php }
            }
        } ?>
    </div>
</div>