<?php
/**
 * Cell content part of the ACF field based dashboard table column.
 *
 * Is used for displaying values of Color Picker fields.
 */

$prefix = \Cvy_AC\Plugin::get_instance()->get_prefix() . '_'; ?>

<div class="<?php echo $prefix; ?>color" style="background-color: <?php echo $color; ?>;">
</div>