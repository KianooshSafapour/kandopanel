<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// افزودن منوی تنظیمات به پیشخوان
add_action('admin_menu', 'sc_add_admin_menu',100);

function sc_add_admin_menu() {
    $hook_suffix = add_submenu_page(
        'samyar-settings', // منوی والد
        __('Server Checkup', SAMYAR_TEXT_DOMAIN),
        __('Server Checkup', SAMYAR_TEXT_DOMAIN),
        'manage_options',
        'system-checkup', // اسلاگ معتبر و مرتبط با والد
        'sc_admin_page'
    );
}


// بررسی فعال بودن سیستم ایمیل
function sc_check_email_system() {
    // Test email address
    $to = 'test@example.com';
    $subject = __('Test Email', SAMYAR_TEXT_DOMAIN);
    $message = __('This is a test email to check if the email system is working.', SAMYAR_TEXT_DOMAIN);
    $headers = array('Content-Type: text/plain; charset=UTF-8');

    // Send test email
    $result = wp_mail($to, $subject, $message, $headers);

    if ($result) {
        return true; // Email sent successfully
    } else {
        // Check possible reasons for email failure
        global $phpmailer;

        if (isset($phpmailer) && is_wp_error($phpmailer->ErrorInfo)) {
            return __('Email sending error: ', SAMYAR_TEXT_DOMAIN) . $phpmailer->ErrorInfo;
        } else {
            return __('The email system is not active. The SMTP configuration may be incorrect or the email server may not be available.', SAMYAR_TEXT_DOMAIN);
        }
    }
}

