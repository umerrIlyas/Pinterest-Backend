<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Umer Illyas',
            'email' => 'admin@regex.co',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
