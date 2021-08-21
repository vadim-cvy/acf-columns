<?php

namespace Cvy_AC\helpers\inc;

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
 * My_Awesome_Package extends \Cvy_AC\helpers\inc\Package
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
     *
     * @return bool If the package was able to run or not.
     */
    public function run() : bool
    {
        if ( ! $this->can_run() )
        {
            return false;
        }

        $this->on_run();

        return true;
    }

    /**
     * Contains the main code of the package.
     *
     * This method is executed when package has already confirmed if it can run via
     * $this->can_run().
     *
     * @return void
     */
    abstract protected function on_run() : void;

    /**
     * Checks if the package is allowed to run.
     *
     * @return boolean True if package is allowed to run false otherwise.
     */
    abstract protected function can_run() : bool;

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
     * Getter for the package root directory.
     *
     * @return string Package root directory.
     */
    abstract public function get_root_dir() : string;

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
        return $this->get_root_dir() . '/templates/';
    }
}