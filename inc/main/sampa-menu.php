<?php

namespace SAMPA\Inc\Main;

defined( 'ABSPATH' ) || exit; // Prevent direct access

if( ! class_exists( 'SAMPAMenu' ) )
{
    class SAMPAMenu {

        /**
         * Add plugin menu
         *
         * @return void
         */
        public static function add_menu(): void
        {
            global $sampa_page_hook_suffix;

            // Settings menu
            $sampa_page_hook_suffix = add_menu_page(
                __( 'Reports', 'sampa' ),
                __( 'Reports', 'sampa' ),
                'publish_posts',
                'sampa-reports',
                array( self::class, 'sampa_render_page' ),
                'dashicons-editor-ul',
                999
            );
        }

        /**
         * Remove plugin namespace
         *
         * @param string plugin namespace
         * @return string remove sampa- from plugin namespace and return it
         */
        private static function sampa_remove_plugin_namespace( $string ): string
        {
            return str_replace( 'sampa-', '', $string );
        }

        /**
         * Render setting page based on plugin namespace
         *
         * @return void
         */
        public static function sampa_render_page(): void
        {
            $page = $_GET['page']; // Get current setting page
            $page = self::sampa_remove_plugin_namespace( $page ); // Remove plugin namespace form page name
            include( sprintf( "%sviews/admin/%s.php", SAMPA_PATH, $page ) ); // Include views
        }
    }
}