<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'keisha@gmail.com'],
            [
                'name' => 'Keisha Azzahra',
                'password' => Hash::make('password123'),
            ]
        );

        $adminRole = Role::where('nama_role', 'admin')->first();

        if ($adminRole && !$user->roles()->where('nama_role', 'admin')->exists()) {
            $user->roles()->attach($adminRole->id);
        }
    }
}