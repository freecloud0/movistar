<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailProducto;
use App\ProductoMaster;
use Illuminate\Support\Facades\Auth;
use DB;
use App\DetalleSalida;
class DetalleEquipoController extends Controller
{
    public function seriesSalida(Request $request)
    {
        // return $request;
        $data=$request->data;
        if ($data=='') {
            $series=DetalleSalida::where('ctdetsa_tipro_code',1)->get();
            
        }else{
            $series=DetalleSalida::where('ctdetsa_tipro_code',1)
            ->where(function($query) use ($data){
                $query->where('ctdetsa_sap', 'LIKE', '%'.$data.'%')
                ->orWhere('ctdetsa_serie', 'LIKE', '%'.$data.'%')
                ->orWhere('ctdetsa_fecha_reg', 'LIKE', '%'.$data.'%')
                ->orWhere('ctdetsa_traspaso', 'LIKE', '%'.$data.'%');
                })->get();
        }
        
        return ['series'=>$series];
    }
    public function MostrarSerieEquipo()
    {
        $seriestore=DetailProducto::where('ctdetpr_esta_code',0)
        ->get();
        return ['salidas'=>$seriestore];
        
    }
    public function MostrarSerieEquipo1()
    {
       
        $series1=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
        ->select('ctdetpr.ctdetpr_produc_id','ctdetpr.ctdetpr_serie as Serie','ctproduc.ctproduc_nombre',
        'ctproduc.sap')
        ->where('ctdetpr_esta_code',1)
        ->orderby('ctdetpr.ctdetpr_produc_id','desc')->get();
        return['series1'=>$series1];
    }
    public function MostrarSerieEquipo2()
    {
       
        $series2=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
        ->select('ctdetpr.ctdetpr_produc_id','ctdetpr.ctdetpr_serie as Serie','ctproduc.ctproduc_nombre',
        'ctproduc.sap')
        ->where('ctdetpr_esta_code',2)
        ->orderby('ctdetpr.ctdetpr_produc_id','desc')->get();
        return['series2'=>$series2];
    }
    public function mostrarSapEquipo(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
        //   return $request;
        $buscar =$request->buscar;
        $criterio=$request->criterio1;
        if ($buscar=='') {
            $ingresos=ProductoMaster::select('ctproduc.ctproduc_id','ctproduc.sap as SAP',
            'ctproduc.ctproduc_nombre as DESCRIPCION','ctproduc.ctproduc_stock as STOCK')
            ->where('estado','=',1)
            ->where('ctproduc_tipro_code','=',1)
            ->orderby('ctproduc.ctproduc_fecha_reg','desc')->get();
         
        }else { 
            $ingresos=ProductoMaster::select('ctproduc.ctproduc_id','ctproduc.sap',
            'ctproduc.ctproduc_nombre','ctproduc.ctproduc_stock')
            ->where('estado','=',1)
            ->where('ctproduc_tipro_code','=',1)
            ->where('ctproduc.'.$criterio,'=',$buscar)
            ->orderby('ctproduc.ctproduc_fecha_reg','desc')->get();
           
        }

         


        return [
            'ingresos'=>$ingresos
        ];
    }

    public function mostrarSapMaterial(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //   return $request;
        $buscar =$request->buscar;
        $criterio=$request->criterio1;
        if ($buscar=='') {
            $ingresos=ProductoMaster::select('ctproduc.ctproduc_id','ctproduc.sap as SAP',
            'ctproduc.ctproduc_nombre as DESCRIPCION','ctproduc.ctproduc_stock as STOCK')
            ->where('estado','=',1)
            ->where('ctproduc_tipro_code','=',2)
            ->orderby('ctproduc.ctproduc_fecha_reg','desc')->get();
         
        }else { 
            $ingresos=ProductoMaster::select('ctproduc.ctproduc_id','ctproduc.sap',
            'ctproduc.ctproduc_nombre','ctproduc.ctproduc_stock')
            ->where('estado','=',1)
            ->where('ctproduc_tipro_code','=',2)
            ->where('ctproduc.'.$criterio,'=',$buscar)
            ->orderby('ctproduc.ctproduc_fecha_reg','desc')->get();
           
        }

         


        return [
            'ingresos'=>$ingresos
        ];
    }

