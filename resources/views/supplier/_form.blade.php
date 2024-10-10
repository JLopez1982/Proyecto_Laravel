@csrf
                <div class="mb-3">
                    <label for="supplier_code"  class="form-label">Código de proveedor</label>
                    
                    @if ($tipo === "creación")
                      <input type="name" class="form-control"  name="supplier_code" id="supplier_code" value="{{ old('supplier_code',$supplier->supplier_code) }}">       
                      @else
                      <input type="name" class="form-control"  name="supplier_code" id="supplier_code" value="{{ old('supplier_code',$supplier->supplier_code) }}" disabled>       
                    @endif

                    @error('supplier_code')
                    <p style="color:red">{{ $message }}</p>
                    @enderror             
                </div>  

                <div class="mb-3">
                    <label for="name"  class="form-label">Nombre</label>
                    <input type="name" class="form-control"  name="name" id="name" value="{{ old('name',$supplier->name) }}">       
                    @error('name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror             
                </div>  
                
                
               @if ($tipo === "edición")
                   
               <div class="mb-3">                
                    <label for="activo" class="form-label">Estatus</label>
                    <br/>

                    @if ($supplier->activo)
                        <input class="form-check-input" type="checkbox" value="1" id="activo" name="activo" checked>  
                        <label  class="form-label">Activo</label>
                    @else
                        <input class="form-check-input" type="checkbox" value="1" id="activo" name="activo">                          
                        <label  class="form-label">Inactivo</label>
                    @endif
                                            
                             
                </div>   
                                  
               @endif
 
 