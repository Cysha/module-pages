<?php

/**
 * TODO: add a link here to the docs for config/menus.php.
 */
return [
    'backend_sidebar' => [
        'Site Management' => [
            'children' => [
                [
                    'route' => 'admin.route.manager',
                    'text' => 'Route Manager',
                    'icon' => 'fa-code-fork',
                    'order' => 99,
                    'permission' => 'manage@admin_config',
                    'activePattern' => '\/{backend}\/routes\/*',
                ],
            ],
        ],
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

    'backend_config_menu' => [
        [
            'route' => 'admin.pages.manager',
            'text' => 'Editor Settings',
            'icon' => 'fa-wrench',
            'order' => 10,
            'permission' => 'manage@pages_backend',
        ],
    ],

];
