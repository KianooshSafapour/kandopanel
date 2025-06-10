<?php


namespace samyar;
use TenQuality\WP\Database\Abstracts\DataModel;
use TenQuality\WP\Database\Traits\DataModelTrait;


class Service extends DataModel
{
	use DataModelTrait;
	/**
	 * Data table name in database (without prefix).
	 * @var string
	 */
	const TABLE = 'samyar_services';
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
     * @param \wpdb $wpdb WordPress database object.
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

    /**
     * List of properties used for keyword search.
     * @var array
     */
    protected static $keywords = ['name'];


    public function get_services_by_category_ids($category_ids, $is_admin, $user_id) {
        global $wpdb;

        if (empty($category_ids)) {
            return array();
        }

        // اطمینان از اینکه همه‌ی category_ids عددی هستند و حذف موارد تکراری
        $category_ids = array_map('intval', $category_ids);
        $category_ids_string = implode(',', array_unique($category_ids));

        $query = "
        SELECT s.*, 
               p.name AS provider_name, 
               p.status AS provider_status, 
               p.base_currency AS provider_currency, 
               p.custom_rate AS provider_custom_rate
        FROM {$wpdb->prefix}samyar_services s
        LEFT JOIN {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
        WHERE s.cate_id IN ($category_ids_string)
          AND (s.api_provider_id = 0 OR p.id IS NOT NULL)"; // فقط سرویس‌هایی که یا provider ندارند (api_provider_id=0) یا provider معتبر دارند

        if (!$is_admin) {
            $query .= " AND s.status = 1";
            if ($user_id) {
                $query .= $wpdb->prepare(
                    " AND s.id NOT IN (SELECT service_id FROM {$wpdb->prefix}samyar_user_disable_service WHERE uid = %d)",
                    $user_id
                );
            }
        }

        $query .= " ORDER BY s.sort ASC";

        return $wpdb->get_results($query);
    }

    public function get_services_by_category_id($category_id, $is_admin, $user_id) {
        global $wpdb;

        // بررسی معتبر بودن شناسه دسته
        $category_id = (int)$category_id;
        if ($category_id <= 0) {
            return [];
        }

        // ساخت کوئری پایه با استفاده از prepare برای جلوگیری از SQL injection
        $query = $wpdb->prepare(
            "SELECT s.*, p.name AS provider_name, p.status AS provider_status, p.base_currency AS provider_currency
        FROM {$wpdb->prefix}samyar_services s
        LEFT JOIN {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
        WHERE s.cate_id = %d
        AND (s.api_provider_id = 0 OR p.id IS NOT NULL)", // شرط جدید برای فیلتر کردن ارائه‌دهنده‌های نامعتبر
            $category_id
        );

        // اضافه کردن شرایط برای کاربران غیرادمین
//        if (!$is_admin) {
            $query .= " AND s.status = 1";
            if ($user_id) {
                $user_id = (int)$user_id;
                $query .= $wpdb->prepare(
                    " AND s.id NOT IN (SELECT service_id FROM {$wpdb->prefix}samyar_user_disable_service WHERE uid = %d)",
                    $user_id
                );
            }
//        }

        // مرتب‌سازی نتایج
        $query .= " ORDER BY s.sort ASC";

        // اجرای کوئری و بازگرداندن نتایج
        return $wpdb->get_results($query);
    }

    public function get_service_by_provider_info($service_id) {
        global $wpdb;

        // بررسی معتبر بودن شناسه سرویس
        if ($service_id <= 0) {
            return null;
        }

        // ساخت کوئری برای دریافت اطلاعات سرویس و ارائه‌دهنده
        $query = "
    SELECT s.*, p.name AS provider_name, p.status AS provider_status, p.base_currency AS provider_currency
    FROM {$wpdb->prefix}samyar_services s
    LEFT JOIN {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
    WHERE s.id = $service_id";

        // اجرای کوئری و بازگرداندن نتیجه
        return $wpdb->get_row($query);
    }

    public function get_service_metas($service_id) {
        global $wpdb;

        $query = "
            SELECT meta_key, meta_value
            FROM {$wpdb->prefix}samyar_servicemeta
            WHERE service_id = %d";
        $results = $wpdb->get_results($wpdb->prepare($query, $service_id));

        $metas = [];
        foreach ($results as $meta) {
            $metas[$meta->meta_key] = $meta->meta_value;
        }

        return $metas;
    }


    public function get_service_metas_bulk($service_ids) {
        global $wpdb;

        if (empty($service_ids)) {
            return [];
        }

        $service_ids_string = implode(',', array_map('intval', $service_ids));

        $query = "
        SELECT service_id, meta_key, meta_value
        FROM {$wpdb->prefix}samyar_servicemeta
        WHERE service_id IN ($service_ids_string)
    ";

        $results = $wpdb->get_results($query);

        $metas = [];
        foreach ($results as $row) {
            if (!isset($metas[$row->service_id])) {
                $metas[$row->service_id] = [];
            }
            $metas[$row->service_id][$row->meta_key] = $row->meta_value;
        }

        return $metas;
    }

    public function get_services_list() {
        global $wpdb;

        $sql = "
        SELECT 
            s.id,
            s.name,
            c.name AS category,
            s.price,
            s.gold_price,
            s.silver_price,
            s.bronze_price,
            s.disable_representation,
            s.min,
            s.max,
            s.type,
            s.description,
            s.dripfeed,
            s.refill,
            s.sort,
            soc.name AS brand
        FROM 
            {$wpdb->prefix}samyar_services s
        JOIN 
            {$wpdb->prefix}samyar_categories c ON s.cate_id = c.id
        LEFT JOIN 
            {$wpdb->prefix}samyar_social soc ON c.social_id = soc.id AND soc.status = 1
        LEFT JOIN 
            {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
        LEFT JOIN 
            {$wpdb->prefix}samyar_user_disable_service uds ON s.id = uds.service_id
        WHERE 
            c.status = 1 
            AND (p.status = 1 OR s.api_provider_id = 0) 
            AND s.status = 1 
            AND uds.service_id IS NULL;
    ";

        $results = $wpdb->get_results($sql, OBJECT);

        if ($results) {
            return $results;
        }

        return [];
    }

    public static function getServicesListByInfo($args = []) {
        global $wpdb;

        // لیست ستون‌های مجاز برای مرتب‌سازی
        $allowed_orderby_columns = [
            'id' => 's.id',
            'name' => 's.name',
            'price' => 's.price',
            'sort' => 's.sort',
            'category' => 'c.name' // نگاشت صحیح برای category
        ];

        // کوئری با ستون‌های مشخص
        $sql = "
    SELECT 
        s.*,
        c.name AS category,
        soc.name AS brand
    FROM 
        {$wpdb->prefix}samyar_services s
    JOIN 
        {$wpdb->prefix}samyar_categories c ON s.cate_id = c.id
    LEFT JOIN 
        {$wpdb->prefix}samyar_social soc ON c.social_id = soc.id AND soc.status = 1
    LEFT JOIN 
        {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
    LEFT JOIN 
        {$wpdb->prefix}samyar_user_disable_service uds ON s.id = uds.service_id
    WHERE 
        c.status = 1 
        AND (p.status = 1 OR s.api_provider_id = 0) 
        AND s.status = 1 
        AND uds.service_id IS NULL
    ";

        // ساخت ORDER BY به صورت امن
        $orderby_clauses = [];
        if (!empty($args['orderby']) && is_array($args['orderby'])) {
            foreach ($args['orderby'] as $column => $direction) {
                if (isset($allowed_orderby_columns[$column])) {
                    $direction = (strtoupper($direction) === 'DESC') ? 'DESC' : 'ASC';
                    $orderby_clauses[] = esc_sql($allowed_orderby_columns[$column]) . " {$direction}";
                }
            }
        }

        // ORDER BY پیش‌فرض
        if (empty($orderby_clauses)) {
            $orderby_clauses[] = 'c.name ASC, s.id ASC';
        }

        $sql .= " ORDER BY " . implode(', ', $orderby_clauses);

        // اجرای کوئری
        $results = $wpdb->get_results($sql, OBJECT);

        // بررسی خطاها
        if ($wpdb->last_error) {
            error_log('SQL Error in getServicesListByInfo: ' . $wpdb->last_error);
            return [];
        }

        return $results ?: [];
    }


    public function getServicesListByInfo_old() {
        global $wpdb;

        $sql = "
        SELECT 
            s.*,
            c.name AS category,
            soc.name AS brand
        FROM 
            {$wpdb->prefix}samyar_services s
        JOIN 
            {$wpdb->prefix}samyar_categories c ON s.cate_id = c.id
        LEFT JOIN 
            {$wpdb->prefix}samyar_social soc ON c.social_id = soc.id AND soc.status = 1
        LEFT JOIN 
            {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
        LEFT JOIN 
            {$wpdb->prefix}samyar_user_disable_service uds ON s.id = uds.service_id
        WHERE 
            c.status = 1 
            AND (p.status = 1 OR s.api_provider_id = 0) 
            AND s.status = 1 
            AND uds.service_id IS NULL;
    ";

        $results = $wpdb->get_results($sql, OBJECT);

        if ($results) {
            return $results;
        }

        return [];
    }

    /**
     * @return array|object|null
     * سرویس های محبوب رو پیدا میکنه
     */
    public function get_top_services()
    {
        global $wpdb;

        $query = "
        SELECT 
            s.id AS service_id,
            s.name AS service_name,
            COUNT(o.id) AS order_count
        FROM 
            {$wpdb->prefix}samyar_services s
        JOIN 
            {$wpdb->prefix}samyar_orders o ON s.id = o.service_id
        WHERE 
            s.status = 1 -- فقط سرویس‌های فعال
            AND o.status = 'completed' -- فقط سفارش‌های تکمیل شده
        GROUP BY 
            s.id
        ORDER BY 
            order_count DESC
        LIMIT 5;
    ";

        $results = $wpdb->get_results($query);

        return $results;
    }


    public function get_service_info($service_id) {
        global $wpdb;

// دریافت شناسه سرویس از پارامترهای ورودی
        $service_id = isset($service_id) ? (int)$service_id : 0;

// کوئری برای بررسی وضعیت سرویس و دریافت اطلاعات آن
        $sql = $wpdb->prepare(
            "SELECT 
        s.id,
        s.name,
        s.cate_id,
        s.api_provider_id,
        s.api_service_id,
        s.manual_currency,
        s.price,
        s.original_price,
        s.gold_price,
        s.silver_price,
        s.bronze_price,
        s.disable_representation,
        s.min,
        s.max,
        s.type,
        s.description,
        s.dripfeed,
        s.refill,
        s.sort,
        s.add_type,
        s.profit_rate,
        p.base_currency AS provider_currency,
        soc.name AS brand
    FROM 
        {$wpdb->prefix}samyar_services s
    JOIN 
        {$wpdb->prefix}samyar_categories c ON s.cate_id = c.id
    LEFT JOIN 
        {$wpdb->prefix}samyar_social soc ON c.social_id = soc.id AND soc.status = 1
    LEFT JOIN 
        {$wpdb->prefix}samyar_api_provider p ON s.api_provider_id = p.id
    LEFT JOIN 
        {$wpdb->prefix}samyar_user_disable_service uds ON s.id = uds.service_id
    WHERE 
        s.id = %d 
        AND c.status = 1 
        AND (p.status = 1 OR s.api_provider_id = 0) 
        AND s.status = 1 
        AND uds.service_id IS NULL",
            $service_id
        );

// اجرای کوئری و دریافت نتیجه
        $result = $wpdb->get_row($sql, OBJECT);

// بررسی نتیجه
        if ($result) {
            // اگر سرویس فعال است، اطلاعات آن را برگردانید
            return $result;
        }

// اگر سرویس غیرفعال است، false برگردانید
        return false;
    }


    public function get_api_service_ids_by_provider($provider_id) {
        global $wpdb;

        // نام جدول دیتابیس
        $table_name = $wpdb->prefix . 'samyar_services';

        // کوئری برای دریافت api_service_id مرتبط با api_provider_id مشخص شده
        $sql = $wpdb->prepare(
            "SELECT api_service_id 
         FROM $table_name 
         WHERE api_provider_id = %d",
            $provider_id
        );

        // اجرای کوئری و ذخیره نتایج در یک آرایه
        $results = $wpdb->get_col($sql);

        // برگرداندن نتایج به صورت آرایه
        return $results;
    }

    public function getServicesByProvider($provider_id) {
        global $wpdb;

        // نام جدول دیتابیس
        $table_name = $wpdb->prefix . 'samyar_services';

        // کوئری برای دریافت api_service_id مرتبط با api_provider_id مشخص شده
        $sql = $wpdb->prepare(
            "SELECT * 
         FROM $table_name 
         WHERE api_provider_id = %d",
            $provider_id
        );

        // اجرای کوئری و ذخیره نتایج در یک آرایه
        // برگرداندن نتایج به صورت آرایه
        return $wpdb->get_results($sql, OBJECT);
    }


    public function getUserServiceFavorites($user_id) {

        if(!$user_id){
            return [];
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'samyar_service_favorites';
        $user_favorites = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT service_id FROM $table_name WHERE user_id = %d",
                $user_id
            )
        );

        return $user_favorites;
    }

}