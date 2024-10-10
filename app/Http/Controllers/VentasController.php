<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentasController extends Controller
{
    //

    public function index(){
        //dd(null);                
        return view('ventas.index');
    }

}
