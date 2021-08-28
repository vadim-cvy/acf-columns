<?php

namespace Cvy_AC\helpers\inc\dashboard\tables;

use \Cvy_AC\helpers\inc\WP_Hooks;

/**
 * Representation of the WP dashboard table column.
 *
 * Works for all types of tables: post types, taxonomies, users.
 */
abstract class Column
{
    protected function __construct()
    {
        $this->register();
    }

    /**
     * Registers the column in dashboard tables.
     *
     * @return void
     */
    protected function register() : void
    {
        $this->add_post_types_hooks();

        $this->add_taxonomies_hooks();

        $this->add_users_hooks();
    }

    /**
     * Registers the column for post types tables.
     *
     * @return void
     */
    protected function add_post_types_hooks() : void
    {
        foreach ( $this->get_post_types() as $post_type )
        {
            $this->register_screen_hooks(  $post_type . '_posts' );
        }
    }

    /**
     * Registers the column for taxonomies tables.
     *
     * @return void
     */
    protected function add_taxonomies_hooks() : void
    {
        foreach ( $this->get_taxonomies() as $taxonomy )
        {
            $this->register_screen_hooks( $taxonomy );
        }
    }

    /**
     * Registers the column for users table.
     *
     * @return void
     */
    protected function add_users_hooks() : void
    {
        if ( $this->is_available_for_users_table() )
        {
            $this->register_screen_hooks( 'users' );
        }
    }

    /**
     * A wrapper for 'manage_{screen_name}_columns' and 'manage_{screen_name}_custom_column'.
     *
     * @param string $screen_name   Screen name.
     * @return void
     */
    protected function register_screen_hooks( string $screen_name ) : void
    {
        $add_column_hook_name = 'manage_' . $screen_name . '_columns';
        $print_cell_hook_name = 'manage_' . $screen_name . '_custom_column';

        WP_Hooks::add_filter_ensure( $add_column_hook_name, [ $this, '_add_column' ] );

        WP_Hooks::add_action_ensure( $print_cell_hook_name, [ $this, '_print_column_cell' ] );
    }

    /**
     * A callback for 'manage_{screen_name}_columns'.
     *
     * @param   array<string> $table_columns    Inital table columns.
     * @return  array<string>                   $table_columns merged with current column.
     */
    public function _add_column( array $table_columns ) : array
    {
        $table_columns[ $this->get_name() ] = $this->get_title();

        return $table_columns;
    }

    /**
     * A callback for 'manage_{screen_name}_custom_column'.
     *
     * @param   string $column_name    Name of the cell's column.
     * @return  void
     */
    public function _print_column_cell( string $column_name ) : void
    {
        if ( $column_name !== $this->get_name() )
        {
            return;
        }

        $cell = $this->create_cell( $this->get_current_table_data() );

        $cell->print();
    }

    /**
     * Returns information regarding current table (screen).
     *
     * @return array<mixed> Current table (screen) data.
     */
    protected function get_current_table_data() : array
    {
        $screen = get_current_screen();

        $is_post_type_table = $screen->base === 'edit';

        if ( $is_post_type_table )
        {
            return [
                'table_type' => 'posts',
                'post_id'    => get_the_ID(),
                'post_type'  => $screen->post_type,
            ];
        }
        else if ( $is_taxonomy_table )
        {
            return [
                'table_type'  => 'taxonomies',
                'taxonomy_id' => null,
                'post_type'   => $screen->post_type,
            ];
        }
        else if ( $is_users_table )
        {
            return [
                'table_type' => 'users',
                'user_id'    => null,
            ];
        }
    }

    /**
     * Creates a column cell instance.
     *
     * See $this->_print_column_cell().
     *
     * @param   array<mixed> $table_data    Current table (screen) data.
     * @return  iCell                       Column cell instance.
     */
    abstract protected function create_cell( array $table_data ) : iCell;

    /**
     * Returns post types the column is available for.
     *
     * @return array<string> Post types names.
     */
    abstract protected function get_post_types() : array;

    /**
     * Returns taxonomies the column is available for.
     *
     * @return array<string> Taxonomies names.
     */
    abstract protected function get_taxonomies() : array;

    /**
     * Checks if the column is available for the users table.
     *
     * @return bool True if column is available for users table, false otherwise.
     */
    abstract protected function is_available_for_users_table() : bool;

    /**
     * Returns column name (slug).
     *
     * @return string Column name (slug).
     */
    abstract protected function get_name() : string;

    /**
     * Returns column title.
     *
     * @return string Column title.
     */
    abstract protected function get_title() : string;
}
