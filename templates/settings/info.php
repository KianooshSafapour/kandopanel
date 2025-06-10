<?php defined( 'ABSPATH' ) || exit( 'No Access!' ); ?>
<div class="samyar-settings-area samyar-settings-info">
    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="info"></span></span>
        <strong><?php _e( 'Information and plugins', SAMYAR_TEXT_DOMAIN ); ?></strong>
    </h3>
    <div class="samyar-theme-info uk-text-center">
        <img class="samyar-logo" src="<?php echo SAMYAR_DIR_IMG . '/icon/cando.png'; ?>" alt="logo" width="80" height="80">
        <h3 class="samyar-theme-name">
            <a href="<?php echo SAMYAR_THEME_URI; ?>" target="_blank"><?php echo __( SAMYAR_THEME_NAME , SAMYAR_TEXT_DOMAIN ); ?></a>
        </h3>
        <div class="samyar-version"><?php echo __( 'Version: ', SAMYAR_TEXT_DOMAIN ) . SAMYAR_THEME_VER; ?></div>
        <div class="samyar-developer">
			<?php echo __( 'By:', SAMYAR_TEXT_DOMAIN ); ?>
            <a href="<?php echo SAMYAR_THEME_AUTHOR_URI; ?>" target="_blank"><?php echo __( SAMYAR_THEME_AUTHOR, SAMYAR_TEXT_DOMAIN ); ?></a>
        </div>
    </div>
    <div class="samyar-other-products uk-text-center">
        <h5 class="samyar-title"><?php echo __( 'Visit our other products.', SAMYAR_TEXT_DOMAIN ); ?></h5>
        <div class="uk-child-width-1-2@s uk-grid-match uk-flex-center" uk-grid>
			<?php echo ( new productsController( SAMYAR_TEXT_DOMAIN ) )->render_html(); ?>
        </div>
    </div>
</div>