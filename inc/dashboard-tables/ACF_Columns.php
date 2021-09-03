<?php

namespace Cvy_AC\inc\dashboard_tables;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Inits and handles common functionality for ACF fields based dashboard table columns.
 */
class ACF_Columns
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    public function __construct()
    {
        \Cvy_AC\helpers\inc\WP_Hooks::add_action_ensure( 'init', [ $this, '_callback__init' ] );
    }

    /**
     * A callback for "init" wp hook. Acts as a class initiator.
     *
     * @return void
     */
    public function _callback__init() : void
    {
        $this->register_columns();
    }

    /**
     * Registers ACF fields based columns.
     *
     * @return void
     */
    protected function register_columns() : void
    {
        $this->register_post_types_columns();

        $this->register_taxonomies_columns();

        $this->register_user_columns();
    }

    /**
     * Registers ACF fields based columns (post types tables).
     *
     * @return void
     */
    protected function register_post_types_columns() : void
    {
        foreach ( $this->get_post_types_fields() as $post_type => $post_type_fields )
        {
            $this->register_screen_columns( $post_type_fields, $post_type );
        }
    }

    /**
     * Returns fields which are designed for posts (any post types).
     *
     * @return array<\Cvy_AC\inc\acf\Field> Fields array.
     */
    protected function get_post_types_fields() : array
    {
        $post_types_fields = [];

        foreach ( \Cvy_AC\inc\acf\Fields::get_fields_having_column() as $field )
        {
            foreach ( $field->get_post_types() as $post_type )
            {
                if ( ! isset( $post_types_fields[ $post_type ] ) )
                {
                    $post_types_fields[ $post_type ] = [];
                }

                $post_types_fields[ $post_type ][] = $field;
            }
        }

        return $post_types_fields;
    }

    /**
     * Registers ACF fields based columns (taxonomies tables).
     *
     * @return void
     */
    protected function register_taxonomies_columns() : void
    {
        foreach ( $this->get_taxonomies_fields() as $taxonomy => $taxonomy_fields )
        {
            $this->register_screen_columns( $taxonomy_fields, $taxonomy );
        }
    }

    /**
     * Returns fields which are designed for terms (any taxonomies).
     *
     * @return array<\Cvy_AC\inc\acf\Field> Fields array.
     */
    protected function get_taxonomies_fields() : array
    {
        $taxonomies_fields = [];

        foreach ( \Cvy_AC\inc\acf\Fields::get_fields_having_column() as $field )
        {
            foreach ( $field->get_taxonomies() as $taxonomy )
            {
                if ( ! isset( $taxonomies_fields[ $taxonomy ] ) )
                {
                    $taxonomies_fields[ $taxonomy ] = [];
                }

                $taxonomies_fields[ $taxonomy ][] = $field;
            }
        }

        return $taxonomies_fields;
    }

    /**
     * Registers ACF fields based columns (users table).
     *
     * @return void
     */
    protected function register_user_columns() : void
    {
        $user_fields = $this->get_user_fields();
        $screen_name = 'users';

        $this->register_screen_columns( $user_fields, $screen_name );
    }

    /**
     * Returns fields which are designed for users.
     *
     * @return array<\Cvy_AC\inc\acf\Field> Fields array.
     */
    protected function get_user_fields() : array
    {
        $user_fields = [];

        foreach ( \Cvy_AC\inc\acf\Fields::get_fields_having_column() as $field )
        {
            if ( $field->is_available_for_users() )
            {
                $user_fields[] = $field;
            }
        }

        return $user_fields;
    }

    /**
     * Registers ACF field based columns for specified screen.
     *
     * @param array<\Cvy_AC\inc\acf\Field> $screen_fields   ACF Fields which should have a column
     *                                                      an specified screen.
     * @param string $screen_name                           Screen(table) name. Ex:
     *                                                          - "my_custom_post_type" - My Custom Post Type table;
     *                                                          - "my_custom_taxonomy" - My Custom Taxonomy table;
     *                                                          - "users" - Users table.
     * @return void
     */
    protected function register_screen_columns( array $screen_fields, string $screen_name ) : void
    {
        $max_columns_allowed = $this->get_screen_max_columns( $screen_name );

        if ( count( $screen_fields ) > $max_columns_allowed )
        {
            $this->columns[] = new ACF_Column__Merged( $screen_fields, $screen_name );
        }
        else
        {
            foreach ( $screen_fields as $field )
            {
                $this->columns[] = new ACF_Column__Single_Field( $field, $screen_name );
            }
        }
    }

    /**
     * Returns a max number of ACF filed based columns allowed for specified screens.
     *
     * @param string $screen_name   Screen(table) name. Ex:
     *                                - "my_custom_post_type" - My Custom Post Type table;
     *                                - "my_custom_taxonomy" - My Custom Taxonomy table;
     *                                - "users" - Users table.
     * @return integer              Max number of ACF filed based columns allowed
     *                              for specified screens.
     */
    protected function get_screen_max_columns( string $screen_name ) : int
    {
        $setting_name = $screen_name . '_max_columns';

        $settings =
            \Cvy_AC\inc\plugin_settings\settings\general\Setting::get_instance()->get_value();

        return $settings[ $setting_name ];
    }
}