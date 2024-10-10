@csrf
                <div class="mb-3">
                    <label for="name"  class="form-label">Nombre</label>
                    <input type="name" class="form-control"  name="name" id="name" value="{{ old('name',$product->name) }}">       
                    @error('name')
                    <p style="color:red">{{ $message }}</p>
                    @enderror             
                </div>  
                
                <div class="mb-3">
                    <label for="description"  class="form-label">Descripción</label>                    
                    <textarea class="form-control"  name="description"  >
                         {{ old('description',$product->description) }}
                    </textarea>                 
                    @error('description')
                    <p style="color:red">{{ $message }}</p>
                    @enderror                        
                </div>             
                <!-- 
                <div class="mb-3">
                    <label for="image"  class="form-label">Imagen</label>
                    <input type="file" class="form-control"  name="image" >    
                    @error('image')
                    <p style="color:red">{{ $message }}</p>
                    @enderror                  
                </div>              -->

                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" class="form-control">
                      @foreach ($categories as $category )
                          <option value="{{ $category->id }}" 
                            @selected($category->id == $product->category_id) > {{$category->name }}                         
                          </option>
                      @endforeach
                    </select>                   
                @error('category_id')
                    <p style="color:red">* Campo requerido</p>
                @enderror
                </div>       

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control"  name="price"  id="price" value="{{  old('price',$product->price) }}">    
                    @error('price')
                    <p style="color:red">{{ $message }}</p>
                    @enderror                
                </div>   

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control"  name="stock"  id="stock" value="{{  old('stock',$product->stock) }}">    
                    @error('stock')
                    <p style="color:red">{{ $message }}</p>
                    @enderror                
                </div>                   
                
               @if ($tipo === "edición")
                   
               <div class="mb-3">                
                    <label for="activo" class="form-label">Estatus</label>
                    <br/>

                    @if ($product->activo)
                        <input class="form-check-input" type="checkbox" value="1" id="activo" name="activo" checked>  
                        <label  class="form-label">Activo</label>
                    @else
                        <input class="form-check-input" type="checkbox" value="1" id="activo" name="activo">                          
                        <label  class="form-label">Inactivo</label>
                    @endif
                                            
                             
                </div>   
                                  
               @endif
 
 