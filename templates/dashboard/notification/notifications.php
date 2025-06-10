<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Notification;

// * paginate
$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//شماره صفحه فعلی
$limit  = 10; //تعداد قابل نمایش
$offset = ( $limit * $paged ) - $limit;

$notifications = Notification::where( ['type' => ['operator' => 'IN', 'value' => ['notification', 'alert'],],'order'=>'DESC','order_by'=>'id', 'limit' => $limit, 'offset' => $offset ] );;
$title = "اطلاعیه ها";
if ( kando_user_can('show_notifications') ):
?>
<div class="woocommerce-MyAccount-content">
	<div class="woocommerce-notices-wrapper"></div>
	<div class="tickets-navigation">
<!--		<span class="button button-default">--><?php //echo $title ?><!--</span>-->
		<a href="<?php echo esc_attr( home_url( 'dashboard/?action=notifications&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal">ارسال اطلاعیه</a>
	</div>
	<div class="dashboard-posts-box dashboard-tickets-box">
		<div class="dashboard-posts-title-holder">
			<i class="elegant-icon icon_lightbulb_alt"></i>
			<h5 class="dashboard-posts-title">اطلاعیه ها</h5>
		</div>
		<div class="dashboard-posts-list">

			<?php if ( $notifications ): ?>
				<?php foreach ( $notifications as $notification ): ?>
					<a href="<?php echo esc_attr( home_url( 'dashboard/?action=notifications&section=edit&id='.$notification->id ) ) ?>" class="dashboard-post" data-wpel-link="internal" style="width: 90%;">
						<div class="dashboard-post-date">
							<span class="dashboard-post-date-day"><?php echo date_i18n('d',strtotime($notification->created_at)) ?></span>
							<span class="dashboard-post-date-month"><?php echo date_i18n('M Y',strtotime($notification->created_at)) ?></span>
                            <span class="button button-<?php if($notification->type==="notification" || $notification->type===""){echo'violet';}else{echo'red';} ?> badge-error-orders" style="margin-top: 4px;">
                                <?php if($notification->type==="notification" || $notification->type===""){echo'اطلاعیه';}else{echo'هشدار';} ?>
                            </span>
						</div>
						<div class="dashboard-post-inner">
							<div class="dashboard-post-title"><?php echo esc_attr($notification->title) ?></div>
							<?php
							switch ($notification->status){
								case 'pending':
									echo '<span class="dashboard-post-status dashboard-post-status-not-replied">منتشر نشده</span>';
									break;
								case 'publish':
									echo '<span class="dashboard-post-status dashboard-post-status-replied">منتشر شده</span>';
									break;
							}
							?>
						</div>
                        <span class="button button-aqua btn-small delete-notification" data-id="<?=$notification->id?>" data-tooltip="حذف"><i class="fal fa-trash"></i></span>
					</a>
				<?php endforeach; ?>
				<?php
				$total  = Notification::count( ['type' => ['operator' => 'IN', 'value' => ['notification', 'alert'],]] );
                samyar_pagination( $total,$limit, $paged )
				?>
			<?php else: ?>
				<span class="services-notfound">تاکنون اطلاعیه ای ارسال نشده است.</span>
			<?php endif; ?>
		</div>
		<a href="<?php echo esc_attr( home_url( 'dashboard/?action=notifications&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
	</div>
</div>
<?php
endif;