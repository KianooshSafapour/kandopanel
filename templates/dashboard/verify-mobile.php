<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<style>
    .text-center {
        text-align: center !important;
    }

    .mb-10 {
        margin-bottom: 2.5rem !important;
    }

    /*! CSS Used from: https://robofollow.ir/public/panel/assets/css/style.bundle.rtl.css */


    .mb-3 {
        margin-bottom: 0.75rem !important;
    }

    .mb-5 {
        margin-bottom: 1.25rem !important;
    }

    .mb-10 {
        margin-bottom: 2.5rem !important;
    }

    .fs-3 {
        font-size: calc(1.26rem + 0.12vw) !important;
    }

    .fs-5 {
        font-size: 1.15rem !important;
    }

    .fw-bold {
        font-weight: 600 !important;
    }

    .fw-semibold {
        font-weight: 500 !important;
    }

    .text-center {
        text-align: center !important;
    }

    .text-dark {
        --bs-text-opacity: 1;
        color: rgba(var(--bs-dark-rgb), var(--bs-text-opacity)) !important;
    }

    .text-muted {
        --bs-text-opacity: 1;
        color: #A1A5B7 !important;
    }

    @media (min-width: 1200px) {
        .fs-3 {
            font-size: 1.35rem !important;
        }
    }

    .text-dark {
        color: var(--kt-text-dark) !important;
    }

    .text-muted {
        color: var(--kt-text-muted) !important;
    }

    .ltr {
        direction: ltr;
    }
</style>
<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="fal fa-mobile"></i>
                <h5 class="dashboard-posts-title">صحت سنجی شماره همراه</h5>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row">
                    <div class="column kt-col-xs-12 kt-col-md-3"></div>
                    <div class="column kt-col-xs-12 kt-col-md-6">
                        <form class="" action="<?php echo home_url() ?>" method="post" id="kando-verify-form">
                            <input type="hidden" name="action" value="kando_verify_mobile">
                            <div class="kt-verify-form-errors"></div>
                            <div class="text-center mb-10">
                                <img alt="Logo" class="mh-125px" src="<?= SAMYAR_DIR_IMG . '/auth/smartphone-2.svg' ?>">
                            </div>
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">تایید شماره همراه</h1>
                                <!--end::Title-->
                                <!--begin::Sub-title-->
                                <div class="text-muted fw-semibold fs-5 mb-5">
                                    لطفا کد ارسال شده به شماره همراه زیر را وارد کنید
                                </div>
                                <!--end::Sub-title-->
                                <!--begin::Mobile no-->
                                <div class="fw-bold text-dark fs-3 ltr">
                                    <?php
                                    $mobile = get_user_meta(get_current_user_id(), 'mobile', true);
                                    if ($mobile) {
                                        echo $mobile;
                                    } else {
                                        echo 'شما شماره همراهی وارد نکرده اید لطفا جهت وارد کردن شماره همراه به <a href="'.home_url('/dashboard/?action=edit-profile').'">پروفایل</a> خود مراجعه نمایید';
                                    }
                                    ?>
                                </div>
                                <!--end::Mobile no-->
                            </div>
                            <?php if ($mobile) { ?>
                                <div class="verify-code-group grid-row aic jcc ltr">
                                    <label>
                                        <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="1"
                                               name="code[1]">
                                    </label>
                                    <label>
                                        <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="2"
                                               name="code[2]">
                                    </label>
                                    <label>
                                        <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="3"
                                               name="code[3]">
                                    </label>
                                    <label>
                                        <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="4"
                                               name="code[4]">
                                    </label>
                                    <label>
                                        <input class="otp ltr" type="number" size="1" maxlength="1" tabindex="5"
                                               name="code[5]">
                                    </label>
                                </div>

                                <a href="#" class="button button-green kt-ajax-button kt-verify-otp-code">بررسی صحت
                                    کد</a>
                                <button class="button button-blue kt-ajax-button kt-verify-send-again">ارسال کد</button>
                            <?php } ?>

                        </form>
                    </div>
                    <div class="column kt-col-xs-12 kt-col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {

        // Restricts input for the set of matched elements to the given inputFilter function.
        (function ($) {
            $.fn.inputFilter = function (callback, errMsg) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function (e) {
                    if (callback(this.value)) {
                        // Accepted value
                        if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                            $(this).removeClass("input-error");
                            this.setCustomValidity("");
                        }
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        // Rejected value - restore the previous one
                        $(this).addClass("input-error");
                        this.setCustomValidity(errMsg);
                        this.reportValidity();
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        // Rejected value - nothing to restore
                        this.value = "";
                    }
                });
            };
        }(jQuery));

        $(function () {
            $(".otp").keydown(function (event) {


                var tabIndex = parseInt($(event.target).attr('tabindex'));

                if (event.which == 8 || event.which == 46) {

                    if ($(this).val() == '') {
                        $(`.otp[tabindex='${tabIndex - 1}']`).focus();
                    } else {
                        $(this).val('');
                    }
                    return;
                } else {
                    var number = $(this).inputFilter(function (value) {
                        return /^\d*$/.test(value);    // Allow digits only, using a RegExp
                    }, "تنها عدد وارد نمایید");

                    if (number.val() == '') {
                        $(`.otp[tabindex='${tabIndex}']`).val(number.val());
                    } else {
                        $(`.otp[tabindex='${tabIndex + 1}']`).focus();
                    }

                }

                if (event.which == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                    $(event.target).closest("form").find('a.kt-verify-otp-code').click();
                }

            })


            $(".otp").keyup(function (event) {
                var index = $(event.target).closest("form").find(`.otp[tabindex='1']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='2']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='3']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='4']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='5']`).val().trim();
                if (index.length == 5) {
                    $(event.target).closest("form").find('a.kt-verify-otp-code').click();
                }
            })
        });
    });
</script>

