<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CargoController extends Controller
{
 
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $cargos=Cargo::orderby('ctcargo_code','desc')->paginate(10);
        }else {
            $cargos=Cargo::where($criterio,'like','%' .$buscar. '%')->orderby('ctcargo_code')->paginate(10);
        }

         


        return [
            'pagination'=>[
                    'total'=>$cargos->total(),
                    'current_page'=>$cargos->currentPage(),
                    'per_page'=>$cargos->perPage(),
                    'last_page'=>$cargos->lastPage(),
                    'from'=>$cargos->firstItem(),
                    'to'=>$cargos->lastItem(),
            ],
            'cargos'=>$cargos
        ];
    }
    public function selectCargo()
    {
        //   if (!$request->ajax( )) return redirect('/');
        $cargos=Cargo::where('estado','=','1')
        ->select('ctcargo_code','ctcargo_nombre')->orderby('ctcargo_code','desc')->get();
        return ['cargos'=>$cargos];
    }
  
    public function store(Request $request)
    {
        // return $request;
        if (!$request->ajax()) return redirect('/');
        
        $id=Cargo::max('ctcargo_code');
        $idmas=$id+1;
        $request->validate([
            'ctcargo_nombre' => 'unique:ctcargo',
        ]);
        $cargos= new Cargo;
        $cargos->ctcargo_code=$idmas;
        $cargos->ctcargo_nombre=$request->ctcargo_nombre;
        $cargos->ctcargo_desc=$request->observacion;
        $cargos->ctcargo_usuario=Auth::user()->ctusuar_usuario;
        $cargos->save();    
        return response()->json('Registrado Correctamente', 200);
    }

   
    public function update(Request $request)
    {
          
        if (!$request->ajax()) return redirect('/');
            $date =Carbon::now('America/Lima')->toDateTimeString();
            $dateconvert =(string) $date;
            $cargos= Cargo::findOrFail($request->ctcargo_code);
            $id = $cargos->ctcargo_code;
            $buscar = Cargo::where('ctcargo_code',$id)->pluck('ctcargo_code');
            $buscarr = str_replace('[',"",$buscar);
            $Userid = str_replace(']',"",$buscarr);
            $name = Cargo::where('ctcargo_code',$id)->pluck('ctcargo_nombre');
            $names = str_replace('["',"",$name);
            $UserName = str_replace('"]',"",$names);
        
        if ($UserName == $request->ctcargo_nombre ) {
            $cargos->ctcargo_nombre=$request->ctcargo_nombre;
            $cargos->ctcargo_desc=$request->observacion;
            $cargos->ctcargo_fecha_act=$dateconvert;
            $cargos->ctcargo_usuario=Auth::user()->ctusuar_usuario;
            $cargos->save();
            return response()->json('Actualizado Correctamente', 200);
        } else {
            $this->validate($request,[
             'ctcargo_nombre' => 'unique:ctcargo,ctcargo_nombre,ctcargo_code'.$id.',ctcargo_code'
            ]);
            $cargos->ctcargo_nombre=$request->ctcargo_nombre;
            $cargos->ctcargo_desc=$request->observacion;
            $cargos->ctcargo_fecha_act=$dateconvert;
            $cargos->ctcargo_usuario=Auth::user()->ctusuar_usuario;
            $cargos->save();
            return response()->json('Actualizado Correctamente', 200);
        }
       
      
      
     
    }

    public function desactivar(Request $request)
    {
        // dd('hola');
        if (!$request->ajax()) return redirect('/');
        $cargos= Cargo::findOrFail($request->idCargo);
        $cargos->estado=0;
        $cargos->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cargos= Cargo::findOrFail($request->idCargo);
        $cargos->estado=1;
        $cargos->save();
    }
}


