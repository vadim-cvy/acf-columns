<?php

namespace Cvy_AC\inc\plugin_settings\pages;

use \Cvy_AC\Plugin;

use \Cvy_AC\helpers\inc\settings\Section;

/**
 * Plugin main settings page.
 */
class Main extends \Cvy_AC\helpers\inc\settings\Page
{
    /**
     * Sections generator.
     *
     * This method is called once and then the value is cached in $this->sections.
     *
     * @return array<Section>
     */
    protected function generate_sections() : array
    {
        return [
            'general' => new Section(
                'general',
                'General',
                '',
                $this
            ),
        ];
    }

    /**
     * Getter for page title.
     *
     * @return string Page title.
     */
    protected function get_page_title() : string
    {
        return \Cvy_AC\Plugin::get_instance()->get_name() . ' Settings';
    }

    /**
     * Getter for menu title.
     *
     * @return string Menu title.
     */
    protected function get_menu_title() : string
    {
        return \Cvy_AC\Plugin::get_instance()->get_name();
    }

    /**
     * Getter for page slug.
     *
     * @return string Page slug.
     */
    public function get_slug() : string
    {
        return \Cvy_AC\Plugin::get_instance()->get_prefix() . '_settings-page';
    }

    /**
     * Getter for minimum capability which is required to have access to the page.
     *
     * @return string Capability.
     */
    protected function get_capability() : string
    {
        return 'manage_options';
    }
}