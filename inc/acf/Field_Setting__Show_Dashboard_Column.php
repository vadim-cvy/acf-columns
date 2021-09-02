<?php

namespace Cvy_AC\inc\acf;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ACF field setting: "Show in Dashboard Tables?".
 */
class Field_Setting__Show_Dashboard_Column extends \Cvy_AC\helpers\inc\acf\field\settings\Field_Setting__Singleton
{
    /**
     * Returns setting arguments.
     *
     * See 2nd param of acf_render_field_setting().
     *
     * @return array<mixed> Setting arguments.
     */
    protected function get_args() : array
    {
        return [
            'label'			=> 'Show in Dashboard Tables?',
            'instructions'	=> 'Some description goes here',
            'name'			=> \Cvy_AC\Plugin::get_instance()->get_prefix() . '_show_dashboard_column',
            'type'			=> 'true_false',
            'ui'            => true,
        ];
    }

    /**
     * Checks if setting is available for specific field.
     *
     * This method is called for ALL fields one by one so you may consider if specific
     * field can / cannot have current setting based on the passed field object.
     *
     * @param   array $field_object ACF Field object (array).
     * @return  boolean             True if setting is available for passed field, false otherwise.
     */
    protected function is_available_for_field( array $field ) : bool
    {
        return in_array( $field['type'], $this->get_supported_field_types() );
    }

    /**
     * Returns field types which may have "Show in Dashboard Tables?" setting.
     *
     * @return array<string> Field types.
     */
    protected function get_supported_field_types() : array
    {
        return [
            'text',
            'textarea',
            'number',
            'range',
            'email',
            'url',
            'password',
            'image',
            'file',
            'wysiwyg',
            'oembed',
            'select',
            'checkbox',
            'radio',
            'button_group',
            'true_false',
            'link',
            'post_object',
            'page_link',
            'relationship',
            'taxonomy',
            'user',
            'date_picker',
            'date_time_picker',
            'time_picker',
            'color_picker',
        ];
    }
}
