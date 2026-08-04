<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'デモユーザー',
                'email' => 'demo@example.com',
                'password' => bcrypt('pass1234'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
