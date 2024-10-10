@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Opciones principales') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (auth()->user()->isAdmin())
                    <div class="container">
                        <div class="row">
                          <div class="col-sm">                            
                            <div class="card" style="width: 18rem;">   
                            <img src="{{ asset("/storage/upload/Productos.jpg") }}" class="card-img-top" width="150" height="150" alt=".....">
                                <div class="card-body">
                                    <h5 class="card-title">Productos</h5>                        
                                    <a href="{{ route('products.index') }}" class="btn btn-primary stretched-link">Visualizar productos</a>
                                </div>
                            </div>
                         </div>
                         <div class="col-sm">
                           <div class="card" style="width: 18rem;">                    
                           <img src="{{ asset("/storage/upload/Proveedores.jpg") }}" class="card-img-top" width="150" height="150" alt=".....">
                            <div class="card-body">
                                    <h5 class="card-title">Proveedores</h5>                        
                                    <a href="{{ route('supplier.index') }}" class="btn btn-primary stretched-link">Visualizar proveedores</a>
                                </div>
                            </div>
                         </div>
                            <div class="col-sm">
                            <div class="card" style="width: 18rem;">                    
                            <img src="{{ asset("/storage/upload/Clientes.jpg") }}" class="card-img-top" width="150" height="150" alt=".....">   
                              <div class="card-body">
                                    <h5 class="card-title">Clientes</h5>                        
                                    <a href="{{ route('customers.index') }}" class="btn btn-primary stretched-link">Visualizar clientes</a>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
					
					<br/><br/>
                    @endif
                    
	                <div class="container">
                        <div class="row">
                          <div class="col-sm">                            
                            <div class="card" style="width: 18rem;">                    
                            <img src="{{ asset("/storage/upload/Ventas.jpg") }}" class="card-img-top" width="150" height="150" alt=".....">   
                                <div class="card-body">
                                    <h5 class="card-title">Ventas</h5>                        
                                    <a href="{{ route('sales.index') }}" class="btn btn-primary stretched-link">Capturar ventas</a>
                                    <p></p>
                                    
                                </div>
                            </div>
                         </div>
						 
						 												
                         <div class="col-sm">                            
                            <div class="card" style="width: 18rem;">                    
                            <img src="{{ asset("/storage/upload/Reportes.jpg") }}" class="card-img-top" width="150" height="150" alt=".....">   
                                <div class="card-body">
                                    <h5 class="card-title">Reporte de Ventas</h5>                        
                                    <a href="{{ route('ventas') }}" class="btn btn-primary stretched-link">Visualizar ventas</a>
                                    <p></p>
                                </div>
                            </div>
                         </div>
						 
						<div class="col-sm">                            
                            <div class="card" style="width: 18rem;border:none">                    
                                <div class="card-body">
                                    <h5 class="card-title"></h5>                        
                                    
                                    <p></p>
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
@endsection
