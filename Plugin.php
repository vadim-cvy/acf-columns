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
