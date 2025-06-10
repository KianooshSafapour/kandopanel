<?php

get_header();
include_once('templates/parts/blog-header.php');
$options      = settingsController::getInstance();
$website_title = $options->get_option( 'website-title',get_option( 'blogname' ));
the_post();
?>

<div class="blog-single" itemscope itemtype="http://schema.org/Article">
    <meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
	<?php if ( has_post_thumbnail() ): ?>
        <div class="blog-single-image-holder" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<?php the_post_thumbnail( 'full' ); ?>
        </div>
	<?php endif; ?>
    <div class="blog-single-top-holder">
        <div class="blog-single-categories-holder">
            <div class="blog-single-categories">
				<?php
				$categories = get_the_category();
				$separator  = '،';
				$output     = '';
				if ( ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="category">' . esc_html( $category->name ) . '</a>' . $separator;
					}
					echo trim( $output, $separator );
				}
				?>
            </div>
        </div>
        <h1 class="blog-single-title" itemprop="name headline"><?php echo the_title() ?></h1>
        <div class="kt-row">
            <?php
            $user = new \samyar\userController();
            ?>
            <div class="column kt-col-xs-6">
                <div class="blog-engagements" data-tooltip="<?php echo sprintf(__('%s people have interacted with this post.', SAMYAR_TEXT_DOMAIN), $user->countEngagements(get_the_ID())); ?>">
                    <div class="blog-engagements-icon"><img src="<?php echo SAMYAR_DIR_IMG ?>/fire-off.svg" src=""/></div>
                    <span><?=$user->countEngagements(get_the_ID())?></span>
                </div>
            </div>
            <div class="column kt-col-xs-6 blog-single-date align-left"><span>
                    <time itemprop="datePublished" datetime=""><?php the_date() ?></time>
                </span>
                <meta itemprop="datePublished" content="<?php echo date(DATE_W3C, get_the_time('U')); ?>"/>
                <time itemprop="dateModified" datetime="<?php echo date(DATE_W3C, get_the_modified_time('U')); ?>">
            </div>
        </div>
    </div>
    <?php

    //like
    $like = get_post_meta(get_the_ID(),'like',true);
    $like = is_null($like) || empty($like) ? 0 : $like;

    //dislike
    $dislike = get_post_meta(get_the_ID(),'dislike',true);
    $dislike = is_null($dislike) || empty($dislike) ? 0 : $dislike;

    //اگر کاربر وارد شده لایک یا دیسلایک کرده
    $like_status = get_post_meta(get_the_ID(),'like_status_'.get_current_user_id(),true);
