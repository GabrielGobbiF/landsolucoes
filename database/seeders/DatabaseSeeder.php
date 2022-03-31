<?php

namespace Database\Seeders;

use App\Models\RSDE\Handswork;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->handsWorks();
    }

    private function handsWorks()
    {
        $url = file_get_contents(database_path('seeders/jsons/mao_de_obra.json'));
        foreach (json_decode($url, true) as $handsworks) {
            Handswork::create($handsworks);
        }
    }
}
