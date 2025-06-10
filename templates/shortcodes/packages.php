<div class="google-adwords-list">

    <div class="google-adwords-list-items">

        <?php
        $options = settingsController::getInstance();
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
                $color = $item['color'] ?? "violet";
                if ($amount):
                    ?>
                    <div class="google-adwords-item currency-Lyr column kt-col-xs-12 kt-col-sm-4 kt-col-md-4 kt-col-lg-4">
                        <div class="google-adwords-item-holder google-adwords-item-<?= $color ?>">
                            <div class="google-adwords-item-label-holder"><span
                                        class="google-adwords-item-label"><?= $title ?></span></div>
                            <div class="google-adwords-item-outer">
                                <div class="google-adwords-item-inner">
                                    <div class="google-adwords-item-inner-holder">
                                        <h4 class="google-adwords-item-title"> <?= number_format_i18n((int)$amount) ?> <span>تومان</span>
                                        </h4>
                                        <?php if (!empty($period)):
                                            switch ($period) {
                                                case 1:
                                                    $period_title = "1 ماهه";
                                                    break;
                                                case 2:
                                                    $period_title = "2 ماهه";
                                                    break;
                                                case 3:
                                                    $period_title = "3 ماهه";
                                                    break;
                                                case 6:
                                                    $period_title = "6 ماهه";
                                                    break;
                                                case 12:
                                                    $period_title = "12 ماهه";
                                                    break;
                                            }
                                            ?>
                                            <div class="google-adwords-item-wage"><?= $period_title ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <br>
                                <div class="package_description"><?= stripslashes(html_entity_decode(nl2br($description))) ?></div>

                                <div class="google-adwords-item-bottom">
                                    <?php $package = new \kandopanel\packageController();
                                    //اگر در حال حاضر نمایندگی براش فعال باشه دکمه ها رو نشون نده
                                    if (!$package->kandy_calculation_representation(get_current_user_id())) {
                                        ?>
                                        <a href="#" target="_blank" class="google-adwords-item-button kt-ajax-button kt-modal-button kando-show-packages-form" data-modal="send-package"
                                           data-package="<?php echo esc_attr($key) ?>"
                                           data-type="fast-order" data-wpel-link="internal">سفارش دهید</a>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
        <?php endif; ?>


    </div>

</div>



