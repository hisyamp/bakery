<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => 'Ular Ijo',
                'category' => 'Sweet',
                'is_active' => 1,
                'branch_id' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Cheese Boot',
                'category' => 'Sweet',
                'is_active' => 1,
                'branch_id' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Pizza',
                'category' => 'Sweet',
                'is_active' => 1,
                'branch_id' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}
