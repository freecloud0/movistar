<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liquidacion;
use App\DetalleGuia;
use Carbon\Carbon;
class LiquidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liqui = Liquidacion::get();
        return $liqui;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function contar_dias(){
        $date=Carbon::now('America/Lima')->toDateString();
        $getDias=DetalleGuia::select('ctdetgu_fecha_reg','ctdetgu_serieProduc','ctdetgu_desc')
        ->where('ctdetgu_undmd_code','=',1)->get();
        foreach ($getDias as $key => $dia) {
            $data=(int)(((strtotime($date)-strtotime($dia->ctdetgu_fecha_reg))/86400)+1);
            if ($data>8) {
                $fecha[]=['dias'=>$data,'series'=>$dia->ctdetgu_serieProduc,'sap'=>$dia->ctdetgu_desc];
            }
        }
        return response()->json(['data'=>$fecha],200);
    }
}
