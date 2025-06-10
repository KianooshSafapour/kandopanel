<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Provider;
use samyar\Service;


$providers = Provider::where( ['order'=>'DESC','order_by'=>'id' ] );;



if($providers):
	?>
	<div class="kt-row">
		<div class="column kt-col-xs-12 kt-col-md-5 float-left">
			<div class="new-ticket-help">
				<img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
				<ul>
                    <li><?php _e("You can view and add new services from each provider in this section", SAMYAR_TEXT_DOMAIN); ?></li>
				</ul>
			</div>
		</div>
		<div class="column kt-col-xs-12 kt-col-md-7 float-left">
			<div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e("List of new services", SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e("Please select the desired provider and click on 'Get new services'", SAMYAR_TEXT_DOMAIN); ?></span>
				<form method="POST" class="samyar-form provider-new-service-list-form">
					<input type="hidden" name="action" value="samyar_new_service_list">
					<div class="new-api-provider-form-errors"></div>
					<div class="samyar-form-loading"></div>
					<div class="clearfix">
                        <label><?php _e("Please select the desired provider", SAMYAR_TEXT_DOMAIN); ?></label>
						<select name="provider_id">
							<?php foreach ($providers as $provider): ?>
								<option value="<?php echo esc_attr($provider->id)?>" <?php if(isset($_GET['id']) && $provider->id === $_GET['id']): ?>selected="selected"<?php endif; ?>><?php echo esc_attr($provider->name)?></option>
							<?php endforeach; ?>
						</select>
                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Get services', SAMYAR_TEXT_DOMAIN); ?>"/>
					</div>
				</form>
			</div>
		</div>

	</div>

    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12" id="provider-services-result"></div>
    </div>
<?php
endif;
