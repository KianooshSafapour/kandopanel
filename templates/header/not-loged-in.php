<a href="<?= home_url('/login') ?>" class="button button-light"><?php _e("Login", SAMYAR_TEXT_DOMAIN); ?></a>
<a href="<?= add_query_arg(['action'=>'register'], home_url('/login')) ?>" class="button button-default"><?php _e("Register", SAMYAR_TEXT_DOMAIN); ?></a>
<!--<button type="button" class="button fa fa-user kt-modal-button header-login-button" data-modal="login"></button>-->