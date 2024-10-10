<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sales;
use App\Models\Product;

class SalesDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    //se definen las relaciones entre las ventas y el detalle de las ventas
    public function sales(){
        return $this->belongsTo(Sales::class);
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }

        
}
