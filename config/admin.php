<?php

return [
    'dataLayout' => 'horizontal',

    'menus' => [
        'l' => [
            [
                'name' =>  'Obras',
                'icon' =>  'ri-building-fill',
                'route' => 'obras',
            ],
            [
                'name' =>  'Arquivos',
                'icon' =>  'ri-dashboard-line',
                'route' => 'arquivos.index',
            ],
        ],
        'dev' => [
            [
                'name' =>  'Dev',
                'icon' =>  'ri-dashboard-line',
                'route' => 'arquivos.index',
            ],
        ]
    ]
];
