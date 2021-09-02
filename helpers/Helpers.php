<?php

namespace Cvy_AC\helpers;

/**
 * Helpers package main file.
 */
class Helpers extends \Cvy_AC\helpers\inc\package\Package
{
    public function init_includes() : void
    {
        \Cvy_AC\helpers\inc\dashboard\Dashboard::get_instance();
    }

    protected function enqueue_assets() : void
    {
        if ( is_admin() )
        {
            $this->enqueue_internal_css_asset( 'dashboard', 'dashboard.css' );
        }
    }

    /**
     * Checks if the package is allowed to run.
     *
     * @return boolean True if package is allowed to run false otherwise.
     */
    protected function can_run() : bool
    {
        return true;
    }

    /**
     * Getter for the package root namespace.
     *
     * @return string Package root namespace.
     */
    protected function get_root_namespace() : string
    {
        return __NAMESPACE__;
    }

    /**
     * Getter for the helpers root(main) file path.
     *
     * @return string Helpers root(main) file path.
     */
    protected function get_root_file() : string
    {
        return __FILE__;
    }

    /**
     * Helpers version.
     *
     * @return string Helpers version.
     */
    public function get_version() : string
    {
        return \Cvy_AC\Plugin::get_instance()->get_version();
    }

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
}