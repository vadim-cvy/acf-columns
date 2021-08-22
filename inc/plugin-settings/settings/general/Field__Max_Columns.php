<?php

namespace Cvy_AC\inc\plugin_settings\settings\general;

/**
 * Max Columns field.
 *
 * Allows to set a number of maximum columns to be displayed in the table. Clomuns
 * will be merged into 1 column if the limit is reached.
 *
 * A wrapper for add_settings_field().
 */
class Field__Max_Columns extends \Cvy_AC\helpers\inc\settings\Field
{
    /**
     * Post type / taxonomy instance or null if $this->target_object_type is 'users'.
     *
     * @var \WP_Post_Type|\WP_Taxonomy|null
     */
    protected $target_object = null;

    /**
     * Type of $this->target_object.
     *
     * Allowed values: 'post_type', 'tax', 'users'.
     *
     * @var string
     */
    protected $target_object_type = '';

    /**
     * @param string $target_object_type                    See $this->target_object_type.
     * @param \WP_Post_Type|\WP_Taxonomy|null $target_object  See $this->target_object
     */
    public function __construct( string $target_object_type, $target_object = null )
    {
        $this->target_object_type = $target_object_type;
        $this->target_object      = $target_object;

        parent::__construct();
    }

    /**
     * Getter for the field id.
     *
     * @return string Field id.
     */
    public function get_id() : string
    {
        return $this->get_target_object_slug() . '_max_columns';
    }

    /**
     * Getter for the field label.
     *
     * @return string Field label.
     */
    protected function get_label() : string
    {
        if ( $this->target_object_type === 'post_type' || $this->target_object_type === 'tax' )
        {
            $label = '"' . $this->target_object->label . '" ';

            if ( $this->target_object_type === 'post_type' )
            {
                $label .= 'post type';
            }
            else if ( $this->target_object_type === 'tax' )
            {
                $label .= 'taxonomy';
            }
        }
        else
        {
            $label = 'Users';
        }

        return $label;
    }

    /**
     * Getter for the field parent setting.
     *
     * @return Setting Field parent setting.
     */
    protected function get_setting() : \Cvy_AC\helpers\inc\settings\Setting
    {
        return Setting::get_instance();
    }

    /**
     * Getter for the field parent section.
     *
     * @return Section Field parent section.
     */
    protected function get_section() : \Cvy_AC\helpers\inc\settings\Section
    {
        return $this->get_setting()->get_parent_page()->get_sections()['max_columns'];
    }

    /**
     * Getter for the field default value.
     *
     * @return mixed Field default value.
     */
    public function get_default_value()
    {
        return 5;
    }

    /**
     * Getter for the field type.
     *
     * @return string Field type.
     */
    protected function get_type() : string
    {
        return 'number';
    }

    /**
     * Checks if field is required.
     *
     * @return bool True if field is required, false otherwise.
     */
    protected function is_required() : bool
    {
        return true;
    }

    /**
     * Getter for field input attributes.
     *
     * @return array<string,mixed> Field input attributes.
     */
    protected function get_input_attrs() : array
    {
        $attrs = parent::get_input_attrs();

        $attrs['min'] = 1;

        return $attrs;
    }

    /**
     * Getter for $this->target_object slug.
     *
     * @return string   Target object slug or 'users' if $this->target_object_type
     *                  is set to 'users'.
     */
    protected function get_target_object_slug() : string
    {
        $target_object_slug = $this->target_object_type;

        if ( $this->target_object_type === 'post_type' || $this->target_object_type === 'tax' )
        {
            $target_object_slug .= '_' . $this->target_object->name;
        }

        return $target_object_slug;
    }
}