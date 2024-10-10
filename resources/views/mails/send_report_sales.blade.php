
<h2>Hola {{ $user->name }}</h2>
<center>
<h3 style="color:blue">Reporte de ventas</h3>

      
          <table style="border-collapse: collapse;width: 100%;">
            <thead>
              <tr style="background-color: #D6EEEE;">
                <th style="  text-align: left;padding: 8px;">id</th>
                <th style="  text-align: left;padding: 8px;">Fecha</th>
                <th style="  text-align: left;padding: 8px;">Total</th>
                <th style="  text-align: left;padding: 8px;">Usuario</th>
              </tr>
            </thead>
            <tbody>              
                @foreach($sales as $sale)
                  <tr >
                    <td style="  text-align: left;padding: 8px;">{{ $sale->id }}</td>
                    <td style="  text-align: left;padding: 8px;">{{ $sale->created_at }}</td>
                    <td style="  text-align: left;padding: 8px;"> $ {{ $sale->getTotal() }}</td>
                    <td style="  text-align: left;padding: 8px;">      
                         {{ $sale->user->name }}
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>               

     </center>     