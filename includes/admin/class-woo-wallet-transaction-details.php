<?php

use samyar\Payment;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Samyar_Wallet_Transaction_Details extends WP_List_Table {

	/**
	 * Total number of found users for the current query
	 *
	 * @since 3.1.0
	 * @var int
	 */
	private $total_count = 0;

	public function __construct() {
		parent::__construct( array(
			'singular' => 'transaction',
			'plural'   => 'transactions',
			'ajax'     => false,
			'screen'   => 'samyar-wallet-transactions',
		) );
	}

	public function get_columns() {
		return apply_filters( 'manage_samyar_wallet_transactions_columns', array(
			'name'           => __( 'Name', SAMYAR_TEXT_DOMAIN ),
			'type'           => __( 'Type', SAMYAR_TEXT_DOMAIN ),
			'amount'         => __( 'Amount', SAMYAR_TEXT_DOMAIN ),
			'details'        => __( 'Details', SAMYAR_TEXT_DOMAIN ),
//            'created_by' => __('Created By', SAMYAR_TEXT_DOMAIN),
			'date'           => __( 'Date', SAMYAR_TEXT_DOMAIN ),
			'transaction_id' => __( 'ID', SAMYAR_TEXT_DOMAIN )
		) );
	}

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$perPage     = $this->get_items_per_page( 'transactions_per_page', 10 );
		$currentPage = $this->get_pagenum();

		$data                  = $this->table_data( ( $currentPage - 1 ) * $perPage, $perPage );
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $data;

		$this->set_pagination_args( array(
			'total_items' => $this->total_count,
			'per_page'    => $perPage
		) );
	}

	/**
	 * Output 'no users' message.
	 *
	 * @since 3.1.0
	 */
	public function no_items() {
		_e( 'No transactions found.', SAMYAR_TEXT_DOMAIN );
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return array( 'transaction_id' );
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		return array();
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data( $lower = 0, $uper = 10 ) {
		global $wpdb;
		$data    = array();
		$user_id = filter_input( INPUT_GET, 'user_id' );
		if ( $user_id == null ) {
			return $data;
		}
		$transactions      = Payment::where( [ 'uid' => $user_id ,'limit' => $uper,'offset'=>$lower,"order_by"=>"created_at" ,'order'=>"DESC"] );
		$this->total_count = Payment::count( [ 'uid' => $user_id ] );
//        $transactions = get_wallet_transactions( array( 'user_id' => $user_id, 'limit' => $lower . ',' . $uper ) );
//        $this->total_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->base_prefix}samyar_wallet_transactions WHERE user_id={$user_id}" );

		if ( $transactions ) {

			foreach ( $transactions as $transaction ) {

				$data[] = array(
					'transaction_id' => $transaction->id,
					'name'           => get_user_by( 'ID', $transaction->uid )->display_name,
					'type'           => ( 'add-credit' === $transaction->payment_type ) || ( 'refund' === $transaction->payment_type ) ? __( 'Credit', SAMYAR_TEXT_DOMAIN ) : __( 'Debit', SAMYAR_TEXT_DOMAIN ),
					'amount'         => number_format($transaction->amount).' تومان ',
					'details'        => $transaction->note,
//                    'created_by'     => get_user_by('ID', $transaction->created_by) ? '<a href="'.add_query_arg( 'user_id', $transaction->created_by, self_admin_url( 'user-edit.php')).'">'.get_user_by('ID', $transaction->created_by)->display_name . '</a>' : '-',
					'date'           => date_i18n( 'd M Y، H:i',strtotime($transaction->created_at) )
				);
			}
		}

		return $data;
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
			case 'transaction_id':
			case 'name':
			case 'type':
			case 'amount':
			case 'details':
//            case 'created_by':
			case 'date':
				return $item[ $column_name ];
			default:
				return apply_filters( 'samyar_wallet_transaction_details_column_default', print_r( $item, true ), $column_name, $item );
		}
	}

}
