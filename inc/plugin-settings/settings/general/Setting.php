<?php

namespace Cvy_AC\inc\plugin_settings\settings\general;

/**
 * Container for the plugin general settings.
 *
 * A wrapper for register_setting().
 */
class Setting extends \Cvy_AC\helpers\inc\settings\Setting
{
    /**
     * Getter for setting name.
     *
     * @return string Setting name.
     */
    public function get_name() : string
    {
        return \Cvy_AC\Plugin::get_instance()->get_prefix() . '_general';
    }

    /**
     * Getter for a parent settings page instance.
     *
     * @return Page Parent settings page instance.
     */
    public function get_parent_page() : \Cvy_AC\helpers\inc\settings\Page
    {
        return \Cvy_AC\inc\plugin_settings\pages\Main::get_instance();
    }

    /**
     * Getter for setting fields.
     *
     * @return array<Field> Setting fields.
     */
    protected function get_fields() : array
    {
        static $fields = [];

        if ( ! empty( $fields ) )
        {
            return $fields;
        }

        $fields = array_merge(
            $this->get_post_types_fields__max_columns(),
            $this->get_tax_fields__max_columns()
        );

        $fields[] = new Field__Max_Columns( 'users' );

        return $fields;
    }

    /**
     * Getter for post types "Max Columns" setting fields.
     *
     * @return array<Field__Max_Columns> Setting fields.
     */
    protected function get_post_types_fields__max_columns() : array
    {
        $fields = [];

        foreach ( \Cvy_AC\helpers\inc\Post_Types::get_visible() as $post_type )
        {
            $fields[] = new Field__Max_Columns( 'post_type', $post_type );
        }

        return $fields;
    }

    /**
     * Getter for taxonomies "Max Columns" setting fields
     *
     * @return array<Field__Max_Columns> Setting fields.
     */
    protected function get_tax_fields__max_columns() : array
    {
        $fields = [];

        foreach ( \Cvy_AC\helpers\inc\Taxonomies::get_visible() as $taxonomy )
        {
            $fields[] = new Field__Max_Columns( 'tax', $taxonomy );
        }

        return $fields;
    }
}