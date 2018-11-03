<?php

namespace factura\Http\Controllers;

use Illuminate\Http\Request;


use factura\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection; 
use factura\Http\Requests\FacturaFormRequest;
use factura\models\Cliente;
use factura\models\Factura;                               
use factura\models\Gasto;
use factura\models\Producto;  

use Carbon\Carbon; // Control de fechas
use Response;
use DB;

class FacturaController extends Controller
{
    public function __construct()
    {
        
    }

    # Función index.

     public function index(Request $request)
    {
        if ($request)
        {
           $query=trim($request->get('searchText'));
           $factura=DB::table('facturas as f')
            ->join('clientes as c','f.id_cliente','=','c.id')
            ->select('c.nombre as nombre','c.apellido as apellido','f.*')
            ->where('c.nombre','LIKE','%'.$query.'%')
            ->orderBy('f.id','desc')
            ->get();
          return view('factura.index',["factura"=>$factura,"searchText"=>$query]);
        }
    }


    public function create()
    {
        $productos=DB::table('productos as pro')->select('pro.*')->get();
        
        $numeros = DB::table('facturas as factura')
            ->select("factura.id")
            ->orderBy('factura.id','desc')
            ->get()
            ->first();
       if($numeros == null){
         $numero = 1;
       }else{
        $numero = $numeros->id + 1;
       }
        
        $hoy = date('Y-m-d');
        
        return view("factura.create",["productos"=>$productos,"numero"=>$numero,"hoy"=>$hoy]);
    }

    public function store (Request $request)
    {
        try {
            DB::beginTransaction();
            $cliente = new Cliente;
            $factura = new Factura;
            

            $id = "";
            $hoy = date('Y-m-d');
            $hora = date('h:i:s A');
            
            $cont = 0;

            $clientes = DB::table('clientes as cliente')
            ->select("cliente.id")
            ->where("cliente.cedula","=",$request->get("cedula"))
            ->get();
            if(count($clientes) != 0){
               $client = $clientes->first();
                $id = $client->id;
            }
            

            if(count($clientes) == 0){
                $cliente->nombre = $request->get("nombre");
                $cliente->apellido = $request->get("apellido");
                $cliente->cedula = $request->get("cedula");
                $cliente->save();
                $id = $cliente->id;
            }

            $factura->id_cliente = $id;
            $factura->total = $request->get("total_cobrar");
            $factura->sub_total = $request->get("sub_venta");
            $factura->total_impuesto = $request->get("iva");
            $factura->hora = $hora;
            $factura->fecha_creacion = $hoy;
            $factura->fecha_modificacion = $hoy;
            $factura->Anular = 0;
            if($request->get("imprimir") == 'Si'){
                $factura->impresa = 1;
            }else{
                $factura->impresa = 0;
            }
            
            $factura->save();

            $concepto =  $request->get("comentarios");
            $id_producto = $request->get("id_productoss");
            $precio_unitario = $request->get("precio_ventas");
            $iva = $request->get("ivas");
            $precio_prducto = $request->get("sub_totales");
            $cantidad = $request->get("cantidades");
            $precio_total_producto = $request->get("totales_cobrar");
          
            
            while ($cont < count($id_producto)) {
                $gasto = new Gasto;
                $productos = Producto::findOrFail($id_producto[$cont]);
                $gasto->id_factura = $factura->id;
                $gasto->concepto = $concepto[$cont];
                $gasto->id_productos = $id_producto[$cont];
                $gasto->nombre_producto = $productos->nombre;
                $gasto->precio_prducto = $precio_prducto[$cont];
                $gasto->precio_unitario = $precio_unitario[$cont];
                $gasto->cantidad = $cantidad[$cont];
                $gasto->precio_total_producto = $precio_total_producto[$cont];
                $gasto->precio_iva = $iva[$cont];
                $gasto-> save();
                $cont=$cont+1;

            }

            DB::commit();
        } catch (Exception $e) 
        {
            DB::rollback();
        }

        return Redirect::to('app/factura/create');
    }

    public function show($id)
    {
        $factura=DB::table('facturas as f')
            ->join('clientes as c','f.id_cliente','=','c.id')
            ->select('c.cedula as cedula','c.nombre as nombre','c.apellido as apellido','f.*')
            ->where('f.id','=',$id)
            ->get()->first();
        $gastos=DB::table('gastos as g')
        ->select('g.*')
        ->where('g.id_factura','=',$id)
        ->get();
        return view("factura.show",["factura"=>$factura,"gastos"=>$gastos]);
    }
    public function edit($id){

        $productos=DB::table('productos as pro')->select('pro.*')->get();

        $factura=DB::table('facturas as f')
            ->join('clientes as c','f.id_cliente','=','c.id')
            ->select('c.cedula as cedula','c.nombre as nombre','c.apellido as apellido','f.*')
            ->where('f.id','=',$id)
            ->get()->first();
        $gastos=DB::table('gastos as g')
        ->select('g.*')
        ->where('g.id_factura','=',$id)
        ->get();
        return view("factura.edit",["factura"=>$factura,"gastos"=>$gastos,"productos"=>$productos]);

    }

