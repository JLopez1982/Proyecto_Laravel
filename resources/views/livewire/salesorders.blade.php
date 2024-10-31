<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Sales;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReportSales;
use Illuminate\Support\Facades\DB;


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
     /*
      if(auth()->user()->isAdmin())
         $sales =Sales::where('user_id', 'like', '%'. $this->search. '%') 
          ->orderBy($this->sortField, $this->sortOrder)
          ->paginate($this->salesPerPage);
      else        
         $sales=Sales::where('user_id', '=', auth()->user()->id)
         ->orderBy($this->sortField, $this->sortOrder)
          ->paginate($this->salesPerPage);
                      
       */
      
       if(auth()->user()->isAdmin())
           //$sales = DB::select('SELECT DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha,sum(sd.taxrate) as impuesto,sum(sd.subtotal) as subtotal,sum(sd.total) as total,u.name, s.user_id FROM sales_details as  sd, sales as s,users as u where sd.sales_id=s.id and s.user_id=u.id  group by DATE_FORMAT(sd.created_at, "%d-%m-%Y"),u.name,s.user_id order by sd.created_at desc');
           $sales = DB::table('sales_details as sd')
           ->join('sales as s', 'sd.sales_id', '=', 's.id')
           ->join('users as u', 's.user_id', '=', 'u.id')
           ->selectRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha, sum(sd.taxrate) as impuesto, sum(sd.subtotal) as subtotal, sum(sd.total) as total, u.name, s.user_id')
           ->groupByRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y"), u.name, s.user_id')
           ->orderBy('sd.created_at', 'desc')
           ->paginate(5);  // Esto activa la paginación
        else
           //$sales = DB::select('SELECT DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha,sum(sd.taxrate) as impuesto,sum(sd.subtotal) as subtotal,sum(sd.total) as total,u.name, s.user_id FROM sales_details as  sd, sales as s,users as u where sd.sales_id=s.id and s.user_id=u.id and u.id=' . auth()->user()->id .' group by DATE_FORMAT(sd.created_at, "%d-%m-%Y"),u.name,s.user_id order by sd.created_at desc');
        $sales = DB::table('sales_details as sd')
        ->join('sales as s', 'sd.sales_id', '=', 's.id')
        ->join('users as u', 's.user_id', '=', 'u.id')
        ->selectRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha, sum(sd.taxrate) as impuesto, sum(sd.subtotal) as subtotal, sum(sd.total) as total, u.name, s.user_id')
        ->where('s.user_id', '=', auth()->user()->id)  // Condición para el usuario autenticado
        ->groupByRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y"), u.name, s.user_id')
        ->orderBy('sd.created_at', 'desc')
        ->paginate(5);  // Esto activa la paginación

         $this->totalSales =$sales->count();
        
        return [
            'sales' => $sales            
        ];
    }

    public function fnc_enviar_correo(){
      // Implementar el envío de correo electrónico con la lista de ventas
     
      try{       
       //dd(auth()->user()->isAdmin());
       $ventas=[];
       /*
       if(auth()->user()->isAdmin())
          $ventas =Sales::all();
       else        
          $ventas=Sales::where('user_id', '=', auth()->user()->id)->get();
       //dd($ventas);
       */

       if(auth()->user()->isAdmin())
       //$sales = DB::select('SELECT DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha,sum(sd.taxrate) as impuesto,sum(sd.subtotal) as subtotal,sum(sd.total) as total,u.name, s.user_id FROM sales_details as  sd, sales as s,users as u where sd.sales_id=s.id and s.user_id=u.id  group by DATE_FORMAT(sd.created_at, "%d-%m-%Y"),u.name,s.user_id order by sd.created_at desc');
       $sales = DB::table('sales_details as sd')
       ->join('sales as s', 'sd.sales_id', '=', 's.id')
       ->join('users as u', 's.user_id', '=', 'u.id')
       ->selectRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha, sum(sd.taxrate) as impuesto, sum(sd.subtotal) as subtotal, sum(sd.total) as total, u.name, s.user_id')
       ->groupByRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y"), u.name, s.user_id')
       ->orderBy('sd.created_at', 'desc')
       ->paginate(5);  // Esto activa la paginación
    else
       //$sales = DB::select('SELECT DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha,sum(sd.taxrate) as impuesto,sum(sd.subtotal) as subtotal,sum(sd.total) as total,u.name, s.user_id FROM sales_details as  sd, sales as s,users as u where sd.sales_id=s.id and s.user_id=u.id and u.id=' . auth()->user()->id .' group by DATE_FORMAT(sd.created_at, "%d-%m-%Y"),u.name,s.user_id order by sd.created_at desc');
      $sales = DB::table('sales_details as sd')
      ->join('sales as s', 'sd.sales_id', '=', 's.id')
      ->join('users as u', 's.user_id', '=', 'u.id')
      ->selectRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y") as fecha, sum(sd.taxrate) as impuesto, sum(sd.subtotal) as subtotal, sum(sd.total) as total, u.name, s.user_id')
      ->where('s.user_id', '=', auth()->user()->id)  // Condición para el usuario autenticado
      ->groupByRaw('DATE_FORMAT(sd.created_at, "%d-%m-%Y"), u.name, s.user_id')
      ->orderBy('sd.created_at', 'desc')
      ->paginate(5);  // Esto activa la paginación


       //dd($sales);

       Mail::to(auth()->user())->send(new SendReportSales(auth()->user(),$sales));
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
                <th>Fecha</th>
                <th>Impuesto</th>
                <th>Subtotal</th>
                <th>Total</th>
                <th>Usuario</th>
              </tr>
            </thead>
            <tbody>              
                @foreach($sales as $sale)
                  <tr>                    
                    <td>{{ $sale->fecha }}</td>
                    <td>$ {{ $sale->impuesto }}</td>
                    <td>$ {{ $sale->subtotal }}</td>
                    <td>$ {{ $sale->total }}</td>
                    <td>      
                         {{ $sale->name }}
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