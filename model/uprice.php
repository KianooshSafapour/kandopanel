<?php

namespace samyar;
use TenQuality\WP\Database\Abstracts\DataModel;
use TenQuality\WP\Database\Traits\DataModelTrait;

class Uprice extends DataModel
{
    use DataModelTrait;
    /**
     * Data table name in database (without prefix).
     * @var string
     */
    const TABLE = 'samyar_user_price';
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
     * Model properties, data column list.
     * @var string
     */
//  protected $attributes = [
//     'model_id',
//     'name',
//  ];

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
     * Inserts multiple rows into the database in a single, efficient query.
     * این تابع چندین ردیف داده را با یک کوئری به دیتابیس اضافه می‌کند.
     *
     * @param array $rows An array of associative arrays, where each inner array represents a row to be inserted.
     * آرایه‌ای از آرایه‌های انجمنی که هر کدام یک ردیف برای درج هستند.
     *
     * @return bool|int False on error, or the number of rows inserted on success.
     * در صورت خطا false و در صورت موفقیت، تعداد ردیف‌های درج شده را برمی‌گرداند.
     */
    public static function bulk_insert(array $rows)
    {
        global $wpdb;

        // اگر آرایه ورودی خالی است، عملیات را متوقف کن
        if (empty($rows)) {
            return false;
        }

        // نام جدول به همراه پیشوند وردپرس
        $table_name = $wpdb->prefix . self::TABLE;

        // استخراج نام ستون‌ها از کلیدهای اولین ردیف داده
        $columns = array_keys(reset($rows));
        $column_sql = '`' . implode('`, `', $columns) . '`';

        // آماده‌سازی بخش VALUES کوئری برای ورود گروهی
        $sql = "INSERT INTO `$table_name` ($column_sql) VALUES ";

        $placeholders = [];
        $all_values = [];
        foreach ($rows as $row) {
            // اطمینان از اینکه ترتیب مقادیر با ستون‌ها یکسان است
            $row_values = [];
            foreach ($columns as $column) {
                $row_values[] = $row[$column] ?? null;
            }

            // تعیین نوع placeholder برای هر مقدار
            $question_marks = [];
            foreach ($row_values as $value) {
                if (is_int($value)) {
                    $question_marks[] = '%d';
                } else if (is_float($value)) {
                    $question_marks[] = '%f';
                } else {
                    $question_marks[] = '%s';
                }
                $all_values[] = $value;
            }
            $placeholders[] = '(' . implode(', ', $question_marks) . ')';
        }

        $sql .= implode(', ', $placeholders);

        // آماده‌سازی و اجرای کوئری نهایی
        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        return $wpdb->query($wpdb->prepare($sql, $all_values));
    }
}