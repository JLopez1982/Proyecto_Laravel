<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Sales;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReportSales;


new class extends Component {
    //
    use WithPagination;
    public $salesPerPage ;
    public $search ;
    public $sortField ;
    public $sortOrder ;
    public $totalSales ;
   


    public function mount(){
      $this->salesPerPage = 8;
      $this->search = '';
      $this->sortField = 'id';
      $this->sortOrder = 'desc';
      $this->totalSales =0;

    }

  
   public function with()
    {
      $sales=[];

      if(auth()->user()->isAdmin())
         $sales =Sales::where('user_id', 'like', '%'. $this->search. '%') 
          ->orderBy($this->sortField, $this->sortOrder)
          ->paginate($this->salesPerPage);
      else        
         $sales=Sales::where('user_id', '=', auth()->user()->id)
         ->orderBy($this->sortField, $this->sortOrder)
          ->paginate($this->salesPerPage);
                                  
        $this->totalSales =$sales->count();
        //dd($sales);
        return [
            'sales' => $sales            
        ];
    }

    public function fnc_enviar_correo(){
      // Implementar el envío de correo electrónico con la lista de ventas
     
      try{       
       //dd(auth()->user()->isAdmin());
       $ventas=[];

       if(auth()->user()->isAdmin())
          $ventas =Sales::all();
       else        
          $ventas=Sales::where('user_id', '=', auth()->user()->id)->get();
       //dd($ventas);
       Mail::to(auth()->user())->send(new SendReportSales(auth()->user(),$ventas));
       session()->flash('success', 'Correo enviado correctamente');
      }catch(\Exception $e){
          dd($e);        
          session()->flash('error', 'Error al enviar el correo');
        }
    }
}; ?>

<div class="row d-flex justify-content-center">
    <center>
    <h3>Ventas generadas </h3>
    <button class="btn btn-primary w-20 mt-3" wire:click="fnc_enviar_correo">Enviar reporte</button> 
    <p></p>
    </center>
    
    <div class="col-sm-5">    
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

        <div class="cart-body">
          <h3>Total de registros  {{ $totalSales }}</h3>
          <table class="table">
            <thead>
              <tr>
                <th>id</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Usuario</th>
              </tr>
            </thead>
            <tbody>              
                @foreach($sales as $sale)
                  <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->created_at }}</td>
                    <td>{{ $sale->getTotal() }}</td>
                    <td>      
                         {{ $sale->user->name }}
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>               
     </div>
    </div>
  </div>
  <div class="row d-flex justify-content-center">  
  <div class="col-sm-5"> 

  <div class="row">
    <div class="col-sm-3 "></div>
    <div class="col-sm-3 "></div>
    <div class="col-sm-3 "></div>
    <div class="col-sm-3 ">	  
      <p></p>
       <div class="mx-auto ">
          {{ $sales->links('pagination::bootstrap-4') }}
	     </div> 
     </div>
  </div>
  </div>
  </div>
</div>	