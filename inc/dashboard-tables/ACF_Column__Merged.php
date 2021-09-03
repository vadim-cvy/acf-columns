<?php

namespace Cvy_AC\inc\dashboard_tables;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ACF field based dashbooard table column.
 *
 * Accepts multiple ACF fields.
 */
class ACF_Column__Merged extends ACF_Column
{
    /**
     * ACF fields which values should be used as column cells content.
     *
     * @var array<\Cvy_AC\inc\acf\Field>
     */
    protected $fields = [];

    /**
     * @param array<Field> $field   See documentation of $this->fields.
     * @param string $screen_name   Screen(table) name. Ex:
     *                              - "my_custom_post_type" - My Custom Post Type table;
     *                              - "my_custom_taxonomy" - My Custom Taxonomy table;
     *                              - "users" - Users table.
     */
    public function __construct( array $fields, string $screen_name )
    {
        $this->fields = $fields;

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

        return $prefix . '__merged';
    }

    /**
     * Returns column title.
     *
     * @return string Column title.
     */
    protected function get_title() : string
    {
        return 'ACF';
    }

    /**
     * Creates a table cell instance based on the passed object id.
     *
     * @param integer $object_id    Post id, or term id, or user id.
     * @return iCell                Cell instance.
     */
    protected function create_cell( int $object_id ) : \Cvy_AC\helpers\inc\dashboard\tables\iCell
    {
        return $this->create_cell_instance( $object_id, $this->fields );
    }
}
