<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salida;
use App\Sot;
use App\User;
use App\DetailProducto;
use App\Categoria;
use App\ProductoMaster;
use Carbon\Carbon;
use App\DetalleSalida;
use Illuminate\Support\Facades\Auth;
class ReporteController extends Controller
{
    
    public function reporteTraspasoEquipo(Request $request)
    {
        // return $request;
        // reporte traspaso por dia
        // if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateString();
        $fecha =$request->fecha;
        // return $fecha.$date;
        $criterio=$request->criterio;
        if ($fecha==$date) {
               
            $almacen=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario as Usuario','ctdetsa.ctdetsa_indice',
            'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso as Usuario Recepción',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_reg'
            ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg','ctdetsa.ctdetsa_observacion',
            'ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_cantidad_traspaso')
            ->where('ctdetsa.ctdetsa_tipro_code','=',1)
            ->where('ctdetsa.ctdetsa_fecha_traspaso','=',$date)
            ->wherenotnull('ctdetsa.ctdetsa_observacion')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->get();
            
        }else {
            $almacen=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario as Usuario','ctdetsa.ctdetsa_indice',
            'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso as Usuario Recepción',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_reg'
            ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg','ctdetsa.ctdetsa_observacion',
            'ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_cantidad_traspaso')
            ->where('ctdetsa.ctdetsa_tipro_code','=',1)
            ->where('ctdetsa.ctdetsa_fecha_traspaso','=',$fecha)
            ->wherenotnull('ctdetsa.ctdetsa_observacion')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->get();
        }

        $cont=DetalleSalida::where('ctdetsa.ctdetsa_fecha_traspaso','=',$date)->count();

        return with(['almacen'=>$almacen,'contarEqui' => $cont]) ;

        
    }

    public function reporteLiquidacionEquipo(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
         
        $date =Carbon::now('America/Lima')->toDateString();
        $fecha =$request->fecha1;
        // return $fecha.$date;
        $criterio=$request->criterio;
        if ($fecha==$date) {
               
            $almacen=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
            ->select('ctdetpr.ctdetpr_serie','ctdetpr.ctdetpr_sap','ctproduc.ctproduc_nombre'
            ,'ctdetpr.ctdetpr_esta_equi','ctproduc.ctproduc_stock')
            ->where('ctdetpr.ctdetpr_tipro_code','=',1)
            ->where('ctdetpr.ctdetpr_esta_code','=',0)
            ->where('ctdetpr.ctdetpr_fechaLiqui','=',$date)
            ->wherenotnull('ctdetpr.ctdetpr_esta_equi')
            ->orderby('ctdetpr.ctdetpr_fecha_act','desc')->get();
            
        }else{
            $almacen=DetailProducto::join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
            ->select('ctdetpr.ctdetpr_serie','ctdetpr.ctdetpr_sap','ctproduc.ctproduc_nombre'
            ,'ctdetpr.ctdetpr_esta_equi','ctproduc.ctproduc_stock')
            ->where('ctdetpr.ctdetpr_tipro_code','=',1)
            ->where('ctdetpr.ctdetpr_esta_code','=',0)
            ->where('ctdetpr.ctdetpr_fechaLiqui','=',$fecha)
            ->wherenotnull('ctdetpr.ctdetpr_esta_equi')
            ->orderby('ctdetpr.ctdetpr_fecha_act','desc')->get();

        }

        $cont=DetailProducto::where('ctdetpr.ctdetpr_fechaLiqui','=',$date)->count();

        return with(['almacen'=>$almacen,'contarLiqui' => $cont]) ;
    }

    public function reporteTraspasoMaterial(Request $request)
    {
        // return ':)';
        // if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
               
            $almacen=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_indice',
            'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_reg'
            ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg','ctdetsa.ctdetsa_observacion',
            'ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_cantidad_traspaso','ctdetsa.ctdetsa_undmdDescri')
            ->where('ctdetsa.ctdetsa_tipro_code','=',2)
            ->wherenotnull('ctdetsa.ctdetsa_observacion')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->paginate(10);
            
        }else {
            $almacen=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_indice',
            'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_reg'
            ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg','ctdetsa.ctdetsa_observacion',
            'ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_cantidad_traspaso','ctdetsa.ctdetsa_undmdDescri')
            ->where('ctdetsa.ctdetsa_tipro_code','=',2)
            ->wherenotnull('ctdetsa.ctdetsa_observacion')
            ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->paginate(10);
           
        }


        return [
            'pagination'=>[
                'total'=>$almacen->total(),
                'current_page'=>$almacen->currentPage(),
                'per_page'=>$almacen->perPage(),
                'last_page'=>$almacen->lastPage(),
                'from'=>$almacen->firstItem(),
                'to'=>$almacen->lastItem(),
            ],
            'almacen'=>$almacen
    
        ];

        
    }
    public function reporteCategoria(Request $request)
    {
        // return ':)';
        // if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        if ($buscar=='') {
               
            $categorias=Categoria::select('ctcatego_desc','ctcatego_fecha_reg')
            ->where('estado','=',1)
            ->orderby('ctcatego_id','desc')->paginate(5);
            
        }


        return ['categorias'=>$categorias
    
        ];

        
    }

    public function ContarEquipos(Request $request)
    {
        $cont=DetailProducto::where('ctdetpr.ctdetpr_esta_code','=',1)->count();
        return with(['contarEqui' => $cont]);
    }
    public function ContarCategorias(Request $request)
    {
        $cont=Categoria::where('estado','=',1)->count();
        return with(['contarCate' => $cont]);
    }

}
