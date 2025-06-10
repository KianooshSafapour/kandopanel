<?php

function kando_header_post_type(){
    //$energyfooter_item_slug = energy_get_option( 'energyfooter-slug', 'energyfooter-item' );
    $kandoheader_item_slug = "kandoheader-item";

    $labels = array(
        'name' 					=> __('هدر ها',SAMYAR_TEXT_DOMAIN),
        'singular_name' 		=> __('هدر آیتم',SAMYAR_TEXT_DOMAIN),
        'add_new' 				=> __('ایجاد هدر جدید',SAMYAR_TEXT_DOMAIN),
        'add_new_item' 			=> __('ایجاد هدر جدید',SAMYAR_TEXT_DOMAIN),
        'edit_item' 			=> __('ویرایش هدر',SAMYAR_TEXT_DOMAIN),
        'new_item' 				=> __('هدر جدید',SAMYAR_TEXT_DOMAIN),
        'view_item' 			=> __('مشاهده هدر',SAMYAR_TEXT_DOMAIN),
        'search_items' 			=> __('جستجو بین هدر ها',SAMYAR_TEXT_DOMAIN),
        'not_found' 			=> __('آیتمی یافت نشد',SAMYAR_TEXT_DOMAIN),
        'not_found_in_trash' 	=> __('آیتمی یافت نشد',SAMYAR_TEXT_DOMAIN),
        'parent_item_colon' 	=> ''
    );

    $args = array(
        'labels' 				=> $labels,
        'menu_icon' 				=> SAMYAR_URI .'/includes/builder/images/header-icon.svg',
        'menu_position'       => 63,
        'public' 				=> true,
        'publicly_queryable' 	=> true,
        'show_ui' 				=> true,
        'query_var' 			=> true,
        'capability_type' 		=> 'post',
        'hierarchical' 			=> false,
        'exclude_from_search' 	=> true,
        'rewrite' 				=> array( 'slug' => $kandoheader_item_slug, 'with_front' => true ),
        'supports' 				=> array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'page-attributes' ),
    );

    register_post_type( 'kandoheader', $args );

}
add_action( 'init', 'kando_header_post_type' );



// Yoast SEO Plugin fix
function my_remove_wp_seo_header_meta_box() {
    remove_meta_box('wpseo_meta', 'kandoheader', 'normal');
}
add_action('add_meta_boxes', 'my_remove_wp_seo_header_meta_box', 100);