//    $dislike_user = get_post_meta(get_the_ID(),'dislike_'.get_current_user_id(),true);
    $like_status_class = "";
    if(!empty($like_status)){
	        $like_status_class = $like_status;
    }

    $facebook_count = get_post_meta(get_the_ID(),'facebook_like',true);
    $facebook_count = is_null($facebook_count) || empty($facebook_count) ? 0 : $facebook_count;

    $twitter_count = get_post_meta(get_the_ID(),'twitter_like',true);
    $twitter_count = is_null($twitter_count) || empty($twitter_count) ? 0 : $twitter_count;

    $linkedin_count = get_post_meta(get_the_ID(),'linkedin_like',true);
    $linkedin_count = is_null($linkedin_count) || empty($linkedin_count) ? 0 : $linkedin_count;

    $telegram_count = get_post_meta(get_the_ID(),'telegram_like',true);
    $telegram_count = is_null($telegram_count) || empty($telegram_count) ? 0 : $telegram_count;
    ?>
    <div class="blog-single-content-holder">
        <div class="blog-single-content-sidebar">
            <div class="blog-single-social-links">
                <div class="kt-like-holder <?=$like_status_class?>" data-id="<?php the_ID() ?>" data-likes="<?=$like?>" data-dislikes="<?=$dislike?>">
                    <div class="kt-like"><a class="kt-like-button" href="#"><i class="far fa-thumbs-up"></i><span class="kt-like-count"><?=$like?></span></a></div>
                    <div class="kt-dislike"><a class="kt-dislike-button" href="#"><i class="far fa-thumbs-down"></i><span class="kt-dislike-count"><?=$dislike?></span></a></div>
                </div>
                <a href="#blog-comments" class="blog-single-meta-comments"><i class="elegant-icon icon_chat_alt"></i><span><?=get_comments_number()?></span></a>
                <a href="https://www.facebook.com/sharer.php?u=<?=esc_attr(get_the_permalink())?>" target="_blank" class="social-share-button social-share-button-facebook" data-type="facebook" data-id="<?php the_ID() ?>" data-wpel-link="external" rel="nofollow external noopener"><i class="fab fa-facebook"></i><span><?=$facebook_count?></span></a>
                <a href="https://twitter.com/share?text=<?=esc_attr(get_the_title())?>&amp;url=<?=esc_attr(get_the_permalink())?>" target="_blank" class="social-share-button social-share-button-twitter" data-type="twitter" data-id="<?php the_ID() ?>" data-wpel-link="external" rel="nofollow external noopener"><i class="fab fa-twitter"></i><span><?=$twitter_count?></span></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?=esc_attr(get_the_permalink())?>&amp;title=<?=esc_attr(get_the_title())?>&amp;summary=<?=esc_attr(get_the_excerpt())?>" target="_blank" class="social-share-button social-share-button-linkedin" data-type="linkedin" data-id="<?php the_ID() ?>" data-wpel-link="external" rel="nofollow external noopener"><i class="fab fa-linkedin"></i><span><?=$linkedin_count?></span></a>
                <a href="https://telegram.me/share/url?url=<?=esc_attr(get_the_permalink())?>&amp;text=<?=esc_attr(get_the_title())?>" target="_blank" class="social-share-button social-share-button-telegram" data-type="telegram" data-id="<?php the_ID() ?>" data-wpel-link="external" rel="nofollow external noopener"><i class="fab fa-telegram-plane"></i><span><?=$telegram_count?></span></a>
            </div>
        </div>
        <div class="blog-single-content">
            <div itemprop="articleBody" class="post-content">
				<?php the_content(); ?>
            </div>

            <div class="blog-single-sources">
                <span><?php _e("Related Topics", SAMYAR_TEXT_DOMAIN); ?></span>
				<?php the_tags(); ?>
            </div>
            <div class="kt-series-pagination clearfix">
				<?php
				$prev_post = get_previous_post();
				$next_post = get_next_post();
				?>
				<?php if ( $prev_post ): ?>
                    <div>
                        <a href="<?php echo get_permalink( $prev_post ) ?>" data-wpel-link="internal">
                            <div>
								<?php if ( has_post_thumbnail( $prev_post ) ): ?>
                                    <img src="<?php echo get_the_post_thumbnail_url( $prev_post, [ 80, 80 ] ) ?>" alt="<?php echo $prev_post->post_title ?>"/>
								<?php endif; ?>
                                <i class="fal fa-angle-right"></i></div>
                            <h3><?php echo $prev_post->post_title ?></h3>
                        </a>
                    </div>
				<?php endif; ?>
				<?php if ( $next_post ): ?>
                    <div class="float-left">
                        <a href="<?php echo get_permalink( $next_post ) ?>" data-wpel-link="internal">
                            <div>
								<?php if ( has_post_thumbnail( $next_post ) ): ?>
                                    <img src="<?php echo get_the_post_thumbnail_url( $next_post, [ 80, 80 ] ) ?>" alt="<?php echo $next_post->post_title ?>"/>
								<?php endif; ?>
                                <i class="fal fa-angle-left"></i></div>
                            <h3><?php echo $next_post->post_title ?></h3>
                        </a>
                    </div>
				<?php endif; ?>
            </div>

            <div class="blog-goto-comments clearfix">
                        <span><?php _e( "Participate in the discussion about this article!", SAMYAR_TEXT_DOMAIN ) ?></span>
                <a href="#blog-comments" class="button button-default"><?php _e( "Send comment", SAMYAR_TEXT_DOMAIN ) ?></a>
            </div>
	        <?php

	        $telegram_url  = $options->get_option( 'telegram-url', "" );
	        $twitter_url   = $options->get_option( 'twitter-url', "" );
	        $instagram_url = $options->get_option( 'instagram-url', "" );
	        $linkedin_url  = $options->get_option( 'linkedin-url', "" );
	        ?>

            <div class="kt-row blog-single-social-boxes">
	            <?php if ( ! empty( $telegram_url ) ): ?>
                <div class="column kt-col-xs-12 kt-col-md-6">
                    <a href="<?= esc_attr( $telegram_url ) ?>" class="blog-single-social-box blog-single-social-box-telegram" data-wpel-link="external" target="_blank" rel="nofollow external noopener">
                        <div class="blog-single-social-box-icon">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M385.268 121.919l-210.569 129.69c-11.916 7.356-17.555 21.885-13.716 35.323l22.768 80c1.945 6.821 8.015 11.355 14.999 11.355.389 0 .782-.014 1.176-.043 7.466-.542 13.374-6.103 14.367-13.515l5.92-43.866a25.915 25.915 0 018.001-15.45l173.765-161.524a13.817 13.817 0 001.618-18.545 13.836 13.836 0 00-18.329-3.425zM214.32 290.478a46.364 46.364 0 00-14.323 27.655l-2.871 21.278-16.527-58.072c-1.343-4.704.635-9.791 4.805-12.365l154.258-95.007L214.32 290.478z"/>
                                <path d="M503.67 37.382a23.52 23.52 0 00-23.698-4.005L15.08 212.719C5.873 216.27-.047 224.939 0 234.804c.048 9.874 6.055 18.495 15.316 21.965l108.59 40.529 42.359 136.225a23.517 23.517 0 0015.703 15.566 23.49 23.49 0 0021.66-4.31l63.14-51.473a8.642 8.642 0 0110.528-.295l113.883 82.681a23.476 23.476 0 0013.823 4.511 23.6 23.6 0 008.517-1.596c7.486-2.895 12.93-9.312 14.56-17.163l83.429-401.309a23.547 23.547 0 00-7.838-22.753zM491.536 55.99l-83.428 401.308c-.302 1.45-1.346 2.053-1.942 2.284-.6.232-1.785.489-2.997-.393l-113.887-82.685a28.982 28.982 0 00-17.052-5.531 29.013 29.013 0 00-18.347 6.519l-63.154 51.485c-1.124.92-2.291.756-2.885.577-.598-.18-1.665-.69-2.099-2.086L141.9 286.462a10.203 10.203 0 00-6.173-6.527L22.462 237.662c-1.696-.635-2.057-1.958-2.062-2.957-.005-.99.343-2.307 2.023-2.955L487.316 52.409l.008-.003c1.51-.583 2.627.087 3.159.537.534.455 1.384 1.455 1.053 3.047z"/>
                                <path d="M427.481 252.142c-5.506-1.196-10.936 2.299-12.131 7.804l-1.55 7.14c-1.195 5.505 2.299 10.936 7.804 12.131a10.25 10.25 0 002.174.234c4.695 0 8.92-3.262 9.958-8.037l1.55-7.14c1.194-5.505-2.301-10.936-7.805-12.132zm-10.2 46.98c-5.512-1.195-10.938 2.299-12.132 7.804L381.69 414.977c-1.195 5.505 2.299 10.936 7.803 12.131.73.158 1.457.234 2.174.234 4.696 0 8.92-3.262 9.958-8.037l23.459-108.052c1.195-5.505-2.299-10.936-7.803-12.131z"/>
                            </svg>
                        </div>
                        <div class="blog-single-social-box-text">
                            <?php echo sprintf(__('Follow on <b>Telegram</b><br/>%s!', SAMYAR_TEXT_DOMAIN), $website_title); ?>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
	            <?php if ( ! empty( $instagram_url ) ): ?>
                <div class="column kt-col-xs-12 kt-col-md-6">
                    <a href="<?= esc_attr( $instagram_url ) ?>" class="blog-single-social-box blog-single-social-box-instagram" data-wpel-link="external" target="_blank"
                       rel="nofollow external noopener">
                        <div class="blog-single-social-box-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M362 44H150C91.551 44 44 91.551 44 150v212c0 58.449 47.551 106 106 106h61c5.523 0 10-4.477 10-10s-4.477-10-10-10h-61c-47.42 0-86-38.58-86-86V150c0-47.42 38.58-86 86-86h212c47.42 0 86 38.58 86 86v212c0 47.42-38.58 86-86 86h-60.333c-5.523 0-10 4.477-10 10s4.477 10 10 10H362c58.449 0 106-47.551 106-106V150c0-58.449-47.551-106-106-106z"/>
                                <path d="M263.07 450.93c-1.86-1.86-4.44-2.93-7.07-2.93s-5.21 1.07-7.07 2.93S246 455.37 246 458s1.07 5.21 2.93 7.07S253.37 468 256 468s5.21-1.07 7.07-2.93c1.86-1.86 2.93-4.44 2.93-7.07s-1.07-5.21-2.93-7.07zm-87.24-295.22c-3.777-4.03-10.104-4.236-14.135-.461l-.443.417c-4.017 3.79-4.201 10.119-.41 14.136a9.97 9.97 0 007.275 3.137 9.966 9.966 0 006.861-2.727l.391-.367c4.03-3.776 4.237-10.105.461-14.135z"/>
                                <path d="M256 118c-21.964 0-43.824 5.291-63.217 15.301-4.907 2.533-6.832 8.565-4.299 13.473 2.534 4.907 8.566 6.831 13.473 4.299C218.762 142.398 236.945 138 256 138c65.065 0 118 52.935 118 118s-52.935 118-118 118-118-52.935-118-118c0-20.419 5.295-40.537 15.313-58.178 2.727-4.802 1.045-10.906-3.758-13.634-4.803-2.726-10.906-1.045-13.634 3.758C124.197 208.592 118 232.125 118 256c0 76.093 61.907 138 138 138s138-61.907 138-138-61.907-138-138-138z"/>
                                <path d="M256 166c-49.626 0-90 40.374-90 90s40.374 90 90 90 90-40.374 90-90-40.374-90-90-90zm0 160c-38.598 0-70-31.402-70-70s31.402-70 70-70 70 31.402 70 70-31.402 70-70 70zM387.25 86.75c-20.953 0-38 17.047-38 38s17.047 38 38 38 38-17.047 38-38-17.047-38-38-38zm0 56c-9.925 0-18-8.075-18-18s8.075-18 18-18 18 8.075 18 18-8.075 18-18 18z"/>
                            </svg>
                        </div>
                        <div class="blog-single-social-box-text">
                            <?php echo sprintf(__('Follow on <b>Instagram</b><br/>%s!', SAMYAR_TEXT_DOMAIN), $website_title); ?>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php
            if ( is_single() && isset( $post->post_author ) ) {

	            $display_name = get_the_author_meta( 'display_name', $post->post_author );
	            if ( empty( $display_name ) )  $display_name = get_the_author_meta( 'nickname', $post->post_author );
	            $user_description = get_the_author_meta( 'user_description', $post->post_author );
	            // Get author's website URL
	            $user_website = get_the_author_meta('url', $post->post_author);

                // Get link to the author archive page
	            $user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));
	        if ( !empty($user_description) ) : ?>
            <div class="author-bio-holder clearfix">
                <div class="author-avatar">
	                <?php echo get_avatar( get_the_author_meta( 'ID' ,$post->post_author), 120, "", $display_name ) ?>
                </div>
                <div class="author-bio-desc-outer">
                    <div class="clearfix"><h4 class="author-name"><?php echo $display_name ?></h4></div>
                    <div class="author-bio-desc"><?php echo $user_description; ?></div>
                    <a href="<?php echo esc_url( $user_posts ); ?>" class="button button-default button-transparent" data-wpel-link="internal"><?php _e( "Other article", SAMYAR_TEXT_DOMAIN ) ?></a></div>
            </div>
            <?php endif;
            }
//            var_dump(get_the_author_meta('description'));
//            $user_desc = get_the_author_meta( 'user_description' );
            ?>


            <?php samyar_related_posts() ?>

        </div>
    </div>
</div>

<?php
if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
	comments_template();
}
?>
<?php get_footer() ?>
