<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmployee;
use App\Models\Employees;
use Illuminate\Http\Request;

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
        $this->repository->create($request->all());

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

        return view('pages.painel.rh.employees.show', [
            'employee' => $employee
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

        $employee = $this->repository->where('uuid', $uuid)->first();

        if (!$employee) {
            return redirect()
                ->route('employees')
                ->with('message', 'Registro não encontrado!');
        }

        $employee->update($columns);

        return view('pages.painel.rh.employees.show', [
            'employee' => $employee
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
}
