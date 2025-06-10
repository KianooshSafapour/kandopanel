<?php
/**
 * Main class to import an Elementor template from outside the plugin itself.
 * @package MerlinWP
 * @subpackage ElementorImporter
 * @since -
 * @see https://github.com/richtabor/MerlinWP
 */

class Merlin_Elementor_Importer {

    /**
     * Stores the state for the import process.
     */
    public $import_flag;

    /**
     * Holds the raw templates passed from the constructor.
     */
    protected $template_data = [];

    /**
     * After the templates have been inserted, this holds the now-parsed templates.
     */
    private $parsed_templates = [];

    /**
     * Additional args.
     */
    protected $args = [];

    /**
     * Sets the template data to be used by importTemplate.
     */
    public function __construct( $templates, $args )
    {
        foreach( $templates as $template_name => $template_url ) {
            $this->template_data[$template_name] = $template_url;
        }
        $this->args = $args;

        if( !class_exists( 'Elementor\Plugin' ) ) {
            return new \WP_Error( 'elementor-not-activated', esc_html__( 'Elementor is not activated.', '_amnth' ) );
        }

        add_action( 'elementor/init', [$this, 'begin_import_process'] );
    }


    /**
     * Manager for all the inner-functions of the class. Asigned every process
     * to a variable for debug purposes.
     */
    public function begin_import_process() {
        $import_templates = $this->import_templates();
        $actions = $this->register_actions();
    }

    /**
     * Loops through all the templates and loads each one. Note: the import is
     * not asynchronous, templates must wait for the last one's import process
     * to finish.
     */
    public function import_templates() {
        foreach( $this->template_data as $name => $url ) {
            /**
             * Checks if the template exists and returns its data or an error.
             */
            $template_state = $this->template_exists( $name, $return_data = True );
            if ( !is_wp_error( $template_state ) ) {
                /**
                 * If the template is valid, add it to the parsed templates for later use.
                 */
                $this->parsed_templates[] = $template_state;

                /**
                 * Sets default page template for each Elementor template loaded.
                 */
                if( $this->args['set_default_template'] ) {
                    $this->set_default_page_template( $template_state['id'] );
                }
                continue;
            }

            $this->import_template( $name,$url );

        }

        $this->import_flag = True;
        //@NOTE: Is this really right to return True here?
        return True;
    }

    /**
     * Registers actions for the importer based on logic.
     */
    public function register_actions() {
        if( $this->import_flag ) {
            /**
             * Registers the action for when it's done with the importing of the template.
             */
            do_action( 'finished_importing_elementor_templates' );
        }
    }
    /**
     * Imports the actual template. Note that this uses Elementor's template manager
     * capabilities.
     * @see Elementor/includes/template-library/sources/local.php::795 - import_template()
     */
    public function import_template( $name,$url )
    {

//        global $_FILES;

//        if( !empty($_FILES) ) {
//            return new \WP_Error( 'elementor-template-global-not-empty', esc_html__( 'Seems the $_FILE global already has a file and I do not wanna conflict.', '_amnth' ) );
//        }

//        $_FILES['file']['tmp_name'] = $url;
//        $_FILES['file']['name'] = $url;

        $fileContent = file_get_contents( $url );
        $fileJson = json_decode( $fileContent, true );


        $import = \Elementor\Plugin::instance()->templates_manager->import_template( [
                'fileData' => base64_encode( $fileContent ),
                'fileName' => $name.'.json',
            ]
        );


//        $import = Elementor\Plugin::instance()->templates_manager->import_template();

//        unset( $_FILES );


        if (is_wp_error($import)) {
            return false;
        }


//        update_post_meta( $import[0]['template_id'], '_elementor_location', 'myCustomLocation' );
//        update_post_meta( $import[0]['template_id'], '_elementor_conditions', [ 'include/general' ] );

        if($name==="home-template"){
            $this->create_home_page();
        }

        if($name==="footer-template"){
            $this->create_footer_page();
        }

        if( !is_wp_error( $import ) ) {
            return True;
        } else {
            return $import;
        }
    }

    public function create_home_page()
    {

// Query WP to get a handle on the template were going to copy
        $query = new WP_Query([
            'post_type' => 'elementor_library',
            'name' => 'home',
            'posts_per_page' => 1
        ]);

// No need to set up The Loop - we just want one post
        $template = $query->found_posts ? $query->posts[0] : false;


        $page = array(
            'post_type' => 'page',
            'post_title' => $template->post_title,
            'post_name' => $template->post_title,
            // Copy the content from the template
            'post_content' => $template->post_content,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
        );

        $pageId = wp_insert_post($page);

        if (is_wp_error($pageId)) {
            return $pageId;
        }

// Set the WordPress template to use
        update_post_meta($pageId, '_wp_page_template', 'elementor_canvas');

// Make sure you don’t have to click on “Edit With Elementor”
//   the first time you access the page
        update_post_meta($pageId, '_elementor_edit_mode', 'builder');

// There are a few other parameters needed to make the page work
        update_post_meta($pageId, '_elementor_template_type', 'wp-page');
        update_post_meta($pageId, '_elementor_version', ELEMENTOR_VERSION);
//        update_post_meta($pageId, '_elementor_pro_version', ELEMENTOR_PRO_VERSION);
        update_post_meta($pageId, '_elementor_css', '');

// Fetch the Elementor settings, data, assets, and controls from
//   the template, so they can be copied to the new page
        $settings = get_post_meta($template->ID, '_elementor_page_settings', true);
        $data = json_decode(get_post_meta($template->ID, '_elementor_data', true), true);
        $assets = get_post_meta($template->ID, '_elementor_page_assets', true);
        $controls = get_post_meta($template->ID, '_elementor_controls_usage', true);

// Copy the Elementor setting, data, assets, and controls into
//   the new page
        update_post_meta($pageId, '_elementor_page_settings', $settings);
        update_post_meta($pageId, '_elementor_data', $data);
        update_post_meta($pageId, '_elementor_page_assets', $assets);
        update_post_meta($pageId, '_elementor_controls_usage', $controls);


        update_post_meta($pageId, '_wp_page_template', "elementor_header_footer");



        // تنظیم برگه مربوط به المنتور به عنوان صفحه اصلی
        update_option('page_on_front', $pageId);
        update_option('show_on_front', 'page');
    }


