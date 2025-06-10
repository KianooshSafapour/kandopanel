<div id="payment" class="woocommerce-checkout-payment kando-gateways-list">
    <?php

    $gateway_style = kando_get_option('gateway-style', "2");

    $gateways = kandopanel_gateways_list();

    // حذف کیف پول از لیست درگاه‌ها
    $wallet = null;
    foreach ($gateways as $key => $gateway) {
        if ($gateway['gateway'] === 'wallet') {
            unset($gateways[$key]);
            break;
        }
    }


    usort($gateways, function ($a, $b) {
        return $a['order'] <=> $b['order'];
    });

    //                                        print_r($gateways);

    //اگر اعتبار قبل از ارسال سفارش فعال بود
    //بهش بگو که باید قبل از ارسال سفارش کیف پول خودشون رو شارژ کنن
    $enable_agree_order = kando_get_option('enable-wallet-charge', "0");

    if ($enable_agree_order !== "1") {

        if ($gateway_style == 1) {
            ?>
            <label class="mt-3"><?php _e('Select the desired gateway', SAMYAR_TEXT_DOMAIN) ?></label>
            <select class="form-control mb-3" id="payment_method"
                    name="payment_method">
                <?php
                foreach ($gateways as $gateway) {
                    if ($gateway['enable']) {

                        ?>

                        <option
                            data-currency="<?= htmlspecialchars($gateway['currency']) ?>"
                            data-hasCardCheck="<?= htmlspecialchars($gateway['hasCardCheck']) ?>"
                            data-cards="<?= htmlspecialchars(json_encode($gateway['cards'] ?? [])) ?>"
                            value="<?= htmlspecialchars($gateway['gateway']) ?>"
                        >
                            <?= htmlspecialchars($gateway['title']) ?>
                        </option>

                    <?php }
                }
                ?>
            </select>
            <?php
        } else {
            ?>
            <label><?php _e('Select the desired gateway', SAMYAR_TEXT_DOMAIN) ?></label>
    <?php
            foreach ($gateways as $gateway) {
                if ($gateway['enable']) {

                    ?>

                    <label class="d-flex flex-stack cursor-pointer style2">
                        <!--begin:Label-->
                        <span class="d-flex align-items-center">
														<!--begin:Icon-->
														<span class="symbol">
															<span class="symbol-label bg-light-warning">
                                                                            <img src="<?= $gateway['icon'] ?>"
                                                                                 alt="<?= $gateway['title'] ?>">
															</span>
														</span>
                            <!--end:Icon-->
                            <!--begin:Info-->
														<span class="d-flex">
															<span class="fw-bold fs-6"><?= $gateway['title'] ?></span>
                                                            															<span class="fs-7 text-muted">
                                                            </span>
														</span>
                            <!--end:Info-->
													</span>
                        <!--end:Label-->
                        <!--begin:Input-->
                        <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio"
                                                               name="payment_method"
                                                               data-currency="<?= htmlspecialchars($gateway['currency']) ?>"
                                                               data-hasCardCheck="<?= htmlspecialchars($gateway['hasCardCheck']) ?>"
                                                               data-cards="<?= htmlspecialchars(json_encode($gateway['cards'] ?? [])) ?>"
                                                               value="<?= htmlspecialchars($gateway['gateway']) ?>"
                                                        >
													</span>
                        <!--end:Input-->
                    </label>


                <?php }
            }
        }


    } ?>
    <div class="show-carts"></div>
</div>