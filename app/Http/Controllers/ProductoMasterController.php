<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoMaster;
use Illuminate\Support\Facades\Auth;
use DB;
class ProductoMasterController extends Controller
{
    public function index(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
         $activos=$request->activo;
         $buscar =$request->buscar;
         $criterio=$request->criterio;
         if ($buscar=='') {
             $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
             ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
             ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
             ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
             ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc','ctundmd.ctundmd_code'
             ,'ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado')
             ->where('ctproduc.ctproduc_tipro_code','=',1)
             ->where('ctproduc.estado','=',$activos)
             // ->whereNotNull('ctproduc.sap')
             ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
         }else {
             $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
             ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
             ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
             ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
             ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc','ctundmd.ctundmd_code'
             ,'ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado')
             ->where('ctproduc.ctproduc_tipro_code','=',1)
             ->where('ctproduc.estado','=',$activos)
             // ->whereNotNull('ctproduc.sap')
             ->where('ctproduc.'.$criterio,'like','%' .$buscar. '%')
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
        if (!$request->ajax()) return redirect('/');
       
       
      
            //Registro de ProductoMaster
            $request->validate([
                'sap' => 'unique:ctproduc',
            ]);
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
            $promaster->ctproduc_undMed=1; 
            $promaster->ctproduc_tipro_code=1;
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
        $promaster->ctproduc_tipro_code=1;
        //  return $promaster;
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

    public function buscarLista(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        // return $request;
        $id =$request->id;
        $produmaster=DB::select('call buscarLista(?)',[$id]);
        
        return ['produmaster'=>$produmaster];
       


    }
    public function listarPDF()
    {
       
        $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
            ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
            ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
            ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc','ctundmd.ctundmd_code'
            ,'ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado')
            ->where('ctproduc.ctproduc_tipro_code','=',1)
            // ->whereNotNull('ctproduc.sap')
            ->orderby('ctproduc.ctproduc_id','desc')->get();
            
            $cont=ProductoMaster::where('ctproduc.ctproduc_tipro_code','=',1)->count();
          
            $pdf=\PDF::loadView('pdf.equipospdf',['produmaster'=>$produmaster,'cont'=>$cont]);
            return $pdf->download('equipos.pdf');
    }


    public function listarDetallePDF()
    {
        
        $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
            ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
            ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
            ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc','ctundmd.ctundmd_code'
            ,'ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado')
            ->where('ctproduc.ctproduc_tipro_code','=',1)
            // ->whereNotNull('ctproduc.sap')
            ->orderby('ctproduc.ctproduc_id','desc')->get();
            
            $cont=ProductoMaster::where('ctproduc.ctproduc_tipro_code','=',1)->count();
          
            $pdf=\PDF::loadView('pdf.equipospdf',['produmaster'=>$produmaster,'cont'=>$cont]);
            return $pdf->download('equipos.pdf');
    }
    public function CodigoSap()
   {
       $sap = ProductoMaster::select('sap')->get();
       return ['sap'=>$sap];
   }

}
