<?php
defined('ABSPATH') || exit('No Access!');
$options = settingsController::getInstance();
$site_mobile_logo = $options->get_option('site-mobile-logo', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_mobile_logo) && !empty($site_mobile_logo) && is_numeric($site_mobile_logo)) {
    $site_mobile_logo = $options->get_option('site-mobile-logo');
    $site_mobile_logo = wp_get_attachment_url($site_mobile_logo);
}

$site_favicon = $options->get_option('site-favicon', SAMYAR_DIR_IMG . '/logo128.png');
if (isset($site_favicon) && !empty($site_favicon) && is_numeric($site_favicon)) {
    $site_favicon = $options->get_option('site-favicon');
    $site_favicon = wp_get_attachment_url($site_favicon);
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $site_favicon ?>" sizes="32x32"/>
    <?php wp_head(); ?>
    <link type="text/css" href="<?php echo get_template_directory_uri() ?>/assets/404/css/style.css" rel="stylesheet" />
</head>
<body class="bg-purple">
<div class="stars">
    <!-- start logo and menu -->
    <div class="custom-navbar">
        <div class="brand-logo">
            <a class="responsive-logo" href="<?= home_url() ?>" title="<?= get_bloginfo('name') ?>" data-wpel-link="internal">
                <?php if (!empty($site_mobile_logo)): ?>
                    <img src="<?= $site_mobile_logo ?>" alt="<?= get_bloginfo('name') ?>" width="80px"/>
                <?php endif; ?>
            </a>
        </div>
        <div class="navbar-links">
            <ul>
                <li><a href="<?php echo home_url() ?>" target="_blank">صفحه نخست</a></li>
            </ul>
        </div>
    </div>
    <!-- end logo and menu -->
    <!-- start content -->
    <div class="central-body">
        <img class="image-404" src="<?php echo get_template_directory_uri() ?>/assets/404/pics/404.png" width="300px">
        <a href="<?php echo home_url() ?>" class="btn-go-home" target="_blank">بازگشت</a>
    </div>
    <div class="objects">
        <img class="object_rocket" src="<?php echo get_template_directory_uri() ?>/assets/404/pics/rocket.svg" width="40px">
        <div class="earth-moon">
            <img class="object_earth" src="<?php echo get_template_directory_uri() ?>/assets/404/pics/earth.svg" width="100px">
            <img class="object_moon" src="<?php echo get_template_directory_uri() ?>/assets/404/pics/moon.svg" width="80px">
        </div>
        <div class="box_astronaut">
            <img class="object_astronaut" src="<?php echo get_template_directory_uri() ?>/assets/404/pics/astronaut.svg" width="140px">
        </div>
    </div>
    <div class="glowing_stars">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>
    <!-- end content -->
</div>
<script src="<?php echo get_template_directory_uri() ?>/assets/404/js/jquery-3.1.1.min.js"></script>
<?php wp_footer(); ?>
</body>
</html>
