@extends('layouts.admin')
@section('contenido')

    <div class="caja" >
        <div class="nivel">
            <a href = "{{ URL::previous() }}">
                <button class="myButton"><i class="fa fa-long-arrow-left"></i>  Atras</button>
            </a>
        </div>
    </div>

    <section>
        <div class="caja">

            <div class="extra-pequeño-12 pequeno-12 medio-12 grande-12 centro">
                <h2>Lista De Facturas</h2>
            </div>
            <hr>

        </div>
        <div class="caja">
            <div class="nivel">
                <div class="extra-pequeño-6 pequeno-12 medio-6 grande-6">
                    
                </div>
                <div class="extra-pequeño-6 pequeno-12 medio-6 grande-6">
                    @include('factura.search')
                </div>
            </div>
            <hr>

            <div class="nivel">
                <div class="extra-pequeño-12 pequeno-12 medio-4 grande-4">
                    <div class="carta">
                        <h6 class="carta-cabecera impresa">Facturas Impresas</h6>
                        <div class="carta-cuerpo">
                        </div>
                    </div>
                </div>
                <div class="extra-pequeño-12 pequeno-12 medio-4 grande-4">
                    <div class="carta">
                        <h6 class="carta-cabecera noImpresa">Facturas No Impresas</h6>
                        <div class="carta-cuerpo">
                        </div>
                    </div>
                </div>
                <div class="extra-pequeño-12 pequeno-12 medio-4 grande-4">
                    <div class="carta">
                        <h6 class="carta-cabecera anulada">Facturas Anuladas</h6>
                        <div class="carta-cuerpo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="nivel">
            

            @foreach($factura as $fact)
            @if($fact->impresa == 1 && $fact->Anular == 0)
                <div class=" extra-pequeño-4 pequeno-6 medio-4 grande-4">
                    <div class="carta">
                        <h5 class="carta-cabecera impresa">Factura Nº {{$fact->id}} </h5>
                        <div class="carta-cuerpo">
                            <h6 class="carta-title">Impresa: Si </h6>
                            <p>factura de:</p>
                            <p><b>Nombre: </b>{{$fact->nombre}}</p>
                            <p><b>Apellido: </b>{{$fact->apellido}}</p>
                            <div class="carta-footer">                             
                                <a href = "{{URL::action('FacturaController@show', $fact->id)}}">
                                    <button class="myButton">Detalle</button>
                                </a>
                                <a data-target="#modal-delete-{{$fact->id}}" data-toggle="modal">
                                    <button class="myButton">Anular</button>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @include('factura.modal')
            @elseif($fact->impresa == 0 && $fact->Anular == 0)
            <div class=" extra-pequeño-4 pequeno-6 medio-4 grande-4">
                    <div class="carta">
                        <h5 class="carta-cabecera noImpresa">Factura Nº {{$fact->id}}</h5>
                        <div class="carta-cuerpo">
                            <h6 class="carta-title">Impresa: No</h6>
                            <p>factura de:</p>
                            <p><b>Nombre: </b>{{$fact->nombre}}</p>
                            <p><b>Apellido: </b>{{$fact->apellido}}</p>
                            <div class="carta-footer">
                                <a href = "{{URL::action('FacturaController@show', $fact->id)}}">
                                    <button class="myButton">Detalle</button>
                                </a>
                                <a href = "{{URL::action('FacturaController@edit', $fact->id)}}">
                                    <button class="myButton">editar</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            @elseif($fact->Anular == 1)
                <div class=" extra-pequeño-4 pequeno-6 medio-4 grande-4">
                    <div class="carta">
                        <h5 class="carta-cabecera anulada">Factura Nº {{$fact->id}}</h5>
                        <div class="carta-cuerpo">
                            <h6 class="carta-title">Impresa: X</h6>
                            <p>factura de:</p>
                            <p><b>Nombre: </b>{{$fact->nombre}}</p>
                            <p><b>Apellido: </b>{{$fact->apellido}}</p>
                            <div class="carta-footer">
                                <a href = "{{URL::action('FacturaController@show', $fact->id)}}">
                                    <button class="myButton">Detalle</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach

                
            </div>
        </div>
    </section>

@endsection