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

    'services' => [
        'Câmara Transformadora',
        'Cubículo Blindado Simplificado',
        'Barramento Blindado',
        'Centro de Medição com QDC',
        'Centro de Medição',
        'Padrão BT medição direta',
        'Padrão BT medição indireta',
        'Aumento de Carga',
        'Migração de Tensão',
        'Servidão de passagem',
        'Base Pedestal',
        'Rede Aérea 15kV',
        'Rede Subterrânea 15kV',
        'Rede Aérea 15kV + Padrões BT Indireta',
        'Obras Internas',
        'Projeto Civil Câmara Transformadora',
        'Projeto Civil Pedestal',
        'Projeto Executivo Cubiculo Simplificado',
        'Projeto Executivo Cubiculo Convencional',
        'Projeto Executivo Padrão BT Indireta',
        'Projeto Rede Aérea 15 kV',
        'Projeto Rede Subterränea 15 kV',
        'Ramal de Entrada com Coluna',
        'Assessoria Concessionária',
        'Cadastro Uso de Gerador em Rampa',
        'Remoção Posto Primário',
        'Iluminação Publica LED',
        'Aumento de Demanda',
        'Cubículo Blindado Convencional',
        'Base Pedestal',
        'Base Pedestal - Civil - Elétrica',
        'REMOÇÃO OU MOVIMENTAÇÃO DE POSTE',
        'Câmara Transformadora - Civil - Elétrica',
        'PADRÃO MT EM POSTE',
        'Base Pedestal Elétrica',
        'Camara Transformadora Elétrica',
        'Parametrização de Relê',
        'teste duplicação',
        'Câmara Transformadora',
        'Câmara Transformadora',
        'Câmara Transformadora em teste',
        'Parametrização de Relê em teste',
        'Câmara Transformadora Elétrica',
        'Rede Aérea 15kV',
        'Pedido de Viabilidade',
        'Malha de Aterramento',
        'Instalação de PI com Lateral e Linha de Duto',
        'Cubículo Blindado Simplificado',
        'Instalação de PI com Lateral e Linha de dutos',
        'Travessia Via Publica',
        'Nivelamento de Tampão de PI e CT',
        'Condomínio Rede Mista Aérea e SUB',
        'Construção de linhas de dutos 16, 12, 8, 6, 4 e 2.',
        'Construção de linha de 16 dutos 200mm',
        'Entrada Em Média Tensão Estaleiro',
        'Bifásico para Trifásico',
        'Caixas Separadoras e Bacias Coletoras',
        'Projeto Servidão de Passagem e Aprovação',
    ],

    'concessionarias' => [
        'ENEL Distribuidora',
        'EDP Bandeirantes',
        'CPFL ENERGIA',
        'ELEKTRO',
        'ENEL - Redes Subterrânea Civil',
        'ENEL - ETDs',
    ],

    'tipos' => [
        'CONCESSIONARIA',
        'ADMINISTRATIVA',
        'OBRA',
        'COMPRA',
        'VISTORIA',
    ]
];
