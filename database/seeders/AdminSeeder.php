<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('SyakRidz02'),
        ]);
    }
}