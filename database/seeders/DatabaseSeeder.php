<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\CustomerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::factory()->create([
            'name' => 'Kisna',
            'email' =>'administrador@example.com',
            'password' =>'test123',
            'role' => 1
        ]);

        User::factory()->create([
            'name' => 'Usuario1',
            'email' =>'usuario1@example.com',
            'password' =>'testpassword1',
            'role' => 2
        ]);


       $this->call(CategorySeeder::class);
       $this->call(SupplierSeeder::class);
       $this->call(CustomerSeeder::class);
    }
}
