<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use Illuminate\Support\Facades\Auth;
class ProveedorController extends Controller
{
    public function index(Request $request)
    {
      if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $proveedores=Proveedor::select('ctprove_code','ctprove_razon_social as NOMBRE',
            'ctprove_nro_ruc as RUC','ctprove_direccion','ctprove_email','ctprove_telefono
            as TELEFONO',
            'ctprove_fecha_reg','ctprove_fecha_act','ctprove_usuario','estado')
            ->orderby('ctprove.ctprove_code','desc')->paginate(10);
        }else {
            $proveedores=Proveedor::select('ctprove_code','ctprove_razon_social as NOMBRE',
            'ctprove_nro_ruc as RUC','ctprove_direccion','ctprove_email','ctprove_telefono
            as TELEFONO',
            'ctprove_fecha_reg','ctprove_fecha_act','ctprove_usuario','estado')
            ->where('ctprove.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctprove.ctprove_code','desc')->paginate(10);
        }

         


        return [
            'pagination'=>[
                    'total'=>$proveedores->total(),
                    'current_page'=>$proveedores->currentPage(),
                    'per_page'=>$proveedores->perPage(),
                    'last_page'=>$proveedores->lastPage(),
                    'from'=>$proveedores->firstItem(),
                    'to'=>$proveedores->lastItem(),
            ],
            'proveedores'=>$proveedores
        ];
    }
    public function selectProveedor()
    {
        $proveedores=Proveedor::where('estado','=','1')
        ->select('ctprove.ctprove_code','ctprove.ctprove_razon_social')->orderby('ctprove.ctprove_code','desc')->get();
        return ['proveedores'=>$proveedores];
    }
    public function store(Request $request)
    {
        //  return $request;
        

        if (!$request->ajax()) return redirect('/');
        $request->validate([
            'ctprove_razon_social' => 'unique:ctprove',
            'ctprove_nro_ruc' => 'unique:ctprove',
            'ctprove_telefono' => 'unique:ctprove',
            'ctprove_email' => 'unique:ctprove',

        ]);
        $id=Proveedor::max('ctprove_code');
        $idmas=$id+1;

        $proveedores= new Proveedor;
        $proveedores->ctprove_code=$idmas;
        $proveedores->ctprove_razon_social=$request->ctprove_razon_social;
        $proveedores->ctprove_nro_ruc=$request->ctprove_nro_ruc;
        $proveedores->ctprove_direccion=$request->direccion;
        $proveedores->ctprove_email=$request->ctprove_email;
        $proveedores->ctprove_fecha_act=$request->fechatualizacion;
        $proveedores->ctprove_telefono=$request->ctprove_telefono;
        $proveedores->ctprove_usuario=Auth::user()->ctusuar_usuario;
        // return $proveedores;
        $proveedores->save();  
        return response()->json('Registrado Correctamente', 200);  
    }
    public function update(Request $request)
    {
        //   return $request;
        if (!$request->ajax()) return redirect('/');
        $proveedores= Proveedor::findOrFail($request->ctprove_code);
        $proveedores->ctprove_razon_social=$request->descripcion;
        $proveedores->ctprove_nro_ruc=$request->ruc;
        $proveedores->ctprove_direccion=$request->direccion;
        $proveedores->ctprove_email=$request->email;
        $proveedores->ctprove_fecha_act=$request->fecha;
        $proveedores->ctprove_telefono=$request->telefono;
        $proveedores->ctprove_usuario=Auth::user()->ctusuar_usuario;
        // return $proveedores;
        $proveedores->save(); 
        return response()->json('Actualizado Correctamente', 200);

    }

    public function desactivar(Request $request)
    {
        //  return $request;
        if (!$request->ajax()) return redirect('/');
     $proveedores= Proveedor::findOrFail($request->ctprove_code);
     $proveedores->estado=0;
     $proveedores->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     $proveedores= Proveedor::findOrFail($request->ctprove_code);
     $proveedores->estado='1';
     $proveedores->save();
    }
  
}
