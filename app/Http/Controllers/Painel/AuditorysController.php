<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditorysController extends Controller
{
    protected $employees;

    public function __construct(Employee $employees)
    {
        $this->middleware('auth');

        $this->employees = $employees;
    }

    public function getParcelasAuditoryById($id)
    {
        $mes = date('Y-m');

        $employees_auditory_month = [];

        $months = [];

        $employee_auditory = DB::select('SELECT id,name,description FROM employees_auditory WHERE id = :id', [':id' => $id]);

        if (!$employee_auditory) {
            return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
        }

        $employees_auditory_month = DB::select('SELECT id,status,empAudMont.month,docs_link,updated_by,updated_at FROM employees_auditory_month empAudMont
        WHERE employees_auditory_id = :employees_id AND empAudMont.month <= :mes', [
            'employees_id' => $employee_auditory[0]->id,
            'mes' => $mes,
        ]);

        if (!count($employees_auditory_month) > 0) {
            return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
        }

        foreach ($employees_auditory_month as $month) {

            if ($month->docs_link != '') {
                $usuario = User::where('id', $month->updated_by)->first();
                $nome_usuario = $usuario->name;
                $data_enviada = date('d/m/Y H:i', strtotime($month->updated_at));
                $doc = 'Documento enviado por ' . $nome_usuario . ' em ' . $data_enviada;
            } else {
                $doc = '';
            }

            $months[] = [
                'id' => $month->id,
                'month' => date('m/Y', strtotime($month->month)),
                'docs' => $month->docs_link != '' ? asset('storage/' . $month->docs_link) : false,
                'status' => $month->status ? 'OK' : 'Pendente',
                'docs_envio' => $doc
            ];
        }

        $employees_auditory_month = [
            'title' => $employee_auditory[0]->description,
            'name' => $employee_auditory[0]->name,
            'payments' => $months
        ];

        return response()->json($employees_auditory_month);
    }

    public function updateEmployeesAuditoryMonth(Request $request, $employee_id)
    {

        if ($request->hasFile('file') && $request->file->isValid()) {

            if ($request->file->extension() != 'pdf') {
                return redirect()
                    ->back()
                    ->with('message', 'Somente arquivos em PDF');
            }

            $employee = $this->employees->where('uuid', $employee_id)->first();

            if (!$employee) {
                return redirect()
                    ->route('employees')
                    ->with('message', 'Registro não encontrado!');
            }

            $employee_name = str_replace(' ', '_', mb_strtolower($employee->name, 'UTF-8'));

            $docs_name = $request->document_name . '_' . uniqid(date('HisYmd'));

            $data_doc = str_replace('/', '_', $request->data_month);

            $upload = $request->file->storeAs("documentos/employees/{$employee_name}/{$request->type_pasta}/{$request->document_name}/{$data_doc}", "{$docs_name}.pdf");

            if (empty($request->employees_auditory_month_id)) {
                return redirect()
                    ->back()
                    ->with('message', 'Nenhum registro selecionado!');
            }

            $user = Auth::user();

            DB::update('UPDATE employees_auditory_month SET
                status = :status,
                updated_by = :updated_by,
                updated_at = :date_now,
                docs_link = :document_link
            WHERE id = :employees_auditory_month_id', [
                'status' => '1',
                'updated_by' => $user->id,
                'employees_auditory_month_id' => $request->employees_auditory_month_id,
                'date_now' => date('Y-m-d H:i:s'),
                'document_link' => $upload
            ]);

            return redirect()
                ->back()
                ->with('message', 'Atualizado com sucesso');
        }

        return redirect()
            ->back()
            ->with('message', 'Nenhum arquivo selecionado');
    }


}
