<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama_lengkap' => 'asministrator',
            'username' => 'admin',
            'password' => 'password',
            'role' => 'admin',
            'status_aktif' => true,
        ]);
        User::create([
            'nama_lengkap' => 'petugas_parkir',
            'username' => 'petugas',
            'password' => 'password',
            'role' => 'petugas',
            'status_aktif' => true,

        ]);
        User::create([
             'nama_lengkap' => 'owner_parkir',
            'username' => 'owner',
            'password' => 'password',
            'role' => 'owner',
            'status_aktif' => true,
        ]);
    }
}
