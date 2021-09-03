<?php
/**
 * Cell content template of the ACF field based dashboard table column.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$prefix = \Cvy_AC\Plugin::get_instance()->get_prefix() . '_'; ?>

<div
    class="
        <?php echo $prefix; ?>field
        <?php echo $prefix; ?>field_type_<?php echo $field->get_type(); ?>
        <?php echo ! empty( $title ) ? $prefix . 'has_title' : ''; ?>
    "
>
    <?php
    if ( ! empty( $title ) )
    { ?>
        <div class="<?php echo $prefix; ?>field_title">
            <?php echo esc_html( $title ); ?>
        </div>
    <?php
    } ?>

    <div class="<?php echo $prefix; ?>field_value">
        <?php echo $field->print(); ?>
    </div>
</div>