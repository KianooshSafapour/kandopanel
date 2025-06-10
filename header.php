<?php
$options = settingsController::getInstance();

$site_favicon = kando_get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = kando_get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}


$site_logo = kando_get_option('site-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_logo) && !empty($site_logo) && is_numeric($site_logo)) {
    $site_logo = kando_get_option('site-logo');
    $site_logo = wp_get_attachment_url($site_logo);
}


$site_mobile_logo = kando_get_option('site-mobile-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_mobile_logo) && !empty($site_mobile_logo) && is_numeric($site_mobile_logo)) {
    $site_mobile_logo = kando_get_option('site-mobile-logo');
    $site_mobile_logo = wp_get_attachment_url($site_mobile_logo);
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- For Resposive Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= $site_favicon ?>" sizes="32x32"/>
    <?php wp_head(); ?>

    <script type="text/javascript">

        Date.prototype.getUTCLocalDate = function () {
            var target = new Date(this.valueOf());
            var offset = target.getTimezoneOffset();
            var Y = target.getUTCFullYear();
            var M = target.getUTCMonth();
            var D = target.getUTCDate();
            var h = target.getUTCHours();
            var m = target.getUTCMinutes();
            var s = target.getUTCSeconds();

            console.log(target);

            return new Date(Date.UTC(Y, M, D, h, offset+m, s));
        };
        function kando_count_time($date,$id, $for) {
            var countDownDate = new Date($date).getTime();


            var x = setInterval(function () {

                // Get today's date and time
                // var now = new Date();

                let now = new Date();
                now.setHours(now.getHours()+1); //اختلاف ساعت ایران رو درست میکنه


                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                // document.getElementById("demo").innerHTML =  minutes + " دقیقه " + seconds + " ثانیه ";


                if (days === 0 && hours === 0) {
                    document.getElementById($id).innerHTML = minutes + " <?php _e("minutes", SAMYAR_TEXT_DOMAIN); ?> " + seconds + " <?php _e("seconds", SAMYAR_TEXT_DOMAIN); ?> <br> " + $for + " ";
                } else if (days === 0) {
                    document.getElementById($id).innerHTML = hours + " <?php _e("hours", SAMYAR_TEXT_DOMAIN); ?> "
                        + minutes + " <?php _e("minutes", SAMYAR_TEXT_DOMAIN); ?> " + seconds + " <?php _e("seconds", SAMYAR_TEXT_DOMAIN); ?> <br> " + $for + " ";
                } else {
                    document.getElementById($id).innerHTML = days + " <?php _e("days", SAMYAR_TEXT_DOMAIN); ?> " + hours + " <?php _e("hours", SAMYAR_TEXT_DOMAIN); ?> "
                        + minutes + " <?php _e("minutes", SAMYAR_TEXT_DOMAIN); ?> " + seconds + " <?php _e("seconds", SAMYAR_TEXT_DOMAIN); ?> <br> " + $for + " ";
                }


                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById($id).innerHTML = "";
                }
            }, 1000);
        }

    </script>
</head>

<body <?php body_class('perfect-body'); ?>>

<?php
$header_notification_active = kando_get_option('header-notification-active', 0);
$header_notification_id = kando_get_option('header-notification-id', "");
$header_notification_title = kando_get_option('header-notification-title', "");
$header_notification_btn_title = kando_get_option('notification-btn-title', "");
$header_notification_btn_url = kando_get_option('notification-btn-url', "");

