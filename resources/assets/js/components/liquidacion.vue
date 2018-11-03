
<template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
              <br>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Liquidacion
                        
                        
                        <template v-if="listado">
                            <!-- <button type="button" @click="mostrarDetalle()" class="btn orange float-right  btn-sm"  >
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button> -->
                            
                        </template>
                        <template v-else>
                           <button type="button" class="btn btn-secondary btn-sm float-right" @click="ocultarDetalle()">
                            Atras <i class="ml-2 fas fa-reply"></i>
                        </button>
                        </template>


                    </div>
                     <template v-if="listado">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-3">
                                    <select class="form-control mt-2" v-model="criterio">
                                        <option value="ctdetgu_serieProduc">Serie del Producto</option>
                                        <option value="ctdetgu_desc">Cod. Sap</option>
                                        <option value="ctdetgu_fecha_reg">Fecha de Registro</option>
                                        <option value="ctdetgu_userSalida">Usuario Salida</option>
                                    </select>
                            </div>
                            <div class="col-md-5">
                                <div class="md-form input-group mt-0 mb-3">
                                 <input type="text" v-model="buscar" @keyup="listarEntrada(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <div class="input-group-append">
                                   <button type="button" :disabled="buscar == ''"  @click="listarEntrada(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm"  >
                                        Busqueda<i class="ml-2 fa fa-search"></i>
                                    </button>
                                </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 ">

                                <div class="anyClass border-r p-4" :class="{disNo:this.probarinsert=='' ,disBlo:this.probarinsert!=''}">
                                    <h6 class="p-2 b-01 text-center">Lista de Liquidación</h6>
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Equipos</th>
                                                <th>Opciones</th>
                                                <th>
                                                    <div class="btn-group ">
                                                        <button type="button" v-b-tooltip.hover title="Limpiar Liquidación"  @click="probarinsert=[]" class=" btn-transparent blue-text">
                                                            <i class="fas fa-eraser"></i>
                                                        </button>
                                                    </div>
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class=" ">
                                            <tr v-for="(fruit, index) in probarinsert" :key="index">
                                                <td>
                                                    {{fruit}}
                                                    <!-- <p hidden="hidden">{{index +1}}</p> -->
                                                </td>
                                                <td>
                                                    <div class="btn-group ">
                                                        <button type="button" @click="eliminarIndex(index)" class=" btn-transparent red-text">
                                                            <i class="fas fa-backspace"></i>
                                                        </button>
                                                    </div>
                                                    <!-- <a @click="eliminarIndex(index)"> eliminar</a> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <button class="btn orange float-c mt-2 btn-sm" @click="liquidarProductos(probarinsert)">Liquidar Todo</button>
                            
                                </div>
                            </div>
                                   
                            <div class="col-md-4">
                                <label for="codigoSOT"> Codigo SOT</label>

                                <input  v-model="codigoSOT" :class="{brd:this.codigoSOT=='',werd:this.codigoSOT!='' }" type="number"  class="form-control" placeholder="Texto a buscar">
                                
                                <div class="filesx" :class="{disBlo:this.codigoSOT=='' ,disNo:this.codigoSOT!=''}">
                                    Campo obligatorio
                                </div>
                            </div>
                            
                            </div>

                            <br>
                            
                         <div  class="table-responsive" :class="{disNo:this.codigoSOT=='' ,disBlo:this.codigoSOT!=''}">
                            <table @click="mostrarLista()" class="table table-bordered table-striped table-sm">
                                <thead class="blue white-text text-center">
                                    <tr class="text-center">
                                        <th>Selección</th>
                                        
                                        <th>Código. SAP</th>
                                        <th>Código del producto</th>
                                        
                                        <th>Fecha de Registro</th>
                                    
                                        <th>Usuario</th>
                                        <th>
                                            Opciones
                                        </th>
                                    
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr v-for="entrada in arrayEntrada" :key="entrada.idProducto"  >
                                        
                                        <td >
                                            <div >
                                                <b-form-checkbox 
                                                    :disabled="entrada.ctdetgu_code==2"
                                                    v-model="LiquiChecked"
                                                    :value="entrada.ctdetgu_serieProduc"
                                                    
                                                    >
                                                    </b-form-checkbox>  
                                            </div>
                                                    
                                        </td>
                                        <td v-text="entrada.ctdetgu_desc" ></td>
                                        <td v-text="entrada.ctdetgu_serieProduc"></td>
                                        <td v-text="entrada.ctdetgu_fecha_reg"></td> 
                                        <td v-text="entrada.ctdetgu_userSalida"></td>
                                        
                                        <!-- <td   class="text-center">
                                            <b-btn :disabled="entrada.ctdetgu_code==2"  @click="liquidarProducto(entrada.ctdetgu_serieProduc)"  variant="warning btn-sm" >
                                                    <i class="fa fa-trash black"></i>    
                                            </b-btn> 
                                        </td> -->
                                        <td class="sm-0 sp-0">
                                            <b-btn class="btn orange float-right mt-2 btn-sm" :disabled="entrada.ctdetgu_code==2" @click="capturaSerie(entrada.ctdetgu_serieProduc)">
                                                Agregar
                                            </b-btn>
                                        </td>
                                        
                                        
                                        
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <b-btn v-show="arrayEntrada.length!==0" v-if="LiquiChecked.length !==0"  @click="liquidarProductos(LiquiChecked)"  variant="warning btn-sm" >
                                    <i class="fa fa-trash black"></i>    
                            </b-btn> 

                            <nav aria-label="pagination example">
                                <ul class="pagination pg-blue">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a  class="page-link" href="#" 
                                            @click.prevent ="cambiarPagina(pagination.current_page-1,buscar,criterio)">
                                            Ant
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page" ></a>
                                    </li>
                                
                                    <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                                    </li>
                                    
                                </ul>
                            </nav>
                        </div>

                        

                    </div>
                    </template>


                    <template v-else>


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- {{arrayEntrada}} -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Proveedor(*)</label>
                                        <select class="form-control" v-model="proveedor_id" >
                                            <option value="0" disabled="" >Seleccione Proveedor</option>
                                            <option v-for="proveedor in arrayProveedor" :key="proveedor.d" :value="proveedor.ctprove_code" v-text="proveedor.ctprove_razon_social"></option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">N° de Comprobante
                                                    <!-- <span style="color:red;"  v-show="nroComprobante==''">(*)</span> -->
                                                </label>
                                             
                                                <b-form-input   id="inputLive"
                                                                v-model.trim="nroComprobante"
                                                                type="number"
                                                                :state="nComState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="nroComprobante==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>
                                                <b-form-invalid-feedback v-show="NumCom()" id="inputLiveFeedback4">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Comprobante ya Registrada
                                                </b-form-invalid-feedback>
                                                

                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Serie Comprobante
                                                    <!-- <span style="color:red;"  v-show="serie==''">(*)</span> -->
                                                </label>
                                                <!-- <input v-model="serie" max="3" type="number" class="form-control">
                                                <span v-if="errores.ctgurem_serie" :class="['label label-danger']">{{ errores.ctgurem_serie[0] }}</span>
                                                <span v-if="success" :class="['label label-success']">Registrado Correctamente!</span>
                                             -->
                                                <b-form-input   id="inputLive1"
                                                                v-model.trim="serie"
                                                                type="number"
                                                                
                                                                :state="serieState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="correEs()" id="inputLiveFeedback4">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Serie ya Registrada
                                                </b-form-invalid-feedback>

                                                <b-form-invalid-feedback v-show="serie==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>

                                                <b-form-invalid-feedback v-show="serie.length>3 " id="inputLiveFeedback1">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                No exeder de 4
                                                </b-form-invalid-feedback>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Fecha de Registro</label>
                                                <!-- <input  v-model="proveedor_id" type="number" > -->
                                                <!-- <input  v-model="fechaRegistro" type="date" class="form-control" > -->
                                                <datepicker v-model="fecha" format="dd/MM/yyyy" input-class="form-control">
                                                </datepicker>
                                            </div>
                                            
                                        </div>  
                                    </div>
                                </div>
                                <hr class="my-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        

                                        <button :disabled="nroComprobante == ''||serie==''||NumCom()||serie.length>3 ||correEs()"  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                                    </div>
                                </div>       
                                    <!-- Modal -->
                                    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Añadir a Lista de Productos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <b-card no-body>
                                            <b-tabs pills card >
                                                <b-tab title="Equipo" active>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <label for="">Código SAP</label>
                                                            <div class="btn-group float-right" >
                                                                <button type="button" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-list-ul "></i>
                                                                </button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <div v-if="eqLis===1">
                                                                            <a  class="dropdown-item" @click.prevent="eqLis=2"><i class="fa fa-list"></i>Cerrar</a>
                                                                        </div>
                                                                        <div v-else>
                                                                                <a class="dropdown-item" @click.prevent="next()"><i class="fa fa-list"></i>Lista</a>
                                                                        </div>

                                                                    </div>
                                                                    <button  class="btn-transparent  blue-text" @click.prevent="clear01()" >
                                                                        <i class="fas fa-eraser"></i>
                                                                    </button>
                                                            </div>
                                                            <input type="text" :disabled="nroComprobante == ''||serie==''" ref="emailss" v-model="buscar" v-on:keyup.enter="listarSAP(buscar,criterio1)" class="form-control" placeholder="Texto a buscar">  
                                                            <span ></span>
                                                        <!-- {{arraySAP}} -->
                                                        </div>
                                                        <div class="col-md-2">
                                                           
                                                            <br>
                                                            <button @click="listarSAP(buscar,criterio1)"  :disabled="error22" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                <i  class="fas fa-dolly"></i>
                                                            </button>
                                                       
                                                        </div>
                                                        <div class="col-md-6"> 
                                                        <label for="">Número de Serie</label>
                                                            <input  :disabled="this.arraySAP == ''||error22" type="text" class="form-control" placeholder="Texto a buscar" v-model="newTasks" @keyup="addBarra"  >
                                                        </div>
                                                    </div>    
                                                    
                                                    
                                                            <div v-if="eqLis === 1">
                                                                <br>
                                                                <hr class="my-1">
                                                                <div class="btn-group float-right" >
                                                                        <button @click.prevent="eqLis=2" class="btn-transparent red-text">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>   
                                                                </div>
                                                                    <!-- User Interface controls -->
                                                                            <b-row>
                                                                            <b-col md="6" class="my-1">
                                                                                
                                                                                <label for="">Búsqueda</label>
                                                                                <b-input-group>
                                                                                    <b-form-input v-model="filter" placeholder="buscar..." />
                                                                                    <b-input-group-append>
                                                                                    
                                                                                    </b-input-group-append>
                                                                                </b-input-group>
                                                                            
                                                                            </b-col>
                                                                            
                                                                            <b-col md="6" class="my-1">
                                                                                    <label for="">Paginación</label>
                                                                                <b-form-select :options="pageOptions1" v-model="perPage1" />
                                                                
                                                                            </b-col>
                                                                            </b-row>

                                                                    <div class="table-responsive">
                                                                            <br>
                                                                            
                                                                            <!-- Main table element -->
                                                                            <b-table show-empty
                                                                                    stacked="md"
                                                                                    :items="arrayEquipoSap"
                                                                                    :fields="fields"
                                                                                    :current-page="currentPage1"
                                                                                    :per-page="perPage1"
                                                                                    :filter="filter"
                                                                                    :sort-by.sync="sortBy"
                                                                                    :sort-desc.sync="sortDesc"
                                                                                    :sort-direction="sortDirection"
                                                                                    @filtered="onFiltered"
                                                                            >
                                                                            
                                                                            <template slot="OPCIONES" slot-scope="row">
                                                                                <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
                                                                                <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)" class="mr-1">
                                                                                Agregar
                                                                                </b-button>
                                                                            </template>
                                                                            
                                                                            </b-table>
                                                                            
                                                                            <b-row>
                                                                            <b-col md="6" class="my-1">
                                                                                <b-pagination :total-rows="this.arrayEquipoSap.length" :per-page="perPage1" v-model="currentPage1" class="my-0" />
                                                                            </b-col>
                                                                            </b-row>

                                                                            <!-- Info modal -->
                                                                    </div>
                                                            </div>
                                                            <div v-if="eqLis === 2" >
                                                                <br>
                                                                <b-container fluid>
                                                                    <div class="col-md-12"> 
                                                                    </div>  
                                                                </b-container>
                                                            </div>
                                                   
                                                        
                                                </b-tab>
                                                <b-tab title="Materiales">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">SAP</label>
                                                            <div class="btn-group float-right" >
                                                                <button type="button" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-list-ul "></i>
                                                                </button>
                                                                    <button  class="btn-transparent  blue-text" @click.prevent="clear()" >
                                                                        <i class="fas fa-eraser"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <div v-if="eqLis01===1">
                                                                            <a  class="dropdown-item" @click.prevent="eqLis01=2"><i class="fa fa-list"></i>Cerrar</a>
                                                                        </div>
                                                                        <div v-else>
                                                                                <a class="dropdown-item" @click.prevent="next01()"><i class="fa fa-list"></i>Lista</a>
                                                                        </div>

                                                                    </div>
                                                            </div>
                                                            
                                                            <input type="text" v-model="buscar1" v-on:keyup.enter="listarMaterialB(buscar1,criterio2)" @keyup.enter="eqLisCanti=1" class="form-control" placeholder="Texto a buscar">
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                        <div  v-if="eqLisCanti ===1">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                   <label for="">Cantidad</label>
                                                                    <input  type="number" :disabled="buscar1 == ''||this.arrayMaterialB ==''" v-model="stockMate"  class="form-control" >
                                                                    <p class="">und.: <span class="green-text">{{arraM02()}}</span> </p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    
                                                                     <button  class="btn-transparent float-right red-text dispaly05" v-on:click="eqLisCanti=2" >
                                                                       <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <br>
                                                                    <button @click.prevent="addBotonMAte()" v-on:click="eqLisCanti=2"  :disabled="this.stockMate <= 0" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                        <i  class="fas fa-dolly"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div  v-if="eqLisCanti ===2">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                     <br>
                                                                <button @click="listarMaterialB(buscar1,criterio2) " v-on:click="eqLisCanti=1"  :disabled="buscar1 == ''" type="button" class="mt-2 float-right btn green btn-sm ">
                                                                    <i  class="fas fa-dolly"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                        </div>
                                                        
                                                      
                                                    </div>


                                                    </div>
                                                    
                                                   
                                                        
                                                            <div v-if="eqLis01 === 1" >
                                                                <br>
                                                                <hr class="my-1">
                                                                <div class="btn-group float-right" >
                                                                        <button @click.prevent="eqLis01=2" class="btn-transparent red-text">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>   
                                                                </div>
                                                                    <!-- User Interface controls -->
                                                                            <b-row>
                                                                            <b-col md="6" class="my-1">
                                                                                
                                                                                <label for="">Búsqueda</label>
                                                                                <b-input-group>
                                                                                    <b-form-input v-model="filter" placeholder="buscar..." />
                                                                                    <b-input-group-append>
                                                                                    
                                                                                    </b-input-group-append>
                                                                                </b-input-group>
                                                                            
                                                                            </b-col>
                                                                            
                                                                            <b-col md="6" class="my-1">
                                                                                    <label for="">Paginación</label>
                                                                                <b-form-select :options="pageOptions2" v-model="perPage2" />
                                                                
                                                                            </b-col>
                                                                            </b-row>
                                                                    <div class="table-responsive">
                                                                            <br>
                                                                            
                                                                            <!-- Main table element -->
                                                                            <b-table show-empty
                                                                                    stacked="md"
                                                                                    :items="arrayMaterialSap"
                                                                                    :fields="fields01"
                                                                                    :current-page="currentPage2"
                                                                                    :per-page="perPage2"
                                                                                    :filter="filter"
                                                                                    :sort-by.sync="sortBy"
                                                                                    :sort-desc.sync="sortDesc"
                                                                                    :sort-direction="sortDirection"
                                                                                    @filtered="onFiltered"
                                                                            >
                                                                            
                                                                            <template slot="OPCIONES" slot-scope="row">
                                                                                <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
                                                                                <b-button size="sm" @click.stop="info01(row.item, row.index, $event.target)" class="mr-1">
                                                                                Agregar
                                                                                </b-button>
                                                                            </template>
                                                                            
                                                                            </b-table>
                                                                            
                                                                            <b-row>
                                                                            <b-col md="6" class="my-1">
                                                                                <b-pagination :total-rows="this.arrayMaterialSap.length" :per-page="perPage2" v-model="currentPage2" class="my-0" />
                                                                            </b-col>
                                                                            </b-row>

                                                                            <!-- Info modal -->
                                                                    </div>
                                                                    
                                                                
                                                            </div>
                                                            <div v-if="eqLis01 === 2" >
                                                                <b-container fluid>
                                                                    <div class="col-md-12"> 
                                                                    </div>  
                                                                </b-container>
                                                            </div>
                                                       
                                                   
                                                    
                                                </b-tab>
                                            </b-tabs>
                                            </b-card>
                                                
                                            </div>
                                    
                                            </div>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div>


                          <hr class="my-1">

                            <div class="row">
                            <div class="col-md-4">
                                   <label for="">Paginación</label>
                                <b-form-select :options="pageOptions" v-model="perPage" />
                            </div>
                            <div class="col-md-8">
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <button type="button" :disabled="tasks.length == 0"  class="btn btn-primary btn-sm float-right" @click="registrarProducto()" >
                                            Registrar entrada
                                        </button>
                                        <!-- <span v-if="errores.ctdetpr_serie" :class="['label label-danger']">{{ errores.ctdetpr_serie[0] }}</span> -->
        
                                        <button  v-b-tooltip.hover title="Descargar Reporte"  type="button" :disabled="tasks.length == 0"  @click="exportPdf" class="float-right btn red btn-sm " >
                                            <i class="fas fa-download white-text" id="icons"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>
                                        
                                <div class="col-md-8"></div>
                                <div class="col-md-12">
                                        <div class="table-responsive">
                                        <table class="table table-bordered mt-4" >
                                            <thead class="blue white-text text-center">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">tipo</th>
                                                    <th scope="col">Codigo sap</th>
                                                    <th scope="col">Categoria</th>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Serie del Producto</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">unidad Medida</th>
                                                    
                                                   
                                                    
                                                    <th scope="col">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr v-for=" (task,indice) in paginador(tasks) " :key="task.descripcion" >
                                                        <td>{{indice+1}}</td>
                                                        <td>{{task.detaTi}}</td>
                                                        <td>{{task.prod01}}</td>
                                                        <td>{{task.cate01}}</td>
                                                        <td>{{task.nompro01}}</td>
                                                        <td>{{(task.ctdetpr_serie)}}</td>
                                                        <td>{{(task.canti)}}</td>
                                                        <td>{{task.uni}}</td>
                                                        <td class="text-center sm-02 sp-02">
                                                            <div class="btn-group " >
                                                                <button type="button" class=" btn-transparent red-text" @click="deleteTask(indice)">
                                                                <i class="fas fa-backspace"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        

                                                    </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                            </div>     
                            <b-pagination size="md" align="center" :total-rows="this.tasks.length" v-model="currentPage" :per-page="perPage">
                            </b-pagination> 
                   
                        
                    </div>
                    </template>
                </div>
                <br>
           
                <!-- Fin ejemplo de tabla Listado -->
            </div>

   

        </main>
