<?php

use samyar\Service;

$options = settingsController::getInstance();
?>
<tr id="order-<?php echo esc_attr( $order->id ) ?>">

    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
		<?php echo esc_attr( $order->id ) ?>
    </td>
    <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
		<?php
		$service = Service::find( $order->service_id );
		?>
        <ul class="order-details">
			<?php if ( $service ): ?>
                <li><?php _e("Service:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr( $service->id ) ?>&nbsp;-&nbsp;<?php echo esc_attr( $service->name ) ?></li>
			<?php endif; ?>
			<?php if (kando_user_can('show_order_provider_info')): ?>
				<?php if ( $order->api_provider_id !== "0" && $provider ): ?>
                    <li><?php _e("Provider:", SAMYAR_TEXT_DOMAIN); ?>&nbsp;<?php echo esc_attr( $provider->name ) ?> (<?= $provider->id ?>)</li>
				<?php else: ?>
                    <li><?php _e("Provider: Manual", SAMYAR_TEXT_DOMAIN); ?></li>
				<?php endif; ?>

                <li>
                    <?php _e("Add order type", SAMYAR_TEXT_DOMAIN); ?> &nbsp;
					<?php

					if ( $order->type === 'api' ) {

						//سایت کاربری که درخواست داده رو هم نشون میده
						$site_url    = get_order_meta( $order->id, 'site_url', true );
						$your_domain = get_user_meta( $order->uid, "your_domain", true );
						if ( $site_url && ! empty( $site_url ) ) {
							$site_url = '<span class="button button-green badge-error-orders">' . $site_url . '</span>';
						} else if ( $your_domain && ! empty( $your_domain ) ) {
							$site_url = '<span class="button button-green badge-error-orders">' . $your_domain . '</span>';
						} else {
							$site_url = "";
						}

						echo ' <span class="button button-orange badge-error-orders">API</span>' . $site_url;
					} else {
						echo ' <span class="button button-blue badge-error-orders">'.__("Site", SAMYAR_TEXT_DOMAIN).'</span>';
					}
					?>
                </li>

			<?php endif; ?>


            <li><?php _e("Username:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr( $order->username ) ?>
            <li><?php _e("Quantity:", SAMYAR_TEXT_DOMAIN); ?> <?= $order->sub_min ?>/<?= $order->sub_max ?>
            <li><?php _e("Posts:", SAMYAR_TEXT_DOMAIN); ?>
                <strong>
					<?php
					$real_posts = ( $order->sub_response_posts > 0 ) ? $order->sub_response_posts : 0;
					?>
                    <a href="<?= esc_attr( home_url( 'dashboard/?action=subscriptions&section=childs&main-id=' . esc_attr( $order->id ) ) ) ?>"><?= $real_posts ?></a>
                    / <?= ( $order->sub_posts == - 1 ) ? "&infin;" : $order->sub_posts ?>
                </strong>
            </li>
			<?php
			if ( ! empty( $order->sub_expiry ) && strtotime( $order->sub_expiry ) != "" ) {
				$database_date = $order->sub_expiry;

// تایم‌زون مورد نظر (مثلاً 'Asia/Tehran')
				$target_timezone = 'Asia/Tehran';

// تبدیل تاریخ به تایم‌زون مورد نظر
				$expiry = date_i18n( 'Y-m-d H:i:s', strtotime( $database_date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ), false, true, $target_timezone );
				$expiry = date( "Y-m-d", strtotime( $expiry ) );
			} else {
				$expiry = "";
			}
			?>
            <li><?= __( "Delay", SAMYAR_TEXT_DOMAIN ) ?>:
                <strong><?= ( $order->sub_delay == "" || $order->sub_delay == 0 ) ? __( "No_delay", SAMYAR_TEXT_DOMAIN ) : $order->sub_delay . " " . __( "minutes", SAMYAR_TEXT_DOMAIN ) ?></strong>
            </li>
            <li><?= __( "Expiry", SAMYAR_TEXT_DOMAIN ) ?>: <strong><?= $expiry ?></strong></li>

			<?php if ( $order->user_note && kando_user_can('show_order_provider_info') ): ?>
                <li><?php _e("User message:", SAMYAR_TEXT_DOMAIN); ?>
                    <button class="button kt-modal-button button-orange kando-show-info" data-modal="info" data-tooltip="<?php _e("Click to view orders", SAMYAR_TEXT_DOMAIN); ?>" data-type="order"
                            data-info="user-note" data-order="<?= $order->id ?>"><?php _e("View orders", SAMYAR_TEXT_DOMAIN); ?>
                    </button>
                </li>
			<?php endif; ?>



			<?php if ( $order->is_drip_feed || $service->type === "subscriptions" ) { ?>
<!--                <li>-->
<!--					--><?php
//					echo '<a href="' . esc_attr( home_url( 'dashboard/?action=subscriptions&section=subscription&main-id=' . esc_attr( $order->id ) ) ) . '" class="button button-blue badge-error-orders" data-tooltip="برای مشاهده سفارش ها کلیک کنید" data-type="order"
/*                                data-info="comments" data-order="<?= $order->id ?>">کلیک کنید*/
//                        </a>';
//					?>
<!--                </li>-->
			<?php } ?>

        </ul>
    </td>

	<?php if (kando_user_can('show_order_user_info')): ?>
        <td data-title="اطلاعات کاربر">
			<?php
			$user = get_user_by( 'id', $order->uid );
			if ( $user ) {
				echo $user->display_name;
				echo "<br>";
				echo get_user_meta( $user->ID, 'mobile', true );
			} else {
				echo 'وجود ندارد';
			}

			?>
        </td>
        <td data-title="شناسه سفارش در API">
			<?php echo ( $order->api_order_id == 0 || $order->api_order_id == - 1 ) ? "" : $order->api_order_id ?>
        </td>
        <td data-title="پاسخ API">
			<?php echo esc_attr( $order->note ) ?>
        </td>
	<?php endif; ?>
    <td data-title="<?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?>">
		<?php echo date_i18n( 'd M Y، H:i', strtotime( $order->created_at ) ) ?>
    </td>
    <td data-title="<?php _e("Update date", SAMYAR_TEXT_DOMAIN); ?>">
		<?php echo date_i18n( 'd M Y، H:i', strtotime( $order->update_at ) ) ?>
    </td>
    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
		<?php
		if ( kando_is_normal_user() && in_array( $order->status, [ 'fail', 'error' ] ) ) {
			$order->status = 'processing';
		}
		?>
        <span style="display: inline-block;" class="button order-status <?= samyar_status_color( $order->status ) ?>">
                                <?php echo samyar_order_status_title( esc_attr( $order->status ) ); ?>
                            </span>
		<?php if ( kando_is_normal_user() && ( $order->status === "awaiting" ) ): ?>
            <span class="button button-red repayment-order kt-modal-button" data-modal="repayment" data-id="<?php echo esc_attr( $order->id ) ?>">پرداخت مجدد</span>
		<?php endif; ?>
    </td>
    <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">


		<?php if ( $order->status === "awaiting_cancel" ) { ?>
			<?php
			$delay_time_order = (int) $options->get_option( 'delay-time-order', 10 );
			$date2            = new DateTime( date( "Y-m-d H:i:s", strtotime( "+$delay_time_order minute", strtotime( $order->created_at ) ) ) );
			?>
            <span class="wating-timer" id="wating-timer-<?= $order->id ?>"></span>
            <script type="text/javascript">
                kando_count_time("<?php echo $date2->format( 'Y m d H:i:s' ) ?>", "wating-timer-<?=$order->id?>", "فرصت برای لغو سفارش",)
            </script>
            <span class="button button-red btn-small cancel-order" data-id="<?php echo esc_attr( $order->id ) ?>" data-tooltip="لغو"><i class="fal fa-ban"></i></span>
            <span class="button button-aqua btn-small fast-send-order" data-id="<?php echo esc_attr( $order->id ) ?>" data-tooltip="همین حالا ارسال کن"><i class="fal fa-share-square"></i></span>
		<?php } ?>

		<?php if (kando_user_can('edit_order')): ?>
            <a href="<?php echo esc_attr( home_url( 'dashboard/?action=orders&section=edit&id=' . esc_attr( $order->id ) ) ) ?>">
                                    <span class="button button-default btn-small" data-tooltip="ویرایش">
                                        <i class="fal fa-edit"></i>
                                    </span>
            </a>
			<?php
			$status = [ "pending", "error", "awaiting" ];
			if ( in_array( $order->status, $status, true ) ) {
				?>
                <span class="button button-aqua btn-small delete-order" data-id="<?php echo esc_attr( $order->id ) ?>" data-tooltip="حذف"><i class="fal fa-trash"></i></span>
			<?php } ?>
			<?php if ( $order->status === "error" ): ?>
                <span class="button button-red btn-small resend-order" data-id="<?php echo esc_attr( $order->id ) ?>" data-tooltip="ارسال مجدد"><i class="fal fa-redo"></i></span>
			<?php endif; ?>
            <!--                                                        <a href=""><span class="button button-red btn-small">ارسال مجدد</span></a>-->
            <!--                        <a href=""><span class="button button-aqua btn-small">ویرایش</span></a>-->

			<?php if ( (int) $order->api_order_id > 0 && (int) $order->api_provider_id > 0 ): ?>
                <span class="button button-blue btn-small kt-modal-button kando-show-info" data-modal="info" data-order="<?php echo esc_attr( $order->id ) ?>" data-type="status"
                      data-tooltip="بررسی وضعیت سفارش در ارائه دهنده"><i class="fas fa-info-circle"></i></span>
			<?php endif; ?>

		<?php endif; ?>
        <span class="button button-red btn-small kt-modal-button kando-show-info" data-modal="info" data-order="<?php echo esc_attr( $order->id ) ?>" data-type="payments"
              data-tooltip="<?php _e("Transaction history", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-envelope-open-dollar"></i></span>

        <a href="<?php echo esc_attr( home_url( 'dashboard/?action=tickets&section=new&order-id=' . esc_attr( $order->id ) ) ) ?>"><span class="button button-violet btn-small"
                                                                                                                                         data-tooltip="<?php _e("Send a ticket related to this order", SAMYAR_TEXT_DOMAIN); ?>"><i
                        class="fal fa-ticket"></i></span></a>


    </td>
</tr>
