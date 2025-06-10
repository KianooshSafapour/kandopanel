<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<?php if (kando_user_can('send_ticket_to_user')): ?>
    <style type="text/css">

        .select2-container {
            margin-top: 10px;
        }

        .select2-selection.select2-selection--single {
            height: 51px;
            background: #fff;
            background-position-x: 0%;
            background-position-y: 0%;
            background-repeat: repeat;
            background-image: none;
            border: 1px solid #ededed;
            border-radius: 3px;
            color: #7f8187;
            font-family: "IRANSans";
            font-size: 13px;
            width: 100%;
            -webkit-transition: color .15s ease-in-out, background .15s ease-in-out, border .15s ease-in-out;
            transition: color .15s ease-in-out, background .15s ease-in-out, border .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            text-indent: .01px;
            text-overflow: "";
        }

        .select2-dropdown {
            background: #fff;
            border: 1px solid #ededed;
        }

        .select2-selection__rendered {
            padding: 13px 15px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        .select2-container--open .select2-dropdown {
            top: 21px;
        }

    </style>
<?php endif; ?>
    <div class="kt-row">
        <div class="column kt-col-xs-12">
            <?php kando_show_alerts('ticket'); ?>
        </div>
    </div>
    <div class="woocommerce-MyAccount-content">
        <div class="woocommerce-notices-wrapper"></div>
        <div class="kt-row">
            <div class="column kt-col-xs-12 kt-col-md-5 float-left">
                <div class="new-ticket-help">
                    <img src="<?php echo SAMYAR_DIR_IMG ?>/new-ticket-help.png"/>
                    <ul>
                        <?php if (kando_user_can('send_ticket_to_user')): ?>
                            <li>برای انتخاب کاربر، تنها کافیست 3 حرف از شماره همراه یا نام و یا نام کاربری را زده و از
                                بین کاربران پیدا شده انتخاب کنید
                            </li>
                        <?php else: ?>
                            <li><?php _e("Enter your request carefully so that our experts can send you a complete answer.", SAMYAR_TEXT_DOMAIN); ?></li>
                            <li><?php _e("It is enough to create a ticket for each topic. Please avoid repeating the same issue.", SAMYAR_TEXT_DOMAIN); ?></li>
                            <li><?php _e("Providing an image or file related to the topic can help us to review your request more carefully.", SAMYAR_TEXT_DOMAIN); ?></li>
                            <li><?php _e("Your file must be less than 3 MB in size.", SAMYAR_TEXT_DOMAIN); ?></li>
                            <li><?php _e("Common text, image and compressed formats are allowed.", SAMYAR_TEXT_DOMAIN); ?></li>
                        <?php endif; ?>


                    </ul>
                </div>
            </div>
            <div class="column kt-col-xs-12 kt-col-md-7 float-left">
                <div class="new-ticket-form-outer">
                    <?php if (kando_user_can('send_ticket_to_user')): ?>
                        <h4 class="new-ticket-title"><?php _e("Send a ticket to the user", SAMYAR_TEXT_DOMAIN); ?></h4>
                    <?php else: ?>
                        <h4 class="new-ticket-title"><?php _e("How can we help you?", SAMYAR_TEXT_DOMAIN); ?></h4>
                        <span class="new-ticket-text"><?php _e("Submit your request as a ticket so that our experts will respond to it as soon as possible.", SAMYAR_TEXT_DOMAIN); ?></span>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="new-ticket-form"
                          data-user-id="<?php echo get_current_user_id() ?>">
                        <div class="new-ticket-form-errors"></div>
                        <div class="new-ticket-form-loading"></div>
                        <div class="clearfix">
                            <input type="text" class="new-ticket-form-title"
                                   placeholder="<?php _e("title", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            $order_id = $_GET['order-id'] ?? "";
                            ?>
                            <input type="text" class="new-ticket-form-order-id" style="margin-top: 10px"
                                   value="<?= $order_id ?>" placeholder="<?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?>">
                            <?php if (kando_user_can('send_ticket_to_user')): ?>

                                <select class="new-ticket-form-user-id" name="username">
                                    <option value=""><?php _e("Please choose a username", SAMYAR_TEXT_DOMAIN); ?></option>
                                </select>
                                <!--                            <input type="text" class="new-ticket-form-user-id" style="margin-top: 10px" placeholder="انتخاب کاربر">-->
                            <?php endif; ?>
                            <textarea class="new-ticket-form-text"
                                      placeholder="<?php _e("Description", SAMYAR_TEXT_DOMAIN); ?>"></textarea>

                            <?php

                            if (kando_get_option('enable-ticket-attach', 1) == 1) {
                                ?>
                                <input type="file" name="new-ticket-form-file" id="new-ticket-form-file"
                                       accept="image/gif, image/jpeg, image/png">
                                <label for="new-ticket-form-file"
                                       class="button button-blue"><?php _e("File upload", SAMYAR_TEXT_DOMAIN); ?></label>
                            <?php } ?>
                            <input type="submit" class="button button-green new-ticket-form-submit"
                                   value="<?php _e("Send ticket", SAMYAR_TEXT_DOMAIN); ?>">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
<?php if (kando_user_can('send_ticket_to_user')): ?>
    <script>
        jQuery(document).ready(function ($) {
            $('.new-ticket-form-user-id').select2({
                ajax: {
                    url: kando_data.ajaxurl, // AJAX URL is predefined in WordPress admin
                    dataType: 'json',
                    delay: 250, // delay in ms while typing when to perform a AJAX search
                    data: function (params) {
                        return {
                            q: params.term, // search query
                            action: 'kando_search_users' // AJAX action for admin-ajax.php
                        };
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {

                            // data is the array of arrays, and each of them contains ID and the Label of the option
                            $.each(data, function (index, text) { // do not forget that "index" is just auto incremented value
                                options.push({id: text[0], text: text[1]});
                            });

                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                language: "fa",
                minimumInputLength: 3 // the minimum of symbols to input before perform a search
            });

        });
    </script>
<?php endif; ?>