<?php
$login_url = home_url('/login');
$register_url = add_query_arg(['action'=>'register'], home_url('/login/'));
$samyar_login_page = kando_get_option('samyar-login-page', 0);
$samyar_register_page = kando_get_option('samyar-register-page', 0);

if((int)$samyar_login_page > 0){
    $login_url = get_page_link((int)$samyar_login_page);
}

if((int)$samyar_register_page > 0){
    $register_url = get_page_link((int)$samyar_register_page);
}
?>
<a href="<?= $login_url ?>" class="button button-light"><?php _e("Login", SAMYAR_TEXT_DOMAIN); ?></a>
<a href="<?= $register_url ?>" class="button button-default"><?php _e("Register", SAMYAR_TEXT_DOMAIN); ?></a>
<!--<button type="button" class="button fa fa-user kt-modal-button header-login-button" data-modal="login"></button>-->