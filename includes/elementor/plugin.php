<?php
namespace kandoElementor;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
//		wp_register_script( 'download-after-info-elemetns', plugins_url( '/assets/js/dai-elements.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_style( 'kando-elements-css',  SAMYAR_DIR_CSS . '/elements.css',[],SAMYAR_THEME_VER);
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/Pack.php' );
		require_once( __DIR__ . '/widgets/Pack2.php' );
		require_once( __DIR__ . '/widgets/posts.php' );
		require_once( __DIR__ . '/widgets/posts2.php' );

	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\kandoPack());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\kandoPack2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\kandoPosts());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\kandoPosts2());



	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );


        add_action( 'elementor/elements/categories_registered', [ $this, 'add_fre_elementor_widget_categories' ]);
	}


    /**
     * add category freelanceengin plus elements
     * @param $elements_manager
     */
    public function add_fre_elementor_widget_categories($elements_manager) {
//	    print_r($elements_manager);

        \Elementor\Plugin::instance()->elements_manager->add_category(
            'kando-category',
            [
                'title' => "المان های کندو پنل",
                'icon' => 'eicon-price-table',
            ]
        );

    }




}

// Instantiate Plugin Class
Plugin::instance();
