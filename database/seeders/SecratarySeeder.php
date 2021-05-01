<?php

namespace Database\Seeders;

use App\Models\Secrtary;
use Illuminate\Database\Seeder;

class SecratarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Secrtary::factory(10)->create();
    }
}
