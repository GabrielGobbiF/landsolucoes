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
        ],
        'compras' => [
            [
                'name' =>  'Fornecedores',
                'icon' =>  'fas fa-truck',
                'route' => 'fornecedor.index',
            ],
            [
                'name' =>  'Produtos',
                'icon' =>  'fas fa-truck-loading',
                'route' => 'produtos.index',
            ],
            [
                'name' =>  'Orçamentos',
                'icon' =>  'fas fa-clipboard',
                'route' => 'orcamento.index',
            ],
            [
                'name' =>  'Categorias',
                'icon' =>  'fas fa-cog',
                'route' => 'categories.index',
            ],
            //[
            //    'name' =>  'Linha de Atuação',
            //    'icon' =>  'fas fa-window-restore',
            //    'route' => 'auditory.company',
            //],
            //[
            //    'name' =>  'Contatos',
            //    'icon' =>  'fas fa-bookmark',
            //    'route' => 'relatorios.employees',
            //],
        ],
        'rdse' => [
            [
                'name' =>  'Modelos RDSE',
                'icon' =>  'fas fa-file-invoice',
                'route' => 'modelo-rdse.index',
            ],
            [
                'name' =>  'RDSE',
                'icon' =>  'fas fa-file-invoice',
                'route' => 'rdse.index',
            ],
            [
                'name' =>  'Mãos de Obra',
                'icon' =>  'fas fa-pallet',
                'route' => 'handswork.index',
            ],
        ]
    ],

    'colunas_faturamento' => [
        'Land Admin',
        'Land MO',
        'Materiais',
        'Terceiros',
    ],

    'atuacao' => [
        'Cabos',
        'Cimento',
        'Pré Moldado',
        'Conectores',
        'Barramento Blindado',
    ],

    'produtos' => [
        'categorias' => [
            'Elétrica',
            'Civil',
            'Locação',
            'Serviços',
        ],
        'sub_categorias' => [
            'Cabos',
            'Capacitores',
            'Cimento',
            'Pré Moldado',
            'Conectores',
            'Barramento Blindado',
        ]
    ],

    'celulares' => [
        'departamento' => [
            'ADM',
            'Cena Obras',
            'DIRETORIA',
            'ETD',
            'Nasai',
            'RDSC',
            'RDSE',
            'RH/DP',
            'Tec Segurança',
            'TMA',
        ]

    ],

    'rdse' => [
        'type' => [
            [
                'name' => 'Emergencial',
                'value' => '299.97',
                'codigo' => '4610003674'
            ],
            [
                'name' => 'LDS',
                'value' => '155.17',
                'codigo' => '4610003729'
            ],
            [
                'name' => 'Manutenção',
                'value' => '155.17',
                'codigo' => '4610003730'
            ],
            [
                'name' => 'Futurabilit',
                'value' => '422.86',
                'codigo' => '4610003673'
            ],
            [
                'name' => 'Civil',
                'value' => '1.00',
                'codigo' => '4610003675'
            ],
            [
                'name' => 'Atendimento ao cliente',
                'value' => '155.17',
                'codigo' => '4610003728'
            ],
        ]
    ]
];
