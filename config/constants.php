<?php


/*
|--------------------------------------------------------------------------
|   Constants - PHP
|--------------------------------------------------------------------------
|
| Config::get('constants.options');
| Config::get('constants.options.option_attachment');
|
*/

return [
    'EM_ABERTO' => '0',
    'FINALIZADO' => '1',

    'DISPENSE' => [
        'Dispensa sem justa causa', 'Pedido de demissão', 'Dispensa por justa causa', 'Morte do empregado'
    ],

    'Dispensa sem justa causa' => [
        'Agendamento exame demissional',
        'Atestado demissional',
        'Aviso prévio',
        'TRCT / Termo de homologação',
        'Entrevista de desligamento',
        'Recibo de entregas de guias',
        'Comprovante de pagamento das verbas rescisórias',
        'Comprovante de pagamento multa 40%',
    ],

    'Pedido de demissão' => [
        'Agendamento exame demissional',
        'Atestado demissional',
        'Carta de próprio punho no caso de "pedido de demissão"',
        'TRCT / Termo de homologação',
        'Entrevista de desligamento',
        'Comprovante de pagamento das verbas rescisórias',
    ],

    'Dispensa por justa causa' => [
        'Agendamento exame demissional',
        'Atestado demissional',
        'TRCT / Termo de homologação',
        'Documentos comprobatórios da justa causa',
        'Comprovante de pagamento das verbas rescisórias',
    ],

    'Morte do empregado' => [
        'Certidão de óbito',
        'Certidão de dependentes habilitados no INSS',
        'TRCT / Termo de homologação',
        'Verificar se necessário ajuizar ação consignatória',
    ],


];
