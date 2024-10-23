<?php

namespace SAMPA\Inc\Woocommerce;

use WC_Product;
// use WC_Product_Simple;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'SAMPACustomProductType' ) )
{
    class SAMPACustomProductType extends WC_Product
    {
        private static $_instance = null;

        public string $product_type = 'package';

        public function __construct( $product )
        {
            $this->supports[]   = 'ajax_add_to_cart';
            parent::__construct( $product );
            $this->set_sold_individually( true );
        }

        public static function get_instance() {

            if ( self::$_instance == null ) {
                self::$_instance = new SAMPACustomProductType( null );
            }

            return self::$_instance;
        }

        /**
         * Return the product type
         *
         * @return string
         */
        public function get_type()
        {
            return $this->product_type;
        }

        public static function sampa_custom_product_type_class( $classname, $product_type )
        {
            if ( $product_type == 'package' ) {
                $classname = __CLASS__;
            }
            return $classname;
        }

        /**
         * Package Type
         *
         * @param array $types
         * @return void
         */
        public static function add_type( $types )
        {
            $types['package'] = __( 'Package', 'sampa' );
            return $types;
        }

        /**
         * Returns the product's active price.
         *
         * @param  string $context What the value is for. Valid values are view and edit.
         * @return string price
         */
        public function get_price( $context = 'view' )
        {
            return $this->get_prop( 'price', $context );
        }



        public static function sampa_hide_attributes_data_panel( $tabs )
        {
            // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
            $tabs['attribute']['class'][] = 'hide_if_package';
            $tabs['shipping']['class'][] = 'hide_if_package';
            $tabs['inventory']['class'][] = 'hide_if_package';

            return $tabs;
        }

        public static function package_product_type_show_price()
        {
            global $product_object;
            if ( $product_object ) {
               ?>
                <div class='options_group package_priod show_if_package'>
                    <?php
                    woocommerce_wp_text_input(
                        array(
                            'id'          => '_package_period',
                            'label'       => __( 'Package period (days)', 'sampa' ),
                            'value'       => $product_object->get_meta( '_package_period', true ),
                            'default'     => 0,
                            'type'        => 'number',
                            'placeholder' => __( 'Add package period (days)', 'sampa' ),
                            'data_type' => 'price'
                        )
                    );
                    ?>
                </div>
                <?php
            }
         }

        public static function enable_js_on_wc_product() {
            global $post, $product_object;

            if ( ! $post )
                return;

            if ( 'product' != $post->post_type )
                return;

            $is_package = $product_object && 'package' === $product_object->get_type() ? true : false;
            ?>
            <script type='text/javascript'>
                jQuery(document).ready(function () {
                    jQuery('.options_group.pricing').addClass('show_if_package').show();
                    jQuery('.general_options').show();
                    <?php if( $is_package ) { ?>
                        jQuery('#general_product_data .package_priod').show();
                    <?php } ?>
                });
             </script>
            <?php
        }

        public static function save_package_product_settings( $post_id )
        {
            $package_period = $_POST['_package_period'];

            if( ! empty( $package_period ) )
            {
                update_post_meta( $post_id, '_package_period', esc_attr( $package_period ) );
            }
        }

        public static function show_add_to_cart_button()
        {
            do_action( 'woocommerce_simple_add_to_cart' );
        }

        public static function add_to_cart_button_text()
        {
            return __('Add to cart', 'woocommerce');
        }

    }
}