<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empleado;
use DB;
use Carbon\Carbon;
use App\Permiso;
// use App\DetalleSalida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
       if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        $criterio1=$request->criterio1;
        if ($buscar=='') {
            $personas=User::join('permiso','permiso.UserID','=','ctusuar.ctusuar_code')
            ->join('ctcolab','ctcolab.ctcolab_id','=','ctusuar.ctusuar_colab_id')
            ->join('ctcargo','ctcargo.ctcargo_code','=','ctusuar.ctusuar_cargo_code')
            ->select('permiso.idPermiso','permiso.categoria','permiso.equipo','permiso.material','permiso.ingreso',
            'permiso.salida','permiso.equipoTecnico','permiso.materialTecnico','permiso.proveedor',
            'permiso.usuario','permiso.rol','permiso.unidadMedida',
            'ctcolab.ctcolab_id','ctcolab.ctcolab_nombres','ctcolab.ctcolab_ap_paterno','ctcolab.ctcolab_ap_materno' ,
            DB::raw('CONCAT(ctcolab.ctcolab_nombres, ", ", ctcolab.ctcolab_ap_paterno," ",ctcolab.ctcolab_ap_materno) as DATOS'),
            'ctcargo.ctcargo_code','ctcargo.ctcargo_nombre as CARGO','ctcolab.ctcolab_dni','ctusuar.ctusuar_email','ctusuar.ctusuar_fecha_act',
            'ctusuar.ctusuar_code','ctusuar.ctusuar_usuario_code','ctcolab.ctcolab_direccion','ctcolab.ctcolab_celular',
            'ctcolab.ctcolab_telefono','ctcolab.ctcolab_email as EMAIL','ctusuar.estado','ctusuar.ctusuar_usuario as USUARIO')
            // ->groupby('permiso.UserID')
            ->orderby('ctcolab.ctcolab_id','desc')->paginate(10);
           
        }else {
            $personas=User::join('permiso','permiso.UserID','=','ctusuar.ctusuar_code')
            ->join('ctcolab','ctcolab.ctcolab_id','=','ctusuar.ctusuar_colab_id')
            ->join('ctcargo','ctcargo.ctcargo_code','=','ctusuar.ctusuar_cargo_code')
            ->select('permiso.idPermiso','permiso.categoria','permiso.equipo','permiso.material','permiso.ingreso',
            'permiso.salida','permiso.equipoTecnico','permiso.materialTecnico','permiso.proveedor',
            'permiso.usuario','permiso.rol','permiso.unidadMedida',
            'ctcolab.ctcolab_id','ctcolab.ctcolab_nombres','ctcolab.ctcolab_ap_paterno','ctcolab.ctcolab_ap_materno' ,
            DB::raw('CONCAT(ctcolab.ctcolab_nombres, ", ", ctcolab.ctcolab_ap_paterno," ",ctcolab.ctcolab_ap_materno) as DATOS'),
            'ctcargo.ctcargo_code','ctcargo.ctcargo_nombre as CARGO','ctcolab.ctcolab_dni','ctusuar.ctusuar_email','ctusuar.ctusuar_fecha_act',
            'ctusuar.ctusuar_code','ctusuar.ctusuar_usuario_code','ctcolab.ctcolab_direccion','ctcolab.ctcolab_celular',
            'ctcolab.ctcolab_telefono','ctcolab.ctcolab_email as EMAIL','ctusuar.estado','ctusuar.ctusuar_usuario as USUARIO')
            ->where('ctcolab.'.$criterio ,'like','%' .$buscar. '%')
            // ->where('ctusuar.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctcolab.ctcolab_id','desc')->paginate(10);
           
        }

         


        return [
            'pagination'=>[
                    'total'=>$personas->total(),
                    'current_page'=>$personas->currentPage(),
                    'per_page'=>$personas->perPage(),
                    'last_page'=>$personas->lastPage(),
                    'from'=>$personas->firstItem(),
                    'to'=>$personas->lastItem(),
            ],
            'personas'=>$personas
        ];
    }

  
  
    public function store(Request $request)
    {
    //   return $request;
         if (!$request->ajax()) return redirect('/');
        
            $datefin = Carbon::now('America/Lima')->toDateTimeString();
            $idU=Permiso::max('idPermiso');
            $idUmas=$idU+1;
            $id=Empleado::max('ctcolab_id');
            $idmas=$id+1;
            $id=User::max('ctusuar_code');
            $idUser=$id+1;
            $request->validate([
                'ctcolab_dni' => 'unique:ctcolab',
                'ctcolab_celular' => 'unique:ctcolab',

            ]);
            $request->validate([
                'ctusuar_usuario' => 'unique:ctusuar',

            ]);
            
           

        // ROLES DE USUARIOS AL CREARLO
         $cargo=$request->idCargo;
        if ($cargo==1) {
            $cont=User::where('ctusuar_cargo_code','=',$cargo)->count();
            
            if ($cont>=2) {
                return response()->json(['error'=>'Máximo de administradores '.$cont],400);
            }else{
                // REGISTRAR EMPLEADO
                $persona=new Empleado();
                $persona->ctcolab_id=$idmas;
                $persona->ctcolab_ap_paterno=$request->apePater;
                $persona->ctcolab_ap_materno=$request->apeMater;
                $persona->ctcolab_nombres=$request->nombres;
                $persona->ctcolab_dni=$request->ctcolab_dni;
                $persona->ctcolab_direccion=$request->direccion;
                $persona->ctcolab_telefono=$request->ctcolab_telefono;
                $persona->ctcolab_celular=$request->ctcolab_celular;
                $persona->ctcolab_email=$request->emailP;
                $persona->ctcolab_fecha_act=$request->fechareg;
                $persona->ctcolab_usuario=Auth::user()->ctusuar_usuario;
                
                  $persona->save();
                //   return $persona;
                // REGISTRAR USUARIO
                $user= new User();
                $user->ctusuar_code=$idUser;
                $user->ctusuar_usuario=$request->ctusuar_usuario;
                $user->ctusuar_colab_id=$idmas;
                $user->ctusuar_email=$request->emailC;
                $user->ctusuar_cargo_code=$request->idCargo;
                $user->password=bcrypt($request->password);
                $user->ctusuar_fecha_act=$request->fechareg;
                $user->ctusuar_usuario_code=Auth::user()->ctusuar_usuario;
                //  return $user;
                  $user->save();
                // ROLES PARA EL USUARIO REGISTRADO
                
                $userCargo=new Permiso();
                $userCargo->idPermiso=$idUmas;
                $userCargo->categoria=1;
                $userCargo->equipo=1;
                $userCargo->material=1;
                $userCargo->ingreso=1;
                $userCargo->salida=1;
                $userCargo->equipoTecnico=1;
                $userCargo->materialTecnico=1;
                $userCargo->proveedor=1;
                $userCargo->usuario=1;
                $userCargo->unidadMedida=1;
                $userCargo->rol=1;
                $userCargo->liquidacion=1;
                $userCargo->UserID=$idUser;
                $userCargo->save();
                // return $userCargo;
            }
          
        }else{
             // REGISTRAR EMPLEADO
             $persona=new Empleado();
             $persona->ctcolab_id=$idmas;
             $persona->ctcolab_ap_paterno=$request->apePater;
             $persona->ctcolab_ap_materno=$request->apeMater;
             $persona->ctcolab_nombres=$request->nombres;
             $persona->ctcolab_dni=$request->ctcolab_dni;
             $persona->ctcolab_direccion=$request->direccion;
             $persona->ctcolab_telefono=$request->ctcolab_telefono;
             $persona->ctcolab_celular=$request->ctcolab_celular;
             $persona->ctcolab_email=$request->emailP;
             $persona->ctcolab_fecha_act=$request->fechareg;
             $persona->ctcolab_usuario=Auth::user()->ctusuar_usuario;
             
               $persona->save();
             //   return $persona;
             // REGISTRAR USUARIO
             $user= new User();
             $user->ctusuar_code=$idUser;
             $user->ctusuar_usuario=$request->ctusuar_usuario;
             $user->ctusuar_colab_id=$idmas;
             $user->ctusuar_email=$request->emailC;
             $user->ctusuar_cargo_code=$request->idCargo;
             $user->password=bcrypt($request->password);
             $user->ctusuar_fecha_act=$request->fechareg;
             $user->ctusuar_usuario_code=Auth::user()->ctusuar_usuario;
             //  return $user;
               $user->save();
            // ROLES PARA EL USUARIO REGISTRADO
           
            $userCargo=new Permiso();
            $userCargo->idPermiso=$idUmas;
            $userCargo->categoria=$request->categoriaChecked;
            $userCargo->equipo=$request->equipoChecked;
            $userCargo->material=$request->materialChecked;
            $userCargo->ingreso=$request->ingresoChecked;
            $userCargo->salida=$request->salidaChecked;
            $userCargo->equipoTecnico=$request->equipoTecnicoChecked;
            $userCargo->materialTecnico=$request->materialTecnicoChecked;
            $userCargo->proveedor=$request->proveedorChecked;
            $userCargo->usuario=$request->usuarioChecked;
            $userCargo->unidadMedida=$request->unidadMedidaChecked;
            $userCargo->rol=$request->rolChecked;
            $userCargo->UserID=$idUser;
            $userCargo->save();
            // return $userCargo;
       }
        
        
        return response()->json('Registrado Correctamente', 200);
    }

   
    public function update(Request $request)
    {
            // return $request;
        if (!$request->ajax()) return redirect('/');
        $cargo=$request->idCargo;
        $cargousuario=$request->idUsuario;
        $user= User::findOrFail($request->idUsuario);
        $persona= Empleado::findOrFail($request->idEmpleado);
        $cargoUser= Permiso::findOrFail($request->idPermiso);
        $dni=Empleado::where('ctcolab_dni',$request->ctcolab_dni)->pluck('ctcolab_dni');
        $dnis = str_replace('["',"",$dni);
        $EmpleadoDNI = str_replace('"]',"",$dnis);

       
        if ($request->ctcolab_dni == $EmpleadoDNI ) {
            if ($cargo==1) {
                $persona->ctcolab_ap_paterno=$request->apePater;
                $persona->ctcolab_ap_materno=$request->apeMater;
                $persona->ctcolab_nombres=$request->nombres;
                $persona->ctcolab_dni=$request->ctcolab_dni;
                $persona->ctcolab_direccion=$request->direccion;
                $persona->ctcolab_telefono=$request->telefono;
                $persona->ctcolab_celular=$request->celular;
                $persona->ctcolab_email=$request->emailP;
                $persona->ctcolab_fecha_act=$request->fechareg;
                $persona->ctcolab_usuario=Auth::user()->ctusuar_usuario;
        
                // return $persona;
                  $persona->save();
        
        
                $user->ctusuar_usuario=$request->usuario;
                $user->ctusuar_email=$request->emailC;
                $user->ctusuar_cargo_code=$request->idCargo;
                // $user->password=bcrypt($request->password);
                $user->ctusuar_fecha_act=$request->fechareg;
                $user->ctusuar_usuario_code=Auth::user()->ctusuar_usuario;
                // return $user;
                  $user->save();
                //ACTUALIZANDO ROL DE USUARIO
                
                // ROLES PARA EL USUARIO REGISTRADO
               
                $cargoUser->categoria=1;
                $cargoUser->equipo=1;
                $cargoUser->material=1;
                $cargoUser->ingreso=1;
                $cargoUser->salida=1;
                $cargoUser->equipoTecnico=1;
                $cargoUser->materialTecnico=1;
                $cargoUser->proveedor=1;
                $cargoUser->usuario=1;
                $cargoUser->unidadMedida=1;
                $cargoUser->rol=1;
                $cargoUser->liquidacion=1;
                $cargoUser->UserID=$cargousuario;
                $cargoUser->save();
                return response()->json('Actualizado Correctamente', 200);
             }else{
            
            
                $persona->ctcolab_ap_paterno=$request->apePater;
                $persona->ctcolab_ap_materno=$request->apeMater;
                $persona->ctcolab_nombres=$request->nombres;
                $persona->ctcolab_dni=$request->ctcolab_dni;
                $persona->ctcolab_direccion=$request->direccion;
                $persona->ctcolab_telefono=$request->telefono;
                $persona->ctcolab_celular=$request->celular;
                $persona->ctcolab_email=$request->emailP;
                $persona->ctcolab_fecha_act=$request->fechareg;
                $persona->ctcolab_usuario=Auth::user()->ctusuar_usuario;
        
                // return $persona;
                $persona->save();
        
        
                $user->ctusuar_usuario=$request->usuario;
                $user->ctusuar_email=$request->emailC;
                $user->ctusuar_cargo_code=$request->idCargo;
                // $user->password=bcrypt($request->password);
                $user->ctusuar_fecha_act=$request->fechareg;
                $user->ctusuar_usuario_code=Auth::user()->ctusuar_usuario;
                // return $user;
                $user->save();
                //ACTUALIZANDO ROL DE USUARIO
                
                $cargoUser->categoria=$request->categoriaChecked;
                $cargoUser->equipo=$request->equipoChecked;
                $cargoUser->material=$request->materialChecked;
                $cargoUser->ingreso=$request->ingresoChecked;
                $cargoUser->salida=$request->salidaChecked;
                $cargoUser->equipoTecnico=$request->equipoTecnicoChecked;
                $cargoUser->materialTecnico=$request->materialTecnicoChecked;
                $cargoUser->proveedor=$request->proveedorChecked;
                $cargoUser->usuario=$request->usuarioChecked;
                $cargoUser->unidadMedida=$request->unidadMedidaChecked;
                $cargoUser->rol=$request->rolChecked;
                $cargoUser->liquidacion=$request->liquidacionChecked;
                $cargoUser->UserID=$cargousuario;
                $cargoUser->save();
                //  return $userCargo;
                return response()->json('Actualizado Correctamente', 200);
            }
        }else {
            $request->validate([
                'ctcolab_dni' => 'unique:ctcolab,ctcolab_dni,ctcolab_id'.$idEmpleado.',ctcolab_id',
                'password' =>'sometimes'
            ]);
            if ($cargo==1) {
                $persona->ctcolab_ap_paterno=$request->apePater;
                $persona->ctcolab_ap_materno=$request->apeMater;
                $persona->ctcolab_nombres=$request->nombres;
                $persona->ctcolab_dni=$request->ctcolab_dni;
                $persona->ctcolab_direccion=$request->direccion;
                $persona->ctcolab_telefono=$request->telefono;
                $persona->ctcolab_celular=$request->celular;
                $persona->ctcolab_email=$request->emailP;
                $persona->ctcolab_fecha_act=$request->fechareg;
                $persona->ctcolab_usuario=Auth::user()->ctusuar_usuario;
        
                // return $persona;
                  $persona->save();
        
        
                $user->ctusuar_usuario=$request->usuario;
                $user->ctusuar_email=$request->emailC;
                $user->ctusuar_cargo_code=$request->idCargo;
                // $user->password=bcrypt($request->password);
                $user->ctusuar_fecha_act=$request->fechareg;
                $user->ctusuar_usuario_code=Auth::user()->ctusuar_usuario;
                // return $user;
                  $user->save();
                //ACTUALIZANDO ROL DE USUARIO
                
                // ROLES PARA EL USUARIO REGISTRADO
               
                $cargoUser->categoria=1;
                $cargoUser->equipo=1;
                $cargoUser->material=1;
                $cargoUser->ingreso=1;
                $cargoUser->salida=1;
                $cargoUser->equipoTecnico=1;
                $cargoUser->materialTecnico=1;
                $cargoUser->proveedor=1;
                $cargoUser->usuario=1;
                $cargoUser->unidadMedida=1;
                $cargoUser->rol=1;
                $cargoUser->liquidacion=1;
                $cargoUser->UserID=$cargousuario;
                $cargoUser->save();
                return response()->json('Actualizado Correctamente', 200);
             }else{
            
            
                $persona->ctcolab_ap_paterno=$request->apePater;
                $persona->ctcolab_ap_materno=$request->apeMater;
                $persona->ctcolab_nombres=$request->nombres;
                $persona->ctcolab_dni=$request->ctcolab_dni;
                $persona->ctcolab_direccion=$request->direccion;
                $persona->ctcolab_telefono=$request->telefono;
                $persona->ctcolab_celular=$request->celular;
                $persona->ctcolab_email=$request->emailP;
                $persona->ctcolab_fecha_act=$request->fechareg;
                $persona->ctcolab_usuario=Auth::user()->ctusuar_usuario;
        
                // return $persona;
                $persona->save();
        
        
                $user->ctusuar_usuario=$request->usuario;
                $user->ctusuar_email=$request->emailC;
                $user->ctusuar_cargo_code=$request->idCargo;
                // $user->password=bcrypt($request->password);
                $user->ctusuar_fecha_act=$request->fechareg;
                $user->ctusuar_usuario_code=Auth::user()->ctusuar_usuario;
                // return $user;
                $user->save();
                //ACTUALIZANDO ROL DE USUARIO
                
                $cargoUser->categoria=$request->categoriaChecked;
                $cargoUser->equipo=$request->equipoChecked;
                $cargoUser->material=$request->materialChecked;
                $cargoUser->ingreso=$request->ingresoChecked;
                $cargoUser->salida=$request->salidaChecked;
                $cargoUser->equipoTecnico=$request->equipoTecnicoChecked;
                $cargoUser->materialTecnico=$request->materialTecnicoChecked;
                $cargoUser->proveedor=$request->proveedorChecked;
                $cargoUser->usuario=$request->usuarioChecked;
                $cargoUser->unidadMedida=$request->unidadMedidaChecked;
                $cargoUser->rol=$request->rolChecked;
                $cargoUser->liquidacion=$request->liquidacionChecked;
                $cargoUser->UserID=$cargousuario;
                $cargoUser->save();
                //  return $userCargo;
                return response()->json('Actualizado Correctamente', 200);
            }

        }
       
         

    }
    public function selectUsuario(Request $request)
    {
        //  return $request;
        
        $filtro = $request->filtro;
        $usuarios = User::where('ctusuar_usuario','like','%'.$filtro.'%')
        ->select('ctusuar_code','ctusuar_usuario')->orderBy('ctusuar_code', 'asc')->take(3)->get();

        return ['usuarios' => $usuarios];
    }

    public function desactivar(Request $request)
    {
        //  return $request;
        if (!$request->ajax()) return redirect('/');
     $user= User::findOrFail($request->idUsuario);
     $user->estado=0;
     $user->save();
    }
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     $user= User::findOrFail($request->idUsuario);
     $user->estado='1';
     $user->save();
    }
}
