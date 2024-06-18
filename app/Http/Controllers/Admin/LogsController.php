<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogsController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $logs = Activity::with('causer')->orderBy('id', 'desc')->paginate();

        return view('admin.dev.logs.index', [
            'logs' => $logs
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string|int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        if (!$log = Activity::where('id', $id)->first()) {
            return redirect()
                ->route('admin.logs.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.dev.logs.show', [
            'log' => $log,
        ]);
    }
}
