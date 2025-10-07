<?php

return [
    'dataLayout' => 'horizontal',

    'menus' => [
        'l' => [

            [
                'name' =>  'Dashboard ',
                'icon' =>  'ri-dashboard-line',
                'route' => 'l.dashboard',
            ],

            [
                'name' =>  'Obras',
                'icon' =>  'ri-building-4-line',
                'route' => 'obras.index',
            ],

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
                'name' =>  'Financeiro',
                'atc' =>  'arquivos',
                'icon' =>  'ri-file-list-3-line',
                'route' => 'finances.index',
            ],
            //[
            //    'name' =>  'Arquivos',
            //    'atc' =>  'arquivos',
            //    'icon' =>  'ri-file-list-3-line',
            //    'route' => 'arquivos.index',
            //],
            [
                'name' =>  'Relatórios',
                'atc' =>  'arquivos',
                'icon' =>  'ri-file-edit-fill',
                'collapse' => 'true',
                'sub-menus' => [
                    [
                        'name' =>  'Etapas Vencidas',
                        'atc' =>  'arquivos',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'obras.etapas.vencidas',
                    ],
                ]
            ],
        ],
        'dev' => [
            [
                'name' =>  'Dev',
                'icon' =>  'ri-dashboard-line',
                'route' => 'dev.index',
            ],

            [
                'name' =>  'Arquivos',
                'icon' =>  'ri-dashboard-line',
                'route' => 'dev.uploadeds.index',
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
                'route' => 'drivers.index',
            ],
            [
                'name' =>  'Portaria',
                'atc' =>  'portaria',
                'icon' =>  'ri-profile-fill',
                'collapse' => 'true',
                'sub-menus' => [
                    [
                        'name' =>  'Lista',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'vehicles.portaria',
                    ],
                    [
                        'name' =>  'Liberação de Saída',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'vehicles.portaria.register',
                    ],
                ]
            ],
            [
                'name' =>  'Celulares',
                'icon' =>  'fas fa-mobile-alt',
                'route' => 'celulares.index',
            ],
            [
                'name' =>  'Visitantes',
                'atc' =>  'portaria',
                'icon' =>  'ri-profile-fill',
                'collapse' => 'true',
                'sub-menus' => [
                    [
                        'name' =>  'Todos',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'visitors.index',
                    ],
                    [
                        'name' =>  'Lista',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'visitors.list',
                    ],
                ]
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
                'route' => 'drivers.index',
            ],

            [
                'name' =>  'Portaria',
                'atc' =>  'portaria',
                'icon' =>  'ri-profile-fill',
                'collapse' => 'true',
                'sub-menus' => [
                    [
                        'name' =>  'Lista',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'vehicles.portaria',
                    ],
                    [
                        'name' =>  'Liberação de Saída',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'vehicles.portaria.register',
                    ],
                ]
            ],
            [
                'name' =>  'Visitantes',
                'atc' =>  'portaria',
                'icon' =>  'ri-profile-fill',
                'collapse' => 'true',
                'sub-menus' => [
                    [
                        'name' =>  'Todos',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'visitors.index',
                    ],
                    [
                        'name' =>  'Lista',
                        'atc' =>  'portaria',
                        'icon' =>  'ri-file-list-3-line',
                        'route' => 'visitors.list',
                    ],
                ]
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
                'name' =>  'Programação',
                'icon' =>  'fas fa-file',
                'route' => 'rdse.programacao.index',
            ],
            [
                'name' =>  'Mão de Obra',
                'icon' =>  'fas fa-pallet',
                'route' => 'handswork.index',
            ],


            [
                'name' =>  'Gestão',
                'atc' =>  'rdse',
                'icon' =>  'ri-file-edit-fill',
                'collapse' => 'true',
                'sub-menus' => [
                    [
                        'name' =>  'Equipes',
                        'icon' =>  'fas fa-pallet',
                        'route' => 'equipes.index',
                    ],

                    [
                        'name' =>  'Supervisores',
                        'icon' =>  'fas fa-pallet',
                        'route' => 'supervisores.index',
                    ],

                    [
                        'name' =>  'Encarregados',
                        'icon' =>  'fas fa-pallet',
                        'route' => 'encarregados.index',
                    ],

                    [
                        'name' =>  'Tipo de Obra',
                        'icon' =>  'fas fa-pallet',
                        'route' => 'tipos_obra.index',
                    ],

                    [
                        'name' =>  'Inventario',
                        'icon' =>  'fas fa-pallet',
                        'route' => 'inventories.index',
                    ],
                ]
            ],
            /*[
                'name' =>  'Arquivos',
                'icon' =>  'fas fa-file',
                'route' => 'rdse.files.index',
            ],*/

        ],
        'epi' => [
            [
                'name' =>  'EPI',
                'icon' =>  'fas fa-clipboard',
                'route' => 'epi.index',
            ],
            [
                'name' =>  'Arquivos',
                'icon' =>  'fas fa-file',
                'route' => 'epi.index',
            ],
        ],
        'etds' => [
            [
                'name' =>  'Etds',
                'icon' =>  'fas fa-clipboard',
                'route' => 'etd.index',
            ],
            [
                'name' =>  'Arquivos',
                'icon' =>  'fas fa-file',
                'route' => 'etd.files.index',
            ],
        ]
    ],

    'colunas_faturamento' => [
        'Land Admin',
        'Land MO',
        'Materiais',
        'Terceiros',
        'Distrato',
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
            'FRAUDE',
            'BT0',
            'COMGÁS',
            'PLPT (PIAUÍ)',
            'FROTA',
            'PORTARIA ',
            'ROÇADA',
            'CONSTRUÇÃO DE REDE',
        ]

    ],

    'rdse' => [
        'type' => [
            [
                'name' => 'Emergencial',
                'value' => '384.24',
                'codigo' => '4610003674'
            ],
            [
                'name' => 'LDS',
                'value' => '216.54',
                'codigo' => '4610003729'
            ],
            [
                'name' => 'Manutenção',
                'value' => '216.54',
                'codigo' => '4610003730'
            ],
            [
                'name' => 'Futurabilit',
                'value' => '216.54',
                'codigo' => '4610003673'
            ],
            [
                'name' => 'Civil',
                'value' => '216.54',
                'codigo' => '4610003675'
            ],
            [
                'name' => 'Atendimento ao cliente',
                'value' => '216.54',
                'codigo' => '4610003728'
            ],
        ]
    ],

    'departamentos_veiculos' => [
        'ADM',
        'CENA OBRAS',
        'TMA',
        'HV(ETD)',
        'RDSC',
        'RDSE',
        'DIVERSOS'
    ],

    'cnh_categories' => [
        [
            'name' => 'A',
            'value' => 'A',
        ],
        [
            'name' => 'B',
            'value' => 'B',
        ],
        [
            'name' => 'C',
            'value' => 'C',
        ],
        [
            'name' => 'D',
            'value' => 'D',
        ],
        [
            'name' => 'E',
            'value' => 'E',
        ],
        [
            'name' => 'A',
            'value' => 'A',
        ],
    ],

    'unidade' => [
        ["name" => "Barra (BR)", "is_active" => true],
        ["name" => "Quilograma (KG)", "is_active" => true],
        ["name" => "Unidade (UN)", "is_active" => true],
        ["name" => "Rolo (RL)", "is_active" => true],
        ["name" => "Saco (SC)", "is_active" => true],
        ["name" => "Metro Cúbico (M3)", "is_active" => true],
        ["name" => "Metro Quadrado (M2)", "is_active" => true],
        ["name" => "Material (MT)", "is_active" => true],
        ["name" => "Balde (LA)", "is_active" => true],
        ["name" => "Verba (VB)", "is_active" => true],
        ["name" => "Tonelada (T)", "is_active" => true],
        ["name" => "Quilograma (KILO)", "is_active" => true],
        ["name" => "Cento (CE)", "is_active" => true],
        ["name" => "Peça (PC)", "is_active" => true],
        ["name" => "Tambor (TB)", "is_active" => true],
        ["name" => "Caixa (CX)", "is_active" => true],
        ["name" => "Saco (SACO)", "is_active" => true],
        ["name" => "Metro (M)", "is_active" => true],
        ["name" => "Pacote (PCT)", "is_active" => true],
        ["name" => "Bloco (BL)", "is_active" => true],
        ["name" => "Quilate (CT)", "is_active" => true],
        ["name" => "Cartela (CTL)", "is_active" => true],
        ["name" => "Galão (GL)", "is_active" => true],
        ["name" => "Par (PAR)", "is_active" => true],
        ["name" => "Par (PR)", "is_active" => true],
        ["name" => "Conjunto (CJ)", "is_active" => true],
        ["name" => "Kit (KIT)", "is_active" => true],
        ["name" => "Kit (KI)", "is_active" => true],
        ["name" => "Máquina (MQ)", "is_active" => true],
        ["name" => "Jogo (JG)", "is_active" => true],
        ["name" => "Litro (LT)", "is_active" => true],
        ["name" => "Unidade (UNID)", "is_active" => true],
        ["name" => "Unidade (UND)", "is_active" => true],
        ["name" => "Litro (L)", "is_active" => true],
        ["name" => "Mililitro (ML)", "is_active" => true],
        ["name" => "Fardo (FD)", "is_active" => true],
    ],


    'gerentes_obras' => [
        '266',
        '267',
        '140',
        '142',
        '256',
        '269',
        '278'
    ]

];
