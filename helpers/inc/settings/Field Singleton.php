<?php

namespace Cvy_AC\helpers\inc\settings;

/**
 * Setting field.
 *
 * A wrapper for add_settings_field().
 *
 * May have only 1 instance.
 */
abstract class Field
{
    use Cvy_AC\helpers\inc\design_pattern\tSingleton;

    use tField;

    protected function __construct()
    {
        $this->on_construct();
    }
}