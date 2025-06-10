<?php if (isset($_REQUEST['gateway'])) { ?>
	<style>
		.mln {
			margin: 8px 0;
			font-size: 1.2em;
			font-weight: 500;
			border-bottom: 1px solid #f0eeee;
			padding-bottom: 20px;
		}

		/*h2 {*/
		/*    text-align: center;*/
		/*    margin-top: 20px;*/
		/*}*/

		.c-checkout-alert__icon.success {
			/*font-size: 5rem !important;*/
			/*background-color: #d2f3f7;*/
			color: #4ac9dd;
		}

		.c-checkout-alert__icon.failed {
			/*background-color: rgba(251, 52, 73, .18);*/
			color: #ff637d
		}

		.payment-status.success {
			color: #4ac9dd;
		}

		.payment-status.failed {
			color: #ff637d
		}

		.c-checkout-alert__icon {
			margin: 0 auto 6px;
			/*padding: 27px;*/
			/*border-radius: 50%;*/
			width: 138px;
			height: 86px;
		}

		.c-checkout-alert__icon i {
			font-size: 100px;
			line-height: 34px;
			position: relative;
			right: -14px;
		}

		.c-checkout-alert__title h4 {
			color: #737373;
			font-size: 21px;
			line-height: 38px;
			font-weight: 700;
			letter-spacing: -.5px;
			text-align: center;
			margin: 20px 0 10px 0;
		}

		.c-checkout-alert__highlighted--success {
			color: #00bfd6;
			background-color: #ebfdff;
		}

		.c-checkout-alert__highlighted {
			border-radius: 8px;
			padding: 3px 5px 0;
			margin: 0 5px;
		}
	</style>
	<div class="wpsp-container" style="max-width: 100%;">
		<div class="kt-row wpsp-card">
			<div class="kt-col-sm-12">
				<div class="card">
<!--					<div class="card-header">بررسی پرداخت</div>-->
					<div class="card-body">
						<?php
						global $wpdb;
						$result = [
							'success'=>false,
							'data'=>"درگاه فعالی وجود ندارد"
						];
//						$table_name = $wpdb->prefix . 'samyar_payments';
						//                    $data = wpsp_process_payment($_REQUEST);
						$result = apply_filters( 'samyar_end_payment_process',$_REQUEST,$result);
						/*
						switch ($_REQUEST['gateway']) {
							case "zarinpal":
								$zarinpal = wpsp_zarinpal::get_instance();
//                                $Authority = (int)$_REQUEST['Authority'];
								$payment_id = (int)$_REQUEST['payment_id'];

								$payment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '$payment_id'", ARRAY_A);

								$data = $zarinpal->back($payment['amount'], $_REQUEST);
								if ($data['success']) {

									//سفارش رو به اسمارت پنل ارسال می کنیم
									$api_data = [
										'payment_id' => $payment_id,
										'order_id' => $payment['order_id'],
										'note' => $data['msg'],
										'transaction_id' => $data['RefID'],
										'payment_type' => $_REQUEST['gateway'],
									];
									$api_order_id = wpsp_send_order_to_api($api_data);

								}


//                            print_r($data);
								break;
							case "idpay":
								$idpay = wpsp_idpay::get_instance();
								$payment_id = (int)$_REQUEST['payment_id'];

								$payment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '$payment_id'", ARRAY_A);

								$data = $idpay->back($payment['amount'], $_REQUEST);
								if ($data['success']) {

									//سفارش رو به اسمارت پنل ارسال می کنیم
									$api_data = [
										'payment_id' => $payment_id,
										'order_id' => $payment['order_id'],
										'note' => $data['msg'],
										'transaction_id' => $data['RefID'],
										'payment_type' => $_REQUEST['gateway'],
									];
									$api_order_id = wpsp_send_order_to_api($api_data);

								}


//                            print_r($data);
								break;
							case "payir":
								$payir = wpsp_payir::get_instance();
								$payment_id = (int)$_REQUEST['payment_id'];

								$payment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '$payment_id'", ARRAY_A);

								$data = $payir->back($payment['amount'], $_REQUEST);
								if ($data['success']) {

									//سفارش رو به اسمارت پنل ارسال می کنیم
									$api_data = [
										'payment_id' => $payment_id,
										'order_id' => $payment['order_id'],
										'note' => $data['msg'],
										'transaction_id' => $data['RefID'],
										'payment_type' => $_REQUEST['gateway'],
									];
									$api_order_id = wpsp_send_order_to_api($api_data);

								}


//                            print_r($data);
								break;
							case "zibal":
								$zibal = wpsp_zibal::get_instance();
								$payment_id = (int)$_REQUEST['payment_id'];

								$payment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '$payment_id'", ARRAY_A);

								$data = $zibal->back($payment['amount'], $_REQUEST);
								if ($data['success']) {

									//سفارش رو به اسمارت پنل ارسال می کنیم
									$api_data = [
										'payment_id' => $payment_id,
										'order_id' => $payment['order_id'],
										'note' => $data['msg'],
										'transaction_id' => $data['RefID'],
										'payment_type' => $_REQUEST['gateway'],
									];
									$api_order_id = wpsp_send_order_to_api($api_data);

								}


//                            print_r($data);
								break;
							case "bitpay":
								$bitpay = wpsp_bitpay::get_instance();
								$payment_id = (int)$_REQUEST['payment_id'];

								$payment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '$payment_id'", ARRAY_A);

								$data = $bitpay->back($payment['amount'], $_REQUEST);
								if ($data['success']) {

									//سفارش رو به اسمارت پنل ارسال می کنیم
									$api_data = [
										'payment_id' => $payment_id,
										'order_id' => $payment['order_id'],
										'note' => $data['msg'],
										'transaction_id' => $data['RefID'],
										'payment_type' => $_REQUEST['gateway'],
									];
									$api_order_id = wpsp_send_order_to_api($api_data);

								}


//                            print_r($data);
								break;
						}
						*/
						?>
						<?php if ($result['success']) { ?>
							<div class="c-checkout-alert__icon success" style="text-align: center">

                                <i class="fal fa-check-circle"></i>
							</div>
							<div class="c-checkout-alert__title">
								<h4>
									سفارش <span class="c-checkout-alert__highlighted c-checkout-alert__highlighted--success js-checkout_dkc_sn"><?php echo $result['order_id'] ?></span> با
									موفقیت
									پرداخت
									و
									ارسال شد.
								</h4>
							</div>
						<?php } else { ?>
							<div class="c-checkout-alert__icon failed" style="text-align: center">
								<i class="fal fa-window-close"></i>
							</div>
							<div class="c-checkout-alert__title"><h4>پرداخت شما ناموفق بود (شما می توانید به پایین همین صفحه رفته و مجدد اقدام به پرداخت نمایید)</h4></div>
						<?php } ?>
						<div class="kt-row" style="margin: 40px 0 ">
							<div class="kt-col-md-6 kt-col-xs-12" style="margin: auto;">
								<?php if (isset($result['order_id'])) { ?>
									<div class="kt-row mln">
										<div class="kt-col-md-6 kt-col-xs-6">شماره سفارش:</div>
										<div class="kt-col-md-6 kt-col-xs-6"><?php echo $result['order_id'] ?></div>
									</div>
								<?php } ?>
								<?php if (isset($payment['id'])) { ?>
									<div class="kt-row mln">
										<div class="kt-col-md-6 kt-col-xs-6">شماره فاکتور:</div>
										<div class="kt-col-md-6 kt-col-xs-6"><?php echo $_REQUEST['payment_id'] ?></div>
									</div>
								<?php } ?>
								<?php if (isset($result['gateway'])) { ?>
									<div class="kt-row mln">
										<div class="kt-col-md-6 kt-col-xs-6">درگاه:</div>
										<div class="kt-col-md-6 kt-col-xs-6"><?php _e($result['gateway'], SAMYAR_TEXT_DOMAIN) ?></div>
									</div>
								<?php } ?>
								<?php if (isset($result['price'])) { ?>
									<div class="kt-row mln">
										<div class="kt-col-md-6 kt-col-xs-6">مبلغ:</div>
										<div class="kt-col-md-6 kt-col-xs-6"><?php echo number_format($result['price']) ?> تومان</div>
									</div>
								<?php } ?>
								<?php if (isset($result['RefID'])) { ?>
									<div class="kt-row mln">
										<div class="kt-col-md-6 kt-col-xs-6">رسید تراکنش:</div>
										<div class="kt-col-md-6 kt-col-xs-6"><?php echo $result['RefID'] ?></div>
									</div>
								<?php } ?>
								<div class="kt-row mln">
									<div class="kt-col-md-6 kt-col-xs-6">وضعیت:</div>
									<div class="kt-col-md-6 kt-col-xs-6">
										<?php if ($result['success']) { ?>
											<span class="payment-status success">موفق</span>
										<?php } else { ?>
											<span class="payment-status failed">ناموفق</span>
										<?php } ?>
									</div>
								</div>
								<?php if (isset($result['msg'])) { ?>
									<div class="kt-row mln">
										<div class="kt-col-md-6 kt-col-xs-6">خطا:</div>
										<div class="kt-col-md-6 kt-col-xs-6"><span class="payment-status failed"><?php echo $result['msg'] ?></span></div>
									</div>
								<?php } ?>
							</div>
						</div>

					</div>
				</div>
				<?php if (!$result['success']) { ?>
					<div class="card" style="margin-top: 20px;">
						<div class="card-header">انتخاب درگاه و پرداخت</div>
						<div class="card-body">
							<div class="wpsp-container-fluid">
								<form method="post" id="wpsp_repayment_form">
									<input type="hidden" name="payment_id" value="<?php echo $_REQUEST['payment_id'] ?>">
									<input type="hidden" name="action" value="wpsp_repayment">

									<div class="fields tight cf margin-20 gateways" id="gateways-fields" style="display: block">

										<fieldset class="gateways-list">
											<div class="kt-row">
                                                <div id="payment" class="woocommerce-checkout-payment">
                                                    <ul class="wc_payment_methods payment_methods methods">
														<?php do_action('samyar_order_payments'); ?>
                                                    </ul>
                                                </div>
											</div>
										</fieldset>

									</div>
									<p style="text-align: center">
										<span class="result-repayment-form"></span>
										<button id="wpsp-submit-payment-button" type="button" class="btn btn-success">پرداخت</button>
									</p>
								</form>
								<form style="display:none;" id="wpspPaymentForm" action="" method="GET"></form>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php }