<?php

namespace SAMPA\Inc;

defined( 'ABSPATH' ) || exit; // Prevent direct access

use WC_Order;

if( ! class_exists( 'SAMPALoader' ) )
{
    class SAMPALoader
    {

        public function __construct()
        {
            // Inclutions
            include_once( SAMPA_PATH . 'inc/main/sampa-menu.php' );
            include_once( SAMPA_PATH . 'vendor/autoload.php' );
            include_once( SAMPA_PATH . 'inc/sampa-helper.php' );
            include_once( SAMPA_PATH . 'inc/woocommerce/sampa-register-endpoint.php' );
            include_once( SAMPA_PATH . 'inc/woocommerce/sampa-custom-product-type.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-save-personal-info-form.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-save-daily-form.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-update-daily-form.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-save-monthly-form.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-update-monthly-form.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-daily-reports.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-daily-reports-for-admin.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-monthly-reports.php' );
            include_once( SAMPA_PATH . 'inc/ajax/sampa-monthly-reports-for-admin.php' );

            // Main hooks
            add_action( 'admin_menu', array( 'SAMPA\Inc\Main\SAMPAMenu', 'add_menu' ) ); // Add plugin menus

            // Woocommerce hooks
            // Adding custom tabs to woocommerce myaccount page
            add_action( 'init', array( 'SAMPA\Inc\Woocommerce\SAMPARegisterEndPoint', 'add_endpoint' ) ); // Add custom endpoint to wc my account
            add_filter( 'query_vars', array( 'SAMPA\Inc\Woocommerce\SAMPARegisterEndPoint', 'sampa_query_vars' ) );
            add_filter( 'woocommerce_account_menu_items', array( 'SAMPA\Inc\Woocommerce\SAMPARegisterEndPoint', 'add_sampa_item_tab' ) );
            add_action( 'woocommerce_account_sampa-add_endpoint', array( 'SAMPA\Inc\Woocommerce\SAMPARegisterEndPoint', 'add_item_content' ) );
            add_action( 'woocommerce_account_sampa-reports_endpoint', array( 'SAMPA\Inc\Woocommerce\SAMPARegisterEndPoint', 'reports_item_content' ) );

            // Adding custom product type to woocommerce
            add_action( 'init', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'get_instance' ) ); // Add custom product typr to WC
            add_filter( 'product_type_selector', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'add_type' ) );
            add_filter( 'woocommerce_product_class', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'sampa_custom_product_type_class' ), 10, 2 );
            add_filter( 'woocommerce_product_data_tabs', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'sampa_hide_attributes_data_panel' ), 10,1 );
            add_action( 'woocommerce_product_options_general_product_data', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'package_product_type_show_price' ) );
            add_action( 'admin_footer', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'enable_js_on_wc_product' ) );
            add_action( 'woocommerce_process_product_meta', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'save_package_product_settings' ) );
            add_action( 'woocommerce_package_add_to_cart', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'show_add_to_cart_button' ) );
            add_filter( 'woocommerce_product_add_to_cart_text', array( 'SAMPA\Inc\Woocommerce\SAMPACustomProductType', 'add_to_cart_button_text' ) );

            // Ajax hooks
            add_action( 'wp_ajax_sampa_save_daily_form', array( 'SAMPA\Inc\Ajax\SAMPASaveDailyForm', 'handler' ) ); // Save form ajax callback
            add_action( 'wp_ajax_sampa_update_daily_form', array( 'SAMPA\Inc\Ajax\SAMPAUpdateDailyForm', 'handler' ) ); // Update form ajax callback
            add_action( 'wp_ajax_sampa_save_monthly_form', array( 'SAMPA\Inc\Ajax\SAMPASaveMonthlyForm', 'handler' ) ); // Save form ajax callback
            add_action( 'wp_ajax_sampa_update_monthly_form', array( 'SAMPA\Inc\Ajax\SAMPAUpdateMonthlyForm', 'handler' ) ); // Update form ajax callback
            add_action( 'wp_ajax_sampa_daily_reports', array( 'SAMPA\Inc\Ajax\SAMPADailyReports', 'handler' ) ); // Get daily reports ajax callback
            add_action( 'wp_ajax_sampa_daily_reports_for_admin', array( 'SAMPA\Inc\Ajax\SAMPADailyReportsForAdmin', 'handler' ) ); // Get daily reports ajax callback
            add_action( 'wp_ajax_sampa_monthly_reports', array( 'SAMPA\Inc\Ajax\SAMPAMonthlyReports', 'handler' ) ); // Get monthly reports ajax callback
            add_action( 'wp_ajax_sampa_monthly_reports_for_admin', array( 'SAMPA\Inc\Ajax\SAMPAMonthlyReportsForAdmin', 'handler' ) ); // Get monthly reports ajax callback

            // Update user meta based on order item
            add_action( 'woocommerce_checkout_order_processed', array( $this, 'update_user_meta_based_on_order_items' ) ); // woocommerce_payment_complete

            // Remove package on cancel order
            add_action( 'woocommerce_order_status_cancelled', array( $this, 'remove_sampa_package' ), 21, 1 );
            add_action( 'before_delete_post', array( $this, 'remove_sampa_package' ), 1, 1 );
        }

        public function update_user_meta_based_on_order_items( $order_id )
        {
            $order = new WC_Order( $order_id );
            $items = $order->get_items();
            $current_time = strtotime( wp_date( 'Y-m-d H:i:s' ) );
            $current_user_package_time = get_user_meta( $order->user_id, '_sampa_package_time', true );
            if( ! empty( $current_user_package_time ) && intval( $current_user_package_time ) >= $current_time )
            {
                $current_user_package_days = wp_date( 'd', intval( $current_user_package_time ) - $current_time );
            }else {
                $current_user_package_days = 0;
            }
           foreach ( $items as $item )
           {
                $product = $item->get_product();

                if ( $order->user_id > 0 && $product->get_type() === 'package' )
                {
                    $product_package_expiry_time = get_post_meta( $product->get_id(), '_package_period', true );
                    if( ! empty( $product_package_expiry_time ) ) {
                        $total_user_package_expiry_time = intval( $current_user_package_days ) + intval( $product_package_expiry_time );
                        update_user_meta( $order->user_id, '_sampa_package_expire_date', wp_date( 'Y-m-d', strtotime( wp_date('Y-m-d') . '+' . $total_user_package_expiry_time . ' day' ) ) );
                        update_user_meta( $order->user_id, '_sampa_package_time', $current_time + ( 86400 * intval( $total_user_package_expiry_time ) ) );
                        update_user_meta( $order->user_id, '_sampa_package', $product->get_id() );
                        update_user_meta( $order->user_id, '_sampa_package_period', $product_package_expiry_time );
                    }
                }
            }
        }

        public function remove_sampa_package( $id )
        {
            $post_type = get_post_type( $id );
            if ($post_type !== 'shop_order') {
                return;
            }

            $order = new WC_Order( $id );
            $items = $order->get_items();
            foreach ( $items as $item )
            {
                $product = $item->get_product();
                if ( $order->user_id > 0 && $product->get_type() === 'package' )
                {
                    delete_user_meta( $order->user_id, '_sampa_package_time' );
                    delete_user_meta( $order->user_id, '_sampa_package' );
                    delete_user_meta( $order->user_id, '_sampa_package_period' );
                }
            }
        }
    }
}