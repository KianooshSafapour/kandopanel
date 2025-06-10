<div class="tickets-navigation">
<!--	<span class="button button-default">--><?php //echo $title ?><!--</span>-->
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=orders&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal"><?php _e("Add order", SAMYAR_TEXT_DOMAIN); ?></a>
	<a href="#" class="button button-blue kando-show-order-filter" data-wpel-link="internal"><?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?></a>
	<?php if ( samyar_is_admin() ): ?>
		<a href="<?php echo esc_attr( home_url( 'dashboard/?action=orders&section=user-orders' ) ) ?>" style="float: left;margin-right: 5px" class="button button-red" data-wpel-link="internal"><?php _e("View orders", SAMYAR_TEXT_DOMAIN); ?></a>
	<?php endif ?>
</div>