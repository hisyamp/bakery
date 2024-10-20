<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('log_types')->insert([
            [
                'name' => 'Finish Good',
                'created_at' => now(),
            ],
            [
                'name' => 'Waste',
                'created_at' => now(),
            ],
            [
                'name' => 'Sold',
                'created_at' => now(),
            ],
        ]);
    }
}
