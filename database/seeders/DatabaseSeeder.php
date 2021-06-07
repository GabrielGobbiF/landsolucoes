<?php

namespace Database\Seeders;

use App\Models\Concessionaria;
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
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        //Serviços
        $i = 0;
        foreach (Config::get('constants.services') as $service) {

            $verfiyDuplicate = Service::where('name', $service)->orderBy('id', 'DESC')->first();

            if ($verfiyDuplicate) {
                $slug = Str::slug(mb_strtolower($service . '_' . $i, 'UTF-8'), '_');
                $name = $service;
                DB::insert(
                    'insert into services (name, slug) values (?, ?)',
                    [$name, $slug]
                );
            } else {
                Service::create([
                    'name' => $service,
                ]);
            }
            $i++;
        }

        foreach (Config::get('constants.concessionarias') as $service) {
            Concessionaria::create([
                'name' => $service,
            ]);
        }

        foreach (Config::get('constants.tipos') as $service) {

            $name = mb_strtolower($service, 'UTF-8');

            Tipo::create([
                'name' => ucfirst($name),
            ]);
        }
    }
}
