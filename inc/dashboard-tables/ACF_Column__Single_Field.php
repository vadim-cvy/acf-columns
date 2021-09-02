<?php

namespace Cvy_AC\inc\dashboard_tables;

use \Cvy_AC\inc\acf\Field;

/**
 * ACF field based dashbooard table column.
 *
 * Accepts only 1 ACF field.
 */
class ACF_Column__Single_Field extends ACF_Column
{
    /**
     * ACF field which value should be used as column cells content.
     *
     * @var \Cvy_AC\inc\acf\Field
     */
    protected $field = null;

    /**
     * @param Field $field          See documentation of $this->field.
     * @param string $screen_name   Screen(table) name. Ex:
     *                              - "my_custom_post_type" - My Custom Post Type table;
     *                              - "my_custom_taxonomy" - My Custom Taxonomy table;
     *                              - "users" - Users table.
     */
    public function __construct( Field $field, string $screen_name )
    {
        $this->field = $field;

        parent::__construct( $screen_name );
    }

    /**
     * Returns column name (slug).
     *
     * @return string Column name (slug).
     */
    protected function get_name() : string
    {
        $prefix = \Cvy_AC\Plugin::get_instance()->get_prefix();

        return $prefix . '__' . $this->get_field()->get_key();
    }

    /**
     * Returns column title.
     *
     * @return string Column title.
     */
    protected function get_title() : string
    {
        return $this->get_field()->get_label( true );
    }

    /**
     * Getter for $this->field.
     *
     * @return Field
     */
    public function get_field() : Field
    {
        return $this->field;
    }

    /**
     * Creates a table cell instance based on the passed object id.
     *
     * @param integer $object_id    Post id, or term id, or user id.
     * @return iCell                Cell instance.
     */
    protected function create_cell( int $object_id ) : \Cvy_AC\helpers\inc\dashboard\tables\iCell
    {
        return $this->create_cell_instance( $object_id, [
            $this->field
        ]);
    }
}