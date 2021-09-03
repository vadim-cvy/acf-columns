<?php

namespace Cvy_AC\inc\dashboard_tables;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Inits all the dashboard tables-related functionality.
 */
class Tables_Controller
{
    use \Cvy_AC\helpers\inc\design_pattern\tSingleton;

    public function __construct()
    {
        ACF_Columns::get_instance();
    }
}