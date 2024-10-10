<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         //
         return view('supplier.create',[            
            'supplier' => new Supplier   
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'supplier_code' =>'required|string|max:5|unique:suppliers',
            'name' =>'required|string|max:255',
        ], 
        [
            'supplier_code.required' => 'El código del proveedor es obligatorio.',
            'supplier_code.max' => 'El código del proveedor no puede tener más de 5 caracteres.',
            'supplier_code.unique' => 'El código del proveedor no se puede repetir.',
            'name.max' => 'El código del proveedor no puede tener más de 255 caracteres.',
        ]);
        

        Supplier::create($request->all());
        //regresa al proveedor
        return redirect('/supplier')->with('success','Proveedor creado ');

    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
        return view('supplier.edit',[
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
        $request->validate([           
            'name' =>'required|string|max:255',
        ], 
        [
            'name.max' => 'El nombre del proveedor no puede tener más de 255 caracteres.'
        ]);
     
        $supplier->update($this->getParams($request,'edición'));         
        
        return redirect('/supplier')->with('success','Proveedor modificado exitosamente ');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
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
