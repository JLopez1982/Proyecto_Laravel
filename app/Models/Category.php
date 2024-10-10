<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function products(){
        //una categoría puede tener muchos productos
        return $this->hasMany(Product::class);
    }  
}
