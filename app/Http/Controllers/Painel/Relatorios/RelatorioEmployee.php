<?php

namespace App\Http\Controllers\Painel\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\Auditory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioEmployee extends Controller
{
    protected $repository;

    public function __construct(Employee $employees, Auditory $auditorys)
    {
        $this->employees = $employees;
        $this->auditorys = $auditorys;

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employees->all();

        $results = [];

        return view('pages.painel.rh.relatorios.index', compact('employees', 'results'));
    }

    public function search(Request $request)
    {
        $employees = $this->employees->all();

        $filters = $request->only('filter');

        $employees_results = $this->employees
            ->where(function ($query) use ($request) {
                if ($request->filter['funcionario']) {
                    $query->where('name', 'LIKE', '%' . $request->filter['funcionario'] . '%');
                }
                //if ($request->filter['pendencia']) {
                //    $query->where('employees_auditory.status', $request->filter['pendencia']);
                //}
                //if ($request->filter['tipo_auditoria']) {
                //    $query->where('employees_auditory.type', $request->filter['tipo_auditoria']);
                //}
            })
            ->latest()
            ->get();


        foreach ($employees_results as $employeesSearch) {

            $request = (object) [
                'employee_id' => $employeesSearch->id,
                'tipo_auditoria' => $filters['filter']['tipo_auditoria'],
            ];

            $results_auditorys = $this->auditorys
                ->where(function ($query) use ($request) {
                    $employees_id = $request->employee_id;
                    $query->where('employee_id', $employees_id);
                    $query->where('doc_applicable', '1');
                    $query->where('status', '0');
                    if ($request->tipo_auditoria) {
                        $query->where('type', $request->tipo_auditoria);
                    }
                })
                ->latest()
                ->get()->toArray();

            foreach ($results_auditorys as $documento) {
                if ($documento['doc_along_month'] == 1) {
                    $along_month = DB::select('SELECT * FROM employees_auditory_month
                    WHERE employees_auditory_id = :employees_auditory_id AND month <= :mes AND status = "0" ', [
                        'employees_auditory_id' => $documento['id'],
                        'mes' => date('Y-m')
                    ]);
                    if (count($along_month) == 0) {
                        $key = array_search($documento['name'], array_column($results_auditorys, 'name'));
                        if ($key !== false) {
                            unset($results_auditorys[$key]);
                        }
                    }
                }
            }

            //$results_auditorys = DB::select('SELECT * FROM employees_auditory
            //WHERE employee_id = :auditory_id ', [
            //    'auditory_id' => $employees_id,
            //]);

            $results[] = (object) [
                'name' => $employeesSearch->name,
                'uuid' => $employeesSearch->uuid,
                'auditory' => count($results_auditorys),
                'documentos' => (object) $results_auditorys
            ];
        }

        return view('pages.painel.rh.relatorios.index', compact('employees', 'filters', 'results'));
    }
}