// ایجاد صفحه تنظیمات
// ایجاد صفحه تنظیمات
// تغییر تابع sc_admin_page برای نمایش نوع کش
function sc_admin_page() {
    ?>
    <div class="wrap">
        <h1>System Checkup</h1>
        <style>
            .status-active {
                color: green;
                font-weight: bold;
            }
            .status-inactive {
                color: red;
                font-weight: bold;
            }
        </style>
        <table class="wp-list-table widefat fixed striped">
            <thead>
            <tr>
                <th><?php _e('Title', SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e('Descriptions', SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php _e('PHP Version', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $php_version_status = sc_check_php_version();
                    if ($php_version_status === true) {
                        echo '<span class="status-active">Updated</span>';
                    } else {
                        echo '<span class="status-inactive">Needs Update</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($php_version_status !== true) {
                        echo $php_version_status;
                    } else {
                        echo sprintf(
                            __('Your PHP version is up to date. (Current version: %s)', SAMYAR_TEXT_DOMAIN),
                            phpversion()
                        );
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('kandopanel Theme Update Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $kandopanel_update_status = sc_check_kandopanel_wp_update();

                    if ($kandopanel_update_status === true) {
                        echo '<span class="status-active">Updated</span>';
                    } else {
                        echo '<span class="status-inactive">Needs Update</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($kandopanel_update_status !== true) {
                        echo $kandopanel_update_status;
                    } else {
                        echo __('The kandopanel theme has been updated to the latest version.', SAMYAR_TEXT_DOMAIN);
                    }
                    ?>
                </td>
            </tr>
            <!--
            <tr>
                <td><?php _e('wget Activation Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td><span class="<?php echo sc_check_wget() ? 'status-active' : 'status-inactive'; ?>"><?php echo sc_check_wget() ? __('Active', SAMYAR_TEXT_DOMAIN) : __('Inactive', SAMYAR_TEXT_DOMAIN); ?></span></td>
                <td><span><?php echo sc_check_wget() ? '' : __('To resolve this issue, contact your hosting provider and request them to enable this feature. If it cannot be enabled, consider changing your hosting provider.', SAMYAR_TEXT_DOMAIN); ?></span></td>
            </tr>
            -->
            <tr>
                <td><?php _e('WordPress Cron Job Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td><span class="<?php echo sc_check_wp_cron() ? 'status-active' : 'status-inactive'; ?>"><?php echo sc_check_wp_cron() ? __('Active', SAMYAR_TEXT_DOMAIN) : __('Inactive', SAMYAR_TEXT_DOMAIN); ?></span></td>
                <td><span><?php echo sc_check_wp_cron() ? '' : __('Go to the wp-config.php file and set DISABLE_WP_CRON to false or remove it.', SAMYAR_TEXT_DOMAIN); ?></span></td>
            </tr>
            <tr>
                <td><?php _e('Object Cache Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td><span class="<?php echo sc_check_wp_object_cache() ? 'status-active' : 'status-inactive'; ?>"><?php echo sc_check_wp_object_cache() ? __('Active', SAMYAR_TEXT_DOMAIN) : __('Inactive', SAMYAR_TEXT_DOMAIN); ?></span></td>
                <td><span><?php echo sc_check_wp_object_cache() ? '' : __('To improve site performance, enable a caching system like Memcached or Redis.', SAMYAR_TEXT_DOMAIN); ?></span></td>
            </tr>
            <tr>
                <td><?php _e('Active Cache System Type', SAMYAR_TEXT_DOMAIN); ?></td>
                <td><?php echo sc_check_cache_type(); ?></td>
                <td>
        <span>
            <?php
            $cache_type = sc_check_cache_type();
            if ($cache_type === 'None') {
                echo __('No cache system is active. To improve site performance, activate a caching system like Memcached or Redis.', SAMYAR_TEXT_DOMAIN);
            } elseif ($cache_type === 'WP_Object_Cache') {
                echo __('The internal WordPress caching system is active. For better performance, it is recommended to use more powerful caching systems like Memcached or Redis.', SAMYAR_TEXT_DOMAIN);
            } else {
                echo sprintf(
                    __('The cache system %s is active.', SAMYAR_TEXT_DOMAIN),
                    esc_html($cache_type)
                );
            }
            ?>
        </span>
                </td>
            </tr>
            <tr>
                <td><?php _e('Email System Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $email_status = sc_check_email_system();
                    if ($email_status === true) {
                        echo '<span class="status-active">' . __('Active', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Inactive', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($email_status !== true) {
                        echo $email_status;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('cURL Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $curl_status = sc_check_curl();
                    if ($curl_status !== false) {
                        echo '<span class="status-active">' . $curl_status . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Inactive', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($curl_status === false) {
                        echo __('cURL is not active. To enable it, contact your hosting support or use the following commands on a Linux server:<br>
            <code>sudo apt-get install php-curl</code> (for Debian/Ubuntu based servers)<br>
            <code>sudo yum install php-curl</code> (for CentOS/RHEL based servers)', SAMYAR_TEXT_DOMAIN);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('Google reCAPTCHA Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $recaptcha_status = sc_check_google_recaptcha();
                    if ($recaptcha_status === true) {
                        echo '<span class="status-active">' . __('Active', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Inactive', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($recaptcha_status !== true) {
                        echo $recaptcha_status;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('kandopanel.zip File Check', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $kandopanel_status = sc_check_kandopanel_file();
                    if ($kandopanel_status === true) {
                        echo '<span class="status-active">' . __('File does not exist', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('File exists', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($kandopanel_status !== true) {
                        echo $kandopanel_status;
                    }
                    ?>
                </td>
            </tr>
            <!-- WordPress Version Check -->
            <tr>
                <td><?php _e('WordPress Version Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $wp_version_status = sc_check_wp_version();
                    if ($wp_version_status === true) {
                        echo '<span class="status-active">' . __('Updated', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Outdated', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($wp_version_status !== true) {
                        echo $wp_version_status;
                    }
                    ?>
                </td>
            </tr>

            <!-- Debug Mode Check -->
            <tr>
                <td><?php _e('Debug Mode Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $debug_status = sc_check_wp_debug();
                    if ($debug_status === true) {
                        echo '<span class="status-active">' . __('Disabled', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Enabled', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($debug_status !== true) {
                        echo $debug_status;
                    }
                    ?>
                </td>
            </tr>




            <!-- Security Settings Check -->
            <tr>
                <td><?php _e('Security Settings Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $security_settings_status = sc_check_security_settings();
                    if ($security_settings_status === true) {
                        echo '<span class="status-active">' . __('Secure', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Insecure', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($security_settings_status !== true) {
                        echo $security_settings_status;
                    }
                    ?>
                </td>
            </tr>
            <!-- SSL Status Check -->
            <tr>
                <td><?php _e('SSL Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $ssl_status = sc_check_ssl();
                    if ($ssl_status === true) {
                        echo '<span class="status-active">' . __('Active', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Inactive', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($ssl_status !== true) {
                        echo $ssl_status;
                    }
                    ?>
                </td>
            </tr>

            <!-- Log Files Check -->
            <tr>
                <td><?php _e('Log Files Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $log_files_status = sc_check_log_files();
                    if ($log_files_status === true) {
                        echo '<span class="status-active">' . __('No issues', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Issues detected', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($log_files_status !== true) {
                        echo $log_files_status;
                    }
                    ?>
                </td>
            </tr>

            <!-- .htaccess File Check -->
            <tr>
                <td><?php _e('.htaccess File Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $htaccess_status = sc_check_htaccess();
                    if ($htaccess_status === true) {
                        echo '<span class="status-active">' . __('Exists', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Does not exist', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($htaccess_status !== true) {
                        echo $htaccess_status;
                    }
                    ?>
                </td>
            </tr>

            <!-- wp-config.php File Check -->
            <tr>
                <td><?php _e('wp-config.php File Status', SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
                    <?php
                    $wp_config_status = sc_check_wp_config();
                    if ($wp_config_status === true) {
                        echo '<span class="status-active">' . __('Exists', SAMYAR_TEXT_DOMAIN) . '</span>';
                    } else {
                        echo '<span class="status-inactive">' . __('Does not exist', SAMYAR_TEXT_DOMAIN) . '</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($wp_config_status !== true) {
                        echo $wp_config_status;
                    }
                    ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php
}

// بررسی فعال بودن wget
function sc_check_wget() {
    return function_exists('exec') && exec('which wget') !== '';
}

// بررسی نسخه PHP
//function sc_check_php_version() {
//    return phpversion();
//}

// بررسی نسخه PHP
function sc_check_php_version() {
    $current_php_version = phpversion(); // Get the current PHP version
    $minimum_php_version = '8.1'; // Required minimum PHP version

    // Compare the current version with the required minimum version
    if (version_compare($current_php_version, $minimum_php_version, '<')) {
        return sprintf(
            __('Your PHP version is %1$s. Please upgrade your PHP version to %2$s or higher.', SAMYAR_TEXT_DOMAIN),
            $current_php_version,
            $minimum_php_version
        );
    }

    return true; // PHP version is up to date
}

// بررسی وضعیت کرون جاب وردپرس
function sc_check_wp_cron() {
    return !defined('DISABLE_WP_CRON') || !DISABLE_WP_CRON;
}

// بررسی فعال بودن Object Cache (wp_cache_get)
function sc_check_wp_object_cache() {
    // بررسی وجود تابع wp_cache_get
    if (function_exists('wp_cache_get')) {
        // بررسی اینکه آیا Object Cache به درستی کار می‌کند
        $test_key = 'sc_object_cache_test';
        $test_value = 'active';

        // ذخیره یک مقدار تستی در کش
        wp_cache_set($test_key, $test_value);

        // بازیابی مقدار از کش
        $cached_value = wp_cache_get($test_key);

        // اگر مقدار بازیابی شده با مقدار ذخیره شده یکسان باشد، کش فعال است
        return $cached_value === $test_value;
    }
    return false;
}

// بررسی نوع سیستم کش فعال
function sc_check_cache_type() {
    if (class_exists('Memcached') && function_exists('wp_cache_add')) {
        return 'Memcached';
    } elseif (class_exists('Redis') && function_exists('wp_cache_add')) {
        return 'Redis';
    } elseif (function_exists('wp_cache_add')) {
        return 'WP_Object_Cache'; // کش داخلی وردپرس
    } else {
        return 'None'; // هیچ سیستم کشی فعال نیست
    }
}

// بررسی فعال بودن cURL
function sc_check_curl() {
    if (function_exists('curl_version')) {
        // دریافت اطلاعات نسخه cURL
        $curl_info = curl_version();
        return 'فعال (نسخه: ' . $curl_info['version'] . ')';
    } else {
        return false; // cURL فعال نیست
    }
}

// بررسی صحت تنظیمات Google reCAPTCHA
function sc_check_google_recaptcha() {
    $site_key = esc_attr(kando_get_option('google-captcha-key', ""));
    $secret_key = esc_attr(kando_get_option('google-captcha-secret-key', ""));

    // reCAPTCHA keys (these values should be retrieved from plugin settings or the database)
    $recaptcha_secret_key = 'YOUR_SECRET_KEY'; // reCAPTCHA secret key
    $recaptcha_site_key   = 'YOUR_SITE_KEY';   // reCAPTCHA site key

    // Check if keys are set
    if (empty($secret_key) || empty($site_key)) {
        return __('reCAPTCHA keys are not configured.', SAMYAR_TEXT_DOMAIN);
    }

    // Send a request to the Google server for verification
    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret'   => $secret_key,
            'response' => 'test', // A test value (usually this value is received from the user)
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ],
    ]);

    // Check for errors in sending the request
    if (is_wp_error($response)) {
        return sprintf(
            __('Error connecting to the Google server: %s', SAMYAR_TEXT_DOMAIN),
            $response->get_error_message()
        );
    }

    // Check the response from the Google server
    $response_body = wp_remote_retrieve_body($response);
    $response_data = json_decode($response_body, true);

    if (isset($response_data['success']) && $response_data['success'] === true) {
        return true; // reCAPTCHA is properly configured
    } else {
        // Check error reasons
        $error_codes = isset($response_data['error-codes']) ? $response_data['error-codes'] : [];
        $error_message = __('Error in reCAPTCHA settings: ', SAMYAR_TEXT_DOMAIN);

        foreach ($error_codes as $error_code) {
            switch ($error_code) {
                case 'missing-input-secret':
                    $error_message .= __('Secret Key is missing. ', SAMYAR_TEXT_DOMAIN);
                    break;
                case 'invalid-input-secret':
                    $error_message .= __('Secret Key is invalid. ', SAMYAR_TEXT_DOMAIN);
                    break;
                case 'missing-input-response':
                    $error_message .= __('reCAPTCHA response from the user is missing. ', SAMYAR_TEXT_DOMAIN);
                    break;
                case 'invalid-input-response':
                    $error_message .= __('reCAPTCHA response is invalid. ', SAMYAR_TEXT_DOMAIN);
                    break;
                default:
                    $error_message .= sprintf(__('Unknown error: %s ', SAMYAR_TEXT_DOMAIN), $error_code);
                    break;
            }
        }

        return $error_message;
    }
}

// Check for the existence of the kandopanel.zip file in the wp-content/themes folder
function sc_check_kandopanel_file() {
    // Full path to the file
    $file_path = WP_CONTENT_DIR . '/themes/kandopanel.zip';

    // Check if the file exists
    if (file_exists($file_path)) {
        return __('The kandopanel.zip file exists in the themes folder. Please remove this file.', SAMYAR_TEXT_DOMAIN);
    } else {
        return true; // File does not exist
    }
}

function sc_check_wp_version() {
    $current_version = get_bloginfo('version');
    $latest_version = wp_remote_get('https://api.wordpress.org/core/version-check/1.7/');

    if (!is_wp_error($latest_version)) {
        $latest_version = json_decode($latest_version['body']);
        $latest_version = $latest_version->offers[0]->version;

        if (version_compare($current_version, $latest_version, '<')) {
            return sprintf(
                __('Your WordPress version is outdated. Please update. (Current version: %1$s, Latest version: %2$s)', SAMYAR_TEXT_DOMAIN),
                $current_version,
                $latest_version
            );
        }
    }

    return true; // WordPress version is up to date
}

function sc_check_wp_debug() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        return __('Debug mode is enabled. Disable it for a production environment.', SAMYAR_TEXT_DOMAIN);
    }
    return true; // Debug mode is disabled
}


function sc_check_security_settings() {
    $messages = [];

    // Check if file editing from the dashboard is disabled
    if (defined('DISALLOW_FILE_EDIT') && !DISALLOW_FILE_EDIT) {
        $messages[] = __('File editing from the dashboard is not disabled. Please disable it.', SAMYAR_TEXT_DOMAIN);
    }

    // Check if plugin/theme installation from the dashboard is disabled
    if (defined('DISALLOW_FILE_MODS') && !DISALLOW_FILE_MODS) {
        $messages[] = __('Plugin/Theme installation from the dashboard is not disabled. Please disable it.', SAMYAR_TEXT_DOMAIN);
    }

    if (!empty($messages)) {
        return implode('<br>', $messages);
    }
    return true; // Security settings are properly applied
}

function sc_check_unnecessary_files() {
    $files_to_check = ['readme.html', 'license.txt'];
    $messages = [];

    foreach ($files_to_check as $file) {
        if (file_exists(ABSPATH . $file)) {
            $messages[] = sprintf(
                __('Unnecessary file: %s exists. Please delete it.', SAMYAR_TEXT_DOMAIN),
                $file
            );
        }
    }

    if (!empty($messages)) {
        return implode('<br>', $messages);
    }
    return true; // No unnecessary files found
}

function sc_check_ssl() {
    if (!is_ssl()) {
        return __('SSL is not enabled. For better security, please enable SSL.', SAMYAR_TEXT_DOMAIN);
    }
    return true; // SSL is enabled
}

function sc_check_log_files() {
    $log_files = glob(ABSPATH . '*.log');
    if (!empty($log_files)) {
        return __('Log files exist in the public folder. Please delete or move them.', SAMYAR_TEXT_DOMAIN);
    }
    return true; // No log files found
}

function sc_check_htaccess() {
    $htaccess_file = ABSPATH . '.htaccess';
    if (!file_exists($htaccess_file)) {
        return __('The .htaccess file does not exist. Please create it.', SAMYAR_TEXT_DOMAIN);
    }
    return true; // .htaccess file exists
}
function sc_check_wp_config() {
    $wp_config_file = ABSPATH . 'wp-config.php';
    if (!file_exists($wp_config_file)) {
        return __('The wp-config.php file does not exist in the root directory.', SAMYAR_TEXT_DOMAIN);
    }
    return true; // The wp-config.php file exists
}

// Check for kandopanel theme updates in WordPress updates section
function sc_check_kandopanel_wp_update() {
    // Current information about the kandopanel theme
    $theme = wp_get_theme('kandopanel'); // Theme folder name

    // Check if the theme exists
    if (!$theme->exists()) {
        return __('The kandopanel theme is not installed.', SAMYAR_TEXT_DOMAIN);
    }

    $current_version = $theme->get('Version'); // Current theme version

    // Get available updates from WordPress
    $update_themes = get_site_transient('update_themes');

    // Check if kandopanel is in the update list
    if (isset($update_themes->response['kandopanel'])) {
        $latest_version = $update_themes->response['kandopanel']['new_version'];

        // Compare versions
        if (version_compare($current_version, $latest_version, '<')) {
            return sprintf(
                __('A new update is available for the kandopanel theme. Please update to version %1$s. (Current version: %2$s)', SAMYAR_TEXT_DOMAIN),
                $latest_version,
                $current_version
            );
        } else {
            return true; // Theme is up to date
        }
    } else {
        // If the theme is not in the update list
        return true; // Theme is up to date
    }
}