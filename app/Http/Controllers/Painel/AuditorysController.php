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

        $employee_auditory = DB::select('SELECT id,name,description,type FROM employees_auditory WHERE id = :id', [':id' => $id]);

        if (!$employee_auditory) {
            return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
        }

        $employees_auditory_month = DB::select('SELECT id,status,empAudMont.month,docs_link,updated_by,updated_at,date_accomplished,validity FROM employees_auditory_month empAudMont
        WHERE employees_auditory_id = :employees_id', [
            'employees_id' => $employee_auditory[0]->id,

        ]);

        if (!count($employees_auditory_month) > 0) {
            return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
        }

        foreach ($employees_auditory_month as $month) {

            $date1 = $month->month != '' ? date('Y-m', strtotime($month->month)) : date('Y-m', strtotime($month->date_accomplished));

            if ($date1 <= date('Y-m')) {
                $validade = '';

                if ($month->date_accomplished != '' && $month->validity != '') {
                    $data_realizada = $month->date_accomplished;

                    $dias_vigencia = $month->validity;

                    $validade = date('Y-m-d', strtotime("+{$dias_vigencia} days", strtotime($data_realizada)));
                }

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
                    'month' => $month->month != '' ? date('m/Y', strtotime($month->month)) : '',
                    'docs' => $month->docs_link != '' ? asset('storage/' . $month->docs_link) : false,
                    'status' => $month->status ? 'OK' : 'Pendente',
                    'docs_envio' => $doc,
                    'date_accomplished' => $month->date_accomplished != '' ? date('m/Y', strtotime($month->date_accomplished)) : '',
                    'validade' => $validade != '' ? date('m/Y', strtotime($validade)) : ''
                ];
            }
        }

        $employees_auditory_month = [
            'title' => $employee_auditory[0]->description,
            'name' => $employee_auditory[0]->name,
            'type' => $employee_auditory[0]->type,
            'payments' => $months
        ];

        return response()->json($employees_auditory_month);
    }

    /**
     * Adicionar uma autitoria em um usuario
     * Exemplo: curso RN6 no funcionar Gabriel
     * @param  \Illuminate\Http\Request  $request
     * @param   $employee_id
     * @return \Illuminate\Http\Response
     */

    public function storeAuditoryEmployee(Request $request, $employee_uuid)
    {
        $employee = $this->employees->where('uuid', $employee_uuid)->first();

        if (!$employee) {
            return redirect()
                ->route('employees')
                ->with('message', 'Registro não encontrado!');
        }

        $ids = $request->input('cursos');

        foreach ($ids as $curso_id) {

            $auditory_id = $curso_id;

            //$auditory = DB::select("SELECT * FROM auditory WHERE type = 'cursos' AND id = :auditory_id", [':auditory_id' => $auditory_id]);

            $auditory = (array) DB::table('auditory')
                ->select('*')
                ->where('type', '=', 'cursos')
                ->where('id', '=', $auditory_id)
                ->get()->first();

            $employees_auditory = $employee->auditory()->create($auditory);

            DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                'month' => '',
                'employees_auditory_id' => $employees_auditory->id,
            ]);
        }

        return redirect()
            ->back()
            ->with('message', 'Atualizado');
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

            $validity = '';

            if ($request->type_pasta == 'cursos') {

                $validity = $request->validity ?? '';

                $date_accomplished = $request->date_accomplished ? date('Y-m-d', strtotime(str_replace('/', '-', $request->date_accomplished))) : NULL;

                $dias_vigencia = $validity;

                $data_validade = date('Y-m-d', strtotime("+{$dias_vigencia} days", strtotime($date_accomplished)));
            }

            DB::update('UPDATE employees_auditory_month SET
                status = :status,
                updated_by = :updated_by,
                updated_at = :date_now,
                docs_link = :document_link,
                date_accomplished = :date_accomplished,
                validity = :validity
            WHERE id = :employees_auditory_month_id', [
                'status' => '1',
                'updated_by' => $user->id,
                'employees_auditory_month_id' => $request->employees_auditory_month_id,
                'date_now' => date('Y-m-d H:i:s'),
                'document_link' => $upload,
                'validity' => $validity,
                'date_accomplished' => $date_accomplished ?? date('Y-m-d')
            ]);

            $auditory_employee = DB::select('select employees_auditory_id from employees_auditory_month where id = ?', [$request->employees_auditory_month_id]);

            if ($request->type_pasta == 'cursos') {
                DB::insert('INSERT INTO employees_auditory_month (date_accomplished, employees_auditory_id) VALUES (:date_accomplished, :employees_auditory_id)', [
                    'date_accomplished' => $data_validade,
                    'employees_auditory_id' => $auditory_employee[0]->employees_auditory_id,
                ]);
            }

            if ($request->type_pasta != 'cursos') {

                $auditory_employee_month = DB::select('SELECT * FROM employees_auditory_month WHERE employees_auditory_id = ? ORDER BY id DESC LIMIT 1', [$auditory_employee[0]->employees_auditory_id]);

                $audit_employee= DB::select('SELECT doc_along_year FROM employees_auditory WHERE id = ? ', [$auditory_employee[0]->employees_auditory_id]);

                $date1 = date('Y-m', strtotime($auditory_employee_month[0]->month));

                if ($date1 > date('Y-m')) {
                } else {

                    $porMesOrYear = $audit_employee[0]->doc_along_year == 1 ? 'year' : 'months';

                    DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                        'month' => date('Y-m', strtotime($date1.' + 1 '.$porMesOrYear)),
                        'employees_auditory_id' => $auditory_employee[0]->employees_auditory_id,
                    ]);
                }
            }

            return redirect()
                ->back()
                ->with('message', 'Atualizado com sucesso');
        }

        return redirect()
            ->back()
            ->with('message', 'Nenhum arquivo selecionado');
    }

    public function storeAuditoryMonthEmployee()
    {

        return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
    }

    public function dispensaEmployee(){




    }
}
