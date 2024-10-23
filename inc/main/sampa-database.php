<?php

namespace SAMPA\Inc\Main;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'SAMPADataBase' ) )
{

    class SAMPADataBase
    {
        /**
         * Create database tables on plugin activation
         *
         * @return void
         */
        public static function add_tables(): void
        {
            global $wpdb;
            $table_prefix = $wpdb->prefix; // Get tables prefix
            $charset_collate = $wpdb->get_charset_collate(); // Get table charset collate
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // For calling dbDelta function

            /********** Create monthly reports table **********/
            $monthly_report_table_name = $table_prefix . 'sampa_monthly_reports';

            $monthly_report_table = "CREATE TABLE IF NOT EXISTS $monthly_report_table_name (

                `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` bigint(20) NOT NULL DEFAULT 0,
                `measurement` text NOT NULL,
                `about` text NOT NULL DEFAULT '',
                `end_month` text DEFAULT NULL,
                `begining_weight` varchar(11) DEFAULT NULL,
                `ending_weight` varchar(11) DEFAULT NULL,
                `award` text DEFAULT NULL,
                `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

                PRIMARY KEY (`ID`)

            ) $charset_collate;";

            dbDelta($monthly_report_table); // Create monthly reports table

            /********** Create daily reports table **********/
            $daily_report_table_name = $table_prefix . 'sampa_daily_reports';

            $daily_report_table = "CREATE TABLE IF NOT EXISTS $daily_report_table_name (

                `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` bigint(20) NOT NULL DEFAULT 0,
                `nutrition` varchar(255) NOT NULL DEFAULT '',
                `sport` varchar(255) NOT NULL DEFAULT '',
                `sleep` varchar(255) NOT NULL DEFAULT '',
                `expenses` varchar(255) NOT NULL DEFAULT '',
                `note` text NOT NULL DEFAULT '',
                `motivational_sentence` text NOT NULL DEFAULT '',
                `water` tinyint(1) NOT NULL DEFAULT 0,
                `thanksgiving` text NOT NULL DEFAULT '',
                `today_work` text NOT NULL DEFAULT '',
                `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

                PRIMARY KEY (`ID`)

            ) $charset_collate;";

            dbDelta($daily_report_table); // Create daily report table

            /********** Create personal info table **********/
            $personal_info_table_name = $table_prefix . 'sampa_personal_info';

            $personal_info_table = "CREATE TABLE IF NOT EXISTS $personal_info_table_name (

                `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` bigint(20) NOT NULL DEFAULT 0,
                `my_name` varchar(255) NOT NULL DEFAULT '',
                `my_height` int NOT NULL DEFAULT 0,
                `my_weight` int NOT NULL DEFAULT 0,
                `my_age` int NOT NULL DEFAULT 0,
                `my_number` varchar(11) NOT NULL DEFAULT '',
                `my_goal` text NOT NULL DEFAULT '',
                `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

                PRIMARY KEY (`ID`)

            ) $charset_collate;";

            dbDelta($personal_info_table); // Create daily report table
        }
    }
}