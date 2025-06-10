<?php
$options = settingsController::getInstance();
$samyar_footer = kando_get_option('samyar-footer', 0);

?>
<?php
if ($samyar_footer !== "disable") {
    if (empty($samyar_footer) || $samyar_footer == 0) { ?>
        <footer class="footer">
            <div class="kt-row">
                <div class="wrapper">
                    <?php if (is_active_sidebar('footer_1')) : ?>
                        <div class="column kt-col-lg-3 kt-col-sm-5 kt-col-xs-12">
                            <div class="footer-widget">
                                <?php dynamic_sidebar('footer_1'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar('footer_2')) : ?>
                        <div class="column kt-col-lg-5 kt-col-sm-7 kt-col-xs-12">
                            <div class="footer-widget">
                                <?php dynamic_sidebar('footer_2'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer-bottom clearfix">
                <div class="wrapper">
                    <div class="footer-logos">

                    </div>
                    <div class="copyright">
                        <?php
                        echo kando_get_option('copyright', __("All material and intellectual property rights of this website belong to <a href=\"http://127.0.0.1/kandopanel\" data-wpel-link=\"internal\">Kando Panel</a>. Any form of copying is subject to legal action.", SAMYAR_TEXT_DOMAIN));
                        ?>
                    </div>
                </div>
            </div>
        </footer>
    <?php } else {

        $footer_query = new WP_Query(array(
                'p'=>$samyar_footer,
            'post_type' => 'kandofooter',
            'posts_per_page' => 1, // اگر چند فوتر دارید، می‌توانید تعداد را انتخاب کنید
        ));

        if ($footer_query->have_posts()) {
            while ($footer_query->have_posts()) {
                $footer_query->the_post();
                the_content(); // نمایش محتوای فوتر المنتور
            }
        }else{
           echo do_shortcode('[elementor-template id="' . $samyar_footer . '"]');
        }

        wp_reset_postdata();



    }
} ?>
<div class="kt-modal-outer-holder">
    <div class="kt-modal-overlay"></div>
    <div class="wrapper">
        <div class="kt-modal-holder">
            <div class="kt-modal-transparent-overlay"></div>
            <?php include_once('templates/modals/login-register.php') ?>
            <?php include_once('templates/dashboard/api-provider/modal-service.php') ?>
            <?php include_once('templates/dashboard/services/modal-description.php') ?>
            <?php include_once('templates/dashboard/notification/show.php') ?>
            <?php include_once('templates/modals/modal-send-package.php') ?>
            <?php include_once('templates/modals/info.php') ?>
            <?php include_once('templates/dashboard/payment/repayment-modal.php') ?>
        </div>
    </div>
</div>

</div>
<?php wp_footer(); ?>
<form method="post" action="" id="checkout_form" style="display: none">
    <div class="payment_info"></div>
    <input type="submit" id="payment_submit"/>
</form>
<?php
$enable_mobile_menu = kando_get_option('enable-mobile-menu', 1);
if ($enable_mobile_menu === "1" || $enable_mobile_menu) {
    include_once(SAMYAR_DIR_TEMPLATE . "/mobile-menu.php");
} ?>
<script>
    //برای جایجایی خودکار بین فیلدهای کد تایید موبایل هست
    // jQuery('.otp').autotab({format: 'custom', pattern: '[^0-9\.]'});

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
                    }, kando_data.langs.only_numbers);

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
    })
</script>
<?php
include_once(SAMYAR_DIR_TEMPLATE . '/parts/notification-sidebar.php');
?>
</body>

</html>