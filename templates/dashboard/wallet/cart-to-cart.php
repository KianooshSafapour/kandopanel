<?php
if (isset($_GET['amount'])) {
    $amount = $_GET['amount'];
} else {
    $amount = "";
}
$card_bank = kando_get_option('card-bank', '');
$card_name = kando_get_option('card-name', '');
$card_number = kando_get_option('card-number', '');
$card_account_number = kando_get_option('card-account-number', '');
$card_shaba_number = kando_get_option('card-shaba-number', '');
?>
<div class="wrapper">
    <div class="cart-inner-holder">
        <div class="woocommerce">
            <div class="woocommerce cardtocard">

                <p>
                    <?php _e("After uploading the deposit slip or tracking code, the system will not automatically credit your account. You need to wait for your deposit to be confirmed. Therefore, avoid re-uploading the same slip.", SAMYAR_TEXT_DOMAIN); ?>
                </p>

                <h2><?php _e("Deposit Information", SAMYAR_TEXT_DOMAIN); ?></h2>

                <table class="cardtocard-table shop_table shop_table_responsive" id="cardtocard-table" cellspacing="0">
                    <thead>
                    <tr>
                        <th><?php _e("Bank Name", SAMYAR_TEXT_DOMAIN); ?></th>
                        <th><?php _e("Account Holder Name", SAMYAR_TEXT_DOMAIN); ?></th>
                        <th><?php _e("Account Number", SAMYAR_TEXT_DOMAIN); ?></th>
                        <th><?php _e("Card Number", SAMYAR_TEXT_DOMAIN); ?></th>
                        <th><?php _e("IBAN", SAMYAR_TEXT_DOMAIN); ?></th>
                    </tr>
                    </thead>
                    <tbody class="accounts">
                    <tr class="account">
                        <td data-title="<?php _e("Bank Name", SAMYAR_TEXT_DOMAIN); ?>"><?= $card_bank ?></td>
                        <td data-title="<?php _e("Account Holder Name", SAMYAR_TEXT_DOMAIN); ?>"><?= $card_name ?></td>
                        <td data-title="<?php _e("Account Number", SAMYAR_TEXT_DOMAIN); ?>"><?= $card_account_number ?></td>
                        <td data-title="<?php _e("Card Number", SAMYAR_TEXT_DOMAIN); ?>"><?= $card_number ?></td>
                        <td data-title="<?php _e("IBAN", SAMYAR_TEXT_DOMAIN); ?>"><?= $card_shaba_number ?></td>
                    </tr>
                    </tbody>
                </table>


                <div id="cardtocard-anchor"></div>

                <form action="" method="POST" style="max-width:565px;"
                      class="cardtocard-checkout-form woocommerce-checkout" id="cardtocard-checkout-form">
                    <input type="hidden" name="payment_id" value="<?= !empty($_GET['payment_id'])?$_GET['payment_id']:''?>">

                    <!-- Payment Method -->
                    <p id="cardtocard_type_select" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_type"
                               class="cardtocard_type_select_label cardtocard_field cardtocard_label">
                            <?php _e("Payment Method", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required" title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <label for="cardtocard_type_shetab"
                               class="cardtocard_type_label cardtocard_type_shetab_label">
                            <input type="radio" name="cardtocard_type" id="cardtocard_type_shetab"
                                   class="cardtocard_type"
                                   value="shetab" checked="checked">
                            <?php _e("Card to Card", SAMYAR_TEXT_DOMAIN); ?>
                        </label>

                        <label for="cardtocard_type_hesab"
                               class="cardtocard_type_label cardtocard_type_hesab_label">
                            <input type="radio" name="cardtocard_type" id="cardtocard_type_hesab"
                                   class="cardtocard_type"
                                   value="hesab">
                            <?php _e("Bank Transfer", SAMYAR_TEXT_DOMAIN); ?>
                        </label>

                        <label for="cardtocard_type_paya"
                               class="cardtocard_type_label cardtocard_type_paya_label">
                            <input type="radio" name="cardtocard_type" id="cardtocard_type_paya"
                                   class="cardtocard_type"
                                   value="paya">
                            <?php _e("Paya Deposit", SAMYAR_TEXT_DOMAIN); ?>
                        </label>
                    </p>

                    <!-- Bank Transfer -->

                    <p id="cardtocard_to_hesab_select" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_to_hesab"
                               class="cardtocard_to_hesab_label cardtocard_field cardtocard_label">
                            <?php _e("Deposited to Account", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required"
                                                                                           title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <select id="cardtocard_to_hesab" name="cardtocard_to_hesab"
                                class="state_select cardtocard_to_hesab cardtocard_to_hesab_select cardtocard_field">
                            <option value=""><?php _e("Account Number", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="<?= $card_account_number ?> (<?= $card_name ?>)"><?= $card_account_number ?> (<?= $card_name ?>)</option>
                        </select>
                    </p>

                    <p id="cardtocard_from_hesab" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_from_hesab"
                               class="cardtocard_from_hesab_label cardtocard_field cardtocard_label">
                            <?php _e("Your Account Number", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required"
                                                                                          title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>
                        <input type="text" name="cardtocard_from_hesab[]" id="cardtocard_from_hesab"
                               class="input-text cardtocard_from_hesab cardtocard_from_hesab_focus cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="">
                    </p>

                    <!-- Paya Deposit -->

                    <!-- Paya Deposit -->
                    <p id="cardtocard_to_paya_select" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_to_paya"
                               class="cardtocard_to_paya_label cardtocard_field cardtocard_label">
                            <?php _e("Deposited to IBAN", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required"
                                                                                        title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <select id="cardtocard_to_paya" name="cardtocard_to_paya"
                                class="state_select cardtocard_to_paya cardtocard_to_paya_select cardtocard_field">
                            <option value=""><?php _e("IBAN Number", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="<?= $card_shaba_number ?> (<?= $card_name ?>)"><?= $card_shaba_number ?> (<?= $card_name ?>)</option>
                        </select>
                    </p>

                    <p id="cardtocard_from_paya" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_from_paya"
                               class="cardtocard_from_paya_label cardtocard_field cardtocard_label">
                            <?php _e("Your IBAN Number", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required"
                                                                                       title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>
                        <input type="text" name="cardtocard_from_paya[]" id="cardtocard_from_paya"
                               class="input-text cardtocard_from_paya cardtocard_from_paya_focus cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="">
                    </p>

                    <!-- Card to Card Deposit -->
                    <p id="cardtocard_to_shetab_select" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_to_shetab"
                               class="cardtocard_to_shetab_label cardtocard_field cardtocard_label">
                            <?php _e("Deposited to Card", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required"
                                                                                        title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <select id="cardtocard_to_shetab" name="cardtocard_to_shetab"
                                class="state_select cardtocard_to_shetab cardtocard_to_shetab_select cardtocard_field">
                            <option value=""><?php _e("Card Number", SAMYAR_TEXT_DOMAIN); ?></option>
                            <option value="<?= $card_number ?> (<?= $card_name ?>)"><?= $card_number ?> (<?= $card_name ?>)</option>
                        </select>
                    </p>

                    <!-- Card Number -->
                    <p id="cardtocard_from_shetab" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_from_shetab"
                               class="cardtocard_from_shetab_label cardtocard_field cardtocard_label">
                            <?php _e("Last 4 digits of your card number", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required"
                                                                                                        title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_from_shetab[]" id="cardtocard_from_shetab"
                               class="input-text cardtocard_from_shetab cardtocard_from_shetab_focus cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="" maxlength="4">
                    </p>

                    <!--بانک واریز کننده-->

                    <!-- Tracking Number -->
                    <p id="cardtocard_trans" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_trans_id"
                               class="cardtocard_trans_id_label cardtocard_field cardtocard_label">
                            <?php _e("Tracking ID", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required" title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_trans_id" id="cardtocard_trans_id"
                               class="input-text cardtocard_trans_id cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="" placeholder="">
                    </p>

                    <!-- Amount -->
                    <p id="cardtocard_price" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_price_amount"
                               class="cardtocard_price_amount_label cardtocard_field cardtocard_label">
                            <?php _e("Amount in", SAMYAR_TEXT_DOMAIN); ?> <?php kando_get_currency_base_text(true); ?> <abbr class="required" title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_price_amount" id="cardtocard_price_amount"
                               class="input-text cardtocard_price_amount cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="<?= $amount ?>" placeholder="">
                    </p>

                    <!-- Date -->
                    <div id="cardtocard_date" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_day"
                               class="cardtocard_date_label cardtocard_field cardtocard_label">
                            <?php _e("Date", SAMYAR_TEXT_DOMAIN); ?> <abbr class="required" title="<?php _e("Required", SAMYAR_TEXT_DOMAIN); ?>">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_year" id="cardtocard_year"
                               class="input-text cardtocard_year cardtocard_field"
                               style="float:left;width:110px;text-align:center !important;"
                               maxlength="4" value="" placeholder="<?php _e("Year", SAMYAR_TEXT_DOMAIN); ?>">

                        <div class="cardtocard_month_wrap"
                             style="display:inline-table;width:110px;float: left;">
                            <select id="cardtocard_month" name="cardtocard_month"
                                    class="state_select cardtocard_month cardtocard_date_select cardtocard_field"
                                    title="">
                                <option value=""><?php _e("Month", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="فروردین"><?php _e("Farvardin", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="اردیبهشت"><?php _e("Ordibehesht", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="خرداد"><?php _e("Khordad", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="تیر"><?php _e("Tir", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="مرداد"><?php _e("Mordad", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="شهریور"><?php _e("Shahrivar", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="مهر"><?php _e("Mehr", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="آبان"><?php _e("Aban", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="آذر"><?php _e("Azar", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="دی"><?php _e("Day", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="بهمن"><?php _e("Bahman", SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="اسفند"><?php _e("Esfand", SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>
                        </div>


                        <div class="cardtocard_day_wrap"
                             style="display:inline-table;width:110px;float: left;">
                            <select id="cardtocard_day" name="cardtocard_day"
                                    class="state_select cardtocard_day cardtocard_date_select cardtocard_field">
                                <option value=""><?php _e("Day", SAMYAR_TEXT_DOMAIN); ?></option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>


                    <!-- Time -->


                    <!-- Additional Description -->
                    <p id="cardtocard_note" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_note_text"
                               class="cardtocard_note_text_label cardtocard_field cardtocard_label">
                            <?php _e("Description", SAMYAR_TEXT_DOMAIN); ?> </label>

                        <textarea name="cardtocard_note_text" id="cardtocard_note_text"
                                  class="input-text cardtocard_note_text cardtocard_field"
                                  style="float:left;max-width:350px;margin:5px;"
                                  placeholder="<?php _e("Additional details", SAMYAR_TEXT_DOMAIN); ?>"></textarea>
                    </p>

                    <br/>
                    <p class="form-row form-row-wide clear-both">
                        <button type="submit" name="cardtocard_submit" class="button button-green kt-ajax-button alt"
                                id="cardtocard_payment_button">
                            <?php _e("Submit", SAMYAR_TEXT_DOMAIN); ?>
                        </button>
                        <a class="cancel btn wc-forward button" href="<?= home_url('dashboard/?action=add-credit') ?>" data-wpel-link="internal">
                            <?php _e("Back", SAMYAR_TEXT_DOMAIN); ?>
                        </a>
                    </p>
                </form>


            </div>

            <style type="text/css">
                .cardtocard-table * {
                    text-align: center;
                }

                .cardtocard-table {
                    width: 100%
                }

                .cardtocard_field {
                    margin: 5px;
                    float: left;
                }

                .cardtocard_label {
                    float: right;
                    width: 100%;
                    max-width: 186px;
                }

                .cardtocard_type_label {
                    float: right;
                }

                .cardtocard_type_label {
                    display: inline;
                    margin: 5px;
                }

                .cardtocard_type_container {
                    float: left;
                    text-align: center;
                }

                .cardtocard_date_select {
                    width: 110px !important;
                }

                .cardtocard_to_shetab_select, .cardtocard_to_hesab_select, .cardtocard_to_paya_select {
                    max-width: 350px !important;
                }

                .clear-both {
                    clear: both;
                }

                @media (max-width: 545px) {
                    .cardtocard_type_label {
                        width:100%;
                        margin-right: 0 !important;
                    }
                }
                @media (max-width: 606px) {
                    .cardtocard_date_select{
                        width:100% !important;
                        max-width: 350px;
                    }

                    .cardtocard_year{
                        width:100% !important;
                        max-width: 350px;
                    }

                    .cardtocard_day_wrap{
                        width:100% !important;
                        max-width: 350px;
                    }

                    .cardtocard_month_wrap{
                        width:100% !important;
                        max-width: 350px;
                    }
                }
            </style>

            <script type="text/javascript">
                jQuery(".cardtocard_from_shetab_focus").on('input', function () {
                    if (jQuery(this).val().length === parseInt(jQuery(this).attr('maxlength'))) {
                        jQuery(this).next(".cardtocard_from_shetab_focus").focus();
                    }
                });
                jQuery(".cardtocard_time").on('input', function () {
                    if (jQuery(this).val().length === parseInt(jQuery(this).attr('maxlength'))) {
                        jQuery(this).next(".cardtocard_time").focus();
                    }
                });

                function show_hide_cardtocart() {
                    if (jQuery('input[name="cardtocard_type"]:checked').val() === 'hesab') {
                        jQuery("#cardtocard_from_shetab").hide("slow");
                        jQuery("#cardtocard_from_hesab").show("slow");
                        jQuery("#cardtocard_from_paya").hide("slow");

                        jQuery("#cardtocard_to_shetab_select").hide("slow");
                        jQuery("#cardtocard_to_hesab_select").show("slow");
                        jQuery("#cardtocard_to_paya_select").hide("slow");
                    } else if (jQuery('input[name="cardtocard_type"]:checked').val() === 'paya') {
                        jQuery("#cardtocard_from_shetab").hide("slow");
                        jQuery("#cardtocard_from_hesab").hide("slow");
                        jQuery("#cardtocard_from_paya").show("slow");

                        jQuery("#cardtocard_to_shetab_select").hide("slow");
                        jQuery("#cardtocard_to_hesab_select").hide("slow");
                        jQuery("#cardtocard_to_paya_select").show("slow");
                    } else {
                        jQuery("#cardtocard_from_shetab").show("slow");
                        jQuery("#cardtocard_from_hesab").hide("slow");
                        jQuery("#cardtocard_from_paya").hide("slow");

                        jQuery("#cardtocard_to_shetab_select").show("slow");
                        jQuery("#cardtocard_to_hesab_select").hide("slow");
                        jQuery("#cardtocard_to_paya_select").hide("slow");
                    }
                }

                jQuery(document).ready(function (jQuery) {
                    show_hide_cardtocart();
                    jQuery('input[name="cardtocard_type"]').on("click", function () {
                        show_hide_cardtocart();
                    });
                });
                jQuery(document).on("click", "#cardtocard_payment_button", function () {
                    var $this = jQuery(this);
                    // jQuery('.cardtocard-checkout-form').block({
                    //     message: null,
                    //     overlayCSS: {
                    //         background: '#fff',
                    //         opacity: 0.6
                    //     }
                    // });
                    var cardtocard_from = document.getElementsByClassName('cardtocard_from_' + jQuery('input[name="cardtocard_type"]:checked').val()),
                        cardtocard_from = [].map.call(cardtocard_from, function (input) {
                            return input.value;
                        }).join('-');
                    $this.addClass('is-loading');
                    $this.addClass('clicked');
                    jQuery.ajax({
                        url: kando_data.ajaxurl,
                        type: "POST",
                        data: {
                            action: "kando_cardtocard_submit",
                            cardtocard_type: jQuery('input[name="cardtocard_type"]:checked').val(),
                            payment_id: jQuery('input[name="payment_id"]').val(),
                            cardtocard_to: jQuery('select[name="cardtocard_to_' + jQuery('input[name="cardtocard_type"]:checked').val() + '"]').val(),
                            cardtocard_from: cardtocard_from,
                            cardtocard_bank_id: jQuery('input[name="cardtocard_bank_id"]').val(),
                            cardtocard_trans_id: jQuery('input[name="cardtocard_trans_id"]').val(),
                            cardtocard_price_amount: jQuery('input[name="cardtocard_price_amount"]').val(),
                            cardtocard_note_text: jQuery('textarea[name="cardtocard_note_text"]').val(),
                            cardtocard_date: jQuery('select[name="cardtocard_day"]').val() + "-" + jQuery('select[name="cardtocard_month"]').val() + "-" + jQuery('input[name="cardtocard_year"]').val(),
                            cardtocard_time: jQuery('input[name="cardtocard_hour"]').val() + ":" + jQuery('input[name="cardtocard_min"]').val() + ":" + jQuery('select[name="cardtocard_am_pm"]').val(),
                        },
                        success: function (response) {

                            if (response.success) {
                                setTimeout(function () {
                                    Swal.fire({
                                        // title: 'خطایی رخ داده است',
                                        icon: 'success',
                                        html: response.data.message,
                                        showCloseButton: true,
                                        confirmButtonText: 'باشه',
                                    })
                                    window.location.href = response.data.redirect;
                                }, 1000);

                                return false;
                            } else {
                                Swal.fire({
                                    title: 'خطایی رخ داده است',
                                    icon: 'error',
                                    html: response.data,
                                    showCloseButton: true,
                                    confirmButtonText: 'باشه',
                                });

                                var target = jQuery('#cardtocard_payment_button').closest('form');
                                jQuery('.woocommerce-error, .woocommerce-message').remove();
                                target.before(response);
                                jQuery('html, body').animate({
                                    scrollTop: jQuery("#cardtocard-anchor").offset().top - 60
                                }, 2000);

                                $this.removeClass('is-loading');
                                $this.removeClass('clicked');
                            }


                        },
                        complete: function () {
                            // jQuery('.cardtocard-checkout-form').unblock();
                        }
                    });
                    return false;
                });
            </script>

            <div class="clear"></div>
        </div>
    </div>
</div>
