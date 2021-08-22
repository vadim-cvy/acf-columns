<?php

namespace Cvy_AC\helpers\inc\settings;

/**
 * Setting field.
 *
 * A wrapper for add_settings_field().
 *
 * May have multiple instances.
 */
abstract class Field
{
    use tField;

    public function __construct()
    {
        $this->on_construct();
    }
}