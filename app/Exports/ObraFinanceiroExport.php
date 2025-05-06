<?php

namespace App\Exports;

use App\Models\Obra;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithMapping,
    WithHeadings,
    WithEvents,
    WithStyles,
    WithDrawings,
    WithStartCell,
    ShouldAutoSize,
    Exportable
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ObraFinanceiroExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    WithEvents,
    WithStyles,
    WithDrawings,
    WithCustomStartCell,
    ShouldAutoSize
{
    use Exportable;

    protected $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }

    /**
     * 1) Busca as obras aplicando seus filtros (incluindo só as com total_a_faturar > 0, se for o caso).
     */
    public function collection()
    {
        return Obra::query()
            ->when(
                !empty($this->filter['obr_name']),
                fn($q) =>
                $q->where('razao_social', 'LIKE', '%' . $this->filter['obr_name'] . '%')
            )
            ->when(
                !empty($this->filter['clients']),
                fn($q) =>
                $q->where('client_id', $this->filter['clients'])
            )
            ->when(
                !empty($this->filter['faturar']),
                function ($q) {
                    $q->whereHas('financeiro', function ($qf) {
                        $qf->where('total_a_faturar', '>', 0);
                    });
                }
            )

            ->when(
                !empty($this->filter['receber']),
                function ($q) {
                    $q->whereHas('financeiro', function ($qf) {
                        $qf->where('a_receber', '>', 0);
                    });
                }
            )

            ->when(
                !empty($this->filter['vencimento']),
                function ($q) {
                    $q->whereHas('financeiro', function ($qf) {
                        $qf->where('vencidas', '>', 0);
                    });
                }
            )
            ->whereNull('remove_finance')
            ->whereIn('status', ['aprovada'])
            ->where('status', '<>', 'concluida')
            ->with(['financeiro', 'client'])
            ->get();
    }

    /**
     * 2) Cabeçalhos na linha 3, antes dos dados começarem na linha 4.
     */
    public function headings(): array
    {
        return [
            'Observação',      // col A
            'Obra',            // col B
            'Cliente',         // col C
            'Negociado',       // col D
            'A Receber',       // col E
            'Recebido',        // col F
            'Faturado',        // col G
            'Total a Faturar', // col H
            'Vencidas',        // col I
            'Saldo',           // col J
        ];
    }

    /**
     * 3) Como transformar cada Obra num array de valores/datas.
     */
    public function map($obra): array
    {
        return [
            $obra->last_note,
            $obra->razao_social,
            $obra->client->company_name,
            $obra->financeiro->valor_negociado,
            $obra->financeiro->a_receber,
            $obra->financeiro->recebido,
            $obra->financeiro->faturado,
            $obra->financeiro->total_a_faturar,
            $obra->financeiro->vencidas,
            $obra->financeiro->saldo,
        ];
    }

    /**
     * 4) Define que o cabeçalho começa em A3.
     */
    public function startCell(): string
    {
        return 'A3';
    }

    /**
     * 5) Eventos para estilização, título, período e linha de totais.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();

                // --- TÍTULO PRINCIPAL (linha 1) ---
                $sheet->mergeCells('B1:O1');
                $sheet->setCellValue('B1', 'RELATÓRIO FINANCEIRO');
                $sheet->getStyle('B1')->getFont()->setSize(18)->setBold(true);
                $sheet->getStyle('B1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // --- PERÍODO (linha 2) ---
                $sheet->mergeCells('A2:H2');
                if (
                    !empty($this->filter['date_start_formatted'] ?? null)
                    && !empty($this->filter['date_end_formatted'] ?? null)
                ) {
                    $sheet->setCellValue('A2', 'Período:');
                    $sheet->mergeCells('I2:P2');
                    $sheet->setCellValue(
                        'I2',
                        $this->filter['date_start_formatted']
                            . ' a ' .
                            $this->filter['date_end_formatted']
                    );
                } else {
                    $sheet->setCellValue('A2', 'Data de Geração:');
                    $sheet->mergeCells('I2:P2');
                    $sheet->setCellValue('I2', Carbon::now()
                        ->format('d/m/Y H:i:s'));
                }
                $sheet->getStyle('A2:I2')->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // --- ESTILO DO CABEÇALHO (linha 3) ---
                $sheet->getStyle('A3:J3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFB8CCE4');
                $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // --- LINHA DE TOTAIS ---
                $lastRow = $sheet->getHighestRow();      // último dado está em $lastRow
                $totalsRow = $lastRow + 1;               // escrever totais aqui

                // Rótulo "Total:" na coluna A
                $sheet->setCellValue("A{$totalsRow}", 'Total:');
                $sheet->getStyle("A{$totalsRow}")->getFont()->setBold(true);

                // Fórmulas de soma para cada coluna de D até J
                foreach (['D', 'E', 'F', 'G', 'H', 'I', 'J'] as $col) {
                    $sheet->setCellValue(
                        "{$col}{$totalsRow}",
                        "=SUM({$col}4:{$col}{$lastRow})"
                    );
                    $sheet->getStyle("{$col}{$totalsRow}")
                        ->getFont()->setBold(true);
                }

                // Centraliza totais
                $sheet->getStyle("A{$totalsRow}:J{$totalsRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    /**
     * 6) Altura da linha 1 e auto-size para todas as colunas A–J.
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(58);
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        return [];
    }

    /**
     * 7) Logo na célula A1.
     */
    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo')
            ->setPath(public_path('panel/images/logo3a.png'))
            ->setHeight(50)
            ->setCoordinates('A1')
            ->setOffsetX(10)
            ->setOffsetY(4);
        return [$drawing];
    }
}
