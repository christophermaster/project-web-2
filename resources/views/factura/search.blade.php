{!! Form::open(array('url' => 'app/factura' , 'method'=> 'Get','autocomplete' =>'off','role' => 'search'))!!}
 <div class="search">
    <form class="search-form">
        <input type="text" placeholder="Buscar por nombre de Cliente " value ="{{$searchText}}" name = "searchText">
        <input type="submit" value="Buscar">
    </form>
</div>
{{Form::close()}}