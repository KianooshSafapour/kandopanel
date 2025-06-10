<?php
defined('ABSPATH') || exit('No Access!');

$sms_provider = $options->get_option('sms-provider');
?>
<div class="samyar-settings-area samyar-settings-representation">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="credit-card"></span></span>
        <strong><?php _e('representation and profits', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <ul uk-tab>
        <li class="uk-active"><a href="#"><?php _e('general', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('representation settings', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('representation packages', SAMYAR_TEXT_DOMAIN); ?></a></li>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-0">میزان سود برای کاربر عادی را به درصد وارد کنید(تنها عدد)</label>
                    <input type="number" class="uk-input" id="representation-level-0" name="representation-level-0"
                           value="<?php echo esc_attr($options->get_option('representation-level-0', 0)); ?>">
                </div>

            </div>
        </li>
        <li>
            <div class="uk-margin">
                <div class="uk-margin">
                    <label class="uk-form-label">فعالسازی نمایندگی</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="representation-active"
                                   value="1" <?php echo checked($options->get_option('representation-active', 0), 1); ?>>فعال</label>
                    </div>
                    <div class="samyar-description">
                        <span>اگر فعال نکنید، برای همه کاربران، نرخ سود کاربر عادی، محاسبه خواهد شد.</span>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-1">میزان سود برای نمایندگی <b style="color:#FFD700;background-color: #7D6C12;border-radius: 3px;padding: 0px 10px;">طلایی</b>
                        را به
                        درصد وارد کنید(تنها عدد)</label>
                    <input type="number" class="uk-input" id="representation-level-1" name="representation-level-1" value="<?php echo esc_attr($options->get_option('representation-level-1', 0)); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-2">میزان سود برای نمایندگی <b style="color:#C0C0C0;background-color: #6C5151;border-radius: 3px;padding: 0px 10px;">نقره
                            ای</b> را به
                        درصد وارد کنید(تنها عدد)</label>
                    <input type="number" class="uk-input" id="representation-level-2" name="representation-level-2" value="<?php echo esc_attr($options->get_option('representation-level-2', 0)); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="representation-level-3">میزان سود برای نمایندگی <b style="color:#CD7F32;background-color: #5D350D;border-radius: 3px;padding: 0px 10px;">برنزی</b>
                        را
                        به درصد وارد کنید(تنها عدد)</label>
                    <input type="number" class="uk-input" id="representation-level-3" name="representation-level-3" value="<?php echo esc_attr($options->get_option('representation-level-3', 0)); ?>">
                </div>
                <hr>
                <div class="uk-margin">
                    <label class="uk-form-label">فعالسازی نمایش قیمت نمایندگی ها در لیست سرویس ها</label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="show-price-representation"
                                   value="1" <?php echo checked($options->get_option('show-price-representation'), 1); ?>>فعال</label>
                    </div>

                </div>
                <?php
                $show_price_representation_type = $options->get_option('show-price-representation-type', 1);
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label">نوع نمایش قیمت</label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="show-price-representation-type">

                            <option <?php if ($show_price_representation_type == 1): ?> selected <?php endif; ?> value="1">آیکون+پاپ آپ</option>
                            <option <?php if ($show_price_representation_type == 2): ?> selected <?php endif; ?> value="2">جدول</option>

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
                        $representations_attr = $options->get_option('representations');
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
                                        $title = "نمایندگی طلایی";
                                        break;
                                    case 2:
                                        $title = "نمایندگی نقره ای";
                                        break;
                                    case 3:
                                        $title = "نمایندگی برنزی";
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
                                            <label class="uk-form-label">قیمت</label>
                                            <input type="text" class="uk-input" name="representations[<?php echo $key; ?>][amount]" value="<?= $amount ?>"
                                                   placeholder="قیمت">
                                        </div>
                                        <!--
                                <div class="uk-margin-small">
                                    <label class="uk-form-label">عنوان زیر قیمت(ضروری نیست)</label>
                                    <input type="text" class="uk-input" name="representations[<?php echo $key; ?>][sub_amount]" value="<?= $sub_amount ?>"
                                           placeholder="عنوان زیر قیمت">
                                </div>
                                -->
                                        <div class="uk-margin-small"><label class="uk-form-label">توضیحات</label>
                                            <?php
                                            wp_editor($description, 'description_' . $key, array(
                                                'media_buttons' => false,
                                                'drag_drop_upload' => false,
                                                'textarea_name' => 'representations[' . $key . '][description]'
                                            )); ?>
                                        </div>

                                        <div class="uk-margin-small"><label class="uk-form-label">دوره نمایندگی</label>
                                            <div uk-form-custom="target: > * > span:first-child"><select name="representations[<?php echo $key; ?>][period]">
                                                    <option value="1" <?php if ($period === "1"): ?> selected <?php endif; ?>>1 ماه</option>
                                                    <option value="2" <?php if ($period === "2"): ?> selected <?php endif; ?>>2 ماه</option>
                                                    <option value="3" <?php if ($period === "3"): ?> selected <?php endif; ?>>3 ماه</option>
                                                    <option value="6" <?php if ($period === "6"): ?> selected <?php endif; ?>>6 ماه</option>
                                                    <option value="12" <?php if ($period === "12"): ?> selected <?php endif; ?>>12 ماه</option>
                                                </select>
                                                <button class="uk-button uk-button-default" type="button" tabindex="-1"><span></span><span uk-icon="icon: chevron-down"></span></button>
                                            </div>
                                        </div>

                                        <div class="uk-margin-small"><label class="uk-form-label">رنگ</label>
                                            <div uk-form-custom="target: > * > span:first-child"><select name="representations[<?php echo $key; ?>][color]" class="kando-wheel-color">
                                                    <option value="violet" <?php if ($color === "violet"): ?> selected <?php endif; ?>>بنفش</option>
                                                    <option value="green" <?php if ($color === "green"): ?> selected <?php endif; ?>>سبز</option>
                                                    <option value="blue" <?php if ($color === "blue"): ?> selected <?php endif; ?>>آبی</option>
                                                    <option value="red" <?php if ($color === "red"): ?> selected <?php endif; ?>>قرمز</option>
                                                    <option value="orange" <?php if ($color === "orange"): ?> selected <?php endif; ?>>نارنجی</option>
                                                    <option value="gray" <?php if ($color === "gray"): ?> selected <?php endif; ?>>خاکستری</option>
                                                    <option value="default" <?php if ($color === "default"): ?> selected <?php endif; ?>>صورتی</option>
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