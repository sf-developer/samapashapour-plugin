<?php

namespace SAMPA\Inc\Ajax;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'SAMPASavePersonalInfoForm' ) )
{
    class SAMPASavePersonalInfoForm
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

            if( empty( $form_items ) || empty( $user_id ) )
                wp_send_json_error( array( 'message' => __('One or more values are empty', 'sampa') ) );

            date_default_timezone_set( 'Asia/Tehran' );
            $local_time  = current_datetime();
            $current_time = $local_time->getTimestamp() + $local_time->getOffset();

            global $wpdb;
            $table_name = $wpdb->prefix . 'sampa_personal_info';

            if( get_user_meta( $user_id, 'is_personal_info_filled', true ) == 1 )
            {
                $result = $wpdb->update(
                    $table_name,
                    array(
                        'my_name' => $form_items[0]['my_name'],
                        'my_height' => intval( $form_items[0]['my_height'] ),
                        'my_weight' => intval( $form_items[0]['my_weight'] ),
                        'my_age' => intval( $form_items[0]['my_age'] ),
                        'my_number' => $form_items[0]['my_number'],
                        'my_goal' => $form_items[0]['my_goal'],
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
                        'my_name' => $form_items[0]['my_name'],
                        'my_height' => intval( $form_items[0]['my_height'] ),
                        'my_weight' => intval( $form_items[0]['my_weight'] ),
                        'my_age' => intval( $form_items[0]['my_age'] ),
                        'my_number' => $form_items[0]['my_number'],
                        'my_goal' => $form_items[0]['my_goal'],
                        'creation_date' => date( 'Y-m-d H:i:s', $current_time ),
                        'update_date' => date( 'Y-m-d H:i:s', $current_time )
                    ),
                    array( '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s' )
                );
            }

            if( ! $result )
                wp_send_json_error( array( 'message' => __('Error occurred on saving data to database!', 'sampa') ) );

            update_user_meta( $user_id, 'is_personal_info_filled', 1 );

            wp_send_json_success( array( 'message' => __( 'Form successfully saved to database', 'sampa' ) ) );
        }
    }
}