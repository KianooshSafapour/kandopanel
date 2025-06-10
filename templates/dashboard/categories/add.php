<?php

use samyar\Social;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$socials = Social::where( ['order'=>'ASC','order_by'=>'sort' ] );
?>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-5 float-left">
        <div class="new-ticket-help">
            <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
            <ul>
                <li><?php _e('To use icons for Iranian social networks, use the following font icons:', SAMYAR_TEXT_DOMAIN); ?></li>
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
            <h4 class="new-ticket-title"><?php _e('Add New Category', SAMYAR_TEXT_DOMAIN); ?></h4>
            <span class="new-ticket-text"><?php _e('Enter the information and click on add', SAMYAR_TEXT_DOMAIN); ?></span>
            <form method="POST" class="samyar-form new-category-form">
                <input type="hidden" name="action" value="samyar_category_add">
                <div class="new-api-provider-form-errors"></div>
                <div class="samyar-form-loading"></div>
                <div class="clearfix">
                    <input type="text" name="name" placeholder="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <input type="text" name="icon" dir="ltr" placeholder="<?php _e('ex: fab fa-instagram or knd icon-aparat', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <input type="text" name="sort" placeholder="<?php _e('Sort Order', SAMYAR_TEXT_DOMAIN); ?>"/>
                    <select name="social_id" id="samyar_select_social">
                        <option value="0"><?php _e('Please select the related brand for this category', SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php foreach ($socials as $social): ?>
                            <option value="<?php echo esc_attr($social->id) ?>"><?php echo esc_attr($social->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label><?php _e('Service Link Type for This Category (Optional)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="radio" value="default" id="default" name="link-type" checked>
                    <label class="link-type" style="margin: 10px 12px;" for="default"><?php _e('Default', SAMYAR_TEXT_DOMAIN); ?></label>

                    <a href="#" class="button button-green show-other-types">
                        <?php _e('View Other Types', SAMYAR_TEXT_DOMAIN); ?>
                        <i class="fal fa-chevron-down"></i>
                    </a>
                    <?php

                    $types = get_link_types();

                    foreach ($types as $brand => $data) {
                        ?>
                        <fieldset class="link-type-fieldset">
                            <legend><?=kando_persian_text($brand)?></legend>
                            <?php
                            $checked="";
                            foreach ($data as $k => $t) {
                                ?>
                                <input type="radio" value="<?= $k ?>" id="<?= $k ?>" name="link-type">
                                <label class="link-type" for="<?= $k ?>"><?= $t ?></label>
                                <?php
                            }
                            ?>
                        </fieldset>
                        <?php
                    }
                    ?>
                    <label><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></label>
                    <?php wp_editor('','description', array(
                        'media_buttons'	   => false,
                        'drag_drop_upload' => false
                    )); ?>
                    <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Submit', SAMYAR_TEXT_DOMAIN); ?>"/>
                </div>
            </form>
        </div>
    </div>

</div>