<?php

return [
    'dataLayout' => 'horizontal',

    'menus' => [
        'l' => [
            [
                'name' =>  'Clientes',
                'atc' =>  'clients',
                'icon' =>  'ri-user-shared-fill',
                'route' => 'clients.index',
            ],
            [
                'name' =>  'Serviços',
                'atc' =>  'services',
                'icon' =>  'ri-git-repository-private-fill',
                'route' => 'services.index',
            ],
            [
                'name' =>  'Concessionárias',
                'atc' =>  'concessionarias',
                'icon' =>  'ri-community-line',
                'route' => 'concessionarias.index',
            ],
            [
                'name' =>  'Comercial',
                'atc' =>  'comercial',
                'icon' =>  'ri-file-edit-fill',
                'route' => 'comercial.index',
            ],
            [
                'name' =>  'Obras',
                'icon' =>  'ri-building-4-line',
                'route' => 'obras.index',
            ],
            [
                'name' =>  'Financeiro',
                'atc' =>  'arquivos',
                'icon' =>  'ri-file-list-3-line',
                'route' => 'finances.index',
            ],
            [
                'name' =>  'Arquivos',
                'atc' =>  'arquivos',
                'icon' =>  'ri-file-list-3-line',
                'route' => 'arquivos.index',
            ],
        ],
        'dev' => [
            [
                'name' =>  'Dev',
                'icon' =>  'ri-dashboard-line',
                'route' => 'arquivos.index',
            ],
        ],
        'vehicles' => [
            [
                'name' =>  'Veiculos',
                'icon' =>  'ri-truck-line',
                'route' => 'vehicles.index',
            ],
            [
                'name' =>  'Motorista',
                'icon' =>  'ri-shield-user-fill',
                'route' => 'vehicles.drivers',
            ],
            [
                'name' =>  'Portaria',
                'icon' =>  ' ri-profile-fill',
                'route' => 'vehicles.portaria',
            ],
            [
                'name' =>  'Celulares',
                'icon' =>  'fas fa-mobile-alt',
                'route' => 'celulares.index',
            ],
        ],
        'portaria' => [
            [
                'name' =>  'Veiculos',
                'icon' =>  'ri-truck-line',
                'route' => 'vehicles.index',
            ],
            [
                'name' =>  'Motorista',
                'icon' =>  'ri-shield-user-fill',
                'route' => 'vehicles.drivers',
            ],
            [
                'name' =>  'Portaria',
                'icon' =>  ' ri-profile-fill',
                'route' => 'vehicles.portaria',
            ],
        ],
        'notifications' => [
            [
                'back' => true,
                'name' =>  'Todas',
                'icon' =>  'ri-notification-2-line',
                'route' => 'notifications.index',
            ],
        ],
        'celulares' => [
            [
                'back' => true,
                'name' =>  'Todos',
                'icon' =>  'fas fa-mobile-alt',
                'route' => 'celulares.index',
            ],
        ],
        'tasks' => [
            [
                'name' =>  'Todas',
                'icon' =>  'ri-notification-2-line',
                'route' => 'tasks.index',
            ],
        ],
        'users' => [
            [
                'name' =>  'Usuários',
                'icon' =>  'fas fa-users',
                'route' => 'users.index',
            ],
            [
                'name' =>  'Funções',
                'icon' =>  'fas fa-user-tag',
                'route' => 'roles.index',
            ],
            [
                'name' =>  'Clientes',
                'icon' =>  'fas fa-user-tie',
                'route' => 'clients.index',
            ],
        ],
        'roles' => [
            [
                'name' =>  'Usuários',
                'icon' =>  'fas fa-users',
                'route' => 'users.index',
            ],
            [
                'name' =>  'Funções',
                'icon' =>  'fas fa-user-tag',
                'route' => 'roles.index',
            ],
            [
                'name' =>  'Clientes',
                'icon' =>  'fas fa-user-tie',
                'route' => 'clients.index',
            ],
        ],
        'rh' => [
            [
                'name' =>  'Funcionários',
                'icon' =>  'fas fa-user-edit',
                'route' => 'employees.index',
            ],
            [
                'name' =>  'Auditoria da Empresa',
                'icon' =>  'fas fa-window-restore',
                'route' => 'auditory.company',
            ],
            [
                'name' =>  'Relátorio',
                'icon' =>  'fas fa-bookmark',
                'route' => 'relatorios.employees',
            ],
        ]
    ],

    'colunas_faturamento' => [
        'Land Admin',
        'Land MO',
        'Materiais',
        'Terceiros',
    ],

    'celulares' => [
        '119130-95689',
        '119130-95705',
        '119130-95716',
        '119130-95807',
        '119130-95826',
        '119130-95877',
        '119130-95910',
        '119130-95977',
        '119130-96030',
        '119130-96045',
        '119130-96056',
        '119130-96068',
        '119130-96143',
        '119130-96154',
        '119401-42994',
        '119407-73809',
        '119407-73865',
        '119407-73959',
        '119407-73997',
        '119407-74034',
        '119407-74133',
        '119407-75712',
        '119407-75725',
        '119407-75869',
        '119407-75919',
        '119471-16273',
        '119471-20542',
        '119471-25507',
        '119478-72882',
        '119478-90057',
        '119638-35632',
        '119645-70458',
        '119659-77475',
        '119659-78933',
        '119708-51002',
        '119766-13734',
        '119766-13941',
        '119766-14006',
        '119766-37285',
        '119766-37439',
        '119766-38127',
        '119766-38623',
        '119766-39148',
        '119766-39657',
        '119766-53277',
        '119766-53496',
        '119766-53543',
        '119766-69880',
        '119766-71561',
        '119766-72799',
        '119766-73436',
        '119766-74490',
        '119766-76272',
        '119766-77770',
        '119766-77799',
        '119766-79469',
        '119766-79867',
        '119766-79981',
        '119837-69000',
        '119843-08000',
        '119868-87777',
        '119891-55306'
    ]
];
