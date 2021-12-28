<?php

namespace Database\Seeders;

use App\Models\Celular;
use App\Models\Client;
use App\Models\Compras\Atuacao;
use App\Models\Compras\Category;
use App\Models\Compras\SubCategory;
use App\Models\Concessionaria;
use App\Models\Department;
use App\Models\Etapa;
use App\Models\Obra;
use App\Models\ObraEtapasFinanceiro;
use App\Models\Service;
use App\Models\Tipo;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * O Seed vai criar
     * Serviços
     * Concessionaria
     * @return void
     */
    public function run()
    {
        #$faker = Faker::create();

        #$this->clientes();
        #$this->servicos();
        #$this->concessionaria();
        #$this->tipos();
        #$this->departamento_cliente();
        #$this->departamento_concessionaria();
        #$this->obras();
        #$this->obras_financeiro();
        #$this->obras_etapas(5000);
        ##$this->obras_etapas(10000);
        ##$this->obras_etapas(15000);
        ##$this->obras_etapas(20000);
        ##$this->obras_etapas(25000);
        ##$this->obras_etapas(90000);
        #$this->obras_etapas_financeiro_faturamento();
        #DB::unprepared(file_get_contents(asset('storage/00tR9vps6D/jsons/etapas.sql')));
        #DB::unprepared(file_get_contents(asset('storage/00tR9vps6D/jsons/variables.sql')));
        #DB::unprepared(file_get_contents(asset('storage/00tR9vps6D/jsons/concessionaria_service.sql')));
        #DB::unprepared(file_get_contents(asset('storage/00tR9vps6D/jsons/con_service_etp.sql')));
        #
        $this->celulares();
        #$this->atuacao();
        #
        #$this->categories();
        #$this->Subcategories();
    }

    private function Subcategories()
    {
        foreach (config('admin.produtos.sub_categorias') as $categorie) {

            $slug = Str::slug(mb_strtolower($categorie, 'UTF-8'), '_');

            SubCategory::create([
                'name' => titleCase($categorie),
                'slug' => $slug,
            ]);
        }
    }

    private function categories()
    {
        foreach (config('admin.produtos.categorias') as $categorie) {

            $slug = Str::slug(mb_strtolower($categorie, 'UTF-8'), '_');

            Category::create([
                'name' => titleCase($categorie),
                'slug' => $slug,
            ]);
        }
    }

    private function atuacao()
    {

        foreach (config('admin.atuacao') as $atuacao) {

            $slug = Str::slug(mb_strtolower($atuacao, 'UTF-8'), '_');

            Atuacao::create([
                'nome' => titleCase($atuacao),
                'slug' => $slug,
            ]);
        }
    }

    private function celulares()
    {
        Celular::query()->delete();

        $url = file_get_contents(config_path('jsons/celulares.json'));
        $url = json_decode($url, true, 512, JSON_UNESCAPED_UNICODE);
        $columns = [];
        $configs = config('admin.celulares.departamento');

        foreach ($url as $ceulares) {


            $columns = [
                'linha' => limparTelefone($ceulares['LINHA']),
                'usuario' => $ceulares['USUARIO'],
                'responsavel' => $ceulares['RESPONSAVEL'],
                'departamento' => $ceulares['DEPARTAMENTO'],
            ];

            Celular::create($columns);
        }
    }

    private function obras_etapas_financeiro_faturamento()
    {
        //financeiro
        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/obras_etapas_financeiro.json'));
        $url = json_decode($url, true);
        $columns = [];
        foreach ($url as $etapaFaturamento) {
            $etp = ObraEtapasFinanceiro::find($etapaFaturamento['obr_etp_financerio_id']);

            if ($etp) {
                $columns = [
                    'id' => $etapaFaturamento['id'],
                    'coluna_faturamento' => $etapaFaturamento['coluna_faturamento'],
                    'nf_n' => $etapaFaturamento['nf_n'],
                    'data_emissao' => return_format_date($etapaFaturamento['data_emissao']),
                    'data_vencimento' => return_format_date($etapaFaturamento['data_vencimento']),
                    'valor' => $etapaFaturamento['valor'],
                    'recebido_status' => $etapaFaturamento['recebido_status'] == '1' ? 'Y' : 'N',
                    'status' => $etapaFaturamento['status'],
                    'obra_id' => $etapaFaturamento['obra_id'],
                ];

                $etp->faturamento()->create($columns);
            }
        }
    }

    private function obras_etapas($n)
    {
        //etapa
        $url = file_get_contents(asset("storage/00tR9vps6D/jsons/obras_etapas90000.json"));
        $url = json_decode($url, true);
        $columns = [];
        foreach ($url as $etapa) {
            $obra = Obra::find($etapa['id_obra']);
            $etapaFind = Etapa::find($etapa['id_etapa']);
            $state = 'P';

            if ($etapa['status'] == '5') {
                $state = 'P';
            }

            if ($etapa['status'] == '6') {
                $state = 'F';
            }

            if ($etapa['status'] == '7') {
                $state = 'AF';
            }

            if ($obra && $etapaFind) {
                $columns = [
                    'id' => $etapa['id'],
                    'id_obra' => $obra->id,
                    'id_etapa' => $etapaFind->id,
                    'tipo_id' => $etapaFind->tipo_id,
                    'nome' => $etapa['nome'],
                    'check' => $etapa['check'] == '1' ? 'C' : 'EM',
                    'status' => $state,
                    'ordem' => $etapa['ordem'] != null ? $etapa['ordem'] : 1,
                    'nota_numero' => $etapa['nota_numero'],
                    'responsavel' => $etapa['responsavel'],
                    'cliente_responsavel' => $etapa['cliente_responsavel'],
                    'preco' => $etapa['preco'],
                    'quantidade' => $etapa['quantidade'],
                    'unidade' => $etapa['unidade'],
                    'observacao' => $etapa['observacao'],
                    'observacao_sistema' => $etapa['observacao_sistema'],
                    'prazo_atendimento' => return_format_date($etapa['prazo_atendimento']),
                    'tempo_atividade' => $etapa['tempo_atividade'],
                    'data_abertura' => return_format_date($etapa['data_abertura']),
                    'data_programada' => return_format_date($etapa['data_programada']),
                    'data_iniciada' => return_format_date($etapa['data_iniciada']),
                    'data_prazo_total' => $etapa['data_prazo_total'] != '0000-00-00 00:00:00' ? return_format_date($etapa['data_prazo_total']) : NULL,
                    'meta_etapa' => return_format_date($etapa['meta_etapa']),
                    'data_pedido' => $etapa['data_pedido'],
                ];

                $obra->etapas()->create($columns);
            }
        }
    }

    private function obras_financeiro()
    {
        //financeiro
        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/obras_financeiro.json'));
        $url = json_decode($url, true);
        $columns = [];
        foreach ($url as $financeiro) {
            $obra = Obra::find($financeiro['id_obra']);

            if ($obra) {
                $columns = [
                    'id' => $financeiro['id'],
                    'id_obra' => $financeiro['id_obra'],
                    'valor_proposta' => $financeiro['valor_proposta'],
                    'valor_negociado' => $financeiro['valor_negociado'],
                    'valor_desconto' => $financeiro['valor_desconto'],
                    'valor_custo' => $financeiro['valor_custo'],
                    'metodo_pagamento' => 'transferência',
                    'envio_at' => return_format_date($financeiro['envio_at']),
                ];

                $obra->financeiro()->create($columns);
            }
        }
    }

    private function obras()
    {

        DB::unprepared(file_get_contents(asset('storage/00tR9vps6D/jsons/address.sql')));
        DB::unprepared(file_get_contents(asset('storage/00tR9vps6D/jsons/obras_viabilizations.sql')));

        //Obras
        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/obras.json'));
        $url = json_decode($url, true);
        $columns = [];
        foreach ($url as $obra) {

            //'elaboração', 'enviada', 'aprovada', 'recusada'
            switch ($obra['status']) {
                case '1':
                    $status = 'elaboração';
                    break;

                case '2':
                    $status = 'enviada';
                    break;

                case '3':
                    $status = 'aprovada';
                    break;

                case '4':
                    $status = 'recusada';
                    break;

                default:
                    $status = 'elaboração';
                    break;
            }

            switch ($obra['atv']) {
                case '0':
                    $deleted_at = NULL;
                    $status = 'concluida';
                    break;

                case '1':
                    $deleted_at = NULL;
                    break;

                case '2':
                    $deleted_at = date('Y-m-d H:i:s');
                    break;

                default:
                    $deleted_at = NULL;
                    break;
            }

            if ($obra) {
                $columns = [
                    'id' => $obra['id'],
                    'service_id' => $obra['service_id'],
                    'client_id' => $obra['client_id'],
                    'concessionaria_id' => $obra['concessionaria_id'],
                    'address_id' => $obra['address_id'] != '' && $obra['address_id'] != 0 ? $obra['address_id'] : NULL,
                    'viabilization_id' => $obra['viabilization_id'],
                    'department_id' =>  $obra['department_id'] != '' &&  $obra['department_id'] != 0 ?  $obra['department_id'] : NULL,
                    'razao_social' => (maiusculo($obra['razao_social'])),
                    'description' => $obra['description'],
                    'last_note' => $obra['last_note'],
                    'cnpj' => $obra['cnpj'],
                    'razao_social_obra_cliente' => (maiusculo($obra['razao_social_obra_cliente'])),
                    'obr_informacoes' => $obra['obr_informacoes'],
                    'status' => $status,
                    'obr_urgence' => $obra['obr_urgence'],
                    'build_at' => return_format_date($obra['build_at']),
                    'deleted_at' => $deleted_at,
                ];

                Obra::create($columns);
            }
        }
    }

    private function departamento_concessionaria()
    {
        //departamento_cliente
        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/departamento_concessionaria.json'));
        $url = json_decode($url, true);
        $columns = [];
        foreach ($url as $departamento) {
            $concessionaria = Concessionaria::find($departamento['departments_id']);

            if ($concessionaria) {
                $columns = [
                    'dep_responsavel' => titleCase(minusculo($departamento['dep_responsavel'])),
                    'dep_telefone_celular' => clear(limpar($departamento['dep_telefone_celular'], '')),
                    'dep_telefone_fixo' => clear(limpar($departamento['dep_telefone_fixo'], '')),
                    'dep_email' => str_replace(' ', '', (minusculo($departamento['dep_email']))),
                    'dep_funcao' => titleCase(minusculo($departamento['dep_funcao'])),
                ];

                $concessionaria->departments()->create($columns);
            }
        }
    }

    private function departamento_cliente()
    {
        //departamento_cliente
        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/departamento_clients.json'));
        $url = json_decode($url, true);
        $columns = [];
        foreach ($url as $departamento) {
            $client = Client::find($departamento['departments_id']);

            if ($client) {
                $columns = [
                    'id' => $departamento['id'],
                    'dep_responsavel' => titleCase(minusculo($departamento['dep_responsavel'])),
                    'dep_telefone_celular' => clear(limpar($departamento['dep_telefone_celular'], '')),
                    'dep_telefone_fixo' => clear(limpar($departamento['dep_telefone_fixo'], '')),
                    'dep_email' => str_replace(' ', '', (minusculo($departamento['dep_email']))),
                    'dep_funcao' => titleCase(minusculo($departamento['dep_funcao'])),
                ];

                $client->departments()->create($columns);
            }
        }
    }

    private function clientes()
    {
        //clientes
        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/clients.json'));
        $url = json_decode($url, true);
        foreach ($url as $client) {
            Client::create($client);
        }
    }

    private function servicos()
    {

        $url = file_get_contents(asset('storage/00tR9vps6D/jsons/services.json'));
        $url = json_decode($url, true);

        $i = 0;
        foreach ($url as $service) {

            $verfiyDuplicate = Service::where('name', $service['name'])->orderBy('id', 'DESC')->first();
            $name = $service['name'];
            $id = $service['id'];
            if ($verfiyDuplicate) {
                $slug = Str::slug(mb_strtolower($service['name'] . '_' . $i, 'UTF-8'), '_');
                DB::insert(
                    'insert into services (id, name, slug) values (?,?,?)',
                    [$id, $name, $slug]
                );
            } else {
                $slug = Str::slug(mb_strtolower($service['name'], 'UTF-8'), '_');
                DB::insert(
                    'insert into services (id, name, slug) values (?,?,?)',
                    [$id, $name, $slug]
                );
            }
            $i++;
        }
    }

    private function concessionaria()
    {
        $i = 1;
        foreach (Config::get('constants.concessionarias') as $service) {
            $id = $i;
            if ($service == 'ENEL - Redes Subterrânea Civil') {
                $id = '9';
            }
            if ($service == 'ENEL - ETDs') {
                $id = '10';
            }
            Concessionaria::create([
                'name' => $service,
                'id' => $id
            ]);
            $i++;
        }
    }

    private function tipos()
    {
        foreach (Config::get('constants.tipos') as $service) {

            $name = mb_strtolower($service, 'UTF-8');

            Tipo::create([
                'name' => ucfirst($name),
            ]);
        }
    }
}
