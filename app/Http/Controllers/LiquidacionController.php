<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\DetalleGuia;
use App\ProductoMaster;
use App\DetalleSalida;
use App\DetailProducto;
use App\Orden;
use App\Liquida;
use Illuminate\Support\Facades\Auth;
use DB;
class LiquidacionController extends Controller
{
    function fechanow(){
        $dates =Carbon::now('America/Lima')->toDateString();
        return $dates;
    }
    public function contar_dias(){
        $getDias=DetailProducto::select('ctdetpr_fecha_reg','ctdetpr_serie','ctdetpr_sap')
        ->where('ctdetpr_esta_code','!=',0)->get();
        foreach ($getDias as $key => $dia) {
            $data=(int)(((strtotime($this->fechanow())-strtotime($dia->ctdetpr_fecha_reg))/86400)+1);
            if ($data>9) {
                $fecha[]=['dias'=>$data,'series'=>$dia->ctdetpr_serie,'sap'=>$dia->ctdetpr_sap,'fechas'=>$dia->ctdetpr_fecha_reg];
            }
        }
         return response()->json(['data'=>$fecha],200);
    }
    public function gettablafecha(Request $request){
        $data=$request->data;
        if ($data=='') {
            $getDias=DetailProducto::select('ctdetpr_fecha_reg','ctdetpr_serie','ctdetpr_sap')
            ->where('ctdetpr_esta_code','=',1)->get();
            foreach ($getDias as $key => $dia) {
                $data=(int)(((strtotime($this->fechanow())-strtotime($dia->ctdetpr_fecha_reg))/86400)+1);
                if ($data>13) {
                    $fecha[]=['dias'=>$data,'series'=>$dia->ctdetpr_serie,'sap'=>$dia->ctdetpr_sap,'fecha'=>$dia->ctdetpr_fecha_reg];
                }
            }
            if ($data==0) {
                $fecha=[];
             }
        }
        else{
            // return $request;
            $fecha=array();
            $getDias=DetailProducto::select('ctdetpr_fecha_reg','ctdetpr_serie','ctdetpr_sap'
            ,'ctdetpr_esta_code')
            ->where('ctdetpr_esta_code','=',1)->where(function($query) use ($data){
                $query->where('ctdetpr_serie', 'LIKE', '%'.$data.'%')
                ->orWhere('ctdetpr_sap', 'LIKE', '%'.$data.'%')
                ->orWhere('ctdetpr_fecha_reg', 'LIKE', '%'.$data.'%');
                })->get();
            foreach ($getDias as $key => $dia) {
                $data=(int)(((strtotime($this->fechanow())-strtotime($dia->ctdetpr_fecha_reg))/86400)+1);
                if ($data>13) {
                    $fecha[]=['dias'=>$data,'series'=>$dia->ctdetpr_serie,'sap'=>$dia->ctdetpr_sap,'fecha'=>$dia->ctdetpr_fecha_reg];
                }
                
            }
        }
       if ($data==0) {
          $fecha=[];
       }
         return response()->json(['seriesLimite'=>$fecha],200);
    }
    public function seriesDevolucion(){
        // $series=DetalleGuia::select('ctdetgu_serieProduc','ctdetgu_code','ctdetgu_userSalida')
        // ->where('ctdetgu_undmd_code','=',1)->get();
        $series=DetalleSalida::join('ctdetpr','ctdetpr.ctdetpr_serie','=','ctdetsa_serie')
        ->select('ctdetsa_serie','ctdetpr_esta_code','ctdetsa_traspaso','ctdetsa_sap')
        ->where('ctdetsa_tipro_code',1)
        ->where('ctdetpr_esta_code',2)  
        ->get();
       
        return response()->json(['data'=>$series],200);
    }
    public function devolucionProductos(Request $request)
    {
    
     $data=$request->serie;
     
     foreach ($data as $key => $d) {
         $numSerie= $d['Numeroserie'];
        $sap=DetailProducto::where('ctdetpr_serie',$numSerie)->pluck('ctdetpr_sap');
        $sapDetalle=$sap->implode($sap);
        $stock=ProductoMaster::where('sap',$sapDetalle)->pluck('ctproduc_stock');
        $stockMaster =$stock->implode($stock);
        $aumentar=$stockMaster+1;
        $actualizarStock=ProductoMaster::where('sap',$sapDetalle)->update(['ctproduc_stock'=>$aumentar]);
        $activarDetalleProducto=DetailProducto::where('ctdetpr_serie',$numSerie)->update(['ctdetpr_esta_code'=>1]);
        $deleteSalidaSerie=DetalleSalida::where('ctdetsa_serie',$numSerie)->delete();
        }   
    }
    public function store(Request $request)
    {
        
         $ordenday=Orden::where('ctorden_numorden',$request->orden)
         ->where('ctorden_fechareg',$this->fechanow())->get();
         if (count($ordenday)==0) {
            $id=Orden::max('ctorden_id');
            $idLiqui=$id+1;
            $store=new Orden();
            $store->ctorden_id=$idLiqui;
            $store->ctorden_numorden=$request->orden;
            $store->ctorden_cliente=$request->cliente;
            $store->ctorden_direccliente=$request->direccion;
            $store->ctorden_codigo=$request->codigo;
            $store->ctorden_userID=$request->idUser;
            $store->ctorden_fechareg=$this->fechanow();
            $store->save();
            return response()->json(['ok'=>true,'data'=>$store],200);
         }else{
            
            return response()->json(['ok'=>false,'data'=>'Esta Orden ya existe'],400);
         }
       
       
    }
    public function update(Request $request)
    {
        //    GET NUMERO DE ORDEN POR USUARIO
        $ordenUpdateGet=Orden::where('ctorden_numorden',$request->orden)
        ->where('ctorden_userID',$request->idUser)
        ->where('ctorden_fechareg',$this->fechanow())->pluck('ctorden_numorden');
       $ordenUconvert=$ordenUpdateGet->implode($ordenUpdateGet);
    //    GET NUMERO DE ORDEN DE TODOS LOS USUARIOs
        $ordenUpdateGetT=Orden::where('ctorden_numorden',$request->orden)
        ->where('ctorden_fechareg',$this->fechanow())->pluck('ctorden_numorden');
        $ordenUconvertT=$ordenUpdateGetT->implode($ordenUpdateGetT);
        // USER
        $userOrden=Orden::join('ctusuar','ctusuar.ctusuar_code','=','ctorden.ctorden_userID')
        ->where('ctorden.ctorden_numorden',$request->orden)
        ->where('ctorden.ctorden_fechareg',$this->fechanow())->pluck('ctusuar.ctusuar_usuario');
        $userO=$userOrden->implode($userOrden);
        // ORDEN ID Y ORDEN
        $or=Orden::where('ctorden_id',$request->ordenid)->pluck('ctorden_numorden');
        $ordenid=$or->implode($or);
       if ($ordenUconvert==$request->orden) {
           if ($ordenid==$request->orden) {
            $this->updateO($request);
           }else{
            return response()->json(['ok'=>false,'error_data'=>'Esta orden ya existe'],400);
           }
           
       }else if ($request->orden==$ordenUconvertT) {
               return response()->json(['ok'=>false,'error'=>'Esta orden le pertenece a '.$userO],400);
           }else{
             $this->updateO($request);
           }
    }
     function updateO($request)
    {
        $ordenu= Orden::findOrFail($request->ordenid);
        $ordenu->ctorden_numorden=$request->orden;
        $ordenu->ctorden_cliente=$request->cliente;
        $ordenu->ctorden_direccliente=$request->direccion;
        $ordenu->ctorden_codigo=$request->codigo;
        $ordenu->ctorden_userID=$request->idUser;
        $ordenu->ctorden_fechareg=$this->fechanow();
        $ordenu->save();
    }
    public function updateOrdenUser(Request $request)
    {
        $ordenuserUpdate= Orden::findOrFail($request->ordenid);
        $ordenuserUpdate->ctorden_numorden=$request->orden;
        $ordenuserUpdate->ctorden_cliente=$request->cliente;
        $ordenuserUpdate->ctorden_direccliente=$request->direccion;
        $ordenuserUpdate->ctorden_codigo=$request->codigo;
        $ordenuserUpdate->ctorden_userID=$request->idUser;
        $ordenuserUpdate->ctorden_fechareg=$this->fechanow();
        $ordenuserUpdate->save();
    }
    public function getOrden(Request $request)
    {
        return $this->orden($request);
    }
    function orden($request)
    {
        $filtro = $request->filtro;
        $orden = Orden::join('ctusuar','ctusuar.ctusuar_code','=','ctorden_userID')
        ->where('ctorden_fechareg',$this->fechanow())
        ->where('ctorden_numorden','like','%'.$filtro.'%')
        ->select('ctorden_id','ctorden_numorden','ctorden_userID','ctusuar.ctusuar_usuario')->take(5)->get();
        return response()->json(['ok'=>true,'orden'=>$orden],200);
    }
    public function getCountorden()
    {
        $orden=Orden::where('ctorden_fechareg',$this->fechanow())->get();
        if (count($orden)==0) {
            return count($orden);
        }else{
            return 1;
        }
    }
    public function storeproducto(Request $request)
    {
      
        $data=$request->lista;
        
        foreach ($data as $key => $producto) {
            if ($producto['tipoID']==1) {
               $this->saveOrden($request,$producto);
               $serie=DetailProducto::where('ctdetpr_serie',$producto['serielista'])
               ->update([ 'ctdetpr_esta_code' => 0]);
               $deleteSerie=DetalleSalida::where('ctdetsa_serie',$producto['serielista'])
               ->where('ctdetsa_colab_id',$request->idUsuario)
               ->delete();
            }elseif ($producto['tipoID']==2) {
                $sapLiqui=Liquida::where('ctliquid_sap',$producto['saplista'])
                ->where('ctliquid_userid',$request->idUsuario)
                ->where('ctliquid_fechareg',$this->fechanow())
                ->where('ctliquid_ordenid', $request->orden)->pluck('ctliquid_cantidad');
                if(count($sapLiqui)==0){
                    $this->saveOrden($request,$producto);
                }else{
                    $convertStock= $sapLiqui->implode($sapLiqui);
                    $sumaStock=$convertStock+$producto['cantidadlista'];
                    $updateStock=Liquida::where('ctliquid_sap',$producto['saplista'])
                    ->where('ctliquid_userid',$request->idUsuario)
                    ->where('ctliquid_fechareg',$this->fechanow())
                    ->where('ctliquid_ordenid', $request->orden)
                    ->update([ 'ctliquid_cantidad' => $sumaStock]);
                }
                
                // STOCK MAXIMO ALMACEN
                $stock=ProductoMaster::where('sap',$producto['saplista'])->pluck('ctproduct_stock_max');
                $stockTotal=$stock->implode($stock);
                $stockactual=$stockTotal-$producto['cantidadlista'];
                // STOCK EN USO
                $stockuso=ProductoMaster::where('sap',$producto['saplista'])->pluck('ctproduc_stock_uso');
                $stockUsoTotal=$stockuso->implode($stockuso);
                $stockUsoAct=$stockUsoTotal-$producto['cantidadlista'];
                $stockMasterA=ProductoMaster::where('sap',$producto['saplista'])
                ->update([ 'ctproduct_stock_max' => $stockactual,'ctproduc_stock_uso' => $stockUsoAct]);

                $stockMUser=DetalleSalida::where('ctdetsa_colab_id',$request->idUsuario)
                ->where('ctdetsa_sap',$producto['saplista'])
                ->pluck('ctdetsa_cantidad');
                $stockTotalMuser=$stockMUser->implode($stockMUser);
              
               if ($stockTotalMuser==$producto['cantidadlista']) {
                    $stocknuevo =DetalleSalida::where('ctdetsa_colab_id',$request->idUsuario)
                    ->where('ctdetsa_tipro_code',2)
                    ->delete();
               }else{
                $resta=$stockTotalMuser-$producto['cantidadlista'];
                $stocknuevo =DetalleSalida::where('ctdetsa_colab_id',$request->idUsuario)
               ->where('ctdetsa_tipro_code',2)
               ->update([ 'ctdetsa_cantidad' => $resta]);
               }
               
            }else{
                $stocknuevo =DetalleSalida::where('ctdetsa_serie',$producto['serielista'])
                ->where('ctdetsa_tipro_code',1)
                ->delete();
            }
            
    }
    
    // return response()->json(['ok'=>true,'equipos'=>$equipo],200);
    }
     function saveOrden($request,$producto)
    {
        $id=Liquida::max('ctliquid_id');
        $idLiquida=$id+1;
        $equipo=new Liquida();
        $equipo->ctliquid_id=$idLiquida;
        $equipo->ctliquid_ordenid=$request->orden; 
        $equipo->ctliquid_sap=$producto['saplista'];
        $equipo->ctliquid_tipoid=$producto['tipoID'];
        $equipo->ctliquid_medidaid=$producto['medidaID'];
        $equipo->ctliquid_cantidad=$producto['cantidadlista'];
        $equipo->ctliquid_serie=$producto['serielista'];
        $equipo->ctliquid_userid=$request->idUsuario;
        $equipo->ctliquid_userlogin=Auth::user()->ctusuar_usuario;
        $equipo->ctliquid_fechareg=$this->fechanow();
        $equipo->save();
    }
    public function liquidarequiposdias(Request $request)
    {
        $data=$request->series;
        foreach ($data as $key => $serie) {
            $serieDB=DetailProducto::where('ctdetpr_serie',$serie['serie'])
            ->update(['ctdetpr_esta_code'=>0]);
            $stockDB=ProductoMaster::where('sap',$serie['sap'])->pluck('ctproduc_stock');
            $stockActual=$stockDB->implode($stockDB);
            $stockFinal=$stockActual-1;
            $sapStockUpdate=ProductoMaster::where('sap',$serie['sap'])->
            update(['ctproduc_stock'=>$stockFinal]);
        }
    }
    public function getDatosLiquidacion(Request $request)
    {
        // return $request;
        return $this->getDatosLiquidacionfecha($request);
    
    }
    public function ordenes(){
        return $this->getOrdenes();
    }
    function getOrdenes()
    {
        $orden=Orden::join('ctusuar','ctusuar.ctusuar_code','=','ctorden.ctorden_userID')
        ->where('ctorden.ctorden_fechareg',$this->fechanow())
        ->select('ctorden.ctorden_id','ctorden.ctorden_numorden','ctorden.ctorden_codigo','ctorden.ctorden_cliente',
        'ctorden.ctorden_direccliente','ctusuar.ctusuar_usuario','ctorden.ctorden_userID')
        ->get();
        return response()->json(['ok'=>true,'ordenes'=>$orden]);
    }
    function getDatosLiquidacionfecha($request)
    {
        $usuario=$request->usuario;
            $getLiqui=Liquida::join('ctorden','ctorden_id','=','ctliquid_ordenid')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctliquid_medidaid')
            ->join('cttipro','cttipro.cttipro_code','=','ctliquid_tipoid')
            ->join('ctusuar','ctusuar.ctusuar_code','=','ctliquid_userid')
            ->select('ctliquid.ctliquid_id','ctorden.ctorden_numorden','ctliquid.ctliquid_sap',
            'ctorden.ctorden_cliente','ctorden.ctorden_direccliente',
            'cttipro.cttipro_desc','ctundmd.ctundmd_desc','ctliquid.ctliquid_cantidad',
            'ctliquid.ctliquid_serie','ctusuar.ctusuar_usuario','ctliquid.ctliquid_userlogin',
            'ctliquid.ctliquid_fechareg')
            ->where('ctliquid.ctliquid_fechareg',$request->fecha)
            ->where('ctliquid.ctliquid_userid',$request->usuario)
            ->get();
            
            
            $ordenUser=Liquida::join('ctorden','ctorden_id','=','ctliquid_ordenid')
            ->select('ctorden.ctorden_id','ctorden_numorden')
            ->where('ctliquid.ctliquid_fechareg',$request->fecha)
            ->where('ctliquid.ctliquid_userid',$request->usuario)
            ->groupby('ctorden.ctorden_id')
            ->get();
        return ['lista'=>$getLiqui,'ordenUser'=>$ordenUser];
        //  return $sumaProducto;
        
    }
    public function EMordenUsuario(Request $request)
    {
        $suma=Liquida::join('ctorden','ctorden_id','=','ctliquid_ordenid')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctliquid_medidaid')
            ->join('cttipro','cttipro.cttipro_code','=','ctliquid_tipoid')
            ->join('ctusuar','ctusuar.ctusuar_code','=','ctliquid_userid')
            ->where('ctliquid.ctliquid_fechareg',$request->fecha)
            ->where('ctliquid.ctliquid_userid',$request->usuario)
            ->where('ctliquid.ctliquid_tipoid',1)
            ->where('ctliquid.ctliquid_ordenid',$request->ordenID)
            ->sum('ctliquid.ctliquid_cantidad');
        $EOrden=Liquida::join('ctorden','ctorden_id','=','ctliquid_ordenid')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctliquid_medidaid')
            ->join('cttipro','cttipro.cttipro_code','=','ctliquid_tipoid')
            ->join('ctusuar','ctusuar.ctusuar_code','=','ctliquid_userid')
            ->select('ctliquid_sap','ctliquid_serie')
            ->where('ctliquid.ctliquid_fechareg',$request->fecha)
            ->where('ctliquid.ctliquid_userid',$request->usuario)
            ->where('ctliquid.ctliquid_tipoid',1)
            ->where('ctliquid.ctliquid_ordenid',$request->ordenID)
           
            ->get();
            $MOrden=Liquida::join('ctorden','ctorden_id','=','ctliquid_ordenid')
            ->join('ctundmd','ctundmd.ctundmd_code','=','ctliquid_medidaid')
            ->join('cttipro','cttipro.cttipro_code','=','ctliquid_tipoid')
            ->join('ctusuar','ctusuar.ctusuar_code','=','ctliquid_userid')
            ->select('ctliquid_sap','ctliquid_cantidad','ctundmd_desc')
            ->where('ctliquid.ctliquid_fechareg',$request->fecha)
            ->where('ctliquid.ctliquid_userid',$request->usuario)
            ->where('ctliquid.ctliquid_tipoid',2)
            ->where('ctliquid.ctliquid_ordenid',$request->ordenID)
            ->get();
        $clienteUser=Orden::where('ctorden_id',$request->ordenID)
        ->select('ctorden_cliente','ctorden_direccliente')
        ->get();
        return ['total'=>$suma,'Equipos'=>$EOrden,'Materiales'=>$MOrden,'cliente'=>$clienteUser];
    }
    public function vertecnicos(Request $request)
    {
        $now = Carbon::now('America/Lima')->format('Y-m-d h:i:s');
        $getDias=DetalleSalida::select('ctdetsa_fecha_reg','ctdetsa_serie','ctdetsa_sap')
        // ->where('ctdetsa_traspaso','=',Auth::user()->ctusuar_usuario)
        ->where('ctdetsa_tipro_code','=',1)->get();
        foreach ($getDias as $key => $dia) {
                    $data=round((((strtotime($now)-strtotime($dia->ctdetsa_fecha_reg))/86400)));
                    // $data 	= abs($data); $data = floor($data);
                    
                        $fecha[]=['dias'=>$data,'series'=>$dia->ctdetsa_serie,'sap'=>$dia->ctdetsa_sap,'fecha'=>$dia->ctdetsa_fecha_reg];
                   
                    
                }
    
                return [$fecha,$now];
        // $now = Carbon::now('America/Lima')->format('m/d/Y h:i:s');
        // return $now.' '.$request;
    }

}
