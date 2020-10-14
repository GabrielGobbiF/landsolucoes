<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmployee;
use App\Models\Auditory;
use App\Models\Employee;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeesController extends Controller
{
    protected $repository;

    public function __construct(Employee $employees)
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

        $columns['salario'] = str_replace('.', '', $request->salario);
        $columns['salario'] = str_replace(',', '.', $columns['salario']);

        $employee = $this->repository->create($columns);

        $auditory = DB::select(
            "SELECT * FROM auditory WHERE type <> 'cursos'"
        );

        foreach ($auditory as $doc) {

            $docColumns = [
                'name' => $doc->name,
                'description' => $doc->description,
                'type' => $doc->type,
                'order' => $doc->order,
                'option_name' => $doc->option_name,
                'doc_applicable' => $doc->doc_applicable,
                'doc_along_month' => $doc->doc_along_month,
                'doc_along_year' => $doc->doc_along_year,
                'employee_id' => $employee->id,
            ];

            $employees_auditory = Auditory::create($docColumns);

            $employees_auditory_id = $employees_auditory->id;

            if ($doc->doc_along_month == true) {
                $this->gerarParcelasMes($employees_auditory_id, $request->date_contract, $doc->doc_along_year);
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

        $documentos = $employee->auditory()->get();

        $documentos = $this->getDocumentAuditoryByEmployee($documentos);

        $cursosInEmployee = DB::table('auditory')
            ->select('id', 'description')
            ->where('type', '=', 'cursos')
            ->whereNotIn('description', DB::table('employees_auditory')->select('description')->where('employee_id', '=', $employee->id))
            ->get()->toArray();

        $entrevista = $documentos['entrevista'] == true ?? false;

        return view('pages.painel.rh.employees.show', [
            'employee' => $employee,
            'documentos' => $documentos,
            'entrevista' => $entrevista,
            'cursosInEmployee' => $cursosInEmployee
        ]);
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
        $columns['updated_by'] = Auth::user()->id;

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

        $request->session()->flash('message', 'Atualizado com sucesso');

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
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

            $upload = $request->file->storeAs("documentos/employees/{$employee_name}/{$request->type_pasta}", "{$docs_name}.pdf");

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
                doc_applicable = 1
            WHERE id = :auditory_id', [
                'status' => '1',
                'updated_by' => $user->id,
                'auditory_id' => $request->auditory_id,
                'date_now' => date('Y-m-d H:i:s'),
                'document_link' => $upload,
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
                doc_applicable = :doc_applicable
            WHERE id = :auditory_id', [
            'doc_applicable' => 1,
            'auditory_id' => $request->id,
        ]);

        return response()->json($update);
    }
    public function gerarParcelasMes($employees_auditory_id, $data_contratacao, $year)
    {
        $dataContratacao = explode('/', $data_contratacao);
//
        $mes = $dataContratacao[1];
        $ano = $dataContratacao[2];

        $data_contratacao = date('Y-m-d', strtotime(str_replace('/', '-', $data_contratacao)));

        $data1 = new DateTime($data_contratacao);
        $data2 = new DateTime(date('Y-m-d'));

        $intervalo = $data1->diff($data2);

        if ($year == '0') {
            for ($x = 0; $x <= $intervalo->m; $x++) {
                $dt_parcelas[$x] = date("Y-m", strtotime("+" . $x . " month", mktime(0, 0, 0, $mes, '25', $ano)));

                DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                    'month' => $dt_parcelas[$x],
                    'employees_auditory_id' => $employees_auditory_id,
                ]);
            }
        } else {
            for ($x = 0; $x <= 5; $x++) {
                $dt_parcelas[$x] = date("Y-m", strtotime("+" . $x . " year", mktime(0, 0, 0, $mes, '25', $ano)));

                DB::insert('INSERT INTO employees_auditory_month (month, employees_auditory_id) VALUES (:month, :employees_auditory_id)', [
                    'month' => $dt_parcelas[$x],
                    'employees_auditory_id' => $employees_auditory_id,
                ]);
            }
        }
    }

    /**
     * Pegar o array dos documentos auditoria
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDocumentAuditoryByEmployee($documentos)
    {
        $docs = [];

        $docs['entrevista'] = false;

        foreach ($documentos as $documento) {

            $nome_usuario = '';
            $data_enviada = '';
            $data_vigencia_curso = '';

            if ($documento->updated_by != '') {
                $usuario = User::where('id', $documento->updated_by)->first();
                $nome_usuario = $usuario->name;
                $data_enviada = date('d/m/Y H:i', strtotime($documento->updated_at));
            }

            if ($documento->date_accomplished != '' && $documento->status === '1') {
                $data_vigencia_curso = $this->vigenciaCursoByEmployee($documento);
            }

            $array_docs = (object) [
                'id' => $documento->id,
                'status' => $documento->status,
                'applicable' => $documento->doc_applicable,
                'along_month' => $documento->doc_along_month,
                'document_link' => $documento->document_link != '' ? asset('storage/' . $documento->document_link) : '',
                'name' => $documento->name,
                'description' => $documento->description,
                'user_envio' => $nome_usuario,
                'data_envio' => $data_enviada,
                'option_name' => $documento->option_name,
                'data_vigencia_curso' => $data_vigencia_curso
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
                case 'cursos':
                    $docs['cursos'][] = $array_docs;
                    break;
                default:
                    $docs['documentos_all'][] = $array_docs;
                    break;
            }

            if ($documento->name == 'entrevista' && $documento->status === '1') {
                $docs['entrevista'] = true;
            }
        }
        return $docs;
    }

    public function vigenciaCursoByEmployee($documento)
    {
        $data_realizada = $documento['date_accomplished'];
        $dias_vigencia = $documento['validity'];

        return date('d/m/Y', strtotime("+{$dias_vigencia} days", strtotime($data_realizada)));
    }
}
