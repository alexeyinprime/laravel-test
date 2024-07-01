<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create ten users
        User::factory()->count(10)->create();
        User::factory()->create([
            'name' => 'Junior',
            'email' => 'junior@laravel.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'email_verified_at' => now(),
            'description' => []
        ]);
    }
}
