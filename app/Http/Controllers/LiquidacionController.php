<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liquidacion;
use Carbon\Carbon;
use App\DetalleGuia;
use App\ProductoMaster;
use App\DetalleSalida;
use App\DetailProducto;
class LiquidacionController extends Controller
{
    public function contar_dias(){
        $date=Carbon::now('America/Lima')->toDateString();
        $getDias=DetalleGuia::select('ctdetgu_fecha_reg','ctdetgu_serieProduc','ctdetgu_desc')
        ->where('ctdetgu_undmd_code','=',1)->get();
        foreach ($getDias as $key => $dia) {
            $data=(int)(((strtotime($date)-strtotime($dia->ctdetgu_fecha_reg))/86400)+1);
            if ($data>9) {
                $fecha[]=['dias'=>$data,'series'=>$dia->ctdetgu_serieProduc,'sap'=>$dia->ctdetgu_desc];
            }
        }
        //  return count($fecha);
        return response()->json(['data'=>$fecha],200);
    }
    public function seriesDevolucion(){
        $series=DetalleGuia::select('ctdetgu_serieProduc','ctdetgu_code')
        ->where('ctdetgu_undmd_code','=',1)->get();
       
        return response()->json(['data'=>$series],200);
    }
    public function devolucionProductos(Request $request)
    {
     $data=$request->serie;
     
     foreach ($data as $key => $d) {
         $numSerie= $d['Numeroserie'];
        $devolucion =DetalleGuia::where('ctdetgu_serieProduc',$numSerie)
        ->update([ 'ctdetgu_code' => 1,'ctdetgu_userSalida' => 'Ninguno']);
        $sap=DetalleGuia::where('ctdetgu_serieProduc',$numSerie)->pluck('ctdetgu_desc');
        $sapR = str_replace('["',"",$sap);
        $sapDetalle = str_replace('"]',"",$sapR);
        $stock=ProductoMaster::where('sap',$sapDetalle)->pluck('ctproduc_stock');
        $stockR = str_replace('[',"",$stock);
        $stockMaster = str_replace(']',"",$stockR);
        $aumentar=$stockMaster+1;
        $actualizarStock=ProductoMaster::where('sap',$sapDetalle)->update(['ctproduc_stock'=>$aumentar]);
        $activarDetalleProducto=DetailProducto::where('ctdetpr_serie',$numSerie)->update(['ctdetpr_esta_code'=>1]);
        $deleteSalidaSerie=DetalleSalida::where('ctdetsa_serie',$numSerie)->delete();
        }   
    }
}
