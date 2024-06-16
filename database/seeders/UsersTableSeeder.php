<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan user dengan role 'admin'
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        // Menambahkan user dengan role 'user'
        User::create([
            'name' => 'Approver',
            'email' => 'approver@gmail.com',
            'password' => bcrypt('approver'),
            'role' => 'approver',
        ]);

        // Menambahkan user dengan role 'manager'
        User::create([
            'name' => 'Hapiss',
            'email' => 'hapis@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);
    }
}
