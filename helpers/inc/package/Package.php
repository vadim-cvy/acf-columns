<?php

namespace Cvy_AC\helpers\inc\package;

use \Cvy_AC\helpers\inc\WP_Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Boilerplate for the package entry points.
 *
 * A package is an independent directory which may include own includes, templates,
 * assets, etc. The directory is assumed to be a package if it may function independently.
 * For example plugins and themes are supposed to be packages.
 * Another example: the Helpers package in which current file is loceted. Helpers
 * is an independent dirrectory and thus may be called a package.
 *
 * How to use:
 *
 * My_Awesome_Package extends \Cvy_AC\helpers\inc\package\Package
 * {
 *      // Your code goes here
 * }
 *
 * My_Awesome_Package::get_instance()->run();
 */
abstract class Package
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    /**
     * An entry method of the package.
     */
    protected function __construct()
    {
        if ( ! $this->can_run() )
        {
            return;
        }

        $this->init_includes();

        WP_Hooks::add_action_ensure( 'wp_enqueue_scripts', [ $this, '_callback__enqueue_scripts' ] );
        WP_Hooks::add_action_ensure( 'admin_enqueue_scripts', [ $this, '_callback__enqueue_scripts' ] );
    }

    /**
     * Inits includes (imports files with the main custom code).
     *
     * @return void
     */
    abstract protected function init_includes() : void;

    /**
     * Fires on "wp_enqueue_scripts" and "admin_enqueue_scripts" hooks.
     *
     * @return void
     */
    public function _callback__enqueue_scripts() : void
    {
        $this->enqueue_assets();
    }

    /**
     * Enqueues assets.
     *
     * I.e call wp_enqueue_script() and wp_enqueue_style() here.
     * It is preffered to use such methods as $this->enqueue_internal_css_asset(),
     * $this->enqueue_css_asset(), etc instead of default wp functions.
     *
     * @return void
     */
    abstract protected function enqueue_assets() : void;

    /**
     * Enqueues CSS file which is a part of the package codebase (i.e asset lays in /assets/css/ dir).
     *
     * A wrapper for wp_enqueue_style().
     *
     * @param string $handle        Name of the stylesheet. Should be unique. Will be prefixed.
     * @param string $relative_src  CSS file URL ralative to the package /assets/css/ dir.
     * @param array $dependencies   An array of registered stylesheet handles this stylesheet
     *                              depends on.
     * @param string $media         The media for which this stylesheet has been defined.
     * @return void
     */
    protected function enqueue_internal_css_asset(
        string $handle,
        string $relative_src,
        array $dependencies = [],
        string $media = ''
    ) : void
    {
        $this->validate_file_exists( $this->get_css_dir() . $relative_src );

        $src     = $this->get_css_dir() . $relative_src;
        $version = $this->get_version();

        $this->enqueue_css_asset( $handle, $src, $dependencies, $version, $media );
    }

    /**
     * Enqueues CSS file.
     *
     * A wrapper for wp_enqueue_style().
     *
     * @param string $handle        Name of the stylesheet. Should be unique. Will be prefixed.
     * @param string $src           CSS file URL.
     * @param array $dependencies   An array of registered stylesheet handles this stylesheet
     *                              depends on.
     * @param string $version       File version number.
     * @param string $media         The media for which this stylesheet has been defined.
     * @return void
     */
    protected function enqueue_css_asset(
        string $handle,
        string $src,
        array $dependencies = [],
        string $version = '',
        string $media = ''
    ) : void
    {
        if ( ! did_action( 'wp_enqueue_scripts' ) && ! did_action( 'admin_enqueue_scripts' ) )
        {
            throw new \Exception(
                '"wp_enqueue_scripts" / "admin_enqueue_scripts" hasn\'t fire yet! ' .
                'Please enqueue your assets the same way but from the ' . static::class . '::enqueue_assets() method.'
            );
        }

        $handle  = $this->get_prefix() . '_' . $handle;

        wp_enqueue_style( $handle, $src, $dependencies, $version, $media );
    }

    /**
     * Throws error if passed file does not exist.
     *
     * @param string $path File path
     * @return void
     */
    protected function validate_file_exists( string $path ) : void
    {
        if ( ! file_exists( $path ) )
        {
            throw new \Exception( 'File "' . $path . '" does not exist!' );
        }
    }

    /**
     * Checks if the package is allowed to run.
     *
     * @return boolean True if package is allowed to run false otherwise.
     */
    abstract protected function can_run() : bool;

    /**
     * Package version.
     *
     * @return string Package version.
     */
    abstract public function get_version() : string;

    /**
     * Getter for the package prefix.
     *
     * Prefix may be used for:
     * - database option names
     * - custom hook names
     * - css selectors
     * - etc
     *
     * @return string Package prefix.
     */
    public function get_prefix() : string
    {
        /**
         * My_Awesome_Package\helpers -> my_awesome_package_helpers
         */
        $prefix = strtolower( $this->get_root_namespace() );
        $prefix = str_replace( '\\', '_', $prefix );

        return $prefix;
    }

    /**
     * Getter for the package root namespace.
     *
     * @return string Package root namespace.
     */
    abstract protected function get_root_namespace() : string;

    /**
     * Getter for the package root(main) file path.
     *
     * @return string Package root(main) file path.
     */
    abstract protected function get_root_file() : string;

    /**
     * Getter for the package root directory.
     *
     * @return string Package root directory.
     */
    public function get_root_dir() : string
    {
        return dirname( $this->get_root_file() ) . '/';
    }

    /**
     * Getter for the package templates directory.
     *
     * Templates directory contains all the HTML files as well as PHP files containing
     * HTML markup.
     *
     * @return string Package templates directory.
     */
    public function get_templates_dir() : string
    {
        return $this->get_root_dir() . 'templates/';
    }

    /**
     * Returns path to the assets dir.
     *
     * Assets are: CSS, JS, images.
     *
     * @return string
     */
    protected function get_assets_dir() : string
    {
        return $this->get_root_dir() . 'assets/';
    }

    /**
     * Returns path to the CSS dir.
     *
     * @return string
     */
    protected function get_css_dir() : string
    {
        return $this->get_assets_dir() . 'css/';
    }

    /**
     * Retrns CSS dir URL.
     *
     * @return string
     */
    abstract protected function get_css_dir_url() : string;

    /**
     * Adds dashboard error notice.
     *
     * @param string $error_message Notice message.
     * @return void
     */
    public function add_dashboard_error( string $error_message ) : void
    {
        \Cvy_AC\helpers\inc\Dashboard::get_instance()->add_error( $error_message );
    }
}