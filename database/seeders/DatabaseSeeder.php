<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()
        ->create([
        'name' => 'admin',
        'email' => 'admin@dbiphils.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);
   
        User::factory()
        ->create([
        'name' => 'admin2',
        'email' => 'admin2@dbiphils.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
]);

    }
}
