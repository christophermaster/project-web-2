@extends ('layouts.admin')
@section ('contenido')
    <div class="caja" >
        <div class="nivel">
            <a href = "{{ URL::previous() }}">
                <button class="myButton"><i class="fa fa-long-arrow-left"></i>  Atras</button>
            </a>
        </div>
    </div>
    <div class="caja">
        <div class="grupoFormulario medio-12 centro">
            <h2>Editar Factura</h2>
        </div>
        <hr>
        <br>
        <div class="nivel">
            <div class="extra-pequeño-4 pequeno-4 medio-4 grande-4 centro">
                Factura
            </div>
            <div class="extra-pequeño-4 pequeno-4 medio-4 grande-4 centro">
                Nº {{$factura->id}}
            </div>
            <div class="extra-pequeño-4 pequeno-4 medio-4 grande-4 centro">
                {{$factura->fecha_creacion}}
            </div>

        </div>

        <hr>
	{!!Form::model($factura,['method'=>'PATCH','route'=>['factura.update',$factura->id]])!!}
	{{Form::token()}}
        <div class="cuadrado">
            <div class="formularioNivel">
                <div class="grupoFormulario medio-4">
                    <label for="inputEmail4">Nombre</label>
                    <input type="text" name ="nombre" class="formularioPrincipal" 
                    id="inputEmail4" placeholder="Nombre" required value="{{$factura->nombre}}" readonly >
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Apellido</label>
                    <input type="text"  name ="apellido" class="formularioPrincipal" 
                    id="inputPassword4" placeholder="Apellido" required value="{{$factura->apellido}}" readonly>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputAddress">Cedula</label>
                    <input type="text" name ="cedula" class="formularioPrincipal" 
                    id="inputAddress" placeholder="1234567" required value="{{$factura->cedula}}" readonly>
                </div>
            </div>
        </div>


        <div class="tabla-responsive class_div">
            <table  id ="detalles" class="tabla table-wrapper-scroll-y">
                <thead>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Concepto</th>
                    <th>Precio Total</th>
                    <th>12%IVA</th>
                    <th>Precio Total + 12%IVA</th>
                    <th>Acción</th>
				</thead>
				
                <tbody>
                    @foreach($gastos as $indexKey =>$gasto)
                   






					<tr class ="selected" id="fila{{$indexKey}}">
						<td><input type ="hidden" name="id_productoss[]" value ="{{$gasto->id_productos}}">{{$gasto->nombre_producto}}</td>
                        <td><input type ="hidden" name="precio_ventas[]" value ="{{$gasto->precio_unitario}}">{{$gasto->precio_unitario}}</td>
                        <td><input type ="hidden" name="cantidades[]" value ="{{$gasto->cantidad}}">{{$gasto->cantidad}}</td>
                        <td><input type ="hidden" name="comentarios[]" value = "{{$gasto->concepto}}">{{$gasto->concepto}}</td>
                        <td><input type ="hidden" name="sub_totales[]" value ="{{$gasto->precio_prducto}}">{{$gasto->precio_prducto}}</td>
                        <td><input type ="hidden" name="ivas[]" value ="{{$gasto->precio_iva}}">{{$gasto->precio_iva}}</td>
                        <td><input type ="hidden" name="totales_cobrar[]" value ="{{$gasto->precio_total_producto}}">{{$gasto->precio_total_producto}}</td>
						<td>
							<button type = "button" class= "btn btn-primary" onclick = "eliminar({{$indexKey}})">X</button>
						</td>						
					</tr>
					@endforeach
                 
                </tbody>
                <thead>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Sub Total</th>
                    <th>Impuesto</th>
                    <th>Total a Cobrar</th>
                    <th></th>
                </thead>
                <tfoot>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <h4 id="sub_total">S/.{{$factura->sub_total}}</h4> 
                        <input type="hidden" name="sub_venta" id="subventa" value ="{{$factura->total}}">
                    </th>
                    <th>
                        <h4 id="iva">S/. {{$factura->total_impuesto}}</h4> 
                        <input type="hidden" name="iva" id="_iva" value ="{{$factura->total}}">
                    </th>
                    <th>
                        <h4 id="total_cobrar">S/.{{$factura->total}}</h4> 
                        <input type="hidden" name="total_cobrar" id="totalcobrar" value ="{{$factura->total}}">
                    </th>
                    <th></th>
                </tfoot>
            </table>
        </div>

        <div class="cuadrado">
            <div class="formularioNivel">
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Producto</label>
                    <select name="id_producto" id="id_producto" class="select" data-live-search = "true">
                        <option value="0_0">Seleccione Producto</option>
                        @foreach($productos as $pro)
                        <option value="{{$pro->id}}_{{$pro->precio_unitario}}">{{$pro->nombre}}</option>
                        @endforeach
                    </select>
                    
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Precio Unitario</label>
                    <input type="number" name="precio_unitario" id="precio_unitario" class="formularioPrincipal" placeholder="Cantidad" readonly>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Cantidad</label>
                    <input type="number" class="formularioPrincipal" id="cantidad" name="cantidad" placeholder="Cantidad" min=1 value="1">
                </div>
            </div>

            <div class="formularioNivel">
                <div class="grupoFormulario medio-12">
                    <label for="inputEmail4">Concepto</label>
                    <input type="text" class="formularioPrincipal" name="concepto" id="concepto" placeholder="Concepto">
                </div>
            </div>
            <div class="formularioNivel button">
                <div class="grupoFormulario medio-12">
                    <button class="insertar" type="button" id = "bt_add">Agregar</button>
                </div>
            </div>
        </div>
    </div>
    <div class ="caja">

        <div class="formularioNivel button">
            <div class="grupoFormulario medio-12">
                <label for="inputEmail4">Imprimir</label>
                <div class="form-check">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="imprimir" value="Si" required>Si
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="imprimir" value="No" required>No
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="caja">
        <div class="nivel ce" id="guardar">
            <div class="grupoFormulario medio-6 centro">
                <button class="insertar" type="submit" >Actualizar</button>
            </div>
            <div class=" medio-6 centro">
                <button href="" class="insertar" type ="reset">Cancelar</button>
            </div>
        </div>
    </div>
{!!Form::close()!!}
@push('scripts')
<script>

    $(document).ready( function(){
        $('#bt_add').click(function(){
            agregar();
        });
    });

    // declaracion de variable
    var cont = 0;
    var sub_total = 0;
    var total_iva = 0;
    var total_cobrar = 0;

    //lleva la suma por fila 
    subtotal = [];
    iva = [];
    totalcobrar = [];

 
    $("#id_producto").change(mostrarValores);

    function inicializar(){
        var a = <?=json_encode($gastos,JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
        if(a.length > 0){
            cont = a.length;
            for(var i = 0; i < cont; i++ ){
                
                subtotal[i] = (a[i].cantidad*a[i].precio_unitario);
                iva[i] = Math.round(subtotal[i] * 0.12);
                totalcobrar[i] =  subtotal[i] + iva[i];

                sub_total = sub_total + subtotal[i];
                total_iva =  total_iva + iva[i];
                total_cobrar = total_cobrar + totalcobrar[i];
            }
        }
       
	}

    function mostrarValores(){
        datosArticulo = document.getElementById('id_producto').value.split('_');
        $('#precio_unitario').val(datosArticulo[1]);
    }


    function agregar(){

        if(cont == 0){
            inicializar()
        }
        datosArticulo = document.getElementById('id_producto').value.split('_');
       
        idarticulo = datosArticulo[0];
        articulo = $("#id_producto option:selected").text();
        cantidad = parseInt($("#cantidad").val());
        descuento = 0;
        precio_venta = $("#precio_unitario").val(); 
     
        comentario = $("#concepto").val(); 
        if(idarticulo != "" && idarticulo != "0"  
        && cantidad != "" && cantidad > 0  && comentario != "" ){
                     
            subtotal[cont] = (cantidad*precio_venta);
            iva[cont] = Math.round(subtotal[cont] * 0.12);
            totalcobrar[cont] =  subtotal[cont] + iva[cont];

            sub_total = sub_total + subtotal[cont];
            total_iva =  total_iva + iva[cont];
            total_cobrar = total_cobrar + totalcobrar[cont];


         var fila ='<tr class ="selected" id="fila'+cont+'">'
        +'<td><input type ="hidden" name="id_productoss[]" value = "'+idarticulo+'">'+articulo+'</td>'
        +'<td><input type ="hidden" name="precio_ventas[]" value = "'+precio_venta+'">'+precio_venta+'</td>'
        +'<td><input type ="hidden" name="cantidades[]" value = "'+cantidad+'">'+cantidad+'</td>'
        +'<td><input type ="hidden" name="comentarios[]" value = "'+comentario+'">'+comentario+'</td>'
        +'<td><input type ="hidden" name="sub_totales[]" value = "'+subtotal[cont]+'">'+subtotal[cont]+'</td>'
        +'<td><input type ="hidden" name="ivas[]" value = "'+iva[cont]+'">'+iva[cont]+'</td>'
        +'<td><input type ="hidden" name="totales_cobrar[]" value = "'+totalcobrar[cont]+'">'+totalcobrar[cont]+'</td>'
        +'<td><button type = "button" class= "btn btn-primary" onclick = "eliminar('+cont+')">X</button></td>'
        +'</tr>';
            cont ++ ;
            limpiar();
            $("#sub_total").html("S/. " +sub_total);
            $("#iva").html("S/. " + total_iva);
            $("#total_cobrar").html("S/. " + total_cobrar);
            $("#subventa").val(sub_total);
            $("#_iva").val(total_iva);
            $("#totalcobrar").val(total_cobrar);
            evaluar();
            $("#detalles").append(fila);

        }else{
            alert("Revise los datos del Servicio o Matenimiento");
        }

    }

    function limpiar(){
        $("#cantidad").val("1");
        $("#concepto").val("");
    }

    function evaluar(){

        if(total_cobrar > 0){
            $("#guardar").show();
        }else{
            $("#guardar").hide();
        }
    }

    function eliminar(index){
        if(cont == 0){
            inicializar()
        }
        sub_total = sub_total - subtotal[index];
        total_iva =  total_iva - iva[index];
        total_cobrar = total_cobrar - totalcobrar[index];
        $("#sub_total").html("S/. " + sub_total);
        $("#iva").html("S/. " + total_iva);
        $("#total_cobrar").html("S/. " + total_cobrar);
        $("#subventa").val(sub_total);
        $("#_iva").val(total_iva);
        $("#totalcobrar").val(total_cobrar);
        $("#fila"+index).remove();
        evaluar();
    }

</script>

@endpush
@endsection

