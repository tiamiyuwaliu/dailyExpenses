<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        if (!$user) {
            DB::table('users')->insert([
                'name' => 'Admin user',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'is_admin' => 1,
            ]);
        }
    }
}
