<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Auditory;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuditorysController extends Controller
{
    protected $employees;

    public function __construct(Employee $employees)
    {
        $this->middleware('auth');

        $this->employees = $employees;

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
    }

    /**
     * Tela de documentos da Empresa
     */
    public function auditory_company()
    {
        $docs = [];

        $auditory = DB::select(
            "SELECT * FROM company_auditory"
        );

        foreach ($auditory as $documento) {

            $nome_usuario = '';
            $data_enviada = '';

            if ($documento->updated_by != '') {
                $usuario = User::where('id', $documento->updated_by)->first();
                $nome_usuario = $usuario->name;
                $data_enviada = date('d/m/Y H:i', strtotime($documento->updated_at));
            }

            $array_docs = (object) [
                'id' => $documento->id,
                'status' => $documento->status,
                'document_link' => $documento->document_link != '' ? asset('storage/' . $documento->document_link) : '',
                'name' => $documento->name,
                'description' => $documento->description,
                'user_envio' => $nome_usuario,
                'data_envio' => $data_enviada,
            ];

            $docs[] = $array_docs;
        }

        return view('pages.painel.rh.auditory_company.index', [
            'documentos' => $docs
        ]);
    }

    public function auditory_company_store(Request $request)
    {

        $name = $this->retiraAcentos($request->input('name'));

        $description = mb_strtoupper($request->input('name'), 'utf-8');

        DB::insert('INSERT INTO company_auditory (name, description, type) VALUES (:name, :description, :type)', [
            'name' => $name,
            'description' => $description,
            'type' => 'documentos'
        ]);

        return redirect()
            ->back()
            ->with('message', 'Inserido com sucesso');
    }

    public function auditory_company_update(Request $request)
    {
        if ($request->hasFile('file') && $request->file->isValid()) {

            try {

                $limit = ini_get('memory_limit');
                ini_set('memory_limit', -1);
                set_time_limit(300);

                if ($request->file->extension() != 'pdf') {
                    return redirect()
                        ->back()
                        ->with('message', 'Somente arquivos em PDF');
                }

                $company_name = 'landsolucoes';

                $docs_name = $request->document_name . '_' . uniqid(date('HisYmd'));

                $upload = $request->file->storeAs("documentos/empresa/{$company_name}", "{$docs_name}.pdf");

                if (empty($request->auditory_id)) {
                    return redirect()
                        ->back()
                        ->with('message', 'Nenhum registro selecionado!');
                }

                $user = Auth::user();

                DB::update('UPDATE company_auditory SET
                    status = :status,
                    updated_by = :updated_by,
                    updated_at = :date_now,
                    document_link = :document_link
                WHERE id = :auditory_id', [
                    'status' => '1',
                    'updated_by' => $user->id,
                    'auditory_id' => $request->auditory_id,
                    'date_now' => date('Y-m-d H:i:s'),
                    'document_link' => $upload,
                ]);

                ini_set('memory_limit', $limit);
                set_time_limit(30);

                return redirect()
                    ->back()
                    ->with('message', 'Atualizado com sucesso');
            } catch (\Throwable $th) {
                return redirect()
                    ->back()
                    ->with('error', 'Erro com o arquivo');
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Nenhum arquivo selecionado');
    }

    /**
     * Acompanhamento Mensal ou Anual
     */
    public function getParcelasAuditoryById($id)
    {
        $mes = date('Y-m');

        $employees_auditory_month = [];

        $months = [];

        $employee_auditory = DB::select('SELECT id,name,description,type FROM employees_auditory WHERE id = :id', [':id' => $id]);

        if (!$employee_auditory) {
            return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
        }

        $employees_auditory_month = DB::select('SELECT id,status,empAudMont.month,docs_link,updated_by,updated_at,date_accomplished,validity,epi_description FROM employees_auditory_month empAudMont
        WHERE employees_auditory_id = :employees_id', [
            'employees_id' => $employee_auditory[0]->id,
        ]);

        foreach ($employees_auditory_month as $month) {

            $date1 = $month->month != '' ? date('Y-m', strtotime($month->month)) : date('Y-m', strtotime($month->date_accomplished));

            if ($date1 <= date('Y-m') || $month->status == '1') {
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
                    $doc = 'Doc enviado por ' . $nome_usuario . ' em ' . $data_enviada;
                } else {
                    $doc = '';
                }

                if ($employee_auditory[0]->name == 'recibos_de_decimo_terceiro_salario') {
                    $month_date = $month->month != '' ? date('Y', strtotime($month->month)) : '';
                } else {
                    $month_date = $month->month != '' ? date('m/Y', strtotime($month->month)) : '';
                }

                $months[] = [
                    'id' => $month->id,
                    'month' => $month_date,
                    'docs' => $month->docs_link != '' ? asset('storage/' . $month->docs_link) : false,
                    'status' => $month->status ? 'OK' : 'Pendente',
                    'docs_envio' => $doc,
                    'date_accomplished' => $month->date_accomplished != '' ? date('m/Y', strtotime($month->date_accomplished)) : '',
                    'validade' => $validade != '' ? date('m/Y', strtotime($validade)) : '',
                    'epi_description' => $month->epi_description != '' ? $month->epi_description : ''
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
     * Adicionar uma autitoria (CURSO) em um usuario
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

            DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id, date_accomplished) VALUES (:month, :employees_auditory_id, :date_accomplished)', [
                'month' => '',
                'date_accomplished' => '',
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

            try {
                $limit = ini_get('memory_limit');
                ini_set('memory_limit', -1);
                set_time_limit(300);
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

                    if ($request->date_accomplished != '') {
                        if (strlen($request->date_accomplished) <= 7) {
                            $dataChange = str_replace('/', '-', '01/' . $request->date_accomplished);
                            $date_accomplished = Carbon::parse($dataChange)->format('Y-m-d');
                        } else {
                            $date_accomplished = $request->date_accomplished ? date('Y-m-d', strtotime(str_replace('/', '-', $request->date_accomplished))) : NULL;
                        }
                    } else {
                        $date_accomplished = '';
                    }

                    $dias_vigencia = $validity;

                    $data_validade = date('Y-m-d', strtotime("+{$dias_vigencia} days", strtotime($date_accomplished)));
                }

                DB::update('UPDATE employees_auditory_month SET
                    status = :status,
                    updated_by = :updated_by,
                    updated_at = :date_now,
                    docs_link = :document_link,
                    date_accomplished = :date_accomplished,
                    validity = :validity,
                    epi_description = :epi_description
                WHERE id = :employees_auditory_month_id', [
                    'status' => '1',
                    'updated_by' => $user->id,
                    'employees_auditory_month_id' => $request->employees_auditory_month_id,
                    'date_now' => date('Y-m-d H:i:s'),
                    'document_link' => $upload,
                    'validity' => $validity,
                    'date_accomplished' => $date_accomplished ?? date('Y-m-d'),
                    'epi_description' => $request->epi_description ?? ''
                ]);

                $auditory_employee = DB::select('select employees_auditory_id from employees_auditory_month where id = ?', [$request->employees_auditory_month_id]);

                if ($request->epi_description == '') {

                    if ($request->type_pasta == 'cursos') {
                        DB::insert('INSERT INTO employees_auditory_month (date_accomplished, employees_auditory_id) VALUES (:date_accomplished, :employees_auditory_id)', [
                            'date_accomplished' => $data_validade,
                            'employees_auditory_id' => $auditory_employee[0]->employees_auditory_id,
                        ]);
                    } else {

                        $auditory_employee_month = DB::select('SELECT * FROM employees_auditory_month WHERE employees_auditory_id = ? ORDER BY id DESC LIMIT 1', [$auditory_employee[0]->employees_auditory_id]);

                        $audit_employee = DB::select('SELECT doc_along_year FROM employees_auditory WHERE id = ? ', [$auditory_employee[0]->employees_auditory_id]);

                        $date1 = date('Y-m', strtotime($auditory_employee_month[0]->month));

                        if ($date1 > date('Y-m')) {
                        } else {

                            $porMesOrYear = $audit_employee[0]->doc_along_year == 1 ? 'year' : 'months';

                            DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                                'month' => date('Y-m', strtotime($date1 . ' + 1 ' . $porMesOrYear)),
                                'employees_auditory_id' => $auditory_employee[0]->employees_auditory_id,
                            ]);
                        }
                    }
                }

                ini_set('memory_limit', $limit);
                set_time_limit(30);

                return redirect()
                    ->back()
                    ->with('message', 'Atualizado com sucesso');
            } catch (\Throwable $th) {
                return redirect()
                    ->back()
                    ->with('error', 'Erro com o arquivo');
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Nenhum arquivo selecionado');
    }

    public function newEpiEmployee(Request $request)
    {
        $employee_auditory_id = $request->auditory_id;

        $auditory_employee_month = DB::select('SELECT * FROM employees_auditory_month WHERE employees_auditory_id = ? AND status = "0"', [$employee_auditory_id]);

        if (isset($auditory_employee_month) && count($auditory_employee_month) == 0) {
            $insert = DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                'month' => date('Y-m'),
                'employees_auditory_id' => $employee_auditory_id,
            ]);

            if (!$insert) {
                return response()->json(['error' => true, 'message' => 'não encontrado contate o administrador']);
            }
            return $this->getParcelasAuditoryById($employee_auditory_id);
        } else {
            return response()->json(['error' => true, 'message' => 'Existe Pendências']);
        }
    }

    public function auditory_company_delete($id)
    {
        $auditory_company = DB::select('SELECT id,name FROM company_auditory WHERE id = :id LIMIT 1', [':id' => $id]);

        if (!$auditory_company) {
            return redirect()
                ->route('auditory.company')
                ->with('message', 'Registro não encontrado!');
        }

        DB::delete('delete FROM company_auditory where id = :id', [':id' => $auditory_company[0]->id]);

        return redirect()
            ->route('auditory.company')
            ->with('message', 'Deletado com sucesso!');
    }

    //Alterar o documento caso, colocou o errado
    public function change_document_auditory(Request $request)
    {
        if ($request->hasFile('file') && $request->file->isValid()) {
            try {
                $limit = ini_get('memory_limit');
                ini_set('memory_limit', -1);
                set_time_limit(300);
                $id_user = Auth::user()->id;
                $id = $request->documento_id;
                $reason_change = $request->reason;
                $employee_id = $request->employee_id;

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

                $auditory_company = DB::select('SELECT * FROM employees_auditory WHERE id = :id LIMIT 1', [':id' => $id]);

                $employee_name = str_replace(' ', '_', mb_strtolower($employee->name, 'UTF-8'));

                $docs_name = $auditory_company[0]->name . '_' . uniqid(date('HisYmd'));

                $upload = $request->file->storeAs("documentos/employees/{$employee_name}/{$auditory_company[0]->name}", "{$docs_name}.pdf");

                if (!$auditory_company) {
                    return redirect()
                        ->route('employees')
                        ->with('message', 'Registro não encontrado!');
                }

                Storage::move($auditory_company[0]->document_link, "documentos/employees/{$employee_name}/trocados/{$docs_name}.pdf");

                DB::insert('INSERT INTO employees_auditory (name, description, type, option_name, doc_applicable, doc_along_month, doc_along_year, epi, employee_id, `status`, document_link, updated_by, `order`, updated_at)
                    VALUES (:name, :description, :type, :option_name, :doc_applicable, :doc_along_month, :doc_along_year, :epi, :employee_id, :status, :document_link, :id_user, :order, :updated_at)', [
                    'name' => $auditory_company[0]->name,
                    'description' => $auditory_company[0]->description,
                    'type' => $auditory_company[0]->type,
                    'option_name' => $auditory_company[0]->option_name,
                    'doc_applicable' => $auditory_company[0]->doc_applicable,
                    'doc_along_month' => $auditory_company[0]->doc_along_month,
                    'doc_along_year' => $auditory_company[0]->doc_along_year,
                    'epi' => $auditory_company[0]->epi,
                    'employee_id' => $auditory_company[0]->employee_id,
                    'status' => '1',
                    'document_link' => $upload,
                    'id_user' => $id_user,
                    'order' => $auditory_company[0]->order,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                DB::update('update employees_auditory set
                updated_by = :id_user,
                is_active = "1",
                reason_change = :reason_change
                where id = :id', [
                    ':id' => $id,
                    ':reason_change' => $reason_change,
                    ':id_user' => $id_user,
                ]);

                ini_set('memory_limit', $limit);
                set_time_limit(30);

                return redirect()
                    ->route('employees.show', $employee_id)
                    ->with('message', 'Atualizado com sucessso');
            } catch (\Throwable $th) {
                return redirect()
                    ->back()
                    ->with('error', 'Erro com o arquivo');
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Nenhum arquivo selecionado');
    }

    function retiraAcentos($string)
    {
        $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = strtr($string, utf8_decode($acentos), $sem_acentos);
        $string = str_replace(" ", "_", $string);
        $string = str_replace("(", "_", $string);
        $string = str_replace(")", "_", $string);
        $string = str_replace(",", "_", $string);

        $string = mb_strtolower($string, 'UTF-8');
        return utf8_decode($string);
    }

    public function removeCourse(Request $request, $auditory_id)
    {
        if (!$auditory_company = Auditory::find($auditory_id)) {
            return redirect()
                ->route('auditory.company')
                ->with('message', 'Registro não encontrado!');
        }

        $auditory_company->delete();

        return redirect()
            ->back()
            ->with('message', 'Curso removido com sucesso');

    }
}
