<?php if ( ! empty( $related_posts ) ) { ?>
    <div class="related-posts"><span class="related-posts-title"><?php _e("We suggest you read these articles as well", SAMYAR_TEXT_DOMAIN); ?></span>

        <div class="related-posts-inner clearfix">
			<?php
			foreach ( $related_posts as $post ) {
				setup_postdata( $post );
				?>
                <div class="related-post"><a href="<?php the_permalink(); ?>" data-wpel-link="internal">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php echo get_the_post_thumbnail( null, [ 80, 80 ], array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
						<?php } ?>
                        <span><?php the_title_attribute(); ?></span></a>
                </div>
			<?php } ?>
        </div>

    </div>
	<?php
}