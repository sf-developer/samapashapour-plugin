<?php

namespace SAMPA\Inc\Ajax;

defined( 'ABSPATH' ) || exit; // Prevent direct access

use Morilog\Jalali\Jalalian;

if( ! class_exists( 'SAMPADailyReportsForAdmin' ) )
{
    class SAMPADailyReportsForAdmin
    {

        /**
         * Getting daily reports from database ajax callback
         *
         * @return void
         */
        public static function handler(): void
        {
            ! check_ajax_referer('sampa_action', 'nonce', false)
                and wp_send_json_error(array( 'message' => __('Security error!', 'sampa'), 'code' => 401 ));

            global $wpdb;
            $table_name = $wpdb->prefix . 'sampa_daily_reports';
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `ID`, `user_id`, `nutrition`, `sport`, `sleep`, `expenses`, `note`, `motivational_sentence`, `water`, `thanksgiving`, `today_work`, `creation_date` FROM {$table_name} ORDER BY `creation_date` ASC"
                )
            );

            if( empty( $results ) )
                wp_send_json_error( array( 'message' => __('There is no record for daily reports!', 'sampa') ) );

            $daily_reports = [];

            if( is_array( $results ) )
            {
                $i = 1;
                foreach( $results as $result )
                {
                    if( strpos( get_locale(), 'fa' ) === 0 )
                    {
                        include_once( SAMPA_PATH . 'vendor/autoload.php' );
                        $date = Jalalian::forge( $result->creation_date )->format( '%A, %d %B %Y - H:i:s' );
                    }else {
                        $date = date( 'd/m/Y - H:i:s', $result->creation_date );
                    }
                    $user = get_userdata( $result->user_id );
                    $daily_reports[] = [
                        $i,
                        '<a href="' . get_edit_user_link( $result->user_id ) . '">' . $user->display_name . '</a>',
                        $result->nutrition,
                        $result->sport,
                        $result->sleep,
                        $result->expenses,
                        $result->water,
                        $result->today_work,
                        $result->motivational_sentence,
                        $result->thanksgiving,
                        $result->note,
                        $date
                    ];
                    $i++;
                }
                wp_send_json_success( array( 'data' => $daily_reports ) );
            }
            wp_send_json_error( array( 'message' => __('Error occurred on giving data from database!', 'sampa') ) );
        }
    }
}