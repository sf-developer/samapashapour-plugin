<?php

namespace SAMPA\Inc\Ajax;

defined( 'ABSPATH' ) || exit; // Prevent direct access

use Morilog\Jalali\Jalalian;

if( ! class_exists( 'SAMPAMonthlyReportsForAdmin' ) )
{
    class SAMPAMonthlyReportsForAdmin
    {

        /**
         * Getting monthly reports from database ajax callback
         *
         * @return void
         */
        public static function handler(): void
        {
            ! check_ajax_referer('sampa_action', 'nonce', false)
                and wp_send_json_error(array( 'message' => __('Security error!', 'sampa'), 'code' => 401 ));

            global $wpdb;
            $table_name = $wpdb->prefix . 'sampa_monthly_reports';
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `ID`, `user_id`, `measurement`, `about`, `creation_date` FROM {$table_name} ORDER BY `creation_date` ASC"
                )
            );

            if( empty( $results ) )
                wp_send_json_error( array( 'message' => __('There is no record for monthly reports!', 'sampa') ) );

            $monthly_reports = [];

            if( is_array( $results ) )
            {
                foreach( $results as $result )
                {
                    if( strpos( get_locale(), 'fa' ) === 0 )
                    {
                        include_once( SAMPA_PATH . 'vendor/autoload.php' );
                        $date = Jalalian::forge( $result->creation_date )->format( '%A, %d %B %Y - H:i:s' );
                    }else {
                        $date = date( 'd/m/Y - H:i:s', $result->creation_date );
                    }
                    $measurements = maybe_unserialize( $result->measurement );
                    $user = get_userdata( $result->user_id );
                    if( ! empty( $measurements ) && is_array( $measurements ) )
                    {
                        $i = 1;
                        foreach( $measurements as $measurement )
                        {
                            $monthly_reports[] = [
                                $i,
                                '<a href="' . get_edit_user_link( $result->user_id ) . '">' . $user->user_login . '</a>',
                                $measurement['chest'],
                                $measurement['left_arm'],
                                $measurement['right_arm'],
                                $measurement['waist'],
                                $measurement['belly'],
                                $measurement['hip'],
                                $measurement['left_thigh'],
                                $measurement['right_thigh'],
                                $measurement['left_leg'],
                                $measurement['right_leg'],
                                $result->about,
                                $date
                            ];
                        }
                        $i++;
                    }
                }
                wp_send_json_success( array( 'data' => $monthly_reports ) );
            }
            wp_send_json_error( array( 'message' => __('Error occurred on giving data from database!', 'sampa') ) );
        }
    }
}