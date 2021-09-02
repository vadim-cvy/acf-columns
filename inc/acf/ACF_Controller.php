<?php

namespace Cvy_AC\inc\acf;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ACF related functionality controller.
 */
class ACF_Controller
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    protected function __construct()
    {
        $this->register_custom_settings();
    }

    /**
     * Registers custom ACF fields settings.
     *
     * @return void
     */
    protected function register_custom_settings() : void
    {
        Field_Setting__Show_Dashboard_Column::get_instance();
    }
}