$site_header_notification_bg = kando_get_option('site-header-notification-bg', SAMYAR_DIR_IMG . '/social_media_banner.png');
if (isset($site_header_notification_bg) && !empty($site_header_notification_bg) && is_numeric($site_header_notification_bg)) {
    $site_header_notification_bg = kando_get_option('site-header-notification-bg');
    $site_header_notification_bg = wp_get_attachment_url($site_header_notification_bg);
}
if ($header_notification_active):
    ?>
    <div class="kt-notice-outer" data-id="<?= esc_attr($header_notification_id) ?>">
        <div class="kt-notice-holder" style="background-image:url(<?= esc_attr($site_header_notification_bg) ?>);background-position:center center;background-repeat:repeat">
            <div class="wrapper">
                <div class="kt-notice-inner clearfix">
                    <i class="kt-notice-close elegant-icon icon_close"></i>
                    <div class="kt-notice-text"><?= esc_attr($header_notification_title) ?></div>
                    <?php if(!empty($header_notification_btn_title)): ?>
                    <a href="<?= esc_attr($header_notification_btn_url) ?>" class="button button-violet" data-wpel-link="internal"><?= esc_attr($header_notification_btn_title) ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<div class="page-holder">
    <?php
    $options = settingsController::getInstance();
    $samyar_header = kando_get_option('samyar-header', 0);
    $enable_site_title = kando_get_option('enable-site-title', 1);
    ?>
    <?php
    if($samyar_header !== "disable"){
        if (empty($samyar_header) || $samyar_header === "0"){ ?>
            <header class="menu-holder">
                <div class="wrapper">
                    <div class="menu-inner">
                        <a class="logo-holder" href="<?= home_url() ?>" title="<?= get_bloginfo('name') ?>" data-wpel-link="internal">
                            <?php if (!empty($site_logo)): ?>
                                <img class="logo" src="<?= $site_logo ?>" alt="<?= get_bloginfo('name') ?>"/>
                            <?php endif; ?>
                            <?php if($enable_site_title == 1): ?>
                            <span class="title"><?= get_bloginfo('name') ?></span>
                            <?php endif; ?>
                        </a>
                        <nav class="main-menu">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'header-menu',
                                'container' => 'ul',
                                'container_id' => 'menu-main-menu',
                                'menu_class' => 'menu',
                                'before' => '<div class="menu-item-inner">',
                                'after' => '</div>',
        //		            'items_wrap'           => '<ul class="menu">%3$s</ul>',
                            ));

                            ?>
                        </nav>

<!--                        <div class="header-phone-holder">-->
        <!--                    <i class="kt-modal-button elegant-icon icon_phone header-phone-icon active" data-modal="contact"></i>-->
<!--                        </div>-->

                        <?php
                        if (is_user_logged_in()):
                            include_once('templates/header/loged-in.php');
                        else:
                            include_once('templates/header/not-loged-in.php');
                        endif;
                        ?>

                        <div class="responsive-menu-button">
                            <i class="responsive-menu-button-inner"></i>
                        </div>

                    </div>
                </div>
            </header>
            <div class="responsive-menu-overlay"></div>
            <div class="responsive-menu-outer-holder">
                <a class="responsive-logo" href="<?= home_url() ?>" title="<?= get_bloginfo('name') ?>" data-wpel-link="internal">
                    <?php if (!empty($site_mobile_logo)): ?>
                        <img src="<?= $site_mobile_logo ?>" alt="<?= get_bloginfo('name') ?>"/>
                    <?php endif; ?>
                </a>
                <div class="responsive-menu-outer">
                    <div class="responsive-menu-holder">
                        <nav class="responsive-menu clearfix">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'header-menu',
                                'container' => 'ul',
                                'container_id' => 'menu-main-menu',
                                'menu_class' => 'responsive-menu-inner',
                                'before' => '<div class="menu-item-inner">',
                                'after' => '</div>',
                                'link_before'          => '<span>',
                                'link_after'           => '</span><i class="menu-item-toggle-icon"></i>',
                            ));

                            ?>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="menu-empty-space"></div>
            <?php }else{
                    $header_query = new WP_Query(array(
                'p'=>$samyar_header,
            'post_type' => 'kandoheader',
            'posts_per_page' => 1, // اگر چند فوتر دارید، می‌توانید تعداد را انتخاب کنید
        ));

        if ($header_query->have_posts()) {
            while ($header_query->have_posts()) {
                $header_query->the_post();
                the_content(); // نمایش محتوای فوتر المنتور
            }
        }else{
           echo do_shortcode('[elementor-template id="' . $samyar_header . '"]');
        }

        wp_reset_postdata();

        }
    } ?>