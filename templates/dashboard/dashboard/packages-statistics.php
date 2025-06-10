<!--start tickets-->
<?php if (samyar_is_admin()) { ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12 kt-col-md-12">
            <div class="dashboard-posts-box dashboard-tickets-box">
                <div class="dashboard-posts-title-holder">
                    <i class="elegant-icon icon_piechart"></i>
                    <h5 class="dashboard-posts-title"><?php _e("Agencies Statistics", SAMYAR_TEXT_DOMAIN); ?></h5>
                </div>
                <div class="dashboard-posts-list">
                    <div class="kt-row dashboard-boxs">
                        <?php
                        $level_array = [
                            '1' => ['text' => __("Golden Representation", SAMYAR_TEXT_DOMAIN), 'icon' => "/svg/author_golden.svg", 'link' => admin_url('users.php?representation=1')],
                            '2' => ['text' => __("Silver Representation", SAMYAR_TEXT_DOMAIN), 'icon' => "/svg/author_diamond.svg", 'link' => admin_url('users.php?representation=2')],
                            '3' => ['text' => __("Bronze Representation", SAMYAR_TEXT_DOMAIN), 'icon' => "/svg/author_bronze.svg", 'link' => admin_url('users.php?representation=3')],
                        ];

                        if (!empty($level_array)) {
                            foreach ($level_array as $level => $val) {
                                ?>
                                <div class="column kt-col-xs-12 kt-col-sm-6 kt-col-md-3">
                                    <div class="dashboard-box dashboard-box-orders">
                                        <a class="dashboard-box-inner" href="<?= $val['link'] ?>" data-wpel-link="internal">
                                            <div class="d-flex align-items-center">
              <span class="stamp stamp-1 stamp-md bg-danger-gradient text-white mr-3">
              <img width="35px" style="margin-top: 7px;" src="<?= SAMYAR_DIR_IMG . $val['icon'] ?>"/>
            </span>
                                                <div class="d-flex order-lg-2 ml-left">
                                                    <div class="ml-2 d-lg-block text-right">
                                                        <h4 class="m-0  number"><?= kando_count_representation($level) ?></h4>
                                                        <small class="text-muted "><?= $val['text'] ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>