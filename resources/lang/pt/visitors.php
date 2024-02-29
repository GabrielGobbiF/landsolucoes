

<?php

use App\Support\Constants;
use App\Supports\Enums\Frota\VisitorsStatus;

return [
    'Visitantes',

    'statuses' => [
        VisitorsStatus::CREATED => 'Criado',
    ],

    'badge' => [],

    'notifications' => [],

    'alert' => [],

    'log' => [
        'badge' => [
            'created' => 'Criado',
        ],

        'label' => [
            'created' => 'success',
        ]
    ]

];
