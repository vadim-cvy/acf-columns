<?php

namespace Cvy_AC\inc\acf;

use \Cvy_AC\helpers\inc\acf\group\Groups;

/**
 * Representation of ACF field.
 */
class Field extends \Cvy_AC\helpers\inc\acf\field\Field
{
    /**
     * Returns post types which match field location rules.
     *
     * @return array<string> Post types names.
     */
    public function get_post_types() : array
    {
        $post_types = [];

        foreach ( \Cvy_AC\helpers\inc\Post_Types::get_visible() as $post_type )
        {
            $post_type = $post_type->name;

            $groups = Groups::get_by_post_type( $post_type );

            if ( $this->belongs_to_any_group( $groups ) )
            {
                $post_types[] = $post_type;
            }
        }

        return $post_types;
    }

    /**
     * Returns taxonomies which match field location rules.
     *
     * @return array<string> Taxonomies names.
     */
    public function get_taxonomies() : array
    {
        $taxonomies = [];

        foreach ( \Cvy_AC\helpers\inc\Taxonomies::get_visible() as $taxonomy )
        {
            $taxonomy = $taxonomy->name;

            $groups = Groups::get_by_taxonomy( $taxonomy );

            if ( $this->belongs_to_any_group( $groups ) )
            {
                $taxonomies[] = $taxonomy;
            }
        }

        return $taxonomies;
    }

    /**
     * Checks if Users table match field location rules.
     *
     * @return boolean True if field appears in Users table, false otherwise.
     */
    public function is_available_for_users() : bool
    {
        $groups = [];

        foreach ( Groups::get_all() as $group )
        {
            foreach ( $group->get_original()['location'] as $rule_set )
            {
                $user_rule_types = [
                    'current_user',
                    'current_user_role',
                    'user_form',
                    'user_role',
                ];

                $rule_types = array_unique( array_column( $rule_set, 'param' ) );

                $rule_types_intersect = array_intersect( $user_rule_types, $rule_types );

                $is_users_related_rull_set =
                    count( $rule_types_intersect ) === count( $rule_types );

                if ( $is_users_related_rull_set )
                {
                    $groups[] = $group;

                    continue 2;
                }
            }
        }

        return $this->belongs_to_any_group( $groups );
    }

