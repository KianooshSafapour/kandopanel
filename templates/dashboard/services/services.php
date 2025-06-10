<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Service;

?>
<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('services'); ?>
    </div>
</div>
<div class="tickets-navigation">
<!--	<span class="button button-default">سرویس ها</span>-->
	<?php if (kando_user_can('add_service')): ?>
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=services&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal">افزودن سرویس</a>
    <?php endif; ?>
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=services&section=all' ) ) ?>"><span class="button button-blue" id="show-service-all" style=""><?php _e("View all services", SAMYAR_TEXT_DOMAIN); ?></span></a>
</div>

		<?php
		echo do_shortcode( '[samyar_services]' );
		?>
