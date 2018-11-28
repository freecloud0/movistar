<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoMaster;
use Maatwebsite\Excel\Facades\Excel;
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
             ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_tipro_code','ctproduc.ctproduc_stock',
             'ctundmd.ctundmd_desc','ctundmd.ctundmd_code','ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario',
             'ctproduc.estado','ctproduc.ctproduct_stock_max as stockMaximo','ctproduc.ctproduc_stock_uso')
               ->where('ctproduc.ctproduc_tipro_code','=',2)
               ->where('ctproduc.estado','=',$activo)
             // ->whereNotNull('ctproduc.sap')
             ->orderby('ctproduc.ctproduc_id','desc')->paginate(10);
         }else {
             $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
             ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
             ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
             ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
             ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_code','ctundmd.ctundmd_desc',
             'ctproduc.ctproduc_fecha_act','ctproduc.ctproduc_usuario','ctproduc.estado',
             'ctproduc.ctproduct_stock_max as stockMaximo','ctproduc.ctproduc_stock_uso')
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
            $promaster->ctproduc_stock=0;
            $promaster->ctproduct_stock_max=$request->stock;
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
        $id=$request->idProducto;
        $sap=$request->sap;
        $material=ProductoMaster::where('ctproduc_id',$id)->pluck('sap');
        $sapMaterial=$material->implode($material);
        
        if ($sapMaterial==$sap) {
            $this->UpdateRequest($request);
            return response()->json('Actualizado Correctamente', 200);
        }else{
            $this->validate($request,[
                'sap' => 'unique:ctproduc,sap,ctproduc_id'.$id.',ctproduc_id'
            ]);
            $this->UpdateRequest($request);
        }
        

    }
    public function UpdateRequest($request)
    {
        $promaster= ProductoMaster::findOrFail($request->idProducto);
        $promaster->ctproduc_catego_id=$request->categoria;
        $promaster->ctproduc_nombre=$request->nombre;
        $promaster->ctproduc_desc=$request->descripcion;
        $promaster->ctproduc_fecha_act=$request->fecha;
        $promaster->ctproduc_usuario=Auth::user()->ctusuar_usuario;
        $promaster->sap=$request->sap;
        $promaster->ctproduct_stock_max=$request->stock;
        $promaster->ctproduc_undMed=$request->unidadMedida; 
        // return $promaster;
        $promaster->save(); 
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
    public function actualizarStock(Request $request)
    {
        // {"idProducto":3,"sap":"clavos","stockA":3}
        $promaster= ProductoMaster::findOrFail($request->idProducto);
        $promaster->ctproduct_stock_max=$request->stockA;
        $promaster->save();
        // return $promaster;
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
    public function export(Request $request) 
   {
    $products =  ProductoMaster::join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
    ->select('ctproduc.sap','ctproduc.ctproduc_nombre'
   ,'ctproduc.ctproduc_desc','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc'
   ,'ctproduc.ctproduc_fecha_reg')
    ->where('ctproduc.ctproduc_tipro_code','=',2)
   ->orderby('ctproduc.ctproduc_fecha_reg','asc')->get(); 
    // $total=count($products);
    Excel::create('Reporte' ,function($excel) use($products) {
        $excel->sheet('Excel sheet', function($sheet) use($products) {
            $sheet->loadView('excel.materialTotalxls')->with('materiales',$products);
            $sheet->setOrientation('landscape');
           
        });
    })->export('xls');
    
   }
   public function materialPDF()
   {
       
       $produmaster=ProductoMaster::join('ctcatego','ctcatego.ctcatego_id','=','ctproduc.ctproduc_catego_id')
           ->join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
           ->join('cttipro','cttipro.cttipro_code','=','ctproduc.ctproduc_tipro_code')
           ->select('ctproduc.ctproduc_id','ctcatego.ctcatego_desc','ctcatego.ctcatego_id','ctproduc.ctproduc_nombre'
           ,'ctproduc.ctproduc_desc','ctproduc.sap','ctproduc.ctproduc_stock','ctundmd.ctundmd_desc','ctundmd.ctundmd_code'
           ,'ctproduc.ctproduc_fecha_reg','ctproduc.ctproduc_usuario','ctproduc.estado')
           ->where('ctproduc.ctproduc_tipro_code','=',2)
           // ->whereNotNull('ctproduc.sap')
           ->orderby('ctproduc.ctproduc_id','desc')->get();
      
            //  return $produmaster;
           $pdf=\PDF::loadView('pdf.materialpdf',['materiales'=>$produmaster]);
           return $pdf->download('materiales.pdf');
   }
    public function getSap(Request $request)
    {
        $filtro = $request->filtro;
        $sap = ProductoMaster::join('ctundmd','ctundmd.ctundmd_code','=','ctproduc.ctproduc_undMed')
        ->where('ctproduc.estado','=',1)
        ->where('ctproduc.sap','like','%'.$filtro.'%')
        ->select('ctproduc.sap','ctproduc.ctproduc_id',
        'ctproduc.ctproduc_tipro_code','ctundmd.ctundmd_desc',
        'ctproduc.ctproduc_undMed')->take(5)->get();
        return response()->json(['ok'=>true,'sap'=>$sap],200);
    }
    public function importar(Request $request)
    {
        return $request;
        // Excel::load($request->excel, function($reader) {
 
        //     $excel = $reader->get();
     
        //     // iteracción
        //     $reader->each(function($row) {
     
        //         $user = new User;
        //         $user->name = $row->nombre;
        //         $user->email = $row->email;
        //         $user->password = bcrypt('secret');
        //         $user->save();
     
        //     });
        
    }
    
}
