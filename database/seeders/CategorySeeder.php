<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             //agregaremos la colección de las categorías
             collect([
                'Papelería',
                'Copias',
                'Dulces',
                'Mercería'
             ])->each(function($category){
                 Category::firstOrCreate(['name'=>$category]) ;//si ya existe la categoría no la inserta
             });
    }
}
