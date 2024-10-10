<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       // $products=Product::orderBy('id','desc')->paginate(10);
        //dd($products);
        /*return view('products.index',[
            'products' => $products
            //::orderBy('id','desc')->paginate(2)  
            //regresa todos los elementos
        ]);*/
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('products.create',[
            'categories' => Category::all(),
            'product' => new Product   
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' =>'required|string|max:255',
            'price' =>'required|numeric',
            'stock' =>'required|numeric',
            'description' =>'required|string|max:255',
            'category_id' =>'required|exists:categories,id',
//            'image' => 'required'
        ], 
        [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.max' => 'El nombre del producto no puede tener más de 255 caracteres.',
            'price.required' => 'El precio del producto es obligatorio.',
            'stock.required' => 'El stock del producto es obligatorio.',
            'description.required' => 'La descripción del producto es obligatorio.',
            'description.max' => 'La descripción del producto no puede tener más de 255 caracteres.',
        ]);
        //dd($request->all());

        Product::create($this->getParams($request,'creación'));
        //regresa al products
        return redirect('/products')->with('success','Producto creado ');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        return view('products.edit',[
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //dd($request->all());        
        $product->update($this->getParams($request,'edición'));         
        
        return redirect('/products')->with('success','Producto modificado exitosamente ');
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        dd($product);
        //$product->delete();
        $product->update([
            'activo' => 0,
        ]);
            
        return redirect('/products')->with('success','Producto actualizado exitosamente ');
        
    }

    public function getParams($request,$tipo_accion){
        $params =$request->all();
        
         if($request->hasFile('image')){
             //para almacenar la imagen se utiliza este método
             $path=$request->file('image')->store('upload','public');//public es el driver de la imagen
             $params['image'] = $path;
         }
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
