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

}