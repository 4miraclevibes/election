<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('roles')->insert([
        //     ['name' => 'admin'],
        //     ['name' => 'user'],
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 1,
        // ]);

        DB::table('users')->insert([
            'name' => 'kholid hasibuan',
            'email' => 'kholid.hasibuan35@gmail.com',
            'password' => Hash::make('Anamkosong12'),
            'role_id' => 1,
        ]);

    }
}
