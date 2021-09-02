<?php

namespace Cvy_AC\inc\dashboard_tables;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Cell of the ACF fields based dashboard table column.
 */
class ACF_Cell implements \Cvy_AC\helpers\inc\dashboard\tables\iCell
{
    /**
     * ACF fields which values should be used as cell content.
     *
     * @var array<\Cvy_AC\inc\acf\Field>
     */
    protected $fields = [];

    /**
     * @param array $fields See documentation of $this->fields.
     */
    public function __construct( array $fields )
    {
        $this->fields = $fields;
    }

    /**
     * Prints cell content.
     *
     * @return void
     */
    public function print() : void
    {
        $templates_dir = \Cvy_AC\Plugin::get_instance()->get_templates_dir();

        $is_single_field = count( $this->fields ) === 1;

        foreach ( $this->fields as $field )
        {
            if ( ! $is_single_field )
            {
                $title = $field->get_label( true );
            }

            require $templates_dir . 'dashboard-tables/acf_cell.php';
        }
    }
}
