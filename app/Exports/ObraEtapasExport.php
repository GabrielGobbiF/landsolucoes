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

            $etapaNome = $etapa->nome;
            if ($etapa->check == 'C') {
                $etapaNome .= ' - concluída';
            }

            $data->push([
                '' => 'Etapa',
                'etapa' => $etapaNome,
                'nome' => '',
                'comentario' => '',
                'data' => '',
            ]);

            if (!empty($etapa->nota_numero)) {
                $data->push([
                    'etapa' => '',
                    'nome' => "Nº Nota: {$etapa->nota_numero}",
                ]);
            }

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
        return 'A7'; // Começa as headings na célula A6, após as informações da obra
    }

    public function styles(Worksheet $sheet)
    {
        // Define as informações da obra na primeira linha e segunda coluna

        $sheet->setCellValue('A1', "Nome da Obra:");
        $sheet->setCellValue('B1', $this->obraInfo['nome']);
        $sheet->setCellValue('C1', 'ID: ' . $this->obraInfo['id']);

        $sheet->setCellValue('A2', "Endereço:");
        $sheet->setCellValue('B2', $this->obraInfo['endereco']);
        $sheet->setCellValue('A3', "Cliente:");
        $sheet->setCellValue('B3', $this->obraInfo['cliente']);
        $sheet->setCellValue('A4', "Assessoria:");
        $sheet->setCellValue('B4', $this->obraInfo['assessor']);

        // Estiliza as informações da obra (negrito para os textos na coluna A)
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);

        // Obter a última linha
        $lastRow = $sheet->getHighestRow();

        // Aplica estilos condicionalmente em cada linha
        for ($row = 6; $row <= $lastRow; $row++) {
            $etapaCell = $sheet->getCell("B$row")->getValue();
            $comentarioCell = $sheet->getCell("C$row")->getValue();

            if (!empty($etapaCell) && empty($comentarioCell)) {

                if (str_contains($etapaCell, ' - concluída')) {

                   #// Separa o nome da etapa e a palavra "concluída"
                   #$etapaParts = explode(' - ', $etapaCell);
                   #$etapaNome = $etapaParts[0];
                   #$concluidaTexto = ' - ' . $etapaParts[1];

                   #// Cria um RichText para estilizar partes da célula
                   #$richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

                   #// Adiciona o nome da etapa sem estilo especial
                   #$richText->createText($etapaNome);

                   #// Adiciona a palavra "concluída" com estilo verde
                   #$concluidaRichText = $richText->createTextRun($concluidaTexto);
                   #$concluidaRichText->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('008000')); // Verde
                   #$concluidaRichText->getFont()->setBold(true);

                   #// Define o RichText na célula
                   #$sheet->getCell("B$row")->setValue($richText);

                    $sheet->getStyle("B$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('008000')); // Verde
                } else if (str_contains($etapaCell, 'Nº Nota')) {
                    $sheet->getStyle("B$row")->getFont()->setBold(true);
                    $sheet->getStyle("B$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('ff3d60'));
                }else {
                    $sheet->getStyle("B$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('0000FF'));

                }

                $sheet->getStyle("B$row")->getFont()->setBold(true);
            } elseif (empty($etapaCell) && !empty($comentarioCell)) {

                if (str_contains($etapaCell, 'Nº Nota')) {
                    $sheet->getStyle("B$row")->getFont()->setBold(true);
                    $sheet->getStyle("B$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('ff3d60'));

                }else {
                    $sheet->getStyle("A$row:C$row")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('000000'));

                }



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
