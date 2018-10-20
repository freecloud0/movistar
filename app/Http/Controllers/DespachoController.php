<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salida;
use App\Sot;
use App\User;
use App\DetailProducto;
use App\ProductoMaster;
use App\DetalleGuia;
use Carbon\Carbon;
use App\DetalleSalida;
// modelo liquidacion nuevo
use App\Liquidacion;
use Illuminate\Support\Facades\Auth;

use Validator;
use DB;
class DespachoController extends Controller
{
    public function index(Request $request)
    {
      if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $salidas=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_salid_nro',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad',
            'ctdetsa.ctdetsa_fecha_reg','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_undmdDescri',
            'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_produDescri')
            ->wherenull('ctdetsa_reportar')
            ->wherenull('ctdetsa_fechaReporte')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->paginate(10);
        }else {
            $salidas=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_salid_nro',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad',
            'ctdetsa.ctdetsa_fecha_reg','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_undmdDescri',
            'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_produDescri')
            ->wherenull('ctdetsa_reportar')
            ->wherenull('ctdetsa_fechaReporte')
            ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->paginate(10);
           
        }
        return [
            'pagination'=>[
                    'total'=>$salidas->total(),
                    'current_page'=>$salidas->currentPage(),
                    'per_page'=>$salidas->perPage(),
                    'last_page'=>$salidas->lastPage(),
                    'from'=>$salidas->firstItem(),
                    'to'=>$salidas->lastItem(),
            ],
            'salidas'=>$salidas
        ];
    }
    // Mostrar SALIDA DE EQUIPOS
    public function SalidaEquipo(Request $request)
    {
      if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $salidas=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_salid_nro',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad',
            'ctdetsa.ctdetsa_fecha_reg','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_undmdDescri',
            'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_produDescri')
            ->wherenull('ctdetsa_reportar')
            ->wherenull('ctdetsa_fechaReporte')
            ->where('ctdetsa_tipro_code','=',1)
            ->orderby('ctdetsa.ctdetsa_indice','desc')->get();
        }else {
            $salidas=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_salid_nro',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad',
            'ctdetsa.ctdetsa_fecha_reg','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_undmdDescri',
            'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_produDescri')
            ->wherenull('ctdetsa_reportar')
            ->wherenull('ctdetsa_fechaReporte')
            ->where('ctdetsa_tipro_code','=',1)
            ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->get();
           
        }
        return [
            
            'salidas'=>$salidas
        ];
    }
    // MOSTRAR SALIDA DE MATERIAL
    public function SalidaMaterial(Request $request)
    {
    //  if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $salidas=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_salid_nro',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad',
            'ctdetsa.ctdetsa_fecha_reg','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_undmdDescri',
            'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_produDescri')
            ->wherenull('ctdetsa_reportar')
            ->wherenull('ctdetsa_fechaReporte')
            ->where('ctdetsa_tipro_code','=',2)
            ->orderby('ctdetsa.ctdetsa_indice','desc')->get();
        }else {
            $salidas=DetalleSalida::select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_salid_nro',
            'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad',
            'ctdetsa.ctdetsa_fecha_reg','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_undmdDescri',
            'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_produDescri')
            ->wherenull('ctdetsa_reportar')
            ->wherenull('ctdetsa_fechaReporte')
            ->where('ctdetsa_tipro_code','=',2)
            ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
            ->orderby('ctdetsa.ctdetsa_indice','desc')->get();
           
        }
        return [
            
            'salidas'=>$salidas
        ];
    }

    public function obtenerProduserie(Request $request)
    {
    //  if (!$request->ajax()) return redirect('/');
    
        $buscar =$request->buscar;
            $series=DB::select('call BucarSerieEquipo(?)',[$buscar]);

        return ['series'=>$series];
    }
    public function obtenerProdusap(Request $request)
    {
      
    //   if (!$request->ajax()) return redirect('/');
    
        $buscar =$request->buscar1;
        $series=DB::select('call obtenerProdusap(?)',[$buscar]);
        return ['series'=>$series];
    }
    public function almacenTotaEquiposTec(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if (Auth::user()->ctusuar_cargo_code==1) {
            
            if ($buscar=='') {
               
                $almacen=DetalleSalida::crossjoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_indice',
                'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act'
                ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg')
                ->where('ctdetsa.ctdetsa_esta_code','=',2)
                ->where('ctdetsa.ctdetsa_tipro_code','=',1)
                ->groupBy('ctdetsa.ctdetsa_indice')
                ->orderby('ctdetsa.ctdetsa_sot','desc')->paginate(10);

                

            }else {
                $almacen=DetalleSalida::crossjoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_indice',
                'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act'
                ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg')
                ->where('ctdetsa.ctdetsa_tipro_code','=',1)
                ->where('ctdetsa.ctdetsa_esta_code','=',2)
                ->groupBy('ctdetsa.ctdetsa_indice')
                ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
                ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
               
            }
    
    
            return [
                'pagination'=>[
                    'total'=>$almacen->total(),
                    'current_page'=>$almacen->currentPage(),
                    'per_page'=>$almacen->perPage(),
                    'last_page'=>$almacen->lastPage(),
                    'from'=>$almacen->firstItem(),
                    'to'=>$almacen->lastItem(),
                ],
                'almacen'=>$almacen
        
            ];
        }else{
            if ($buscar=='') {
                
                $almacen=DetalleSalida::crossjoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_indice',
                'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act'
                ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg')
                  ->where('ctdetsa.ctdetsa_traspaso','=',Auth::user()->ctusuar_usuario)
                  ->where('ctdetsa.ctdetsa_esta_code','=',2)
                 ->where('ctdetsa.ctdetsa_tipro_code','=',1)
                    
                  ->groupBy('ctdetsa.ctdetsa_indice')
                //  ->where('ctproduc.ctproduc_usuario','=',Auth::user()->ctusuar_usuario)
                ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
            }else {
                $almacen=DetalleSalida::crossjoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_usuario','ctdetsa.ctdetsa_indice',
                'ctdetsa_esta_code','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie','ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act'
                ,'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_detgu_fecha_reg')
                  ->where('ctdetsa.ctdetsa_traspaso','=',Auth::user()->ctusuar_usuario)
                  ->where('ctdetsa.ctdetsa_esta_code','=',2)
                  ->where('ctdetsa.ctdetsa_tipro_code','=',1)
                  ->groupBy('ctdetsa.ctdetsa_indice')
                  ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
                 ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
               
            }
    
    
            return [
                'pagination'=>[
                    'total'=>$almacen->total(),
                    'current_page'=>$almacen->currentPage(),
                    'per_page'=>$almacen->perPage(),
                    'last_page'=>$almacen->lastPage(),
                    'from'=>$almacen->firstItem(),
                    'to'=>$almacen->lastItem(),
                ],
                'almacen'=>$almacen
        
            ];
        }
       
        
    }

    public function almacenTotaMaterialesTec(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
       

        if (Auth::user()->ctusuar_cargo_code==1) {
            if ($buscar=='') {
                $almacen=DetalleSalida::crossJoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_indice','ctsalid.ctsalid_sot_id','ctdetsa.ctdetsa_salid_nro','ctdetsa.ctdetsa_usuario',
                'ctdetsa.ctdetsa_undmdDescri', 'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie',
                'ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_roduc_id',
                'ctdetsa.ctdetsa_undmd_code','ctdetsa.ctdetsa_tipro_code'
                ,'ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_produDescri'
                ,'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_fecha_reg')
                ->where('ctdetsa.ctdetsa_tipro_code','=',2)	
                ->wherenull('ctdetsa_reportar')
                ->wherenull('ctdetsa_fechaReporte')
                ->groupBy('ctdetsa.ctdetsa_indice')
                ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
            }else {
                $almacen=DetalleSalida::crossJoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_indice','ctsalid.ctsalid_sot_id','ctdetsa.ctdetsa_salid_nro','ctdetsa.ctdetsa_usuario',
                'ctdetsa.ctdetsa_undmdDescri', 'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie',
                'ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_roduc_id',
                'ctdetsa.ctdetsa_undmd_code','ctdetsa.ctdetsa_tipro_code'
                ,'ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_produDescri'
                ,'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_fecha_reg')
                ->where('ctdetsa.ctdetsa_tipro_code','=',2)	
                ->groupBy('ctdetsa.ctdetsa_indice')
                ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
                ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
               
            }
            return [
                'pagination'=>[
                    'total'=>$almacen->total(),
                    'current_page'=>$almacen->currentPage(),
                    'per_page'=>$almacen->perPage(),
                    'last_page'=>$almacen->lastPage(),
                    'from'=>$almacen->firstItem(),
                    'to'=>$almacen->lastItem(),
                ],
                'almacen'=>$almacen
        
            ];
        }else{
            if ($buscar=='') {
                $almacen=DetalleSalida::crossJoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_indice','ctsalid.ctsalid_sot_id','ctdetsa.ctdetsa_salid_nro','ctdetsa.ctdetsa_usuario',
                'ctdetsa.ctdetsa_undmdDescri', 'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie',
                'ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_roduc_id',
                'ctdetsa.ctdetsa_undmd_code','ctdetsa.ctdetsa_tipro_code'
                ,'ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_produDescri'
                ,'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_fecha_reg')
                ->wherenull('ctdetsa_reportar')
                ->wherenull('ctdetsa_fechaReporte')

                ->where('ctdetsa.ctdetsa_tipro_code','=',2)	
                ->where('ctdetsa.ctdetsa_traspaso','=',Auth::user()->ctusuar_usuario)
                ->groupBy('ctdetsa.ctdetsa_indice')
                ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
            }else {
                $almacen=DetalleSalida::crossJoin('ctsalid')
                ->join('ctcolab','ctcolab.ctcolab_id','ctsalid.ctsalid_colab_id')
                ->join('ctusuar','ctusuar.ctusuar_colab_id','ctcolab.ctcolab_id')
                ->select('ctdetsa.ctdetsa_indice','ctsalid.ctsalid_sot_id','ctdetsa.ctdetsa_salid_nro','ctdetsa.ctdetsa_usuario',
                'ctdetsa.ctdetsa_undmdDescri', 'ctdetsa.ctdetsa_sap','ctdetsa.ctdetsa_serie',
                'ctdetsa.ctdetsa_cantidad','ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_traspaso',
                'ctdetsa.ctdetsa_colab_id','ctdetsa.ctdetsa_sot','ctdetsa.ctdetsa_roduc_id',
                'ctdetsa.ctdetsa_undmd_code','ctdetsa.ctdetsa_tipro_code'
                ,'ctdetsa.ctdetsa_fecha_act','ctdetsa.ctdetsa_fecha_traspaso','ctdetsa.ctdetsa_produDescri'
                ,'ctdetsa.ctdetsa_descriTipo','ctdetsa.ctdetsa_fecha_reg')
                ->wherenull('ctdetsa_reportar')
                ->wherenull('ctdetsa_fechaReporte')
                 ->where('ctdetsa.ctdetsa_tipro_code','=',2)
                 ->where('ctdetsa.ctdetsa_traspaso','=',Auth::user()->ctusuar_usuario)
                 ->groupBy('ctdetsa.ctdetsa_indice')
                 ->where('ctdetsa.'.$criterio,'like','%' .$buscar. '%')
                 ->orderby('ctdetsa.ctdetsa_serie','desc')->paginate(10);
               
            }
    
    
            return [
                'pagination'=>[
                    'total'=>$almacen->total(),
                    'current_page'=>$almacen->currentPage(),
                    'per_page'=>$almacen->perPage(),
                    'last_page'=>$almacen->lastPage(),
                    'from'=>$almacen->firstItem(),
                    'to'=>$almacen->lastItem(),
                ],
                'almacen'=>$almacen
        
            ];
        }
       
        
    }
    
    public function store(Request $request)
    {   
       
    //    return $request;      
         if (!$request->ajax()) return redirect('/');
         $date =Carbon::now('America/Lima')->toDateTimeString();
         $dateconvert =(string) $date;
         //CAPTURAR USUARIO TRASLADO
         $user=new User();
         $user->ctusuar_code=$request->usuario_id;
         $usereplace = str_replace('{"ctusuar_code":',"",$user);
         $usereplacefinal = str_replace('}',"",$usereplace);
         $usuario =User::where('ctusuar_code',$usereplacefinal)
         ->select('ctusuar_usuario')->pluck('ctusuar_usuario');
         $usuarioreplace = str_replace('["',"",$usuario);
         $usuarioreplacefinal = str_replace('"]',"",$usuarioreplace);
         //REGISTRAR SALIDA
         $id=Salida::max('ctsalid_nro');
         $idmas=$id+1;
         $salida= new Salida();
         $salida->ctsalid_nro=$idmas;
         $salida->ctsalid_colab_id=$request->usuario_id;
        //  $salida->ctsalid_sot_id=$request->sot;
         $salida->ctsalid_fecha_act=$request->fechaLlegada;
         $salida->ctsalid_usuario=Auth::user()->ctusuar_usuario;
         $salida->save();
         //REGISTRAR DETALLE SALIDA
         $guiaIncrementar=$request->incrementar;
         $detail=$request->data;
         foreach ($detail as $ep => $det) {
           
             //CAPTURAR TIPO DE PRODUCTO DATA
            $tipoDeProducto=$det['detaTi'];
            
            //IF
            if ($tipoDeProducto==1) {
            //CAPTURAR UNIDAD MEDIDA DATA
            $unidaMedida=$det['uni'];
             //CAPTURAR SAP DE DATA
            $codigoSapProducto=$det['conte'];
             //CAPTURAR ID DE  DATA
            $idEquipoDetalle=$det['idProduct'];
            //SERIE DEL PRODUCTO
            $serieProducto=$det['prod01'];
           
            //NOMBRE DEL PRODUCTO
            $productonombre=$det['prodescri'];
            
            //REGISTRAR DETALLE SALIDA EQUIPO 1
          
            $detallessalida=new DetalleSalida();
            $idet=DetalleSalida::max('ctdetsa_indice'); 
            $idetmas=$idet+1;
            $detallessalida->ctdetsa_indice=$idetmas;
            $detallessalida->ctdetsa_salid_nro=$idmas;
            // $detallessalida->ctdetsa_sot=$request->sot;
            $detallessalida->ctdetsa_roduc_id=$det['idProduct'];
            $detallessalida->ctdetsa_serie=$det['prod01'];
            $detallessalida->ctdetsa_fecha_reg=$dateconvert;
            $detallessalida->ctdetsa_fecha_act=$dateconvert;
            $detallessalida->ctdetsa_undmd_code=$det['uni'];
            $detallessalida->ctdetsa_tipro_code=$det['detaTi'];
            $detallessalida->ctdetsa_produDescri=$det['prodescri'];
            $detallessalida->ctdetsa_numguiatecnico=$guiaIncrementar;
            //REGISTRAR USUARIO DE SALIDA
            $userSalida=DetalleGuia::where('ctdetgu_serieProduc', $serieProducto)
            ->update([
            'ctdetgu_code' => 2,
            'ctdetgu_userSalida'=>$usuarioreplacefinal
            ]);
            //OBTENER FECHA DE REGISTRO
            $detalleGuia=DetalleGuia::where('ctdetgu_serieProduc',$serieProducto)
            ->where('ctdetgu_desc',$codigoSapProducto)
            ->select('ctdetgu_fecha_reg')->get();
            // return $detalleGuia;
            $fecha = str_replace('[{"ctdetgu_fecha_reg":"',"",$detalleGuia);
            $fechaRegistro = str_replace('"}]',"",$fecha); 
            // return $fechaRegistro;
            $detallessalida->ctdetsa_detgu_fecha_reg=$fechaRegistro;
            $detallessalida->ctdetsa_undmdDescri='Unidad';
            $detallessalida->ctdetsa_descriTipo=$det['tipodescri'];
            $detallessalida->ctdetsa_colab_id=$request->usuario_id;
            $detallessalida->ctdetsa_sap=$det['conte'];
            $detallessalida->ctdetsa_cantidad=1;
            $detallessalida->ctdetsa_esta_code=2;
            $detallessalida->ctdetsa_traspaso=$usuarioreplacefinal;
            $detallessalida->ctdetsa_usuario=Auth::user()->ctusuar_usuario;
            $detallessalida->save();

            $estadoDetalleProducto=DetailProducto::where('ctdetpr_produc_id', $idEquipoDetalle)
            ->where('ctdetpr_serie', $serieProducto)->where('ctdetpr_sap', $codigoSapProducto)
            ->where('ctdetpr_undmd_code', $unidaMedida)
            ->update([
            'ctdetpr_esta_code' => 2,
            ]);
            
             //CAPTURAR STOCK DE PRODUCTO CTPRODUC
             $stockEquipo=ProductoMaster::where('ctproduc_id',$idEquipoDetalle)
             ->select('ctproduc_stock')->get();
             $stockEquipoJson = str_replace('[{"ctproduc_stock":',"",$stockEquipo);
             $stockEquipoReplace = str_replace('}]',"",$stockEquipoJson);

            //ACTUALIZAR STOCK DE PRODUCTO SEGUN ID
            $resta=$stockEquipoReplace -1;
            $descontarstockMaterial =ProductoMaster::where('ctproduc_id', $idEquipoDetalle)
             ->update([
            'ctproduc_stock' => $resta]);


            }elseif ($tipoDeProducto==2) {
                
                $idMaterialDetalle=$det['productoID'];
                //DATOS PARA GUARDAR EN DETALLE DE SALIDA
                //CAPTURAR STOCK DE PRODUCTO CTPRODUC
                $stockMaterial=ProductoMaster::where('ctproduc_id',$idMaterialDetalle)
                ->select('ctproduc_stock')->orderby('ctproduc_id')->get();
                $stockMaterialJson = str_replace('[{"ctproduc_stock":',"",$stockMaterial);
                $stockMaterialReplace = str_replace('}]',"",$stockMaterialJson);
                //CAPTURAR CANTIDAD DATA
                $cantidad=$det['cantidadProducto'];
                if ($cantidad>$stockMaterialReplace) {
                    return ['minimostock',$minimostock];
                }else{
                    //ACTUALIZAR STOCK DE PRODUCTO SEGUN ID
                    $resta=$stockMaterialReplace -$cantidad;
                    $descontarstockMaterial =ProductoMaster::where('ctproduc_id', $idMaterialDetalle)
                     ->update([
                    'ctproduc_stock' => $resta,
                    ]);
                    //REGISTRAR DETALLE SALIDA 1
                        $detallessalida=new DetalleSalida();
                        $idet=DetalleSalida::max('ctdetsa_indice');
                        $idetmas=$idet+1;
                        $detallessalida->ctdetsa_indice=$idetmas;
                        // $detallessalida->ctdetsa_sot=$request->sot; 
                        $detallessalida->ctdetsa_salid_nro=$idmas;
                        $detallessalida->ctdetsa_roduc_id=$det['productoID'];
                        $detallessalida->ctdetsa_undmd_code=$det['UnidadID'];
                        $detallessalida->ctdetsa_tipro_code=$det['detaTi'];
                        $detallessalida->ctdetsa_sap=$det['sapProducto'];
                        $detallessalida->ctdetsa_descriTipo=$det['tipodescri'];
                        $detallessalida->ctdetsa_produDescri=$det['productoDescripcion'];
                        $detallessalida->ctdetsa_cantidad=$det['cantidadProducto'];
                        $detallessalida->ctdetsa_undmdDescri=$det['unidadDescripcion'];
                        $detallessalida->ctdetsa_fecha_act=$dateconvert;
                        $detallessalida->ctdetsa_fecha_reg=$dateconvert;
                        $detallessalida->ctdetsa_colab_id=$request->usuario_id;
                        $detallessalida->ctdetsa_traspaso=$usuarioreplacefinal;
                        $detallessalida->ctdetsa_usuario=Auth::user()->ctusuar_usuario;
                        $detallessalida->save();
                }
            }
           
            
           
        }
         

    }
   //traslados de Equipos entre Tecnicos
    public function update(Request $request)
    {
        //    return $request;  
        if (!$request->ajax()) return redirect('/');
          //CAPTURAR NOMBRE DE USUARIO
          $nombreUsuario=$request->idUsuario;
          $usuarionombre =User::where('ctusuar_code',$nombreUsuario)
          ->select('ctusuar_usuario')->get();
          $usuariofinaljson = str_replace('[{"ctusuar_usuario":"',"",$usuarionombre);
          $usuariofinaljson1 = str_replace('"}]',"",$usuariofinaljson);

          if ($nombreUsuario==null) {
           
            $msjUser='Elija un Usuario a trasladar';
            return with(['msjUser' => $msjUser]);
        }
        elseif (Auth::user()->ctusuar_usuario==$usuariofinaljson1) {
            
            
            $msj='No puedes ser el usuario de traslado';
            return with(['msj' => $msj]);
        }else{
        //CAPTURAR SERIE DE EQUIPO PARA TRASLADO
        $serieEquipo=$request->serie;
        //CAPTURAR USUARIO PARA TRASLADO
        $idUsuario=$request->idUsuario;
        //CAPTURAR FECHA DE TRASLADO
        $fechadetraslado=$request->fecha;
        //CAPTURAR OBSERVACION 
        $observacion=$request->observacion;
        // CAPTURAR INDICE DE DETALLE SALIDA
        $indice=$request->indice;
        
        // CARGAR INDICE DE BASE DE DATOS
        $SalidaIndice=DetalleSalida::where('ctdetsa_indice',$indice)->get();
        // CARGAR OBservacion DE BASE DE DATOS
        $observacionBD=DetalleSalida::where('ctdetsa_indice',$indice)->select('ctdetsa_observacion')->get();
        $observacionInicio = str_replace('[{"ctdetsa_observacion":',"",$observacionBD);
        $ObservacionFInal = str_replace('}]',"",$observacionInicio);
        // return $ObservacionFInal;
       
            $newUsuario =DetalleSalida::where('ctdetsa_serie', $serieEquipo)
            ->where('ctdetsa_indice',$indice)
            ->update([
            'ctdetsa_colab_id' => $idUsuario,
            // 'ctdetsa_userDespacho' => Auth::user()->ctusuar_usuario,
            'ctdetsa_cantidad' => 1,
            'ctdetsa_fecha_traspaso' => $fechadetraslado,
            'ctdetsa_fecha_act' => $fechadetraslado,
            'ctdetsa_observacion' =>'De: '.Auth::user()->ctusuar_usuario.' Para: '.$usuariofinaljson1.' '.
            'Detalle: '.$observacion,
            'ctdetsa_traspaso' => $usuariofinaljson1]);

            //ACTUALIZAR USUARIO DE SALIDA
            $userSalida=DetalleGuia::where('ctdetgu_serieProduc', $serieEquipo)
            ->update([
            'ctdetgu_userSalida'=>$usuariofinaljson1
            ]);
       
        return response()->json('Actualizado Correctamente', 200);
        }
    }
    //traslados de materiales entre Tecnicos
    public function updateM(Request $request)
    {
        //  return $request;
        if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateString();
        $dateconvert =(string) $date;
       
        //FECHA DE REGISTRO
        $fechaInicio=$request->fechaInicio;
        // return $fechaInicio;
        //CAPTURAR INDICE SALIDA
        $indice=$request->indiceSalida;
        //CAPTURAR SAP DE MATERIAL
        $sap=$request->sap;
        //CAPTURAR SOT DE MATERIAL
        $sot=$request->sot;
        //CAPTURAR DESCRIPCION DEL PRODUCTO DE MATERIAL
        $productodescripcion=$request->produdescri;
        
        //CAPTURAR DESCRIPCION TIPO DE PRODUCTO
        $tipodescri=$request->tipodescri;
        
        // return $tipodescri;
        //CAPTURAR ID DEL COLABORADOR
        $Usuario=$request->idUsuario;
        
        //CAPTURAR NOMBRE DE USUARIO 
        $traslados2= new DetalleSalida();
        $traslados2->ctdetsa_usuario=$request->idUsuario;
        $usuarionombrejson = str_replace('{"ctdetsa_usuario":',"",$traslados2);
        $usuarionombrejson1 = str_replace('}',"",$usuarionombrejson);
        $usuarionombre =User::where('ctusuar_code',$usuarionombrejson1)
        ->select('ctusuar_usuario')->get();
        $usuariofinaljson = str_replace('[{"ctusuar_usuario":"',"",$usuarionombre);
        $usuariofinaljson1 = str_replace('"}]',"",$usuariofinaljson);
        //CAPTURAR FECHA 
        $fechadetraslado=$request->fecha;
        //CAPTURAR NUEVA CANTDAD 
        $cantidad=$request->cantidadnueva;
        // CAPTURAR NUEVA CANTIDAD TRASPASO
        $cantidadtraslado=$request->cantidadtraspaso;
        //CAPTURAR OBSERVACION
        $observacion=$request->observacion;
        $observacionDetalle='Observacion: '.$observacion.' Usuario: '.$usuariofinaljson1;
        //CAPTURAR ID SALIDA
        $salida=$request->idSalida;
        if ($Usuario==null) {
           
            $msjUser='Elija un Usuario a trasladar';
            return with(['msjUser' => $msjUser]);
        }
       elseif (Auth::user()->ctusuar_usuario==$usuariofinaljson1) {
            
            
            $msj='No puedes ser el usuario de traslado';
            return with(['msj' => $msj]);
        }else{
        //ACTUALIZANDO STOCK DE SALIDA DE MATERIALES
        if ($cantidad==0) {
           
            // //ELIMINDANDO FILA SI LA CANTIDAD ES = A CERO
            // $newUsuario =DetalleSalida::where('ctdetsa_sap', $sap)
            //     ->where('ctdetsa_indice',$indice)
            //     ->delete();
            // return 'HOLA';
            $newUsuario =DetalleSalida::where('ctdetsa_sap', $sap)
            ->where('ctdetsa_indice',$indice)
            ->update([
                'ctdetsa_observacion' => $observacionDetalle,
                'ctdetsa_traspaso' => $usuariofinaljson1,
                'ctdetsa_cantidad_traspaso' => $cantidadtraslado,
                'ctdetsa_usuario' => Auth::user()->ctusuar_usuario,
               ]);
        }else{
        $newUsuario =DetalleSalida::where('ctdetsa_sap', $sap)
        ->where('ctdetsa_indice',$indice)
        ->update([
            'ctdetsa_observacion' => $observacionDetalle,
            'ctdetsa_cantidad' => $cantidad,
            'ctdetsa_cantidad_traspaso' => $cantidadtraslado,
            // 'ctdetsa_usuario' => Auth::user()->ctusuar_usuario,
           ]);
             //Creando nuevo registro para el tecnico que recibio los materiales
        
        $idindice=DetalleSalida::max('ctdetsa_indice');
        $idindicemas=$idindice+1;
        $materialuser=new DetalleSalida();
        $materialuser->ctdetsa_indice=$idindicemas;
        $materialuser->ctdetsa_salid_nro=$salida;
        $materialuser->ctdetsa_roduc_id=$request->idProducto;
        $materialuser->ctdetsa_produDescri=$productodescripcion;
        $materialuser->ctdetsa_descriTipo=$tipodescri;
        $materialuser->ctdetsa_undmd_code=$request->unidadMedida;
        $materialuser->ctdetsa_undmdDescri=$request->descripcionMedida;
        $materialuser->ctdetsa_tipro_code=$request->TipoDeProducto;
        $materialuser->ctdetsa_observacion=$request->observacionDetalle;
        $materialuser->ctdetsa_sap=$request->sap;
        $materialuser->ctdetsa_cantidad=$cantidadtraslado;
        $materialuser->ctdetsa_fecha_act=$fechadetraslado;
        $materialuser->ctdetsa_fecha_reg=$fechaInicio;
        $materialuser->ctdetsa_traspaso=$usuariofinaljson1;
        $materialuser->ctdetsa_colab_id=$Usuario;
        $materialuser->ctdetsa_fecha_traspaso=$fechadetraslado;
        $materialuser->ctdetsa_usuario=Auth::user()->ctusuar_usuario;
        // return $materialuser;
        $materialuser->save();

        }
        }
      
       return response()->json('Actualizado Correctamente', 200);

    }

    public function desactivarEquipo(Request $request)
    {
        // return $request;    
        if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateTimeString();
        $dateconvert =(string) $date;
    //INDICE DE DETALLE PRODUCTO
     $vendidos= new DetalleSalida();
     $vendidos->ctdetsa_esta_code=$request->idEquipo;
     $estadojson = str_replace('{"ctdetsa_esta_code":',"",$vendidos);
     $estadosjson1 = str_replace('}',"",$estadojson);
    //STOCK PRODUCTO PARA DESCONTAR
     $productoDesc =DetalleSalida::crossjoin('ctdetpr')
    ->join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
    ->select('ctproduc.ctproduc_stock')
    ->where('ctdetsa_indice',$estadosjson1)
    ->groupby('ctproduc.ctproduc_stock')->get();
    $stockreplace = str_replace('[{"ctproduc_stock":',"",$productoDesc);
    $stockreplacefinal = str_replace('}]',"",$stockreplace);
    //SAP PRODUCTO 
    $sapproducto =DetalleSalida::crossjoin('ctdetpr')
    ->join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
    ->select('ctproduc.sap')
    ->where('ctdetsa_indice',$estadosjson1)->get();
    $sapreplace = str_replace('[{"sap":',"",$sapproducto);
    $sapreplacefinal = str_replace('}]',"",$sapreplace);
    
    //SERIE DEL PRODUCTO
    $serieproducto =DetalleSalida::select('ctdetsa_serie')
    ->where('ctdetsa_indice',$estadosjson1)->get();
    $seriereplace = str_replace('[{"ctdetsa_serie":"',"",$serieproducto);
    $seriereplacefinal = str_replace('"}]',"",$seriereplace);
    //ID DEL PRODUCTO
    $idproducto =DetalleSalida::crossjoin('ctdetpr')
    ->join('ctproduc','ctproduc.ctproduc_id','=','ctdetpr.ctdetpr_produc_id')
    ->select('ctproduc.ctproduc_id')
    ->where('ctdetsa_indice',$estadosjson1)->get();
    $idreplace = str_replace('[{"ctproduc_id":',"",$idproducto);
    $idreplacefinal = str_replace('}]',"",$idreplace);
     //ACTUALIZAR STOCK
     $newUsuario =DetalleSalida::where('ctdetsa_indice', $estadosjson1)
    ->delete(); 
    //OCULTAR PRODUCTO CON SERIE IDENTIFICADA
    
    $serie =DetailProducto::where('ctdetpr_serie', $seriereplacefinal)
    ->delete();
    //MOSTRAR MENSAJE ELIMINADO
    //ELIMINAR DE DETALLE GUIA
    $serieGuia =DetalleGuia::where('ctdetgu_serieProduc', $seriereplacefinal)
    ->delete();
    
    }
    public function devolverMaterialAlmacen(Request $request)
    {
        //   return $request;
        //OCULTAR MATERIAL CON SERIE E INDICE IDENTIFICADO
       
        if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateTimeString();
        $dateconvert =(string) $date;

        $cantidad=$request->cantidadnueva;
        $cantidadTraspaso=$request->cantidadtraspaso;
        $idProducto=$request->idProducto;
        // INDICE
        $indiceSalida=$request->indiceSalida;
        // CANTIDAD 
        $cantidad=$request->cantidadnueva;

        $obtenerIdProductoBD =DetalleSalida::where('ctdetsa_indice', $indiceSalida)
        ->where('ctdetsa_roduc_id', $idProducto)->select('ctdetsa_roduc_id')->get();
        $idMasterPro = str_replace('[{"ctdetsa_roduc_id":',"",$obtenerIdProductoBD);
        $idMasterProducto = str_replace('}]',"",$idMasterPro);
        //  STOCK DE MASTER PRODUCTO
        $stockProducto=ProductoMaster::where('ctproduc_id',$idMasterProducto)
        ->select('ctproduc_stock')->get();
        $stockProdu = str_replace('[{"ctproduc_stock":',"",$stockProducto);
        $stockFinal = str_replace('}]',"",$stockProdu);

        if ($cantidad==0) {
            $suma=$stockFinal+$cantidadTraspaso;
            $stocknuevo =ProductoMaster::where('ctproduc_id', $idMasterProducto)
            ->update([ 'ctproduc_stock' => $suma, ]);
            $serie =DetalleSalida::where('ctdetsa_indice', $indiceSalida)
            ->delete();

        }else {
            $serie =DetalleSalida::where('ctdetsa_indice', $indiceSalida)
            ->update([ 'ctdetsa_cantidad' => $cantidad,'ctdetsa_fecha_act'=>$dateconvert ]);
           
            $suma=$stockFinal+$cantidadTraspaso;
            $stocknuevo =ProductoMaster::where('ctproduc_id', $idMasterProducto)
            ->update([ 'ctproduc_stock' => $suma]);
           
        }
        
    }

    public function LiquidarMaterialAlmacen(Request $request)
    {
        //  return $request;
        if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateTimeString();
        $dateconvert =(string) $date;
        $indiceSalida=$request->indiceSalida;
        $cantidadnueva=$request->cantidadnueva;
        $idproductoMate=$request->idProducto;
        if ($cantidadnueva==0) {
            $stocknuevo =DetalleSalida::where('ctdetsa_indice', $indiceSalida)
            ->delete();
        }else{
            $stocknuevo =DetalleSalida::where('ctdetsa_indice', $indiceSalida)
            ->update([ 'ctdetsa_cantidad' => $cantidadnueva,'ctdetsa_fecha_act'=>$dateconvert]);
        }
    }
    
    public function devolverEquipoAlmacen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateTimeString();
        $dateconvert =(string) $date;
        $indice=$request->idEquipo;
        // DETALLE SALIDA COMPARAR
        $obtenerIdProductoBD =DetalleSalida::where('ctdetsa_indice', $indice)
        ->select('ctdetsa_roduc_id')->get();
        $idMasterPro = str_replace('[{"ctdetsa_roduc_id":',"",$obtenerIdProductoBD);
        $idMasterProducto = str_replace('}]',"",$idMasterPro);
        
        //  STOCK DE MASTER PRODUCTO
        $stockProducto=ProductoMaster::where('ctproduc_id',$idMasterProducto)
        ->select('ctproduc_stock')->get();
        $stockProdu = str_replace('[{"ctproduc_stock":',"",$stockProducto);
        $stockFinal = str_replace('}]',"",$stockProdu);
        // SERIE DEL PRODUCTO
        $serieProducto =DetalleSalida::where('ctdetsa_indice', $indice)
        ->select('ctdetsa_serie')->get();
        $serieProduc = str_replace('[{"ctdetsa_serie":"',"",$serieProducto);
        $serieProductoFinal = str_replace('"}]',"",$serieProduc);
        
        $serie =DetalleSalida::where('ctdetsa_indice', $indice)
        ->delete();
        $suma=$stockFinal+1;
        $stocknuevo =ProductoMaster::where('ctproduc_id', $idMasterProducto)
        ->update([ 'ctproduc_stock' => $suma]);
        $activarProducto =DetailProducto::where('ctdetpr_serie', $serieProductoFinal)
        ->update([ 'ctdetpr_esta_code' => 1]);
        //DEVOLVER EQUIPO GUIA
        $userSalida=DetalleGuia::where('ctdetgu_serieProduc', $serieProductoFinal)
        ->update([
        'ctdetgu_code' => 1,
        'ctdetgu_userSalida'=>null
        ]);
        // return $indice;
    }
    public function listarLiquidar(Request $request)
    
    {
        // if (!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if ($buscar=='') {
            $productos=DetalleGuia::select('ctdetgu.ctdetgu_desc',
            'ctdetgu.ctdetgu_serieProduc','ctdetgu.ctdetgu_fecha_reg',
            'ctdetgu.ctdetgu_code','ctdetgu.ctdetgu_userSalida')
            ->where('ctdetgu.ctdetgu_serieProduc','!=','Ninguno')
            // ->where('ctdetpr.ctdetpr_esta_code' ,'=',1)
            // ->groupby('ctdetgu.ctdetgu_serieProduc')
            ->orderby('ctdetgu.ctdetgu_fecha_reg','desc')->paginate(10);
        }else {
            $productos=DetalleGuia::select('ctdetgu.ctdetgu_desc',
            'ctdetgu.ctdetgu_serieProduc','ctdetgu.ctdetgu_fecha_reg',
            'ctdetgu.ctdetgu_code','ctdetgu.ctdetgu_userSalida')
            ->where('ctdetgu.ctdetgu_serieProduc','!=','Ninguno')
            // ->where('ctdetpr.ctdetpr_esta_code' ,'=',1)
            ->where('ctdetgu.'.$criterio,'like','%' .$buscar. '%')
            // ->groupby('ctdetgu.ctdetgu_serieProduc')
            ->orderby('ctdetgu.ctdetgu_fecha_reg','desc')->paginate(10);
           
        }
        return [
            'pagination'=>[
                    'total'=>$productos->total(),
                    'current_page'=>$productos->currentPage(),
                    'per_page'=>$productos->perPage(),
                    'last_page'=>$productos->lastPage(),
                    'from'=>$productos->firstItem(),
                    'to'=>$productos->lastItem(),
            ],
            'productos'=>$productos
        ];
    }
   public function LiquidarEquipoAdmin(Request $request)
   {
       
    // return $request;
    if (!$request->ajax()) return redirect('/');
       $serie=$request->serie;

       $serieProducto =DetailProducto::where('ctdetpr_serie', $serie)
       ->pluck('ctdetpr_produc_id');
       $proid = str_replace('[',"",$serieProducto);
       $IdProducto = str_replace(']',"",$proid);

       
       $stock =ProductoMaster::where('ctproduc_id', $IdProducto)
       ->pluck('ctproduc_stock');
       $stockB = str_replace('[',"",$stock);
       $stockBD = str_replace(']',"",$stockB);

       
       
       $seriesDP =DetailProducto::where('ctdetpr_serie', $serie)
       ->delete();
       $seriesDG =DetalleGuia::where('ctdetgu_serieProduc', $serie)
       ->delete();

       $resta=$stockBD-1;
      
       $stocknuevo =ProductoMaster::where('ctproduc_id', $IdProducto)
       ->update([ 'ctproduc_stock' => $resta]);
   }
   public function LiquidarEquipoAdminArray(Request $request)
   {
        //  return $request;
    if (!$request->ajax()) return redirect('/');
        $date =Carbon::now('America/Lima')->toDateTimeString();
        $dateconvert =(string) $date;
        $idLiqui=Liquidacion::max('ctliqui_id');
        $idLiquiMax=$idLiqui+1;
        // capturando array de la respuesta
        $serie=$request->serie;
        //Capturando el codigo sap de la respuesta
        $codigoSOT=$request->codigoSOT;  
        //  return $serie;
       foreach ($serie as $key => $value) {
            //añadiendo equipos a la tabla liquidacion para control respectivo
            $product_liquidation=new Liquidacion();
            $product_liquidation->ctliqui_id=$idLiquiMax; 
            $product_liquidation->ctliqui_sot=$codigoSOT;
            $product_liquidation->ctliqui_fechareg=$dateconvert;
            $product_liquidation->ctliqui_userliqui=Auth::user()->ctusuar_usuario;
            // return $product_liquidation;
            $product_liquidation->save();   
            // eliminando los equipos por serie
            $serieProducto =DetailProducto::where('ctdetpr_serie', $value)
            ->pluck('ctdetpr_produc_id');
            $proid = str_replace('[',"",$serieProducto);
            $IdProducto = str_replace(']',"",$proid);
            
            
            $stock =ProductoMaster::where('ctproduc_id', $IdProducto)
            ->pluck('ctproduc_stock');
            $stockB = str_replace('[',"",$stock);
            $stockBD = str_replace(']',"",$stockB);
            // return $stockBD;
            $seriesDP =DetailProducto::where('ctdetpr_serie', $value)
            ->delete();
            $seriesDG =DetalleGuia::where('ctdetgu_serieProduc', $value)
            ->delete();
            
            $resta=$stockBD-1;
      
            $stocknuevo =ProductoMaster::where('ctproduc_id', $IdProducto)
            ->update([ 'ctproduc_stock' => $resta]);

            }
      
   }
   public function Numero_de_guia_tecnico()
    {
        $numero=DetalleSalida::max('ctdetsa_numguiatecnico');
        $numeromas = 'N00001';

      if ($numero == '') {
       return ['numero'=>$numeromas];
      }else {
       $mas=++$numero;
       return ['numero'=>$mas];
      }
    }
}
