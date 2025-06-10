<?php
defined('ABSPATH') || exit('No Access!');

$default = kandopanel_menu_list();
$options = settingsController::getInstance();

$menus = $options->samyar_get_menus($default);

?>
    <div class="samyar-settings wrap" style="margin: 10px 42px 5px 20px;">
        <div class="uk-grid-match" uk-grid>
            <div class="samyar-settings-content uk-width-4-4@m">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="samyar-settings-area samyar-settings-menu-list" style="display:block">

                        <h3 class="samyar-settings-title">
                            <span class="samyar-title-icon"><span uk-icon="list"></span></span>
                            <strong><?php _e('Customize Account Menu', SAMYAR_TEXT_DOMAIN); ?></strong>
                        </h3>

                        <style>
                            @font-face {
                                font-family: 'FontAwesome';
                                font-style: normal;
                                font-weight: 300;
                                font-display: block;
                                src: url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-light-300.eot");
                                src: url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-light-300.eot?#iefix") format("embedded-opentype"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-light-300.woff2") format("woff2"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-light-300.woff") format("woff"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-light-300.ttf") format("truetype"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-light-300.svg#fontawesome") format("svg");
                            }

                            @font-face {
                                font-family: 'FontAwesomeBrands';
                                font-style: normal;
                                font-weight: 300;
                                font-display: block;
                                src: url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-brands-400.eot");
                                src: url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-brands-400.eot?#iefix") format("embedded-opentype"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-brands-400.woff2") format("woff2"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-brands-400.woff") format("woff"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-brands-400.ttf") format("truetype"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-brands-400.svg#fontawesome") format("svg");
                            }

                            @font-face {
                                font-family: 'FontAwesomeRegular';
                                font-style: normal;
                                font-weight: 300;
                                font-display: block;
                                src: url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-regular-400.eot");
                                src: url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-regular-400.eot?#iefix") format("embedded-opentype"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-regular-400.woff2") format("woff2"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-regular-400.woff") format("woff"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-regular-400.ttf") format("truetype"),
                                url("<?= SAMYAR_DIR_FONT ?>/fontawesome/fontawesome/fa-regular-400.svg#fontawesome") format("svg");
                            }

                            .fa, .fas, .fal {
                                font-family: 'FontAwesome' !important;
                                font-weight: 300;
                                font-style: unset;
                            }

                            .fab {
                                font-family: 'FontAwesomeBrands' !important;
                                font-weight: 400;
                                font-style: unset;
                            }

                            .far {
                                font-family: 'FontAwesomeRegular' !important;
                                font-weight: 400;
                                font-style: unset;
                            }
                            .opacity6 {
                                opacity: .6;
                            }

                            .menu-items-block .toggled-item-name {
                                padding-right: 50px;
                            }

                            .menu-items-block .toggled-item-name .switchery {
                                position: absolute;
                                top: 6px;
                                right: 0;
                            }

                            .menu-items-block .toggled-item-name label {
                                display: inline;
                                top: 0;
                            }

                            .menu-items-block .toggled-item-name label img {
                                width: 15px;
                                height: 15px;
                                display: inline-block;
                                margin: 0 0 0 15px;
                            }

                            .menu-items-block .reorder-grabber {
                                margin: 0 0 0 2px;
                                font-size: 17px;
                                display: inline-block;
                                cursor: move;
                                position: relative;
                                top: 1px;
                            }

                            .menu-items-block .sortable-categories .sorting-only {
                                display: none;
                            }

                            .menu-items-block .sortable-categories .reorder-grabber {
                                display: block;
                                margin: 0;
                                height: 100%;
                                width: 30px;
                                text-align: center;
                                position: absolute;
                                background: #eee;
                                top: 0;
                                right: 0;
                            }

                            .menu-items-block .sortable-categories .reorder-grabber i.ti {
                                position: absolute;
                                top: 50%;
                                right: 50%;
                                margin: -7px -7px 0 0;
                                font-size: 14px;
                            }

                            .menu-items-block .delete-tag, .menu-items-block .delete-article-category {
                                font-size: 14px;
                                display: inline-block;
                                position: absolute;
                                top: 30px;
                                left: 21px;
                                cursor: pointer;
                                color: #aaa;
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }

                            .menu-items-block .category-settings {
                                font-size: 14px;
                                display: inline-block;
                                position: absolute;
                                top: 20px;
                                left: 25px;
                                cursor: pointer;
                                color: #aaa;
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }

                            .menu-items-block .remove-menu {
                                font-size: 14px;
                                display: inline-block;
                                position: absolute;
                                top: 19px;
                                left: 2px;
                                cursor: pointer;
                                color: #aaa;
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }

                            .menu-items-block .menu-status {
                                display: inline-block;
                                position: absolute;
                                top: 23px;
                                left: 28px;
                                cursor: pointer;
                                -webkit-transform: scale(1);
                                transform: scale(1);
                            }

                            .menu-items-block .sorting-on .delete-article-category {
                                display: none;
                            }

                            .menu-items-block .remove-menu:hover, .menu-items-block .delete-tag:hover, .menu-items-block .category-settings:hover {
                                -webkit-transform: scale(1.3);
                                transform: scale(1.3);
                            }

                            #articles-order-form .reorder-grabber {
                                cursor: move;
                            }

                            .menu-items-block ul.sortable-categories {
                                margin: 0;
                            }

                            .menu-items-block ul.sortable-categories li.placeholder {
                                border: dashed 2px #ccc;
                                height: 70px;
                                background-color: #FFF;
                            }

                            .menu-items-block ul.children {
                                margin: 12px 35px 15px 0;
                            }

                            .menu-items-block .sortable-categories li {
                                list-style: none
                            }

                            .menu-items-block .sortable-categories.sorting-on {
                                margin-top: -5px;
                                margin-bottom: 15px;
                            }

                            .menu-items-block .sortable-categories.sorting-on .sorting-only {
                                display: block;
                                padding-right: 28px;
                            }

                            .menu-items-block .sortable-categories.sorting-on .remove-menu,
                            .menu-items-block .sortable-categories.sorting-on .setting-category,
                            .menu-items-block .sortable-categories.sorting-on .manage-category-block > div {
                                display: none;
                            }

                            .menu-items-block .sortable-categories.sorting-on .manage-category-block {
                                display:flex;
                                padding: 0;
                                background: none;
                                border: none;
                                box-shadow: none;
                            }

                            .menu-items-block .sortable-categories.sorting-on .reorder-grabber {
                                background: none;
                                z-index: 100;
                            }

                            .menu-items-block .sortable-categories.sorting-on .reorder-grabber i.ti {
                                right: 0;
                                margin-right: 0;
                            }

                            .menu-items-block .sortable-categories .category-sorting-title {
                                padding-right: 22px;
                                margin: 0;
                            }

                            .menu-items-block .sortable-categories .category-sorting-title img {
                                width: 17px;
                                height: 17px;
                                float: right;
                                margin-left: 10px;
                                position: relative;
                                top: 2px;
                                -moz-border-radius: 3px;
                                -webkit-border-radius: 3px;
                                border-radius: 3px;
                            }

                            .menu-items-block .category-thumb {
                                display: inline-block;
                                width: 35px;
                                height: 35px;
                                box-sizing: border-box;
                                -moz-border-radius: 3px;
                                -webkit-border-radius: 3px;
                                border-radius: 3px;
                                margin: 0;
                                position: absolute;
                                top: 14px;
                                right: 50px;
                            }

                            .menu-items-block .category-thumb-uploader {
                                cursor: pointer;
                                border: 1px solid #ddd;
                                background: #fff;
                            }

                            .menu-items-block .category-thumb-uploader i.ti-plus {
                                display: block;
                                color: #ddd;
                                width: 100%;
                                height: 100%;
                                text-align: center;
                                line-height: 35px;
                            }

                            .menu-items-block .category-thumb-uploader i.ti-refresh {
                                width: auto;
                                height: auto;
                                line-height: 32px;
                                display: none;
                            }

                            .menu-items-block .category-thumb-uploader .delete {
                                display: none;
                                width: 14px;
                                height: 14px;
                                line-height: 14px;
                                text-align: center;
                                -moz-border-radius: 7px;
                                -webkit-border-radius: 7px;
                                border-radius: 7px;
                                color: #fff;
                                position: absolute;
                                top: -3px;
                                left: -3px;
                                font-size: 12px;
                                font-weight: 500;
                                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
                            }

                            .menu-items-block .category-thumb-uploader .delete:hover {
                                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.30);
                                background: #333;
                            }

                            .menu-items-block .category-thumb-uploader:hover {
                                border-style: dashed;
                                border-color: #aaa;
                                background: #eee;
                            }

                            .menu-items-block .category-thumb-uploader.has-thumb:hover .delete {
                                display: block;
                            }

                            .menu-items-block .category-thumb-uploader:hover i.ti {
                                color: #aaa;
                            }

                            .menu-items-block .category-thumb-uploader img {
                                -moz-border-radius: 2px;
                                -webkit-border-radius: 2px;
                                border-radius: 2px;
                            }

                            .menu-items-block .category-thumb-uploader img:hover {
                                opacity: 0.75;
                            }

                            .menu-items-block .category-thumb-uploader.has-thumb {
                                border: none;
                                background: #fff;
                            }

                            .menu-items-block .category-thumb-uploader.has-thumb i.ti-plus {
                                display: none;
                            }

                            .menu-items-block .category-thumb-uploader.uploading, .menu-items-block .category-thumb-uploader.uploading:hover {
                                border: none;
                            }

                            .menu-items-block .category-thumb-uploader.uploading i.ti-plus, .menu-items-block .category-thumb-uploader.uploading .img-holder {
                                display: none;
                            }

                            .img-holder {
                                padding-top: 6px;
                                font-size: 20px;
                                text-align: center;
                                display: flex;
                                justify-content: center;
                            }

                            .menu-items-block .category-thumb-uploader.uploading i.ti-refresh {
                                display: block;
                                color: #fff;
                                width: 100%;
                                height: 100%;
                                text-align: center;
                                line-height: 35px;
                            }

                            .menu-items-block .category-thumb-uploader .delete {
                                animation: ticketa-tinypop 0.2s;
                                -webkit-animation: ticketa-tinypop 0.2s;
                                -moz-animation: ticketa-tinypop 0.2s;
                                -ms-animation: ticketa-tinypop 0.2s;
                                -o-animation: ticketa-tinypop 0.2s;
                            }

                            .menu-items-block .manage-category-block {
                                border: 1px solid #e5e5e5;
                                position: relative;
                                background: #fff;
                                padding: 10px 20px 10px 75px;
                                box-shadow: unset;
                                margin: 0 0 10px;
                                -moz-border-radius: 3px;
                                -webkit-border-radius: 3px;
                                border-radius: 3px;
                                list-style-type: none;
                            }

                            .menu-items-block .manage-category-block.ui-sortable-helper {
                                border: 1px solid #ddd;
                                border-bottom-color: #ccc;
                                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.10);
                            }

                            .menu-items-block .manage-category-block.ui-sortable-placeholder {
                                visibility: visible !important;
                                box-shadow: none;
                                border: 1px solid #eee;
                                background: #f5f5f5;
                            }

                            .menu-items-block .manage-category-block.deleting-category {
                                background: #f5f5f5;
                            }

                            .menu-items-block .manage-category-block.deleting-category .reorder-grabber,
                            .menu-items-block .manage-category-block.deleting-category .fields,
                            .menu-items-block .manage-category-block.deleting-category .remove-menu {
                                opacity: 0.15;
                            }

                            .menu-items-block .category-thumb-uploader:hover,
                            .menu-items-block .category-thumb-uploader:hover i.ti,
                            .menu-items-block .category-thumb-uploader img,
                            .menu-items-block .category-thumb-uploader .delete,
                            header#header nav span.notifications span.dropdown a small {
                                -webkit-transition: all .1s ease-out;
                                -moz-transition: all .1s ease-out;
                                -o-transition: all .1s ease-out;
                                transition: all .1s ease-out;
                            }

                            .menu-items-block .manage-category-block {
                                -webkit-transition: box-shadow .2s ease-out;
                                -moz-transition: box-shadow .2s ease-out;
                                -o-transition: box-shadow .2s ease-out;
                                transition: box-shadow .2s ease-out;
                            }

                            .menu-items-block ul.sortable li ul {
                                margin-right: 50px
                            }

                            .iconpicker-container .iconpicker-popover {
                                display: block;
                                position: relative;
                                left: -37px;
                                top: -33px;
                            }


                            @media (max-width: 600px){
                                .menu-items-block .manage-category-block
                                {
                                    flex-direction: column;
                                }

                                .manage-category-block span.input{
                                    margin-right: 100px !important;
                                    margin-bottom:10px !important;
                                }
                            }

                            .samyar-reset-default img,.samyar-save-menus img{
                                display: none;
                            }
                        </style>
                        <form id="samyar-update-menu-form">
                            <div class="uk-margin menu-items-block">


                                <br>

                                <?php

                                if ($menus) {
                                    include('menu-item.php');
                                }


                                ?>

                                <br>


                                <div class="uk-margin">

                                    <button type="button" class="samyar-reset-default uk-button uk-button-primary btn-has-loader uk-align-left">
                                        <?php _e('Reset to default', SAMYAR_TEXT_DOMAIN); ?>
                                        <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg" width="26" height="26" alt="loader">
                                    </button>

                                    <button type="submit" class="samyar-save-menus uk-button  btn-has-loader uk-button-primary">
                                        <?php _e('Save changes', SAMYAR_TEXT_DOMAIN); ?>
                                        <img class="loader" src="<?php echo SAMYAR_DIR_IMG; ?>/oval.svg" width="26" height="26" alt="loader">
                                    </button>
                                </div>

                            </div>
                        </form>
                        <div class="uk-margin menu-settings-block" style="display: none">
                            <span style="display: flex;justify-content: center;"><div uk-spinner></div></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            var $sortableElements = $('.sortable');
            if ($sortableElements.length) {
                $sortableElements.nestedSortable({
                    handle: 'div',
                    listType: "ul",
                    items: 'li',
                    toleranceElement: '> div'
                });
            }
        });
    </script>
<?php //include('icon-picker-modal.php') ?>