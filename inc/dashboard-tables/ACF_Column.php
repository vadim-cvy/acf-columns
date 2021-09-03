<?php

namespace Cvy_AC\inc\dashboard_tables;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ACF field based dashbooard table column.
 */
abstract class ACF_Column extends \Cvy_AC\helpers\inc\dashboard\tables\Column
{
    /**
     * Creates a table cell instance.
     *
     * Table cell content will be a values list of the passed fields.
     *
     * @param integer $object_id    Cell post id, or term id, or user id.
     * @param array $fields         Acf fields which values will be printed as a cell content.
     * @return \Cvy_AC\helpers\inc\dashboard\tables\iCell Cell instance.
     */
    protected function create_cell_instance( int $object_id, array $fields ) : \Cvy_AC\helpers\inc\dashboard\tables\iCell
    {
        foreach ( $fields as $field )
        {
            $context = $this->get_acf_context( $object_id );

            $field->set_context( $context );
        }

        return new ACF_Cell( $fields );
    }

    /**
     * Returns ACF context for passed post/term/user id.
     *
     * ACF context is a second argument which is passed to ACF get_field() function.
     *
     * @param integer $object_id    Cell post id, or term id, or user id.
     * @return string               ACF context.
     */
    protected function get_acf_context( int $object_id ) : string
    {
        $table_type = $this->get_current_table_type();

        if ( $table_type === 'posts' )
        {
            return $object_id;
        }
        else if ( $table_type === 'tax' )
        {
            return get_current_screen()->taxonomy . '_' . $object_id;
        }
        else if ( $table_type === 'users' )
        {
            return 'user_' . $object_id;
        }
    }
}