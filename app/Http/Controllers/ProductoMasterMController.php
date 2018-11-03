<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoMaster;
use Illuminate\Support\Facades\Auth;
use DB;
class ProductoMasterMController extends Controller
{
    public function index(Request $request)
    {
        // return $request;
         if (!$request->ajax()) return redirect('/');
         $activo=$request->activo;
         $buscar =$request->buscar;
         $criterio=$request->criterio;
         if ($buscar=='') {
             $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
             ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
             ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
             ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
             ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_tipro_code','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc','ctundmd.ctundmd_code','ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado')
               ->where('ctproduc.ctproduc_tipro_code','=',2)
               ->where('ctproduc.estado','=',$activo)
             // ->whereNotNull('ctproduc.sap')
             ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
         }else {
             $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
             ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
             ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
             ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
             ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_code','ctundmd.ctundmd_desc','ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado')
              ->where('cttipro.cttipro_code','=',2)
             // ->where('ctproduc.sap','=',null)
             ->whereNotNull('ctproduc.sap')
             ->where('ctproduc.'.$criterio,'like','%' .$buscar. '%')
             ->where('ctproduc.estado','=',$activo)
             ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
         }
 
          
 
 
         return [
             'pagination'=>[
                     'total'=>$produmaster->total(),
                     'current_page'=>$produmaster->currentPage(),
                     'per_page'=>$produmaster->perPage(),
                     'last_page'=>$produmaster->lastPage(),
                     'from'=>$produmaster->firstItem(),
                     'to'=>$produmaster->lastItem(),
             ],
             'produmaster'=>$produmaster
         ];
    }

    public function store(Request $request)
    {
    //    return $request;
    if (!$request->ajax()) return redirect('/');
            $request->validate([
                'sap' => 'unique:ctproduc',
            ]);
            //Registro de ProductoMaster
            $id=ProductoMaster::max('ctproduc_id');
            $idmas=$id+1;
            $promaster=new ProductoMaster();
            $promaster->ctproduc_id=$idmas;
            $promaster->ctproduc_catego_id=$request->categoria;
            $promaster->ctproduc_nombre=$request->nombre;
            $promaster->ctproduc_desc=$request->descripcion;
            $promaster->ctproduc_fecha_act=$request->fecha;
            $promaster->ctproduc_usuario=Auth::user()->ctusuar_usuario;
            $promaster->sap=$request->sap;
            $promaster->ctproduc_stock=$request->stock;
            $promaster->ctproduc_undMed=$request->unidadMedida; 
            $promaster->ctproduc_tipro_code=2;
            // return $promaster;
            $promaster->save();
            return response()->json('Registrado Correctamente', 200);
          
    }
    public function update(Request $request)
    {
      
        //   return $request;
        if (!$request->ajax()) return redirect('/');
        $promaster= ProductoMaster::findOrFail($request->idProducto);
        $promaster->ctproduc_catego_id=$request->categoria;
        $promaster->ctproduc_nombre=$request->nombre;
        $promaster->ctproduc_desc=$request->descripcion;
        $promaster->ctproduc_fecha_act=$request->fecha;
        $promaster->ctproduc_usuario=Auth::user()->ctusuar_usuario;
        $promaster->sap=$request->sap;
        $promaster->ctproduc_stock=$request->stock;
        $promaster->ctproduc_undMed=$request->unidadMedida; 
        // return $promaster;
        $promaster->save(); 
        return response()->json('Actualizado Correctamente', 200);

    }

    public function desactivar(Request $request)
    {
        //  return $request;
        if (!$request->ajax()) return redirect('/');
     $promaster= ProductoMaster::findOrFail($request->idProducto);
     $promaster->estado=0;
     $promaster->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     $promaster= ProductoMaster::findOrFail($request->idProducto);
     $promaster->estado='1';
     $promaster->save();
    }
    public function listarPDF()
    {
        # code...
    }
// BUSCAR MATERIAL POR SAP
    public function buscarSapMaterial(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
    
        $buscar =$request->buscar1;
        $criterio=$request->criterio2;
        if ($buscar=='') {
            // $series='';
            // return $series;

            $series=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
            ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
            ->select('ctcatego.ctcatego_id','ctcatego.ctcatego_desc','ctundmd.ctundmd_code','ctundmd.ctundmd_desc',
            'cttipro.cttipro_code','cttipro.cttipro_desc','ctproduc.ctproduc_id','ctproduc.ctproduc_nombre',
            'ctproduc.sap','ctproduc.ctproduc_stock','ctproduc.estado') 
            ->where('ctproduc.ctproduc_tipro_code','=',2)
            ->where('ctproduc.estado','=',1)
            ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
        }else {
            $series=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
            ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
            ->select('ctcatego.ctcatego_id','ctcatego.ctcatego_desc','ctundmd.ctundmd_code','ctundmd.ctundmd_desc',
            'cttipro.cttipro_code','cttipro.cttipro_desc','ctproduc.ctproduc_id','ctproduc.ctproduc_nombre',
            'ctproduc.sap','ctproduc.ctproduc_stock','ctproduc.estado') 
            ->where('ctproduc.ctproduc_tipro_code','=',2)
            ->where('ctproduc.estado','=',1)
            ->where('ctproduc.'.$criterio,'=',$buscar)
            ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
           
        }

        return [
            'pagination'=>[
                'total'=>$series->total(),
                'current_page'=>$series->currentPage(),
                'per_page'=>$series->perPage(),
                'last_page'=>$series->lastPage(),
                'from'=>$series->firstItem(),
                'to'=>$series->lastItem(),
            ],
            'series'=>$series
        ];
    }
}
