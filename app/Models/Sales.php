<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SalesDetail;
use App\Models\User;
use App\Models\Customer;

class Sales extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relaciones 
    public function salesDetails(){
        return $this->hasMany(SalesDetail::class);
    }
        
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function getTotal(){
    
        /* return $this->salesDetails->reduce( function ($carry,$item){
             return $carry + $item->product->price;
         },0);
         */
        return $this->salesDetails->sum( function($salesDetails){
            return $salesDetails->total;
        });
        
    }

    ///obrserver 
    protected static function booted(): void {
        //cuando se crea la Venta  
        static::creating(function ( Sales $sale) {            
              $sale->uuid = str()->uuid();            
        });

    }    
}
