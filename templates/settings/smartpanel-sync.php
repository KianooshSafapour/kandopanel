<?php
defined( 'ABSPATH' ) || exit( 'No Access!' );
use samyar\smartPanelApi;


$lists     = array();
$api       = new smartPanelApi();
$connected = false;
//if ( $connected ) {
$balance = $api->balance();

if ( is_null( $balance ) || isset( $balance->error ) ) {
	$connected = false;
} else {
	$connected = true;
}
//print_r($balance);

//}

?>
<div class="samyar-settings-area samyar-settings-spsync">

	<h3 class="samyar-settings-title">
		<span class="samyar-title-icon"><span uk-icon="refresh"></span></span>
		<strong><?php _e( 'API', SAMYAR_TEXT_DOMAIN ); ?></strong>
	</h3>
    <div class="uk-margin">
        <div class="uk-alert-primary" uk-alert>
            <p style="margin-top: 0">
                <b>ویدیو آموزشی مربوط به همگامسازی اطلاعات اسمارت پنل و قالب کندو پنل را از لینک زیر تماشا کنید:</b><br><br>
                <a href="https://www.aparat.com/v/zyDnx?playlist=36127006" target="_blank">ویدیو آموزشی همگامسازی اطلاعات اسمارت پنل و قالب کندو</a>
                <br>
            </p>
        </div>
    </div>
	<div class="uk-margin">

		<div class="uk-margin">
			<table class="form-table">

				<tr valign="top">
					<th scope="row">
						<?php echo esc_html__( 'Status:', SAMYAR_TEXT_DOMAIN ); ?>
					</th>
					<td>
						<?php
						//						$connected = true;
						if ( $connected ) {
							?>
							<span class="status positive"><?php echo esc_html__( 'CONNECTED', SAMYAR_TEXT_DOMAIN ); ?></span>
							<?php
						} else {
							?>
							<span class="status neutral"><?php echo esc_html__( 'NOT CONNECTED', SAMYAR_TEXT_DOMAIN ); ?></span>
							<?php if ( ! empty( $message ) ) { ?>
								<div class="uk-alert-danger" uk-alert>
									<a class="uk-alert-close" uk-close></a>
									<p><?php echo $message ?></p>
								</div>
							<?php } ?>
							<?php
						}
						?>
					</td>
					<?php if ( $connected ) { ?>
						<th scope="row">
							<?php echo esc_html__( 'credit:', SAMYAR_TEXT_DOMAIN ); ?>
						</th>
						<td><?php echo $balance->balance ?></td>
					<?php } ?>
				</tr>
			</table>
			<div class="uk-alert-primary" uk-alert>
				<a class="uk-alert-close" uk-close></a>
				<p><?php _e( 'note: after add API Key refresh page for connect status', SAMYAR_TEXT_DOMAIN ); ?></p>
			</div>
			<div class="uk-margin-small">
				<input type="text" dir="ltr" class="uk-input" name="api-url" value="<?php echo esc_attr( $options->get_option( 'api-url' ) ); ?>"
				       placeholder="<?php _e( 'API url', SAMYAR_TEXT_DOMAIN ); ?>">
			</div>
			<div class="uk-margin-small">
				<input type="text" dir="ltr" class="uk-input" name="api-key" value="<?php echo esc_attr( $options->get_option( 'api-key' ) ); ?>"
				       placeholder="<?php _e( 'API Key', SAMYAR_TEXT_DOMAIN ); ?>">
			</div>
            <div class="uk-alert-primary" uk-alert>
                <p><b>توجه:</b> در نظر داشته باشید که به علت تفاوت در رمزنگاری دو سیستم، رمز های کاربران منتقل نمی شوند و کاربران منتقل شده باید بازیابی رمز عبور را زده و رمز جدید برای خودشون تنظیم نمایند. </p>
            </div>
			<?php
			//						$connected = true;
			if ( $connected ) {
			?>
			<div class="samyar-description">
				<a class="samyar-save uk-button uk-button-danger" id="smartpanel-sync-users" style="color:#fff !important">
                    <span uk-icon="users" style="color:#fff !important;float:right;margin-top: 8px;margin-left: 10px;"></span>
					<?php _e( 'start sync users', SAMYAR_TEXT_DOMAIN ); ?>
                    <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg" style="position: relative;left: -10px;top: 7px;" width="26" height="26" alt="loader">
				</a>
                <a class="samyar-save uk-button uk-button-danger" id="smartpanel-sync-services" style="color:#fff !important">
                    <span uk-icon="list" style="color:#fff !important;float:right;margin-top: 8px;margin-left: 10px;"></span>
					<?php _e( 'start sync services', SAMYAR_TEXT_DOMAIN ); ?>
                    <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg" style="position: relative;left: -10px;top: 7px;" width="26" height="26" alt="loader">
                </a>
			</div>
			<?php
			}
			?>
            <div class="uk-margin-small" id="user_sync_stat" style="display: none">

            </div>

            <div class="uk-alert-danger" id="user_sync_errors" style="display: none" uk-alert>
            </div>
		</div>


	</div>

</div>