<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserActivoController extends Controller
{
    public function CargarCargoUser(Request $request)
    {
        $cargoUser=Auth::user()->ctusuar_cargo_code;
        return with(['cargo'=>$cargoUser]) ;
    }
}
