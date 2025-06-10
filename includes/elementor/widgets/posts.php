<?php

namespace kandoElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class kandoPosts extends Widget_Base {

	public static $slug = 'samyar-posts';

	public function get_name() {
		return self::$slug;
	}

	public function get_title() {
		return __( 'smamyar list posts', self::$slug );
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
				'label' => "تنظیمات",
			]
		);

		$this->add_control(
			'post-number',
			[
				'label' => "تعداد پست",
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
            <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-4">
                <div class="course-item-holder">
					<?php if ( has_post_thumbnail( $post ) ): ?>
                        <a href="<?php the_permalink( $post ); ?>" class="course-item-image-holder" data-wpel-link="internal">
							<?php echo get_the_post_thumbnail( $post, array( 300, 300 ), [ 'class' => 'kt-lazyload', 'data-src' => get_the_post_thumbnail_url( $post ) ] ); ?>
                        </a>
					<?php endif; ?>
                    <div class="course-item-desc-holder">
                        <h3 class="course-item-title">
                            <a href="<?= get_permalink( $post ) ?>" data-wpel-link="internal"><?= $post->post_title ?></a>
                        </h3>

						<?php
						$categories = get_the_category( $post );
						$separator  = ',';
						$output     = '';
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$output .= '<a href="' . get_category_link( $category ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
							}

						}
						?>
                        <div class="course-item-details">
                            <div class="course-item-types">
                                <span class="course-item-type course-item-type-online"><?= trim( $output, $separator ); ?></span>
                            </div>
                        </div>
                        <span class="course-item-content"><?= $post->post_excerpt ?></span>
                        <ul class="course-item-meta clearfix">
                            <li><i class="dripicons dripicons-calendar"></i><span><?= date_i18n( 'd M Y', strtotime( $post->post_date ) ) ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
		<?php
	}
}