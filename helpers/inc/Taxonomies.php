<?php

namespace Cvy_AC\helpers\inc;

class Taxonomies
{
    public static function get_visible() : array
    {
        return get_taxonomies([
            'public'  => true,
            'show_ui' => true,
        ], 'objects' );
    }
}
