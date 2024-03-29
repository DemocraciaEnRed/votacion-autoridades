<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Democracia en Red',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Democracia en Red</b>',
    'logo_img' => '/img/logo-admin.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Democracia en Red',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => null,
    'password_reset_url' => null,
    'password_email_url' => null,
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        [
            'text' => 'Logout',
            'topnav_right' => true,
            'url'=> 'logout',
        ],
        'My account',
        [
            'text' => 'Perfil',
            'url'  => 'admin/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        'Administrator',
        [
            'text' => 'Administradores',
            'url'  => 'admin/administrators',
            'icon' => 'fas fa-fw fa-users',
            'can' => ['listar administradores'],
        ],
        [
            'text' => 'Roles',
            'url'  => 'admin/roles',
            'icon' => 'fas fa-fw fa-user-tag',
            'can' => ['listar roles'],
        ],
        'General',
        [
            'text' => 'Home',
            'url'  => 'admin/homes',
            'icon' => 'fas fa-home',
            'can' => ['ver home'],
        ],
        [
            'text' => 'Usuarios',
            'url'  => 'admin/users',
            'icon' => 'fas fa-fw fa-users',
            'can' => ['menu usuarios'],
            'submenu' => [
                [
                    'shift' => 'ml-3',
                    'text' => 'Listar',
                    'url'  => 'admin/users',
                    'icon' => 'fas fa-fw fa-list',
                    'can' => ['listar usuarios'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Validar',
                    'url'  => 'admin/users/validate',
                    'icon' => 'fas fa-fw fa-check',
                    'can' => ['ver validar usuario'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Validar todos los usuarios',
                    'url'  => 'admin/users/validate-all-users',
                    'icon' => 'fas fa-fw fa-check-double',
                    'can' => ['validar todos los usuarios'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Exportar',
                    'url'  => 'admin/users/export',
                    'icon' => 'fas fa-file-export',
                    'can' => ['exportar usuarios'],
                ],
            ],
        ],
        [
            'text' => 'Censo',
            'url'  => 'admin/rolls',
            'icon' => 'fas fa-fw fa-scroll',
            'can' => ['menu censo'],
            'submenu' => [
                [
                    'shift' => 'ml-3',
                    'text' => 'Listar',
                    'url'  => 'admin/rolls',
                    'icon' => 'fas fa-fw fa-list',
                    'can' => ['listar padrones'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Logs',
                    'url'  => 'admin/log-rolls',
                    'icon' => 'fas fa-fw fa-clipboard-list',
                    'can' => ['ver logs padrones'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Importar',
                    'url'  => 'admin/rolls/import',
                    'icon' => 'fas fa-fw fa-file-import',
                    'can' => ['ver importar padrones'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Exportar',
                    'url'  => 'admin/rolls/export',
                    'icon' => 'fas fa-fw fa-file-export',
                    'can' => ['ver exportar padrones'],
                ],
            ],
        ],
        [
            'text' => 'Bloques',
            'url'  => 'admin/blocks',
            'icon' => 'fas fa-fw fa-cubes',
            'can' => ['listar bloques'],
        ],
        [
            'text' => 'Planchas',
            'url'  => 'admin/plates',
            'icon' => 'fas fa-fw fa-vote-yea',
            'can' => ['listar planchas'],
        ],
        [
            'text' => 'Estados de votación',
            'url'  => 'admin/votes',
            'icon' => 'fas fa-fw fa-person-booth',
            'can' => ['ver estado de votacion'],
        ],
        [
            'text' => 'Resultados',
            'icon' => 'fas fa-fw fa-poll',
            'can' => 'menu resultados',
            'submenu' => [
                [
                    'shift' => 'ml-3',
                    'text' => 'Ver resultados',
                    'url'  => 'admin/vote-results',
                    'icon' => 'fas fa-fw fa-eye',
                    'can' => ['ver resultados'],
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Exportar',
                    'url'  => 'admin/vote-results/export',
                    'icon' => 'fas fa-fw fa-file-export',
                    'can' => ['exportar resultados'],
                ],
            ],
        ],
        [
            'text' => 'Cargar resultados manuales',
            'url'  => 'admin/vote-results/load-votes-manually',
            'icon' => 'fas fa-fw fa-plus',
            'can' => ['cargar resultados manuales'],
        ],
        [
            'text' => 'Personas no censadas',
            'url'  => 'admin/user-not-in-rolls/export',
            'icon' => 'fas fa-file-download',
            'can' => ['exportar personas no censadas'],
        ],
        [
            'text' => 'Designaciones',
            'url'  => 'admin/designations',
            'icon' => 'fas fa-drafting-compass',
            'can' => ['ver designaciones'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@9',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
