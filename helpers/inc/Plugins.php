<?php

namespace Cvy_AC\helpers\inc;

/**
 * Incapsulates common helpers for plugins related functionality.
 */
class Plugins
{
    /**
     * Wrapper for is_plugin_active().
     *
     * @param string $plugin_main_file  Plugin main file path.
     *                                  "{base dir name}/{main file name}.php"
     *
     * @return boolean                  True if plugin is active, false otherwise.
     */
    public static function is_active( string $plugin_main_file ) : bool
    {
        if ( ! function_exists( 'is_plugin_active' ) )
        {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        return is_plugin_active( $plugin_main_file );
    }

    /**
     * Checks if plugin is installed.
     *
     * @param string $plugin_main_file  Plugin main file path.
     *                                  "{base dir name}/{main file name}.php"
     *
     *  @return boolean                 True if plugin is installed, false otherwise.
     */
    public static function is_installed( string $plugin_main_file ) : bool
    {
        $file_path = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $plugin_main_file;

        return file_exists( $file_path );
    }
}