<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmployee;
use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $employee = $this->repository->create($request->all());

        $documents_auditory = DB::select(
            "SELECT id,doc_applicable FROM documents_auditory"
        );

        foreach ($documents_auditory as $doc) {
            $auditory_id = $doc->id;
            $applicable = $doc->doc_applicable;

            DB::insert('INSERT INTO employees_auditory (auditory_id, employee_id, applicable) VALUES (:auditory_id, :employee_id, :applicable)', [
                'auditory_id' => $auditory_id,
                'employee_id' => $employee->id,
                'applicable' => $applicable,
            ]);
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
                INNER JOIN documents_auditory da ON (ea.auditory_id = da.id)
                WHERE ea.employee_id = :employee_id
            ",
            [
                'employee_id' => $id
            ]
        );

        $docs['entrevista'] = false;

        foreach ($documentos as $documento) {
            switch ($documento->type) {
                case 'entrevista':
                    $docs['documentos_entrevista'][] = $documento;
                    break;
                case 'contratacao':
                    $docs['documentos_contratacao'][] = $documento;
                    break;
                case 'acompanhamento':
                    $docs['documentos_acompanhamento'][] = $documento;
                    break;
                case 'documentos':
                    $docs['documentos_documentos'][] = $documento;
                    break;
                default:
                    $docs['documentos_all'][] = $documento;
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

            $upload = $request->file->storeAs("documentos/employees/{$employee_name}/{$request->type_pasta}", "{$docs_name}.pdf");

            if (empty($request->auditory_id)) {
                return redirect()
                    ->back()
                    ->with('message', 'Nenhum registro selecionado!');
            }

            $user = Auth::user();

            DB::update('UPDATE employees_auditory SET
                status = :status,
                update_by = :update_by,
                updated_at = :date_now,
                document_link = :document_link,
                applicable = 1
            WHERE id = :auditory_id', [
                'status' => '1',
                'update_by' => $user->id,
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
}
