<?php

/**
 * Plugin Name: Sama Pashapour
 * Plugin URI: https://samapashapour.com/
 * Requires PHP: 7.2
 * Description: This plugin adds some daily and monthly diet notes to the dashboard of WooCommerce account, and also the admin can view the notes report and export it as a pdf or excel file.
 * Version: 1.0.9
 * Tested up to: 6.2.2
 * Author: Sajjad Fattah
 * Author URI: https://safateam.net/
 * Text Domain: sampa
 * Domain Path: /languages
 * License: GPL2
 */

namespace SAMPA;
use SAMPA\Inc\SAMPALoader;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'InitSAMPA' ) )
{
    class InitSAMPA
    {
        protected $plugin_name = 'Sama Pashapour';

        public function __construct()
        {
            $this->sampa_init();
        }

        /**
         * Define plugin constants, definitions and hooks
         *
         * @return void
         */
        private function sampa_init(): void
        {
            // Check dependencies
            register_activation_hook( __FILE__, array( $this, 'sampa_check_dependencies' ) );

            // Definitions
            defined( 'SAMPA_PATH' ) or define( 'SAMPA_PATH', plugin_dir_path( __FILE__ ) ); // Plugin path
            defined( 'SAMPA_URL' ) or define( 'SAMPA_URL', plugin_dir_url( __FILE__ ) ); // Plugin url

            // Inclutions
            include_once( SAMPA_PATH . 'inc/main/sampa-database.php' );
            include_once( SAMPA_PATH . 'inc/main/sampa-resources.php' );

            // Hooks
            register_activation_hook( __FILE__, array( 'SAMPA\Inc\Main\SAMPADataBase', 'add_tables' ) ); // Create database tables
            add_action( 'plugins_loaded', array( $this, 'i18n' ) ); // Localization
            add_action( 'admin_enqueue_scripts', array( 'SAMPA\Inc\Main\SAMPAResources', 'admin_resources' ), 999 ); // Register plugin admin resources
            add_action( 'wp_enqueue_scripts', array( 'SAMPA\Inc\Main\SAMPAResources', 'public_resources' ), 999 ); // Register plugin public resources
            add_action( 'plugins_loaded', array( $this, 'init' ) ); // Initializing
        }

        /**
         * Deactivate the plugin and display a notice if the dependent plugin is not active.
         */
        public function sampa_check_dependencies()
        {
            if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) )
            {
                $this->sampa_deactivate_plugin();
                wp_die( sprintf( __( 'Could not be activated. %s', 'sampa' ), $this->sampa_get_admin_notices() ) );
            }
        }

        /**
         * Function to deactivate the plugin
         */
        private function sampa_deactivate_plugin()
        {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            deactivate_plugins( plugin_basename( __FILE__ ) );
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }

        /**
         * Writing the admin notice
         */
        protected function sampa_get_admin_notices()
        {
            return sprintf(
                __( '%1$s requires woocommerce installed and active. You can download woocommerce latest version %2$s OR go back to %3$s.', 'sampa' ),
                '<strong>' . $this->plugin_name . '</strong>',
                '<strong><a href="https://wordpress.org/plugins/woocommerce">' . __( 'from here', 'sampa' ) . '</a></strong>',
                '<strong><a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">' . __( 'plugins page', 'sampa' ) . '</a></strong>'
            );
        }

        /**
         * Load the plugin's text domain for localization
         *
         * @return void
        **/
        public function i18n(): void
        {
            load_plugin_textdomain( 'sampa', false, plugin_basename( __DIR__ ) . '/languages' );
        }

        /**
         * Initializing the plugin
         *
         * @return void
         */
        public function init(): void
        {
            include_once SAMPA_PATH . 'inc/sampa-loader.php';
            new SAMPALoader();
        }
    }
}

new InitSAMPA();