    public function create_footer_page()
    {

// Query WP to get a handle on the template were going to copy
        $query = new WP_Query([
            'post_type' => 'elementor_library',
            'name' => 'footer',
            'posts_per_page' => 1
        ]);

// No need to set up The Loop - we just want one post
        $template = $query->found_posts ? $query->posts[0] : false;


        $page = array(
            'post_type' => 'kandofooter',
            'post_title' => $template->post_title,
            'post_name' => $template->post_title,
            // Copy the content from the template
            'post_content' => $template->post_content,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
        );

        $pageId = wp_insert_post($page);

        if (is_wp_error($pageId)) {
            return $pageId;
        }

// Set the WordPress template to use
        update_post_meta($pageId, '_wp_page_template', 'elementor_canvas');

// Make sure you don’t have to click on “Edit With Elementor”
//   the first time you access the page
        update_post_meta($pageId, '_elementor_edit_mode', 'builder');

// There are a few other parameters needed to make the page work
        update_post_meta($pageId, '_elementor_template_type', 'wp-page');
        update_post_meta($pageId, '_elementor_version', ELEMENTOR_VERSION);
//        update_post_meta($pageId, '_elementor_pro_version', ELEMENTOR_PRO_VERSION);
        update_post_meta($pageId, '_elementor_css', '');

// Fetch the Elementor settings, data, assets, and controls from
//   the template, so they can be copied to the new page
        $settings = get_post_meta($template->ID, '_elementor_page_settings', true);
        $data = json_decode(get_post_meta($template->ID, '_elementor_data', true), true);
        $assets = get_post_meta($template->ID, '_elementor_page_assets', true);
        $controls = get_post_meta($template->ID, '_elementor_controls_usage', true);

// Copy the Elementor setting, data, assets, and controls into
//   the new page
        update_post_meta($pageId, '_elementor_page_settings', $settings);
        update_post_meta($pageId, '_elementor_data', $data);
        update_post_meta($pageId, '_elementor_page_assets', $assets);
        update_post_meta($pageId, '_elementor_controls_usage', $controls);


        update_post_meta($pageId, '_wp_page_template', "elementor_header_footer");



        //در تنظیمات قالب هم فوتر رو درج میکنیم
        $samyar_options = get_option( 'samyar_options' );
        $newOptions = array();
        if (!is_null($samyar_options)) {

            $newOptions['samyar-footer'] = $pageId;
            update_option('samyar_options', $newOptions);

        }
    }
    /**
     * Checks if the template we're trying to insert already exists.
     * @return WP_Error elementor-template-already-loaded - template already exists / loaded, will bail.
     * @param $return_data - Allows for return of the data of said template if the template exists.
     */
    public function template_exists( $template_name )
    {

        $posts = get_posts(
            [
                'name' => $template_name,
                'post_type' => 'elementor_library',
                'post_status' => 'publish'
            ]
        );

        if( $posts ) {
            return [
                'name' => $posts[0]->post_name,
                'id' => $posts[0]->ID
            ];
        }

        return new \WP_Error( 'elementor-template-already-loaded', esc_html__( 'This template has already been loaded.', '_amnth' ) );
    }

    /**
     * Sets the default page template (note, this is not the template we're loading, just
     * the layout of the page that we pre-defined in a file).
     * @since -
     */
    public function set_default_page_template( $id )
    {
        update_post_meta( $id, '_wp_page_template', $this->args['default_page_template'] );
    }

}

/**
 * Initializes the Importer. DON'T EVER FUCKING INITIALIZE THE SAME CLASS IN THE SAME FILE. JUST SHOWING AN EXAMPLE.
 */

//$importer = new Elementor_Template_Importer(
//    $templates = [
//        'new-template' => get_parent_theme_file_path() . '/Assets/elementor_templates/elementor-166-2018-04-17.json',
//        'new-template-2' => get_parent_theme_file_path() . '/Assets/elementor_templates/elementor-166-2018-04-17-2.json',
//    ],
//    $args = [
//        'set_default_template' => True,
//        'default_page_template' => 'templates/full-width-template.php',
//    ]
//);