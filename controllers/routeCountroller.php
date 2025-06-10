<?php


Class routeCountroller {

    private $pages;

    function __construct() {

        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        add_action( 'init', array( $this, 'rewrite' ) );
        add_filter( 'query_vars', array( $this, 'query_vars' ) );
        add_action( 'template_include', array( $this, 'change_template' ) );
//		$this->pages = new ticketa_Options_Manager();

    }

    function activate() {
        set_transient( 'vpt_flush', 1, 60 );
    }

    function rewrite() {

//		add_rewrite_endpoint( 'dump', EP_PERMALINK );
        add_rewrite_rule( '^cron/order/([^/]+)/?$', 'index.php?kando-cron-order=1&key=$matches[1]', 'top' );//برای صفحه بندی
        add_rewrite_rule( '^cron/status/([^/]+)/?$', 'index.php?kando-cron-status=1&key=$matches[1]', 'top' );//برای صفحه بندی

        if(get_transient( 'vpt_flush' )) {
            delete_transient( 'vpt_flush' );
            flush_rewrite_rules();
        }
    }

    function query_vars($vars) {
        $vars[] = 'kando-cron-order';
        $vars[] = 'kando-cron-status';
        $vars[] = 'key';


        return $vars;
    }

    function change_template( $template ) {


        if( get_query_var( 'kando-cron-order', false ) !== false ) {

            $newTemplate = SAMYAR_PATH . '/cron.php';
            if( file_exists( $newTemplate ) ) {
                return $newTemplate;
            }

        }

        if( get_query_var( 'kando-cron-status', false ) !== false ) {

            $newTemplate = SAMYAR_PATH . '/cron.php';
            if( file_exists( $newTemplate ) ) {
                return $newTemplate;
            }

        }

    }



}

new routeCountroller;