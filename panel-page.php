<?php
/*
Template Name: Dashboard
*/
if (!is_user_logged_in()) {
    wp_redirect(site_url('/login'));
} else {
    $mobile_approved = (int)get_the_author_meta('mobile_approved', get_current_user_id());

    if (is_page('dashboard') && isset($_GET['action']) && $_GET['action'] !== "verify-mobile" && $_GET['action'] !== "edit-profile" && !samyar_is_admin() && settingsController::getInstance()->get_option('enable-sms', 0) && $mobile_approved === 0) {
        wp_redirect(site_url('/dashboard/?action=verify-mobile'));
    }

//    $two_fa = (int)get_the_author_meta('2fa', get_current_user_id());//اگر 2fa فعال هست
//    $two_fa_2fa_approve = (int)get_the_author_meta('2fa_approve', get_current_user_id());//آیا کد دو عاملیتی رو تایید کرده یا خیر
    $tfa_enabled = get_user_meta(get_current_user_id(), '2fa_enabled', true);
    $tfa_verified = get_user_meta(get_current_user_id(), 'tfa_needs_verification', true);
    if($tfa_enabled && $tfa_verified && is_page('dashboard') && isset($_GET['action']) && $_GET['action'] !== "verify-mobile"){
        wp_redirect(site_url('/dashboard/?action=verify-mobile&for=2fa'));
    }
}



$options = settingsController::getInstance();
$user_panel = kando_get_option('select_user_panel', 'panel2');
$admin_panel = kando_get_option('select_admin_panel', $user_panel);

if(samyar_is_admin()){
    switch ($admin_panel) {
        case 'panel1':
            include(SAMYAR_DIR_TEMPLATE . '/user-panels/panel1.php');
            break;
        case 'panel2':
            include(SAMYAR_DIR_TEMPLATE . '/user-panels/panel2.php');
            break;

        default:
            do_action('kando_select_userpanel', $admin_panel);
            break;
    }

}else{
    switch ($user_panel) {
        case 'panel1':
            include(SAMYAR_DIR_TEMPLATE . '/user-panels/panel1.php');
            break;
        case 'panel2':
            include(SAMYAR_DIR_TEMPLATE . '/user-panels/panel2.php');
            break;

        default:
            do_action('kando_select_userpanel', $user_panel);
            break;
    }
}

