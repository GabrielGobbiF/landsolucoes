<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function clientsAlterPassword()
    {

        $clients = Client::all();

        foreach ($clients as $client) {

            $client->password = Hash::make("cena_" . limpar($client->username, ''));
            $client->save();
            $client->update();

            if (Storage::disk('local')->exists('senhas_clientes.txt')) {
                Storage::disk('local')->append('senhas_clientes.txt', 'nome:' . $client->username . '   senha: ' . "cena_" . limpar($client->username, ''));
            } else {
                Storage::disk('local')->put('senhas_clientes.txt', 'nome:' . $client->username . '      senha: ' . "cena_" . limpar($client->username, ''));
            }
        }

        echo 'ok';
    }

    public function downloadEnel()
    {
        return view('pages.enel.download');
    }
}
