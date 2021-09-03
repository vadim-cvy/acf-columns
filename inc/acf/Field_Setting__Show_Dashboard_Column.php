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
            // Todo: set description
            'instructions'	=> 'Some description goes here',
            'name'			=> \Cvy_AC\Plugin::get_instance()->get_prefix() . '_show_dashboard_column',
            'type'			=> 'true_false',
            'ui'            => true,
        ];
    }

    /**
     * Returns field types which should have this setting.
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
