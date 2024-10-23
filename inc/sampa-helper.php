<?php

namespace SAMPA\Inc;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'SAMPAHelper' ) )
{
    class SAMPAHelper
    {
        public static function get_expire_date()
        {
            return get_user_meta( get_current_user_id(), '_sampa_package_expire_date', true );
        }

        public static function get_remaining_days()
        {
            $expire_date = self::get_expire_date();
            return $expire_date ? intval( ( strtotime( $expire_date ) - strtotime( wp_date( 'Y-m-d' ) ) ) / 86400 ) : 0;
        }

        public static function is_persoanl_info_filled( $current_user_id )
        {
            return get_user_meta( $current_user_id, 'is_personal_info_filled', true );
        }

        public static function get_presonal_info( $current_user_id )
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'sampa_personal_info';

            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `my_name`, `my_height`, `my_weight`, `my_age`, `my_number`, `my_goal` FROM {$table_name} WHERE `user_id` = %d",
                    $current_user_id
                )
            );
        }

        public static function get_today_report( $current_user_id )
        {
            global $wpdb;
            $daily_report_table_name = $wpdb->prefix . 'sampa_daily_reports';

            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `ID`, `nutrition`, `sport`, `sleep`, `expenses`, `note`, `motivational_sentence`, `water`, `thanksgiving`, `today_work` FROM {$daily_report_table_name} WHERE `user_id` = %d AND DATE(`creation_date`) = %s",
                    $current_user_id,
                    date( 'Y-m-d' )
                )
            );
        }

        public static function get_this_month_report( $current_user_id )
        {
            global $wpdb;
            $monthly_report_table_name = $wpdb->prefix . 'sampa_monthly_reports';

            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `ID`, `measurement`, `about`, `end_month`, `begining_weight`, `ending_weight`, `award` FROM {$monthly_report_table_name} WHERE `user_id` = %d AND DATE(`creation_date`) = %s",
                    $current_user_id,
                    date( 'Y-m-d' )
                )
            );
        }
    }
}