<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


use kandopanel\currencyController;
use samyar\Pmeta;
use samyar\priceController;

$priceSettings = [
    'base_currency_data' => currencyController::getInstance()->getUserCurrency(get_option('base_currency', "IRT")),
    'user_currency_data' => currencyController::getInstance()->getUserCurrency(currencyController::getInstance()->getUserCurrency()),
];
?>
<div class="dashboard-posts-title-holder">
	<i class="elegant-icon icon_creditcard"></i>
	<h5 class="dashboard-posts-title">پرداخت ها</h5>
</div>
<div class="dashboard-posts-list">
	<?php

    if ( $payments ):
		?>

		<table class="shop_table shop_table_responsive">
			<thead>
			<tr>
                <th><span class="nobr"><?php _e("Type", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Gateway", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("User information", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <?php if (kando_user_can('edit_payment')): ?>
                    <th><span class="nobr"><?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?></span></th>
                <?php endif; ?>
			</tr>
			</thead>

			<tbody>
			<?php
			foreach ( $payments as $payment ):
				?>
				<tr id="order-<?php echo esc_attr( $payment->id ) ?>">
                    <td data-title="<?php _e("Type", SAMYAR_TEXT_DOMAIN); ?>" class="<?php if ( $payment->status == 1 ): ?>success-payment<?php else: ?>fail-payment<?php endif; ?>">
                        <?php //if ($payment->status == 1): ?>
                        <?php if ($payment->payment_type == "add-credit"): ?>
                            <span style="color: #00a699;font-size: 20px;" data-tooltip="<?php _e("Add funds", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-plus"></i></span>
                        <?php elseif ($payment->payment_type == "decrease-credit"): ?>
                            <span style="color: #e60921;font-size: 20px;" data-tooltip="<?php _e("Decrease credit", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-minus"></i></span>
                        <?php elseif ($payment->payment_type == "set-credit"): ?>
                            <span style="color: #00a699;font-size: 20px;" data-tooltip="<?php _e("Set credit", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-credit-card"></i></span>
                        <?php elseif ($payment->payment_type == "order"): ?>
                            <span style="color: #e60921;font-size: 20px;"><i class="fal fa-minus" data-tooltip="<?php _e("Credit reduction for order", SAMYAR_TEXT_DOMAIN); ?>"></i></span>
                        <?php elseif ($payment->payment_type == "refund"): ?>
                            <span style="color: #00a699;font-size: 23px" data-tooltip="<?php _e("Refund", SAMYAR_TEXT_DOMAIN); ?>"><i class="fal fa-undo"></i></span>
                        <?php endif; ?>
                        <?php //endif; ?>
                    </td>

                    <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php echo esc_attr( $payment->id ) ?>
                    </td>
                    <td data-title="<?php _e("Gateway", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php

                        switch ($payment->gateway) {
                            case 'bitpay':
                                $text = __("Bitpay", SAMYAR_TEXT_DOMAIN);
                                $color = "button-red";
                                break;
                            case 'zarinpal':
                                $text = __("Zarinpal", SAMYAR_TEXT_DOMAIN);
                                $color = "button-orange";
                                break;
                            case 'zibal':
                                $text = __("Zibal", SAMYAR_TEXT_DOMAIN);
                                $color = "button-green";
                                break;
                            case 'nextpay':
                                $text = __("Nextpay", SAMYAR_TEXT_DOMAIN);
                                $color = "button-blue";
                                break;
                            case 'mrpardakht':
                                $text = __("Mrpardakht", SAMYAR_TEXT_DOMAIN);
                                $color = "button-blue";
                                break;
                            case 'wallet':
                                $text = __("Wallet", SAMYAR_TEXT_DOMAIN);
                                $color = "button-aqua";
                                break;
                            case 'card_to_card':
                                $text = __("Card to card", SAMYAR_TEXT_DOMAIN);
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
					<td data-title="<?php _e("Amount", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php echo priceController::kandoFormatPrice($payment->amount)['price_for_show_formatted'] ?>
					</td>
                    <td data-title="<?php _e("User information", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php
                        $user = get_user_by( 'id', $payment->uid );
                        if ( $user ):
                            echo $user->display_name;
                            echo "<br>";
                            echo get_user_meta( $user->ID, 'mobile', true );
                        endif;
                        ?>
                    </td>
                    <td data-title="<?php _e("Date", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php
                        $date_format = get_option('date_format');
                        $time_format = get_option('time_format');
                        echo date_i18n( $date_format.' '.$time_format, strtotime( $payment->created_at ) ) ?>
                    </td>
                    <td data-title="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php echo esc_attr( $payment->note ) ?>
                        <?php if ( $payment->order_id && $payment->status === "1" && ( $payment->payment_type === "decrease-credit" || $payment->payment_type === "refound" ) ): ?>
                            (<a href="<?php echo esc_attr( home_url( 'dashboard/?action=orders&section=edit&id=' . esc_attr( $payment->order_id ) ) ) ?>"><?php _e("Order", SAMYAR_TEXT_DOMAIN); ?></a>)
                        <?php endif ?>

                        <?php
                        $coupon_code           = Pmeta::find_where( [ 'payment_id' => $payment->id, 'meta_key' => 'coupon_code' ] );
                        if ( $coupon_code ):
                            $original_price = Pmeta::find_where( [ 'payment_id' => $payment->id, 'meta_key' => 'original_price' ] );
                            $price_by_discount = Pmeta::find_where( [ 'payment_id' => $payment->id, 'meta_key' => 'price_by_discount' ] );
                            ?>
                            <span class="button button-green badge-error-orders"
                                  style="margin-right: 0;"><?php _e("Amount charged:", SAMYAR_TEXT_DOMAIN); ?>   <?= number_format_i18n( (int)$original_price->meta_value ) ?> <?php kando_get_currency_base_text() ?></span>
                            <br>
                            <?php _e("discount:", SAMYAR_TEXT_DOMAIN); ?>   <?= number_format_i18n( (int)$original_price->meta_value - (int)$price_by_discount->meta_value ) ?><?php kando_get_currency_base_text() ?> <br>
                            <?php _e("Amount paid:", SAMYAR_TEXT_DOMAIN); ?>   <?= number_format_i18n( (int)$price_by_discount->meta_value ) ?><?php kando_get_currency_base_text() ?> <br>
                            <?php _e("Gift code:", SAMYAR_TEXT_DOMAIN); ?>   <?= $coupon_code->meta_value ?><br>

                        <?php
                        endif ?>

                        <?php
                        $credit_before_charge = Pmeta::find_where( [ 'payment_id' => $payment->id, 'meta_key' => 'credit_before_charge' ] );
                        if ( $credit_before_charge ) {
                            ?>
                            <?php _e("Credit before charging:", SAMYAR_TEXT_DOMAIN); ?> <?= number_format_i18n( (int)$credit_before_charge->meta_value ) ?><?php kando_get_currency_base_text() ?> <br>
                        <?php }
                        ?>

                        <?php
                        $ref_id = Pmeta::find_where( [ 'payment_id' => $payment->id, 'meta_key' => 'ref_id' ] );
                        if ( $ref_id ) {
                            ?>
                            <?php _e("Tracking ID:", SAMYAR_TEXT_DOMAIN); ?>   <?= $ref_id->meta_value ?><br>
                        <?php }
                        ?>
                    </td>
                    <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
                        <?php
                        switch ($payment->status) {
                            case 0:
                                echo "<span style='color: #f58'>"._e("Unsuccessful", SAMYAR_TEXT_DOMAIN)."</span>";
                                break;
                            case 1:
                                echo "<span style='color: #7ccc77'>"._e("Successful", SAMYAR_TEXT_DOMAIN)."</span>";
                                break;
                            case 2:
                                echo "<span style='color: #7793cc'>"._e("Awaiting confirmation", SAMYAR_TEXT_DOMAIN)."</span>";
                                break;
                        }
                        ?>
                    </td>
                    <?php if ( kando_user_can('edit_payment') ): ?>
                        <td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">

                            <a href="#" class="button button-green kando-change-payment-status" data-id="<?php echo $payment->id ?>" data-status="<?php echo $payment->status ?>"><?php _e("Edit", SAMYAR_TEXT_DOMAIN); ?></a>

                        </td>
                    <?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php
	else:
		?>
        <span class="payments-notfound"><?php _e("No transaction has been done yet.", SAMYAR_TEXT_DOMAIN); ?></span>
	<?php
	endif;
	?>
</div>