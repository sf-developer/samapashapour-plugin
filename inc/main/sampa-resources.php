<?php

namespace SAMPA\Inc\Main;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if ( ! class_exists( 'SAMPAResources' ) )
{

    class SAMPAResources {

        /**
         * Register admin resources
         *
         * @return void
         */
        public static function admin_resources( $hook ): void
        {

            if ( ! is_admin() ) return; //make sure we are on the backend

            if( str_contains( $hook, 'sampa-' ) ) {

                is_rtl() ? wp_register_style( 'bootstrap', SAMPA_URL . 'assets/libs/bootstrap/css/bootstrap.rtl.min.css', array(), '5.3.0' ) : wp_register_style( 'bootstrap', SAMPA_URL . 'assets/libs/bootstrap/css/bootstrap.min.css', array(), '5.3.0' );
                wp_register_style( 'sampa-fontawesome', SAMPA_URL . 'assets/libs/fontawesome/all.min.css', array(), '6.3.0' );
                wp_register_style( 'datatables', SAMPA_URL . 'assets/libs/datatables/css/datatables.min.css', array(), '1.13.4' );
                wp_register_style( 'sampa', SAMPA_URL . 'assets/admin/css/style.css', array( 'bootstrap', 'sampa-fontawesome' ), '1.0.0' );

                wp_register_script( 'jquery', SAMPA_URL . 'assets/libs/jquery/jquery.min.js', array(), '3.6.1', true );
                wp_register_script( 'bootstrap', SAMPA_URL . 'assets/libs/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.0', true );
                wp_register_script( 'notiflix', SAMPA_URL . 'assets/libs/notiflix/notiflix-aio.min.js', array( 'jquery' ), '3.2.6', true );
                wp_register_script( 'datatables', SAMPA_URL . 'assets/libs/datatables/js/datatables.min.js', array(), '1.13.4', true );
                wp_register_script( 'sampa', SAMPA_URL . 'assets/admin/js/script.js', array( 'jquery', 'bootstrap', 'notiflix' ), '1.0.0', true);

                wp_localize_script( 'sampa', 'sampa', array(
                    '_ajax_url' => admin_url( 'admin-ajax.php' ),
                    '_ajax_nonce' => wp_create_nonce( 'sampa_action' )
                ));

                // Localization for js translate
                wp_localize_script('sampa', 'sampa_translate', array(
                    'yes' => __('Yes', 'sampa'),
                    'no' => __('No', 'sampa'),
                    'emptyValues' => __('One or more values are empty', 'sampa'),
                    'invalidPhone' => __('Phone number is incorect', 'sampa')
                ));
            }
        }

        /**
         * Register public resources
         *
         * @return void
         */
        public static function public_resources(): void
        {
            /* <------------------------------- Register Plugin resources -------------------------------> */
            is_rtl() ? wp_register_style( 'bootstrap', SAMPA_URL . 'assets/libs/bootstrap/css/bootstrap.rtl.min.css', array(), '5.3.0') : wp_register_style('bootstrap', SAMPA_URL . 'assets/libs/bootstrap/css/bootstrap.min.css', array(), '5.3.0' );
            wp_register_style( 'datatables', SAMPA_URL . 'assets/libs/datatables/css/datatables.min.css', array(), '1.13.4' );
            wp_register_style( 'sampa', SAMPA_URL . 'assets/public/css/style.css', array( 'bootstrap' ), '1.0.0');

            wp_register_script( 'jquery', SAMPA_URL . 'assets/libs/jquery/jquery.min.js', array());
            wp_register_script( 'bootstrap', SAMPA_URL . 'assets/libs/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ) );
            wp_register_script( 'notiflix', SAMPA_URL . 'assets/libs/notiflix/notiflix-aio.min.js', array( 'jquery' ) );
            wp_register_script( 'datatables', SAMPA_URL . 'assets/libs/datatables/js/datatables.min.js', array(), '1.13.4', true );
            wp_register_script( 'sampa', SAMPA_URL . 'assets/public/js/script.js', array( 'jquery', 'bootstrap', 'notiflix' ) );

            // Localization for ajax
            wp_localize_script('sampa', 'sampa', array(
                '_ajax_url' => admin_url( 'admin-ajax.php' ),
                '_ajax_nonce' => wp_create_nonce( 'sampa_action' )
            ));

            // Localization for js translate
            wp_localize_script('sampa', 'sampa_translate', array(
                'savingConfirmTitle' => __( 'Confirm save', 'sampa' ),
                'savingConfirmContent' => __( 'Are you sure of saving the information?', 'sampa' ),
                'yes' => __('Yes', 'sampa'),
                'no' => __('No', 'sampa'),
                'emptyValues' => __('One or more values are empty', 'sampa')
            ));
        }
    }
}