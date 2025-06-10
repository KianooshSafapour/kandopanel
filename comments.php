<?php

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
// Do not delete these lines
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'Please do not load this page directly. Thanks!' );
}

if ( post_password_required() ) { ?>
    <p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
	return;
}
?>

<!-- You can start editing here. -->
<div class="blog-single-comments <?php if ( get_comments_number() == 0 ): ?>without-comment<?php endif; ?>" id="blog-comments">
    <div id="comments" class="comments clearfix">

		<?php
		if ( comments_open() || pings_open() ) {
			?>
            <div class="comments-title clearfix">
                <div class="comments-title-outer">
                    <div class="comments-title-inner">
						<?php if ( get_comments_number() > 0 ): ?>
                            <span class="comments-number"><?php echo get_comments_number() ?></span><span><?php _e( "Comment", SAMYAR_TEXT_DOMAIN ) ?></span>
						<?php else: ?>
                            <span><?php _e( "No comment", SAMYAR_TEXT_DOMAIN ) ?></span>
						<?php endif; ?>
                    </div>

                    <span><?php _e( "Participate in the discussion about this article!", SAMYAR_TEXT_DOMAIN ) ?></span>

                </div>
				<?php if ( get_comments_number() > 0 ): ?>
                    <a href="#" class="comment-open-button button button-green"><?php _e( "Send comment", SAMYAR_TEXT_DOMAIN ) ?></a>
				<?php endif; ?>
            </div>

            <div class="comment-form-outer">
                <div class="comment-form-holder clearfix">
                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">
                            <a rel="nofollow" id="cancel-comment-reply-link" href="<?php the_permalink(); ?>#respond" style="display:none;" data-wpel-link="internal"><?php _e( "Cancel response", SAMYAR_TEXT_DOMAIN ) ?></a>
                        </h3>
                        <form action="<?php echo site_url( '/wp-comments-post.php' ) ?>" method="post" id="commentform" class="comment-form" novalidate>
							<?php if ( is_user_logged_in() ): ?>
                                <p class="logged-in-as"><a href="<?php echo get_option( 'siteurl' ); ?>/wp-admin/profile.php"
                                                           aria-label="<?php echo sprintf(__('Entered as %s Edit your birth certificate.', SAMYAR_TEXT_DOMAIN), get_user_option( 'user_nicename' )); ?>"
                                                           data-wpel-link="internal"><?php echo sprintf(__('You are logged in as %s', SAMYAR_TEXT_DOMAIN), get_user_option( 'user_nicename' )); ?></a>. <a
                                            href="<?php echo wp_logout_url( get_permalink() ); ?>"
                                            data-wpel-link="internal"><?php _e( "Logout?", SAMYAR_TEXT_DOMAIN ) ?></a></p>
							<?php endif; ?>
                            <div class="clearfix">
                                <textarea id="comment" placeholder="<?php _e( "Your comment", SAMYAR_TEXT_DOMAIN ) ?>" name="comment" aria-required="true"></textarea>
                            </div>
							<?php if ( ! is_user_logged_in() ): ?>
                                <div class="comment-name-field"><input type="text" name="author" id="author" placeholder="<?php _e( "First and Lastname", SAMYAR_TEXT_DOMAIN ) ?>" aria-required="true"></div>
                                <div class="comment-email-field"><input type="email" name="email" id="email" placeholder="<?php _e( "Email", SAMYAR_TEXT_DOMAIN ) ?>" aria-required="true"></div>
							<?php endif; ?>
                            <p class="form-submit">
                                <input name="submit" type="submit" id="submit" class="button button-green comment-submit" value="<?php _e( "Send comment", SAMYAR_TEXT_DOMAIN ) ?>"/>
                                <input type='hidden' name='comment_post_ID' value='<?php the_ID() ?>' id='comment_post_ID'/>
                                <input type='hidden' name='comment_parent' id='comment_parent' value='0'/>
	                            <?php do_action('comment_form', $post->ID); ?>
                            </p>
                        </form>
                    </div><!-- #respond -->
                </div>
            </div>
			<?php
		} else { ?>
            <p><?php _e( "Closed comments", SAMYAR_TEXT_DOMAIN ) ?></p>
			<?php
		}
		?>
        <div class="comments-holder">
            <ul class="comments-list">
				<?php
				wp_list_comments(
					array(
						'walker'      => new \samyar\commentController(),
						'avatar_size' => 90,
						'style'       => 'li',
					)
				);
				?>
            </ul>
        </div>
    </div>
</div>