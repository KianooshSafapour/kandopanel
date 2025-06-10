<?php
// فایل‌های مورد نیاز و تعریف کلاس Notification_List_Table (بدون تغییر)
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Notification_List_Table extends WP_List_Table {
    // تمام محتوای کلاس شما در اینجا قرار می‌گیرد (بدون تغییر)
    // ... (کدی که در سوال قبل ارسال کردید)
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'samyar_notification_queue';

        parent::__construct([
            'singular' => __('Notification', SAMYAR_TEXT_DOMAIN), // نام تکی آیتم
            'plural'   => __('Notifications', SAMYAR_TEXT_DOMAIN), // نام جمع آیتم
            'ajax'     => false // این جدول از ایجکس استفاده نمی‌کند
        ]);
    }

    public function get_columns()
    {
        return [
            'cb'            => '<input type="checkbox" />', // چک‌باکس برای عملیات گروهی
            'id'            => __('ID', SAMYAR_TEXT_DOMAIN),
            'recipient'     => __('Recipient', SAMYAR_TEXT_DOMAIN),
            'type'          => __('Type', SAMYAR_TEXT_DOMAIN),
            'status'        => __('Status', SAMYAR_TEXT_DOMAIN),
            'subject'       => __('Subject', SAMYAR_TEXT_DOMAIN),
            'error_message' => __('Error Message', SAMYAR_TEXT_DOMAIN),
            'created_at'    => __('Created At', SAMYAR_TEXT_DOMAIN),
        ];
    }

    protected function get_sortable_columns()
    {
        return [
            'id'         => ['id', true], // true یعنی به صورت پیش‌فرض نزولی مرتب شود
            'type'       => ['type', false],
            'status'     => ['status', false],
            'created_at' => ['created_at', false],
        ];
    }

    protected function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'type':
            case 'subject':
            case 'error_message':
            case 'created_at':
                return esc_html($item->$column_name);
            default:
                return print_r($item, true); // برای دیباگ
        }
    }

    protected function column_status($item) {
        $status = esc_html($item->status);
        $color = 'blue';
        if ($status === 'failed') {
            $color = 'red';
        } elseif ($status === 'processing') {
            $color = 'orange';
        }

        return sprintf('<span style="color:%s; font-weight:bold;">%s</span>', $color, ucfirst($status));
    }

    protected function column_recipient($item)
    {
        $recipient = esc_html($item->recipient);

        // ساخت Nonce برای امنیت
        $delete_nonce = wp_create_nonce('samyar_delete_notification');
        $edit_nonce = wp_create_nonce('samyar_edit_notification');

        // لینک‌های اکشن
        $actions = [
            'edit'   => sprintf(
                '<a href="?page=%s&action=edit&notification_id=%s&_wpnonce=%s">' . __('Edit', SAMYAR_TEXT_DOMAIN) . '</a>',
                esc_attr($_REQUEST['page']),
                absint($item->id),
                $edit_nonce
            ),
            'delete' => sprintf(
                '<a href="?page=%s&action=delete&notification_id=%s&_wpnonce=%s" onclick="return confirm(\'Are you sure you want to delete this item?\')">' . __('Delete', SAMYAR_TEXT_DOMAIN) . '</a>',
                esc_attr($_REQUEST['page']),
                absint($item->id),
                $delete_nonce
            ),
        ];

        return '<strong>' . $recipient . '</strong>' . $this->row_actions($actions);
    }

    protected function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item->id);
    }

    /**
     * تعریف عملیات گروهی (Bulk Actions)
     * @return array
     */
    protected function get_bulk_actions()
    {
        return [
            // ویرگول اضافی در انتهای این خط حذف شد تا با همه محیط‌ها سازگار باشد
            'bulk-delete' => __('Delete', SAMYAR_TEXT_DOMAIN)
        ];
    }

    /**
     * آماده‌سازی آیتم‌ها - اصلاح شده برای استفاده از $_REQUEST
     */
    public function prepare_items()
    {
        global $wpdb;

        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
        $this->process_actions();

        $per_page     = $this->get_items_per_page('notifications_per_page', 20);
        $current_page = $this->get_pagenum();
        $total_items  = self::get_notification_count();

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page
        ]);

        $orderby = !empty($_REQUEST['orderby']) ? esc_sql($_REQUEST['orderby']) : 'created_at';
        $order   = !empty($_REQUEST['order']) ? esc_sql($_REQUEST['order']) : 'DESC';

        $where_clauses = [];
        // تغییر از $_GET به $_REQUEST
        if (!empty($_REQUEST['status_filter'])) {
            $where_clauses[] = $wpdb->prepare("status = %s", $_REQUEST['status_filter']);
        }

        $where_sql = '';
        if (count($where_clauses) > 0) {
            $where_sql = ' WHERE ' . implode(' AND ', $where_clauses);
        }

        $query = "SELECT * FROM {$this->table_name}";
        $query .= $where_sql;
        $query .= " ORDER BY $orderby $order";
        $query .= " LIMIT $per_page";
        $query .= " OFFSET " . ($current_page - 1) * $per_page;

        $this->items = $wpdb->get_results($query);
    }
    /**
     * پردازش اکشن‌های تکی و گروهی (مثل حذف)
     * این نسخه اصلاح شده است
     */
    public function process_actions()
    {
        $action = $this->current_action();

        // اکشن حذف تکی
        if ('delete' === $action) {
            // بررسی امنیتی Nonce
            if ( ! isset($_REQUEST['_wpnonce']) || ! wp_verify_nonce($_REQUEST['_wpnonce'], 'samyar_delete_notification') ) {
                die('Security check failed!');
            }

            // فراخوانی تابع استاتیک با self:: به جای $this->
            self::delete_notification(absint($_GET['notification_id']));

            // نمایش پیام موفقیت
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Notification deleted successfully!', SAMYAR_TEXT_DOMAIN) . '</p></div>';
        }

        // اکشن حذف گروهی
        if ('bulk-delete' === $action && isset($_POST['bulk-delete'])) {
            $delete_ids = array_map('absint', $_POST['bulk-delete']);

            foreach ($delete_ids as $id) {
                // فراخوانی تابع استاتیک با self:: به جای $this->
                self::delete_notification($id);
            }

            // نمایش پیام موفقیت
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Selected notifications deleted successfully!', SAMYAR_TEXT_DOMAIN) . '</p></div>';
        }
    }

    public static function delete_notification($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'samyar_notification_queue';
        $wpdb->delete($table_name, ['id' => $id], ['%d']);
    }

    /**
     * تابع کمکی برای گرفتن تعداد کل اطلاعیه‌ها - اصلاح شده برای استفاده از $_REQUEST
     */
    public static function get_notification_count()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'samyar_notification_queue';

        $where_clauses = [];
        // تغییر از $_GET به $_REQUEST
        if (!empty($_REQUEST['status_filter'])) {
            $where_clauses[] = $wpdb->prepare("status = %s", $_REQUEST['status_filter']);
        }

        $where_sql = '';
        if (count($where_clauses) > 0) {
            $where_sql = ' WHERE ' . implode(' AND ', $where_clauses);
        }

        return (int) $wpdb->get_var("SELECT COUNT(id) FROM $table_name" . $where_sql);
    }

}
// --- پایان کلاس ---

