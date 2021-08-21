<?php

namespace Cvy_AC\helpers\inc;

/**
 * Incapsulates wrappers for wp hooks related funcitons.
 */
class WP_Hooks
{
    /**
     * Makes sure action hasn't fired before add_action() is called.
     *
     * Wrapper for add_action().
     *
     * @param string $action_name
     * @param callable  $callback
     * @return void
     */
    public static function add_action_ensure( string $action_name, callable $callback ) : void
    {
        if ( did_action( $action_name ) )
        {
            throw new \Exception( 'Can\'t handle add_action()! Action "' . $action_name . '" has already fired.' );
        }

        add_action( $action_name, $callback );
    }
}