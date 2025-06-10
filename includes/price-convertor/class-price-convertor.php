<?php
// Exit if accessed directly.
use samyar\priceController;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Merlin.
 */
class priceConvertor
{
    /**
     * Top level admin page.
     *
     * @var string $price_convertor_url
     */

    private static $instance = null;
    /**
     * Current theme.
     *
     * @var object WP_Theme
     */
    protected $theme;

    /**
     * Current step.
     *
     * @var string
     */
    protected $step = '';

    /**
     * Steps.
     *
     * @var    array
     */
    protected $steps = array();

    /**
     * TGMPA instance.
     *
     * @var    object
     */
    protected $tgmpa;

    /**
     * Importer.
     *
     * @var    array
     */
    protected $importer;

    /**
     * WP Hook class.
     *
     * @var Merlin_Hooks
     */
    protected $hooks;

    /**
     * Holds the verified import files.
     *
     * @var array
     */
    public $import_files;

    /**
     * The base import file name.
     *
     * @var string
     */
    public $import_file_base_name;

    /**
     * Helper.
     *
     * @var    array
     */
    protected $helper;

    /**
     * Updater.
     *
     * @var    array
     */
    protected $updater;

    /**
     * The text string array.
     *
     * @var array $strings
     */
    protected $strings = null;

    /**
     * The base path where Merlin is located.
     *
     * @var array $strings
     */
    protected $base_path = null;

    /**
     * The base url where Merlin is located.
     *
     * @var array $strings
     */
    protected $base_url = null;

    /**
     * The location where Merlin is located within the theme or plugin.
     *
     * @var string $directory
     */
    protected $directory = null;

    /**
     * Top level admin page.
     *
     * @var string $price_convertor_url
     */
    protected $price_convertor_url = null;

    /**
     * The wp-admin parent page slug for the admin menu item.
     *
     * @var string $parent_slug
     */
    protected $parent_slug = null;

    /**
     * The capability required for this menu to be displayed to the user.
     *
     * @var string $capability
     */
    protected $capability = null;

    /**
     * The URL for the "Learn more about child themes" link.
     *
     * @var string $child_action_btn_url
     */
    protected $child_action_btn_url = null;

    /**
     * Turn on dev mode if you're developing.
     *
     * @var string $dev_mode
     */
    protected $dev_mode = false;

    /**
     * Ignore.
     *
     * @var string $ignore
     */
    public $ignore = null;

    /**
     * The object with logging functionality.
     *
     * @var Logger $logger
     */
    public $logger;

    /**
     * Setup plugin version.
     *
     * @access private
     * @return void
     * @since 1.0
     */
    private function version()
    {

        if (!defined('PRICE_CONVERTOR_VERSION')) {
            define('PRICE_CONVERTOR_VERSION', '1.0.0');
        }
    }

