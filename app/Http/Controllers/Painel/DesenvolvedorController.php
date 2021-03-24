<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DesenvolvedorController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('pages.painel.desenvolvedor.index');
    }

    public function alterNameAllEmployees(Request $request)
    {
        $nameDe = $request->input('de');
        $namePara = $request->input('para');
        $docs = DB::select("SELECT * FROM employees_auditory WHERE name = ? OR description = ?", [$nameDe, $nameDe]);

        if ($docs) {
            foreach ($docs as $doc) {

                $nameParaSlug = Str::slug(mb_strtolower($namePara, 'UTF-8'));
                $nameParaSlug = str_replace('-', '_', $nameParaSlug);

                DB::update('update employees_auditory set name = ?, description = ? where id = ?', [
                    $nameParaSlug,
                    $namePara,
                    $doc->id
                ]);
            }
            return redirect()->back()->with('message', 'Salvo');
        } else {
            return redirect()->back()->with('error', 'Não salvo');
        }
    }

    public function deleteAllEmployees(Request $request)
    {
        $name = $request->input('name');
        $docs = DB::select("SELECT * FROM employees_auditory WHERE name = ? OR description = ?", [$name, $name]);

        if ($docs) {
            foreach ($docs as $doc) {
                DB::delete('delete from employees_auditory where id = ?', [
                    $doc->id,
                ]);
            }
            return redirect()->back()->with('message', 'Salvo');
        } else {
            return redirect()->back()->with('error', 'Não salvo');
        }
    }

    public function deleteDocAuditory(Request $request)
    {
        $name = $request->input('name');
        $docs = DB::select("SELECT * FROM auditory WHERE name = ? OR description = ?", [$name, $name]);

        if ($docs) {
            foreach ($docs as $doc) {
                DB::delete('delete from auditory where id = ?', [
                    $doc->id,
                ]);
            }
            return redirect()->back()->with('message', 'Salvo');
        } else {
            return redirect()->back()->with('error', 'Não salvo');
        }
    }

    public function alterDocAuditory(Request $request)
    {
        $nameDe = $request->input('de');
        $namePara = $request->input('para');
        $docs = DB::select("SELECT * FROM auditory WHERE name = ? OR description = ?", [$nameDe, $nameDe]);

        if ($docs) {
            foreach ($docs as $doc) {

                $nameParaSlug = Str::slug(mb_strtolower($namePara, 'UTF-8'));
                $nameParaSlug = str_replace('-', '_', $nameParaSlug);

                DB::update('update auditory set name = ?, description = ? where id = ?', [
                    $nameParaSlug,
                    $namePara,
                    $doc->id
                ]);
            }
            return redirect()->back()->with('message', 'Salvo');
        } else {
            return redirect()->back()->with('error', 'Não salvo');
        }
    }
}
