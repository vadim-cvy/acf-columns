<?php

namespace Cvy_AC\helpers\inc\package;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * A boilerplate for plugins main files.
 *
 * How to use:
 *
 * My_Awesome_Plugin extends \Cvy_AC\helpers\inc\package\Plugin_Package
 * {
 *      // Your code goes here
 * }
 *
 * My_Awesome_Plugin::get_instance()->run();
 */
abstract class Plugin_Package extends Package
{
    /**
     * Checks if the package is allowed to run.
     *
     * @return boolean True if package is allowed to run false otherwise.
     */
    protected function can_run() : bool
    {
        return $this->is_active();
    }

    /**
     * Wrapper for get_plugin_data().
     *
     * @return array<string> Plugin data.
     */
    public function get_plugin_data() : array
    {
        return get_plugin_data( $this->get_root_file() );
    }

    /**
     * Package version.
     *
     * @return string Package version.
     */
    public function get_version() : string
    {
        return $this->get_plugin_data()['Version'];
    }

    /**
     * Getter for plugin name.
     *
     * @return string Plugin name.
     */
    public function get_name() : string
    {
        return $this->get_plugin_data()['Name'];
    }

    /**
     * Checks if plugin is active.
     *
     * @return boolean True if plugin is active, false otherwise.
     */
    protected function is_active() : bool
    {
        $plugin =
            basename( $this->get_root_dir() ) . '/' .
            basename( $this->get_root_file() );

        return \Cvy_AC\helpers\inc\Plugins::is_active( $plugin );
    }

    /**
     * Getter for the plugin root(main) file path.
     *
     * @return string Plugin root(main) file path.
     */
    abstract protected function get_root_file() : string;

    /**
     * Retrns CSS dir URL.
     *
     * @return string
     */
    protected function get_css_dir_url() : string
    {
        $css_dir_path = $this->get_css_dir();

        $css_dir_path .=
            'unexisting_file_which_prevents_PLUGIN_DIR_URL_func_to_remove_css_dir';

        return plugin_dir_url( $css_dir_path );
    }

    /**
     * Adds dashboard error notice.
     *
     * @param string $error_message Notice message.
     * @return void
     */
    public function add_dashboard_error( string $error_message ) : void
    {
        $error_message =
            '<strong>' .
                '"' . $this->get_name() . '" Plugin Error:' .
            '</strong> ' .
            $error_message;

        parent::add_dashboard_error( $error_message );
    }
}