<?php
/*
Template Name: blog
*/
get_header();
include_once('templates/parts/blog-header.php');

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
query_posts( array( 'post_type' => 'post', 'post_status' => 'publish','paged' => $paged ) );
//$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
//$the_query = new WP_Query( ['post_type' => 'post','paged=' . $paged ]);
?>
<div class="wrapper blog-page-posts-outer">
    <div class="kt-row blog-items-holder">
        <div class="masonry-size masonry-item kt-col-md-4 kt-col-sm-6 kt-col-xs-12"></div>

	    <?php
	    if(have_posts()){
        while (have_posts()) {
            the_post();
	        ?>
            <div class="column masonry-item kt-col-sm-6 kt-col-xs-12 kt-col-md-4">
                <div class="blog-item-holder">
                    <div class="blog-image-holder">
	                    <?php if ( has_post_thumbnail() ): ?>
                            <a href="<?php the_permalink(); ?>" data-wpel-link="internal" >
			                    <?php the_post_thumbnail(array(380, 200,true), [ 'class' => 'kt-lazyload', 'data-src' => get_the_post_thumbnail_url() ] ); ?>
                            </a>
	                    <?php endif; ?>
                    </div>
                    <div class="blog-item-desc-holder">
                        <div class="blog-item-top-holder">
	                        <?php

                            $user = new \samyar\userController();
                            $categories = get_the_category();
	                        $separator  = '،';
	                        $output     = '';
	                        if ( ! empty( $categories ) ) {
		                        foreach ( $categories as $category ) {
			                        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="category">' . esc_html( $category->name ) . '</a>' . $separator;
		                        }

	                        }
	                        ?>
                            <div class="blog-item-categories">
                                <?php echo trim( $output, $separator ); ?>
                            </div>

                        </div>
                        <h3 class="blog-item-title"><a href="<?php the_permalink(); ?>" data-wpel-link="internal"><?php the_title(); ?></a>
                        </h3>
<!--                        <span class="blog-item-content">--><?php //the_excerpt(); ?><!--</span>-->
                        <div class="blog-item-bottom-holder clearfix">
                            <span class="blog-item-readtime"><?php the_date() ?></span>

                            <div class="blog-engagements" data-tooltip="<?php echo sprintf(__('%s people have interacted with this post.', SAMYAR_TEXT_DOMAIN), $user->countEngagements(get_the_ID())); ?>">
                                <div class="blog-engagements-icon"><img src="<?php echo SAMYAR_DIR_IMG ?>/fire-muted.svg"/></div>
                                <span><?=$user->countEngagements(get_the_ID())?></span></div>
                        </div>
                    </div>
                </div>
            </div>
	        <?php
        }

	    } else {
		    echo '<h2>در حال حاضر مطلبی وجود ندارد</h2>';
	    }
	    ?>


    </div>
    <div class="pagination-holder blog-pagination">
        <?php
        the_posts_pagination( array(
	        'mid_size'  => 2,
	        'prev_text' => '<i class="far fa-angle-right"></i>',
	        'next_text' => '<i class="far fa-angle-left"></i>',
        ) );
        ?>

    </div>
</div>
<?php
wp_reset_query();
?>
<?php get_footer() ?>