</template>

<script>
 
 const $ = require('jquery')
 window.$ = $
 //

//AUTOSELECIONAR UN IMPUT//
function pasacampo(key_event)
{
  var k;
  if (document.all)  k = event.keyCode;
  else k = key_event.which;
 if (k == 13) document.getElementById('campo2').focus();
}

//
// var fecha1 = moment('2018-08-1');
// var fecha2 = moment(new Date());




    import jsPDF from 'jspdf';
    import autoTable from 'jspdf-autotable';

    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    import vSelect from 'vue-select';

     const items = [
    ]

    export default {
        data(){
            return{
                //event_at: new Date(),
                
                codigoSOT:'',
                probarinsert:[],
                lista:[],
                items: items,  
                fields: ['SAP','DESCRIPCION','STOCK','OPCIONES'],
                fields01: ['SAP','DESCRIPCION','STOCK','OPCIONES'],
                currentPage: 1,
                perPage: 5,
                totalRows: items.length,
                pageOptions: [ 5, 10, 15 ],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                modalInfo: { title: '', content: '' },     
                eqLisCanti:2,
                eqLis:2,
                dateToFilter:moment(),
                fecha1:'',
                listado:1,
                producto_id:0,
                descripcion:'',
                nroComprobante:'',
                idcategoria:0,
                unidadMedida:{},
                serie:'',
                fecha:new Date(), 
                codigo:0,
                nombre_categoria:0,
                descripcion:'',
                caracteristicas:'',
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorEntrada:0,
                errorMostrarMsjEntrada:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                newCantidad:[]=1,
                offset:3,
                criterio:'ctdetgu_serieProduc',
                criterio1:'sap',
                criterio2:'ctdetpr_serie',
                buscar:'',
                buscarSerie:'',
                arrayCategoria:[],
                arrayEntrada:[],
                newTasks:[],
                tasks:[],
                arrayProducto:[],
                arraySAP:[],
                arrayProducto1:[],
                proveedor_id:1,
                arrayProveedor:[],
                arrayMedida:[],
                arraySerie:[],
               
                agUni:'',
                errorIngreso:0,
                col:0,
                pro:1,
                CatePro01:'',
                errores:[],
                arrayEquipo:[],
                 success:false,
                 arrayEquipoSap:[],
                buscartres:[],
                arrayMaterialB:[],
                buscar1:'',
                mensj:'',
                mensj01:'',
                stockMate:'',
                eqLis01:2,
                arrayMaterialSap:[],
                arrayListarSerie:[],
                arrayGuia:[],
                LiquiChecked:[],
                selectAll: false,
                
               
          
            }
        },
        filters:{
            changeDateFilter:
            function (value){
                    return moment(value).fromNow();
            }
        },
        components:{
            Datepicker,
            vSelect
        },
        computed:{
            error22(){
                 return this.buscar !='' ? false : true
            },
            nComState () {
            return this.nroComprobante.length > 2 ? true : false
            },
            serieState () {
              
               
                
            return this.serie.length > 0 &&this.serie.length <=3  ? true : false
            },

            sortOptions () {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => { return { text: f.label, value: f.key } })
            },

              isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods:{
            eliminarIndex: function (index) {

               this.probarinsert.splice(index, 1);
                
            },
            capturaSerie: function (id) {
           if (this.probarinsert < 1) {
               this.probarinsert.push(id);
           } else {
            if (this.probarinsert.indexOf(id) === -1) {
                    this.probarinsert.push(id);
                } else if (this.probarinsert.indexOf(id) > -1) {
                     toast({
                        type: 'warning',
                        title: `la serie ya existe en la colección.`
                    })
                }
           } 
            },
            
            mostrarLista(){
                this.lista = this.arrayEntrada;
            },
              liquidarProducto(serie){
                 swal({
                    title: '¿Desea eliminar este registro?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {
                let me=this;
                    axios.patch('/liquidar/producto',{
                                
                                'serie':serie
                            }).then(function (response) {
                           
                            me.listarEntrada(1,'','ctdetgu_serieProduc');
                                   swal(
                                    'Elimindao!',
                                    'Registro eliminado',
                                    'success'
                                    )       
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    })

            },
             liquidarProductos(serie){

                 if (this.probarinsert.length ==0) {
                      toast({
                        type: 'warning',
                        title: `no existe ninguna colección a eliminar.`
                    })
                 } else {
                 swal({
                    title: '¿Desea eliminar estos registros?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {
                let me=this;
                    axios.patch('/liquidar/productoArray',{
                                
                                'serie':serie,
                                'codigoSOT':this.codigoSOT
                            }).then(function (response) {
                           
                            me.listarEntrada(1,'','ctdetgu_serieProduc');
                                   swal(
                                    'Desactivado!',
                                    'Registro desactivado',
                                    'success'
                                    )
                                    me.LiquiChecked.length=0 
                                    me.probarinsert.length=0       
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    })
                 }
            },
            paginador(val) {
                const indiceInicio = (this.currentPage - 1) * this.perPage;
                const indiceFinal =
                    indiceInicio + this.perPage > val.length
                    ? val.length
                    : indiceInicio  + this.perPage;
                return val.slice(indiceInicio , indiceFinal );
                },
            exportPdf(){              
                let vm = this;
                let nCompro = vm.nroComprobante;
                let doc = new jsPDF('p', 'pt');
                let columns = [
                    // {title: "#", dataKey: "1"},
                    {title: "Tipo", dataKey: "detaTi"},
                    {title: "Código Sap", dataKey: "prod01"},
                    {title: "Categoria", dataKey: "cate01"},
                    {title: "Producto", dataKey: "nompro01"},
                    {title: "Serie del Producto", dataKey: "ctdetpr_serie"},
                    {title: "Cantidad", dataKey: "canti"},
                    {title: "unidad Medida", dataKey: "uni"},
                ];
                
                    // Error ========================
                doc.autoTable(columns,vm.tasks,{
                    theme: 'grid',
                    // styles : { fillColor : [ 1, 108 , 162 ] } ,
                    headerStyles: {fillColor : [ 1, 108 , 162 ]},
                    bodyStyles: {fillColor : [ 255, 255 , 255 ]},
                    columnStyles: {
                        id: {fillColor:0}
                    },
                    margin: {top: 90},
                    
                    addPageContent: function(data) {
                            //(v(x)-h(y))

                        doc.setFontSize(11);
                        doc.text("Número Comprobante", 40, 40);

                        doc.setDrawColor(0);
                        doc.setFillColor(255, 255, 255);
                        doc.roundedRect(40, 45, 70, 20, 3, 3, 'FD'); 

                        doc.setFontSize(11);
                        doc.text(nCompro, 40, 60);
                        
                    }
                }
                
                );
                doc.save('teste.pdf');
            },
            info (item, index, button) {
            this.respuesta = `Row index: ${index}`
            // this.modalInfo.content = item.age
            // this.$root.$emit('bv::show::modal', 'modalInfo', button)
                    this.arraySAP='';
                    
                    this.buscar=item.SAP;
                    this.eqLis=2;

                    this.timer = setTimeout(() => {
                        let me=this;
                        var url='/productoIngre?buscar=' + this.buscar ;
                        axios.get(url).then(function (response) {
                                // handle success;
                                var respuesta=response.data;
                            me.arraySAP=respuesta.ingresos.data;
                            })
                            .catch(function (error) {
                                // handle error 
                                console.log(error);
                    });
                 }, 800);
                

            },

            correEs(){
                for (let index = 0; index < this.arrayEntrada.length; index++) {
                    const element = this.arrayEntrada[index].ctdetgu_serie;
                    if(element == this.serie){
                        return true
                    }
                    else{
                        return false
                    }
                    
                }
            },
             NumCom(){
                for (let index = 0; index < this.arrayEntrada.length; index++) {
                    const element = this.arrayEntrada[index].ctdetgu_nro;
                    if(element == this.nroComprobante){
                        return true
                    }
                    else{
                        return false
                    }
                    
                }
            },

            info01 (item, index, button) {
            this.respuesta = `Row index: ${index}`
                    this.arrayMaterialB='';
                    this.buscar1=item.SAP;
                     this.eqLis01=2;
                    this.timer = setTimeout(() => {
                        let me=this;
                        var url='/materialIngre?buscar=' + this.buscar1 ;
                        axios.get(url).then(function (response) {
                            // handle success;
                            var respuesta=response.data;
                        me.arrayMaterialB=respuesta.ingresos.data;
                        })
                        .catch(function (error) {
                                // handle error 
                                console.log(error);
                       });
                 }, 800);
                
            },

            resetModal () {
            this.modalInfo.title = ''
            this.modalInfo.content = ''
            },
            onFiltered (filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
            },
            //////////////////
             next01() {
                this.eqLis01=1
            },

             next() {
                this.eqLis=1
   
            },
            clear(){
                this.buscar1='';
            },
            clear01(){
                this.buscar='';
            },
            /////////////////
            customFormatter(data) {

                    this.fecha1= moment(data).format('LLL');
                    return this.fecha1;   
            },

          
            deleteTask:function(indice){
                this.tasks.splice(indice,1);
            },

             mostrarDetalle(){
                let me=this;
                this.listado=0;
                this.selectProveedor();
                me.producto_id=1;
                me.nroComprobante='';
                me.buscar='';
                me.serie='';
                me.newTasks='';
                me.comprobante_id='';
                me.nombre_producto='';
                me.precioUnitario=0;
                me.fechaVencimiento='';
                me.arraySAP=[];
                me.errores=[];
                me.tasks=[];
                this.listarEquipoSap();
            },
            ocultarDetalle(){
                 let me=this;
                 if (me.nroComprobante !==''
                 ||me.serie !== ''||me.newTasks !==''||me.buscar!==''
                 ||me.tasks.length !==0
                 ) {
                      Swal({
                        title: '¿Seguro que quieres cerrar esta ventana?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                        if (result.value) {
                          this.listado=1;
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                       
                        }
                        })
                         
                    }else{
                        this.listado=1;
                    }
                
            },
             buscarArticulo(id){
                var sw=0;
                for (var i = 0; i < this.tasks.length; i++) {
                    if (this.tasks[i].ctdetpr_serie==id) {
                        sw=true;
                    }
                    
                }
                return sw;

            },
            listarSerieEquipo(){
                let me=this;
                var url='/serie/equipo' ;
               axios.get(url).then(function (response) {
                    var respuesta=response.data;
                   me.arrayListarSerie=respuesta.salidas;
                
                 
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            buscarArticuloBD(id1){
                var sw=0;
                for (var i = 0; i < this.arrayListarSerie.length; i++) {
                    if (this.arrayListarSerie[i].Serie==id1) {
                        sw=true;
                    }
                     
                }
               
                return sw;

            },
            listarGuias(){
                let me=this;
                var url='/guias' ;
               axios.get(url).then(function (response) {
                    var respuesta=response.data;
                   me.arrayGuia=respuesta.ingresos;
                
                 
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
             buscarGuiaBD(id2){
                var sw=0;
                for (var i = 0; i < this.arrayGuia.length; i++) {
                    if (this.arrayGuia[i].ctdetgu_serie==id2) {
                        sw=true;
                    }
                     
                }
               
                return sw;

            },

            
             

            addBarra: function(){
               
                if (this.newTasks=='') {
                    
                }
                // else if(this.buscar==''){
                    
                // }
                else{

                    if (this.timer) {
                        clearTimeout(this.timer);
                        this.timer = null;
                    }
                    this.timer = setTimeout(() => {
                        if (this.newTasks=='') {
                            
                        }else if (this.buscarArticuloBD(this.newTasks)) {
                            
                                swal({
                                    type:'error',
                                    title:'Error...',
                                    text:'La serie del equipo ya se encuentra en la Base de datos',
                                })}else if (this.buscarArticulo(this.newTasks)) {
                                    swal({
                                    type:'error',
                                    title:'Error...',
                                    text:'Ya se encuentra agregado a la lista',
                                })
                                }else{

                                         this.tasks.push({
                                            cate01:this.arraySAP[0].ctcatego_desc,
                                            idtipro:this.arraySAP[0].ctproduc_tipro_code,
                                            nompro01:this.arraySAP[0].ctproduc_nombre,
                                            ctdetpr_serie: this.newTasks,
                                            prodid:this.arraySAP[0].ctproduc_id,
                                            cateid1:this.arraySAP[0].ctcatego_id,
                                            uni:this .arraySAP[0].ctundmd_desc,
                                            idundmed:this .arraySAP[0].ctproduc_undMed,
                                            canti:1,
                                            detaTi:this.arraySAP[0].cttipro_desc,
                                            prod01:this.arraySAP[0].sap,
                                            });
                                      
                                }
                       
                                this.newTasks='';

                    }, 800);

                    }
                //    
            },
            arraM02(){
                for (let index = 0; index < this.arrayMaterialB.length; index++) {
                    return this.arrayMaterialB[0].ctundmd_desc
                    
                }
            },
            addBotonMAte: function(){
               
                if (this.stockMate==''||this.stockMate <=0) {
                    
                }

                else{

                    this.timer = setTimeout(() => {
                      
                                this.tasks.push({
                                cate01:this.arrayMaterialB[0].ctcatego_desc ,
                                prod01:this.arrayMaterialB[0].sap,
                                nompro01:this.arrayMaterialB[0].ctproduc_nombre,          
                                prodid:this.arrayMaterialB[0].ctproduc_id,
                                ctdetpr_serie:'Ninguno',
                                canti:this.stockMate,
                                uni:this .arrayMaterialB[0].ctundmd_desc,
                                idundmed:this.arrayMaterialB[0].ctproduc_undMed,
                                detaTi:this.arrayMaterialB[0].cttipro_desc,
                                idtipro:this.arrayMaterialB[0].ctproduc_tipro_code, 
                              
                                
                            });

                            this.buscar1='';
                            this.stockMate='';
                            this.arrayMaterialB='';
    
                    }, 800);
                    }
                //    
            },
           
             listarSAP(buscar){
                let me=this;
                var url='/productoIngre?buscar=' + buscar ;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arraySAP=respuesta.ingresos;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
               
                    
               
            },
            listarEquipoSap(){
                let me=this;
                var url='/sap/equipo';
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayEquipoSap=respuesta.ingresos;
                //    console.log( me.arrayEquipoSap);
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
               
            },
             listarMaterialSap(){
                let me=this;
                var url='/sap/material';
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayMaterialSap=respuesta.ingresos;
                //    console.log( me.arrayMaterialSap);
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
               
            },
             listarMaterialB(buscar){
                let me=this;
                var url='/materialIngre?buscar=' + buscar ;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayMaterialB=respuesta.ingresos;
                //    console.log(respuesta);

                
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
 
            },
             listarSerie(buscarSerie,criterio2){
                let me=this;
                var url='/productoSerie?buscarSerie=' + buscarSerie + '&criterio2=' + criterio2;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arraySerie=respuesta.ingresos.data;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            selectProducto(search,loading){
                let me=this;
                loading(true)
                var url='/producto/selectProducto?filtro='+search;
               axios.get(url).then(function (response) {
                   let respuesta=response.data;
                   q:search
                   me.arrayProducto=respuesta.productos;
                   loading(false)
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getDatosProducto(val1){
                let me=this;
                me.loading=true;
                me.producto_id=val1.idProducto
            },
            selectProveedor(){
                 let me=this;
                 var url='/proveedor/selectProveedor';
               axios.get(url).then(function (response) {
                   var respuesta=response.data;
                   me.arrayProveedor=respuesta.proveedores;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
          
            listarEntrada(page,buscar,criterio){
                let me=this;
                var url='/liquidar/listar?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayEntrada=respuesta.productos.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            
           
            selectCategoria(){
                 let me=this;
                 var url='/categoria/selectCategoria';
               axios.get(url).then(function (response) {
                   var respuesta=response.data;
                   me.arrayCategoria=respuesta.categorias;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarEntrada(page,buscar,criterio);
            },
            registrarProducto(){
                if (
                    this.categoria==0
                    ||this.nroComprobante==''
                    ||this.serie==''
                    ||this.arraySAP==this.tasks) {
                    }else{
                let me=this;
                axios.post('/producto/registrar',{
                    'proveedor_id':this.proveedor_id,
                    'fecha':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),
                    'ctgurem_nro':this.nroComprobante,
                    'ctgurem_serie':this.serie,

                    'data':this.tasks
                       
                    
                }).then(function (response) {
                    
                //    me.listarProducto(1,'','descripcion');
                   me.listarEntrada(1,'','ctdetgu_fecha_act');
                   me.tasks=[];
                   me.nroComprobante='';
                   me.serie='';
                   me.errores=[];
                   me.arraySAP=[];
                   me.newTasks='';
                   me.buscar='';
                })
                 .catch((error) => {
                         this.errores = error.response.data.errors;
                         this.success = false;
                    });
                    }

            },
            listarEquipo(page,buscar,criterio){
                let me=this;
                var url='/producto/master?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    // console.log(response);
                   var respuesta=response.data;
                   me.arrayEquipo=respuesta.produmaster.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
             listarProducto(idEquipo){
                let me=this;
                    var url='/producto/lista?id='+ idEquipo ;
                    axios.get(url).then(function (response) {
                        var respuesta=response.data;
                        me.arrayEquipo=respuesta.produmaster;
                        
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
         
         
            
        },
        mounted() {
            this.listarMaterialSap(1,this.buscar,this.criterio);
             this.listarEquipo(1,this.buscar,this.criterio);
            this.listarEntrada(1,this.buscar,this.criterio);
            this.listarSerieEquipo();
            this.listarGuias();


           
            
        },
        
    }
</script>
<style>
.mn-t-2{
    margin-top: -8px!important;
}
    .modal-content{
        width: 100% !important ;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important ;
        position: absolute !important ;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    .redis01{
        color: red !important;
    }
    .green01{
        color: green !important;
    }
    .prueba{
        /* width:9px ;
        max-width:10;
        height:10; */
        /* overflow-y:scroll; */
        /* border:1px solid #eee; */
        box-shadow: 0px 0px 20px #ccc inset;
    }
    .anyClass {
    height:112px;
    width:278px;
    overflow-y: scroll;
    }
    .anyClass {
    height:112px;
    width:278px;
    overflow-y: scroll;
    }
    .border-r{
        border:1px solid #09111a !important;
    }
    .disBlo{
        display: block;
    }
    .disNo{
        display: none;
    }
   </style>
