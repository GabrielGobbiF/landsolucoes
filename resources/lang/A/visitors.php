

<?php

use App\Support\Constants;
use App\Supports\Enums\Frota\VisitorsStatus;

return [
    'Visitantes',

    'badge' => [],

    'notifications' => [],

    'alert' => [],

    'log' => [
        'badge' => [
            'created' => 'Criado',
            'released' => 'Liberado',
            'closed' => 'Encerrado',
        ],

        'label' => [
            'created' => 'success',
            'released' => 'warning',
            'closed' => 'danger',
        ]
    ]

];
