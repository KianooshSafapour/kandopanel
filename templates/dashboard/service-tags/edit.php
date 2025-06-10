<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\serviceTag;
use samyar\Social;

$tag_id = $_GET['id'];
$tag = serviceTag::find($tag_id);
if ($tag):
    ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-5 float-left">
            <div class="new-ticket-help">
                <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                <ul>
                    <li><?php _e("You can read the tips related to this section here", SAMYAR_TEXT_DOMAIN); ?></li>
                    <li><?php _e("To use icons for Iranian social networks, use the following icon fonts:", SAMYAR_TEXT_DOMAIN); ?></li>
                    <li>knd icon-gap</li>
                    <li>knd icon-eitaa</li>
                    <li>knd icon-rubika</li>
                    <li>knd icon-soroush</li>
                    <li>knd icon-aparat</li>
                    <li>knd icon-bale</li>
                    <li>knd icon-x</li>
                    <li>knd icon-threads</li>
                </ul>
            </div>
        </div>
        <div class="column kt-col-xs-12 kt-col-md-7 float-left">
            <div class="new-api-form-outer">
                <h4 class="new-ticket-title"><?php _e("Edit Category", SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e("Enter the information and click on update", SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" class="samyar-form new-tag-form">
                    <input type="hidden" name="action" value="samyar_tag_edit">
                    <input type="hidden" name="id" value="<?php echo esc_attr($tag->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <input type="text" name="name" value="<?php echo esc_attr($tag->name) ?>" placeholder="<?php _e("Name", SAMYAR_TEXT_DOMAIN); ?>"/>
                        <label><?php _e("Icon", SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="text" name="icon" dir="ltr" value="<?php echo esc_attr($tag->icon) ?>" placeholder="<?php _e("ex: fab fa-instagram or knd icon-aparat", SAMYAR_TEXT_DOMAIN); ?>"/>
                        <div class="kt-col-xs-12">
                            <div class="kt-wc-coupon-box"><a href="https://fontawesome.com/v5/search"><?php _e("Icon List", SAMYAR_TEXT_DOMAIN); ?></a></div>
                        </div>
                        <select name="background_color" id="background_color">
                            <option value="0"><?php _e("Please select background color", SAMYAR_TEXT_DOMAIN); ?></option>
                            <?php foreach (service_tags_color() as $key => $color): ?>
                                <option <?php if (esc_attr($tag->background_color) == $key) echo 'selected' ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_attr($color['name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="status">
                            <option <?php if (esc_attr($tag->status) == 1) echo 'selected' ?> value="1"><?php _e("Active", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if (esc_attr($tag->status) == 0) echo 'selected' ?> value="0"><?php _e("Inactive", SAMYAR_TEXT_DOMAIN); ?></option>
                        </select>

                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e("Update", SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
else:
    echo '<p>' . __('Tag not found.', SAMYAR_TEXT_DOMAIN) . '</p>';
endif;