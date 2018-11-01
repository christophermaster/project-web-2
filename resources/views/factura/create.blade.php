@extends ('layouts.admin')
@section ('contenido')
 <div class="caja">

        <div class="nivel">
            <div class="extra-pequeño-4 pequeno-4 medio-4 grande-4 centro">
                Factura
            </div>
            <div class="extra-pequeño-4 pequeno-4 medio-4 grande-4 centro">
                Nº {{$numero}}
            </div>
            <div class="extra-pequeño-4 pequeno-4 medio-4 grande-4 centro">
                {{$hoy}}
            </div>

        </div>

        <hr>
{!!Form::open(array('url'=>'app/factura','method'=>'POST','autocomplete'=>'off'))!!}
{{Form::token()}}
        <div class="cuadrado">
            <div class="formularioNivel">
                <div class="grupoFormulario medio-4">
                    <label for="inputEmail4">Nombre</label>
                    <input type="nombre" name ="nombre" class="formularioPrincipal" 
                    id="inputEmail4" placeholder="Nombre" required>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Apellido</label>
                    <input type="text"  name ="apellido" class="formularioPrincipal" 
                    id="inputPassword4" placeholder="Apellido" required>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputAddress">Cedula</label>
                    <input type="number" name ="cedula" class="formularioPrincipal" 
                    id="inputAddress" placeholder="1234567" required>
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
                        <h4 id="sub_total">S/. 0.00</h4> 
                        <input type="hidden" name="sub_venta" id="subventa">
                    </th>
                    <th>
                        <h4 id="iva">S/. 0.00</h4> 
                        <input type="hidden" name="iva" id="subventa">
                    </th>
                    <th>
                        <h4 id="total_cobrar">S/. 0.00</h4> 
                        <input type="hidden" name="total_cobrar" id="totalcobrar"></th>
                    <th></th>
                </tfoot>
            </table>
        </div>

        <div class="cuadrado">
            <div class="formularioNivel">
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Producto</label>
                    <select name="id_producto" id="id_producto" class="select" data-live-search = "true">
                        <option value="0">Seleccione Producto</option>
                        @foreach($productos as $pro)
                        <option value="{{$pro->id}}_{{$pro->precio_unitario}}">{{$pro->nombre}}</option>
                        @endforeach
                    </select>
                    
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Precio Unitario</label>
                    <input type="number" name="precio_unitario" id="precio_unitario" class="formularioPrincipal" placeholder="Cantidad" disabled>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Cantidad</label>
                    <input type="number" class="formularioPrincipal" id="cantidad" name="cantidad" placeholder="Cantidad" min=1 value="1">
                </div>
            </div>

            <div class="formularioNivel">
                <div class="grupoFormulario medio-12">
                    <label for="inputEmail4">Concepto</label>
                    <input type="email" class="formularioPrincipal" name="concepto" id="concepto" placeholder="Concepto">
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
                    <input type="radio" class="form-check-input" name="option" required>Si
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="option" required>No
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="caja">
        <div class="nivel ce" id="guardar">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="grupoFormulario medio-6 centro">
                <button class="insertar" type="submit" >Guardar</button>
            </div>
            <div class=" medio-6 centro">
                <a href="index.html" class="insertar">Cancelar</a>
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

    var cont = 0;
    //lleva la suma total de toda las fila
    sub_total = 0;
    total_iva = 0;
    total_cobrar = 0;

    //lleva la suma por fila 
    subtotal = [];
    iva = [];
    totalcobrar = [];

    $("#guardar").hide();
    $("#id_producto").change(mostrarValores);

    function mostrarValores(){
        datosArticulo = document.getElementById('id_producto').value.split('_');
        $('#precio_unitario').val(datosArticulo[1]);
    }


    function agregar(){
        datosArticulo = document.getElementById('id_producto').value.split('_');
       
        idarticulo = datosArticulo[0];
        articulo = $("#id_producto option:selected").text();
        cantidad = parseInt($("#cantidad").val());
        descuento = 0;
        precio_venta = $("#precio_unitario").val(); 
     
        comentario = $("#concepto").val(); 
        if(idarticulo != "" && cantidad != "" && cantidad > 0  && concepto != "" ){
                     
            subtotal[cont] = (cantidad*precio_venta);
            iva[cont] = Math.round(subtotal[cont] * 0.12);
            totalcobrar[cont] =  subtotal[cont] + iva[cont];

            sub_total = sub_total + subtotal[cont];
            total_iva =  total_iva + iva[cont];
            total_cobrar = total_cobrar + totalcobrar[cont];


         var fila ='<tr class ="selected" id="fila'+cont+'">'
        +'<td><input type ="hidden" name ="id_producto[]" value = "'+idarticulo+'">'+articulo+'</td>'
        +'<td><input type ="hidden" name ="precio_venta[]" value = "'+precio_venta+'">'+precio_venta+'</td>'
        +'<td><input type ="hidden" name ="cantidad[]" value = "'+cantidad+'">'+cantidad+'</td>'
        +'<td><input type ="hidden" name ="comentario[]" value = "'+comentario+'">'+comentario+'</td>'
        +'<td><input type ="hidden" name ="subtotal[]" value = "'+subtotal[cont]+'">'+subtotal[cont]+'</td>'
        +'<td><input type ="hidden" name ="iva[]" value = "'+iva[cont]+'">'+iva[cont]+'</td>'
        +'<td><input type ="hidden" name ="totalcobrar[]" value = "'+totalcobrar[cont]+'">'+totalcobrar[cont]+'</td>'
        +'<td><button type = "button" class= "btn btn-warning" onclick = "eliminar('+cont+')">X</button></td>'
        +'</tr>';
            cont ++ ;
            limpiar();
            $("#sub_total").html("S/. " +sub_total);
            $("#iva").html("S/. " + total_iva);
            $("#total_cobrar").html("S/. " + total_cobrar);
            $("#subventa").val(total_cobrar);
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
        sub_total = sub_total - subtotal[index];
        total_iva =  total_iva - iva[index];
        total_cobrar = total_cobrar - totalcobrar[index];
        $("#sub_total").html("S/. " + sub_total);
        $("#iva").html("S/. " + total_iva);
        $("#total_cobrar").html("S/. " + total_cobrar);
        $("#total_venta").val(total_cobrar);
        $("#fila"+index).remove();
        evaluar();
    }
</script>

@endpush
@endsection

