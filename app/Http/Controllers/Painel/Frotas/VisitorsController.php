<?php

namespace App\Http\Controllers\Painel\Frotas;

use App\Http\Requests\Frotas\StoreUpdateVisitors;
use App\Models\Visitor;
use App\Http\Controllers\Controller;
use App\Supports\Enums\Frota\VisitorsStatus;
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    public function __construct(protected Visitor $repository)
    {
    }

    public function all(Request $request)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $visitors = Visitor::all();

        return view('pages.painel.frotas.visitors.index', [
            'visitors' => $visitors
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function list()
    {
        $visitors = Visitor::orderby('id', 'desc')
            ->whereDate('visitor_at', today())
            ->get();

        return view('pages.painel.frotas.visitors.list', [
            'visitors' => $visitors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreUpdateVisitors $request)
    {
        $this->repository->create($request->validated());

        return redirect()
            ->route('visitors.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $identify
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(int $identify)
    {
        if (!$visitor = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('visitors.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.frotas.visitors.show', [
            'visitor' => $visitor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $identify
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update(StoreUpdateVisitors $request, int $identify)
    {
        $columns = $request->all();

        if (!$visitors = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('visitors.index')
                ->with('message', 'Registro não encontrado!');
        }

        $visitors->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!$visitors = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('visitors.index')
                ->with('message', 'Registro (Visitor) não encontrado!');
        }

        $visitors->delete();

        return redirect()
            ->route('visitors.index')
            ->with('message', 'Deletado com sucesso');
    }
}
