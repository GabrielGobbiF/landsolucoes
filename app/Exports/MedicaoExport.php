<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class MedicaoExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    protected $medicoes;

    public function __construct(Collection $medicoes)
    {
        $this->medicoes = $medicoes;
    }

    public function collection()
    {
        return $this->medicoes;
    }

    public function headings(): array
    {
        return [
            ['SAT\'R:', '', '', '', '', '', ''],
            ['Ficha de Medição', '', '', '', '', '', ''],
            ['Código', 'Descrição', 'Vlr UPS', 'Planej.', 'Tot. UPS ENEL', 'Tot. Aplic.', 'Tot. UPS',

            'Parcial 1 Quantidade',
            'Parcial 1 Valor',
            'Parcial 2 Quantidade',
            'Parcial 2 Valor',

            'Parcial 3 Quantidade',
            'Parcial 3 Valor'
            ]
        ];
    }

    public function map($medicao): array
    {
        return [
            $medicao->code,
            $medicao->description,
            $medicao->price_ups,
            '',
            '',
            $medicao->qnt_atividade,
            '',

            $medicao->p_quantidade1,
            $medicao->p_preco1,

            $medicao->p_quantidade2,
            $medicao->p_preco2,

            $medicao->p_quantidade3,
            $medicao->p_preco3,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para o cabeçalho
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
        ];
    }
}
