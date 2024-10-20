<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branchs')->insert([
            [
                'name' => 'Gresik',
                'address' => 'Gresik',
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Bangil',
                'address' => 'Bangil',
                'is_active' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}
