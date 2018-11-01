<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Producto;
use App\DetailProducto;
use App\DetalleGuia;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Comprobante;
use App\ProductoMaster;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DetalleIngresoController extends Controller
{
    public function index(Request $request)
    {
        // return $request;
    //   if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $productos=DetalleGuia::join('ctundmd','ctundmd_code','=','ctdetgu_undmd_code')
            ->select('ctdetgu_indice','ctdetgu_nro','ctdetgu_serie','ctdetgu_prove_code','ctdetgu_produc_id','ctdetgu_code',
            'ctdetgu_desc','ctdetgu_serieProduc','ctdetgu_cantidad','ctdetgu_undmd_code','ctdetgu_fecha_reg','ctdetgu_fecha_act',
            'ctdetgu_usuario','ctundmd.ctundmd_code','ctundmd.ctundmd_desc')
            ->orderby('ctdetgu.ctdetgu_indice','desc')
            ->get();
        }else { 
            $productos=DetalleGuia::join('ctundmd','ctundmd_code','=','ctdetgu_undmd_code')
            ->select('ctdetgu_indice','ctdetgu_nro','ctdetgu_serie','ctdetgu_prove_code','ctdetgu_produc_id','ctdetgu_code',
            'ctdetgu_desc','ctdetgu_serieProduc','ctdetgu_cantidad','ctdetgu_undmd_code','ctdetgu_fecha_reg','ctdetgu_fecha_act',
            'ctdetgu_usuario','ctundmd.ctundmd_code','ctundmd.ctundmd_desc')
            ->where('ctdetgu.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetgu.ctdetgu_indice','desc')
            ->get();
           
        }
        return [
            
            'productos'=>$productos
        ];
    }

    public function detalleProducto(Request $request)
    {
     
         if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio3;
        if ($buscar=='') {
            
            $productos=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctdetpr.ctdetpr_undmd_code')
            ->join('cttipro','cttipro.cttipro_code','=','ctdetpr.ctdetpr_tipro_code')
            ->select('ctproduc.ctproduc_id','cttipro.cttipro_code','ctundmd.ctundmd_code','ctproduc.ctproduc_nombre',
            'ctdetpr.ctdetpr_serie','ctundmd.ctundmd_desc','ctdetpr.ctdetpr_mac1','ctdetpr.ctdetpr_mac2',
            'ctdetpr.ctdetpr_mac3','ctdetpr.ctdetpr_sap','ctdetpr.ctdetpr_fecha_act','ctdetpr.ctdetpr_usuario')
            ->orderby('ctdetpr.ctdetpr_fecha_act','desc')->paginate(10);
            
        }else {
            $productos=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctdetpr.ctdetpr_undmd_code')
            ->join('cttipro','cttipro.cttipro_code','=','ctdetpr.ctdetpr_tipro_code')
            ->select('ctproduc.ctproduc_id','cttipro.cttipro_code','ctundmd.ctundmd_code','ctproduc.ctproduc_nombre',
            'ctdetpr.ctdetpr_serie','ctundmd.ctundmd_desc','ctdetpr.ctdetpr_mac1','ctdetpr.ctdetpr_mac2',
            'ctdetpr.ctdetpr_mac3','ctdetpr.ctdetpr_sap','ctdetpr.ctdetpr_fecha_act','ctdetpr.ctdetpr_usuario')
            ->where('ctdetpr.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetpr.ctdetpr_fecha_act','desc')->paginate(10);
          

            
           
        }

         


        return [
            'pagination'=>[
                    'total'=>$productos->total(),
                    'current_page'=>$productos->currentPage(),
                    'per_page'=>$productos->perPage(),
                    'last_page'=>$productos->lastPage(),
                    'from'=>$productos->firstItem(),
                    'to'=>$productos->lastItem(),
            ],
            'productos'=>$productos
        ];
    }
    public function buscarSapEqui(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //   return $request;
        $buscar =$request->buscar;
            $ingresos=DB::select('call buscarSapEqui(?)',[$buscar]);
            return ['ingresos'=>$ingresos];
         

      
    }
    public function buscarSapMate(Request $request)
    {

         if (!$request->ajax()) return redirect('/');
        //   return $request;
        $buscar =$request->buscar;
        
            $ingresos=DB::select('call buscarSapMate(?)',[$buscar]);
            return ['ingresos'=>$ingresos];

    }
    public function mostrarSerie(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //  return $request;
        $buscar =$request->buscarSerie;
        $criterio=$request->criterio2;
        if ($buscar=='') {
            $ingresos=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctdetpr.ctdetpr_undmd_code')
            ->join('cttipro','cttipro.cttipro_code','=','ctdetpr.ctdetpr_tipro_code')
            ->select('ctproduc.ctproduc_id','ctundmd.ctundmd_desc','cttipro.cttipro_desc','ctdetpr.ctdetpr_serie','ctdetpr.ctdetpr_esta_code',
            'ctdetpr.ctdetpr_mac1','ctdetpr.ctdetpr_mac2','ctdetpr.ctdetpr_mac3','ctdetpr.ctdetpr_lote','ctdetpr.ctdetpr_sap','ctdetpr.ctdetpr_stock',
            'ctdetpr.ctdetpr_fecha_reg','ctdetpr.ctdetpr_fecha_act','ctdetpr.ctdetpr_usuario');
            //  ->orderby('ctdetpr.ctdetpr_fecha_reg','desc')->paginate(5);
        }else { 
            $ingresos=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctdetpr.ctdetpr_undmd_code')
            ->join('cttipro','cttipro.cttipro_code','=','ctdetpr.ctdetpr_tipro_code')
            ->join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
            ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_id','ctcatego.ctcatego_desc','ctproduc.sap','ctdetpr.ctdetpr_serie',
            'ctproduc.ctproduc_nombre','ctdetpr.ctdetpr_stock','ctdetpr.ctdetpr_undmd_code','ctdetpr.ctdetpr_tipro_code')
            ->where('ctdetpr.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetpr.ctdetpr_fecha_reg','desc')->paginate(10);
           
        }

         


        return [
            'ingresos'=>$ingresos
        ];
    }
    public function store(Request $request)
    {
            //   return $request;
        
            if (!$request->ajax()) return redirect('/');
            $request->validate([
                'ctgurem_nro' => 'unique:ctgurem',
                'ctgurem_serie' => 'unique:ctgurem',
            ]);
            //Registro de Comprobante
            $comprobantes=new Comprobante();
            $comprobantes->ctgurem_nro=$request->ctgurem_nro;
            $comprobantes->ctgurem_serie=$request->ctgurem_serie;
            $comprobantes->ctgurem_fecha_registro=$request->fecha;
            $comprobantes->save();
            //Registro de Detalle de producto
            $producdetalles=request()->data;
            
            foreach ($producdetalles as $ep => $det) {
                // verificar tipo de producto
               $tipo=$det['idtipro'];
               if ($tipo==1) {
                $producdetalles=new DetailProducto();
                $producdetalles->ctdetpr_produc_id=$det['prodid'];
                $producdetalles->ctdetpr_serie=$det['ctdetpr_serie'];
                $producdetalles->ctdetpr_undmd_code=$det['idundmed'];
                $producdetalles->ctdetpr_tipro_code=$det['idtipro'];
                // $producdetalles->ctdetpr_mac1=$det['mac1'];
                // $producdetalles->ctdetpr_mac2=$det['mac2'];
                // $producdetalles->ctdetpr_mac3=$det['mac3'];
                $producdetalles->ctdetpr_sap=$det['prod01'];
                $producdetalles->ctdetpr_fecha_reg=$request->fecha;
                $producdetalles->ctdetpr_usuario=Auth::user()->ctusuar_usuario;
                $producdetalles->save();

                 // Actualiza Stock de Master Producto
                 $sap=$det['prod01'];
                 $sapBD = ProductoMaster::where('sap', '=', $sap)->select('sap')->get();
                 $sapBDjson = str_replace('[{"sap":"',"",$sapBD);
                 $sapBDjson1 = str_replace('"}]',"",$sapBDjson);
 
                 if ($sap==$sapBDjson1) {
                     $cantidadResponse=1;
                     $cantidadBD = ProductoMaster::where('sap',$sap)->max('ctproduc_stock');
                     $suma=$cantidadResponse + $cantidadBD;
                     $newCantidad =ProductoMaster::where('sap', $sap)->update(['ctproduc_stock' => $suma]);
                 
                 }
                
               }else if($tipo==2) {
                   // Actualiza Stock de Master Producto
                 $sap=$det['prod01'];
                 $sapBD = ProductoMaster::where('sap', '=', $sap)->select('sap')->get();
                 $sapBDjson = str_replace('[{"sap":"',"",$sapBD);
                 $sapBDjson1 = str_replace('"}]',"",$sapBDjson);
                 $cantidad=$det['canti'];
                 if ($sap==$sapBDjson1) {
                     $cantidadResponse=$cantidad;
                     $cantidadBD = ProductoMaster::where('sap',$sap)->max('ctproduc_stock');
                     $suma=$cantidadResponse + $cantidadBD;
                     $newCantidad =ProductoMaster::where('sap', $sap)->update(['ctproduc_stock' => $suma]);
                 
                 }
               }
               
                $detguias=new DetalleGuia();
                $idet=DetalleGuia::max('ctdetgu_indice');
                $idetmas=$idet+1;
                if ($tipo==1) {
                    $cantidadResponseif=1;
                }else if($tipo==2){
                    $cantidad=$det['canti'];
                    $cantidadResponseif=$cantidad;
                }
                $detguias->ctdetgu_indice=$idetmas;
                $detguias->ctdetgu_nro=$request->ctgurem_nro;
                $detguias->ctdetgu_prove_code=$request->proveedor_id;
                $detguias->ctdetgu_serie=$request->ctgurem_serie;
                $detguias->ctdetgu_produc_id=$det['prodid'];
                $detguias->ctdetgu_desc=$det['prod01'];
                $detguias->ctdetgu_cantidad=$cantidadResponseif;
                $detguias->ctdetgu_serieProduc=$det['ctdetpr_serie'];
                $detguias->ctdetgu_undmd_code=$det['idundmed'];
                $detguias->ctdetgu_fecha_reg=$request->fecha;
                $detguias->ctdetgu_usuario=Auth::user()->ctusuar_usuario;
                $detguias->save();
                              
            }
            
            
            return response()->json('Registrado Correctamente', 200);
          
    }

    public function mostrarGuias(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
        //   return $request;
      
            $ingresos=DetalleGuia::select('ctdetgu_serie')->get();
            return [ 'ingresos'=>$ingresos];
    }

    public function AdminNotificacion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
   
        
            $productos=DetalleGuia::select(
            'ctdetgu_desc','ctdetgu_serieProduc','ctdetgu_fecha_reg')
            ->where('ctdetgu_undmd_code','=',1)
            ->paginate(10);
            
        return [
            'pagination'=>[
                    'total'=>$productos->total(),
                    'current_page'=>$productos->currentPage(),
                    'per_page'=>$productos->perPage(),
                    'last_page'=>$productos->lastPage(),
                    'from'=>$productos->firstItem(),
                    'to'=>$productos->lastItem(),
            ],
            'productos'=>$productos
        ];
    }
}
