<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@kotaukir.id',
            'username' => 'administrator',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'address' => 'Jl. Raya Kebon Jeruk No. 123',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '12345',
            'level' => 'basic',
            'phone' => '081234567890',

        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
            'role' => 'user',
            'password' => bcrypt('password'),
            'address' => 'Jl. Jalan No. 456',
            'city' => 'Bandung',
            'province' => 'Jawa Barat',
            'postal_code' => '45678',
            'level' => 'basic',
            'phone' => '081234567891',

        ]);
    }
}
