<?php

namespace SAMPA\Inc\Woocommerce;

use SAMPA\Inc\SAMPAHelper;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if ( !class_exists( 'SAMPARegisterEndPoint' ) ) {

    class SAMPARegisterEndPoint {

        /**
         * Add new item endpoint
         *
         * @return void
         */
        public static function add_endpoint(): void
        {
            if( self::is_user_buy_plan() )
            {
                if( ! self::is_user_plan_expire() )
                {
                    add_rewrite_endpoint( 'sampa-add', EP_ROOT | EP_PAGES );
                }
                add_rewrite_endpoint( 'sampa-reports', EP_ROOT | EP_PAGES );
                flush_rewrite_rules();
            }
        }

        /**
         * Add new order query var.
         *
         * @param array $vars vars.
         * @return array An array of items.
         */
        public static function sampa_query_vars( $vars )
        {
            if( self::is_user_buy_plan() )
            {
                if( ! self::is_user_plan_expire() )
                {
                    $vars[] = 'sampa-add';
                }
                $vars[] = 'sampa-reports';
            }
            return $vars;
        }

        /**
         * Add sampa tabs in my account page.
         *
         * @param array $items myaccount Items.
         * @return array Items including New tab.
         */
        public static function add_sampa_item_tab( $items )
        {
            if( self::is_user_buy_plan() )
            {
                $download = $items['downloads'];
                $eidt_address = $items['edit-address'];
                $eidt_account = $items['edit-account'];
                $logout = $items['customer-logout'];
                unset( $items['downloads'] );
                unset( $items['edit-address'] );
                unset( $items['edit-account'] );
                unset( $items['customer-logout'] );
                if( ! self::is_user_plan_expire() )
                {
                    $items['sampa-add'] = __( 'New report', 'sampa' );
                }
                $items['sampa-reports'] = __( 'Reports', 'sampa' );
                $items['downloads'] = $download;
                $items['edit-address'] = $eidt_address;
                $items['edit-account'] = $eidt_account;
                $items['customer-logout'] = $logout;
            }
            return $items;
        }

        /**
         * Add content to add new report tab.
         *
         * @return void
         */
        public static function add_item_content()
        {
            if( self::is_user_buy_plan() && ! self::is_user_plan_expire() )
            {
                include_once( SAMPA_PATH . 'views/public/add-report.php' );
            }
        }

        /**
         * Add content to reports tab.
         *
         * @return void
         */
        public static function reports_item_content()
        {
            if( self::is_user_buy_plan() )
            {
                include_once( SAMPA_PATH . 'views/public/reports.php' );
            }
        }

        /**
         * Check if user buy plan
         *
         * @return bool
         */
        private static function is_user_buy_plan()
        {
            $current_user_package_time = get_user_meta( get_current_user_id(), '_sampa_package_time', true );
            return ! empty( $current_user_package_time );
        }

        /**
         * Check if user plan expire
         *
         * @return bool
         */
        private static function is_user_plan_expire()
        {
            return SAMPAHelper::get_remaining_days() == 0 ? true : false;
        }
    }
}