<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\Provider;
use samyar\Service;
use samyar\serviceController;

$title = __("Subscription orders", SAMYAR_TEXT_DOMAIN);
$stranslates = \samyar\serviceController::getInstance()->get_translates();
?>


<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_lifesaver"></i>
        <h5 class="dashboard-posts-title"><?php _e("Subscription orders", SAMYAR_TEXT_DOMAIN); ?></h5>
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
                    <th><span class="nobr"><?php _e("Status", SAMYAR_TEXT_DOMAIN); ?></span></th>
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
                                    <li><?php _e("Service:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr($service->id) ?>&nbsp;-&nbsp;<?php echo esc_attr(serviceController::getInstance()->get_title($stranslates,$service)) ?></li>
								<?php endif; ?>

                                <li><?php _e("Username:", SAMYAR_TEXT_DOMAIN); ?> <?php echo esc_attr( $order->username ) ?></li>
                                <li><?php _e("Quantity:", SAMYAR_TEXT_DOMAIN); ?> <?= $order->sub_min ?>/<?= $order->sub_max ?></li>
                                    <?php
                                    $real_posts = 0;
                                    if (!empty($item['sub_response_posts'])) {
	                                    $link_detail = "";
	                                    $real_posts = sprintf('<strong><a href="%s">%s</a></strong>', $link_detail, $item['sub_response_posts']);
                                    }
                                    $posts = sprintf('%s / %s', $real_posts, $item['sub_posts']);
                                    ?>
                                <li><?php _e("Posts:", SAMYAR_TEXT_DOMAIN); ?> <?= $posts ?></li>

                                    <?php
                                    $delay = ((int)$order->sub_delay > 0) ? $order->sub_delay . ' minutes' : __('No delay',SAMYAR_TEXT_DOMAIN);
                                    ?>
                                <li><?php _e("Delay:", SAMYAR_TEXT_DOMAIN); ?> <?= $delay ?> </li>

                                <?php
                                $expiry = "";


                                if (!empty($order->sub_expiry) && strtotime($order->sub_expiry) != "") {
	                                $database_date = $order->sub_expiry;

	                                // تایم‌زون مورد نظر (مثلاً 'Asia/Tehran')
	                                $target_timezone = 'Asia/Tehran';

	                                // تبدیل تاریخ به تایم‌زون مورد نظر
	                                $expiry = date_i18n( 'Y-m-d H:i:s', strtotime( $database_date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ), false, true, $target_timezone );
	                                $expiry = date( "Y-m-d", strtotime( $expiry ) );
                                }
                                ?>
                                <li><?php _e("Expiration:", SAMYAR_TEXT_DOMAIN); ?> <?= $expiry ?> </li>

                            </ul>

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

                        <td data-title="<?php _e("Status", SAMYAR_TEXT_DOMAIN); ?>">
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
