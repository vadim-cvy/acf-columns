<?php

namespace Cvy_AC\helpers\inc\acf\field;

/**
 * Representation of ACF Field.
 */
class Field
{
    /**
     * Field key
     *
     * @var string
     */
    protected $key = '';

    /**
     * @param string $field_key Field key.
     */
    public function __construct( string $field_key )
    {
        $this->key = $field_key;
    }

    /**
     * Field key getter.
     *
     * @return string Field key.
     */
    public function get_key() : string
    {
        return $this->key;
    }

    /**
     * Returns field label.
     *
     * @param boolean $include_parents  Returned value will include field parents labels (including parent group)
     *                                  if $include_parents is set to true.
     *                                  Ex: "{group name} > {parent name} > {field name}".
     * @return string                   Field label.
     */
    public function get_label( bool $include_parents = false ) : string
    {
        $label = '';

        if ( $include_parents )
        {
            foreach ( array_reverse( $this->get_parents() ) as $parent )
            {
                $label .= $parent->get_label() . ' > ';
            }
        }

        $label .= $this->get_original()['label'];

        return $label;
    }

    /**
     * Checks if field exists.
     *
     * @return boolean True if field exists, false otherwise.
     */
    public function exists() : bool
    {
        try
        {
            $this->validate_exists();
        }
        catch ( Field_Not_Exist_Error $error )
        {
            return false;
        }

        return true;
    }

    /**
     * Checks and throws error if field does not exist.
     *
     * @return void
     */
    public function validate_exists()
    {
        $this->get_original();
    }

    /**
     * Wrapper for get_field_object().
     *
     * @return array<string,mixed> Field object.
     */
    public function get_original() : array
    {
        $field_object = get_field_object( $this->get_key() );

        if ( empty( $field_object ) )
        {
            throw new Field_Not_Exist_Error( $this );
        }

        return $field_object;
    }

    /**
     * Returns field parent.
     *
     * @return \Cvy_AC\helpers\inc\acf\group\Group|Field Field parent (group or field instance).
     */
    public function get_parent()
    {
        $parent_id = $this->get_original()['parent'];

        try
        {
            $parent = Fields::get_by_id( $parent_id, true );
        }
        catch ( Field_Not_Exist_Error $error )
        {
            $parent = \Cvy_AC\helpers\inc\acf\group\Groups::get_by_id( $parent_id );
        }

        return $parent;
    }

    /**
     * Returns all field parents.
     *
     * @return array<\Cvy_AC\helpers\inc\acf\group\Group|Field> Field parents.
     */
    public function get_parents() : array
    {
        $parents = [];

        $parent = $this->get_parent();

        while ( true )
        {
            $parents[] = $parent;

            if ( ! is_a( $parent, '\\' . self::class ) )
            {

                break;
            }

            $parent = $parent->get_parent();
        }

        return $parents;
    }

    /**
     * Returns field parent group.
     *
     * @return \Cvy_AC\helpers\inc\acf\group\Group Field parent group.
     */
    public function get_group() : \Cvy_AC\helpers\inc\acf\group\Group
    {
        $parents = $this->get_parents();

        return array_pop( $parents );
    }

    /**
     * Returns field type.
     *
     * @return string Field type.
     */
    public function get_type() : string
    {
        return $this->get_original()['type'];
    }

    /**
     * Returns field name.
     *
     * @return string Field name.
     */
    public function get_name() : string
    {
        return $this->get_original()['name'];
    }

    /**
     * Wrapper for the get_field().
     *
     * @param   string $context     "{post id}" or "{taxonomy}_{id}" or "{user}_{id}".
     * @return  mixed               Field value.
     */
    public function get_value( string $context = '' )
    {
        if ( $this->is_subfield() )
        {
            $parent_value = $this->get_parent()->get_value( $context );

            return $parent_value[ $this->get_name() ];
        }

        return get_field( $this->get_key(), $context );
    }

    /**
     * Checks if field has a parent filed.
     *
     * @return boolean True if field has a parent field, false otherwise.
     */
    protected function is_subfield()
    {
        return count( $this->get_parents() ) > 1;
    }
}