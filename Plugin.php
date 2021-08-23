<?php
/**
 * Plugin Name:       Cvy ACF Columns
 * Description:       This plugins makes it possible to add ACF fields as columns to post types, users and taxonomies tables in WP Dashboard.
 * Version:           1.0.0
 * Author:            Vadim Cherepenichev
 * Author URI:        https://www.toptal.com/resume/vadim-cherepenichev
 * Text Domain:       cvy-acf-columns
 */

namespace Cvy_AC;

use \Cvy_AC\helpers\inc\acf\ACF;

/**
 * Init plugin autoloader.
 */
require_once __DIR__ . '/helpers/inc/package/Package_Autoloader.php';
new \Cvy_AC\helpers\inc\package\Package_Autoloader( __NAMESPACE__, __DIR__ );

/**
 * Entry point of the plugin.
 */
class Plugin extends \Cvy_AC\helpers\inc\package\Plugin_Package
{
    /**
     * Contains the main code of the plugin.
     *
     * This method is executed when plugin has already confirmed if it can run via
     * $this->can_run().
     *
     * @return void
     */
    public function on_run() : void
    {
        \Cvy_AC\inc\plugin_settings\Plugin_Settings::get_instance();
    }

    /**
     * Checks if the plugin is allowed to run.
     *
     * @return boolean True if package is allowed to run false otherwise.
     */
    protected function can_run() : bool
    {
        if (
            ! parent::can_run() ||
            ! $this->validate_acf_plugin_active()
        )
        {
            return false;
        }

        return true;
    }

    /**
     * Checks if ACF plugin is installed and activated.
     *
     * @return boolean True if ACF is active,
     */
    protected function validate_acf_plugin_active() : bool
    {
        if ( ACF::is_installed() && ACF::is_active() )
        {
            return true;
        }

        $error_message = 'ACF plugin is not ';

        if ( ! ACF::is_installed() )
        {
            $error_message .= 'installed! Please install it.';
        }
        else if ( ! ACF::is_active() )
        {
            $error_message .= 'active! Please activate it.';
        }

        $this->add_dashboard_error( $error_message );

        return false;
    }

    /**
     * Getter for the plugin root namespace.
     *
     * @return string Plugin root namespace.
     */
    protected function get_root_namespace() : string
    {
        return __NAMESPACE__;
    }

    /**
     * Getter for the plugin root(main) file path.
     *
     * @return string Plugin root(main) file path.
     */
    protected function get_root_file() : string
    {
        return __FILE__;
    }
}

Plugin::get_instance()->run();
