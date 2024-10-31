<?php

use Livewire\Volt\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesDetail;

new class extends Component {
    public $products;
    public $cartSubTotal = 0;
    public $cartIVA = 0;
    public $cartTotal = 0;
    public $cartItems;
    public $customer;
    public $search_product="";
    public $customer_id=0;
    public $quantities;
    //
    public function mount()
    {
        $this->products= [];                
        $this->quantities=[]; // Array para almacenar las cantidades
        //Product::all();
       //dd($this->products);           
       $this->customer=Customer::all()->find(1);
       //dd($this->customer->id); 
       $customer_id=$this->customer->id;
       //dd('Id cliente= ' . $this->customer->id);
        // Calcula el total del carrito
        $this->updateCartTotal();
    }

    public function addToCart($product)
    {
        // Encuentra el producto por ID
        //dd($this->quantities[$product['id']]);
       try{ 
       $cantidad_carrito=$this->fnc_buscar_producto_carrito($product['id']);              
       $cantidad=$this->quantities[$product['id']];
       $stock=$product['stock'];
       //dd("Stock =" .  $stock  . " cantidad_carrito=" . $cantidad_carrito . "  cantidad= " .$cantidad); 
       if($stock<$cantidad_carrito+$cantidad){
           session()->flash('error', 'No hay stock suficiente para agregar la cantidad solicitada.');
           return;
       }

       $cartItem =cart()->add($product['id'], 
       $product['name'], 
       $cantidad, 
        $product['price']);
       //dd($cartItem->rowId);
       //actualiza el IVA para que sea el 16% de lo contrario deja el 21%
       cart()->setTax($cartItem->rowId, 0);
        // Actualiza el total del carrito
        $this->updateCartTotal();
      
    }catch(\Exception $e){
        //dd($e);        
        session()->flash('error', 'Favor de proporcionar la cantidad a agregar');
      }


    }

    public function fnc_buscar_producto_carrito($productId){//fnc_buscar_producto_carrito
    // Accede al contenido del carrito
    $cart = cart()->content();

    // Busca el producto en el carrito con el ID proporcionado
    $itemEncontrado = $cart->search(function ($cartItem, $rowId) use ($productId) {
        return $cartItem->id === $productId;
    });

    // Si se encuentra el producto
    if ($itemEncontrado !== false) {
        // Accedemos al producto en el carrito
        $cartItem = $cart->get($itemEncontrado);

        // Retorna la cantidad agregada al carrito
        return $cartItem->qty;
    } else {
        // Si no se encuentra el producto en el carrito
        return 0;
    }

    }//fnc_buscar_producto_carrito

    public function removeFromCart($rowId)
    {
        // Elimina un producto del carrito
        cart()->remove($rowId);
        // Actualiza el total del carrito
        $this->updateCartTotal();
    }

    public function updateCartTotal()
    {
        // Actualiza el total del carrito
        //$this->cartTotal = Cart::total();
        $this->cartSubTotal = cart()->subtotal();
        $this->cartIVA = cart()->tax();
        $this->cartTotal = cart()->total();               
        //dd(Cart::content());
        $items=cart()->content()->map(function($item) {         
            return [
            "rowId" => $item->rowId,
            "id" => $item->id,
            "name" => $item->name,
            "price" => $item->price,
            "qty" => $item->qty,
            ];
         })->values();
         //dd( $items);
        $this->cartItems=$items;        
        //dd($this->cartItems);
    }

  public function checkout()
  {
    //dd(cart()->count());
    //dd('Id cliente= ' . $this->customer->id);
    if (cart()->count() == 0) {
        //dd('success');
        session()->flash('error', 'El carrito está vacío.');
        
    }
    else{
        $this->fnc_generar_venta($this->customer->id);
    }

   }

   public function fnc_buscar_producto() {
    //dd($this->search_product);    
    $this->products=Product::where('name', 'LIKE', '%'.$this->search_product.'%')
                            ->where('activo', 1) // Condición para productos activos
                            ->get();
    $this->reset(['search_product']);
    $this->quantities=[]; // Array para almacenar las cantidades
    //dd($this->products);
   }

   public function fnc_generar_venta($p_cliente_id){
    //dd("p_cliente_id= " . $p_cliente_id);
    try{
       //dd(cart()->content()) ;
       $sale = Sales::create( ['user_id'=> auth()->id(),'customer_id' =>$p_cliente_id]);//manda todo menos el campo token       
       $items=cart()->content()->map(function($item) use($sale) {
        $subtotal=($item->qty * $item->price);
        $IVA=($subtotal)*($item->taxRate/100);
        
        $total=$subtotal+$IVA;

        $orderDetail = SalesDetail::create([
           'sales_id' => $sale->id,  
           'product_id' => $item->id,                                              
           'price' => $item->price,
           "quantity" => $item->qty,
           "taxrate" => $IVA,
           "subtotal" => $subtotal,
           "total" => $total,
        ]);

        $product = Product::find($item->id); // Asumiendo que `Product` es tu modelo de productos
        if ($product) {
            // Actualizas el producto con los valores que necesites, por ejemplo el inventario
            $product->update([
                'stock' => $product->stock - $item->qty, // Ejemplo: restar la cantidad del carrito al stock
            ]);
        }
        ///esta es la forma en como mercado pago ocupa la información
        return [        
        "product_id" => $item->id,
        "quantity" => $item->qty,
        ];
     })->values()->toArray();

     //dd($items) ;
      // Lógica para guardar el pedido, etc.
      $itemsCount = count($items);
      if($itemsCount>0){
        cart()->destroy(); // Vacia el carrito
        $this->reset(['search_product']);
        $this->products= [];     
        $this->updateCartTotal();   
      }       
       session()->flash('success', 'La venta se creó correctamente');
    }catch(\Exception $e){
        //dd($e);        
        session()->flash('error', 'Error al generar la venta');
      }

   }


}; ?>
       
