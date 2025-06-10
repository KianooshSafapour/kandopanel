<?php
defined('ABSPATH') || exit('No Access!');

$sms_provider = kando_get_option('sms-provider');
?>
<div class="samyar-settings-area samyar-settings-packages">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="credit-card"></span></span>
        <strong><?php _e('Packages and Profits', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e('General', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Representation Settings', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('Representation Packages', SAMYAR_TEXT_DOMAIN); ?></a></li>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-0"><?php _e('Enter the profit percentage for regular users (numbers only)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-danger uk-alert" uk-alert="">
                        <div class="kt-wc-coupon-box"><a target="_blank" href="<?=home_url('wp-admin/admin.php?page=kandopanel-price-convertor')?>"><?php _e('Click here to change', SAMYAR_TEXT_DOMAIN); ?></a></div>
                    </div>
                    <!--
                    <input type="number" class="uk-input" id="representation-level-0" name="representation-level-0"
                           value="<?php echo esc_attr(kando_get_option('representation-level-0', 0)); ?>">
                           -->
                </div>

            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Enable Representation', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="representation-active"
                                   value="1" <?php echo checked(kando_get_option('representation-active', 0), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>
                    <div class="samyar-description">
                        <span><?php _e('If not enabled, the regular user profit rate will be calculated for all users.', SAMYAR_TEXT_DOMAIN); ?></span>
                    </div>
                </div>

                <div class="uk-alert-danger uk-alert" uk-alert="">
                    <p>
                        <?php
                        _e('This section is active for users who are using Kandopanel version 28 or earlier (to prevent changes to old rates) and has no effect in version 29 and later.', SAMYAR_TEXT_DOMAIN);
                        ?><br>
                        <?php
                        printf(
                            __('For representative rate changes in version 29 and later, please refer to %s.', SAMYAR_TEXT_DOMAIN),
                            '<a href="' . home_url('wp-admin/admin.php?page=kandopanel-price-convertor') . '">' . __('this section', SAMYAR_TEXT_DOMAIN) . '</a>'
                        );
                        ?>
                    </p>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-1"><?php _e('Enter the profit percentage for <b style="color:#FFD700;background-color: #7D6C12;border-radius: 3px;padding: 0px 10px;">Gold</b> representation (numbers only)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-danger uk-alert" uk-alert="">
                        <div class="kt-wc-coupon-box"><a target="_blank" href="<?=home_url('wp-admin/admin.php?page=kandopanel-price-convertor')?>"><?php _e('Click here to change', SAMYAR_TEXT_DOMAIN); ?></a></div>
                    </div>

                                        <input type="number" class="uk-input" id="representation-level-1" name="representation-level-1" value="<?php echo esc_attr(kando_get_option('representation-level-1', 0)); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-2"><?php _e('Enter the profit percentage for <b style="color:#C0C0C0;background-color: #6C5151;border-radius: 3px;padding: 0px 10px;">Silver</b> representation (numbers only)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-danger uk-alert" uk-alert="">
                        <div class="kt-wc-coupon-box"><a target="_blank" href="<?=home_url('wp-admin/admin.php?page=kandopanel-price-convertor')?>"><?php _e('Click here to change', SAMYAR_TEXT_DOMAIN); ?></a></div>
                    </div>
                                        <input type="number" class="uk-input" id="representation-level-2" name="representation-level-2" value="<?php echo esc_attr(kando_get_option('representation-level-2', 0)); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-3"><?php _e('Enter the profit percentage for <b style="color:#CD7F32;background-color: #5D350D;border-radius: 3px;padding: 0px 10px;">Bronze</b> representation (numbers only)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-alert-danger uk-alert" uk-alert="">
                        <div class="kt-wc-coupon-box"><a target="_blank" href="<?=home_url('wp-admin/admin.php?page=kandopanel-price-convertor')?>"><?php _e('Click here to change', SAMYAR_TEXT_DOMAIN); ?></a></div>
                    </div>
                                        <input type="number" class="uk-input" id="representation-level-3" name="representation-level-3" value="<?php echo esc_attr(kando_get_option('representation-level-3', 0)); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Enable displaying representation prices in the services list', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="show-price-representation"
                                   value="1" <?php echo checked(kando_get_option('show-price-representation'), 1); ?>><?php _e('Enable', SAMYAR_TEXT_DOMAIN); ?></label>
                    </div>

                </div>
                <?php
                $show_price_representation_type = kando_get_option('show-price-representation-type', 1);
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Price display type', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="show-price-representation-type">

                            <option <?php if ($show_price_representation_type == 1): ?> selected <?php endif; ?> value="1"><?php _e('Icon + Popup', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option <?php if ($show_price_representation_type == 2): ?> selected <?php endif; ?> value="2"><?php _e('Table', SAMYAR_TEXT_DOMAIN); ?></option>

                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>


            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">

                    <div class="uk-margin">
                        <?php
                        $representations_attr = kando_get_option('representations');
                        $representations_attr = is_array($representations_attr) ? $representations_attr : [];

                        $representations = [
                            '1' => [
                                'amount' => $representations_attr[1]['amount'] ?? null,
                                'sub_amount' => $representations_attr[1]['sub_amount'] ?? null,
                                'description' => $representations_attr[1]['description'] ?? null,
                                'period' => $representations_attr[1]['period'] ?? null,
                                'color' => $representations_attr[1]['color'] ?? "violet",
                            ],
                            '2' => [
                                'amount' => $representations_attr[2]['amount'] ?? null,
                                'sub_amount' => $representations_attr[2]['sub_amount'] ?? null,
                                'description' => $representations_attr[2]['description'] ?? null,
                                'period' => $representations_attr[2]['period'] ?? null,
                                'color' => $representations_attr[2]['color'] ?? "violet",
                            ],
                            '3' => [
                                'amount' => $representations_attr[3]['amount'] ?? null,
                                'sub_amount' => $representations_attr[3]['sub_amount'] ?? null,
                                'description' => $representations_attr[3]['description'] ?? null,
                                'period' => $representations_attr[3]['period'] ?? null,
                                'color' => $representations_attr[3]['color'] ?? "violet",
                            ],
                        ];
                        ?>
                        <?php if (count($representations)): ?>
                            <?php foreach ($representations as $key => $item): ?>
                                <?php
                                switch ($key) {
                                    case 1:
                                        $title = __("Gold Representation", SAMYAR_TEXT_DOMAIN);
                                        break;
                                    case 2:
                                        $title = __("Silver Representation", SAMYAR_TEXT_DOMAIN);
                                        break;
                                    case 3:
                                        $title = __("Bronze Representation", SAMYAR_TEXT_DOMAIN);
                                        break;
                                }
                                $amount = $item['amount'] ?? null;
                                $sub_amount = $item['sub_amount'] ?? null;
                                $description = $item['description'] ?? null;
                                $period = $item['period'] ?? null;
                                $color = $item['color'] ?? null;
                                ?>
                                <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="margin: 15px 0;">
                                    <h3 style="text-align: center;"><?= $title ?></h3>
                                    <div class="samyar-social-network-item samyar-item uk-margin">

                                        <div class="uk-margin-small">
                                            <label class="uk-form-label"><?php _e('Price', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <input type="text" class="uk-input" name="representations[<?php echo $key; ?>][amount]" value="<?= $amount ?>"
                                                   placeholder="<?php _e('Price', SAMYAR_TEXT_DOMAIN); ?>">
                                        </div>
                                        <!--
                                <div class="uk-margin-small">
                                    <label class="uk-form-label"><?php _e('Sub Price Title (optional)', SAMYAR_TEXT_DOMAIN); ?></label>
                                    <input type="text" class="uk-input" name="representations[<?php echo $key; ?>][sub_amount]" value="<?= $sub_amount ?>"
                                           placeholder="<?php _e('Sub Price Title', SAMYAR_TEXT_DOMAIN); ?>">
                                </div>
                                -->
                                        <div class="uk-margin-small"><label class="uk-form-label"><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <?php
                                            wp_editor($description, 'description_' . $key, array(
                                                'media_buttons' => false,
                                                'drag_drop_upload' => false,
                                                'textarea_name' => 'representations[' . $key . '][description]'
                                            )); ?>
                                        </div>

                                        <div class="uk-margin-small"><label class="uk-form-label"><?php _e('Representation Period', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <div uk-form-custom="target: > * > span:first-child"><select name="representations[<?php echo $key; ?>][period]">
                                                    <option value="1" <?php if ($period === "1"): ?> selected <?php endif; ?>><?php _e('1 Month', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="2" <?php if ($period === "2"): ?> selected <?php endif; ?>><?php _e('2 Months', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="3" <?php if ($period === "3"): ?> selected <?php endif; ?>><?php _e('3 Months', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="6" <?php if ($period === "6"): ?> selected <?php endif; ?>><?php _e('6 Months', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="12" <?php if ($period === "12"): ?> selected <?php endif; ?>><?php _e('12 Months', SAMYAR_TEXT_DOMAIN); ?></option>
                                                </select>
                                                <button class="uk-button uk-button-default" type="button" tabindex="-1"><span></span><span uk-icon="icon: chevron-down"></span></button>
                                            </div>
                                        </div>

                                        <div class="uk-margin-small"><label class="uk-form-label"><?php _e('Color', SAMYAR_TEXT_DOMAIN); ?></label>
                                            <div uk-form-custom="target: > * > span:first-child"><select name="representations[<?php echo $key; ?>][color]" class="kando-wheel-color">
                                                    <option value="violet" <?php if ($color === "violet"): ?> selected <?php endif; ?>><?php _e('Purple', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="green" <?php if ($color === "green"): ?> selected <?php endif; ?>><?php _e('Green', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="blue" <?php if ($color === "blue"): ?> selected <?php endif; ?>><?php _e('Blue', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="red" <?php if ($color === "red"): ?> selected <?php endif; ?>><?php _e('Red', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="orange" <?php if ($color === "orange"): ?> selected <?php endif; ?>><?php _e('Orange', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="gray" <?php if ($color === "gray"): ?> selected <?php endif; ?>><?php _e('Gray', SAMYAR_TEXT_DOMAIN); ?></option>
                                                    <option value="default" <?php if ($color === "default"): ?> selected <?php endif; ?>><?php _e('Pink', SAMYAR_TEXT_DOMAIN); ?></option>
                                                </select>
                                                <button class="uk-button uk-button-default" type="button" tabindex="-1"><span></span><span uk-icon="icon: chevron-down"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </li>
</div>