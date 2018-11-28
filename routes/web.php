<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('contenido/contenido');
// });
Route::get('iniciar-sesion', function () {
    return view('auth.login02');
 })->name('iniciar-sesion');

    
Route::group(['middleware'=>['guest']],function(){
    Route::get('/', 'Auth\LoginController@ShowLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('login');

});
Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');
    Route::group(['middleware'=>['Almacenero']],function(){
            ////CATEGORIAS
       
    });
    Route::group(['middleware'=>['Administrador']],function(){
       //////UNIDAD DE MEDIDA
        Route::get('/medida','UnidadMedidaController@index');
        Route::post('/medida/registrar','UnidadMedidaController@store');
        Route::patch('/medida/actualizar','UnidadMedidaController@update');
        Route::patch('/medida/desactivar','UnidadMedidaController@desactivar');
        Route::patch('/medida/activar','UnidadMedidaController@activar');
        Route::get('/medida/selectMedida','UnidadMedidaController@selectMedida');
        
        //////EMPLEADO
        Route::get('/empleado','EmpleadoController@index');
        Route::post('/empleado/registrar','EmpleadoController@store');
        Route::patch('/empleado/actualizar','EmpleadoController@update');
        Route::patch('/empleado/desactivar','EmpleadoController@desactivar');
        Route::patch('/empleado/activar','EmpleadoController@activar');
        
        
        
        //////CARGO
        Route::get('/cargo','CargoController@index');
        Route::post('/cargo/registrar','CargoController@store');
        Route::patch('/cargo/actualizar','CargoController@update');
        Route::patch('/cargo/desactivar','CargoController@desactivar');
        Route::patch('/cargo/activar','CargoController@activar');
        Route::get('/cargo/selectCargo','CargoController@selectCargo');
        
        //////CATEGORIAS
        Route::get('/categoria','CategoriaController@index');
        Route::get('/categoriacate','CategoriaController@productoCate');
        Route::post('/categoria/registrar','CategoriaController@store');
        Route::patch('/categoria/actualizar','CategoriaController@update');
        Route::patch('/categoria/desactivar','CategoriaController@desactivar');
        Route::patch('/categoria/activar','CategoriaController@activar');
        Route::get('/categoria/selectCategoria','CategoriaController@selectCategoria');
     
        
        ///ENTRADA DE PRODUCTOS A ALMACEN
        
        Route::get('/productoEntrada','DetalleIngresoController@index');
        Route::get('/productoDetalle','DetalleIngresoController@detalleProducto');
        Route::get('/productoIngre','DetalleIngresoController@buscarSapEqui');
        Route::get('/materialIngre','DetalleIngresoController@buscarSapMate');
        Route::get('/productoSerie','DetalleIngresoController@mostrarSerie');
        Route::post('/producto/registrar','DetalleIngresoController@store');
        Route::get('/guias','DetalleIngresoController@mostrarGuias'); 
        Route::get('/admin/notificacion','DetalleIngresoController@AdminNotificacion');
        Route::patch('/serie-actualizar','DetalleIngresoController@serieActualizar'); 
        Route::patch('/serie-actualizar-total','DetalleIngresoController@serieActualizarTotal'); 
         ////////////Imprimir excel
        Route::get('/excel-ingresos','DetalleIngresoController@export');
         ////////////Imprimir pdf
         Route::get('/pdf-ingresos','DetalleIngresoController@pdfTotalIngresos');
        ///////////PRODUCTO EQUIPO MASTER
        Route::get('/producto/master','ProductoMasterController@index');
        Route::get('/producto/lista','ProductoMasterController@buscarLista');
        Route::post('/producto/master/registrar','ProductoMasterController@store'); 
        Route::patch('/producto/master/actualizar','ProductoMasterController@update'); 
        Route::patch('/producto/master/desactivar','ProductoMasterController@desactivar');
        Route::patch('/producto/master/activar','ProductoMasterController@activar');
        Route::get('/codigo-sap','ProductoMasterController@CodigoSap');
        // Imprimir PDF
        Route::get('/producto/listarPdfDeta/{sap}','ProductoMasterController@listarDetallePDF')->name('detalleEquipo_pdf');
        // total pdf
        Route::get('/equipo-total-pdf','ProductoMasterController@pdfTotalEquipos')->name('total_equipo_pdf');

        //Imprimir excel
        Route::get('/excel-equipo/{sap}','ProductoMasterController@export');
        // Imprimir total excel
        Route::get('/excel-equipoTotal','ProductoMasterController@exportTotal');
         ///////////PRODUCTO Materiales MASTER
         Route::get('/producto/masterm','ProductoMasterMController@index');
         Route::get('/producto/buscarM','ProductoMasterMController@buscarSapMaterial');
         Route::post('/producto/masterm/registrar','ProductoMasterMController@store'); 
         Route::patch('/producto/masterm/actualizar','ProductoMasterMController@update'); 
         Route::patch('/producto/masterm/desactivar','ProductoMasterMController@desactivar');
         Route::patch('/producto/masterm/activar','ProductoMasterMController@activar');
         Route::get('/get-sap','ProductoMasterMController@getSap');
         Route::patch('/stock-material-actualizar','ProductoMasterMController@actualizarStock');
          // Imprimir PDF
        Route::get('/materialPDF','ProductoMasterMController@materialPDF')->name('material_pdf');
         ////////////Imprimir excel
         Route::get('/excel-material','ProductoMasterMController@export');
        //////PROVEEDORES
        Route::get('/proveedor','ProveedorController@index');
        Route::post('/proveedor/registrar','ProveedorController@store');
        Route::patch('/proveedor/actualizar','ProveedorController@update');
        Route::patch('/proveedor/desactivar','ProveedorController@desactivar');
        Route::patch('/proveedor/activar','ProveedorController@activar');
        Route::get('/proveedor/selectProveedor','ProveedorController@selectProveedor');
        
       //////////////////////////////////////////////
       Route::get('/pruebas','DespachoController@prueba');
       Route::post('/prueba','DespachoController@prueba');
       /////////////////////////////////////////////
       
        ////DETALLE SALIDA
        Route::get('/salida','DespachoController@index');
        Route::get('/salida/equipo','DespachoController@SalidaEquipo');
        Route::get('/salida/material','DespachoController@SalidaMaterial');
        Route::post('/salida/registrar','DespachoController@store');
        Route::patch('/salida/actualizar','DespachoController@update');
        Route::patch('/salida/actualizarM','DespachoController@updateM');
        
        Route::get('/salida/despachar','DespachoController@obtenerProduserie');
        Route::get('/salida/despacharMateriales','DespachoController@obtenerProdusap');
        Route::patch('/Equipo/desactivar','DespachoController@desactivarEquipo');
        Route::patch('/Material/Almacen','DespachoController@devolverMaterialAlmacen');
        Route::patch('/Equipo/devolver','DespachoController@devolverEquipoAlmacen');
        Route::patch('/Material/liquidar','DespachoController@LiquidarMaterialAlmacen');
        Route::patch('/liquidar/producto','DespachoController@LiquidarEquipoAdmin');
        Route::patch('/liquidar/productoArray','DespachoController@LiquidarEquipoAdminArray');
        Route::get('/liquidar/listar','DespachoController@listarLiquidar');
        Route::get('/incrementar-guia','DespachoController@Numero_de_guia_tecnico');
        Route::get('/series-despachado','DespachoController@serieDespachado');
         ////////////Imprimir excel equipo
         Route::get('/excel-salidas','DespachoController@export');
        ////////////Imprimir pdf equipo
        Route::get('/pdf-salidas','DespachoController@pdfTotalSalida');
        ////////////Imprimir excel Material
        Route::get('/excel-salidasM','DespachoController@exportMaterial');
        ////////////Imprimir pdf Material
        Route::get('/pdf-salidasM','DespachoController@pdfTotalSalidaMaterial');
        //ALMACEN TECNICO
        Route::get('/almacentec','DespachoController@almacenTotaEquiposTec');
        Route::get('/almacentecmate','DespachoController@almacenTotaMaterialesTec');
        // User Listar Almacen Tecnico
        Route::get('/user/selectUser','DespachoController@selectUser');
        Route::get('/sap-stock','DespachoController@sapStock');

        //////Usuario
        Route::get('/user','UserController@index');
        Route::post('/user/registrar','UserController@store');
        Route::patch('/user/actualizar','UserController@update');
        Route::patch('/user/desactivar','UserController@desactivar');
        Route::patch('/user/activar','UserController@activar');
        Route::get('/user/selectUsuario','UserController@selectUsuario');
        // // UsuarioPUTPrueba
        // Route::patch('/user/actualizar1','UserController@update1');
        // REPORTES
        Route::get('/reporte/traspaso/equipo','ReporteController@reporteTraspasoEquipo');
        Route::get('/reporte/categoria','ReporteController@reporteCategoria');
        Route::get('/reporte/traspaso/material','ReporteController@reporteTraspasoMaterial');
        Route::get('/reporte/liquidacion/equipo','ReporteController@reporteLiquidacionEquipo');
        Route::get('/contar/equipo','ReporteController@ContarEquipos');
        Route::get('/contar/categoria','ReporteController@ContarCategorias');
        // FECHA REPORTE SALIDA
        Route::get('/fecha-reporte','ReporteController@fechaReporte');
        //MOSTRAR SERIES Y SAP DE EQUIPOS Y MATERIALES
        Route::get('/series-salida','DetalleEquipoController@seriesSalida');
        Route::get('/serie/equipo','DetalleEquipoController@MostrarSerieEquipo');
        Route::get('/serie/equipo1','DetalleEquipoController@MostrarSerieEquipo1');
        Route::get('/serie/equipo2','DetalleEquipoController@MostrarSerieEquipo2');
        Route::get('/sap/equipo','DetalleEquipoController@mostrarSapEquipo');
        Route::get('/sap/material','DetalleEquipoController@mostrarSapMaterial');
        Route::get('/serie/Equi','DetalleEquipoController@ProductoSerie');
        Route::get('/todas-series','DetalleEquipoController@todas_series');
        Route::get('/procedimiento','DetalleEquipoController@procedimiento');
        // CARGO DE USUARIO ACIVO
        Route::get('/user/cargo','UserActivoController@CargarCargoUser');
        Route::get('/usuario','UserActivoController@Usuario');
        // LIQUIDACION 
        Route::get('/liquidacion','LiquidacionController@index');
        Route::get('/series-devolucion','LiquidacionController@seriesDevolucion');
        Route::patch('/devolver/productoArray','LiquidacionController@devolucionProductos');
        //    LIQUIDACION NUEVO 
        Route::post('/liquidar-create','LiquidacionController@store');
        Route::get('/get-orden','LiquidacionController@getOrden');
        Route::post('/liquidar-productos','LiquidacionController@storeproducto');
        Route::get('/get-liquidacion','LiquidacionController@getDatosLiquidacion');
        Route::get('/get-ordenCount','LiquidacionController@getCountorden');
        Route::get('/get-ordenes-master','LiquidacionController@ordenes');
        Route::patch('/patch-orden','LiquidacionController@update');
        Route::get('/get-ordenEM','LiquidacionController@EMordenUsuario');
        Route::get('/fecha-series','LiquidacionController@gettablafecha');
        Route::patch('/liquidar-productoArray','LiquidacionController@liquidarequiposdias');
        Route::patch('/patch-orden-user','LiquidacionController@updateOrdenUser');
        // Contar dias
        Route::get('/dias','LiquidacionController@contar_dias');
        Route::get('/dias-tecnico','LiquidacionController@vertecnicos');
        // Importar archivos excel prueba
        Route::post('/importar','ProductoMasterMController@importar'); 

        Route::get('error', function () {
            abort(404);
         });
         Route::get('error', function () {
             abort(503);
          });
          Route::get('error', function () {
             abort(500);
          });

    });
    

});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
