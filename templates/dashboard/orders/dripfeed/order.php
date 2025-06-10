<?php

use samyar\Service;

$options = settingsController::getInstance();
?>
<tr id="order-<?php echo esc_attr($order->id) ?>">

	<td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
		<?php echo esc_attr($order->id) ?>
	</td>
    <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
		<?php
		$service = Service::find($order->service_id);
		?>

		<?php if($order->service_type == "giftcart"){

			include('order/gift.php');

		}else{ ?>
            <ul class="order-details">
				<?php if ($service): ?>
                    <li>سرویس: <?php echo esc_attr($service->id) ?>&nbsp;-&nbsp;<?php echo esc_attr($service->name) ?></li>
				<?php endif; ?>
				<?php if (kando_user_can('show_order_provider_info')): ?>
					<?php if ($order->api_provider_id !== "0" && $provider): ?>
                        <li>ارائه دهنده: &nbsp;<?php echo esc_attr($provider->name) ?> (<?= $provider->id ?>)</li>
					<?php else: ?>
                        <li>ارائه دهنده: دستی</li>
					<?php endif; ?>

                    <li>
                        نوع ثبت سفارش: &nbsp;
						<?php

						if ($order->type === 'api') {

							//سایت کاربری که درخواست داده رو هم نشون میده
							$site_url = get_order_meta($order->id,'site_url',true);
							$your_domain = get_user_meta($order->uid, "your_domain", true);
							if($site_url && !empty($site_url)){
								$site_url = '<span class="button button-green badge-error-orders">'.$site_url.'</span>';
							}else if($your_domain && !empty($your_domain)){
								$site_url = '<span class="button button-green badge-error-orders">'.$your_domain.'</span>';
							}else{
								$site_url = "";
							}

							echo ' <span class="button button-orange badge-error-orders">API</span>'.$site_url;
						} else {
							echo ' <span class="button button-blue badge-error-orders">سایت</span>';
						}
						?>
                    </li>

				<?php endif; ?>


                <li>لینک: <?php
					if (filter_var($order->link, FILTER_VALIDATE_URL)) {
						echo '<a class="CopyToClipBoard2" href="' . $order->link . '" target="_blank"><i class="fal fa-copy"></i>&nbsp;' . samyar_truncate_string($order->link, 35) . '</a>';
					} else {
						echo samyar_truncate_string($order->link, 35);
					}
					$followers = get_order_meta($order->id, 'followers', true);
					$following = get_order_meta($order->id, 'following', true);
					$likes = get_order_meta($order->id, 'like', true);
					$views = get_order_meta($order->id, 'views', true);
					$comments = get_order_meta($order->id, 'comments', true);
					if ($followers) {
						echo '<br>';
						echo 'دنبال کننده: ' . number_format($followers);
					}
					if ($following) {
						echo '<br>';
						echo 'دنبال شونده: ' . number_format($following);
					}
					if ($likes) {
						echo '<br>';
						echo 'لایک: ' . number_format($likes);
					}
					if ($views) {
						echo '<br>';
						echo 'ویو: ' . number_format($views);
					}
					if ($comments) {
						echo '<br>';
						echo 'کامنت: ' . number_format($comments);
					}
					?>

                </li>
				<?php

				//تعداد به همراه هدیه
				$quantity_by_gift = \samyar\Ometa::find_where(['order_id'=>$order->id,'meta_key'=>'quantity_by_gift']);
				if(!$quantity_by_gift){
					$quantity_by_gift = NULL;
				}else{
					$quantity_by_gift = $quantity_by_gift->meta_value;
				}
				?>
                <li>تعداد: <?php echo esc_attr($order->dripfeed_quantity) ?>
                </li>
                <li>مبلغ: <?php echo number_format_i18n(esc_attr((int)$order->charge)) ?> <?php kando_get_currency_base_text() ?></li>
				<?php if (kando_user_can('show_order_provider_info')): ?>
                    <li>(<span style="color:#f58">هزینه</span>/<span style="color:#3ca235">سود</span>): (<span
                                style="color:#3ca235"><?php echo number_format_i18n(esc_attr((int)$order->profit)) ?></span>/<span
                                style="color:#f58"><?php echo number_format_i18n(esc_attr((int)$order->formal_charge)) ?></span>) <?php kando_get_currency_base_text() ?>
                    </li>
				<?php endif; ?>
	            <?php
	            if (!empty($order->sub_response_orders) ) {
		            $real_runs = kando_get_value($order->sub_response_orders, 'runs');
	            }else{
		            $real_runs = 0;
	            }
	            ?>
                <li>اجرا:

                    <strong>
                        <a href="<?= esc_attr(home_url( 'dashboard/?action=dripfeeds&section=drips&main-id='.esc_attr($order->id)))?>"><?=$real_runs?></a> / <?=$order->runs?>
                    </strong>
                </li>
                <li><?=__("interval",SAMYAR_TEXT_DOMAIN)?>: <strong><?=$order->interval?></strong></li>
                <li><?=__("total quantity",SAMYAR_TEXT_DOMAIN)?>: <strong><?=$order->runs * $order->dripfeed_quantity?></strong></li>
				<?php if ($order->user_note && kando_user_can('show_order_provider_info')): ?>
                    <li>پیام کاربر:
                        <button class="button kt-modal-button button-orange kando-show-info" data-modal="info" data-tooltip="برای مشاهده پیام کاربر کلیک کنید" data-type="order"
                                data-info="user-note" data-order="<?= $order->id ?>">کلیک کنید
                        </button>
                    </li>
				<?php endif; ?>


				<?php
				switch ($order->service_type) {
					case 'custom_comments':
					case 'custom_comments_package':
						?>
                        <li>کامنت ها:
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info" data-tooltip="برای مشاهده کامنت ها کلیک کنید" data-type="order"
                                    data-info="comments" data-order="<?= $order->id ?>">کلیک کنید
                            </button>
                        </li>
						<?php
						break;
					case 'mentions_with_hashtags':
						?>
                        <li>نام کاربری ها:
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info" data-tooltip="برای مشاهده نام کاربری ها کلیک کنید" data-type="order"
                                    data-info="usernames" data-order="<?= $order->id ?>">نام کاربری ها
                            </button>
                        </li>
                        <li>هشتگ ها:
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info" data-tooltip="برای مشاهده هشتگ ها کلیک کنید" data-type="order"
                                    data-info="hashtags" data-order="<?= $order->id ?>">هشتگ ها
                            </button>
                        </li>
						<?php
						break;
					case 'mentions_custom_list':
					case 'mentions':
						?>
                        <li>نام کاربری ها:
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info" data-tooltip="برای مشاهده نام کاربری ها کلیک کنید" data-type="order"
                                    data-info="mentions_usernames" data-order="<?= $order->id ?>">نام کاربری ها
                            </button>
                        </li>
						<?php
						break;
					case 'mentions_hashtag':
						?>
                        <li>هشتگ ها:
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info" data-tooltip="برای مشاهده هشتگ ها کلیک کنید" data-type="order"
                                    data-info="hashtag" data-order="<?= $order->id ?>">هشتگ ها
                            </button>
                        </li>
						<?php
						break;
					case 'mentions_user_followers':
					case 'comment_likes':
						?>
                        <li>نام کاربری :
                            <button class="button kt-modal-button button-blue kando-show-info" data-modal="info" data-tooltip="برای مشاهده نام کاربری کلیک کنید" data-type="order"
                                    data-info="username" data-order="<?= $order->id ?>">نام کاربری
                            </button>
                        </li>
						<?php
						break;
					case 'mentions_media_likers':
						?>
                        <li>لینک مدیا: <?php
							if (filter_var($order->media, FILTER_VALIDATE_URL)) {
								echo '<a href="' . $order->media . '" target="_blank">' . samyar_truncate_string($order->media, 35) . '</a>';
							} else {
								echo samyar_truncate_string($order->media, 35);
							}
							?></li>
						<?php
						break;
				}
				?>

				<?php if($order->is_drip_feed || $service->type === "subscriptions"){ ?>
                    <li>
						<?php

						if ($order->is_drip_feed) {
							echo '<a href="'. esc_attr(home_url( 'dashboard/?action=dripfeeds&section=drips&main-id='.esc_attr($order->id))).'" class="button button-blue badge-error-orders" data-tooltip="برای مشاهده سفارش ها کلیک کنید" data-type="order"
                                data-info="comments" data-order="<?= $order->id ?>">دیدن بخش ها
                        </a>';
						} elseif($service->type === "subscriptions") {
							echo '<a href="'. esc_attr(home_url( 'dashboard/?action=subscriptions&section=subscription&main-id='.esc_attr($order->id))).'" class="button button-blue badge-error-orders" data-tooltip="برای مشاهده سفارش ها کلیک کنید" data-type="order"
                                data-info="comments" data-order="<?= $order->id ?>">کلیک کنید
                        </a>';
						}
						?>
                    </li>
				<?php } ?>

            </ul>
		<?php } ?>
    </td>
    <td data-title="<?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?>">
		<?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format.' '.$time_format, strtotime($order->created_at)) ?>
    </td>
    <td data-title="<?php _e("Update date", SAMYAR_TEXT_DOMAIN); ?>">
		<?php echo date_i18n($date_format.' '.$time_format, strtotime($order->update_at)) ?>
    </td>
	<?php if (kando_user_can('show_order_user_info')): ?>
        <td data-title="<?php _e("User information", SAMYAR_TEXT_DOMAIN); ?>">
			<?php
			$user = get_user_by('id', $order->uid);
			if ($user) {
				echo $user->display_name;
				echo "<br>";
				echo get_user_meta($user->ID, 'mobile', true);
			} else {
				echo 'وجود ندارد';
			}

			?>
        </td>
        <td data-title="<?php _e("Order ID in API", SAMYAR_TEXT_DOMAIN); ?>">
			<?php echo ($order->api_order_id == 0 || $order->api_order_id == -1) ? "" : $order->api_order_id ?>
        </td>
        <td data-title="<?php _e("API response", SAMYAR_TEXT_DOMAIN); ?>">
			<?php echo esc_attr($order->note) ?>
        </td>
	<?php endif; ?>

	<td data-title="<?php _e("status", SAMYAR_TEXT_DOMAIN); ?>">
		<?php
		if (kando_is_normal_user() && in_array($order->status, ['fail', 'error'])) {
			$order->status = 'processing';
		}
		?>
		<span style="display: inline-block;" class="button order-status <?= samyar_status_color($order->status) ?>">
                                <?php echo samyar_order_status_title(esc_attr($order->status)); ?>
                            </span>
		<?php if (kando_is_normal_user() && ($order->status === "awaiting")): ?>
			<span class="button button-red repayment-order kt-modal-button" data-modal="repayment" data-id="<?php echo esc_attr($order->id) ?>">پرداخت مجدد</span>
		<?php endif; ?>
	</td>
	<td data-title="<?php _e("Operations", SAMYAR_TEXT_DOMAIN); ?>">


		<?php if ($order->status === "awaiting_cancel") { ?>
			<?php
			$delay_time_order = (int)$options->get_option('delay-time-order', 10);
			$date2 = new DateTime(date("Y-m-d H:i:s", strtotime("+$delay_time_order minute", strtotime($order->created_at))));
			?>
			<span class="wating-timer" id="wating-timer-<?= $order->id ?>"></span>
			<script type="text/javascript">
                kando_count_time("<?php echo $date2->format('Y m d H:i:s') ?>", "wating-timer-<?=$order->id?>", "فرصت برای لغو سفارش",)
			</script>
			<span class="button button-red btn-small cancel-order" data-id="<?php echo esc_attr($order->id) ?>" data-tooltip="لغو"><i class="fal fa-ban"></i></span>
			<span class="button button-aqua btn-small fast-send-order" data-id="<?php echo esc_attr($order->id) ?>" data-tooltip="همین حالا ارسال کن"><i class="fal fa-share-square"></i></span>
		<?php } ?>

		<?php if (kando_user_can('edit_order')): ?>
			<a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=edit&id=' . esc_attr($order->id))) ?>">
                                    <span class="button button-default btn-small" data-tooltip="ویرایش">
                                        <i class="fal fa-edit"></i>
                                    </span>
			</a>
			<?php
			$status = ["pending", "error", "awaiting"];
			if (in_array($order->status, $status, true)) {
				?>
				<span class="button button-aqua btn-small delete-order" data-id="<?php echo esc_attr($order->id) ?>" data-tooltip="حذف"><i class="fal fa-trash"></i></span>
			<?php } ?>
			<?php if ($order->status === "error"): ?>
				<span class="button button-red btn-small resend-order" data-id="<?php echo esc_attr($order->id) ?>" data-tooltip="ارسال مجدد"><i class="fal fa-redo"></i></span>
			<?php endif; ?>
			<!--                                                        <a href=""><span class="button button-red btn-small">ارسال مجدد</span></a>-->
			<!--                        <a href=""><span class="button button-aqua btn-small">ویرایش</span></a>-->

			<?php if ((int)$order->api_order_id > 0 && (int)$order->api_provider_id>0): ?>
				<span class="button button-blue btn-small kt-modal-button kando-show-info" data-modal="info" data-order="<?php echo esc_attr($order->id) ?>" data-type="status"
				      data-tooltip="بررسی وضعیت سفارش در ارائه دهنده"><i class="fas fa-info-circle"></i></span>
			<?php endif; ?>

		<?php endif; ?>
		<span class="button button-red btn-small kt-modal-button kando-show-info" data-modal="info" data-order="<?php echo esc_attr($order->id) ?>" data-type="payments"
		      data-tooltip="تاریخچه تراکنش ها"><i class="fal fa-envelope-open-dollar"></i></span>

		<a href="<?php echo esc_attr(home_url( 'dashboard/?action=tickets&section=new&order-id='.esc_attr($order->id))) ?>"><span class="button button-violet btn-small"
		                                                                                                                          data-tooltip="ارسال تیکت مربوط به این سفارش"><i class="fal fa-ticket"></i></span></a>
	</td>
</tr>
