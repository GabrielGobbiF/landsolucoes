<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    protected $repository;

    public function __construct(User $users)
    {
        $this->middleware('auth');

        $this->repository = $users;

        $this->middleware('role:admin');

        //$this->middleware(['can:view-users'], ['only' => ['index']]);
        //$this->middleware(['can:view-users', 'can:store-users'], ['only' => ['create', 'store']]);
        //$this->middleware(['can:view-users'], ['only' => ['show', 'update']]);
        //$this->middleware(['can:view-users', 'can:destroy-users'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->get();

        return view('pages.painel.administrador.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $roles = Role::get()->toArray();

        return view('pages.painel.administrador.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreUpdateUser $request)
    {
        $columns = $request->validated();

        $roles = $columns['roles'] ?? '';

        $user = $this->repository->create($columns);

        if (!empty($roles)) {
            $user->roles()->sync($roles);
        }

        return redirect()
            ->route('users.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Users  $id
     */
    public function show($uuid)
    {
        if (!$user = $this->repository->where('uuid', $uuid)->orWhere('id', $uuid)->first()) {
            return redirect()
                ->route('users.index')
                ->with('message', 'Registro não encontrado!');
        }

        $rolesUser = $user->roles()->get(['name'])->toArray();

        foreach ($rolesUser as $roleUser) {
            $roles_user[] = $roleUser['name'];
        }

        $roles = Role::get()->toArray();

        return view('pages.painel.administrador.users.show', [
            'user' => $user,
            'roles_user' => $roles_user ?? [],
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Users  $users
     */
    public function update(Request $request, $uuid)
    {
        if ($request->user()->hasRole('admin') || $request->user()->uuid == $uuid) {

            if (!$users = $this->repository->where('uuid', $uuid)->first()) {
                return redirect()
                    ->route('users.index')
                    ->with('message', 'Registro não encontrado!');
            }

            $columns = $request->all();

            $roles = $columns['roles'] ?? '';

            if (!empty($columns['password'])) {
                $columns['password'] = Hash::make($columns['password']);
            } else {
                unset($columns['password']);
            }

            //if (!isset($request->is_active)) {
            //    $columns['is_active'] = '1';
            //}

            if (!empty($roles)) {
                $users->roles()->sync($roles);
            }

            $users->update($columns);

            return redirect()
                ->back()
                ->with('message', 'Atualizado com sucesso');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Users  $users
     */
    public function destroy($uuid)
    {
        if (!$user = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('users.index')
                ->with('message', 'Registro não encontrado!');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('message', 'Deletado com sucesso!');
    }
}
