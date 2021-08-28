<?php

namespace Cvy_AC\helpers\inc;

class Post_Types
{
    public static function get_visible() : array
    {
        return get_post_types([
            'public'  => true,
            'show_ui' => true,
        ], 'objects' );
    }
}
