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
                'name' =>  'Obras',
                'icon' =>  'ri-building-4-line',
                'route' => 'obras',
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
            'back' => true,
            [
                'name' =>  'Todas',
                'icon' =>  'ri-notification-2-line',
                'route' => 'notification',
            ],
        ]
    ]
];
