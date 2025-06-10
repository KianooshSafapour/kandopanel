<?php

function kando_footer_post_type(){
    $kandofooter_item_slug = "kandofooter-item";

    $labels = array(
        'name' 					=> __('فوتر ها',SAMYAR_TEXT_DOMAIN),
        'singular_name' 		=> __('فوتر آیتم',SAMYAR_TEXT_DOMAIN),
        'add_new' 				=> __('ایجاد فوتر جدید',SAMYAR_TEXT_DOMAIN),
        'add_new_item' 			=> __('ایجاد فوتر جدید',SAMYAR_TEXT_DOMAIN),
        'edit_item' 			=> __('ویرایش فوتر',SAMYAR_TEXT_DOMAIN),
        'new_item' 				=> __('فوتر جدید',SAMYAR_TEXT_DOMAIN),
        'view_item' 			=> __('مشاهده فوتر',SAMYAR_TEXT_DOMAIN),
        'search_items' 			=> __('جستجو بین فوتر ها',SAMYAR_TEXT_DOMAIN),
        'not_found' 			=> __('آیتمی یافت نشد',SAMYAR_TEXT_DOMAIN),
        'not_found_in_trash' 	=> __('آیتمی یافت نشد',SAMYAR_TEXT_DOMAIN),
        'parent_item_colon' 	=> ''
    );

    $args = array(
        'labels' 				=> $labels,
        'menu_icon' 				=> SAMYAR_URI .'/includes/builder/images/footer-icon.svg',
        'menu_position'       => 64,
        'public' 				=> true,
        'publicly_queryable' 	=> true,
        'show_ui' 				=> true,
        'query_var' 			=> true,
        'capability_type' 		=> 'post',
        'hierarchical' 			=> false,
        'exclude_from_search' 	=> true,
        'rewrite' 				=> array( 'slug' => $kandofooter_item_slug, 'with_front' => true ),
        'supports' 				=> array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'page-attributes' ),
    );

    register_post_type( 'kandofooter', $args );

}
add_action( 'init', 'kando_footer_post_type' );



// Yoast SEO Plugin fix
function my_remove_wp_seo_footer_meta_box() {
    remove_meta_box('wpseo_meta', 'kandofooter', 'normal');
}
add_action('add_meta_boxes', 'my_remove_wp_seo_footer_meta_box', 100);