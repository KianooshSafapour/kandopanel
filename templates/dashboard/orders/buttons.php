<div class="tickets-navigation">
<!--	<span class="button button-default">--><?php //echo $title ?><!--</span>-->
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=orders&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal"><?php _e("Add order", SAMYAR_TEXT_DOMAIN); ?></a>
	<a href="#" class="button button-blue kando-show-order-filter" data-wpel-link="internal"><?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?></a>

</div>