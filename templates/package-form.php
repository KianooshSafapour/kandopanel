<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use kandoNumber\Number;
use kandonumber\numberLand;
use kandoNumber\numberService;
use kandopanel\currencyController;
use samyar\Number2Word;
use samyar\priceController;
use samyar\walletController;

$priceSettings = [
    'base_currency_data' => currencyController::getInstance()->getCurrencyByCode(get_option('base_currency', "IRT")),
    'user_currency_data' => currencyController::getInstance()->getCurrencyByCode(currencyController::getInstance()->getUserCurrency()),
];

$options = settingsController::getInstance();
$representations_attr = kando_get_option('representations');
$representations_attr = is_array($representations_attr) ? $representations_attr : [];

if (isset($_GET['package_id']) && !empty($_GET['package_id'])):
    $this_representation = $representations_attr[$_GET['package_id']];

    switch ($_GET['package_id']) {
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
endif; ?>

<div class="kt-row">
    <form method="POST" class="samyar-form package-form-order">
        <input type="hidden" name="action" value="kando_package_order">
        <input type="hidden" name="package_id" value="<?= $_GET['package_id'] ?>">
        <div class="column kt-col-xs-12 kt-col-md-12 float-left">

            <?php
            $wallet = walletController::getInstance();
            $user_credit = $wallet->getUserCredit(get_current_user_id())['price'];
            if (!is_user_logged_in()) {
                $user_credit = 0;
            }

            $total_package = $this_representation['amount'];

            if ($user_credit > 0) { // If user's wallet balance is greater than zero
                // Check if the wallet balance covers the package cost
                if ($total_package > $user_credit) { // If the package cost is higher than the wallet balance
                    $total_payment = $total_package - $user_credit; // Amount to be paid
                    $wallet_payment = $user_credit; // Deduct the entire wallet balance
                } else if ($total_package === $user_credit) { // If the wallet balance equals the package cost
                    $total_payment = 0; // No payment required
                    $wallet_payment = $user_credit; // Deduct the entire wallet balance
                } else { // If the wallet balance is more than the package cost
                    $wallet_payment = $total_package; // Deduct the package cost from the wallet
                    $total_payment = 0; // No payment required
                }
            } else {
                $wallet_payment = 0;
                $total_payment = $this_representation['amount'];
            }

            $number2word = new Number2Word();
            ?>
            <div class="kt-row">
                <div class="samyar-form-loading"></div>
                <div id="order_review" class="column kt-col-xs-12 kt-col-md-12" style="margin-top: 40px;">
                    <table class="shop_table">
                        <thead>
                        <tr>
                            <th class="product-name"><?php _e('Product', SAMYAR_TEXT_DOMAIN); ?></th>
                            <th class="product-total"><?php _e('Price', SAMYAR_TEXT_DOMAIN); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item">
                            <td class="product-name">
                                <span class="product-title">
                                    <?php _e('Purchase', SAMYAR_TEXT_DOMAIN); ?> <?= $title ?>&nbsp;
                                </span>
                            </td>
                            <td class="product-total">
                                <?= priceController::kandoFormatPrice($this_representation['amount'])['price_for_show_formatted'] ?>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>

                        <?php if ($wallet_payment > 0): ?>
                            <tr class="cart-discount">
                                <th><?php _e('Deduct from Wallet', SAMYAR_TEXT_DOMAIN); ?></th>
                                <td class="align-left" data-title="<?php _e('Wallet Balance', SAMYAR_TEXT_DOMAIN); ?>"><?= priceController::kandoFormatPrice($wallet_payment)['price_for_show_formatted'] ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr class="cart-subtotal" style="display: none">
                            <th><?php _e('Total Price', SAMYAR_TEXT_DOMAIN); ?></th>
                            <td><span class="amount"><?= priceController::kandoFormatPrice((int)$this_representation['amount'])['price_for_show_formatted'] ?>&nbsp;</span></td>
                        </tr>

                        <tr class="order-total">
                            <th><?php _e('Amount Payable', SAMYAR_TEXT_DOMAIN); ?></th>
                            <td><strong><span class="amount"><?= priceController::kandoFormatPrice((int)$total_payment)['price_for_show_formatted'] ?>&nbsp;</span></strong></td>
                        </tr>
                        <?php if (round($total_payment) > 0) { ?>
                            <tr>
                                <th colspan="2"><?php _e('In Words:', SAMYAR_TEXT_DOMAIN); ?> <strong><span class="woocommerce-Price-amount amount"><?php echo $number2word->numberToWords(round($total_payment)) ?>&nbsp;<span
                                                    class="woocommerce-Price-currencySymbol"><?php kando_get_currency_base_text() ?></span></span></strong></th>
                            </tr>
                        <?php } ?>

                        </tfoot>
                    </table>

                    <div>
                        <textarea style="height: 110px;margin-top: 20px;" name="user_note" class="input-text" id="user_note" placeholder="<?php _e('Your note for the admin (optional)', SAMYAR_TEXT_DOMAIN); ?>"></textarea>
                    </div>

                    <div id="payment" class="woocommerce-checkout-payment">
                        <?php include (SAMYAR_DIR_TEMPLATE.'/gateways-list/gateways-list.php') ?>
                        <div class="form-row place-order">
                            <button class="button button-green kt-ajax-button alt" id="place_order"><?php _e('Place Order', SAMYAR_TEXT_DOMAIN); ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>

<script>
    jQuery(function($) {
        var $form = $j('.package-form-order');
        if (!$form.length) return;

        // kandoSetDefaultGateway($form);
        // kandoToggleCardSelect($form);
        // روش صحیح: تابع را مستقیماً پاس دهید، نه نتیجه آن را
        $(document).on("change", '.package-form-order #payment_method', function() {
            kandoToggleCardSelect($form);
        });

        $(document).on("change", '.package-form-order input[name="payment_method"]', function() {
            kandoToggleCardSelect($form);
        });
    });
</script>