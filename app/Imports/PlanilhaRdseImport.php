<?php

namespace App\Imports;

use App\Models\RSDE\Rdse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PlanilhaRdseImport implements ToModel, SkipsEmptyRows, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Rdse([
            'description' => $row[6],
            'type' => 'Manutenção',
            'solicitante' => auth()->user()->name,
            'n_order' => $row[1],
            'month_date' => $this->excelDateToCarbon($row[9]),
            'diretoria' => 'HV',
            'tipo_obra' => $this->getTipoObra($row['10'])
        ]);
    }

    private function excelDateToCarbon($serialDate)
    {
        $baseDate = Carbon::createFromDate(1900, 1, 1);

        return $baseDate->addDays($serialDate - 2);
    }

    private function getTipoObra($tipo)
    {
        return match ($tipo) {
            'Coleta de Óleo Seletivo' => '42',
            'Coleta de Óleo Reticulado' => '35',
            'Coleta de Óleo Radial' => '41',
            'Coleta de Óleo em Pedestal' => '3',
            default => null
        };
    }
}
