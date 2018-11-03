
@extends ('layouts.admin')
@section ('contenido')

 
  <div class="caja">
    <div class="grupoFormulario medio-12 centro">
    <h2>Detalles de la Factura Nº {{$factura->id}} </h2>
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
                {{$factura->fecha_creacion}} {{$factura->hora}}
            </div>

        </div>

        <hr>
        <div class="cuadrado">              
            <div class="formularioNivel">
                <div class="grupoFormulario medio-4">
                    <label for="inputEmail4">Nombre</label>
                    <p>{{$factura->nombre}}</p>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputPassword4">Apellido</label>
                   <p>{{$factura->apellido}}</p>
                </div>
                <div class="grupoFormulario medio-4">
                    <label for="inputAddress">Cedula</label>
                    <p>{{$factura->cedula}}</p>
                </div>
            </div>

        </div>

                


        <div class="tabla-responsive ">
            <table  id ="detalles" class="tabla">
                <thead>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Concepto</th>
                    <th>Precio Total</th>
                    <th>12%IVA</th>
                    <th>Precio Total + 12%IVA</th>
                </thead>
                <tbody>
                @foreach($gastos as $gasto)
                    <tr>
                        <td>{{$gasto->nombre_producto}}</td>
                        <td>{{$gasto->precio_unitario}}</td>
                        <td>{{$gasto->cantidad}}</td>
                        <td>{{$gasto->concepto}}</td>
                        <td>{{$gasto->precio_prducto}}</td>
                        <td>{{$gasto->precio_iva}}</td>
                        <td>{{$gasto->precio_total_producto}}</td>
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
                        <h4 id="sub_total">S/. {{$factura->sub_total}}</h4> 
                    </th>
                    <th>
                        <h4 id="iva">S/. {{$factura->total_impuesto}}</h4> 
                    </th>
                    <th>
                        <h4 id="total_cobrar">S/. {{$factura->total}}</h4> 
                    </th>
                    <th></th>
                </tfoot>
            </table>
        </div>

@endsection
