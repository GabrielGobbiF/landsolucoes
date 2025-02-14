<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AtividadesExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithDrawings, WithCustomStartCell
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
            'DATA SERVIÇO',
            'SUPERVISOR',
            'VEICULO',
            'EQUIPE',
            'ENCARREGADO',
            'DIRETORIA',
            'ENDEREÇO',
            'OBRA',
            'SERVIÇO PROGRAMADO',
        ];
    }

   /**
     * Define a célula de início para que as linhas 1 e 2 fiquem reservadas ao cabeçalho customizado.
     */
    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // === Linha 1 ===
                // Mesclar de B1 até H1 e definir o título centralizado, com fonte 18 e negrito
                $sheet->mergeCells('B1:H1');
                $sheet->setCellValue('B1', 'PROGRAMAÇÃO DIÁRIA DE EQUIPE');
                $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('B1')->getFont()->setSize(18)->setBold(true);

                // === Linha 2 ===
                // Mesclar de A2 até H2 e definir o texto "Periodo:" centralizado
                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue('A2', 'Periodo:');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // Inserir a data de geração na célula I2, centralizada
                $sheet->setCellValue('I2', date('d/m/Y'));
                $sheet->getStyle('I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // === Estilização da collection (a partir da linha 3) ===
                // Define o fundo da linha de cabeçalho da collection (linha 3)
                $sheet->getStyle('A3:I3')->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFB8CCE4');

                // Centraliza horizontal e verticalmente todas as células a partir da linha 3 até a última linha
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A3:I{$lastRow}")->getAlignment()
                      ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                      ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Define a altura da primeira linha para pelo menos 58 pixels
        $sheet->getRowDimension(1)->setRowHeight(58);

        // Define o auto sizing para as colunas A até H
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Para a coluna I, manter uma largura mínima de 39 unidades (~272px)
        $sheet->getColumnDimension('I')->setWidth(39);

        return [];
    }

    public function drawings()
    {
        $drawings = [];

        // Imagem na célula A1 (Imagem da esquerda)
        $drawing1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing1->setName('Logo1');
        $drawing1->setDescription('Imagem da esquerda');
        $drawing1->setPath(public_path('panel/images/enel.png')); // Atualize para o caminho correto
        $drawing1->setHeight(50);
        $drawing1->setCoordinates('A1');
        // Ajustando offsets para centralizar a imagem dentro da célula (valores de exemplo)
        $drawing1->setOffsetX(10);
        $drawing1->setOffsetY(4);
        $drawings[] = $drawing1;

        // Imagem na célula I1 (Imagem da direita)
        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('Logo2');
        $drawing2->setDescription('Imagem da direita');
        $drawing2->setPath(public_path('panel/images/logo.png')); // Atualize para o caminho correto
        $drawing2->setHeight(50);
        $drawing2->setCoordinates('I1');
        // Ajustando offsets para centralizar a imagem dentro da célula (valores de exemplo)
        $drawing2->setOffsetX(10);
        $drawing2->setOffsetY(4);
        $drawings[] = $drawing2;

        return $drawings;
    }
}
