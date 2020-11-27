<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class RolesController extends Controller
{
    protected $repository;

    public function __construct(Role $roles)
    {
        $this->middleware('auth');

        $this->middleware('role:admin');

        //$this->middleware('can:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);

        $this->repository = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->repository->all();

        return view('pages.painel.administrador.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.painel.administrador.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $roles = $this->repository->create($columns);

        return redirect()
            ->route('roles.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\roles  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$role = $this->repository->find($id)) {
            return redirect()
                ->route('roles.index')
                ->with('message', 'Registro não encontrado!');
        }


        $groupsPermissons = DB::select('SELECT `groups` FROM `permissions` group by `groups`');

        foreach ($groupsPermissons as $groups) {

            //$permissons = Permission::where('groups', $groups->groups)->get()->toArray();
//
            //foreach ($permissons as $rolePerm) {
            //    $role_permission = $rolePerm['name'];
            //}

            $all_groups[] = [
                'title' => $groups->groups,
                'permissions' => Permission::where('groups', $groups->groups)->get(['id','name'])->toArray()
            ];
        }

        $rolePermissions = $role->permissions()->get()->toArray();
        foreach ($rolePermissions as $rolePerm) {
            $role_permission[] = $rolePerm['name'];
        }

        //$all_permissions = Permission::all();

        return view('pages.painel.administrador.roles.show', [
            'role' => $role,
            'rolePermissions' => $role_permission??[],
            'all_groups' => $all_groups
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.painel.administrador.roles.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $columns = $request->all();

        $permissions = $request->only(['permissions']);

        if (!$role = $this->repository->find($id)) {
            return redirect()
                ->route('roles.index')
                ->with('message', 'Registro não encontrado!');
        }

        //$role->update($columns);

        foreach ($permissions as $permission) {
            $role->permissions()->sync($permission);
        }

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$role = $this->repository->find($id)) {
            return redirect()
                ->route('roles.index')
                ->with('message', 'Registro não encontrado!');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('message', 'Deletado com sucesso!');
    }

    /**
     * Search results
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $roles = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', $request->filter);
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('pages.painel.administrador.roles.index', compact('roles', 'filters'));
    }
}
