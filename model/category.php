<?php

namespace samyar;

use TenQuality\WP\Database\Abstracts\DataModel;
use TenQuality\WP\Database\Traits\DataModelTrait;

class Category extends DataModel
{
    use DataModelTrait;

    /**
     * Data table name in database (without prefix).
     * @var string
     */
    const TABLE = 'samyar_categories';

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
     * WordPress database object.
     * @var \wpdb
     */
    private $wpdb;

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
     * Fetches categories with pagination.
     *
     * @param int $page
     * @param int $per_page
     * @param bool $is_admin
     * @return array
     */
    public function get_categories($page, $per_page, $is_admin)
    {
        global $wpdb;
        $offset = ($page - 1) * $per_page;

        $query = "SELECT * FROM {$wpdb->prefix}samyar_categories";
        if (!$is_admin) {
            $query .= " WHERE status = 1";
        }
        $query .= " ORDER BY sort ASC LIMIT %d OFFSET %d";

        return $wpdb->get_results($wpdb->prepare($query, $per_page, $offset));
    }


    /**
     * Fetches categories with pagination.
     *
     * @param int $page
     * @param int $per_page
     * @param bool $is_admin
     * @return array
     */
    public function get_category($category_id)
    {
        if (!$category_id) {
            return [];
        }

        global $wpdb;
        $query = "SELECT * FROM {$wpdb->prefix}samyar_categories WHERE status = 1 AND id=%d ORDER BY sort ASC";
        return $wpdb->get_results($wpdb->prepare($query, $category_id));
    }


    public function get_all_categories($page, $per_page, $is_admin)
    {
        global $wpdb;
        $offset = ($page - 1) * $per_page;

        $query = "SELECT * FROM {$wpdb->prefix}samyar_categories";

        $query .= " ORDER BY sort ASC LIMIT %d OFFSET %d";

        return $wpdb->get_results($wpdb->prepare($query, $per_page, $offset));
    }

    /**
     * Fetches total number of categories.
     *
     * @param bool $is_admin
     * @return int
     */
    public function get_total_categories($is_admin)
    {
        global $wpdb;
        $query = "SELECT COUNT(*) FROM {$wpdb->prefix}samyar_categories";
        if (!$is_admin) {
            $query .= " WHERE status = 1";
        }
        return $wpdb->get_var($query);
    }
}