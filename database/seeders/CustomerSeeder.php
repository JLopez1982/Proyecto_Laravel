<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //                
        Customer::firstOrCreate([
            'customer_code' => 'C0001',
            'name' => 'Público en general'            
        ]);
    }
}
