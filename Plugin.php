<?php
/**
 * Plugin Name:       ACF Columns
 * Description:       This plugins makes it possible to create dashboard table columns for ACF fields.
 * Version:           1.0.0
 * Author:            Vadim Cherepenichev
 * Author URI:        https://www.toptal.com/resume/vadim-cherepenichev
 * Text Domain:       cvy-acf-columns
 */

namespace Cvy_AC;

use \Cvy_AC\helpers\inc\acf\ACF;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Init plugin autoloader.
 */
require_once __DIR__ . '/helpers/inc/package/Package_Autoloader.php';
new \Cvy_AC\helpers\inc\package\Package_Autoloader( __NAMESPACE__, __DIR__ );

/**
 * Init Helpers
 */
\Cvy_AC\helpers\Helpers::get_instance();

/**
 * Entry point of the plugin.
 */
class Plugin extends \Cvy_AC\helpers\inc\package\Plugin_Package
{
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
     * Inits includes (imports files with the main custom code).
     *
     * @return void
     */
    protected function init_includes() : void
    {
        \Cvy_AC\inc\plugin_settings\Plugin_Settings_Controller::get_instance();

        \Cvy_AC\inc\acf\ACF_Controller::get_instance();

        \Cvy_AC\inc\dashboard_tables\Tables_Controller::get_instance();
    }

    /**
     * Enqueues assets.
     *
     * @return void
     */
    protected function enqueue_assets() : void
    {
        if ( is_admin() )
        {
            $this->enqueue_internal_css_asset( 'dashboard', 'dashboard.css' );
        }
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

Plugin::get_instance();
