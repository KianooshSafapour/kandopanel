<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


use samyar\Payment;

?>
<?php if (kando_user_can('show_payment_filter')): ?>
	<div class="tickets-navigation">
		<a href="<?php echo esc_attr( home_url( 'dashboard/?action=payments&section=users-payment' ) ) ?>" style="float: right;" class="button button-red" data-wpel-link="internal">تراکنش های کاربران</a>
	</div>
	<div class="kt-row">
		<div class="column kt-col-xs-12 kt-col-md-12 float-right" style="margin-top:5px;">
			<form method="POST" class="samyar-form filter-payments-form">
				<input type="hidden" name="action" value="samyar_filter_payments_form">
				<div class="new-api-provider-form-errors"></div>
				<div class="samyar-form-loading"></div>
				<div class="clearfix">
					<div class="column kt-col-xs-12 kt-col-md-5 float-right">
						<input type="text" name="query" placeholder="<?php _e("Enter here", SAMYAR_TEXT_DOMAIN); ?>">
					</div>
					<div class="column kt-col-xs-12 kt-col-md-5 float-right">
						<select name="filter_type">
							<option value="0"><?php _e("Select the filter type", SAMYAR_TEXT_DOMAIN); ?></option>
							<option value="transaction-id"><?php _e("Transaction id", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="email"><?php _e("User email", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="mobile"><?php _e("Mobile", SAMYAR_TEXT_DOMAIN); ?></option>
						</select>
					</div>
					<div class="column kt-col-xs-12 kt-col-md-2 float-right">
						<input type="submit" class="button button-green sen" value="<?php _e("Search", SAMYAR_TEXT_DOMAIN); ?>">
					</div>
				</div>
			</form>
		</div>
	</div>

<div class="dashboard-posts-box dashboard-tickets-box">
	<div class="dashboard-posts-title-holder">
		<i class="elegant-icon icon_creditcard"></i>
		<h5 class="dashboard-posts-title">پرداخت ها</h5>
	</div>
	<div class="dashboard-posts-list">
		<?php
		//		$payments = Payment::all();
		// * paginate
		$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//شماره صفحه فعلی
		$limit  = 30; //تعداد قابل نمایش
		$offset = ( $limit * $paged ) - $limit;


		$payments = Payment::where( ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset ] );
		if ( $payments ):
			?>

			<table class="shop_table shop_table_responsive">
				<thead>
				<tr>
					<th><span class="nobr">نوع</span></th>
					<th><span class="nobr">شناسه</span></th>
					<th><span class="nobr">درگاه</span></th>
					<th><span class="nobr">مبلغ پرداختی</span></th>
					<th><span class="nobr">اطلاعات کاربر</span></th>
					<th><span class="nobr">توضیحات</span></th>
					<th><span class="nobr">وضعیت</span></th>
					<!--                    <th><span class="nobr">عملیات ها</span></th>-->
				</tr>
				</thead>

				<tbody>
				<?php
				foreach ( $payments as $payment ):
					?>
					<tr id="order-<?php echo esc_attr( $payment->id ) ?>">
						<td data-title="نوع">
							<?php if ( $payment->status == 1 ): ?>
								<?php if ( $payment->payment_type == "add-credit" ): ?>
									<span style="color: #00a699;font-size: 20px;"><i class="fal fa-plus"></i></span>
								<?php elseif ( $payment->payment_type == "decrease-credit" ): ?>
									<span style="color: #e60921;font-size: 20px;"><i class="fal fa-minus"></i></span>
								<?php elseif ( $payment->payment_type == "set-credit" ): ?>
                                    <span style="color: #00a699;font-size: 20px;" data-tooltip="تنظیم اعتبار"><i class="fal fa-credit-card"></i></span>
								<?php elseif ( $payment->payment_type == "order" ): ?>
									<span style="color: #e60921;font-size: 20px;"><i class="fal fa-minus"></i></span>
								<?php endif; ?>
							<?php endif; ?>
						</td>

						<td data-title="شناسه">
							<?php echo esc_attr( $payment->id ) ?>
						</td>
						<td data-title="درگاه">
                            <?php

                            switch ($payment->gateway) {
                                case 'bitpay':
                                    $text = __('bitpay', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-red";
                                    break;
                                case 'idpay':
                                    $text = __('idpay', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-blue";
                                    break;
                                case 'payir':
                                    $text = __('payir', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-default";
                                    break;
                                case 'zarinpal':
                                    $text = __('zarinpal', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-orange";
                                    break;
                                case 'zibal':
                                    $text = __('zibal', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-green";
                                    break;
                                case 'nextpay':
                                    $text = __('nextpay', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-blue";
                                    break;
                                case 'mrpardakht':
                                    $text = __('mrpardakht', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-blue";
                                    break;
                                case 'wallet':
                                    $text = __('wallet', SAMYAR_TEXT_DOMAIN);
                                    $color = "button-aqua";
                                    break;
                                case 'card_to_card':
                                    $text = __( "card to card", SAMYAR_TEXT_DOMAIN );
                                    $color = "button-blue";
                                    break;
                                default:
                                    $result = [];
                                    $result = apply_filters('kando_payment_list',$result,$payment->gateway);
                                    $text = $result['text'];
                                    $color = $result['color'];
                                    break;
                            }
                            ?>

                            <?php echo '<span class="button ' . $color . ' badge-error-orders">' . $text . '</span>'; ?>
						</td>
						<td data-title="مبلغ">
							<?php
							if ($payment->amount):
								echo number_format_i18n( esc_attr( (int)$payment->amount ) ).'  '.kando_get_currency_base_text(false);
							endif;
							?>
						</td>
						<td data-title="اطلاعات کاربر">
							<?php
							$user = get_user_by('id',$payment->uid);
							echo $user->display_name;
							echo "<br>";
							echo get_user_meta($user->ID,'mobile',true);
							?>
						</td>
						<td data-title="توضیحات">
							<?php echo esc_attr( $payment->note ) ?>
						</td>
						<td data-title="وضعیت">
							<?php
							switch ( $payment->status ) {
								case 0:
									echo "<span style='color: #f58'>ناموفق</span>";
									break;
								case 1:
									echo "<span style='color: #7ccc77'>موفق</span>";
									break;
							}
							?>
						</td>
						<!--                        <td data-title="عملیات ها">-->
						<!--							--><?php //if ( $payment->status == 0 ):
						?>
						<!--                                <input type="submit" class="button button-green alt" name="woocommerce_checkout_place_order" id="place_order" value="پرداخت" data-value="پرداخت"/>-->
						<!--							--><?php //endif;
						?>
						<!--                        </td>-->
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php
			$total = Payment::count();
			samyar_pagination( $total, $limit, $paged )
			?>
		<?php
		else:
			?>
			<span class="payments-notfound">تاکنون تراکنشی انجام نشده است.</span>
		<?php
		endif;
		?>
	</div>
</div>
<?php endif; ?>