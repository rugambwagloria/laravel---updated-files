<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admins = [
            ['Fname' => 'Gloria', 'Lname' => 'Rugambwa', 'email' => 'grugambwa21@gmail.com', 'password' => 'rugambwa@2002'],
            ['Fname' => 'Emma', 'Lname' => 'Rugambwa', 'email' => 'irugambwa@gmail.com', 'password' => 'rugambwa'],
        ];

        foreach ($admins as $admin) {
            Admin::create([
                'Fname' => 'Gloria',
            'Lname' => 'Rugambwa', 
            'email' => 'grugambwa21@gmail.com',
            'password' => Hash::make('rugambwa@2002'),
            ]);
        }
    }
}

