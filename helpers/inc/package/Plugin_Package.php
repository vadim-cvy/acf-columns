<?php

namespace Cvy_AC\helpers\inc\package;

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
     * Getter for the plugin root directory path.
     *
     * @return string Plugin root directory path.
     */
    public function get_root_dir() : string
    {
        return dirname( $this->get_root_file() ) . '/';
    }
}