<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
use samyar\Social;
?>
<div class="tickets-navigation">
<!--	<span class="button button-default">دسته ها</span>-->
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=social&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal">افزودن برند</a>
</div>
<div class="dashboard-posts-box dashboard-tickets-box">
	<div class="dashboard-posts-title-holder">
        <i class="fas fa-copyright"></i>
		<h5 class="dashboard-posts-title">برندها</h5>
	</div>
	<div class="dashboard-posts-list">
		<?php
		// * paginate
		$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//شماره صفحه فعلی
		$limit  = 20; //تعداد قابل نمایش
		$offset = ( $limit * $paged ) - $limit;

		$socials = Social::where( ['order'=>'ASC','order_by'=>'sort', 'limit' => $limit, 'offset' => $offset ] );
		if ($socials):
			?>

			<table class="shop_table shop_table_responsive">
				<thead>
				<tr>
					<th><span class="nobr">شناسه</span></th>
					<th><span class="nobr">نام</span></th>
					<th><span class="nobr">آیکون</span></th>
					<th><span class="nobr">مرتب سازی</span></th>
<!--					<th><span class="nobr">تعداد سرویس ها</span></th>-->
					<th><span class="nobr">وضعیت</span></th>
					<th><span class="nobr">عملیات ها</span></th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach ( $socials as $social ):
					?>
					<tr id="social-<?php echo esc_attr($social->id) ?>">
						<td data-title="شناسه">
							<?php echo esc_attr($social->id) ?>
						</td>
						<td data-title="نام">
							<?php echo esc_attr($social->name) ?>
						</td>
                        <td data-title="آیکون">
                            <i class="<?php echo esc_attr($social->icon) ?>"></i>
                        </td>
                        <td data-title="مرتب سازی">
							<?php echo esc_attr($social->sort) ?>
                        </td>
						<td data-title="وضعیت">
                            <label class="custom-switch">
                                <input type="checkbox" name="disable-social" data-type="social" data-id="<?php echo esc_attr($social->id) ?>" class="ajax-switch custom-switch-input" data-toggle="collapse" aria-expanded="false" <?php echo checked($social->status, 1); ?>>
                                <span class="custom-switch-indicator"></span>
                            </label>
						</td>
						<td data-title="عملیات ها">
							<a href="<?php echo esc_attr(home_url('dashboard/?action=social&section=edit&id='. esc_attr($social->id) )) ?>"><span class="button button-default btn-small" data-tooltip="ویرایش"><i class="fal fa-edit"></i></span></a>
                            <span class="button button-aqua btn-small delete-social" data-id="<?php echo esc_attr($social->id) ?>" data-tooltip="حذف"><i class="fal fa-trash"></i></span>
							<!--                        <a href=""><span class="button button-red btn-small">ویرایش</span></a>-->
							<!--                        <a href=""><span class="button button-aqua btn-small">ویرایش</span></a>-->
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php
			$total = Social::count();
			samyar_pagination( $total,$limit, $paged )
			?>
		<?php
		else:
			?>
			<span class="services-notfound">تاکنون برندی اضافه نشده است.</span>
		<?php
		endif;
		?>
	</div>
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=social&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>
