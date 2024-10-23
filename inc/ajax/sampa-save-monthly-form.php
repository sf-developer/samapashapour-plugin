<?php

namespace SAMPA\Inc\Ajax;

defined( 'ABSPATH' ) || exit; // Prevent direct access

use SAMPA\Inc\SAMPAHelper;

if( ! class_exists( 'SAMPASaveMonthlyForm' ) )
{
    class SAMPASaveMonthlyForm
    {

        /**
         * Saving form ajax callback
         *
         * @return void
         */
        public static function handler(): void
        {
            ! check_ajax_referer('sampa_action', 'nonce', false)
                and wp_send_json_error(array( 'message' => __('Security error!', 'sampa'), 'code' => 401 ));

            $user_id = wp_strip_all_tags($_POST['user_id']);
            $form_items = $_POST['form_items'];
            $daily_items = $_POST['daily_items'];
            $first_time = $_POST['first_time'];
            $about = $_POST['about'];

            date_default_timezone_set( 'Asia/Tehran' );
            $local_time  = current_datetime();
            $current_time = $local_time->getTimestamp() + $local_time->getOffset();

            if( $first_time )
            {
                $personal_items = $_POST['personal_items'];
            } else {
                $end_month_items = $_POST['end_month_items'];
                $begining_weight = $_POST['begining_weight'];
                $ending_weight = $_POST['ending_weight'];
                $award = $_POST['award'];
            }

            if( empty( $form_items ) || empty( $user_id ) || empty( $about ) || empty( $daily_items ) )
            {
                wp_send_json_error( array( 'message' => __('One or more values are empty', 'sampa') ) );

                if( $first_time && empty( $personal_items ) )
                {
                    wp_send_json_error( array( 'message' => __('One or more values are empty', 'sampa') ) );
                } else {
                    if( empty( $end_month_items ) || empty( $begining_weight ) || empty( $ending_weight ) || empty( $award ) )
                        wp_send_json_error( array( 'message' => __('One or more values are empty', 'sampa') ) );
                }
            }

            global $wpdb;

            $daily_table_name = $wpdb->prefix . 'sampa_daily_reports';

            $is_daily_exists = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `ID` FROM {$daily_table_name} WHERE `user_id` = %d AND DATE(`creation_date`) = %s",
                    $user_id,
                    date( 'Y-m-d', $current_time )
                )
            );

            if( empty( $is_daily_exists ) )
            {
                $wpdb->insert(
                    $daily_table_name,
                    [
                        'user_id' => intval( $user_id ),
                        'nutrition' => $daily_items[0]['nutrition'],
                        'sport' => $daily_items[0]['sport'],
                        'sleep' => $daily_items[0]['sleep'],
                        'expenses' => $daily_items[0]['expenses'],
                        'note' => $daily_items[0]['note'],
                        'motivational_sentence' => $daily_items[0]['motivational_sentence'],
                        'water' => intval( $daily_items[0]['water'] ),
                        'thanksgiving' => $daily_items[0]['thanksgiving'],
                        'today_work' => $daily_items[0]['works'],
                        'creation_date' => date( 'Y-m-d H:i:s', $current_time ),
                        'update_date' => date( 'Y-m-d H:i:s', $current_time )
                    ],
                    [ '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s' ]
                );
            } else {
                $wpdb->update(
                    $daily_table_name,
                    [
                        'ID' => intval( $is_daily_exists[0]->ID )
                    ],
                    [
                        'nutrition' => $daily_items[0]['nutrition'],
                        'sport' => $daily_items[0]['sport'],
                        'sleep' => $daily_items[0]['sleep'],
                        'expenses' => $daily_items[0]['expenses'],
                        'note' => $daily_items[0]['note'],
                        'motivational_sentence' => $daily_items[0]['motivational_sentence'],
                        'water' => intval( $daily_items[0]['water'] ),
                        'thanksgiving' => $daily_items[0]['thanksgiving'],
                        'today_work' => $daily_items[0]['works'],
                        'update_date' => date( 'Y-m-d H:i:s', $current_time )
                    ],
                    [ '%d' ],
                    [ '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s' ]
                );
            }

            if( $first_time )
            {
                $table_name = $wpdb->prefix . 'sampa_personal_info';

                if( get_user_meta( $user_id, 'is_personal_info_filled', true ) == 1 )
                {
                    $result = $wpdb->update(
                        $table_name,
                        array(
                            'my_name' => $personal_items[0]['my_name'],
                            'my_height' => intval( $personal_items[0]['my_height'] ),
                            'my_weight' => intval( $personal_items[0]['my_weight'] ),
                            'my_age' => intval( $personal_items[0]['my_age'] ),
                            'my_number' => $personal_items[0]['my_number'],
                            'my_goal' => $personal_items[0]['my_goal'],
                            'update_date' => date( 'Y-m-d H:i:s', $current_time )
                        ),
                        array(
                            'user_id' => intval( $user_id )
                        ),
                        array( '%s', '%d', '%d', '%d', '%s', '%s', '%s' ),
                        array( '%d' )
                    );
                } else {
                    $result = $wpdb->insert(
                        $table_name,
                        array(
                            'user_id' => intval( $user_id ),
                            'my_name' => $personal_items[0]['my_name'],
                            'my_height' => intval( $personal_items[0]['my_height'] ),
                            'my_weight' => intval( $personal_items[0]['my_weight'] ),
                            'my_age' => intval( $personal_items[0]['my_age'] ),
                            'my_number' => $personal_items[0]['my_number'],
                            'my_goal' => $personal_items[0]['my_goal'],
                            'creation_date' => date( 'Y-m-d H:i:s', $current_time ),
                            'update_date' => date( 'Y-m-d H:i:s', $current_time )
                        ),
                        array( '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s' )
                    );
                }

                update_user_meta( $user_id, 'is_personal_info_filled', 1 );
            }

            $table_name = $wpdb->prefix . 'sampa_monthly_reports';
            $monthly_report = SAMPAHelper::get_this_month_report( $user_id );

            if( empty( $monthly_report ) )
            {
                $result = $wpdb->insert(
                    $table_name,
                    array(
                        'user_id' => intval( $user_id ),
                        'measurement' => maybe_serialize( $form_items ),
                        'about' => $about,
                        'end_month' => ( ! $first_time ) ? maybe_serialize( $end_month_items ) : null,
                        'begining_weight' => ( ! $first_time ) ? $begining_weight : null,
                        'ending_weight' => ( ! $first_time ) ? $ending_weight : null,
                        'award' => ( ! $first_time ) ? $award : null,
                        'creation_date' => date( 'Y-m-d H:i:s', $current_time ),
                        'update_date' => date( 'Y-m-d H:i:s', $current_time )
                    ),
                    array( '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
                );
                if( ! $result )
                    wp_send_json_error( array( 'message' => __('Error occurred on saving data to database!', 'sampa') ) );

                wp_send_json_success( array( 'message' => __( 'Form successfully saved to database', 'sampa' ) ) );
            }
            wp_send_json_error( array( 'message' => __('This form has already been saved!', 'sampa') ) );
        }
    }
}