<?php
/**
 * Cell content part of the ACF field based dashboard table column.
 *
 * Is used for displaying values of URL fields.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( empty( $target ) )
{
    $target = '_blank';
} ?>

<p>
    <a href="<?php echo $url; ?>" target="<?php echo $target; ?>">
        <?php echo $label; ?>
    </a>
</p>