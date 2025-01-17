<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class AtividadesExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $atividades;

    // Construtor para receber os dados da controller
    public function __construct($atividades)
    {
        $this->atividades = $atividades;
    }

    /**
     * Retorna os dados passados pela controller.
     */
    public function collection()
    {
        // Transforma os dados recebidos em uma coleção
        return collect($this->atividades);
    }

    /**
     * Define os cabeçalhos do arquivo Excel.
     */
    public function headings(): array
    {
        return [
            'VEICULO',
            'EQUIPE',
            'ENCARREGADO',
            'DIRETORIA',
            'ENDEREÇO',
            'OBRA',
            'SERVIÇO PROGRAMADO',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:Z1'; // Cobrirá todas as colunas até a coluna 'Z'. Ajuste conforme necessário
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true); // Opção para deixar o cabeçalho em negrito
                $event->sheet->autoSize(); // Ajusta automaticamente a largura das colunas
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getDefaultRowDimension()->setRowHeight(-1); // Ajusta a altura da linha automaticamente
        $sheet->getStyle('A1:B' . $sheet->getHighestRow())
            ->getAlignment()->setWrapText(true); // Aplica a quebra de texto automática

        $sheet->getColumnDimension('B')->setWidth(25);

        $sheet->getStyle('A:A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        return [];
    }
}
