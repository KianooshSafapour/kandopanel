<?php
if (!class_exists('WP_Package_Updater')) {
    require_once get_stylesheet_directory() . '/lib/wp-package-updater/class-wp-package-updater.php';
}
new WP_Package_Updater(
    SAMYAR_UPDATE_SERVER,
    wp_normalize_path(__FILE__),
    get_stylesheet_directory()
);