<?php

namespace Cvy_AC\inc\plugin_settings;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin settings controller.
 */
class Plugin_Settings_Controller
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    protected function __construct()
    {
        $this->register_settings();

        $this->register_settings_pages();
    }

    /**
     * Registers plugin settings (options).
     *
     * @return void
     */
    protected function register_settings() : void
    {
        \Cvy_AC\inc\plugin_settings\settings\general\Setting::get_instance();
    }

    /**
     * Registers plugin settings pages.
     *
     * @return void
     */
    protected function register_settings_pages() : void
    {
        \Cvy_AC\inc\plugin_settings\pages\Main::get_instance();
    }
}