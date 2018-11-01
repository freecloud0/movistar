<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Collection as Collection;
class LoginController extends Controller
{
    public function ShowLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        // return $request;
        $usuario=$request->usuario;
        $user=User::where('ctusuar_usuario',$usuario)->pluck('ctusuar_usuario');
        $ema = str_replace('["',"",$user);
        $userEmail = str_replace('"]',"",$ema);
        $iduser=User::where('ctusuar_usuario',$usuario)->pluck('ctusuar_code');
        $idconvert =(string) $iduser;
        $idema = str_replace('[',"",$idconvert);
        $IdUsuario = str_replace(']',"",$idema);
        
        $estado=User::where('ctusuar_code',$IdUsuario)->pluck('estado');
        $estadoconvert =(string) $estado;
        $idema = str_replace('[',"",$estadoconvert);
        $estadoUser = str_replace(']',"",$idema);
        // return $estadoUser;
        
        // return $userEmail;
            if (Auth::attempt(['ctusuar_usuario'=>$request->usuario,'password'=>$request->password,'estado'=>1])) {
                
                    return redirect()->route('main');
                
               
            } 
            if ($usuario==$userEmail) {
                if ($estadoUser==0) {
                    return redirect('iniciar-sesion')
                    ->with('msj1','Usuario desactivo');
                }else{
                 return redirect()->route('iniciar-sesion')
                 ->withErrors(['ctusuar_usuario'=>trans('auth.failed')])
                 ->withInput(request(['usuario']));
                }
            
                 
           
             }else{
                 
                
                 $msj='Usuario no creado';
                 return redirect('iniciar-sesion')
                 ->with('msj','Usuario no registrado');
             }


            // if (Auth::attempt(['ctusuar_email'=>$request->usuario,'password'=>$request->password,'estado'=>1])) {
            //     return redirect()->route('main');
            // }
            // return back()->withErrors(['ctusuar_email'=>trans('auth.failed')])
            // ->withInput(request(['usuario']));
        

        
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