    public function update(Request $request, $id){

        try {

            DB::beginTransaction();
            $factura = Factura::findOrFail($id);
            
            $hoy = date('Y-m-d');
            $hora = date('h:i:s A');
            $cont = 0;
        
            $factura->total = $request->get("total_cobrar");
            $factura->sub_total = $request->get("sub_venta");
            $factura->total_impuesto = $request->get("iva");
            $factura->hora = $hora;
            $factura->fecha_modificacion = $hoy;

            if($request->get("imprimir") == 'Si'){
                $factura->impresa = 1;
            }else{
                $factura->impresa = 0;
            }

            $factura->update();

            $gastos=DB::table('gastos as g')
            ->select('g.id as id')
            ->where('g.id_factura','=',$id)
            ->get();

            while ($cont < count($gastos)){
               
                Gasto::destroy($gastos[$cont]->id);
                $cont = $cont + 1;
            }

            $concepto =  $request->get("comentarios");
            $id_producto = $request->get("id_productoss");
            $precio_unitario = $request->get("precio_ventas");
            $iva = $request->get("ivas");
            $precio_prducto = $request->get("sub_totales");
            $cantidad = $request->get("cantidades");
            $precio_total_producto = $request->get("totales_cobrar");

            $cont = 0;
          
            while ($cont < count($id_producto)) {
                $gasto = new Gasto;
                $productos = Producto::findOrFail($id_producto[$cont]);
                $gasto->id_factura = $factura->id;
                $gasto->concepto = $concepto[$cont];
                $gasto->id_productos = $id_producto[$cont];
                $gasto->nombre_producto = $productos->nombre;
                $gasto->precio_prducto = $precio_prducto[$cont];
                $gasto->precio_unitario = $precio_unitario[$cont];
                $gasto->cantidad = $cantidad[$cont];
                $gasto->precio_total_producto = $precio_total_producto[$cont];
                $gasto->precio_iva = $iva[$cont];
                $gasto-> save();
                $cont=$cont+1;

            }

            DB::commit();
        } catch (Exception $e) 
        {
            DB::rollback();
        }

        return Redirect::to('app/factura/'.$id);
     
    }

    public function destroy($id)
    {
    
         try {

            DB::beginTransaction();
            $factura = Factura::findOrFail($id);
            $factura->Anular = 1;
            $factura->update();

            $hoy = date('Y-m-d');
            $hora = date('h:i:s A');
            $cont = 0;

            $factura_nueva = new Factura();

            $factura_nueva->id_cliente = $factura->id_cliente;
            $factura_nueva->total = $factura->total;
            $factura_nueva->sub_total = $factura->sub_total;
            $factura_nueva->total_impuesto = $factura->total_impuesto;
            $factura_nueva->hora = $factura->hora;
            $factura_nueva->fecha_modificacion = $factura->fecha_modificacion;
            $factura_nueva->fecha_creacion = $factura->fecha_creacion;
            $factura_nueva->impresa = $factura->impresa;
            $factura_nueva->Anular = 0;

            $factura_nueva->save();

            $gastos=DB::table('gastos as g')
            ->select('g.*')
            ->where('g.id_factura','=',$id)
            ->get();

            while ($cont < count($gastos)) {
                $gasto = new Gasto;
                $gasto->id_factura = $factura_nueva->id;
                $gasto->concepto = $gastos[$cont]->concepto;
                $gasto->id_productos = $gastos[$cont]->id_productos;
                $gasto->nombre_producto = $gastos[$cont]->nombre_producto;
                $gasto->precio_prducto = $gastos[$cont]->precio_prducto;
                $gasto->precio_unitario = $gastos[$cont]->precio_unitario;
                $gasto->cantidad = $gastos[$cont]->cantidad;
                $gasto->precio_total_producto = $gastos[$cont]->precio_total_producto;
                $gasto->precio_iva = $gastos[$cont]->precio_iva;
                $gasto-> save();
                $cont=$cont+1;

            }

            DB::commit();
        } catch (Exception $e) 
        {
            DB::rollback();
        }

        return Redirect::to('app/factura/'.$factura_nueva->id.'/edit');
    }
}
