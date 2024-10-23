<?php

namespace SAMPA\Inc\Ajax;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'SAMPAUpdateDailyForm' ) )
{
    class SAMPAUpdateDailyForm
    {

        /**
         * Updating form ajax callback
         *
         * @return void
         */
        public static function handler(): void
        {
            ! check_ajax_referer('sampa_action', 'nonce', false)
                and wp_send_json_error(array( 'message' => __('Security error!', 'sampa'), 'code' => 401 ));

            $user_id = wp_strip_all_tags($_POST['user_id']);
            $form_id = wp_strip_all_tags($_POST['form_id']);
            $form_items = $_POST['form_items'];

            date_default_timezone_set( 'Asia/Tehran' );
            $local_time  = current_datetime();
            $current_time = $local_time->getTimestamp() + $local_time->getOffset();

            if( empty( $form_items ) || empty( $user_id ) || empty( $form_id ) )
                wp_send_json_error( array( 'message' => __('One or more values are empty', 'sampa') ) );

            global $wpdb;
            $table_name = $wpdb->prefix . 'sampa_daily_reports';
            $result = $wpdb->update(
                $table_name,
                array(
                    'nutrition' => $form_items[0]['nutrition'],
                    'sport' => $form_items[0]['sport'],
                    'sleep' => $form_items[0]['sleep'],
                    'expenses' => $form_items[0]['expenses'],
                    'note' => $form_items[0]['note'],
                    'motivational_sentence' => $form_items[0]['motivational_sentence'],
                    'water' => intval( $form_items[0]['water'] ),
                    'thanksgiving' => $form_items[0]['thanksgiving'],
                    'today_work' => $form_items[0]['works'],
                    'creation_date' => date( 'Y-m-d H:i:s', $current_time ),
                    'update_date' => date( 'Y-m-d H:i:s', $current_time )
                ),
                array(
                    'ID' => intval( $form_id ),
                    'user_id' => intval( $user_id ),
                ),
                array( '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s' ),
                array( '%d', '%d' )
            );

            if( ! $result )
                wp_send_json_error( array( 'message' => __('Error occurred on updating data to database!', 'sampa') ) );

            wp_send_json_success( array( 'message' => __( 'Form successfully updated to database', 'sampa' ) ) );
        }
    }
}