/**
 * تابع جدید: نمایش فرم ویرایش اطلاعیه
 * @param int $id شناسه اطلاعیه
 */
function samyar_render_edit_form($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'samyar_notification_queue';
    
    // دریافت اطلاعات فعلی از دیتابیس
    $notification = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

    if (!$notification) {
        echo '<div class="wrap"><h1>' . __('Error', SAMYAR_TEXT_DOMAIN) . '</h1><p>' . __('Notification not found.', SAMYAR_TEXT_DOMAIN) . '</p></div>';
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Edit Notification', SAMYAR_TEXT_DOMAIN); ?></h1>
        
        <form method="post">
            <?php wp_nonce_field('samyar_update_notification_nonce'); ?>
            <input type="hidden" name="notification_id" value="<?php echo $notification->id; ?>" />
            
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="recipient"><?php _e('Recipient', SAMYAR_TEXT_DOMAIN); ?></label></th>
                        <td><input name="recipient" type="text" id="recipient" value="<?php echo esc_attr($notification->recipient); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="subject"><?php _e('Subject', SAMYAR_TEXT_DOMAIN); ?></label></th>
                        <td><input name="subject" type="text" id="subject" value="<?php echo esc_attr($notification->subject); ?>" class="regular-text" /></td>
                    </tr>
                     <tr>
                        <th scope="row"><label for="message"><?php _e('Message', SAMYAR_TEXT_DOMAIN); ?></label></th>
                        <td><textarea name="message" id="message" class="large-text" rows="10"><?php echo esc_textarea($notification->message); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="status"><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></label></th>
                        <td>
                            <select name="status" id="status">
                                <option value="pending" <?php selected($notification->status, 'pending'); ?>><?php _e('Pending', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="processing" <?php selected($notification->status, 'processing'); ?>><?php _e('Processing', SAMYAR_TEXT_DOMAIN); ?></option>
                                <option value="failed" <?php selected($notification->status, 'failed'); ?>><?php _e('Failed', SAMYAR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button(__('Save Changes', SAMYAR_TEXT_DOMAIN)); ?>
        </form>
    </div>
    <?php
}

/**
 * تابع جدید: پردازش و ذخیره اطلاعات فرم ویرایش
 */
function samyar_handle_update_notification() {
    // 1. بررسی امنیت و دسترسی
    if (!isset($_POST['notification_id']) || !isset($_POST['_wpnonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['_wpnonce'], 'samyar_update_notification_nonce')) {
        die('Security check failed!');
    }
    if (!current_user_can('manage_options')) {
        die('You are not allowed to do this.');
    }

    // 2. دریافت و پاک‌سازی داده‌ها
    global $wpdb;
    $table_name = $wpdb->prefix . 'samyar_notification_queue';
    
    $id = absint($_POST['notification_id']);
    $data = [
        'recipient' => sanitize_text_field($_POST['recipient']),
        'subject'   => sanitize_text_field($_POST['subject']),
        'message'   => wp_kses_post($_POST['message']), // برای محتوای HTML امن
        'status'    => sanitize_text_field($_POST['status']),
    ];

    // 3. به‌روزرسانی دیتابیس
    $wpdb->update($table_name, $data, ['id' => $id]);

    // 4. نمایش پیام موفقیت
    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible"><p>' . __('Notification updated successfully!', SAMYAR_TEXT_DOMAIN) . '</p></div>';
    });
}


/**
 * تابع اصلی مدیریت صفحه: تصمیم می‌گیرد لیست را نمایش دهد یا فرم ویرایش را
 */
function samyar_notification_queue_page() {
    // ابتدا بررسی می‌کنیم که آیا فرم ویرایش ارسال شده است یا خیر
    if (isset($_POST['notification_id']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'samyar_update_notification_nonce')) {
        samyar_handle_update_notification();
    }

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'list';
    $id = isset($_GET['notification_id']) ? absint($_GET['notification_id']) : 0;

    switch ($action) {
        case 'edit':
            // بررسی Nonce برای امنیت لینک ویرایش
            if ( ! isset($_REQUEST['_wpnonce']) || ! wp_verify_nonce($_REQUEST['_wpnonce'], 'samyar_edit_notification') ) {
                die('Security check failed!');
            }
            samyar_render_edit_form($id);
            break;

        default:
            // نمایش جدول لیست
            $notification_list_table = new Notification_List_Table();
            ?>
            <div class="wrap">
                <h1 class="wp-heading-inline"><?php _e('Notification Queue', SAMYAR_TEXT_DOMAIN); ?></h1>
                <hr class="wp-header-end">

                <form method="post">
                    <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
                    <?php
                    $notification_list_table->prepare_items();
                    $notification_list_table->display();
                    ?>
                </form>
            </div>
            <?php
            break;
    }
}