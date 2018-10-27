<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnidadMedida;
use Illuminate\Support\Facades\Auth;
class UnidadMedidaController extends Controller
{
    public function index(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $medidas=UnidadMedida::orderby('ctundmd_code','desc')->paginate(10);
        }else {
            $medidas=UnidadMedida::where($criterio,'like','%' .$buscar. '%')->orderby('ctundmd_code')->paginate(10);
        }

         


        return [
            'pagination'=>[
                    'total'=>$medidas->total(),
                    'current_page'=>$medidas->currentPage(),
                    'per_page'=>$medidas->perPage(),
                    'last_page'=>$medidas->lastPage(),
                    'from'=>$medidas->firstItem(),
                    'to'=>$medidas->lastItem(),
            ],
            'medidas'=>$medidas
        ];
    }
    public function selectMedida()
    {
       
        $medidas=UnidadMedida::where('estado','=','1')
        ->where('ctundmd_code','>',1)
        ->select('ctundmd_code','ctundmd_desc')->orderby('ctundmd_code','asc')->get();
        return ['medidas'=>$medidas];
    }
    public function store(Request $request)
    {
        // return $request;
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'ctundmd_desc' => 'unique:ctundmd',

        ]);
        $id=UnidadMedida::max('ctundmd_code');
        $idmas=$id+1;
        $medidas= new UnidadMedida;
        $medidas->ctundmd_code=$idmas;
        $medidas->ctundmd_desc=$request->ctundmd_desc;
        $medidas->ctundmd_fecha_act=$request->fecha;
        $medidas->ctundmd_usuario=Auth::user()->ctusuar_usuario;
        // $medidas->usuario=Auth::user()->usuario;
        //  return $medidas;
        $medidas->save();    
        return response()->json('Registrado Correctamente', 200);
    }

   
    public function update(Request $request)
    {
        //  return $request;
        if (!$request->ajax()) return redirect('/');
     $medidas= UnidadMedida::findOrFail($request->idUndMed);
     $medidas->ctundmd_desc=$request->descripcion;
     $medidas->ctundmd_fecha_act=$request->fecha;
     $medidas->ctundmd_usuario=Auth::user()->ctusuar_usuario;;
     $medidas->save();
     return response()->json('Actualizado Correctamente', 200);
    }

    public function desactivar(Request $request)
    {
        // dd('hola');
        if (!$request->ajax()) return redirect('/');
        $medidas= UnidadMedida::findOrFail($request->idUndMed);
        $medidas->estado=0;
        $medidas->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $medidas= UnidadMedida::findOrFail($request->idUndMed);
        $medidas->estado=1;
        $medidas->save();
    }
}
