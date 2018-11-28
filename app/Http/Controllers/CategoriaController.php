<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
class CategoriaController extends Controller
{
    public function index(Request $request)
    {
    //    if (!$request->ajax()) return redirect('/');
    if (Auth::guest()) {
        return Redirect::to('/iniciar-sesion');
    }
       $idActivo = $request->idActivo;
       $buscar =$request->buscar;
       $criterio=$request->criterio;
       ///////PAGINATE////////////
       $paginate=$request->page;
       if ($buscar=='' OR $idActivo == '') {
           $categorias=Categoria::where('estado',$idActivo)
           ->orderby('ctcatego_id','desc')->paginate(10);
       }else {
           $categorias=Categoria::where('estado',$idActivo)
           ->where($criterio,'like','%' .$buscar. '%')
           ->orderby('ctcatego_id')->paginate(10);
       }
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
        // return $request;
     if (!$request->ajax()) return redirect('/');
     $id=$request->idCategoria;
     $descripcion=$request->ctcatego_desc;
     $categoria=Categoria::where('ctcatego_id',$id)->pluck('ctcatego_desc');
     $convertDescripcion=$categoria->implode($categoria);
     if ( $descripcion==$convertDescripcion) {
         $this->UpdateRequest($request);
         return response()->json('Actualizado Correctamente', 200);
     }else{
        $this->validate($request,[
            'ctcatego_desc' => 'unique:ctcatego,ctcatego_desc,ctcatego_id'.$id.',ctcatego_id'
        ]);
        $this->UpdateRequest($request);
        return response()->json('Actualizado Correctamente', 200);
     }
    
     
     
    }
    public function UpdateRequest($request)
    {
        $date =Carbon::now('America/Lima')->toDateTimeString();
        $categoria= Categoria::findOrFail($request->idCategoria);
        $categoria->ctcatego_desc=$request->ctcatego_desc;
        $categoria->ctcatego_fecha_act=$date;
        $categoria->ctcatego_usuario=Auth::user()->ctusuar_usuario;
        $categoria->save();
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
