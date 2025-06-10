<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
use samyar\Category;
?>
<div class="tickets-navigation">
<!--	<span class="button button-default">دسته ها</span>-->
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=categories&section=new' ) ) ?>" class="button button-light" data-wpel-link="internal">افزودن دسته</a>
</div>
<div class="dashboard-posts-box dashboard-tickets-box">
	<div class="dashboard-posts-title-holder">
		<i class="elegant-icon icon_folder-alt"></i>
		<h5 class="dashboard-posts-title">دسته های خدمات</h5>
	</div>
	<div class="dashboard-posts-list">
		<?php
		// * paginate
        $categoryController = \samyar\categoryController::getInstance();
		$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;//شماره صفحه فعلی
		$limit  = 20; //تعداد قابل نمایش
		$offset = ( $limit * $paged ) - $limit;

		$categories = Category::where( ['order'=>'ASC','order_by'=>'sort', 'limit' => $limit, 'offset' => $offset ] );;
		if ($categories):
			?>

			<table class="shop_table shop_table_responsive">
				<thead>
				<tr>
					<th><span class="nobr">شناسه</span></th>
					<th><span class="nobr">نام</span></th>
					<th><span class="nobr">مرتب سازی</span></th>
					<th><span class="nobr">تعداد سرویس ها</span></th>
					<th><span class="nobr">برند</span></th>
					<th><span class="nobr">توضیحات</span></th>
					<th><span class="nobr">وضعیت</span></th>
					<th><span class="nobr">عملیات ها</span></th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach ( $categories as $category ):
					?>
					<tr id="category-<?php echo esc_attr($category->id) ?>">
						<td data-title="شناسه">
							<?php echo esc_attr($category->id) ?>
						</td>
						<td data-title="نام">
                            <?php
                            if($category->icon):
                                echo '<i class="'.$category->icon.'"></i>&nbsp;';
                            endif;
                            ?>
                            <?php echo esc_attr($category->name) ?>
						</td>
                        <td data-title="مرتب سازی">
							<?php echo esc_attr($category->sort) ?>
                        </td>
                        <td data-title="تعداد سرویس ها">
                            <?php echo esc_attr($categoryController->count_services_in_category($category->id)) ?>
                        </td>
                        <td data-title="برند">
                            <?php if(!is_null($category->social_id)):
                             $social = \samyar\Social::find($category->social_id);
                             if($social):
                                 echo '<i class="'.$social->icon.'"></i>&nbsp;';
                                echo $social->name;
                             endif;
                           endif; ?>
                        </td>
						<td data-title="توضیحات">
							<?php
                            if($category->description){
                                echo html_entity_decode( $category->description, ENT_QUOTES );
                            }
                            ?>
						</td>
						<td data-title="وضعیت">
                            <label class="custom-switch">
                                <input type="checkbox" name="disable-category" data-type="category" data-id="<?php echo esc_attr($category->id) ?>" class="ajax-switch custom-switch-input" data-toggle="collapse" aria-expanded="false" <?php echo checked($category->status, 1); ?>>
                                <span class="custom-switch-indicator"></span>
                            </label>
						</td>
						<td data-title="عملیات ها">
							<a href="<?php echo esc_attr(home_url('dashboard/?action=categories&section=edit&id='. esc_attr($category->id) )) ?>"><span class="button button-default btn-small" data-tooltip="ویرایش"><i class="fal fa-edit"></i></span></a>
                            <span class="button button-aqua btn-small delete-category" data-id="<?php echo esc_attr($category->id) ?>" data-tooltip="حذف"><i class="fal fa-trash"></i></span>
							<!--                        <a href=""><span class="button button-red btn-small">ویرایش</span></a>-->
							<!--                        <a href=""><span class="button button-aqua btn-small">ویرایش</span></a>-->
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php
			$total = Category::count();
			samyar_pagination( $total,$limit, $paged )
			?>
		<?php
		else:
			?>
			<span class="services-notfound">تاکنون دسته ای اضافه نشده است.</span>
		<?php
		endif;
		?>
	</div>
	<a href="<?php echo esc_attr( home_url( 'dashboard/?action=categories&section=new' ) ) ?>" class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>
