<div class="dashboard-posts-box dashboard-tickets-box payment-history-modal">
    <div class="dashboard-posts-list" style="padding:25px">
        <div style="clear:both;">
            <?php if ($payment->payment_type === "refund"): ?>
                <span class="price"><?= number_format_i18n((int)$payment->amount) ?>&nbsp;<?php kando_get_currency_base_text(true) ?></span>
            <?php else: ?>

                <span class="price"><?= number_format_i18n((int)$payment->amount) ?>&nbsp;<?php kando_get_currency_base_text(true) ?></span>
            <?php endif; ?>

            <span class="status">
                                                <?php
                                                switch ($payment->status) {
                                                    case 0:
                                                        echo "<span class='unsuccessful'>".__("Unsuccessful", SAMYAR_TEXT_DOMAIN)."</span>";
                                                        break;
                                                    case 1:
                                                        echo "<span class='successful'>".__("Successful", SAMYAR_TEXT_DOMAIN)."</span>";
                                                        break;
                                                    case 2:
                                                        echo "<span class='awaiting'>".__("Awaiting confirmation", SAMYAR_TEXT_DOMAIN)."</span>";
                                                        break;
                                                }
                                                ?>
</span>
        </div>
        <hr class="break">
        <div class="row1">
            <span class="title"><?php _e("Title", SAMYAR_TEXT_DOMAIN); ?></span>
            <span class="content">
                    <?php if ($payment->gateway === "wallet") { ?>
                        <?php if ($payment->payment_type === "refund"): ?>
                            <?php _e("Refund", SAMYAR_TEXT_DOMAIN); ?>

                        <?php elseif ($payment->payment_type === "decrease-credit"): ?>
                            <?php _e("Deduct from wallet", SAMYAR_TEXT_DOMAIN); ?>
                        <?php endif; ?>

                    <?php } else { ?>
                        <?php _e("Payment through the bank portal", SAMYAR_TEXT_DOMAIN); ?>

                    <?php } ?>
</span>
        </div>
        <?php if ($payment->gateway) { ?>
            <div class="row2" >
                <span class="title"><?php _e("Gateway title", SAMYAR_TEXT_DOMAIN); ?></span>
                <span class="content">
                                            <?php

                                            switch ($payment->gateway) {
                                                case 'bitpay':
                                                    $text = __("Bitpay", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-red";
                                                    break;
                                                case 'idpay':
                                                    $text = __("Idpay", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-blue";
                                                    break;
                                                case 'payir':
                                                    $text = __("Payir", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-default";
                                                    break;
                                                case 'zarinpal':
                                                    $text = __("Zarinpal", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-orange";
                                                    break;
                                                case 'zibal':
                                                    $text = __("Zibal", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-green";
                                                    break;
                                                case 'nextpay':
                                                    $text = __("Nextpay", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-blue";
                                                    break;
                                                case 'mrpardakht':
                                                    $text = __("Mrpardakht", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-blue";
                                                    break;
                                                case 'wallet':
                                                    $text = __("Wallet", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-aqua";
                                                    break;
                                                case 'card_to_card':
                                                    $text = __("Card to card", SAMYAR_TEXT_DOMAIN);
                                                    $color = "button-blue";
                                                    break;
                                                default:
                                                    $result = [];
                                                    $result = apply_filters('kando_payment_list', $result, $payment->gateway);
                                                    $text = $result['text'];
                                                    $color = $result['color'];
                                                    break;
                                            }
                                            ?>

                                            <?php echo '<span class="button ' . $color . ' badge-error-orders">' . $text . '</span>'; ?>
                </span>
            </div>
        <?php } ?>
        <div class="row3">
            <span class="title"><?php _e("Date and time", SAMYAR_TEXT_DOMAIN); ?></span>
            <span class="content"> <?php
                $date_format = get_option('date_format');
                $time_format = get_option('time_format');
                echo date_i18n($date_format . ' ' . $time_format, strtotime($payment->created_at))
                ?></span>
        </div>
        <?php if ($payment->transaction_id) { ?>
            <div class="row4">
                <span class="title"><?php _e("Bank tracking code", SAMYAR_TEXT_DOMAIN); ?></span>
                <span class="content"><?= $payment->transaction_id ?></span>
            </div>
        <?php } ?>
    </div>
</div>