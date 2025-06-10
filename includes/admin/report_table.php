<?php
namespace kandopanel;
// Load the parent class if it doesn't exist.
use WP_List_Table;


/**
 * Create Table
 */
if ( ! class_exists( 'report_table' ) ) :
    class report_table extends WP_List_Table {

        /**
         * Get a list of columns.
         *
         * @return array
         */
        public function get_columns() {
            return array(
                'date'      => wp_strip_all_tags( __( 'date',SAMYAR_TEXT_DOMAIN) ),
                'order-count'   => wp_strip_all_tags( __( 'count',SAMYAR_TEXT_DOMAIN) ),
                'order-amount'   => wp_strip_all_tags( __( 'amount',SAMYAR_TEXT_DOMAIN) ),
                'order-formal-charge'   => wp_strip_all_tags( __( 'formal-charge',SAMYAR_TEXT_DOMAIN) ),
                'order-profit'   => wp_strip_all_tags( __( 'profit',SAMYAR_TEXT_DOMAIN) ),
            );
        }

        /**
         * Prepares the list of items for displaying.
         */
        public function prepare_items() {
            $columns  = $this->get_columns();
            $hidden   = array();
            $sortable = array();
            $primary  = 'date';
            $this->_column_headers = array( $columns, $hidden, $sortable, $primary );

        }

        /**
         * Generates content for a single row of the table.
         * 
         * @param object $item The current item.
         * @param string $column_name The current column name.
         */
        protected function column_default( $item, $column_name ) {
            switch ( $column_name ) {
                case 'date':
                    return esc_html( $item['date'] );
                case 'order-count':
                    return esc_html( $item['order-count'] );
                case 'order-amount':
                    return esc_html( $item['order-amount'] );
                case 'order-formal-charge':
                    return esc_html( $item['order-formal-charge'] );
                case 'order-profit':
                    return esc_html( $item['order-profit'] );
                return 'Unknown';
            }
        }

        /**
         * Generates custom table navigation to prevent conflicting nonces.
         * 
         * @param string $which The location of the bulk actions: 'top' or 'bottom'.
         */
        protected function display_tablenav( $which ) {
            ?>
            <div class="tablenav <?php echo esc_attr( $which ); ?>">

                <div class="alignleft actions bulkactions">
                    <?php $this->bulk_actions( $which ); ?>
                </div>
                <?php
                $this->extra_tablenav( $which );
                $this->pagination( $which );
                
                ?>

                <br class="clear" />
            </div>
            <?php
        }

        /**
         * Generates content for a single row of the table.
         *
         * @param object $item The current item.
         */
        public function single_row( $item ) {
            echo '<tr>';
            $this->single_row_columns( $item );
            echo '</tr>';
        }
    }
endif;