<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SalesController extends Controller
{
    //
    public function index(){
        //dd(null);
        return view('sales.index');
    }

}
