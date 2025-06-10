<?php
namespace kandopanel;
// Load the parent class if it doesn't exist.
use WP_List_Table;


/**
 * Create Table
 */
if ( ! class_exists( 'report_table' ) ) :
    class users_report_table extends WP_List_Table {

        /**
         * Get a list of columns.
         *
         * @return array
         */
        public function get_columns() {
            return array(
                'display-name'      => wp_strip_all_tags( __( 'display name',SAMYAR_TEXT_DOMAIN) ),
                'info'   => wp_strip_all_tags( __( 'info',SAMYAR_TEXT_DOMAIN) ),
                'sum-charge'   => wp_strip_all_tags( __( 'sum charge',SAMYAR_TEXT_DOMAIN) ),
//                'sum-orders'   => wp_strip_all_tags( __( 'sum orders',SAMYAR_TEXT_DOMAIN) ),
            );
        }

        /**
         * Prepares the list of items for displaying.
         */
        public function prepare_items() {
            $columns  = $this->get_columns();
            $hidden   = array();
            $sortable = array();
            $primary  = 'display-name';
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
                case 'display-name':
                    return esc_html( $item['display-name'] );
                case 'info':
                    return esc_html( $item['info'] );
                case 'sum-charge':
                    return esc_html( $item['sum-charge'] );
//                case 'sum-orders':
//                    return esc_html( $item['sum-orders'] );
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