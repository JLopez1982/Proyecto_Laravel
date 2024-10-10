@extends('layouts.app')

@section('content')

   <div class="row d-flex justify-content-center">

    <div class="col-sm-5">
        <div class="card">
            <div class="card-body">
              <h3>Creación de proveedores</h3>

              <form action="{{ route('supplier.store') }}" method="POST" 
              enctype="multipart/form-data">                
                @include('supplier._form', ['supplier' => $supplier, 'tipo' => 'creación' ])
                <div class="row">
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                
              </form>

            </div>
          </div>      
    </div>
   </div> 

@endsection
