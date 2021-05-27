<?php

return [
    'dataLayout' => 'horizontal',

    'menus' => [
        'l' => [
            [
                'name' =>  'Clientes',
                'icon' =>  'ri-user-shared-fill',
                'route' => 'clients.index',
            ],
            [
                'name' =>  'Obras',
                'icon' =>  'ri-building-fill',
                'route' => 'obras',
            ],
            [
                'name' =>  'Arquivos',
                'icon' =>  ' ri-file-list-3-line',
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
