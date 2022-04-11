<?php

namespace Database\Seeders;

use App\Models\RSDE\Handswork;
use App\Models\RSDE\Rdse;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->handsWorks();
        $this->rdses();
    }

    private function handsWorks()
    {
        $url = file_get_contents(database_path('seeders/jsons/mao_de_obra.json'));
        foreach (json_decode($url, true) as $handsworks) {
            Handswork::create($handsworks);
        }
    }

    private function rdses()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {

            Rdse::create([
                'description' => $faker->name
            ]);
        }
    }
}
