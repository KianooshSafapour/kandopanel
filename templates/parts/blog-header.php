<div class="blog-page-header">
    <div class="wrapper">
        <div class="kt-row">
            <div class="column kt-col-xs-12 kt-col-sm-6">
                <h3 class="blog-page-header-title farsi-title">
                    <a href="<?php echo home_url( 'blog' ) ?>" data-wpel-link="internal"><strong><?php _e("Blog", SAMYAR_TEXT_DOMAIN); ?></strong></a>
                </h3>
            </div>
            <div class="column kt-col-xs-12 kt-col-sm-6">
                <h3 class="blog-page-header-title align-left english-title">
                    <a href="<?php echo home_url( 'blog' ) ?>" data-wpel-link="internal"><strong>Blog</strong></a>
                </h3>
            </div>
        </div>
    </div>
</div>
<?php
$options      = settingsController::getInstance();
$telegram_url  = kando_get_option( 'telegram-url', "" );
$twitter_url   = kando_get_option( 'twitter-url', "" );
$instagram_url = kando_get_option( 'instagram-url', "" );
$linkedin_url  = kando_get_option( 'linkedin-url', "" );
?>
<div class="wrapper">
    <div class="blog-header-bar clearfix">
        <div class="blog-header-social-icons">
			<?php if ( ! empty( $telegram_url ) ): ?>
                <a href="<?= esc_attr( $telegram_url ) ?>" class="fab fa-telegram-plane" data-wpel-link="external" target="_blank" rel="nofollow external noopener"></a>
			<?php endif; ?>
			<?php if ( ! empty( $twitter_url ) ): ?>
                <a href="<?= esc_attr( $twitter_url ) ?>" class="fab fa-twitter" data-wpel-link="external" target="_blank" rel="nofollow external noopener"></a>
			<?php endif; ?>
			<?php if ( ! empty( $instagram_url ) ): ?>
                <a href="<?= esc_attr( $instagram_url ) ?>" class="fab fa-instagram" data-wpel-link="external" target="_blank" rel="nofollow external noopener"></a>
			<?php endif; ?>
			<?php if ( ! empty( $linkedin_url ) ): ?>
                <a href="<?= esc_attr( $linkedin_url ) ?>" class="fab fa-linkedin" data-wpel-link="external" target="_blank" rel="nofollow external noopener"></a>
			<?php endif; ?>
        </div>

        <div class="header-search-holder">
            <a href="#" class="button button-light header-search-button"><i class="elegant-icon icon_search"></i><span><?php _e("Search the site", SAMYAR_TEXT_DOMAIN); ?></span></a>
            <div class="header-search-content has-animation">
                <form role="search" class="search-form" action="<?= home_url( '' ) ?>" method="get">
                    <input name="s" id="s" value="" type="text" placeholder="<?php _e("Search the site", SAMYAR_TEXT_DOMAIN); ?>" class="search-field" autocomplete="off">
                    <button class="search-submit"><i class="search-submit-icon elegant-icon icon_search"></i><i class="search-loading-icon fal fa-refresh"></i></button>
                    <i class="search-remove-value elegant-icon icon_close"></i>
                </form>
                <div class="header-search-content-outer"></div>
            </div>
        </div>

    </div>


    <!-- rank match -->
    <?php if (function_exists('rank_math_the_breadcrumbs')){ ?>
        <div class="breadcrumb-holder" typeof="BreadcrumbList" vocab="https://schema.org/">
            <?php rank_math_the_breadcrumbs(); ?>
        </div>
    <?php	} ?>


</div>