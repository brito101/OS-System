<?php

use Illuminate\Support\Facades\Auth;

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

    'title' => env('APP_NAME'),
    'title_prefix' => env('APP_NAME'),
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

    'use_ico_only' => true,
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

    'logo' => env('APP_NAME'),
    'logo_img' => 'img/logo-circle.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => env('APP_NAME'),

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

    'usermenu_enabled' => false,
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
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

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

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
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
    'register_url' => false, //'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
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
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Pesquisar',
        ],
        //Custom menus
        [
            'text'        => 'Dashboard',
            'url'         => '/admin',
            'icon'        => 'fa fa-fw fa-digital-tachograph',
        ],
        [
            'text'        => 'Usuários',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-users',
            'can'         => 'Acessar Usuários',
            'submenu' => [
                [
                    'text' => 'Listagem de Usuários',
                    'url'  => 'admin/users',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Usuários',
                ],
                [
                    'text' => 'Cadastro de Usuários',
                    'url'  => 'admin/users/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Usuários',
                ],
            ],
        ],
        [
            'text'        => 'Filiais',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-building',
            'can'         => 'Acessar Filiais',
            'submenu' => [
                [
                    'text' => 'Listagem de Filiais',
                    'url'  => 'admin/subsidiaries',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Filiais',
                ],
                [
                    'text' => 'Cadastro de Filial',
                    'url'  => 'admin/subsidiaries/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Filiais',
                ],
                [
                    'text' => 'Gerentes',
                    'url'  => 'admin/subsidiaries/managers',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Gerentes',
                ],
                [
                    'text' => 'Colaboradores',
                    'url'  => 'admin/subsidiaries/collaborators',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Colaboradores',
                ],
                [
                    'text' => 'Financistas',
                    'url'  => 'admin/subsidiaries/financiers',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Financistas',
                ],
            ],
        ],
        [
            'text'        => 'Funcionários',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-users-cog',
            'can'         => 'Acessar Funcionários',
            'submenu' => [
                [
                    'text' => 'Listagem de Funcionários',
                    'url'  => 'admin/employees',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Funcionários',
                ],
                [
                    'text' => 'Cadastro de Funcionário',
                    'url'  => 'admin/employees/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Funcionários',
                ],
            ],
        ],
        [
            'text'        => 'Vendedores',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-id-badge',
            'can'         => 'Acessar Vendedores',
            'submenu' => [
                [
                    'text' => 'Listagem de Vendedores',
                    'url'  => 'admin/sellers',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Vendedores',
                ],
                [
                    'text' => 'Cadastro de Vendedor',
                    'url'  => 'admin/sellers/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Vendedores',
                ],
            ]
        ],
        [
            'text'        => 'Clientes',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-user-plus',
            'can'         => 'Acessar Clientes',
            'submenu' => [
                [
                    'text' => 'Listagem de Clientes',
                    'url'  => 'admin/clients',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Clientes',
                ],
                [
                    'text' => 'Cadastro de Clientes',
                    'url'  => 'admin/clients/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Clientes',
                ],
            ],
        ],
        [
            'text'        => 'Fornecedores',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-truck',
            'can'         => 'Acessar Fornecedores',
            'submenu' => [
                [
                    'text' => 'Listagem de Fornecedores',
                    'url'  => 'admin/providers',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Fornecedores',
                ],
                [
                    'text' => 'Cadastro de Fornecedor',
                    'url'  => 'admin/providers/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Fornecedores',
                ],
            ],
        ],
        [
            'text'        => 'Ordens de Serviço',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-list',
            'can'         => 'Acessar Ordens de Serviço',
            'submenu' => [
                [
                    'text' => 'Listagem de O. S.',
                    'url'  => 'admin/service-orders',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Ordens de Serviço',
                ],
                [
                    'text' => 'Cadastro de de O. S.',
                    'url'  => 'admin/service-orders/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Ordens de Serviço',
                ],
            ],
        ],
        [
            'text'        => 'Financeiro',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-money-bill',
            'can'         => 'Acessar Financeiro',
            'submenu' => [
                [
                    'text' => 'Listagem de Receitas',
                    'url'  => 'admin/finance-incomes',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Rendas',
                ],
                [
                    'text' => 'Cadastro de Receita',
                    'url'  => 'admin/finance-incomes/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Rendas',
                ],
                [
                    'text' => 'Listagem de Despesas',
                    'url'  => 'admin/finance-expenses',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Despesas',
                ],
                [
                    'text' => 'Cadastro de Despesa',
                    'url'  => 'admin/finance-expenses/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Despesas',
                ],
                [
                    'text' => 'Listagem de Reembolsos',
                    'url'  => 'admin/finance-refunds',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Reembolsos',
                ],
                [
                    'text' => 'Cadastro de Reembolso',
                    'url'  => 'admin/finance-refunds/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Reembolsos',
                ],
                [
                    'text' => 'Listagem de O. de Compra',
                    'url'  => 'admin/finance-purchase-orders',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Ordens de Compra',
                ],
                [
                    'text' => 'Cadastro de O. de Compra',
                    'url'  => 'admin/finance-purchase-orders/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Ordens de Compra',
                ],
            ],
        ],
        [
            'text'        => 'Comissões',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-coins',
            'can'         => 'Acessar Comissões',
            'submenu' => [
                [
                    'text' => 'Listagem de Comissões',
                    'url'  => 'admin/commissions',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Comissões',
                ],
                [
                    'text' => 'Cadastro de Comissão',
                    'url'  => 'admin/commissions/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Comissões',
                ],
            ]
        ],
        [
            'text'        => 'Passagens',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-file-invoice-dollar',
            'can'         => 'Acessar Pagamento de Passagens',
            'submenu' => [
                [
                    'text' => 'Listagem de Pagamentos',
                    'url'  => 'admin/ticket-payments',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Pagamento de Passagens',
                ],
                [
                    'text' => 'Cadastro de Pagamento',
                    'url'  => 'admin/ticket-payments/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Pagamento de Passagens',
                ],
            ]
        ],
        [
            'text'        => 'Estoque',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-box',
            'can'         => 'Acessar Estoque',
            'submenu' => [
                [
                    'text' => 'Estoque Consolidado',
                    'url'  => 'admin/stocks/consolidated',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Movimentações',
                ],
                [
                    'text' => 'Movimentações',
                    'url'  => 'admin/stocks',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Movimentações',
                ],
                [
                    'text' => 'Cadastrar Movimentação',
                    'url'  => 'admin/stocks/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Movimentações',
                ],
                [
                    'text' => 'Listagem de Produtos',
                    'url'  => 'admin/products',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Produtos',
                ],
                [
                    'text' => 'Cadastro de Produto',
                    'url'  => 'admin/products/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Produtos',
                ],
            ]
        ],
        /** Schedule */
        [
            'text'        => 'Agenda',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-calendar',
            'can'         => 'Acessar Agenda',
            'submenu' => [
                [
                    'text' => 'Eventos da Agenda',
                    'url'  => 'admin/schedule',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Eventos na Agenda',
                ],
                [
                    'text' => 'Cadastro de Eventos',
                    'url'  => 'admin/schedule/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Eventos na Agenda',
                ],
            ],
        ],
        [
            'text'        => 'Atividades',
            'url'         => '#',
            'icon'        => 'fas fa-fw fa-clipboard-list',
            'can'         => 'Acessar Atividades',
            'submenu' => [
                [
                    'text' => 'Listagem de Atividades',
                    'url'  => 'admin/activities',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Listar Atividades',
                ],
                [
                    'text' => 'Cadastro de Atividades',
                    'url'  => 'admin/activities/create',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'can'  => 'Criar Atividades',
                ],
            ],
        ],
        [
            'text'    => 'ACL',
            'icon'    => 'fas fa-fw fa-user-shield',
            'can'     => 'Acessar ACL',
            'submenu' => [

                [
                    'text' => 'Listagem de Perfis',
                    'url'  => 'admin/role',
                    'icon'    => 'fas fa-fw fa-chevron-right',
                    'can'     => 'Listar Perfis',
                ],
                [
                    'text' => 'Cadastro de Perfis',
                    'url'  => 'admin/role/create',
                    'icon'    => 'fas fa-fw fa-chevron-right',
                    'can'     => 'Criar Perfis',
                ],
                [
                    'text' => 'Listagem de Permissões',
                    'url'  => 'admin/permission',
                    'icon'    => 'fas fa-fw fa-chevron-right',
                ],
                [
                    'text' => 'Cadastro de Permissões',
                    'url'  => 'admin/permission/create',
                    'icon'    => 'fas fa-fw fa-chevron-right',
                    'can'     => 'Criar Permissões',
                ],
            ]
        ],
        [
            'text'        => 'Site',
            'url'    => '/',
            'icon'    => 'fas fa-fw fa-link',
            'target' => '_blank',
        ]
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
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
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
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'vendor/chart.js/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
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
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
        'select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],

        'BootstrapSelect' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
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
    |
    */

    'livewire' => false,
];
