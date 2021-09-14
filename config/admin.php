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
    ]
];
