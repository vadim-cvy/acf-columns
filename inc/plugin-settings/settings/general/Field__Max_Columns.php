<?php

namespace Cvy_AC\inc\plugin_settings\settings\general;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Max Columns field.
 *
 * Allows to set a number of maximum columns to be displayed in the table. Clomuns
 * will be merged into 1 column if the limit is reached.
 *
 * A wrapper for add_settings_field().
 */
class Field__Max_Columns extends \Cvy_AC\helpers\inc\settings\Field__Dynamic
{
    /**
     * Screen (table) name.
     *
     * Ex:
     *  - "my_custom_post_type" - My Custom Post Type table;
     *  - "my_custom_taxonomy" - My Custom Taxonomy table;
     *  - "users" - Users table.
     *
     * @var string
     */
    protected $screen_name = '';

    /**
     * @param string $screen_name See documentation of $this->screen.
     */
    public function __construct( string $screen_name )
    {
        $this->screen_name = $screen_name;

        parent::__construct();
    }

    /**
     * Getter for the field id.
     *
     * @return string Field id.
     */
    public function get_id() : string
    {
        return $this->screen_name . '_max_columns';
    }

    /**
     * Getter for the field label.
     *
     * @return string Field label.
     */
    protected function get_label() : string
    {
        if ( $this->screen_name === 'users' )
        {
            return 'Users';
        }

        $post_type = get_post_type_object( $this->screen_name );

        if ( $post_type )
        {
            return $post_type->name;
        }

        return get_taxonomy( $this->screen_name )->name;
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
}