<div class="google-adwords-list">

    <div class="google-adwords-list-items">

        <?php
        $options = settingsController::getInstance();
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
                        $title = __("Golden Representation", SAMYAR_TEXT_DOMAIN);
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
                                        <h4 class="google-adwords-item-title"> <?= number_format_i18n((int)$amount) ?> <span><?php _e("Toman", SAMYAR_TEXT_DOMAIN); ?></span>
                                        </h4>
                                        <?php if (!empty($period)):
                                            switch ($period) {
                                                case 1:
                                                    $period_title = __("1 Month", SAMYAR_TEXT_DOMAIN);
                                                    break;
                                                case 2:
                                                    $period_title = __("2 Months", SAMYAR_TEXT_DOMAIN);
                                                    break;
                                                case 3:
                                                    $period_title = __("3 Months", SAMYAR_TEXT_DOMAIN);
                                                    break;
                                                case 6:
                                                    $period_title = __("6 Months", SAMYAR_TEXT_DOMAIN);
                                                    break;
                                                case 12:
                                                    $period_title = __("12 Months", SAMYAR_TEXT_DOMAIN);
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
                                    // If the user already has an active representation, don't show buttons
                                    if (!$package->kando_user_has_package(get_current_user_id())) {
                                        ?>
                                        <a href="#" target="_blank" class="google-adwords-item-button kt-ajax-button kt-modal-button kando-show-packages-form" data-modal="send-package"
                                           data-package="<?php echo esc_attr($key) ?>"
                                           data-type="fast-order" data-wpel-link="internal"><?php _e("Order Now", SAMYAR_TEXT_DOMAIN); ?></a>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
        <?php endif; ?>


    </div>

</div>