<div class="row mt">
   <div class="col-md-7">
    <div class="card">
    @if (session('error'))
        <div class="alert alert-danger" id="flash_message">
            {{ session('error') }}
        </div>
    @elseif (session('success'))    
    <div class="alert alert-primary" id="flash_message">
        {{ session('success') }}
    </div>
    @endif
    <div class="card-header bg-secondary text-white">
       <h4>Información del cliente</h4>
    </div>
    <div class="card-body"> 
       <!-- Datos del cliente-->
       <div class="input-group mb-7">
       <form>
        <div class="row">
            <div class="col">
            <input type="text" class="form-control" placeholder="Código..."  value="{{$customer->customer_code}}" size="50" disabled>
            </div>
            <div class="col-md-7">
            <input type="text" class="form-control" placeholder="Nombre..."  disabled value="{{$customer->name}}">
            </div>
            <div class="col">
            <input type="hidden" class="form-control" placeholder="Id..."  value="{{$customer->id}}" wire:model="customer_id">
            </div>
            <div class="col">
            <button class="btn btn-outline-secondary" id="searchCustomer" wire:click="fnc_buscar_clientes" disabled>Buscar</button>
            </div>
        </div>
        </form>                                          
        </div>                     
     </div>    
    </div>    
   </div>
    <!-- Sección izquierda: Buscador de productos -->
    <div class="col-md-7">

        <div class="card">
   
            <div class="card-header bg-primary text-white">
                <h4>Buscador de productos</h4>
            </div>
            <div class="card-body">
            <!-- Input para buscar productos -->
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Buscar productos..." id="producro_name" wire:model="search_product">
              <button class="btn btn-outline-secondary" id="searchBtn" wire:click="fnc_buscar_producto">Buscar</button>
            </div>                
                <!-- Tabla de productos -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="w-10">#</th>
                            <th class="w-20">Nombre</th>
                            <th class="w-30">Descripción</th>
                            <th class="w-10">Precio</th>
                            <th class="w-10">Stock</th>
                            <th class="w-10">Cantidad</th>
                            <th class="w-10">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ number_format($product->stock, 0) }}</td>
                            <td>
                                <!-- Input para capturar la cantidad -->
                                <input type="number" wire:model="quantities.{{ $product['id'] }}" min="1" class="form-control form-control-sm" 
                                       placeholder="Cantidad" value="1" size="2" style="width: 100px;">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success" wire:click="addToCart({{ $product }})">Agregar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sección derecha: Carrito de compras -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h4>Productos a vender</h4>
            </div>
            <div class="card-body">
                <!-- Lista de productos en el carrito -->
                <ul class="list-group mb-3">
                    @forelse($cartItems as $item)                                                     
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item['name']}}
                        <span>${{ $item['price'] }}</span>
                        <span>Cantidad: {{ $item['qty'] }}</span>
                        <button class="btn btn-sm btn-danger" wire:click="removeFromCart('{{ $item['rowId'] }}')">Eliminar</button>
                    </li>
                    @empty
                    <li class="list-group-item">El carrito está vacío</li>
                    @endforelse
                </ul>
                <!-- Total -->
                <div class="d-flex justify-content-between">
                    <h5>Subtotal:</h5>
                    <h5>${{ $cartSubTotal }}</h5>
                </div>
                <div class="d-flex justify-content-between">
                    <h5>IVA:</h5>
                    <h5>${{ $cartIVA}}</h5>
                </div>
                <div class="d-flex justify-content-between">
                    <h5>Total:</h5>
                    <h5>${{ $cartTotal }}</h5>
                </div>
                <!-- Botón para finalizar la compra -->
                <button class="btn btn-primary w-100 mt-3" wire:click="checkout">Finalizar venta</button> 
            </div>
        </div>
    </div>
</div>

