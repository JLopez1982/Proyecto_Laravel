@extends('layouts.app')

@section('content')

   <div class="row d-flex justify-content-center">

    <div class="col-sm-5">
        <div class="card">
            <div class="card-body">
              <h3>Edición de clientes</h3>
              <form action="{{ route('customers.update',['customer'=>$customer]) }}" method="POST"
                enctype="multipart/form-data">
                @method('PATCH')
                @include('customers._form', ['customer' => $customer, 'tipo' => 'edición'])
                <div class="row">
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                
              </form>
            </div>
          </div>      
    </div>
   </div> 

@endsection

