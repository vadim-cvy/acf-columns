<input
    <?php
    foreach ( $this->get_input_attrs() as $key => $value )
    {
        echo $key . '="' . $value . '" ';
    } ?>
>

<?php
if ( $this->has_errors() )
{ ?>
    <!-- Todo: move to .css file -->
    <style>
        .color_error
        {
            color: red;
        }
    </style>

    <p class="color_error">
        <?php echo $this->get_error_hint(); ?>
    </p>
<?php
}