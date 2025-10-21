<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'テストユーザー',
                'name_kana' => 'テストユーザー',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'grade_id' => 1,
                'profile_image' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}