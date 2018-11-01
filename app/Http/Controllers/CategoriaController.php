<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CategoriaController extends Controller
{
    public function index(Request $request)
    {
       if (!$request->ajax()) return redirect('/');
       $idActivo = $request->idActivo;
       $buscar =$request->buscar;
       $criterio=$request->criterio;
       // if ($idActivo == '') {
       //     $categorias = Categoria::where('estado',1)->paginate(10);
       // }else{
       if ($buscar=='' OR $idActivo == '') {
           $categorias=Categoria::where('estado',$idActivo)
           ->orderby('ctcatego_id','desc')->paginate(10);
       }else {
           $categorias=Categoria::where('estado',$idActivo)
           ->where($criterio,'like','%' .$buscar. '%')
           ->orderby('ctcatego_id')->paginate(10);
       }

   // }


       return [
           'pagination'=>[
                   'total'=>$categorias->total(),
                   'current_page'=>$categorias->currentPage(),
                   'per_page'=>$categorias->perPage(),
                   'last_page'=>$categorias->lastPage(),
                   'from'=>$categorias->firstItem(),
                   'to'=>$categorias->lastItem(),
           ],
           'categorias'=>$categorias
       ];
   
    }
   
 
    public function selectCategoria()
    {
        //   if (!$request->ajax()) return redirect('/');
        
        $categorias=Categoria::where('estado','=','1')
        ->select('ctcatego_id','ctcatego_desc')->orderby('ctcatego_id','desc')->get();
        return ['categorias'=>$categorias];
    }
    public function store(Request $request)
    {
        //  return $request;
         if (!$request->ajax()) return redirect('/');
        //  $categoria = Categoria::create(request()->all());   
      
        $request->validate([
            'ctcatego_desc' => 'unique:ctcatego',
        ]);

        $id=Categoria::max('ctcatego_id');
        $idmas=$id+1;
        $cargos= new Categoria;
        $cargos->ctcatego_id=$idmas;
        $cargos->ctcatego_desc=$request->ctcatego_desc;
        $cargos->ctcatego_fecha_act=$request->fechatualizacion;
        $cargos->ctcatego_usuario=Auth::user()->ctusuar_usuario;
        $cargos->save();  
        return response()->json('Registrado Correctamente', 200);
    }

   
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
     $date =Carbon::now('America/Lima')->toDateTimeString();
     $categoria= Categoria::findOrFail($request->idCategoria);
     $id=$request->idCategoria;
     $descripcion=$request->ctcatego_desc;
     $descripcionBD=Categoria::where('ctcatego_desc',$descripcion)->select('ctcatego_desc')->get();
     $descripcionjson = str_replace('[{"ctcatego_desc":"',"",$descripcionBD);
     $descripcionBaseDatos = str_replace('"}]',"",$descripcionjson);
     if ($descripcionBaseDatos==$descripcion) {
        //  $validate='Campo existente';
        // return with(['validate' => $validate]);
        return response()->json('Campo existente', 400);
     }else{
     $categoria->ctcatego_desc=$request->ctcatego_desc;
     $categoria->ctcatego_fecha_act=$date;
     $categoria->ctcatego_usuario=Auth::user()->ctusuar_usuario;
     $categoria->save();
     return response()->json('Actualizado Correctamente', 200);
     }
     
     
    }

    public function desactivar(Request $request)
    {
        // dd('hola');
        if (!$request->ajax()) return redirect('/');
     $categoria= Categoria::findOrFail($request->idCategoria);
     $categoria->estado=0;
     $categoria->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     $categoria= Categoria::findOrFail($request->idCategoria);
     $categoria->estado='1';
     $categoria->save();
    }
}
