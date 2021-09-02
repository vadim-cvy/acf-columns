<?php

namespace Cvy_AC\inc\acf;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Incapsulates common ACF fields related methods.
 */
class Fields extends \Cvy_AC\helpers\inc\acf\field\Fields
{
    /**
     * Return fields which have dashboard table column(s).
     *
     * @return array<Field>
     */
    public static function get_fields_having_column() : array
    {
        $setting_name = Field_Setting__Show_Dashboard_Column::get_instance()->get_name();

        return static::get_by_setting( $setting_name, 1 );
    }

    /**
     * Creates field instance.
     *
     * @param   string $field_key   Field key.
     * @return  Field               Field instance.
     */
    protected static function create_using_key( string $field_key ) : \Cvy_AC\helpers\inc\acf\field\Field
    {
        return new Field( $field_key );
    }
}
