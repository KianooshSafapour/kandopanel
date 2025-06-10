<?php

use samyar\Payment;
use samyar\walletController;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Samyar_Wallet_Balance_Details extends WP_List_Table {

	public function __construct() {
		parent::__construct( array(
			'singular' => 'transaction',
			'plural'   => 'transactions',
			'ajax'     => false,
			'screen'   => 'samyar-wallet',
		) );
		add_action( 'admin_footer', array( $this, 'add_js_scripts' ) );
	}

	public function get_columns() {
		return apply_filters( 'samyar_wallet_balance_details_columns', array(
			'cb'       => __( 'cb', SAMYAR_TEXT_DOMAIN ),
			'ID' => __( 'ID', SAMYAR_TEXT_DOMAIN ),
			'username' => __( 'Username', SAMYAR_TEXT_DOMAIN ),
			'name'     => __( 'Name', SAMYAR_TEXT_DOMAIN ),
			'email'    => __( 'Email', SAMYAR_TEXT_DOMAIN ),
			'balance'  => __( 'Remaining balance', SAMYAR_TEXT_DOMAIN ),
			'actions'  => __( 'Actions', SAMYAR_TEXT_DOMAIN ),
			'id'       => __( 'ID', SAMYAR_TEXT_DOMAIN )
		) );
	}

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items() {

		$usersearch     = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
		$users_per_page = $this->get_items_per_page( 'users_per_page', 15 );
		$paged          = $this->get_pagenum();
		$columns        = $this->get_columns();
		$hidden         = $this->get_hidden_columns();
		$sortable       = $this->get_sortable_columns();
		$args           = array(
			'blog_id' => $GLOBALS['blog_id'],
			'number'  => $users_per_page,
			'offset'  => ( $paged - 1 ) * $users_per_page,
			'search'  => $usersearch,
			'fields'  => 'all_with_meta'
		);

		if ( '' !== $args['search'] ) {
			$args['search'] = '*' . $args['search'] . '*';
		}

		if ( isset( $_REQUEST['role'] ) ) {
			$args['role'] = $_REQUEST['role'];
		}

		if ( isset( $_REQUEST['orderby'] ) ) {
			$args['orderby'] = $_REQUEST['orderby'];
		}

		if ( isset( $_REQUEST['order'] ) ) {
			$args['order'] = $_REQUEST['order'];
		}

		if ( isset( $args['orderby'] ) ) {
			if ( 'balance' === $args['orderby'] ) {
                $wallet_meta_key = walletController::getInstance()->get_meta_key();
				$args = array_merge(
					$args, array(
						// phpcs:ignore WordPress.VIP.SlowDBQuery.slow_db_query_meta_key
						'meta_key' => $wallet_meta_key,
						'orderby'  => 'meta_value_num',
					)
				);
			}
		}

		$args = apply_filters( 'samyar_wallet_users_list_table_query_args', $args );

		// Query the user IDs for this page
		$wp_user_search = new WP_User_Query( $args );
		$wallet         = walletController::getInstance();
		$data           = array();
		foreach ( $wp_user_search->get_results() as $user ) {
			$data[] = apply_filters( 'samyar_wallet_balance_details_list_table_item_data', array(
				'id'       => $user->ID,
				'username' => $user->data->user_login,
				'name'     => $user->data->display_name,
				'email'    => $user->data->user_email,
				'balance'  => $wallet->getUserCredit( $user->ID )['price_formatted'],
				'actions'  => ''
			), $user );
		}

		$this->_column_headers = array( $columns, $hidden, $sortable );


		$this->set_pagination_args( array(
			'total_items' => $wp_user_search->get_total(),
			'per_page'    => $users_per_page,
		) );
		$this->process_bulk_actions();

		$this->items           = $data;
	}

	/**
	 * Output 'no users' message.
	 *
	 * @since 3.1.0
	 */
	public function no_items() {
		_e( 'No users found.', SAMYAR_TEXT_DOMAIN );
	}

	/**
	 * Return an associative array listing all the views that can be used
	 * with this table.
	 *
	 * Provides a list of roles and user count for that role for easy
	 * Filtersing of the user table.
	 *
	 * @return array An array of HTML links, one for each view.
	 * @global string $role
	 *
	 * @since  1.3.8
	 *
	 */
	protected function get_views() {
		global $role;

		$wp_roles = wp_roles();

		$url           = 'admin.php?page=samyar-wallet';
		$users_of_blog = count_users();

		$total_users = $users_of_blog['total_users'];
		$avail_roles = &$users_of_blog['avail_roles'];
		unset( $users_of_blog );

		$current_link            = ( ! empty( $_REQUEST['role'] ) ? $_REQUEST['role'] : 'all' );
		$current_link_attributes = ( $current_link === 'all' ) ? ' class="current" aria-current="page"' : '';

		$role_links        = array();
		$role_links['all'] = "<a href='$url'$current_link_attributes>" . sprintf( _nx( 'All <span class="count">(%s)</span>', 'All <span class="count">(%s)</span>', $total_users, 'users', SAMYAR_TEXT_DOMAIN ), number_format_i18n((int) $total_users ) ) . '</a>';
		foreach ( $wp_roles->get_names() as $this_role => $name ) {
			if ( ! isset( $avail_roles[ $this_role ] ) ) {
				continue;
			}

			$current_link_attributes = '';
			$current_link_attributes = ( $current_link == $this_role ? ' class="current" aria-current="page"' : '' );

			$name = translate_user_role( $name );
			/* translators: User role name with count */
			$name                     = sprintf( __( '%1$s <span class="count">(%2$s)</span>', SAMYAR_TEXT_DOMAIN ), $name, number_format_i18n((int) $avail_roles[ $this_role ] ) );
			$role_links[ $this_role ] = "<a href='" . esc_url( add_query_arg( 'role', $this_role, $url ) ) . "'$current_link_attributes>$name</a>";
		}

		if ( ! empty( $avail_roles['none'] ) ) {

			$current_link_attributes = '';

			if ( 'none' === $role ) {
				$current_link_attributes = ' class="current" aria-current="page"';
			}

			$name = __( 'No role', SAMYAR_TEXT_DOMAIN );
			/* translators: User role name with count */
			$name               = sprintf( __( '%1$s <span class="count">(%2$s)</span>', SAMYAR_TEXT_DOMAIN ), $name, number_format_i18n((int) $avail_roles['none'] ) );
			$role_links['none'] = "<a href='" . esc_url( add_query_arg( 'role', 'none', $url ) ) . "'$current_link_attributes>$name</a>";
		}

		return $role_links;
	}

	/**
	 * Output extra table controls.
	 *
	 * @param string $which Whether this is being invoked above ("top")
	 *                      or below the table ("bottom").
	 *
	 * @since 1.3.8
	 *
	 */
	protected function extra_tablenav( $which ) {
		if ( 'top' === $which ) {
			echo( sprintf( "<label class='alignleft actions bulkactions'>%s(%s): <input name='amount' type='number' step='100' id='amount'></input></label>", __( 'Amount', SAMYAR_TEXT_DOMAIN ), get_option('site_currency','IRT') ) );
			echo( sprintf( "<label class='alignleft actions bulkactions'>%s: <input name='description' type='text' id='description'></input></label>", __( 'Description', SAMYAR_TEXT_DOMAIN ) ) );
		}
		do_action( 'samyar_wallet_users_list_extra_tablenav', $which );
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return array( 'id' );
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'username' => array( 'login', false ),
			'balance'  => array( 'balance', false ),
			'email'    => array( 'email', false ),
		);

		return apply_filters( 'samyar_wallet_balance_details_sortable_columns', $sortable_columns );
	}

	/**
	 * Define what data to show on each column of the table
	 *
	 * @param Array $item Data
	 * @param String $column_name - Current column name
	 *
	 * @return Mixed
	 */
	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'id':
			case 'ID':
			    return $item['id'];
			case 'username':
			case 'name':
			case 'email':
			case 'balance':
				return $item[ $column_name ];
			case 'actions':
				return '<p><a href="' . add_query_arg( array( 'page'    => 'samyar-wallet-add',
				                                              'user_id' => $item['id']
					), admin_url( 'admin.php' ) ) . '" class="button tips wallet-manage"></a> <a class="button tips wallet-view" href="' . add_query_arg( array( 'page'    => 'samyar-wallet-transactions',
				                                                                                                                                                 'user_id' => $item['id']
					), admin_url( 'admin.php' ) ) . '"></a></p>';
			case 'cb':
				return '<input type="checkbox" />';
			default:
				return apply_filters( 'samyar_wallet_balance_details_column_default', print_r( $item, true ), $column_name, $item );
		}
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET
	 *
	 * @return Mixed
	 */
	private function sort_data( $a, $b ) {
		// Set defaults
		$orderby = 'username';
		$order   = 'asc';
		// If orderby is set, use this as the sort column
		if ( ! empty( $_GET['orderby'] ) ) {
			$orderby = $_GET['orderby'];
		}
		// If order is set use this as the order
		if ( ! empty( $_GET['order'] ) ) {
			$order = $_GET['order'];
		}
		$result = strcmp( $a[ $orderby ], $b[ $orderby ] );
		if ( $order === 'asc' ) {
			return $result;
		}

		return - $result;
	}

	protected function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="users[]" value="%s" />', $item['id'] );
	}

	private function process_bulk_actions() {

        global $wpdb;

		if ( 'credit' === $this->current_action() && isset( $_POST['users'] ) ) {
			$credit_ids  = esc_sql( $_POST['users'] );
			$amount      = isset( $_POST['amount'] ) ? floatval( $_POST['amount'] ) : 0;
			$description = isset( $_POST['description'] ) ? $_POST['description'] : '';
			if ( $amount && $credit_ids ) {
				foreach ( $credit_ids as $id ) {

                    $wallet_meta_key = walletController::getInstance()->get_meta_key();
                    // افزایش اعتبار
                    $status = $wpdb->query(
                        $wpdb->prepare(
                            "UPDATE {$wpdb->usermeta} SET meta_value = CAST(meta_value AS DECIMAL(20,4)) + %s WHERE user_id = %d AND meta_key = %s",
                            $amount,
                            (int)$id,
                            $wallet_meta_key
                        )
                    );


					//اینجا می یایم یه تراکنش شارژ اعتبار اضافه می کنیم که کاربر متوجه بشه به خاطر چی بوده
					$payment = Payment::insert( [
						"uid"          => $id,
						"gateway"      => 'wallet',
						"amount"       => $amount,
						"payment_type" => 'add-credit',
						"status"       => 1,
						"note"         => $description,
						'created_at'   => current_time( 'mysql' )
					] );

//                    samyar_wallet()->wallet->credit($id, $amount, $description);
				}
			}
			header( "Refresh: 0" );
		}

		if ( 'debit' === $this->current_action() && isset( $_POST['users'] ) ) {
			$debit_ids   = esc_sql( $_POST['users'] );
			$amount      = isset( $_POST['amount'] ) ? floatval( $_POST['amount'] ) : 0;
			$description = isset( $_POST['description'] ) ? $_POST['description'] : '';
			if ( $amount && $debit_ids ) {
				foreach ( $debit_ids as $id ) {

                    $wallet_meta_key = walletController::getInstance()->get_meta_key();
                    // افزایش اعتبار
                    $status = $wpdb->query(
                        $wpdb->prepare(
                            "UPDATE {$wpdb->usermeta} SET meta_value = CAST(meta_value AS DECIMAL(20,4)) + %s WHERE user_id = %d AND meta_key = %s",
                            $amount,
                            (int)$id,
                            $wallet_meta_key
                        )
                    );

					//اینجا می یایم یه تراکنش شارژ اعتبار اضافه می کنیم که کاربر متوجه بشه به خاطر چی بوده
					$payment = Payment::insert( [
						"uid"          => $id,
						"gateway"      => 'wallet',
						"amount"       => $amount,
						"payment_type" => 'add-credit',
						"status"       => 1,
						"note"         => $description,
						'created_at'   => current_time( 'mysql' )
					] );
				}
			}
			header( "Refresh: 0" );
		}

		if ( 'delete_log' === $this->current_action() && isset( $_POST['users'] ) ) {
			$delete_ids = esc_sql( $_POST['users'] );
			if ( $delete_ids ) {
				foreach ( $delete_ids as $id ) {
					delete_user_wallet_transactions( $id, true );
				}
			}
			header( "Refresh: 0" );
		}

		do_action( 'samyar_wallet_balance_details_process_bulk_actions', $this->current_action() );
	}

	protected function get_bulk_actions() {
		$actions = apply_filters( 'samyar_wallet_balance_details_bulk_actions', array(
			'credit'     => __( 'Credit', SAMYAR_TEXT_DOMAIN ),
			'debit'      => __( 'Debit', SAMYAR_TEXT_DOMAIN ),
//			'delete_log' => __( 'Delete Log', SAMYAR_TEXT_DOMAIN )
		) );

		return $actions;
	}

	protected function bulk_actions( $which = '' ) {
		if ( 'bottom' === $which ) {
			return;
		}
		parent::bulk_actions( $which );
	}

	public function add_js_scripts() {
		$bulk_delete_log_msg = __( 'You are about to delete transaction records from database for selected users.', SAMYAR_TEXT_DOMAIN );
		?>
        <script type="text/javascript">
            jQuery(function ($) {
                $('.toplevel_page_woo-wallet #posts-filter').submit(function () {
                    if ($('[name="action"]').val() == 'delete_log' || $('[name="action2"]').val() == 'delete_log') {
                        return confirm('<?php echo $bulk_delete_log_msg; ?>');
                    }
                    return true;
                });
            });
        </script>
		<?php

	}

}
