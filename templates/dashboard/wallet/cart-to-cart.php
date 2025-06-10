<?php
if (isset($_GET['amount'])) {
    $amount = $_GET['amount'];
} else {
    $amount = "";
}
$card_bank = $options->get_option('card-bank', '');
$card_name = $options->get_option('card-name', '');
$card_number = $options->get_option('card-number', '');
$card_account_number = $options->get_option('card-account-number', '');
$card_shaba_number = $options->get_option('card-shaba-number', '');
?>
<div class="wrapper">
    <div class="cart-inner-holder">
        <div class="woocommerce">
            <div class="woocommerce cardtocard">

                <p>
                    پس از درج فیش واریزی یا کد رهگیری ، سامانه به صورت خودکار شارژ نشده و باید منتظر بمانید تا واریز شما تایید گردد ، بنابراین از درج مجدد فیش جدا خود داری نمایید.</p>

                <h2>اطلاعات واریز</h2>

                <table class="cardtocard-table shop_table shop_table_responsive" id="cardtocard-table" cellspacing="0">
                    <thead>
                    <tr>
                        <th>نام بانک</th>
                        <th>نام صاحب حساب</th>

                        <th>شماره حساب</th>

                        <th>شماره کارت</th>

                        <th>شماره شبا</th>
                    </tr>
                    </thead>
                    <tbody class="accounts">

                    <tr class="account">
                        <td data-title="نام بانک"><?= $card_bank ?></td>
                        <td data-title="نام صاحب حساب"><?= $card_name ?></td>
                        <td data-title="شماره حساب"><?= $card_account_number ?></td>
                        <td data-title="شماره کارت"><?= $card_number ?></td>
                        <td data-title="شماره شبا"><?= $card_shaba_number ?></td>
                    </tr>
                    </tbody>
                </table>


                <div id="cardtocard-anchor"></div>

                <form action="" method="POST" style="max-width:565px;"
                      class="cardtocard-checkout-form woocommerce-checkout" id="cardtocard-checkout-form">
                    <input type="hidden" name="payment_id" value="<?= !empty($_GET['payment_id'])?$_GET['payment_id']:''?>">

                    <!--نوع پرداخت-->
                    <p id="cardtocard_type_select" class="form-row form-row-wide clear-both">

                        <label for="cardtocard_type"
                               class="cardtocard_type_select_label cardtocard_field cardtocard_label">
                            روش پرداخت <abbr class="required" title="ضروری">*</abbr>
                        </label>

                        <label for="cardtocard_type_shetab"
                               class="cardtocard_type_label cardtocard_type_shetab_label">
                            <input type="radio" name="cardtocard_type" id="cardtocard_type_shetab"
                                   class="cardtocard_type"
                                   value="shetab" checked="checked">
                            کارت به کارت </label>

                        <label for="cardtocard_type_hesab"
                               class="cardtocard_type_label cardtocard_type_hesab_label">
                            <input type="radio" name="cardtocard_type" id="cardtocard_type_hesab"
                                   class="cardtocard_type"
                                   value="hesab">
                            واریز به حساب </label>

                        <label for="cardtocard_type_paya"
                               class="cardtocard_type_label cardtocard_type_paya_label">
                            <input type="radio" name="cardtocard_type" id="cardtocard_type_paya"
                                   class="cardtocard_type"
                                   value="paya">
                            واریز پایا </label>
                    </p>

                    <!--واریز به حساب-->

                    <p id="cardtocard_to_hesab_select" class="form-row form-row-wide clear-both">

                        <label for="cardtocard_to_hesab"
                               class="cardtocard_to_hesab_label cardtocard_field cardtocard_label">
                            واریز شده به حساب <abbr class="required"
                                                    title="ضروری">*</abbr>
                        </label>

                        <select id="cardtocard_to_hesab" name="cardtocard_to_hesab"
                                class="state_select cardtocard_to_hesab cardtocard_to_hesab_select cardtocard_field">
                            <option value="">شماره حساب</option>
                            <option value="<?= $card_account_number ?> (<?= $card_name ?>)"><?= $card_account_number ?> (<?= $card_name ?>)</option>
                        </select>

                    </p>

                    <p id="cardtocard_from_hesab" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_from_hesab"
                               class="cardtocard_from_hesab_label cardtocard_field cardtocard_label">
                            شماره حساب شما <abbr class="required"
                                                 title="ضروری">*</abbr>
                        </label>
                        <input type="text" name="cardtocard_from_hesab[]" id="cardtocard_from_hesab"
                               class="input-text cardtocard_from_hesab cardtocard_from_hesab_focus cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="">

                    </p>

                    <!--واریز به پایا-->

                    <p id="cardtocard_to_paya_select" class="form-row form-row-wide clear-both">

                        <label for="cardtocard_to_paya"
                               class="cardtocard_to_paya_label cardtocard_field cardtocard_label">
                            واریز شده به شبا <abbr class="required"
                                                   title="ضروری">*</abbr>
                        </label>

                        <select id="cardtocard_to_paya" name="cardtocard_to_paya"
                                class="state_select cardtocard_to_paya cardtocard_to_paya_select cardtocard_field">
                            <option value="">شماره شبا</option>
                            <option value="<?= $card_shaba_number ?> (<?= $card_name ?>)"><?= $card_shaba_number ?> (<?= $card_name ?>)</option>
                        </select>
                    </p>


                    <p id="cardtocard_from_paya" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_from_paya"
                               class="cardtocard_from_paya_label cardtocard_field cardtocard_label">
                            شماره شبای شما <abbr class="required"
                                                 title="ضروری">*</abbr>
                        </label>
                        <input type="text" name="cardtocard_from_paya[]" id="cardtocard_from_paya"
                               class="input-text cardtocard_from_paya cardtocard_from_paya_focus cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="">

                    </p>

                    <!--واریز به کارت-->

                    <p id="cardtocard_to_shetab_select" class="form-row form-row-wide clear-both">

                        <label for="cardtocard_to_shetab"
                               class="cardtocard_to_shetab_label cardtocard_field cardtocard_label">
                            واریز شده به کارت <abbr class="required"
                                                    title="ضروری">*</abbr>
                        </label>

                        <select id="cardtocard_to_shetab" name="cardtocard_to_shetab"
                                class="state_select cardtocard_to_shetab cardtocard_to_shetab_select cardtocard_field">
                            <option value="">شماره کارت</option>
                            <option value="<?= $card_number ?> (<?= $card_name ?>)"><?= $card_number ?> (<?= $card_name ?>)</option>
                        </select>
                    </p>

                    <!--شماره کارت-->
                    <p id="cardtocard_from_shetab" class="form-row form-row-wide clear-both">

                        <label for="cardtocard_from_shetab"
                               class="cardtocard_from_shetab_label cardtocard_field cardtocard_label">
                            4 رقم پایانی شماره کارت شما <abbr class="required"
                                                              title="ضروری">*</abbr>
                        </label>


                        <input type="text" name="cardtocard_from_shetab[]" id="cardtocard_from_shetab"
                               class="input-text cardtocard_from_shetab cardtocard_from_shetab_focus cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="" maxlength="4">
                    </p>


                    <!--بانک واریز کننده-->

                    <!--شماره پیگیری-->
                    <p id="cardtocard_trans" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_trans_id"
                               class="cardtocard_trans_id_label cardtocard_field cardtocard_label">
                            شناسه پیگیری <abbr class="required" title="ضروری">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_trans_id" id="cardtocard_trans_id"
                               class="input-text cardtocard_trans_id cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="" placeholder="">
                    </p>

                    <!--مبلغ-->
                    <p id="cardtocard_price" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_price_amount"
                               class="cardtocard_price_amount_label cardtocard_field cardtocard_label">
                            مبلغ به <?php kando_get_currency_base_text(true) ?> <abbr class="required" title="ضروری">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_price_amount" id="cardtocard_price_amount"
                               class="input-text cardtocard_price_amount cardtocard_field"
                               style="float:left;max-width:350px;text-align:center !important;margin:5px;"
                               value="<?= $amount ?>" placeholder="">
                    </p>

                    <!--تاریخ-->
                    <div id="cardtocard_date" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_day"
                               class="cardtocard_date_label cardtocard_field cardtocard_label">
                            تاریخ <abbr class="required" title="ضروری">*</abbr>
                        </label>

                        <input type="text" name="cardtocard_year" id="cardtocard_year"
                               class="input-text cardtocard_year cardtocard_field"
                               style="float:left;width:110px;text-align:center !important;"
                               maxlength="4" value="" placeholder="سال">

                        <div class="cardtocard_month_wrap"
                             style="display:inline-table;width:110px;float: left;">
                            <select id="cardtocard_month" name="cardtocard_month"
                                    class="state_select cardtocard_month cardtocard_date_select cardtocard_field"
                                    title="">
                                <option value="">ماه</option>
                                <option value="فروردین">فروردین</option>
                                <option value="اردیبهشت">اردیبهشت</option>
                                <option value="خرداد">خرداد</option>
                                <option value="تیر">تیر</option>
                                <option value="مرداد">مرداد</option>
                                <option value="شهریور">شهریور</option>
                                <option value="مهر">مهر</option>
                                <option value="آبان">آبان</option>
                                <option value="آذر">آذر</option>
                                <option value="دی">دی</option>
                                <option value="بهمن">بهمن</option>
                                <option value="اسفند">اسفند</option>
                            </select>
                        </div>


                        <div class="cardtocard_day_wrap"
                             style="display:inline-table;width:110px;float: left;">
                            <select id="cardtocard_day" name="cardtocard_day"
                                    class="state_select cardtocard_day cardtocard_date_select cardtocard_field">
                                <option value="">روز</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>
                    </div>


                    <!--ساعت-->


                    <!--توضیحات اضافی-->
                    <p id="cardtocard_note" class="form-row form-row-wide clear-both">
                        <label for="cardtocard_note_text"
                               class="cardtocard_note_text_label cardtocard_field cardtocard_label">
                            توضیحات </label>

                        <textarea name="cardtocard_note_text" id="cardtocard_note_text"
                                  class="input-text cardtocard_note_text cardtocard_field"
                                  style="float:left;max-width:350px;margin:5px;"
                                  placeholder="توضیحات اضافی"></textarea>
                    </p>

                    <br/>
                    <p class="form-row form-row-wide clear-both">
                        <button type="submit" name="cardtocard_submit" class="button button-green kt-ajax-button alt"
                                id="cardtocard_payment_button"/>
                        ثبت</button>
                        <a class="cancel btn wc-forward button" href="<?= home_url('dashboard/?action=add-credit') ?>" data-wpel-link="internal">بازگشت</a>
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
