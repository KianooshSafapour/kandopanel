<div class="dashboard-posts-box dashboard-tickets-box" style="margin-top: 10px">
	<div class="dashboard-posts-title-holder">
		<h5 class="dashboard-posts-title"><?php echo $category_name ?></h5>
	</div>
	<div class="dashboard-posts-list">
		<?php

		if ( $services ):
			?>

			<table class="shop_table shop_table_responsive">
				<thead>
				<tr>
					<th><span class="nobr">شناسه</span></th>
					<th><span class="nobr">نام</span></th>
					<th><span class="nobr">توضیحات</span></th>
					<th><span class="nobr">قیمت</span></th>
					<th><span class="nobr">عملیات ها</span></th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach ( $services as $service ):
                    $cancel = $service['cancel']??0;
					?>
					<tr id="service-<?php echo esc_attr( $service['service'] ) ?>">
						<td data-title="شناسه">
							<?php echo esc_attr( $service['service'] ) ?>
						</td>
						<td data-title="نام">
							<?php echo esc_attr( $service['name'] ) ?>
						</td>
						<td data-title="توضیحات">
							<?php if ( isset($service['desc']) && $service['desc'] ): ?>
								<span class="kt-modal-button button button-default samyar-show-description-service-local" data-modal="show-description"
								      data-desc="<?php echo nl2br($service['desc']) ?>">توضیحات</span>

							<?php
							else:
								echo "-";
							endif; ?>
						</td>
						<td data-title="قیمت">
							<?php
                            if($provider->base_currency === "USD"){
//                                echo number_format_i18n( esc_attr( str_replace(array(',','،'), '', $service['rate'])  )) ?><!--&nbsp;--><?php //get_currency_text( $provider->base_currency );
//                             echo esc_attr( str_replace(array(',','،'), '', $service['rate'])  )?><!--&nbsp;--><?php //get_currency_text( $provider->base_currency );
                             echo esc_attr( str_replace(array('.'), '/', $service['rate'])  )?>&nbsp;<?php get_currency_text( $provider->base_currency );
                            }else{
                                echo number_format_i18n( esc_attr( str_replace(array(',','،'), '', $service['rate'])  ) ) ?>&nbsp;<?php get_currency_text( $provider->base_currency );
                            }

                            ?>
						</td>
						<td data-title="عملیات ها">
							<div class="header-phone-holder">
								<i class="kt-modal-buttonactive" data-modal="service"></i>
							</div>

							<span class="kt-modal-button button button-default btn-small add_service_from_list" data-modal="service" data-tooltip="افزودن"
							      data-provider="<?php echo esc_attr( $provider->id ) ?>"
							      data-service="<?php echo esc_attr( $service['service'] ) ?>"
                                  data-name="<?php echo esc_attr( $service['name'] ) ?>"
							      data-category="<?php echo esc_attr( $service['category'] ) ?>"
                                  data-rate="<?php echo esc_attr( str_replace(array(',','،'), '', $service['rate'])  ) ?>"
							      data-min="<?php echo esc_attr( $service['min'] ) ?>"
                                  data-max="<?php echo esc_attr( $service['max'] ) ?>"
							      data-type="<?php echo esc_attr( strtolower(str_replace(" ", "_", $service['type']))) ?>"
                                  data-desc="<?php if(isset($service['desc']) && $service['desc']){echo esc_attr( $service['desc'] );} ?>"
							      data-dripfeed="<?php echo esc_attr( $service['dripfeed'] ) ?>"
							      data-refill="<?php echo esc_attr( $service['refill'] ) ?>"
							      data-cancel="<?php echo esc_attr( $cancel ) ?>"
                                  data-currency="<?php get_currency_text( $provider->base_currency ) ?>"
                            ><i class="fal fa-plus"></i></span>

						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php
		else:
			?>
			<span class="services-notfound">سرویسی برای این دسته وجود ندارد</span>
		<?php
		endif;
		?>
	</div>
</div>