    /**
     * Checks if field is a child of any of the passed groups.
     *
     * @param array<\Cvy_AC\helpers\inc\acf\group\Group> $groups Field groups.
     * @return boolean True if field is a child of one of the groups, false otherwise.
     */
    protected function belongs_to_any_group( array $groups ) : bool
    {
        foreach ( $groups as $group )
        {
            if ( $this->belongs_to_group( $group ) )
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if field is a child of the passed group.
     *
     * @param \Cvy_AC\helpers\inc\acf\group\Group $group Field group.
     * @return boolean True if field is a child of the passed group, false otherwise.
     */
    protected function belongs_to_group( $group ) : bool
    {
        return $group->get_key() === $this->get_group()->get_key();
    }

    /**
     * Prints the field value.
     *
     * @return void
     */
    public function print()
    {
        if ( empty( $this->get_value() ) && $this->get_type() !== 'true_false' )
        {
            echo '<p>-</p>';
        }
        else if ( $this->is_plain_text_field() )
        {
            echo '<p>' . $this->get_value() . '</p>';
        }
        else if ( $this->is_choice_field() )
        {
            echo $this->get_value_as_string__choice();
        }
        else if ( $this->is_post_field() )
        {
            echo $this->get_value_as_string__post();
        }
        else
        {
            $method_name = 'get_value_as_string__' . $this->get_type();

            echo $this->$method_name();
        }
    }

    /**
     * Returns field value as string. Works for choice fields.
     *
     * Field examples: Select, Button Group, etc.
     *
     * @return string
     */
    protected function get_value_as_string__choice() : string
    {
        $value = $this->get_value( '', false );

        if ( is_array( $value ) )
        {
            $output = '';

            foreach ( $value as $choice )
            {
                $output .= '<p>' . $this->get_original()['choices'][ $choice ] . '</p>';
            }
        }
        else
        {
            $output = '<p>' . $this->get_original()['choices'][ $value ] . '</p>';
        }

        return $output;
    }

    /**
     * Returns field value as string. Works for post fields.
     *
     * Field examples: Relationship, Page Link, etc.
     *
     * @return string
     */
    protected function get_value_as_string__post() : string
    {
        $value = $this->get_value( '', false );

        if ( is_array( $value ) )
        {
            $output = '';

            foreach ( $value as $post_id )
            {
                $output .= $this->get_post_link_html( $post_id );
            }
        }
        else
        {
            $output = $this->get_post_link_html( $value );
        }

        return $output;
    }

    /**
     * Returns post liknk as HTML for passed post id.
     *
     * @param integer $post_id  Post id.
     * @return string           Post link HTML.
     */
    protected function get_post_link_html( int $post_id ) : string
    {
        $post = get_post( $post_id );

        return $this->get_value_template([
            'url'    => get_edit_post_link( $post->ID ),
            'label'  => $post->post_title,
        ], 'url' );
    }

    /**
     * Returns field value as string. Works for Image field.
     *
     * @return string
     */
    protected function get_value_as_string__image() : string
    {
        $img_id = $this->get_value( '', false );

        return wp_get_attachment_image( $img_id );
    }

    /**
     * Returns field value as string. Works for File field.
     *
     * @return string
     */
    protected function get_value_as_string__file() : string
    {
        $file_id  = $this->get_value( '', false );
        $file_url = wp_get_attachment_url( $file_id );

        return $this->get_value_template([
            'url'   => $file_url,
            'label' => $file_url,
        ], 'url' );
    }

    /**
     * Returns field value as string. Works for True/False field.
     *
     * @return string
     */
    protected function get_value_as_string__true_false() : string
    {
        return empty( $this->get_value() ) ? 'No' : 'Yes';
    }

    /**
     * Returns field value as string. Works for Link field.
     *
     * @return string
     */
    protected function get_value_as_string__link() : string
    {
        $value = $this->get_value( '', false );

        return $this->get_value_template([
            'url'    => $value['url'],
            'label'  => $value['title'],
            'target' => $value['target'],
        ], 'url' );
    }

    /**
     * Returns field value as string. Works for URL field.
     *
     * @return string
     */
    protected function get_value_as_string__url() : string
    {
        $url = $this->get_value();

        return $this->get_value_template([
            'url'   => $url,
            'label' => $url
        ]);
    }

    /**
     * Returns field value as string. Works for Taxonomy field.
     *
     * @return string
     */
    protected function get_value_as_string__taxonomy() : string
    {
        $output = '';

        $value = $this->get_value( '', false );

        if ( ! is_array( $value ) )
        {
            $value = [
                $value
            ];
        }

        foreach ( $value as $term_id )
        {
            $term = get_term( $term_id, $this->get_original()['taxonomy'] );

            $output .= $this->get_value_template([
                'url'    => get_edit_term_link( $term->term_id ),
                'label'  => $term->name,
            ], 'url' );
        }

        return $output;
    }

    /**
     * Returns field value as string. Works for User field.
     *
     * @return string
     */
    protected function get_value_as_string__user() : string
    {
        $value = $this->get_value( '', false );

        if ( ! is_array( $value ) )
        {
            $value = [
                $value,
            ];
        }

        $users_data = [];

        foreach ( $value as $user_id )
        {
            $user = get_userdata( $user_id );

            $users_data[] = [
                [
                    'label' => 'Name',
                    'value' => $user->first_name,
                ],
                [
                    'label' => 'Last Name',
                    'value' => $user->last_name,
                ],
                [
                    'label' => 'Email',
                    'value' => $user->user_email,
                ],
                [
                    'label' => 'Login',
                    'value' => $user->user_login,
                ],
                'edit_link' => [
                    'label' => 'Edit User Profile',
                    'value' => get_edit_user_link( $user->ID ),
                ],
            ];
        }

        return $this->get_value_template([
            'users_data' => $users_data
        ]);
    }

    /**
     * Returns field value as string. Works for Color Picker field.
     *
     * @return string
     */
    protected function get_value_as_string__color_picker() : string
    {
        return $this->get_value_template([
            'color' => $this->get_value(),
        ]);
    }

    /**
     * Returns field value as string. Works for WYSIWYG field.
     *
     * @return string
     */
    protected function get_value_as_string__wysiwyg() : string
    {
        return $this->get_value();
    }

    /**
     * Imports field value template file.
     *
     * @param array<string,mixed> $args Template variables array (var_name => var_value).
     * @param string $template_type     Template type. Will be converted to template name
     *                                  like this: "field_value__{type}".
     * @return string                   Template output.
     */
    protected function get_value_template( array $args = [], string $template_type = '' ) : string
    {
        if ( ! $template_type )
        {
            $template_type = $this->get_type();
        }

        ob_start();

        extract( $args );

        require
            \Cvy_AC\Plugin::get_instance()->get_value_templates_dir() .
            'dashboard-tables/field_value__' . $template_type . '.php';

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }

    /**
     * Checks if field value is a plain text.
     *
     * @return boolean True if field value is a plain text, false otherwise.
     */
    protected function is_plain_text_field() : bool
    {
        return in_array( $this->get_type(), [
            'text',
            'textarea',
            'number',
            'range',
            'email',
            'password',
            'date_picker',
            'date_time_picker',
            'time_picker',
            'oembed',
        ]);
    }

    /**
     * Checks if field value is a choice.
     *
     * @return boolean True if field value is a choice, false otherwise.
     */
    protected function is_choice_field() : bool
    {
        return in_array( $this->get_type(), [
            'select',
            'checkbox',
            'radio',
            'button_group',
        ]);
    }

    /**
     * Checks if field value is a post(s).
     *
     * @return boolean True if field value is a post(s), false otherwise.
     */
    protected function is_post_field() : bool
    {
        return in_array( $this->get_type(), [
            'relationship',
            'page_link',
            'post_object',
        ]);
    }
}