    function __construct($config = array(), $strings = array())
    {

        $this->version();


        $config = wp_parse_args(
            $config, array(
                'base_path' => get_parent_theme_file_path(),
                'base_url' => get_parent_theme_file_uri(),
                'directory' => 'includes/price-convertor',
                'price_convertor_url' => 'kandopanel-price-convertor',
                'parent_slug' => 'samyar-settings',
                'capability' => 'manage_options',
                'child_action_btn_url' => '',
                'dev_mode' => true,
                'ready_big_button_url' => home_url('/'),
            )
        );


        // Set config arguments.
        $this->base_path = $config['base_path'];
        $this->base_url = $config['base_url'];
        $this->directory = $config['directory'];
        $this->price_convertor_url = $config['price_convertor_url'];
        $this->parent_slug = $config['parent_slug'];
        $this->capability = $config['capability'];
        $this->child_action_btn_url = $config['child_action_btn_url'];
        $this->dev_mode = $config['dev_mode'];
        $this->ready_big_button_url = $config['ready_big_button_url'];


        // Strings passed in from the config file.
        $this->strings = array(
            'admin-menu' => __('Price Settings', SAMYAR_TEXT_DOMAIN),
            'title%s%s%s%s' => esc_html__('%1$s%2$s Price Settings: %3$s%4$s', SAMYAR_TEXT_DOMAIN),
        );

        // Retrieve a WP_Theme object.
        $this->theme = wp_get_theme();
        $subject =  $this->theme->template ?? ''; // اگر $subject null باشد، رشته خالی جایگزین می‌شود
        $this->slug = strtolower(preg_replace('#[^a-zA-Z]#', '',$subject));

        // Set the ignore option.
        $this->ignore = $this->slug . '_ignore';

        // Is Dev Mode turned on?
        if (true !== $this->dev_mode) {

            // Has this theme been setup yet?
            $already_setup = get_option('price_convertor_' . $this->slug . '_completed');

            // Return if Merlin has already completed it's setup.
            if ($already_setup) {
                return;
            }
        }

        add_action('admin_init', array($this, 'redirect'), 30);
//        add_action('admin_init', array($this, 'steps'), 30, 0);
        add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        add_action('admin_init', array($this, 'admin_page'), 30, 0);
        add_action('admin_init', array($this, 'ignore'), 5);


        add_action('wp_ajax_price_convertor_save_settings', array($this, 'save_settings'));
    }


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new priceConvertor();
        }

        return self::$instance;
    }

    /**
     * Redirection transient.
     */
    public function redirect()
    {

        $key = $this->theme->template . '_price_convertor_redirect';

        //اگر تنظیمات قبل انجام شده بود و تا حالا تنظیمات تبدیل مبلغ ها انجام نشده بود به صفحه هدایتش کن
        if (!get_option($key) && get_option('samyar_options')) {
            update_option($key, 1);

            wp_safe_redirect(menu_page_url($this->price_convertor_url, false));

            exit;
        }


    }


    /**
     * Add the admin menu item, under Appearance.
     */
    public function add_admin_menu()
    {

        // Strings passed in from the config file.
        $strings = $this->strings;

        $this->hook_suffix = add_submenu_page(
            $this->parent_slug,                             // Parent slug
            __('Price Settings', SAMYAR_TEXT_DOMAIN),              // Page title
            __('Price Settings', SAMYAR_TEXT_DOMAIN),              // Menu title
            $this->capability,                             // Capability
            $this->price_convertor_url,                    // Menu slug
            array($this, 'admin_page')                     // Callback function
        );

    }


    /**
     * Add the admin page.
     */
    public function admin_page()
    {


        // Do not proceed, if we're not on the right page.
        if (empty($_GET['page']) || $this->price_convertor_url !== $_GET['page']) {
            return;
        }

        if (ob_get_length()) {
            ob_end_clean();
        }


        // Enqueue styles.
//        wp_enqueue_style('price-convertor', trailingslashit($this->base_url) . $this->directory . '/assets/css/price-convertor' . $suffix . '.css', array('wp-admin'), PRICE_CONVERTOR_VERSION);
        wp_enqueue_style('price-convertor-fonts', trailingslashit($this->base_url) . $this->directory . '/assets/fonts/YekanBakh/fonts.css', array('wp-admin'), PRICE_CONVERTOR_VERSION);
        if(is_rtl()){
            wp_enqueue_style('price-convertor-style-bundle', trailingslashit($this->base_url) . $this->directory . '/assets/css/style.bundle.rtl.css', array('wp-admin'), PRICE_CONVERTOR_VERSION);
        }else{
            wp_enqueue_style('price-convertor-style-bundle', trailingslashit($this->base_url) . $this->directory . '/assets/css/style.bundle.css', array('wp-admin'), PRICE_CONVERTOR_VERSION);
        }

        wp_enqueue_style('price-convertor-plugins-bundle', trailingslashit($this->base_url) . $this->directory . '/assets/css/plugins.bundle.rtl.css', array('wp-admin'), PRICE_CONVERTOR_VERSION);

        // Enqueue javascript.
//        wp_enqueue_script('price-convertor', trailingslashit($this->base_url) . $this->directory . '/assets/js/price-convertor' . $suffix . '.js', array('jquery-core'), PRICE_CONVERTOR_VERSION);
        wp_enqueue_script('price-convertor-plugin-bundle', trailingslashit($this->base_url) . $this->directory . '/assets/js/plugins.bundle.js', array('jquery-core'), PRICE_CONVERTOR_VERSION);
        wp_enqueue_script('price-convertor-scripts-bundle', trailingslashit($this->base_url) . $this->directory . '/assets/js/scripts.bundle.js', array('jquery-core'), PRICE_CONVERTOR_VERSION);
        wp_enqueue_script('price-convertor-create-account', trailingslashit($this->base_url) . $this->directory . '/assets/js/save-price-settings.js', array('jquery-core'), PRICE_CONVERTOR_VERSION);

        $texts = array(
            'something_went_wrong' => esc_html__('Something went wrong. Please refresh the page and try again!', SAMYAR_TEXT_DOMAIN),
        );


        wp_localize_script(
            'price-convertor-create-account', 'price_convertor_params', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'wpnonce' => wp_create_nonce('price_convertor_nonce'),
                'texts' => $texts,
            )
        );


        ob_start();

        /**
         * Start the actual page content.
         */
        $this->header(); ?>

        <?php
        $this->welcome();
        ?>

        <?php $this->footer(); ?>

        <?php
        exit;
    }

    /**
     * Output the header.
     */
    protected function header()
    {

        // Strings passed in from the config file.
        $strings = $this->strings;
        syncUsdFromApi();
        ?>

        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
        <head>
            <meta name="viewport" content="width=device-width"/>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <?php printf( '<title>%s</title>', esc_html( sprintf( $strings['title%s%s%s%s'], '', '', $this->theme->name, '' ) )); ?>
            <?php do_action('admin_print_styles'); ?>
            <?php do_action('admin_print_scripts'); ?>
            <?php do_action('admin_head'); ?>
            <style>
                input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea {
                    border: 1px solid var(--bs-gray-300);
                }

                input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus {
                    border-color: var(--bs-gray-400);
                    box-shadow: unset;
                    outline: 1px solid transparent

                }

                input[type=checkbox], input[type=radio] {
                    background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23ffffff'/%3e%3c/svg%3e") 100% 50% / auto padding-box border-box rgb(241, 241, 244) scroll no-repeat;
                }

                input[type=checkbox]:checked::before {
                    content: unset;
                }

                .currency-container .IRT, .currency-container .USD {
                    display: none;
                }

                #kt_app_root.IRT .currency-container .IRT {
                    display: block;
                }

                #kt_app_root.USD .currency-container .USD {
                    display: block;
                }

                .round-price.IRT {
                    display: none;
                }

                .IRT .round-price.IRT {
                    display: block;
                }
            </style>
        </head>
        <body id="kt_body" class="app-blank">
        <script>
            var defaultThemeMode = "light";
            var themeMode = "light";

            if (document.documentElement) {
                <!--
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if ( localStorage.getItem("data-bs-theme") !== null ) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }
                } if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                -->
                document.documentElement.setAttribute("data-bs-theme", "light");
            }</script>

        <?php
    }


    /**
     * Output the footer.
     */
    protected function footer()
    {
        ?>
        </body>
        <?php do_action('admin_footer'); ?>
        <?php do_action('admin_print_footer_scripts'); ?>
        </html>
        <?php
    }

    /**
     * Introduction step
     */
    protected function welcome()
    {
        // دریافت مقدار ذخیره شده از دیتابیس
        $site_currency = get_option('site_currency', 'IRT'); // مقدار پیش‌فرض IRT
        ?>

        <div class="d-flex flex-column flex-root <?= $site_currency ?>" id="kt_app_root">
            <!--begin::Authentication - Multi-steps-->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid stepper stepper-pills stepper-column stepper-multistep"
                 id="kt_create_account_stepper">
                <!--begin::Aside-->
                <div class="d-flex flex-column flex-lg-row-auto w-lg-350px w-xl-500px">
                    <div class="d-flex flex-column position-lg-fixed top-0 bottom-0 w-lg-350px w-xl-500px scroll-y bgi-size-cover bgi-position-center"
                         style="background-image: url(<?php echo trailingslashit($this->base_url) . $this->directory . '/assets/images/auth-bg.png' ?>">
                        <!--begin::Header-->
                        <div class="d-flex flex-center py-5 py-lg-5 mt-lg-5">
                            <!--begin::Logo-->
                            <!--
                            <a href="index.html">
                                <img alt="Logo" src="assets/media/logos/custom-1.png" class="h-70px" />
                            </a>
                            -->
                            <!--end::Logo-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="d-flex flex-row-fluid justify-content-center p-10">
                            <!--begin::Nav-->
                            <div class="stepper-nav">
                                <!--begin::Step 1-->
                                <div class="stepper-item current" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon rounded-3">
                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">1</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title fs-2"><?php _e('Base Currency Selection', SAMYAR_TEXT_DOMAIN); ?></h3>
                                            <div class="stepper-desc fw-normal"><?php _e('Select the currency to be stored in the database', SAMYAR_TEXT_DOMAIN); ?></div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon rounded-3">
                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">2</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title fs-2"><?php _e('Currency Settings', SAMYAR_TEXT_DOMAIN); ?></h3>
                                            <div class="stepper-desc fw-normal"><?php _e('Set the exchange rates for currencies', SAMYAR_TEXT_DOMAIN); ?></div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">3</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title fs-2"><?php _e('Profit Configuration', SAMYAR_TEXT_DOMAIN); ?></h3>
                                            <div class="stepper-desc fw-normal"><?php _e('Set the profit amount', SAMYAR_TEXT_DOMAIN); ?></div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">4</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title"><?php _e('Provider Profit', SAMYAR_TEXT_DOMAIN); ?></h3>
                                            <div class="stepper-desc fw-normal"><?php _e('Set the profit for the provider', SAMYAR_TEXT_DOMAIN); ?></div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">5</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title"><?php _e('Price Calculation', SAMYAR_TEXT_DOMAIN); ?></h3>
                                            <div class="stepper-desc fw-normal"><?php _e('Calculates the prices of services', SAMYAR_TEXT_DOMAIN); ?></div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 5-->
                                <!--begin::Step 6-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">6</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title"><?php _e('Completed', SAMYAR_TEXT_DOMAIN); ?></h3>
                                            <div class="stepper-desc fw-normal"><?php _e('Settings have been saved successfully', SAMYAR_TEXT_DOMAIN); ?></div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 6-->
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="d-flex flex-center flex-wrap px-5 py-10">
                            <!--begin::Links-->
                            <div class="d-flex fw-normal">
                                <a href="<?= home_url() ?>" class="text-success px-5" target="_blank"><?php _e('Home Page', SAMYAR_TEXT_DOMAIN); ?></a>
                                <a href="<?= home_url('wp-admin') ?>" class="text-success px-5" target="_blank"><?php _e('Return to Admin', SAMYAR_TEXT_DOMAIN); ?></a>
                                <a href="https://wp-bazar.com/kandopanel-document/" class="text-success px-5" target="_blank"><?php _e('KandoPanel Documentation', SAMYAR_TEXT_DOMAIN); ?></a>
                            </div>
                            <!--end::Links-->
                        </div>
                        <!--end::Footer-->
                    </div>
                </div>
                <!--begin::Aside-->
                <!--begin::Body-->
                <div class="d-flex flex-column flex-lg-row-fluid py-10">
                    <!--begin::Content-->
                    <div class="flex-center flex-column flex-column-fluid">
                        <!--begin::Wrapper-->
                        <div class="w-lg-650px w-xl-900px p-10 p-lg-15 mx-auto">
                            <!--begin::Form-->
                            <form class="my-auto pb-5" novalidate="novalidate" id="kando_price_settings_form">
                                <!--begin::Step 1-->
                                <div class="current" data-kt-stepper-element="content">
                                    <script>
                                        jQuery(document).ready(function ($) {
                                            $("input[name='site_currency']").on("change", function () {
                                                const selectedValue = $(this).val(); // مقدار انتخاب‌شده
                                                const appRoot = $("#kt_app_root");

                                                if (appRoot.length) {
                                                    // حذف تمام کلاس‌های قبلی مرتبط با ارز
                                                    appRoot.removeClass("IRT USD");
                                                    // اضافه کردن کلاس جدید
                                                    appRoot.addClass(selectedValue);
                                                }
                                            });

                                        });

                                    </script>

                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold d-flex align-items-center text-gray-900"><?php _e('Base Currency Selection', SAMYAR_TEXT_DOMAIN); ?></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6"><?php _e('Service prices will be saved in this currency on the site', SAMYAR_TEXT_DOMAIN); ?></div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-6">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="btn-check"
                                                           name="site_currency" <?php checked($site_currency, 'IRT'); ?>
                                                           value="IRT" checked="checked"
                                                           id="kt_create_account_form_account_type_personal"/>
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center mb-10"
                                                           for="kt_create_account_form_account_type_personal">
                                                        <style>
                                                            .coin {
                                                                width: 70px;
                                                                height: 70px;
                                                                background: radial-gradient(circle, #ffd700, #e6b800);
                                                                border-radius: 50%;
                                                                border: 3px solid #b8860b;
                                                                display: flex;
                                                                justify-content: center;
                                                                align-items: center;
                                                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2),
                                                                inset 0 2px 4px rgba(255, 255, 255, 0.5);
                                                                position: relative;
                                                            }

                                                            .coin::before {
                                                                content: "";
                                                                position: absolute;
                                                                width: 60px;
                                                                height: 60px;
                                                                border: 2px solid rgba(255, 255, 255, 0.8);
                                                                border-radius: 50%;
                                                            }

                                                            .coin::after {
                                                                content: "";
                                                                position: absolute;
                                                                width: 50px;
                                                                height: 50px;
                                                                border: 2px solid rgba(0, 0, 0, 0.1);
                                                                border-radius: 50%;
                                                            }

                                                            .coin-text {
                                                                font-family: YekanBakh, Tahoma, sans-serif;
                                                                font-weight: 500;
                                                                font-size: 18px;
                                                                color: #8b4513;
                                                                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
                                                            }
                                                        </style>
                                                        <div class="coin me-5">
                                                            <div class="coin-text">تومان</div>
                                                        </div>
                                                        <!--
                                                        <i class="fs-3x me-5 coin">IRT</i>
                                                        -->
                                                        <!--begin::Info-->
                                                        <span class="d-block fw-semibold text-start">
    <span class="text-gray-900 fw-bold d-block fs-4 mb-2"><?php _e('Toman', SAMYAR_TEXT_DOMAIN); ?></span>
    <span class="text-muted fw-semibold fs-6"><?php _e('Save in Toman', SAMYAR_TEXT_DOMAIN); ?></span>
</span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-lg-6">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="btn-check"
                                                           name="site_currency" <?php checked($site_currency, 'USD'); ?>
                                                           value="USD"
                                                           id="kt_create_account_form_account_type_corporate"/>
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center"
                                                           for="kt_create_account_form_account_type_corporate">
                                                        <div class="coin me-5">
                                                            <div class="coin-text">$</div>
                                                        </div>
                                                        <!--begin::Info-->
                                                        <span class="d-block fw-semibold text-start">
    <span class="text-gray-900 fw-bold d-block fs-4 mb-2"><?php _e('Dollar', SAMYAR_TEXT_DOMAIN); ?></span>
    <span class="text-muted fw-semibold fs-6"><?php _e('Save in Dollar', SAMYAR_TEXT_DOMAIN); ?></span>
</span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900"><?php _e('Currency Settings', SAMYAR_TEXT_DOMAIN); ?></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6"><?php _e('Configure currency settings', SAMYAR_TEXT_DOMAIN); ?></div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <div class="table-responsive">
                                                <table class="table table-rounded table-striped border gy-7 gs-7">
                                                    <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                        <th class="min-w-75px"><?php _e('Currency Name', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th class="min-w-125px"><?php _e('Decimals', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th class="min-w-300px"><?php _e('Value', SAMYAR_TEXT_DOMAIN); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $args = array(
                                                        'post_type' => 'kando_currency',
                                                        'posts_per_page' => -1 // برای دریافت همه پست‌ها
                                                    );

                                                    $query = new WP_Query($args);

                                                    $currencies = array();

                                                    if ($query->have_posts()) {
                                                        while ($query->have_posts()) {
                                                            $query->the_post();
                                                            $post_id = get_the_ID();
                                                            $currency_code = get_post_meta($post_id, 'currency_code', true);
                                                            $meta_values = get_post_meta($post_id);

                                                            if ($currency_code) {
                                                                // حذف لایه اضافی آرایه
                                                                foreach ($meta_values as $key => $value) {
                                                                    if (is_array($value) && count($value) == 1) {
                                                                        $meta_values[$key] = $value[0];
                                                                    }
                                                                }

                                                                // چک کردن وضعیت currency_status
                                                                if (isset($meta_values['currency_status']) && $meta_values['currency_status']) {
                                                                    $currencies[$post_id] = $meta_values;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    // ریست کردن کوئری
                                                    wp_reset_postdata();


                                                    ?>
                                                    <?php foreach ($currencies as $post_id => $currency) {

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="my-3 text-center">
                                                                    <?= $currency['symbol'] ?>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <select class="form-select"
                                                                        name="decimal_place[<?= $post_id ?>][<?= $currency['currency_code'] ?>]"
                                                                        aria-label="Select example">
                                                                    <option value="0" <?php selected($currency['decimal_place'], 0); ?>>
                                                                        0
                                                                    </option>
                                                                    <option value="1" <?php selected($currency['decimal_place'], 1); ?>>
                                                                        0.0
                                                                    </option>
                                                                    <option value="2" <?php selected($currency['decimal_place'], 2); ?>>
                                                                        0.00
                                                                    </option>
                                                                    <option value="3" <?php selected($currency['decimal_place'], 3); ?>>
                                                                        0.000
                                                                    </option>
                                                                    <option value="4" <?php selected($currency['decimal_place'], 4); ?>>
                                                                        0.0000
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>


                                                                <?php if ($currency['currency_code'] === "IRT") { ?>
                                                                    <div class="row">
                                                                        <div class="col-lg-7">
                                                                            <!--begin::Input group-->
                                                                            <div class="input-group mb-5">
                                                                                <span class="input-group-text"><?php _e('1 Dollar is equal to', SAMYAR_TEXT_DOMAIN); ?></span>
                                                                                <input type="text" class="form-control"
                                                                                       data-bs-toggle="tooltip"
                                                                                       data-bs-html="true"
                                                                                       title="<?php _e('Updated from NobiTeX', SAMYAR_TEXT_DOMAIN); ?><br><b><?php echo date_i18n('Y-m-d H:i:s', strtotime(get_option('last_usd_update_time'))); ?></b>"
                                                                                       dir="ltr"
                                                                                       value="<?php echo $currency['value_currency']; ?>"
                                                                                       name="value_currency[<?php echo $post_id; ?>][<?php echo $currency['currency_code']; ?>]"
                                                                                       aria-label=""/>
                                                                                <span class="input-group-text"><?= $currency['symbol'] ?></span>
                                                                            </div>
                                                                            <!--end::Input group-->
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <div class="my-3 text-center">


                                                                                <i class="ki-duotone ki-plus-square fs-2x">
                                                                                    <span class="path1"></span>
                                                                                    <span class="path2"></span>
                                                                                    <span class="path3"></span>
                                                                                </i>


                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="input-group mb-5">
                                                                                <input type="text" class="form-control"
                                                                                       dir="ltr"
                                                                                       placeholder="<?php _e('To be added', SAMYAR_TEXT_DOMAIN); ?>"
                                                                                       value="<?php echo esc_attr(get_option('usd_rate_fix', 0)); ?>"
                                                                                       name="usd_rate_fix"
                                                                                       aria-label=""/>
                                                                                <span class="input-group-text"><?= $currency['symbol'] ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <!--begin::Input group-->
                                                                    <div class="input-group mb-5">
                                                                        <span class="input-group-text"><?php _e('1 Dollar is equal to', SAMYAR_TEXT_DOMAIN); ?></span>
                                                                        <input type="text" class="form-control"
                                                                               dir="ltr"
                                                                               value="<?= $currency['value_currency'] ?>"
                                                                               name="value_currency[<?= $post_id ?>][<?= $currency['currency_code'] ?>]"
                                                                               aria-label=""/>
                                                                        <span class="input-group-text"><?= $currency['symbol'] ?></span>
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                <?php } ?>


                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-12">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900"><?php _e('Set the Profit', SAMYAR_TEXT_DOMAIN); ?></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6"><?php _e('Enter the general and representative profit rates in percentage', SAMYAR_TEXT_DOMAIN); ?></div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <div class="table-responsive">

                                                <table class="table table-rounded table-striped border gy-7 gs-7">
                                                    <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                        <th class="min-w-75px"><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th class="min-w-200px"><?php _e('Fixed Rate', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th></th>
                                                        <th class="min-w-200px"><?php _e('Profit Percentage', SAMYAR_TEXT_DOMAIN); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <td>
                                                            <div class="my-3 text-center">
                                                                <?php _e('General Profit', SAMYAR_TEXT_DOMAIN); ?>
                                                            </div>
                                                        </td>
                                                        <td>

                                                            <!--begin::Input group-->
                                                            <div class="input-group mb-5">

                                                                <input type="number" class="form-control"
                                                                       name="public-profit-fix"
                                                                       value="<?php echo esc_attr(get_option('public_profit_fix')); ?>"
                                                                       aria-label=""/>
                                                                <div class="input-group-text">
                                                                    <div class="currency-container">
                                                                        <span class="USD"><?php _e('Dollar', SAMYAR_TEXT_DOMAIN); ?></span>
                                                                        <span class="IRT"><?php _e('Toman', SAMYAR_TEXT_DOMAIN); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Input group-->


                                                        </td>
                                                        <td>
                                                            <div class="my-3 text-center">


                                                                <i class="ki-duotone ki-plus-square fs-2x">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>


                                                            </div>

                                                        </td>
                                                        <td>
                                                            <!--begin::Input group-->
                                                            <div class="input-group mb-5">
                                                                    <span class="input-group-text">
        <i class="ki-duotone ki-percentage fs-2x">
 <span class="path1"></span>
 <span class="path2"></span>
</i>

    </span>
                                                                <input type="number" min="0" max="100"
                                                                       class="form-control" name="public-profit-percent"
                                                                       value="<?php echo esc_attr(get_option('public_profit_percent')); ?>"
                                                                       aria-label=""/>

                                                            </div>
                                                            <!--end::Input group-->

                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="table-responsive">

                                                <table class="table table-rounded table-striped border gy-7 gs-7">
                                                    <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                        <th class="min-w-75px"><?php _e('Package Title', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th class="min-w-125px"><?php _e('Discount Percentage', SAMYAR_TEXT_DOMAIN); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <td>
                                                            <div class="my-3 text-center">
                                                                <?php _e('Golden', SAMYAR_TEXT_DOMAIN); ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!--begin::Input group-->
                                                            <div class="input-group mb-5">
                                                                    <span class="input-group-text">
        <i class="ki-duotone ki-percentage fs-2x">
 <span class="path1"></span>
 <span class="path2"></span>
</i>

    </span>
                                                                <input type="number" min="0" max="100"
                                                                       class="form-control" name="gold_discount"
                                                                       value="<?php echo esc_attr(get_option('gold_discount')); ?>"
                                                                       placeholder="<?php _e('If you do not want it to be active, set it to 0', SAMYAR_TEXT_DOMAIN); ?>"
                                                                       aria-label=""/>
                                                                <span class="input-group-text"><?php _e('Discount', SAMYAR_TEXT_DOMAIN); ?></span>
                                                            </div>
                                                            <!--end::Input group-->

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="my-3 text-center">
                                                                <?php _e('Silver', SAMYAR_TEXT_DOMAIN); ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!--begin::Input group-->
                                                            <div class="input-group mb-5">
                                                                   <span class="input-group-text">
        <i class="ki-duotone ki-percentage fs-2x">
 <span class="path1"></span>
 <span class="path2"></span>
</i>

    </span>
                                                                <input type="number" min="0" max="100"
                                                                       class="form-control" name="silver_discount"
                                                                       value="<?php echo esc_attr(get_option('silver_discount')); ?>"
                                                                       placeholder="<?php _e('If you do not want it to be active, set it to 0', SAMYAR_TEXT_DOMAIN); ?>"
                                                                       aria-label=""/>
                                                                <span class="input-group-text"><?php _e('Discount', SAMYAR_TEXT_DOMAIN); ?></span>
                                                            </div>
                                                            <!--end::Input group-->
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="my-3 text-center">
                                                                <?php _e('Bronze', SAMYAR_TEXT_DOMAIN); ?>
                                                            </div>
                                                        </td>
                                                        <td>

                                                            <!--begin::Input group-->
                                                            <div class="input-group mb-5">
    <span class="input-group-text">
        <i class="ki-duotone ki-percentage fs-2x">
 <span class="path1"></span>
 <span class="path2"></span>
</i>

    </span>
                                                                <input type="number" class="form-control"
                                                                       min="0" max="100" name="bronze_discount"
                                                                       value="<?php echo esc_attr(get_option('bronze_discount')); ?>"
                                                                       placeholder="<?php _e('If you do not want it to be active, set it to 0', SAMYAR_TEXT_DOMAIN); ?>" />
                                                                <span class="input-group-text"><?php _e('Discount', SAMYAR_TEXT_DOMAIN); ?></span>
                                                            </div>
                                                            <!--end::Input group-->


                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900"><?php _e('Provider Profit', SAMYAR_TEXT_DOMAIN); ?></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6"><?php _e('If you wish, you can set a custom profit for each provider.', SAMYAR_TEXT_DOMAIN); ?></div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Input group-->
                                        <div class="row mb-10 my-5">
                                            <div class="scroll h-500px px-5 table-responsive">
                                                <table class="table table-rounded table-striped border gy-7 gs-7">
                                                    <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th class="min-w-200px"><?php _e('Fixed Rate', SAMYAR_TEXT_DOMAIN); ?></th>
                                                        <th></th>
                                                        <th class="min-w-200px"><?php _e('Profit Percentage', SAMYAR_TEXT_DOMAIN); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php
                                                    // دریافت اطلاعات از دیتابیس برای همه providers فعال
                                                    $providers = \samyar\Provider::where(['status' => 1]);
                                                    foreach ($providers as $provider) {

                                                        // گرفتن مقدار نرخ ثابت و درصد سود از دیتابیس
                                                        $profit_fix = $provider->custom_rate_fix;
                                                        $profit_percent = $provider->custom_rate;

                                                        // قالب‌بندی مقادیر برای نمایش (برای نمایش عدد صحیح یا اعشاری)
                                                        $formatted_profit_fix = number_format($profit_fix, 4, '.', '');
                                                        $formatted_profit_percent = number_format($profit_percent, 4, '.', '');

                                                        // حذف صفرهای اضافی از اعشار
                                                        $formatted_profit_fix = rtrim(rtrim($formatted_profit_fix, '0'), '.');
                                                        $formatted_profit_percent = rtrim(rtrim($formatted_profit_percent, '0'), '.');


                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="my-3 text-center">
                                                                    <?= $provider->name ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <!--begin::Input group-->
                                                                <div class="input-group mb-5">

                                                                    <input type="number" class="form-control"
                                                                           name="provider-profit-fix[<?= $provider->id ?>]"
                                                                           value="<?= $formatted_profit_fix ? $formatted_profit_fix : '' ?>"
                                                                           aria-label=""/>
                                                                    <span class="input-group-text">
                                                               <div class="currency-container">
<span class="USD"><?php _e('Dollar', SAMYAR_TEXT_DOMAIN); ?></span>
<span class="IRT"><?php _e('Toman', SAMYAR_TEXT_DOMAIN); ?></span>
                                                                    </div>
                                                                    </span>
                                                                </div>
                                                                <!--end::Input group-->

                                                            </td>
                                                            <td>


                                                                <div class="my-3 text-center">
                                                                    <i class="ki-duotone ki-plus-square fs-2x">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                    </i>


                                                                </div>


                                                            </td>
                                                            <td>
                                                                <!--begin::Input group-->
                                                                <div class="input-group mb-5">
    <span class="input-group-text">
        <i class="ki-duotone ki-percentage fs-2x">
 <span class="path1"></span>
 <span class="path2"></span>
</i>

    </span>
                                                                    <input type="number" class="form-control"
                                                                           type="number"
                                                                           min="0" max="100"
                                                                           name="provider-profit-percent[<?= $provider->id ?>]"
                                                                           value="<?= $formatted_profit_percent ? $formatted_profit_percent : '' ?>"
                                                                           placeholder=""/>
                                                                    <span class="input-group-text"><?php _e('Profit', SAMYAR_TEXT_DOMAIN); ?></span>
                                                                </div>
                                                                <!--end::Input group-->

                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div class="convertor-step" data-kt-stepper-element="content">
                                    <script>
                                        jQuery(document).ready(function ($) {
                                            // تابع برای کنترل نمایش بر اساس وضعیت چک‌باکس
                                            function toggleRoundPriceOptions() {
                                                if ($("input[name='round-price']").is(":checked")) {
                                                    $("#select_round_price_type").css('display', 'flex');
                                                } else {
                                                    $("#select_round_price_type").css('display', 'none');
                                                }
                                            }

                                            // اعمال وضعیت اولیه هنگام بارگذاری صفحه
                                            toggleRoundPriceOptions();

                                            // مدیریت تغییر وضعیت چک‌باکس
                                            $("input[name='round-price']").on("change", function () {
                                                toggleRoundPriceOptions();
                                            });
                                        });

                                    </script>
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-12">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900"><?php _e('Price Calculation', SAMYAR_TEXT_DOMAIN); ?></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6"><?php _e('Calculates the prices of services.', SAMYAR_TEXT_DOMAIN); ?></div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">

                                            <div class="round-price IRT">
                                                <!--begin::Input group-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6"><?php _e('Enable Price Rounding', SAMYAR_TEXT_DOMAIN); ?></label>
                                                    <!--begin::Label-->
                                                    <!--begin::Label-->
                                                    <div class="col-lg-8 d-flex align-items-center">
                                                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                            <input class="uk-checkbox" type="hidden" name="round-price"
                                                                   value="0">
                                                            <input class="form-check-input w-45px h-30px"
                                                                   value="1" <?php echo checked(kando_get_option('round-price', 0), 1); ?>
                                                                   type="checkbox"
                                                                   name="round-price" id="round-price"/>
                                                            <label class="form-check-label" for="round-price"></label>
                                                        </div>
                                                    </div>
                                                    <!--begin::Label-->
                                                </div>
                                                <!--end::Input group-->
                                                <?php
                                                $round_price_number = kando_get_option('round-price-number', 10);
                                                ?>
                                                <div class="row mb-10" id="select_round_price_type" style="display: none">
                                                    <div class="col-md-6 fv-row">
                                                        <label class="fs-6 fw-semibold mb-2"><?php _e('Round to how many digits?', SAMYAR_TEXT_DOMAIN); ?></label>
                                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                                data-placeholder="<?php _e('Round to how many digits', SAMYAR_TEXT_DOMAIN); ?>" name="round-price-number">
                                                            <option value=""><?php _e('Round to how many digits', SAMYAR_TEXT_DOMAIN); ?></option>
                                                            <option value="10" <?php selected($round_price_number, 10); ?>>
                                                                <?php _e('Tens (Example: 13523 -> 13530)', SAMYAR_TEXT_DOMAIN); ?>
                                                            </option>
                                                            <option value="100" <?php selected($round_price_number, 100); ?>>
                                                                <?php _e('Hundreds (Example: 13523 -> 13600)', SAMYAR_TEXT_DOMAIN); ?>
                                                            </option>
                                                            <option value="1000" <?php selected($round_price_number, 1000); ?>>
                                                                <?php _e('Thousands (Example: 13523 -> 14000)', SAMYAR_TEXT_DOMAIN); ?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end::Col-->
                                            </div>

                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 5-->
                                <!--begin::Step 6-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-8 pb-lg-10">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900"><?php _e('Your work is complete!', SAMYAR_TEXT_DOMAIN); ?></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">
                                                <?php _e('Price settings have been successfully saved.', SAMYAR_TEXT_DOMAIN); ?>
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Body-->
                                        <div class="mb-0">
                                            <!--begin::Alert-->
                                            <!--begin::Notice-->
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold"><?php _e('Please Note', SAMYAR_TEXT_DOMAIN); ?></h4>
                                                        <div class="fs-6 text-gray-700">
                                                            <?php _e('Please review the list of services and ensure that the prices are displayed correctly.', SAMYAR_TEXT_DOMAIN); ?>
                                                            <a target="_blank" href="<?= home_url('dashboard/?action=services') ?>" class="fw-bold">
                                                                <?php _e('View Services', SAMYAR_TEXT_DOMAIN); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Notice-->
                                            <!--end::Alert-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 6-->
                                <!--begin::Actions-->
                                <div class="d-flex flex-stack pt-15">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                            <i class="ki-outline ki-arrow-right fs-4 me-1"></i><?php _e('Previous', SAMYAR_TEXT_DOMAIN); ?>
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
            <span class="indicator-label"><?php _e('Save', SAMYAR_TEXT_DOMAIN); ?>
            <i class="ki-outline ki-arrow-left fs-4 ms-2"></i></span>
                                            <span class="indicator-progress"><?php _e('Please wait...', SAMYAR_TEXT_DOMAIN); ?>
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                            <?php _e('Next', SAMYAR_TEXT_DOMAIN); ?>
                                            <i class="ki-outline ki-arrow-left fs-4 ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Authentication - Multi-steps-->
        </div>

        <?php
    }


    public function save_settings()
    {
        if (!check_ajax_referer('price_convertor_nonce', 'wpnonce')) {
            wp_send_json_error(['message' => esc_html__('Yikes! The theme activation failed. Please try again or contact support.', 'merlin-wp')]);
        }

        global $wpdb;

        // دریافت داده‌های ارسال‌شده
        parse_str($_POST['data'], $parsed_data); // داده‌های `serialize` را به آرایه تبدیل می‌کند


        //ذخیره مرحله اول
        $site_currency = isset($parsed_data['site_currency']) ? sanitize_text_field($parsed_data['site_currency']) : '';
        update_option('site_currency', $site_currency);


        //ذخیره مرحله دوم
        $decimal_place = isset($parsed_data['decimal_place']) ? $parsed_data['decimal_place'] : [];
        $value_currency = isset($parsed_data['value_currency']) ? $parsed_data['value_currency'] : [];

        // مثال برای پردازش آرایه چندسطحی
        // پردازش داده‌ها و ذخیره در متاها
        foreach ($decimal_place as $post_id => $currencies) {
            foreach ($currencies as $currency => $decimal) {
                if (isset($value_currency[$post_id][$currency])) {
                    // مقدار عددی و ارزی
                    $value = sanitize_text_field($value_currency[$post_id][$currency]);
                    $post_id = trim($post_id, "'\"");
                    $decimal = (int)$decimal;

                    // ذخیره متاها برای پست تایپ
                    update_post_meta($post_id, "decimal_place", $decimal);
                    update_post_meta($post_id, "value_currency", $value);
                }
            }
        }


        //مقدار نرخی که به تومان میخوایم اضافه بشه
        $usd_rate_fix = isset($parsed_data['usd_rate_fix']) ? (int)$parsed_data['usd_rate_fix'] : 0;
        update_option('usd_rate_fix', $usd_rate_fix);

        //مرحله سوم
        $public_profit_fix = isset($parsed_data['public-profit-fix']) ? (int)$parsed_data['public-profit-fix'] : 0;
        $public_profit_percent = !empty($parsed_data['public-profit-percent']) ? sanitize_text_field($parsed_data['public-profit-percent']) : '';

        // دریافت مقادیر تخفیف
        $gold_discount = isset($parsed_data['gold_discount']) ? sanitize_text_field($parsed_data['gold_discount']) : '';
        $silver_discount = isset($parsed_data['silver_discount']) ? sanitize_text_field($parsed_data['silver_discount']) : '';
        $bronze_discount = isset($parsed_data['bronze_discount']) ? sanitize_text_field($parsed_data['bronze_discount']) : '';


        // بررسی اینکه حداقل یکی از مقادیر سود عمومی تعیین شده باشد
        if (empty($public_profit_fix) && empty($public_profit_percent)) {
            wp_send_json_error(__('Please specify either the fixed rate or the profit percentage for the general profit.', SAMYAR_TEXT_DOMAIN));
            exit;
        }


        // ذخیره مقادیر در گزینه‌های وردپرس (یا متاهای پست‌ها)
        update_option('public_profit_fix', $public_profit_fix);
        update_option('public_profit_percent', $public_profit_percent);
        update_option('gold_discount', $gold_discount);
        update_option('silver_discount', $silver_discount);
        update_option('bronze_discount', $bronze_discount);

        //مرحله چهارم
        // بررسی داده‌های ارسالی
        $profit_fix = isset($parsed_data['provider-profit-fix']) ? $parsed_data['provider-profit-fix'] : [];
        $profit_percent = isset($parsed_data['provider-profit-percent']) ? $parsed_data['provider-profit-percent'] : [];

        $table_name = $wpdb->prefix . 'samyar_api_provider'; // نام جدول دیتابیس

        foreach ($profit_fix as $key => $value) {
            $fix_value = isset($value) ? (float)$value : 0;
            $percent_value = isset($profit_percent[$key]) ? (float)$profit_percent[$key] : 0;

            // بروزرسانی دیتابیس برای هر شناسه
            $wpdb->update(
                $table_name,
                array(
                    'custom_rate_fix' => $fix_value,  // ذخیره نرخ ثابت
                    'custom_rate' => $percent_value,  // ذخیره درصد سود
                ),
                array('id' => $key),
                array('%f', '%f'), // نوع داده‌ها
                array('%d') // نوع شناسه
            );
        }

        //مرحله پنجم
        $round_price = isset($parsed_data['round-price']) ? (int)$parsed_data['round-price'] : 0;
        $round_price_number = !empty($parsed_data['round-price-number']) ? sanitize_text_field($parsed_data['round-price-number']) : '10';

        update_option('round-price', $round_price);
        update_option('round-price-number', $round_price_number);

        wp_send_json_success(__('Settings saved successfully.', SAMYAR_TEXT_DOMAIN));

        wp_die();
    }

    /**
     * Base currency step
     */
    protected function site_currency()
    {

        // Text strings.
        $header = __('Select Base Currency', SAMYAR_TEXT_DOMAIN);
        $skip = __('Skip', SAMYAR_TEXT_DOMAIN);
        $next = __('Save', SAMYAR_TEXT_DOMAIN);
        $paragraph = __('How would you like the prices to be saved on your site?', SAMYAR_TEXT_DOMAIN);
        ?>

        <style>
            .radio-container {
                display: flex;
                gap: 30px; /* فاصله بین گزینه‌ها */
                align-items: center;
                justify-content: center;
                margin-top: 10px;
            }

            .radio-option {
                display: flex;
                align-items: center;
                cursor: pointer;
                font-family: Tahoma, Geneva, Verdana, sans-serif;
                font-size: 16px;
                color: #444;
                position: relative;
                padding: 10px 20px;
                border: 2px solid #ddd;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .radio-option:hover {
                border-color: #aaa;
                background-color: #f9f9f9;
            }

            .radio-option input[type="radio"] {
                display: none; /* مخفی کردن ورودی اصلی */
            }

            .custom-radio {
                width: 20px;
                height: 20px;
                border: 2px solid #444;
                border-radius: 50%;
                margin-right: 10px;
                position: relative;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                display: none;
            }

            .custom-radio::after {
                content: "";
                width: 12px;
                height: 12px;
                background-color: #444;
                border-radius: 50%;
                transform: scale(0);
                transition: transform 0.3s ease;
            }

            .radio-option input[type="radio"]:checked + .custom-radio::after {
                transform: scale(1);
            }

            .radio-option input[type="radio"]:checked ~ .radio-label {
                font-weight: bold;
                color: #222;
            }

            .radio-label {
                font-size: 14px;
                color: #666;
                transition: color 0.3s ease, font-weight 0.3s ease;
            }

        </style>
        <div class="price_convertor__content--transition">

            <img src="<?php echo trailingslashit($this->base_url) . $this->directory . '/assets/images/cash.webp' ?>"
                 width="200px" alt="">
            <svg class="icon icon--checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="icon--checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="icon--checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>

            <h1><?php echo esc_html($header); ?></h1>

            <p id="base-currency-text"><?php echo esc_html($paragraph); ?></p>

        </div>
        <form action="" method="post">
            <?php
            // دریافت مقدار ذخیره شده از دیتابیس
            $site_currency = get_option('site_currency', 'IRT'); // مقدار پیش‌فرض IRT
            ?>

            <div class="radio-container">
                <label class="radio-option">
                    <input type="radio" name="site_currency" value="USD" <?php checked($site_currency, 'USD'); ?>>
                    <span class="custom-radio"></span>
                    <span class="radio-label"><?php _e('Dollar (USD)', SAMYAR_TEXT_DOMAIN); ?></span>
                </label>
                <label class="radio-option">
                    <input type="radio" name="site_currency" value="IRT" <?php checked($site_currency, 'IRT'); ?>>
                    <span class="custom-radio"></span>
                    <span class="radio-label"><?php _e('Toman (IRT)', SAMYAR_TEXT_DOMAIN); ?></span>
                </label>
            </div>


            <footer class="price_convertor__content__footer">

                <a id="skip" href="<?php echo esc_url($this->step_next_link()); ?>"
                   class="price_convertor__button price_convertor__button--skip price_convertor__button--proceed"><?php echo esc_html($skip); ?></a>

                <a href="<?php echo esc_url($this->step_next_link()); ?>"
                   class="price_convertor__button price_convertor__button--next button-next js-price-convertor-base-currency-button price_convertor__button--colorchange"
                   data-callback="site_currency">
                    <span class="price_convertor__button--loading__text"><?php echo esc_html($next); ?></span>
                    <?php echo wp_kses($this->loading_spinner(), $this->loading_spinner_allowed_html()); ?>
                </a>

                <?php wp_nonce_field('price_convertor'); ?>
            </footer>
        </form>
        <?php
    }


    public function ignore()
    {

        // Bail out if not on correct page.
        if (!isset($_GET['_wpnonce']) || (!wp_verify_nonce($_GET['_wpnonce'], 'price-convertor-wp-ignore-nounce') || !is_admin() || !isset($_GET[$this->ignore]) || !current_user_can('manage_options'))) {
            return;
        }

        update_option('price_convertor_' . $this->slug . '_completed', 'ignored');
    }



}

priceConvertor::getInstance();