
<h2>Hola {{ $user->name }}</h2>
<center>
<h3 style="color:blue">Reporte de ventas</h3>

      
          <table style="border-collapse: collapse;width: 100%;">
            <thead>
              <tr style="background-color: #D6EEEE;">                
                <th style="  text-align: left;padding: 8px;">Fecha</th>
                <th style="  text-align: left;padding: 8px;">Impuestos</th>
                <th style="  text-align: left;padding: 8px;">Subtotal</th>
                <th style="  text-align: left;padding: 8px;">Total</th>
                <th style="  text-align: left;padding: 8px;">Usuario</th>
              </tr>
            </thead>
            <tbody>              
                @foreach($sales as $sale)
                  <tr >
                    <td style="  text-align: left;padding: 8px;">{{ $sale->fecha }}</td>
                    <td style="  text-align: left;padding: 8px;">{{ $sale->impuesto }}</td>
                    <td style="  text-align: left;padding: 8px;"> $ {{ $sale->subtotal }}</td>
                    <td style="  text-align: left;padding: 8px;"> $ {{ $sale->total }}</td>
                    <td style="  text-align: left;padding: 8px;">      
                         {{ $sale->name }}
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>               

     </center>     