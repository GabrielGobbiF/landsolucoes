<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class ObraEtapasExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithCustomStartCell, WithColumnWidths
{
    // Construtor para receber os dados da controller
    public function __construct(private $etapas, private $obraInfo) {}

    /**
     * Retorna os dados passados pela controller.
     */
    public function collection()
    {
        $data = collect();

        $data->push(['', '', '', '', '']);

        foreach ($this->etapas as $etapa) {
            // Adiciona a linha com a etapa
            $data->push([
                '' => 'Etapa',
                'etapa' => $etapa->nome,
                'nome' => '', // Linha para a etapa principal
                'comentario' => '', // Linha para a etapa principal
                'data' => '',
            ]);

            // Adiciona os comentários como sublinhas
            foreach ($etapa->comments as $comentario) {
                $data->push([
                    'etapa' => '', // Deixa vazio para alinhar
                    'nome' => $comentario->user->username,
                    'comentario' => $comentario->obs_texto,
                    'data' => formatDateAndTime($comentario->created_at),
                ]);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            '',
            'Etapa',
            'Comentários',
            'Data',
        ];
    }

    public function startCell(): string
    {
        return 'A6'; // Começa as headings na célula A6, após as informações da obra
    }

    public function styles(Worksheet $sheet)
    {
        // Define as informações da obra na primeira linha e segunda coluna
        $sheet->setCellValue('A1', "Endereço:");
        $sheet->setCellValue('B1', $this->obraInfo['endereco']);
        $sheet->setCellValue('A2', "Cliente:");
        $sheet->setCellValue('B2', $this->obraInfo['cliente']);
        $sheet->setCellValue('A3', "Assessoria:");
        $sheet->setCellValue('B3', $this->obraInfo['assessor']);

        // Estiliza as informações da obra (negrito para os textos na coluna A)
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);

        // Obter a última linha
        $lastRow = $sheet->getHighestRow();

        // Aplica estilos condicionalmente em cada linha
        for ($row = 6; $row <= $lastRow; $row++) {
            $etapaCell = $sheet->getCell("B$row")->getValue();
            $comentarioCell = $sheet->getCell("C$row")->getValue();

            // Verifica se a linha é uma etapa
            if (!empty($etapaCell) && empty($comentarioCell)) {
                // Aplica estilo azul para o nome da etapa
                $sheet->getStyle("B$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('0000FF'));
                $sheet->getStyle("B$row")->getFont()->setBold(true);
            } elseif (empty($etapaCell) && !empty($comentarioCell)) {
                // Aplica estilo preto para comentários
                $sheet->getStyle("A$row:C$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('000000'));
            }
        }

        // Define negrito para a primeira coluna das etapas
        $sheet->getStyle('A')->getFont()->setBold(true);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Largura fixa para a primeira coluna
            'B' => 30, // Largura máxima para a coluna de etapas
            'C' => 50, // Largura máxima para comentários
            'D' => 20, // Largura para a coluna de data
        ];
    }
}
