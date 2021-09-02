<?php

namespace Cvy_AC\helpers\inc\acf\field\settings;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Representation of the ACF field setting.
 *
 * This class is a singleton and may have only 1 instance.
 */
abstract class Field_Setting__Singleton
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    protected function __construct()
    {
        $this->register();
    }

    /**
     * Returns setting name.
     *
     * @return string Setting name.
     */
    public function get_name() : string
    {
        return $this->get_args()['name'];
    }

    /**
     * Returns setting arguments.
     *
     * See 2nd param of acf_render_field_setting().
     *
     * @return array<mixed> Setting arguments.
     */
    abstract protected function get_args() : array;

    /**
     * Checks if setting is available for specific field.
     *
     * This method is called for ALL fields one by one so you may consider if specific
     * field can / cannot have current setting based on the passed field object.
     *
     * @param   array $field_object ACF Field object (array).
     * @return  boolean             True if setting is available for passed field, false otherwise.
     */
    abstract protected function is_available_for_field( array $field_object ) : bool;

    /**
     * Registers the setting.
     *
     * @return void
     */
    protected function register() : void
    {
        \Cvy_AC\helpers\inc\WP_Hooks::add_filter_ensure( 'acf/render_field_settings', [ $this, '_print' ] );
    }

    /**
     * Prints the setting.
     *
     * @param   array $field_object ACF Field object (array).
     * @return  void
     */
    public function _print( array $field_object ) : void
    {
        if ( $this->is_available_for_field( $field_object ) )
        {
            acf_render_field_setting( $field_object, $this->get_args() );
        }
    }
}
