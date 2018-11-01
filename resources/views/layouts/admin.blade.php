<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scal">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/estilos.css')}}" />
    <link href="{{url('https://fonts.googleapis.com/css?family=Roboto')}}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <header class="menu">
        <input id="toggle" type="checkbox" />
        <label for="toggle" class="drop">
            <svg width="20px" height="20px" viewBox="0 0 48 48">
                <path d="M6 36h36v-4H6v4zm0-10h36v-4H6v4zm0-14v4h36v-4H6z"></path>
            </svg>
        </label>
        <nav>
            <a href="{{url('almacen/categoria/create')}}">Facturar</a>
            <a href="listaFactura.html">Lista de Factura</a>
        </nav>

    </header>

    <br><br>

    <!--Contenido-->
    @yield('contenido')
    <!--Fin Contenido-->

</body>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
@stack('scripts');
</html>