<?php

namespace kandoElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class kandoPosts2 extends Widget_Base {

	public static $slug = 'samyar-posts2';

	public function get_name() {
		return self::$slug;
	}

	public function get_title() {
		return "آخرین مقالات";
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
        return ['kando-category'];
	}

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Settings', SAMYAR_TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'post-number',
            [
                'label' => __('Number of Posts', SAMYAR_TEXT_DOMAIN),
                'type'  => Controls_Manager::TEXT,
            ]
        );

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$post_number = isset( $settings['post-number'] ) && ! empty( $settings['post-number'] ) ? $settings['post-number'] : "3";
		?>

		<?php
		$posts = get_posts( [
			'numberposts' => $post_number,
		] );
		?>
		<?php foreach ( $posts as $post ): ?>
            <div class="column masonry-item kt-col-sm-6 kt-col-xs-12 kt-col-md-4">
                <div class="blog-item-holder">
                    <div class="blog-image-holder">
						<?php if ( has_post_thumbnail( $post ) ): ?>
                            <a href="<?php the_permalink( $post ); ?>" data-wpel-link="internal">
								<?php echo get_the_post_thumbnail( $post, array( 925, 397 ), [ 'class' => 'kt-lazyload', 'data-src' => get_the_post_thumbnail_url( $post ) ] ); ?>
                            </a>
						<?php endif; ?>
                    </div>
                    <div class="blog-item-desc-holder">
                        <div class="blog-item-top-holder">
							<?php
							$categories = get_the_category( $post );
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
                        <h3 class="blog-item-title"><a href="<?= get_permalink( $post ) ?>" data-wpel-link="internal"><?= $post->post_title ?></a>
                        </h3>
                        <span class="blog-item-content"><?= $post->post_excerpt ?></span>
                        <div class="blog-item-bottom-holder clearfix">
                            <span class="blog-item-readtime"><?= date_i18n( 'd M Y', strtotime( $post->post_date ) ) ?></span>
							<?php
							$user = new \samyar\userController();
							?>
                            <div class="blog-engagements" data-tooltip="<?php echo sprintf(__('%s people have interacted with this post.', SAMYAR_TEXT_DOMAIN), $user->countEngagements($post->ID)); ?>">
                                <div class="blog-engagements-icon"><img src="<?php echo SAMYAR_DIR_IMG ?>/fire-muted.svg"/></div>
                                <span><?= $user->countEngagements( $post->ID ) ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
		<?php
	}
}