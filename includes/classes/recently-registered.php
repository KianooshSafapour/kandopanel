<?php
namespace samyar;
class SamyarRegisterDate {

	/**
	 * Let's get this party started
	 *
	 * @since 3.4
	 * @access public
	 */

	public function __construct() {
		add_action( 'init', array( &$this, 'init' ) );
	}


	/**
	 * All init functions
	 *
	 * @since 3.4
	 * @access public
	 */

	public function init() {
		add_filter( 'manage_users_columns', array( $this,'users_columns') );
		add_action( 'manage_users_custom_column',  array( $this ,'users_custom_column'), 10, 3);
		add_filter( 'manage_users_sortable_columns', array( $this ,'users_sortable_columns') );
		add_filter( 'request', array( $this ,'users_orderby_column') );
	}

	/**
	 * Registers column for display
	 *
	 * @since 2.0
	 * @access public
	 */

	public static function users_columns($columns) {
		$columns['registerdate'] = _x('Registered', 'user', SAMYAR_TEXT_DOMAIN);
		return $columns;
	}

	/**
	 * Handles the registered date column output.
	 * 
	 * This uses the same code as column_registered, which is why
	 * the date isn't filterable.
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @global string $mode
	 */

	public static function users_custom_column( $value, $column_name, $user_id ) {

		global $mode;
		$mode = empty( $_REQUEST['mode'] ) ? 'list' : $_REQUEST['mode'];

		if ( 'registerdate' != $column_name ) {
			return $value;
		} else {
			$user = get_userdata( $user_id );

			if ( is_multisite() && ( 'list' == $mode ) ) {
				$formated_date = __( 'Y/m/d' );
			} else {
				$formated_date = __( 'Y/m/d g:i:s a' );
			}

			$registered   = strtotime(get_date_from_gmt($user->user_registered));
			$registerdate = '<span>'. date_i18n( $formated_date, $registered ) .'</span>' ;

			return $registerdate;
		}
	}

	/**
	 * Makes the column sortable
	 *
	 * @since 1.0
	 * @access public
	 */

	public static function users_sortable_columns($columns) {
		$custom = array(
			// meta column id => sortby value used in query
			'registerdate'    => 'registered',
		);
		return wp_parse_args($custom, $columns);
	}

	/**
	 * Calculate the order if we sort by date.
	 *
	 * @since 1.0
	 * @access public
	 */
	public static function users_orderby_column( $vars ) {
		if ( isset( $vars['orderby'] ) && 'registerdate' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'registerdate',
				'orderby'  => 'meta_value'
			) );
		}
		return $vars;
	}


}

new SamyarRegisterDate();