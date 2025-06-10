<?php
defined('ABSPATH') || exit('No Access!');
$custom_gateway = $options->get_option('zaringate-gateways', "RND");
$default_gateway = $options->get_option('default-gateway', "zarinpal");
//print_r($balance);

//}

?>
<div class="samyar-settings-area samyar-settings-gateways">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="credit-card"></span></span>
        <strong><?php _e('GATWAYS', SAMYAR_TEXT_DOMAIN); ?></strong>
    </h3>
    <ul uk-tab>
        <li class="uk-active"><a href="#">تنظیمات عمومی</a></li>
        <li><a href="#"><?php _e('cart-to-cart', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('zarinpal', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('idpay', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('payir', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('zibal', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('bitpay', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('nextpay', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('mrpardakht', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('vandar', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <li><a href="#"><?php _e('mellat', SAMYAR_TEXT_DOMAIN); ?></a></li>
        <?php do_action('kando_settings_gateway_title') ?>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <?php
            $gateway_array = array('zarinpal','idpay', 'payir','zibal','bitpay','nextpay','mrpardakht', 'vandar','mellat');
            $gateway_array = apply_filters('kando_gateways_list',$gateway_array);
            ?>
            <div class="uk-margin">
                <label class="uk-form-label"><?php _e('default gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                <div uk-form-custom="target: > * > span:first-child">
                    <select name="default-gateway">
                        <option value=""><?php _e('Please select default gateway.', SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php foreach ($gateway_array as $gateway){ ?>
                            <option value="<?=$gateway?>" <?php selected($default_gateway, $gateway); ?>><?php _e($gateway.' Gateway', SAMYAR_TEXT_DOMAIN); ?></option>
                        <?php } ?>
                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>
            </div>
            <div class="uk-margin">

                <div class="uk-margin-small">
                    <label class="uk-form-label">حداقل پرداخت برای شارژ اعتبار(<?php kando_get_currency_base_text(true) ?>)</label>
                    <input type="number" class="uk-input" name="min-charge-credit" min="100" value="<?php echo esc_attr($options->get_option('min-charge-credit',1000)); ?>"
                           placeholder="حداقل پرداخت">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">حداکثر پرداخت برای شارژ اعتبار(<?php kando_get_currency_base_text(true) ?>)</label>
                    <input type="number" class="uk-input" name="max-charge-credit" value="<?php echo esc_attr($options->get_option('max-charge-credit',1000000)); ?>"
                           placeholder="حداکثر پرداخت">
                </div>
                <hr>
                <div class="uk-margin-small">
                    <label class="uk-form-label">حداقل پرداخت برای شارژ اعتبار(دلار)</label>
                    <input type="number" class="uk-input" name="usd-min-charge-credit" min="0" value="<?php echo esc_attr($options->get_option('usd-min-charge-credit',1)); ?>"
                           placeholder="حداقل پرداخت">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">حداکثر پرداخت برای شارژ اعتبار(دلار)</label>
                    <input type="number" class="uk-input" name="usd-max-charge-credit" min="0" value="<?php echo esc_attr($options->get_option('usd-max-charge-credit',1000)); ?>"
                           placeholder="حداکثر پرداخت">
                </div>
                <hr>
                <div class="uk-margin-small">
                    <div class="uk-alert-primary" uk-alert>
                       در این بخش می توانید میزان درصد مالیات را مشخص نمایید، این درصد به مبلغ ها اضافه و سپس به درگاه ارسال خواهد شد
                    </div>
                    <label class="uk-form-label">میزان مالیات(به درصد)<span class="new-option">(جدید)</span></label>
                    <input type="number" class="uk-input" name="tax-percent" min="0" max="100" value="<?php echo esc_attr($options->get_option('tax-percent',0)); ?>"
                           placeholder="میزان مالیات به درصد">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('cart-to-cart', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="cart-to-cart-active"
                                   value="1" <?php echo checked($options->get_option('cart-to-cart-active'), 1); ?>>
                            فعال
                        </label>
                    </div>

                </div>

                <div class="uk-margin-small">
                    <label class="uk-form-label">نام بانک</label>
                    <input type="text" class="uk-input" name="card-bank" value="<?php echo esc_attr($options->get_option('card-bank','')); ?>"
                           placeholder="نام بانک">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">نام و نام خانوادگی مالک کارت</label>
                    <input type="text" class="uk-input" name="card-name" value="<?php echo esc_attr($options->get_option('card-name','')); ?>"
                           placeholder="نام و نام خانوادگی مالک کارت">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">شماره کارت مالک کارت</label>
                    <input type="text" class="uk-input" name="card-number" value="<?php echo esc_attr($options->get_option('card-number','')); ?>"
                           placeholder="شماره کارت مالک کارت">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">شماره حساب مالک کارت</label>
                    <input type="text" class="uk-input" name="card-account-number" value="<?php echo esc_attr($options->get_option('card-account-number','')); ?>"
                           placeholder="شماره حساب مالک کارت">
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">شماره شبا مالک کارت</label>
                    <input type="text" class="uk-input" name="card-shaba-number" value="<?php echo esc_attr($options->get_option('card-shaba-number','')); ?>"
                           placeholder="شماره شبا مالک کارت">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('zarinpal Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zarinpal-active"
                                   value="1" <?php echo checked($options->get_option('zarinpal-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('zarinpal sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zarinpal-sandbox"
                                   value="1" <?php echo checked($options->get_option('zarinpal-sandbox'), 1); ?>>
				            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="zarinpal-merchant" value="<?php echo esc_attr($options->get_option('zarinpal-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://www.zarinpal.com" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('use zaringate', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="use-zaringate"
                                   value="1" <?php echo checked($options->get_option('use-zaringate', $options->samyar_default('use-zaringate')), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('select custom gateway(if use zaringate)', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div uk-form-custom="target: > * > span:first-child">
                        <select name="zaringate-gateways">
                            <option value=""><?php _e('Please select custom gateway.', SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="RND" <?php selected($custom_gateway, 'RND'); ?>>رندوم</option>
                            <option value="ASAN" <?php selected($custom_gateway, 'ASAN'); ?>>پرشین سوییچ</option>
                            <option value="SEP" <?php selected($custom_gateway, 'SEP'); ?>>سامان</option>
                            <option value="SAD" <?php selected($custom_gateway, 'SAD'); ?>>سداد</option>
                            <option value="PEC" <?php selected($custom_gateway, 'PEC'); ?>>پارسیان</option>
                            <option value="FAN" <?php selected($custom_gateway, 'FAN'); ?>>فن آوا کارت</option>
                        </select>
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">
                            <span></span>
                            <span uk-icon="icon: chevron-down"></span>
                        </button>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label for="zarinpal-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="zarinpal-order" value="<?php echo esc_attr($options->get_option('zarinpal-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>

            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('idpay Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="idpay-active"
                                   value="1" <?php echo checked($options->get_option('idpay-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="idpay-merchant" value="<?php echo esc_attr($options->get_option('idpay-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('idpay sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="idpay-sandbox"
                                   value="1" <?php echo checked($options->get_option('idpay-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://idpay.ir/" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="idpay-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="idpay-order" value="<?php echo esc_attr($options->get_option('idpay-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('payir Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="payir-active"
                                   value="1" <?php echo checked($options->get_option('payir-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="payir-merchant" value="<?php echo esc_attr($options->get_option('payir-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('payir sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="payir-sandbox"
                                   value="1" <?php echo checked($options->get_option('payir-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://pay.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="payir-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="payir-order" value="<?php echo esc_attr($options->get_option('payir-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('zibal Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zibal-active"
                                   value="1" <?php echo checked($options->get_option('zibal-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="zibal-merchant" value="<?php echo esc_attr($options->get_option('zibal-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('zibal sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="zibal-sandbox"
                                   value="1" <?php echo checked($options->get_option('zibal-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://zibal.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="zibal-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="zibal-order" value="<?php echo esc_attr($options->get_option('zibal-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('bitpay Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="bitpay-active"
                                   value="1" <?php echo checked($options->get_option('bitpay-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="bitpay-merchant" value="<?php echo esc_attr($options->get_option('bitpay-merchant')); ?>"
                           placeholder="<?php _e('Merchant Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('bitpay sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="bitpay-sandbox"
                                   value="1" <?php echo checked($options->get_option('bitpay-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://bitpay.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="bitpay-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="bitpay-order" value="<?php echo esc_attr($options->get_option('bitpay-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('nextpay Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="nextpay-active"
                                   value="1" <?php echo checked($options->get_option('nextpay-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="nextpay-api-key" value="<?php echo esc_attr($options->get_option('nextpay-api-key')); ?>"
                           placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>

                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://nextpay.org" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="nextpay-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="nextpay-order" value="<?php echo esc_attr($options->get_option('nextpay-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('mrpardakht Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="mrpardakht-active"
                                   value="1" <?php echo checked($options->get_option('mrpardakht-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mrpardakht-api-key" value="<?php echo esc_attr($options->get_option('mrpardakht-api-key')); ?>"
                           placeholder="<?php _e('mrpardakht Pin', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('mrpardakht sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="mrpardakht-sandbox"
                                   value="1" <?php echo checked($options->get_option('mrpardakht-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://aqayepardakht.ir" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="mrpardakht-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="mrpardakht-order" value="<?php echo esc_attr($options->get_option('mrpardakht-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('vandar Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="vandar-active"
                                   value="1" <?php echo checked($options->get_option('vandar-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="vandar-api" value="<?php echo esc_attr($options->get_option('vandar-api')); ?>"
                           placeholder="<?php _e('API Key', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('vandar sandbox', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="vandar-sandbox"
                                   value="1" <?php echo checked($options->get_option('vandar-sandbox'), 1); ?>>
                            <?php _e('Active sandbox', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="https://vandar.io" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="vandar-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="vandar-order" value="<?php echo esc_attr($options->get_option('vandar-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <li>
            <div class="uk-margin">

                <div class="uk-margin">
                    <label class="uk-form-label"><?php _e('Mellat Gateway', SAMYAR_TEXT_DOMAIN); ?></label>
                    <div class="uk-margin-small">
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="mellat-active"
                                   value="1" <?php echo checked($options->get_option('mellat-active'), 1); ?>>
                            <?php _e('Active', SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </div>

                </div>


                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mellat-terminal-id" value="<?php echo esc_attr($options->get_option('mellat-terminal-id')); ?>"
                           placeholder="<?php _e('mellat Terminal ID', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mellat-username" value="<?php echo esc_attr($options->get_option('mellat-username')); ?>"
                           placeholder="<?php _e('mellat Username', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="uk-margin-small">
                    <input type="text" class="uk-input" name="mellat-password" value="<?php echo esc_attr($options->get_option('mellat-password')); ?>"
                           placeholder="<?php _e('mellat Password', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
                <div class="samyar-description">
                    <span uk-icon="info"></span>
                    <a href="http://www.behpardakht.com/" target="_blank"><?php _e('Get from this link.', SAMYAR_TEXT_DOMAIN); ?></a>
                </div>
                <div class="uk-margin-small">
                    <label for="mellat-order"><?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?></label>
                    <input type="text" class="uk-input" name="mellat-order" value="<?php echo esc_attr($options->get_option('mellat-order')); ?>"
                           placeholder="<?php _e('Ordering', SAMYAR_TEXT_DOMAIN); ?>">
                </div>
            </div>
        </li>
        <?php do_action('kando_settings_gateway_content') ?>
    </ul>
</div>