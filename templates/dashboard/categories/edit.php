<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Category;
use samyar\Social;

$category_id = $_GET['id'];
$category = Category::find($category_id);
$socials = Social::where(['order' => 'ASC', 'order_by' => 'sort']);
if ($category):
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
                <h4 class="new-ticket-title"><?php _e('Edit Category', SAMYAR_TEXT_DOMAIN); ?></h4>
                <span class="new-ticket-text"><?php _e('Enter the information and click on update', SAMYAR_TEXT_DOMAIN); ?></span>
                <form method="POST" class="samyar-form new-category-form">
                    <input type="hidden" name="action" value="samyar_category_edit">
                    <input type="hidden" name="id" value="<?php echo esc_attr($category->id) ?>">
                    <div class="new-api-provider-form-errors"></div>
                    <div class="samyar-form-loading"></div>
                    <div class="clearfix">
                        <input type="text" name="name" value="<?php echo esc_attr($category->name) ?>"
                               placeholder="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="text" name="icon" dir="ltr" value="<?php echo esc_attr($category->icon) ?>" placeholder="<?php _e('ex: fab fa-instagram or knd icon-aparat', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <input type="text" name="sort" value="<?php echo esc_attr($category->sort) ?>"
                               placeholder="<?php _e('Sort Order', SAMYAR_TEXT_DOMAIN); ?>"/>
                        <select name="social_id" id="samyar_select_social">
                            <option value="0"><?php _e('Please select the related brand for this category', SAMYAR_TEXT_DOMAIN); ?></option>
                            <?php foreach ($socials as $social): ?>
                                <option value="<?php echo esc_attr($social->id) ?>"
                                        <?php if ($category->social_id === $social->id): ?>selected<?php endif; ?>><?php echo esc_attr($social->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="status">
                            <option <?php if (esc_attr($category->status) == 1) echo 'selected' ?> value="1"><?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                            </option>
                            <option <?php if (esc_attr($category->status) == 0) echo 'selected' ?> value="0"><?php _e('Inactive', SAMYAR_TEXT_DOMAIN); ?>
                            </option>
                        </select>
                        <label><?php _e('Service Link Type (Optional)', SAMYAR_TEXT_DOMAIN); ?></label>
                        <input type="radio" value="default" id="default" name="link-type" <?php checked( $category->link_type,"default" ); ?>>
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
                                    <input type="radio" value="<?= $k ?>" id="<?= $k ?>" <?php checked( $category->link_type,$k ); ?> name="link-type">
                                    <label class="link-type" for="<?= $k ?>"><?= $t ?></label>
                                    <?php
                                }
                                ?>
                            </fieldset>
                            <?php
                        }
                        ?>

                        <label><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></label>
                        <?php wp_editor($category->description, 'description', array(
                            'media_buttons' => false,
                            'drag_drop_upload' => false
                        )); ?>


                        <input type="submit" class="button button-green new-ticket-form-submit" value="<?php _e('Update', SAMYAR_TEXT_DOMAIN); ?>"/>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php
else:

endif;