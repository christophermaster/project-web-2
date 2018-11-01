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
          /*  $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','dv.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante',
            'v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado',
            'v.total_venta')
            ->where('v.num_comprobante','LIKE','%'.$query.'%')
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante',
            'v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->paginate(7);*/
           return Redirect::to('app/factura/create');
        }
    }


    public function create()
    {
        $productos=DB::table('productos as pro')->select('pro.*')->get();
        
        $numero = DB::table('facturas as factura')
            ->select("factura.id")
            ->orderBy('factura.id','desc')
            ->get()
            ->first();
       
        $numero += 1;
        $hoy = date('Y-m-d');
        
        return view("factura.create",["productos"=>$productos,"numero"=>$numero,"hoy"=>$hoy]);
    }

    public function store (Request $request)
    {
        try {
            DB::beginTransaction();
            $cliente = new Cliente;
            $factura = new Factura;
            $gasto = new Gasto;

            $id = "";
            $hoy = date('Y-m-d');

            $clientes = DB::table('clientes as cliente')
            ->select("cliente.*")
            ->where("cliente.cedula","=",$request->get("cedula"))
            ->get();
            $id = $clientes->id;

            if(count($clientes) == 0){
                $cliente->nombre = $request->get("nombre");
                $cliente->apellido = $request->get("apellido");
                $cliente->cedula = $request->get("cedula");
                $cliente->save();
                $id = $cliente->id;
            }

            $factura->id_cliente = $id;
            $factura->total = $request->get("total_cobrar");
            $factura->total = $request->get("sub_venta");
            $factura->total = $request->get("iva");
            $factura->hora = $request->get("iva");
            $factura->fechra_creacion = $request->get("iva");
            $factura->fechra_modificacion = $request->get("iva");
            

            
           /* $venta = new Venta;

            $venta->idcliente=$request->get('idcliente');
            $venta->tipo_comprobante=$request->get('tipo_comprobante');
            $venta->serie_comprobante=$request->get('serie_comprobante');
            $venta->num_comprobante=$request->get('num_comprobante');
            $venta->total_venta=$request->get('total_venta');
            $mytime = Carbon::now('America/Bogota');
            $venta->fecha_hora=$mytime->toDateTimeString();
            $venta->impuesto = '19';
            $venta->estado = 'A';
            $venta->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');   
            $descuento = $request->get('descuento');         
            $precio_venta = $request->get('precio_venta');
            

            $cont = 0;

            while ($cont<count($idarticulo)) {
                $detalle=new DetalleVenta();
                $detalle->idventa=$venta->idventa;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }*/

            DB::commit();
        } catch (Exception $e) 
        {
            DB::rollback();
        }

        return Redirect::to('app/factura/create');
    }

    public function show(Request $request)
    {
       
    }

    public function destroy($id)
    {
        $venta= Venta::findOrFail($id);
        $venta->Estado='C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
}
