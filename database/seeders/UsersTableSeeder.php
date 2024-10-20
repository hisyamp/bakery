<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Syarif',
                'username' => 'syarif',
                'email' => 'syarif@gmail.com',
                'role_id' => 1,
                'password' => Hash::make('ourbakery'),  // Hashed password
                'branch_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Nanda',
                'username' => 'nanda',
                'email' => 'nanda@gmail.com',
                'role_id' => 1,
                'password' => Hash::make('ourbakery'),
                'branch_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Hanif',
                'username' => 'hanif',
                'email' => 'hanif@gmail.com',
                'role_id' => 1,
                'password' => Hash::make('ourbakery'),
                'branch_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Sutimin',
                'username' => 'sutimin',
                'email' => 'sutimin@gmail.com',
                'role_id' => 2,
                'password' => Hash::make('ourbakery'),
                'branch_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}
