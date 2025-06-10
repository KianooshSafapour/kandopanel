<div class="dashboard-posts-title-holder">
	<i class="elegant-icon icon_creditcard"></i>
	<h5 class="dashboard-posts-title">پرداخت ها</h5>
</div>
<div class="dashboard-posts-list">
	<?php

    use samyar\Pmeta;

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
                <th><span class="nobr">تاریخ</span></th>
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
					<td data-title="نوع" class="<?php if ($payment->status == 1): ?>success-payment<?php else: ?>fail-payment<?php endif; ?>">
<!--						--><?php //if ($payment->status == 1): ?>
						<?php if ( $payment->payment_type == "add-credit" ): ?>
                            <span style="color: #00a699;font-size: 20px;" data-tooltip="افزایش اعتبار"><i class="fal fa-plus"></i></span>
						<?php elseif ( $payment->payment_type == "decrease-credit" ): ?>
                            <span style="color: #e60921;font-size: 20px;" data-tooltip="کاهش اعتبار"><i class="fal fa-minus"></i></span>
						<?php elseif ( $payment->payment_type == "set-credit" ): ?>
                            <span style="color: #00a699;font-size: 20px;" data-tooltip="تنظیم اعتبار"><i class="fal fa-credit-card"></i></span>
						<?php elseif ( $payment->payment_type == "order" ): ?>
                            <span style="color: #e60921;font-size: 20px;"><i class="fal fa-minus" data-tooltip="کاهش اعتبار برای سفارش"></i></span>
						<?php elseif ( $payment->payment_type == "refund" ): ?>
                            <span style="color: #00a699;font-size: 23px" data-tooltip="بازگشت وجه"><i class="fal fa-undo"></i></span>
						<?php endif; ?>
<!--						--><?php //endif; ?>
					</td>

					<td data-title="شناسه">
						<?php echo esc_attr( $payment->id ) ?>
					</td>
					<td data-title="درگاه">
                        <?php

                        switch ($payment->gateway) {
                            case 'bitpay':
                                $text = "بیت پی";
                                $color = "button-red";
                                break;
                            case 'idpay':
                                $text = "آیدی پی";
                                $color = "button-blue";
                                break;
                            case 'payir':
                                $text = "پی آی آر";
                                $color = "button-default";
                                break;
                            case 'zarinpal':
                                $text = "زرین پال";
                                $color = "button-orange";
                                break;
                            case 'zibal':
                                $text = "زیبال";
                                $color = "button-green";
                                break;
                            case 'wallet':
                                $text = "کیف پول";
                                $color = "button-aqua";
                                break;
                            case 'card_to_card':
                                $text = "کارت به کارت";
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
						<?php echo number_format_i18n( esc_attr( (int)$payment->amount ) ) ?> <?php kando_get_currency_base_text(true)?>
					</td>
                    <td data-title="اطلاعات کاربر">
						<?php
						$user = get_user_by('id',$payment->uid);
						echo $user->display_name;
						echo "<br>";
						echo get_user_meta($user->ID,'mobile',true);
						?>
                    </td>
                    <td data-title="تاریخ">
                        <?php
                        $date_format = get_option('date_format');
                        $time_format = get_option('time_format');
                        echo date_i18n($date_format.' '.$time_format, strtotime($payment->created_at)) ?>
                    </td>
					<td data-title="توضیحات">
                        <?php echo esc_attr($payment->note) ?>
                        <?php if ($payment->order_id && $payment->status === "1" && ($payment->payment_type === "decrease-credit" || $payment->payment_type === "refound")): ?>
                            (<a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($payment->order_id))) ?>">سفارش</a>)
                        <?php endif ?>

                        <?php
                        $coupon_code = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'coupon_code']);
                        if ($coupon_code):
                            $original_price = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'original_price']);
                            $price_by_discount = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'price_by_discount']);
                            ?>
                            <span class="button button-green badge-error-orders" style="margin-right: 0;">مبلغ شارژ شده:   <?= number_format_i18n((int)$original_price->meta_value) ?> <?php kando_get_currency_base_text() ?></span><br>
                            تخفیف:   <?= number_format_i18n((int)$original_price->meta_value - (int)$price_by_discount->meta_value) ?> تومان <br>
                            مبلغ پرداخت شده:   <?= number_format_i18n((int)$price_by_discount->meta_value) ?> تومان <br>
                            کد تخفیف:   <?= $coupon_code->meta_value ?><br>

                        <?php
                        endif ?>
                        <?php
                        $credit_before_charge = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'credit_before_charge']);
                        if($credit_before_charge){?>
                            اعتبار قبل از شارژ:   <?= number_format_i18n((int)$credit_before_charge->meta_value) ?> <?php kando_get_currency_base_text() ?> <br>
                        <?php }
                        ?>
                        <?php
                        $ref_id = Pmeta::find_where(['payment_id' => $payment->id, 'meta_key' => 'ref_id']);
                        if ($ref_id) {
                            ?>
                            شناسه پیگیری:   <?= $ref_id->meta_value ?><br>
                        <?php }
                        ?>
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
                            case 2:
                                echo "<span style='color: #7793cc'>در انتظار تایید</span>";
                                break;
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php
	else:
		?>
		<span class="payments-notfound">تاکنون تراکنشی انجام نشده است.</span>
	<?php
	endif;
	?>
</div>