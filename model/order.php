<?php


namespace samyar;

use Morilog\Jalali\Jalalian;
use TenQuality\WP\Database\Abstracts\DataModel;
use TenQuality\WP\Database\Traits\DataModelTrait;

class Order extends DataModel
{
    use DataModelTrait;

    /**
     * Data table name in database (without prefix).
     * @var string
     */
    const TABLE = 'samyar_orders';
    /**
     * Data table name in database (without prefix).
     * @var string
     */
    protected $table = self::TABLE;
    /**
     * Primary key column name. Default ID
     * @var string
     */
    protected $primary_key = 'id';


    /**
     * Constructor.
     *
     * @param array $attributes
     * @param mixed $id
     */
    public function __construct($attributes = [], $id = null)
    {
        // فراخوانی سازنده کلاس والد (DataModel)
        parent::__construct($attributes, $id);

    }




    /**
     * Model properties, data column list.
     * @var string
     */
//	protected $attributes = [
//		'model_id',
//		'name',
//	];

    /**
     * Returns list of protected/readonly properties for
     * when saving or updating.
     *
     * @return array
     */
    protected function protected_properties()
    {
        // The following is the default array list
        return [$this->primary_key];
    }

    // تابع برای محاسبه تعداد و جمع فروش ماهانه
    public function calculate_monthly_sales($user_id,$start_date, $end_date) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'samyar_orders';

        $query = $wpdb->prepare(
            "SELECT COUNT(id) as order_count, SUM(charge) as total_sales 
         FROM $table_name 
         WHERE 
             uid = %d
         AND created_at BETWEEN %s AND %s ",
            $user_id,
            $start_date->format('Y-m-d H:i:s'),
            $end_date->format('Y-m-d H:i:s')
        );

        return $wpdb->get_row($query, ARRAY_A);
    }


    public function repeat_order($user_id,$quantity,$service_id,$link)
    {
        global $wpdb;

// پاکسازی و اعتبارسنجی ورودی‌ها
        $quantity = isset($params["quantity"]) ? intval($params["quantity"]) : 0;
        $service_id = isset($params["service"]) ? intval($params["service"]) : 0;
        $link = isset($params["link"]) ? sanitize_text_field(trim($params["link"])) : '';

// بررسی وجود سفارش تکراری
        $exist_orders = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) 
     FROM {$wpdb->prefix}orders 
     WHERE status IN ('active', 'processing', 'inprogress', 'pending', '') 
       AND service_id = %d 
       AND quantity = %d 
       AND link = %s 
       AND uid = %d",
            $service_id,
            $quantity,
            $link,
            $user_id
        ));


        return $exist_orders;

    }

    public function get_last_10_orders(int $uid)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'samyar_orders';

        $sql = $wpdb->prepare(
            "SELECT * FROM $table_name 
        WHERE uid = %d 
        ORDER BY id DESC 
        LIMIT 10",
            $uid
        );

        $results = $wpdb->get_results($sql);

        return $results;
    }


    function search_orders($search_term, $uid) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'samyar_orders';

        // جستجو در فیلدهای id, api_order_id, link
        $sql = $wpdb->prepare(
            "SELECT * FROM $table_name 
        WHERE (id LIKE %s) 
        AND uid = %d 
        ORDER BY id DESC 
        LIMIT 10",
            '%' . $wpdb->esc_like($search_term) . '%',
            $uid
        );

        // اجرای کوئری و دریافت نتایج
        $results = $wpdb->get_results($sql);

        return $results;
    }
}