<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           //
           return view('customers.create',[            
            'customer' => new Customer   
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //dd($request->all());
        $request->validate([
            'customer_code' =>'required|string|max:5|unique:customers',
            'name' =>'required|string|max:255',
        ], 
        [
            'customer_code.required' => 'El código del cliente es obligatorio.',
            'customer_code.max' => 'El código del cliente no puede tener más de 5 caracteres.',
            'customer_code.unique' => 'El código del cliente no se puede repetir.',
            'name.max' => 'El código del cliente no puede tener más de 255 caracteres.',
        ]);
        

        Customer::create($request->all());
        //regresa al proveedor
        return redirect('/customers')->with('success','Cliente creado ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        
        //
        return view('customers.edit',[
                'customer' => $customer
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {

        //
        $request->validate([           
                    'name' =>'required|string|max:255',
                ], 
                [
                    'name.max' => 'El código del cliente no puede tener más de 255 caracteres.'
                ]);
             
        $customer->update($this->getParams($request,'edición'));         
                
        return redirect('/customers')->with('success','Cliente modificado exitosamente ');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function getParams($request,$tipo_accion){
        $params =$request->all();
        
         //solo en edición se validará el estatus del producto
         if($tipo_accion=='edición'){
            $v_estatus = $request->input('activo', 0); // Valor por defecto: '0'    
            //dd($v_estatus);    
            if ($v_estatus == 1) 
               $params['activo'] = 1;
             else 
               $params['activo'] = 0;     
         }
        
        //dd($params);

        return $params;
    }
}
