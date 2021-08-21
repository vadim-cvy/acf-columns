<?php

namespace Cvy_AC\helpers\inc;

/**
 * Boilerplate for the module entry points.
 *
 * A module is an independent package (dir) which may include own includes, templates,
 * assets, etc. The package is assumed to be a module if it may function independently.
 * For example plugins and themes are supposed to be modules.
 * Another example: the Helpers package in which current fiel is loceted. It is
 * also treated as module. Helpers is an independent package and thus may be called
 * a module.
 *
 * How to use:
 *
 * My_Awesome_Module extends \Cvy_AC\helpers\inc\Module
 * {
 *      // Your code goes here
 * }
 *
 * My_Awesome_Module::get_instance()->run();
 */
abstract class Module
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    /**
     * An entry point of the module.
     *
     * @return bool If the module was able to run or not.
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
     * Contains the main code of the module.
     *
     * This method is executed when module has already confirmed if it can run via
     * $this->can_run().
     *
     * @return void
     */
    abstract protected function on_run() : void;

    /**
     * Checks if the module is allowed to run.
     *
     * @return boolean True if module is allowed to run false otherwise.
     */
    abstract protected function can_run() : bool;

    /**
     * Getter for the module prefix.
     *
     * Prefix may be used for:
     * - database option names
     * - custom hook names
     * - css selectors
     * - etc
     *
     * @return string Module prefix.
     */
    public function get_prefix() : string
    {
        /**
         * My_Awesome_Module\helpers -> my_awesome_module_helpers
         */
        $prefix = strtolower( $this->get_root_namespace() );
        $prefix = str_replace( '\\', '_', $prefix );

        return $prefix;
    }

    /**
     * Getter for the module(package) root namespace.
     *
     * @return string Module root namespace.
     */
    abstract protected function get_root_namespace() : string;

    /**
     * Getter for the module(package) root directory.
     *
     * @return string Module root directory.
     */
    abstract public function get_root_dir() : string;

    /**
     * Getter for the module(package) templates directory.
     *
     * Templates directory contains all the HTML files as well as PHP files containing
     * HTML markup.
     *
     * @return string Module templates directory.
     */
    public function get_templates_dir() : string
    {
        return $this->get_root_dir() . '/templates/';
    }
}