<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Product;

new class extends Component {
    //
    use WithPagination;
/*
    public function mount(){
        $this->products =Product::all();
    }*/

    public function with()
    {
        return [
            'products' => Product::paginate(4)
        ];
    }

}; ?>

<div>
    <div class="container">
        <div class="row justify-content-center">
            @session('success')
            <div class="alert alert-primary" role="alert">
                {{ $value }}
            </div>
            @endsession
            <div class="col-md-9">
                @if (auth()->user()->isAdmin())
                <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 text-end">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Producto</a>
                    </div>
                    <div class="col-sm-2 text-end">
                        <a href="{{ route('home') }}" class="btn btn-primary"><- Regresar</a>
                    </div>
                </div>
                
                @endif
                <br/><br/>
                <div class="row">
                     
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-10">
                        <div class="card">
                          <div class="cart-body">
                            <h3>Productos</h3>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>stock</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>              
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            @if($product->activo)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                           
                                           
                                        </td>
                                        <td>      
                                        @if (auth()->user()->isAdmin())
                                            <a href="{{ route('products.edit', ['product' => $product]) }}" class="btn btn-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-down-left" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M9.636 2.5a.5.5 0 0 0-.5-.5H2.5A1.5 1.5 0 0 0 1 3.5v10A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5V6.864a.5.5 0 0 0-1 0V13.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                                                <path fill-rule="evenodd" d="M5 10.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1H6.707l8.147-8.146a.5.5 0 0 0-.708-.708L6 9.293V5.5a.5.5 0 0 0-1 0z" />
                                            </svg>
                                            </a>
                                            
                                        @endif                      
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
							<div class="col-6 mx-auto">
								{{ $products->links('pagination::bootstrap-4') }}
							</div>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>

         
            </div>
        </div>
    </div>
</div>
