<?php

/**
 * Cell content part of the ACF field based dashboard table column.
 *
 * Is used for displaying values of User fields.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$prefix = \Cvy_AC\Plugin::get_instance()->get_prefix() . '_';

foreach ( $users_data as $user_data )
{ ?>
    <div class="<?php echo $prefix; ?>user_data">
        <?php
        foreach ( $user_data as $key => $data_item )
        {
            $value = $data_item['value'];

            if ( empty( $value ) )
            {
                continue;
            }

            if ( $key === 'edit_link' )
            {
                $url   = $value;
                $label = $data_item['label'];

                require __DIR__ . '/field_value__url.php';
            }
            else
            { ?>
                <p>
                    <?php echo $data_item['label'] . ': ' . $value; ?>
                </p>
            <?php
            }
        } ?>
    </div>
<?php
}