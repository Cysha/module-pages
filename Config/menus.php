<?php

/**
 * TODO: add a link here to the docs for config/menus.php.
 */
return [

    'backend_sidebar' => [
        'Pages' => [
            'order' => 104,
            'children' => [
                [
                    'route' => 'admin.pages.manager',
                    'text' => 'Pages Manager',
                    'icon' => 'fa-file-o',
                    'order' => 1,
                    'permission' => 'manage@pages_backend',
                    'activePattern' => '\/{backend}\/pages\/*',
                ],
            ],
        ],
    ],

];
