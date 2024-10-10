<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'image',
        'activo',
        'stock',
    ];

    public function category(){
        //un producto puede tener una categoría
        return $this->beLongsTo(Category::class);
    }
}
