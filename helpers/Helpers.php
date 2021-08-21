<?php

namespace Cvy_AC\helpers;

/**
 * Helpers package main file.
 */
class Helpers extends \Cvy_AC\helpers\inc\package\Package
{
    /**
     * Contains the main code of the package.
     *
     * This method is executed when package has already confirmed if it can run via
     * $this->can_run().
     *
     * @return void
     */
    public function on_run() : void
    {

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
     * Getter for the package root directory.
     *
     * @return string Package root directory.
     */
    public function get_root_dir() : string
    {
        return __DIR__;
    }
}