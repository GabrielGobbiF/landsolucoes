<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmployee;
use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeesController extends Controller
{
    protected $repository;

    public function __construct(Employees $employees)
    {
        $this->middleware('auth');

        $this->repository = $employees;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->repository->paginate();

        return view('pages.painel.rh.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.painel.rh.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateEmployee $request)
    {
        $columns = $request->all();

        if (!$request->cnh) {
            $columns['cnh'] = '0';
        }

        if ($request->date_contract) {
            $columns['date_contract'] = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_contract)));
        }

        $employee = $this->repository->create($columns);

        $auditory = DB::select(
            "SELECT id,doc_applicable,doc_along_month FROM auditory"
        );

        foreach ($auditory as $doc) {
            $auditory_id = $doc->id;
            $applicable = $doc->doc_applicable;
            $along_month = $doc->doc_along_month;

            DB::insert('INSERT INTO employees_auditory (auditory_id, employee_id, applicable, along_month) VALUES (:auditory_id, :employee_id, :applicable, :along_month)', [
                'auditory_id' => $auditory_id,
                'employee_id' => $employee->id,
                'applicable' => $applicable,
                'along_month' => $along_month
            ]);

            $employees_auditory_id = DB::getPdo()->lastInsertId();

            if ($along_month == true) {
                $this->gerarParcelasMes($employees_auditory_id, $request->date_contract);
            }
        }

        return redirect()
            ->route('employees')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $employee = $this->repository->where('uuid', $uuid)->first();

        if (!$employee) {
            return redirect()
                ->route('employees')
                ->with('message', 'Registro não encontrado!');
        }

        $documentos = $this->getDocumentAuditoryByEmployee($employee->id);

        $entrevista = $documentos['entrevista'] == true ?? false;

        return view('pages.painel.rh.employees.show', [
            'employee' => $employee,
            'documentos' => $documentos,
            'entrevista' => $entrevista
        ]);
    }

    /**
     * Pegar o array dos documentos auditoria
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDocumentAuditoryByEmployee($id)
    {
        $docs = [];

        $documentos = DB::select(
            "SELECT *, ea.id as employee_auditory_id FROM employees_auditory ea
                INNER JOIN auditory da ON (ea.auditory_id = da.id)
                WHERE ea.employee_id = :employee_id
            ",
            [
                'employee_id' => $id
            ]
        );

        $docs['entrevista'] = false;

        foreach ($documentos as $documento) {
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
                'applicable' => $documento->applicable,
                'along_month' => $documento->along_month,
                'document_link' => $documento->document_link != '' ? asset('storage/' . $documento->document_link) : '',
                'employee_auditory_id' => $documento->employee_auditory_id,
                'name' => $documento->name,
                'description' => $documento->description,
                'user_envio' => $nome_usuario,
                'data_envio' => $data_enviada,
                'option_name' => $documento->option_name
            ];

            switch ($documento->type) {
                case 'entrevista':
                    $docs['documentos_entrevista'][] = $array_docs;
                    break;
                case 'contratacao':
                    $docs['documentos_contratacao'][] = $array_docs;
                    break;
                case 'acompanhamento':
                    $docs['documentos_acompanhamento'][] = $array_docs;
                    break;
                case 'documentos':
                    $docs['documentos_docs'][] = $array_docs;
                    break;
                default:
                    $docs['documentos_all'][] = $array_docs;
                    break;
            }

            if ($documento->auditory_id == '46' && $documento->status === '1') {
                $docs['entrevista'] = true;
            }
        }
        return $docs;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateEmployee $request, $uuid)
    {
        $columns = $request->all();

        if (!$request->cnh) {
            $columns['cnh'] = '0';
        }

        if ($request->date_contract) {
            $columns['date_contract'] = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_contract)));
        }

        $employee = $this->repository->where('uuid', $uuid)->first();

        if (!$employee) {
            return redirect()
                ->route('employees')
                ->with('message', 'Registro não encontrado!');
        }

        $employee->update($columns);

        $documentos = $this->getDocumentAuditoryByEmployee($employee->id);

        $entrevista = $documentos['entrevista'] == true ?? false;

        return view('pages.painel.rh.employees.show', [
            'employee' => $employee,
            'documentos' => $documentos,
            'entrevista' => $entrevista
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $employee = $this->repository
            ->where('uuid', $uuid)
            ->first();

        if (!$employee) {
            return redirect()
                ->route('employees')
                ->with('message', 'Registro não encontrado!');
        }

        $employee->delete();

        return redirect()
            ->route('employees')
            ->with('message', 'Deletado com sucesso!');
    }

    public function auditoryUpdate(Request $request, $employee_id)
    {
        if ($request->hasFile('file') && $request->file->isValid()) {

            if ($request->file->extension() != 'pdf') {
                return redirect()
                    ->back()
                    ->with('message', 'Somente arquivos em PDF');
            }

            $employee = $this->repository->where('uuid', $employee_id)->first();

            if (!$employee) {
                return redirect()
                    ->route('employees')
                    ->with('message', 'Registro não encontrado!');
            }

            $employee_name = str_replace(' ', '_', mb_strtolower($employee->name, 'UTF-8'));

            $docs_name = $request->document_name . '_' . uniqid(date('HisYmd'));

            $upload = $request->file->storeAs("documentos/employees/{$employee_name}/{$request->type_pasta}", "{$docs_name}.pdf", "public");

            if (empty($request->auditory_id)) {
                return redirect()
                    ->back()
                    ->with('message', 'Nenhum registro selecionado!');
            }

            $user = Auth::user();

            DB::update('UPDATE employees_auditory SET
                status = :status,
                updated_by = :updated_by,
                updated_at = :date_now,
                document_link = :document_link,
                applicable = 1
            WHERE id = :auditory_id', [
                'status' => '1',
                'updated_by' => $user->id,
                'auditory_id' => $request->auditory_id,
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

    /**
     * atualizar o documento_auditory para ser aplicavel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response JSON
     */
    public function update_auditory_applicable(Request $request)
    {
        $update = DB::update('UPDATE employees_auditory SET
                applicable = :applicable
            WHERE id = :auditory_id', [
            'applicable' => 1,
            'auditory_id' => $request->auditory_id,
        ]);

        return response()->json($update);
    }
    public function gerarParcelasMes($employees_auditory_id, $data_contratacao)
    {
        $dataContratacao = explode('/', $data_contratacao);

        $mes = $dataContratacao[1];
        $ano = $dataContratacao[2];

        for ($x = 0; $x <= 50; $x++) {
            $dt_parcelas[$x] = date("Y-m", strtotime("+" . $x . " month", mktime(0, 0, 0, $mes, '25', $ano)));

            DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                'month' => $dt_parcelas[$x],
                'employees_auditory_id' => $employees_auditory_id,
            ]);
        }
    }
}
