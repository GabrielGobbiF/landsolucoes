<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Spatie\Activitylog\Models\Activity;

class DeveloperController extends Controller
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
        return view('admin.dev.index', []);
    }

    public function clear_cache()
    {
        $command = [
            'optimize:clear',
            'cache:clear',
        ];

        try {
            foreach ($command as $c) {
                Artisan::call($c);
            }

            return redirect()
                ->back()
                ->with('message', 'Cache Limpado com sucesso');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