    public function ProductoSerie(Request $request)
    {
        // return $request;
    //    if (!$request->ajax()) return redirect('/');
    $buscar=$request->buscar;
    
        $series=DetailProducto::leftjoin('ctproduc','ctproduc_id','=','ctdetpr_produc_id')
        ->leftjoin('ctundmd as medida','ctundmd_code','=','ctproduc_undMed')
        ->leftjoin('cttipro as tipo','cttipro_code','=','ctproduc_tipro_code')
        ->leftjoin('ctcatego as categoria','ctcatego_id','=','ctproduc_catego_id')
        ->select('ctdetpr.ctdetpr_produc_id','ctdetpr.ctdetpr_serie as Serie','ctdetpr.ctdetpr_undmd_code'
        ,'ctdetpr.ctdetpr_tipro_code','ctdetpr.ctdetpr_sap','ctdetpr.ctdetpr_fecha_act'
        ,'ctdetpr.ctdetpr_usuario','ctproduc.ctproduc_id','ctproduc.ctproduc_nombre','ctproduc.sap',
        'ctproduc.ctproduc_stock','medida.ctundmd_code','medida.ctundmd_desc','categoria.ctcatego_id',
        'categoria.ctcatego_desc','tipo.cttipro_code','tipo.cttipro_desc','ctdetpr.ctdetpr_esta_code')
        // ->where('ctdetpr.ctdetpr_esta_code','=',1)
        ->where('ctproduc.ctproduc_stock','>',0)
        // ->where('ctdetpr.ctdetpr_serie','=',$buscar)
        ->get();
    
   

    
       return ['series'=>$series];
        // $series=DB::select('call ProductoSerie(?)',[$buscar]);
        // return ['series'=>$series];


        
    }
    public function todas_series(Request $request)
    {
        
            $series=DetailProducto::leftjoin('ctproduc','ctproduc_id','=','ctdetpr_produc_id')
            ->leftjoin('ctundmd as medida','ctundmd_code','=','ctproduc_undMed')
            ->leftjoin('cttipro as tipo','cttipro_code','=','ctproduc_tipro_code')
            ->leftjoin('ctcatego as categoria','ctcatego_id','=','ctproduc_catego_id')
            ->select('ctdetpr.ctdetpr_produc_id','ctdetpr.ctdetpr_serie as Serie','ctdetpr.ctdetpr_undmd_code'
            ,'ctdetpr.ctdetpr_tipro_code','ctdetpr.ctdetpr_sap','ctdetpr.ctdetpr_fecha_act'
            ,'ctdetpr.ctdetpr_usuario','ctproduc.ctproduc_id','ctproduc.ctproduc_nombre','ctproduc.sap',
            'ctproduc.ctproduc_stock','medida.ctundmd_code','medida.ctundmd_desc','categoria.ctcatego_id',
            'categoria.ctcatego_desc','tipo.cttipro_code','tipo.cttipro_desc','ctdetpr.ctdetpr_esta_code')
            // ->where('ctdetpr.ctdetpr_esta_code','=',1)
            ->where('ctproduc.ctproduc_stock','>',0)
            ->get();
            return ['series'=>$series];
        
    }
    public function procedimiento()
    {
        $cate=DB::select('call BucarSerieEquipo(?)',[$buscar]);
        return $cate;
        // call BucarSerieEquipo(224991205266);

        $series=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
        ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
        ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
        ->select('ctcatego.ctcatego_id','ctcatego.ctcatego_desc','ctundmd.ctundmd_code','ctundmd.ctundmd_desc',
        'cttipro.cttipro_code','cttipro.cttipro_desc','ctproduc.ctproduc_id','ctproduc.ctproduc_nombre',
        'ctproduc.sap','ctproduc.ctproduc_stock','ctproduc.estado','ctproduc.ctproduc_undMed') 
        ->where('ctproduc.ctproduc_stock','>',0)
        ->where('ctproduc.ctproduc_tipro_code','=',2)
        ->where('ctproduc.estado','=',1)
        ->where('ctproduc.'.$criterio,'like',$buscar.'%')
        ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
    }

  
}

