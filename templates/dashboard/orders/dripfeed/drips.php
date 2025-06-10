<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\Provider;
use samyar\Service;

$title = __("drip feeds orders", SAMYAR_TEXT_DOMAIN);
?>


<div class="dashboard-posts-box dashboard-tickets-box">
	<div class="dashboard-posts-title-holder">
		<i class="elegant-icon icon_lifesaver"></i>
		<h5 class="dashboard-posts-title"><?php _e("drip feeds orders", SAMYAR_TEXT_DOMAIN); ?></h5>
	</div>
	<div class="dashboard-posts-list">
		<?php
		$main_id = $_GET['main-id'];
		// * paginate
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
		$limit = 30; //تعداد قابل نمایش
		$offset = ($limit * $paged) - $limit;

		$query = ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset];

		//میخوایم بگیم که اون سفارش هایی که مربوط به چند بخشی هست رو اینجا نشون نده
		$query['main_order_id'] = $main_id;

		$orders = Order::where($query);
		if ($orders):
			?>

			<table class="shop_table shop_table_responsive">
				<thead>
				<tr>
					<th><span class="nobr"><?php _e("ID", SAMYAR_TEXT_DOMAIN); ?></span></th>
					<th><span class="nobr"><?php _e("Details", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e("Update date", SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if (kando_user_can('show_order_user_info')){ ?>
						<th><span class="nobr">اطلاعات کاربر</span></th>
                    <?php } ?>
                    <?php if (kando_user_can('show_order_provider_id')) { ?>
						<th><span class="nobr">شناسه سفارش در API</span></th>
						<th><span class="nobr">پاسخ API</span></th>
                    <?php } ?>
                    <th><span class="nobr"><?php _e("status", SAMYAR_TEXT_DOMAIN); ?></span></th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach ($orders as $order):
					if ($order->api_provider_id !== "0") {
						$provider = Provider::find($order->api_provider_id);
					}
					?>
                    <tr id="order-<?php echo esc_attr($order->id) ?>">
                        <td data-title="<?php _e("ID", SAMYAR_TEXT_DOMAIN); ?>">
							<?php echo esc_attr($order->id) ?>
                        </td>
                        <td data-title="<?php _e("Details", SAMYAR_TEXT_DOMAIN); ?>">
							<?php
							$service = Service::find($order->service_id);
							?>

                            <ul class="order-details">
								<?php if ($service): ?>
                                    <li>سرویس: <?php echo esc_attr($service->id) ?>&nbsp;-&nbsp;<?php echo esc_attr($service->name) ?></li>
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
                                <li>تعداد: <?php echo esc_attr($order->quantity) ?>
									<?php if($quantity_by_gift !== NULL && kando_user_can('show_order_provider_info')){ ?>
                                        <span style="color:#f58">(با هدیه:<?=$quantity_by_gift?>)</span>
									<?php } ?>
                                </li>
                                <li>مبلغ: <?php echo number_format_i18n(esc_attr((int)$order->charge)) ?> <?php kando_get_currency_base_text() ?></li>
                                <li>شروع شمارنده: <?php echo esc_attr($order->start_counter) ?> </li>
                                <li>باقی مانده: <?php echo esc_attr($order->remains) ?> </li>
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
                            </ul>

                        </td>
                        <td data-title="<?php _e("Creation date", SAMYAR_TEXT_DOMAIN); ?>">
		                    <?php
                            $date_format = get_option('date_format');
                            $time_format = get_option('time_format');
                            echo date_i18n($date_format.' '.$time_format, strtotime($order->created_at))
                            ?>
                        </td>
                        <td data-title="<?php _e("Update date", SAMYAR_TEXT_DOMAIN); ?>">
		                    <?php echo date_i18n($date_format.' '.$time_format, strtotime($order->update_at)) ?>
                        </td>

						<?php if (kando_user_can('show_order_user_info')) { ?>
                            <td data-title="اطلاعات کاربر">
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
                            <?php } ?>
                        <?php if (kando_user_can('show_order_provider_id')) { ?>
                            <td data-title="شناسه سفارش در API">
								<?php echo ($order->api_order_id == 0 || $order->api_order_id == -1) ? "" : $order->api_order_id ?>
                            </td>
                            <td data-title="پاسخ API">
								<?php echo esc_attr($order->note) ?>
                            </td>
						<?php } ?>
                        <td data-title="<?php _e("status", SAMYAR_TEXT_DOMAIN); ?>">
                            <span style="display: inline-block;" class="button order-status <?= samyar_status_color($order->status) ?>">
                                <?php echo samyar_order_status_title(esc_attr($order->status)); ?>
                            </span>
                        </td>
                    </tr>
				<?php
				endforeach; ?>
				</tbody>
			</table>
			<?php
			$total = Order::count(['main_order_id' => $main_id]);
			samyar_pagination($total, $limit, $paged)
			?>
		<?php
		else:
			?>
			<span class="orders-notfound"><?php _e("No part has been added yet.", SAMYAR_TEXT_DOMAIN); ?></span>
		<?php
		endif;
		?>
	</div>

</div>
