
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
                        <i class="fa fa-align-justify"></i> Salida

                        <template v-if="listado">
                            <button  type="button" @click="mostrarDetalle()" class="btn orange float-right  btn-sm"  >
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </template>
                        <template v-else>
                           <button type="button" class="btn btn-secondary btn-sm float-right" @click="ocultarDetalle()">
                            Atras <i class="ml-2 fas fa-reply"></i>
                        </button>
                        </template>

                        
                    </div>

                     <template v-if="listado">

                    <div class="card-body">
                        

                        <br>
                        <b-card no-body>
                        <b-tabs pills card>
                            <b-tab title="Equipos" active>
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterio">
                                                <option value="ctdetsa_serie">Serie Producto</option>
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                            
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscar"  @keyup="listarSalida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscar == ''" @click="listarSalida(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Serie Producto</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalida)" :key="salida.id" >
                                                
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_serie"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                            <b-tab title="Materiales">
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterioSW">
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                           
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscarSW"  @keyup="listarSalidaMaterial(1,buscarSW,criterioSW)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscarSW == ''" @click="listarSalidaMaterial(1,buscarSW,criterioSW)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalidaMaterial)" :key="salida.idProducto"  >
                                               
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPaginaMaterial(pagination.current_page-1,buscarSW,criterioSW)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(page,buscarSW,criterioSW)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(pagination.current_page+1,buscarSW,criterioSW)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                        </b-tabs>
                        </b-card>


                        

                    </div>
                    </template>
                    <template v-else>
                    <div class="card-body">
                        <div class="row m-2">
                            
                            <div class="col-md-4">
                                <label for="">Usuario
                                    
                                </label>
                                    <v-select
                                    :on-search="selectUsuario"
                                    :class="{
                                           stylosError:this.usuario_id=='',
                                           stylosCorrec:this.usuario_id!=''
                                           }"
                                    label="ctusuar_usuario" 
                                    :options="arrayUsuario"
                                    placeholder="Buscar usuarios..."
                                    
                                    :onChange="getDatosProducto"                                        
                                >
                                </v-select>
                                

                            </div>
                            <div class="col-md-4">
                                <label for="">Código SOT 
                                    <!-- <span style="color:red;"  v-show="codigo_sot==''">(*Rellene este campo)</span> -->
                                    
                                </label>
                                    <b-form-input   id="inputLive"
                                                    v-model.trim="codigo_sot"
                                                    type="number"
                                                    :state="sotState"
                                                    placeholder="">
                                    </b-form-input>
                                    <b-form-invalid-feedback v-show="codigo_sot==''" id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                    Rellene este campo
                                    </b-form-invalid-feedback>
                            </div>
                            <div class="col-md-4">
                                <label for="">Fecha de Llegada</label>
                                <datepicker v-model="fechaLlegada" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>

                            </div>
                        </div>     
                        
                            <hr class="my-1">
                                <div class="row">
                                    <div class="col-md-12">

                                        <button :disabled="arrayUsuario <1 || codigo_sot==''"  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                       
                                    </div>
                                </div>  
                            <hr class="my-1">

                                <!-- Modal -->
                                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Salida de Productos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                             
                                <div hidden="hidden" id="tabla" class="card m-2" ref="myModalRef" >
                                     <input type="text" placeholder="Texto a buscar">
                                 <div class="table-responsive">
                                    <table   class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                <th>SAP</th>
                                                <th>SERIE</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in arraySalida" :key="salida.idProducto"  >
                                                <td v-text="salida.ctdetsa_sot" ></td>
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td>
                                                     <button :disabled="codigo_sot == ''" type="button" class="btn btn-primary m-2 float-right btn-sm" data-toggle="modal" data-target="#basicExampleModal1">Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div> 
                                 
                                    <div class="modal-body">
                                        <b-card no-body>
                                        <b-tabs pills card >
                                            <b-tab title="Equipo" active>
                                              
                                                <!-- {{arraySAP}} -->
                                                <!-- {{arrayEquiEn}} -->
                                                    
                                                    
                                                    <!-- <input type="text"  ref="emailss"  v-model="buscar" @keyup="listarSAP(buscar,criterio1)" class="form-control" placeholder="Texto a buscar">
                                                    <span style="color:red;"  v-show="codigo_sot==''">(*Rellene Código SOT para registrar en este campo)</span>
                                                     -->
                                                     <div class="row">
                                                        <div class="col-md-10">
                                                            <label for="">Código SAP</label>
                                                            <div class="btn-group float-right" >
                                                                <button  class="btn-transparent  blue-text" @click.prevent="clearSap()" >
                                                                    <i class="fas fa-eraser"></i>
                                                                </button>
                                                        </div>
                                                            <input type="text" v-on:keyup.enter="listarProductoEncontrar(buscarSap02)"  v-model="buscarSap02"  class="form-control" >
                                                        </div>
                                                        <div class="col-md-2">
                                                           <br>
                                                            <button @click="listarProductoEncontrar(buscarSap02)"  :disabled="error22" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                <i  class="fas fa-dolly"></i>
                                                            </button>
                                                        </div>

                                                        <br>
                                                        <div class="col-md-12">
                                                        
                                                        
                                                        <div class="row">
                                                            <div class="col-1">
                                                                <br>
                                                                <i class="fas fa-barcode reds01 mt-2"></i>
                                                               
                                                            </div>
                                                            <div class="col-10">
                                                                <label for="">Número de Serie</label>
                                                                 <div class="btn-group float-right" >
                                                                    <button type="button" :disabled="ControlSer" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                                </div>
                                                                 <input type="text" :disabled="ControlSer"  v-model="buscar05" @keyup="buscarInfo()" class="form-control gres01" >  
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
                                                     
                                                     

                                                     <!-- <b-alert variant="danger"
                                                            dismissible
                                                            :show="showDismissibleAlert"
                                                            @dismissed="showDismissibleAlert=false">
                                                    Equipo no registrado

                                                    </b-alert> -->

                                                    <!-- {{arrayEquiEn}} -->
                                                    <!-- {{tasks}} -->

                                                    <div v-if="eqLis === 1">
                                                        <br>
                                                        <hr class="my-1">
                                                         <div class="btn-group float-right" >
                                                                <button @click.prevent="eqLis=2" class="btn-transparent red-text">
                                                                    <i class="fas fa-times"></i>
                                                                </button>   
                                                        </div>
                                                            <b-row>
                                                            <b-col md="6" class="my-1">
                                                                
                                                                <label for="">Busqueda</label>
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
                                                                            :items="(arrayEquiEn)"
                                                                            :fields="fields"
                                                                            :current-page="currentPage1"
                                                                            :per-page="perPage1"
                                                                            :filter="filter"
                                                                            :sort-by.sync="sortBy"
                                                                            :sort-desc.sync="sortDesc"
                                                                            :sort-direction="sortDirection"
                                                                            @filtered="onFiltered"
                                                                    >
                                                                    
                                                                    <template slot="opciones" slot-scope="row">
                                                                        <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
                                                                        <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)"  class="mr-1">
                                                                        Agregar
                                                                        </b-button>
                                                                    </template>
                                                                    
                                                                    </b-table>
                                                                    
                                                                    <b-row>
                                                                    <b-col md="6" class="my-1">
                                                                        <b-pagination :total-rows="this.arrayEquiEn.length" :per-page="perPage1" v-model="currentPage1" class="my-0" />
                                                                    </b-col>
                                                                    </b-row>
                                                                  
                                                                    <!-- Info modal -->
                                                            </div>
                                                    </div>
                                                    <div v-if="eqLis === 2" >
                                                        <br>
                                                        <b-container fluid>
                                                               
                                                        </b-container>
                                                    </div>
                                            </b-tab>
                                            <b-tab title="Materiales">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- {{arraySAPMate}} -->
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
                                                       <input type="text" v-model="buscar1" v-on:keyup.enter="listarMaterialB(buscar1,criterio2)" @keyup.enter="eqLisCanti=1"  class="form-control" placeholder="Texto a buscar">
                                                            
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  v-if="eqLisCanti ===1">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <label for="">Can.</label>
                                                                    <tr class="text-center" 
                                                                        style="font-weight:bolder ; top: 0px; right: 34px; position: absolute;" 
                                                                        v-for="ingreso in arraySAPMate" 
                                                                        :key="ingreso.pro" > 

                                                                        <label class="green-text" v-text="ingreso.ctproduc_stock" ></label> 
                                                                        <label  v-text="ingreso.ctundmd_desc" ></label>             
                                                                    </tr>
                                                                    
                                                                    <b-form-input   
                                                                                v-model="cantidadProductos"
                                                                                type="number"
                                                                                :disabled="buscar1 == ''||this.arraySAPMate ==''"
                                                                                :state="cantiState"
                                                                                
                                                                                >
                                                                    </b-form-input>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button  class="btn-transparent float-right red-text dispaly05" v-on:click="eqLisCanti=2" >
                                                                       <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <br>
                                                                    <button @click="agregra()"  :disabled="buscar1 == ''||this.arraySAPMate ==''||ConCanti" v-on:click="eqLisCanti=2" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                        <i  class="fas fa-dolly"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div  v-if="eqLisCanti ===2">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                     <br>
                                                                <button @click="listarMaterialB(buscar1,criterio2) " v-on:click="eqLisCanti=1"  :disabled="buscar1 == ''" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                    <i  class="fas fa-dolly"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                        </div>
                                                        
                                                        <!-- <p class="">und. med: <span class="green-text">{{arraM02()}}</span> </p> -->
                                                    </div>
                                                    
                                                    
                                               
                                                   
                                                    <div class="col-md-12">
                                                        <div v-if="eqLis01 === 1">
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
                                                            <br>
                                                            <b-container fluid>
                                                                <div class="col-md-12"> 
                                                                </div>  
                                                            </b-container>
                                                        </div>
                                                    </div>

                                                </div>
                                            </b-tab>
                                        </b-tabs>
                                        </b-card>
                                    </div>
                                   
                                    </div>
                                </div>
                                </div>

           
                       
                            <div class="row">
                                <div class="col-md-4">
                                   <label for="">Paginación</label>
                                    <b-form-select :options="pageOptions" v-model="perPage" />
                                
                                </div>

                             <div class="col-md-8">
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <button type="button" :disabled="tasks.length == 0"  class="btn btn-primary btn-sm float-right" @click="registrarSalida()" >
                                            Registrar salida
                                        </button>
                                        <!-- <span v-if="errores.ctdetpr_serie" :class="['label label-danger']">{{ errores.ctdetpr_serie[0] }}</span> -->
        
                                        <button  v-b-tooltip.hover title="Descargar Reporte"  type="button" :disabled="tasks.length == 0"  @click="exportPdf" class="float-right btn red btn-sm " >
                                            <i class="fas fa-download white-text" id="icons"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>


                            </div>
                             <br>
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered " >
                                    <thead class="blue white-text">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">tipo</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Serie del Producto</th>
                                            
                                            <th  scope="col">Cantidad</th>
                                            <th>Unidad Medida</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr v-for=" (task,indice) in paginador(tasks) " :key="task.descripcion" >
                                                <td>{{indice+1}}</td>
                                                <td>

                                                    {{tipoDe(task.detaTi)}}
                                                    
                                                </td>
                                                <td>{{task.cate01}}</td>
                                                <td>{{task.prodescri}}</td>
                                                <td>{{task.prod01}}</td>
                                                
                                                <td class="retroCanti text-center">{{task.cantidadProducto}}</td>
                                                <td>{{task.unidadDescripcion}}</td>
                                                <td class="text-center ">
                                                    <div class="btn-group " >
                                                        <button type="button"  class=" btn-transparent red-text" @click="deleteTask(indice)">
                                                        <i class="fas fa-backspace"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            

                                        </tr>
                                    </tbody>
                                </table> 
                            </div>E
                             <b-pagination size="md" align="center" :total-rows="this.tasks.length" v-model="currentPage" :per-page="perPage">
                            </b-pagination> 
                       
                        <br>
                        <hr>
                        <br>
                       
                   </div>
                    </template>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
     

            
           
        </main>
</template><template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
              <br>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Salida

                        <template v-if="listado">
                            <button  type="button" @click="mostrarDetalle()" class="btn orange float-right  btn-sm"  >
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </template>
                        <template v-else>
                           <button type="button" class="btn btn-secondary btn-sm float-right" @click="ocultarDetalle()">
                            Atras <i class="ml-2 fas fa-reply"></i>
                        </button>
                        </template>

                        
                    </div>

                     <template v-if="listado">

                    <div class="card-body">
                        

                        <br>
                        <b-card no-body>
                        <b-tabs pills card>
                            <b-tab title="Equipos" active>
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterio">
                                                <option value="ctdetsa_serie">Serie Producto</option>
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                            
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscar"  @keyup="listarSalida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscar == ''" @click="listarSalida(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Serie Producto</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalida)" :key="salida.id" >
                                                
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_serie"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                            <b-tab title="Materiales">
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterioSW">
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                           
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscarSW"  @keyup="listarSalidaMaterial(1,buscarSW,criterioSW)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscarSW == ''" @click="listarSalidaMaterial(1,buscarSW,criterioSW)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalidaMaterial)" :key="salida.idProducto"  >
                                               
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPaginaMaterial(pagination.current_page-1,buscarSW,criterioSW)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(page,buscarSW,criterioSW)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(pagination.current_page+1,buscarSW,criterioSW)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                        </b-tabs>
                        </b-card>


                        

                    </div>
                    </template>
                    <template v-else>
                    <div class="card-body">
                        <div class="row m-2">
                            
                            <div class="col-md-4">
                                <label for="">Usuario
                                    
                                </label>
                                    <v-select
                                    :on-search="selectUsuario"
                                    :class="{
                                           stylosError:this.usuario_id=='',
                                           stylosCorrec:this.usuario_id!=''
                                           }"
                                    label="ctusuar_usuario" 
                                    :options="arrayUsuario"
                                    placeholder="Buscar usuarios..."
                                    
                                    :onChange="getDatosProducto"                                        
                                >
                                </v-select>
                                

                            </div>
                            <div class="col-md-4">
                                <label for="">Código SOT 
                                    <!-- <span style="color:red;"  v-show="codigo_sot==''">(*Rellene este campo)</span> -->
                                    
                                </label>
                                    <b-form-input   id="inputLive"
                                                    v-model.trim="codigo_sot"
                                                    type="number"
                                                    :state="sotState"
                                                    placeholder="">
                                    </b-form-input>
                                    <b-form-invalid-feedback v-show="codigo_sot==''" id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                    Rellene este campo
                                    </b-form-invalid-feedback>
                            </div>
                            <div class="col-md-4">
                                <label for="">Fecha de Llegada</label>
                                <datepicker v-model="fechaLlegada" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>

                            </div>
                        </div>     
                        
                            <hr class="my-1">
                                <div class="row">
                                    <div class="col-md-12">

                                        <button :disabled="arrayUsuario <1 || codigo_sot==''"  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                       
                                    </div>
                                </div>  
                            <hr class="my-1">

                                <!-- Modal -->
                                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Salida de Productos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                             
                                <div hidden="hidden" id="tabla" class="card m-2" ref="myModalRef" >
                                     <input type="text" placeholder="Texto a buscar">
                                 <div class="table-responsive">
                                    <table   class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                <th>SAP</th>
                                                <th>SERIE</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in arraySalida" :key="salida.idProducto"  >
                                                <td v-text="salida.ctdetsa_sot" ></td>
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td>
                                                     <button :disabled="codigo_sot == ''" type="button" class="btn btn-primary m-2 float-right btn-sm" data-toggle="modal" data-target="#basicExampleModal1">Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div> 
                                 
                                    <div class="modal-body">
                                        <b-card no-body>
                                        <b-tabs pills card >
                                            <b-tab title="Equipo" active>
                                              
                                                <!-- {{arraySAP}} -->
                                                <!-- {{arrayEquiEn}} -->
                                                    
                                                    
                                                    <!-- <input type="text"  ref="emailss"  v-model="buscar" @keyup="listarSAP(buscar,criterio1)" class="form-control" placeholder="Texto a buscar">
                                                    <span style="color:red;"  v-show="codigo_sot==''">(*Rellene Código SOT para registrar en este campo)</span>
                                                     -->
                                                     <div class="row">
                                                        <div class="col-md-10">
                                                            <label for="">Código SAP</label>
                                                            <div class="btn-group float-right" >
                                                                <button  class="btn-transparent  blue-text" @click.prevent="clearSap()" >
                                                                    <i class="fas fa-eraser"></i>
                                                                </button>
                                                        </div>
                                                            <input type="text" v-on:keyup.enter="listarProductoEncontrar(buscarSap02)"  v-model="buscarSap02"  class="form-control" >
                                                        </div>
                                                        <div class="col-md-2">
                                                           <br>
                                                            <button @click="listarProductoEncontrar(buscarSap02)"  :disabled="error22" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                <i  class="fas fa-dolly"></i>
                                                            </button>
                                                        </div>

                                                        <br>
                                                        <div class="col-md-12">
                                                        
                                                        
                                                        <div class="row">
                                                            <div class="col-1">
                                                                <br>
                                                                <i class="fas fa-barcode reds01 mt-2"></i>
                                                               
                                                            </div>
                                                            <div class="col-10">
                                                                <label for="">Número de Serie</label>
                                                                 <div class="btn-group float-right" >
                                                                    <button type="button" :disabled="ControlSer" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                                </div>
                                                                 <input type="text" :disabled="ControlSer"  v-model="buscar05" @keyup="buscarInfo()" class="form-control gres01" >  
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
                                                     
                                                     

                                                     <!-- <b-alert variant="danger"
                                                            dismissible
                                                            :show="showDismissibleAlert"
                                                            @dismissed="showDismissibleAlert=false">
                                                    Equipo no registrado

                                                    </b-alert> -->

                                                    <!-- {{arrayEquiEn}} -->
                                                    <!-- {{tasks}} -->

                                                    <div v-if="eqLis === 1">
                                                        <br>
                                                        <hr class="my-1">
                                                         <div class="btn-group float-right" >
                                                                <button @click.prevent="eqLis=2" class="btn-transparent red-text">
                                                                    <i class="fas fa-times"></i>
                                                                </button>   
                                                        </div>
                                                            <b-row>
                                                            <b-col md="6" class="my-1">
                                                                
                                                                <label for="">Busqueda</label>
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
                                                                            :items="(arrayEquiEn)"
                                                                            :fields="fields"
                                                                            :current-page="currentPage1"
                                                                            :per-page="perPage1"
                                                                            :filter="filter"
                                                                            :sort-by.sync="sortBy"
                                                                            :sort-desc.sync="sortDesc"
                                                                            :sort-direction="sortDirection"
                                                                            @filtered="onFiltered"
                                                                    >
                                                                    
                                                                    <template slot="opciones" slot-scope="row">
                                                                        <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
                                                                        <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)"  class="mr-1">
                                                                        Agregar
                                                                        </b-button>
                                                                    </template>
                                                                    
                                                                    </b-table>
                                                                    
                                                                    <b-row>
                                                                    <b-col md="6" class="my-1">
                                                                        <b-pagination :total-rows="this.arrayEquiEn.length" :per-page="perPage1" v-model="currentPage1" class="my-0" />
                                                                    </b-col>
                                                                    </b-row>
                                                                  
                                                                    <!-- Info modal -->
                                                            </div>
                                                    </div>
                                                    <div v-if="eqLis === 2" >
                                                        <br>
                                                        <b-container fluid>
                                                               
                                                        </b-container>
                                                    </div>
                                            </b-tab>
                                            <b-tab title="Materiales">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- {{arraySAPMate}} -->
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
                                                       <input type="text" v-model="buscar1" v-on:keyup.enter="listarMaterialB(buscar1,criterio2)" @keyup.enter="eqLisCanti=1"  class="form-control" placeholder="Texto a buscar">
                                                            
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  v-if="eqLisCanti ===1">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <label for="">Can.</label>
                                                                    <tr class="text-center" 
                                                                        style="font-weight:bolder ; top: 0px; right: 34px; position: absolute;" 
                                                                        v-for="ingreso in arraySAPMate" 
                                                                        :key="ingreso.pro" > 

                                                                        <label class="green-text" v-text="ingreso.ctproduc_stock" ></label> 
                                                                        <label  v-text="ingreso.ctundmd_desc" ></label>             
                                                                    </tr>
                                                                    
                                                                    <b-form-input   
                                                                                v-model="cantidadProductos"
                                                                                type="number"
                                                                                :disabled="buscar1 == ''||this.arraySAPMate ==''"
                                                                                :state="cantiState"
                                                                                
                                                                                >
                                                                    </b-form-input>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button  class="btn-transparent float-right red-text dispaly05" v-on:click="eqLisCanti=2" >
                                                                       <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <br>
                                                                    <button @click="agregra()"  :disabled="buscar1 == ''||this.arraySAPMate ==''||ConCanti" v-on:click="eqLisCanti=2" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                        <i  class="fas fa-dolly"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div  v-if="eqLisCanti ===2">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                     <br>
                                                                <button @click="listarMaterialB(buscar1,criterio2) " v-on:click="eqLisCanti=1"  :disabled="buscar1 == ''" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                    <i  class="fas fa-dolly"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                        </div>
                                                        
                                                        <!-- <p class="">und. med: <span class="green-text">{{arraM02()}}</span> </p> -->
                                                    </div>
                                                    
                                                    
                                               
                                                   
                                                    <div class="col-md-12">
                                                        <div v-if="eqLis01 === 1">
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
                                                            <br>
                                                            <b-container fluid>
                                                                <div class="col-md-12"> 
                                                                </div>  
                                                            </b-container>
                                                        </div>
                                                    </div>

                                                </div>
                                            </b-tab>
                                        </b-tabs>
                                        </b-card>
                                    </div>
                                   
                                    </div>
                                </div>
                                </div>

           
                       
                            <div class="row">
                                <div class="col-md-4">
                                   <label for="">Paginación</label>
                                    <b-form-select :options="pageOptions" v-model="perPage" />
                                
                                </div>

                             <div class="col-md-8">
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <button type="button" :disabled="tasks.length == 0"  class="btn btn-primary btn-sm float-right" @click="registrarSalida()" >
                                            Registrar salida
                                        </button>
                                        <!-- <span v-if="errores.ctdetpr_serie" :class="['label label-danger']">{{ errores.ctdetpr_serie[0] }}</span> -->
        
                                        <button  v-b-tooltip.hover title="Descargar Reporte"  type="button" :disabled="tasks.length == 0"  @click="exportPdf" class="float-right btn red btn-sm " >
                                            <i class="fas fa-download white-text" id="icons"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>


                            </div>
                             <br>
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered " >
                                    <thead class="blue white-text">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">tipo</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Serie del Producto</th>
                                            
                                            <th  scope="col">Cantidad</th>
                                            <th>Unidad Medida</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr v-for=" (task,indice) in paginador(tasks) " :key="task.descripcion" >
                                                <td>{{indice+1}}</td>
                                                <td>

                                                    {{tipoDe(task.detaTi)}}
                                                    
                                                </td>
                                                <td>{{task.cate01}}</td>
                                                <td>{{task.prodescri}}</td>
                                                <td>{{task.prod01}}</td>
                                                
                                                <td class="retroCanti text-center">{{task.cantidadProducto}}</td>
                                                <td>{{task.unidadDescripcion}}</td>
                                                <td class="text-center ">
                                                    <div class="btn-group " >
                                                        <button type="button"  class=" btn-transparent red-text" @click="deleteTask(indice)">
                                                        <i class="fas fa-backspace"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            

                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                             <b-pagination size="md" align="center" :total-rows="this.tasks.length" v-model="currentPage" :per-page="perPage">
                            </b-pagination> 
                       
                        <br>
                        <hr>
                        <br>
                       
                   </div>
                    </template>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
     

            
           
        </main>
</template><template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
              <br>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Salida

                        <template v-if="listado">
                            <button  type="button" @click="mostrarDetalle()" class="btn orange float-right  btn-sm"  >
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </template>
                        <template v-else>
                           <button type="button" class="btn btn-secondary btn-sm float-right" @click="ocultarDetalle()">
                            Atras <i class="ml-2 fas fa-reply"></i>
                        </button>
                        </template>

                        
                    </div>

                     <template v-if="listado">

                    <div class="card-body">
                        

                        <br>
                        <b-card no-body>
                        <b-tabs pills card>
                            <b-tab title="Equipos" active>
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterio">
                                                <option value="ctdetsa_serie">Serie Producto</option>
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                            
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscar"  @keyup="listarSalida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscar == ''" @click="listarSalida(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Serie Producto</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalida)" :key="salida.id" >
                                                
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_serie"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                            <b-tab title="Materiales">
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterioSW">
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                           
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscarSW"  @keyup="listarSalidaMaterial(1,buscarSW,criterioSW)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscarSW == ''" @click="listarSalidaMaterial(1,buscarSW,criterioSW)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalidaMaterial)" :key="salida.idProducto"  >
                                               
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPaginaMaterial(pagination.current_page-1,buscarSW,criterioSW)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(page,buscarSW,criterioSW)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(pagination.current_page+1,buscarSW,criterioSW)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                        </b-tabs>
                        </b-card>


                        

                    </div>
                    </template>
                    <template v-else>
                    <div class="card-body">
                        <div class="row m-2">
                            
                            <div class="col-md-4">
                                <label for="">Usuario
                                    
                                </label>
                                    <v-select
                                    :on-search="selectUsuario"
                                    :class="{
                                           stylosError:this.usuario_id=='',
                                           stylosCorrec:this.usuario_id!=''
                                           }"
                                    label="ctusuar_usuario" 
                                    :options="arrayUsuario"
                                    placeholder="Buscar usuarios..."
                                    
                                    :onChange="getDatosProducto"                                        
                                >
                                </v-select>
                                

                            </div>
                            <div class="col-md-4">
                                <label for="">Código SOT 
                                    <!-- <span style="color:red;"  v-show="codigo_sot==''">(*Rellene este campo)</span> -->
                                    
                                </label>
                                    <b-form-input   id="inputLive"
                                                    v-model.trim="codigo_sot"
                                                    type="number"
                                                    :state="sotState"
                                                    placeholder="">
                                    </b-form-input>
                                    <b-form-invalid-feedback v-show="codigo_sot==''" id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                    Rellene este campo
                                    </b-form-invalid-feedback>
                            </div>
                            <div class="col-md-4">
                                <label for="">Fecha de Llegada</label>
                                <datepicker v-model="fechaLlegada" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>

                            </div>
                        </div>     
                        
                            <hr class="my-1">
                                <div class="row">
                                    <div class="col-md-12">

                                        <button :disabled="arrayUsuario <1 || codigo_sot==''"  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                       
                                    </div>
                                </div>  
                            <hr class="my-1">

                                <!-- Modal -->
                                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Salida de Productos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                             
                                <div hidden="hidden" id="tabla" class="card m-2" ref="myModalRef" >
                                     <input type="text" placeholder="Texto a buscar">
                                 <div class="table-responsive">
                                    <table   class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                <th>SAP</th>
                                                <th>SERIE</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in arraySalida" :key="salida.idProducto"  >
                                                <td v-text="salida.ctdetsa_sot" ></td>
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td>
                                                     <button :disabled="codigo_sot == ''" type="button" class="btn btn-primary m-2 float-right btn-sm" data-toggle="modal" data-target="#basicExampleModal1">Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div> 
                                 
                                    <div class="modal-body">
                                        <b-card no-body>
                                        <b-tabs pills card >
                                            <b-tab title="Equipo" active>
                                              
                                                <!-- {{arraySAP}} -->
                                                <!-- {{arrayEquiEn}} -->
                                                    
                                                    
                                                    <!-- <input type="text"  ref="emailss"  v-model="buscar" @keyup="listarSAP(buscar,criterio1)" class="form-control" placeholder="Texto a buscar">
                                                    <span style="color:red;"  v-show="codigo_sot==''">(*Rellene Código SOT para registrar en este campo)</span>
                                                     -->
                                                     <div class="row">
                                                        <div class="col-md-10">
                                                            <label for="">Código SAP</label>
                                                            <div class="btn-group float-right" >
                                                                <button  class="btn-transparent  blue-text" @click.prevent="clearSap()" >
                                                                    <i class="fas fa-eraser"></i>
                                                                </button>
                                                        </div>
                                                            <input type="text" v-on:keyup.enter="listarProductoEncontrar(buscarSap02)"  v-model="buscarSap02"  class="form-control" >
                                                        </div>
                                                        <div class="col-md-2">
                                                           <br>
                                                            <button @click="listarProductoEncontrar(buscarSap02)"  :disabled="error22" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                <i  class="fas fa-dolly"></i>
                                                            </button>
                                                        </div>

                                                        <br>
                                                        <div class="col-md-12">
                                                        
                                                        
                                                        <div class="row">
                                                            <div class="col-1">
                                                                <br>
                                                                <i class="fas fa-barcode reds01 mt-2"></i>
                                                               
                                                            </div>
                                                            <div class="col-10">
                                                                <label for="">Número de Serie</label>
                                                                 <div class="btn-group float-right" >
                                                                    <button type="button" :disabled="ControlSer" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                                </div>
                                                                 <input type="text" :disabled="ControlSer"  v-model="buscar05" @keyup="buscarInfo()" class="form-control gres01" >  
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
                                                     
                                                     

                                                     <!-- <b-alert variant="danger"
                                                            dismissible
                                                            :show="showDismissibleAlert"
                                                            @dismissed="showDismissibleAlert=false">
                                                    Equipo no registrado

                                                    </b-alert> -->

                                                    <!-- {{arrayEquiEn}} -->
                                                    <!-- {{tasks}} -->

                                                    <div v-if="eqLis === 1">
                                                        <br>
                                                        <hr class="my-1">
                                                         <div class="btn-group float-right" >
                                                                <button @click.prevent="eqLis=2" class="btn-transparent red-text">
                                                                    <i class="fas fa-times"></i>
                                                                </button>   
                                                        </div>
                                                            <b-row>
                                                            <b-col md="6" class="my-1">
                                                                
                                                                <label for="">Busqueda</label>
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
                                                                            :items="(arrayEquiEn)"
                                                                            :fields="fields"
                                                                            :current-page="currentPage1"
                                                                            :per-page="perPage1"
                                                                            :filter="filter"
                                                                            :sort-by.sync="sortBy"
                                                                            :sort-desc.sync="sortDesc"
                                                                            :sort-direction="sortDirection"
                                                                            @filtered="onFiltered"
                                                                    >
                                                                    
                                                                    <template slot="opciones" slot-scope="row">
                                                                        <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
                                                                        <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)"  class="mr-1">
                                                                        Agregar
                                                                        </b-button>
                                                                    </template>
                                                                    
                                                                    </b-table>
                                                                    
                                                                    <b-row>
                                                                    <b-col md="6" class="my-1">
                                                                        <b-pagination :total-rows="this.arrayEquiEn.length" :per-page="perPage1" v-model="currentPage1" class="my-0" />
                                                                    </b-col>
                                                                    </b-row>
                                                                  
                                                                    <!-- Info modal -->
                                                            </div>
                                                    </div>
                                                    <div v-if="eqLis === 2" >
                                                        <br>
                                                        <b-container fluid>
                                                               
                                                        </b-container>
                                                    </div>
                                            </b-tab>
                                            <b-tab title="Materiales">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- {{arraySAPMate}} -->
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
                                                       <input type="text" v-model="buscar1" v-on:keyup.enter="listarMaterialB(buscar1,criterio2)" @keyup.enter="eqLisCanti=1"  class="form-control" placeholder="Texto a buscar">
                                                            
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  v-if="eqLisCanti ===1">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <label for="">Can.</label>
                                                                    <tr class="text-center" 
                                                                        style="font-weight:bolder ; top: 0px; right: 34px; position: absolute;" 
                                                                        v-for="ingreso in arraySAPMate" 
                                                                        :key="ingreso.pro" > 

                                                                        <label class="green-text" v-text="ingreso.ctproduc_stock" ></label> 
                                                                        <label  v-text="ingreso.ctundmd_desc" ></label>             
                                                                    </tr>
                                                                    
                                                                    <b-form-input   
                                                                                v-model="cantidadProductos"
                                                                                type="number"
                                                                                :disabled="buscar1 == ''||this.arraySAPMate ==''"
                                                                                :state="cantiState"
                                                                                
                                                                                >
                                                                    </b-form-input>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button  class="btn-transparent float-right red-text dispaly05" v-on:click="eqLisCanti=2" >
                                                                       <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <br>
                                                                    <button @click="agregra()"  :disabled="buscar1 == ''||this.arraySAPMate ==''||ConCanti" v-on:click="eqLisCanti=2" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                        <i  class="fas fa-dolly"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div  v-if="eqLisCanti ===2">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                     <br>
                                                                <button @click="listarMaterialB(buscar1,criterio2) " v-on:click="eqLisCanti=1"  :disabled="buscar1 == ''" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                    <i  class="fas fa-dolly"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                        </div>
                                                        
                                                        <!-- <p class="">und. med: <span class="green-text">{{arraM02()}}</span> </p> -->
                                                    </div>
                                                    
                                                    
                                               
                                                   
                                                    <div class="col-md-12">
                                                        <div v-if="eqLis01 === 1">
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
                                                            <br>
                                                            <b-container fluid>
                                                                <div class="col-md-12"> 
                                                                </div>  
                                                            </b-container>
                                                        </div>
                                                    </div>

                                                </div>
                                            </b-tab>
                                        </b-tabs>
                                        </b-card>
                                    </div>
                                   
                                    </div>
                                </div>
                                </div>

           
                       
                            <div class="row">
                                <div class="col-md-4">
                                   <label for="">Paginación</label>
                                    <b-form-select :options="pageOptions" v-model="perPage" />
                                
                                </div>

                             <div class="col-md-8">
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <button type="button" :disabled="tasks.length == 0"  class="btn btn-primary btn-sm float-right" @click="registrarSalida()" >
                                            Registrar salida
                                        </button>
                                        <!-- <span v-if="errores.ctdetpr_serie" :class="['label label-danger']">{{ errores.ctdetpr_serie[0] }}</span> -->
        
                                        <button  v-b-tooltip.hover title="Descargar Reporte"  type="button" :disabled="tasks.length == 0"  @click="exportPdf" class="float-right btn red btn-sm " >
                                            <i class="fas fa-download white-text" id="icons"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>


                            </div>
                             <br>
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered " >
                                    <thead class="blue white-text">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">tipo</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Serie del Producto</th>
                                            
                                            <th  scope="col">Cantidad</th>
                                            <th>Unidad Medida</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr v-for=" (task,indice) in paginador(tasks) " :key="task.descripcion" >
                                                <td>{{indice+1}}</td>
                                                <td>

                                                    {{tipoDe(task.detaTi)}}
                                                    
                                                </td>
                                                <td>{{task.cate01}}</td>
                                                <td>{{task.prodescri}}</td>
                                                <td>{{task.prod01}}</td>
                                                
                                                <td class="retroCanti text-center">{{task.cantidadProducto}}</td>
                                                <td>{{task.unidadDescripcion}}</td>
                                                <td class="text-center ">
                                                    <div class="btn-group " >
                                                        <button type="button"  class=" btn-transparent red-text" @click="deleteTask(indice)">
                                                        <i class="fas fa-backspace"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            

                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                             <b-pagination size="md" align="center" :total-rows="this.tasks.length" v-model="currentPage" :per-page="perPage">
                            </b-pagination> 
                       
                        <br>
                        <hr>
                        <br>
                       
                   </div>
                    </template>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
     

            
           
        </main>
</template><template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
              <br>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Salida

                        <template v-if="listado">
                            <button  type="button" @click="mostrarDetalle()" class="btn orange float-right  btn-sm"  >
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </template>
                        <template v-else>
                           <button type="button" class="btn btn-secondary btn-sm float-right" @click="ocultarDetalle()">
                            Atras <i class="ml-2 fas fa-reply"></i>
                        </button>
                        </template>

                        
                    </div>

                     <template v-if="listado">

                    <div class="card-body">
                        

                        <br>
                        <b-card no-body>
                        <b-tabs pills card>
                            <b-tab title="Equipos" active>
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterio">
                                                <option value="ctdetsa_serie">Serie Producto</option>
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                            
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscar"  @keyup="listarSalida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscar == ''" @click="listarSalida(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Serie Producto</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                                
                                            
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalida)" :key="salida.id" >
                                                
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_serie"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                            <b-tab title="Materiales">
                                <div class="row">
                                    <div class="col-md-3">
                                            <select class="form-control mt-2" v-model="criterioSW">
                                            <option value="ctdetsa_sap">Sap</option>
                                            <option value="ctdetsa_fecha_act">Fecha</option>
                                           
                                            </select>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form input-group mt-0 mb-3">
                                            <input type="text" v-model="buscarSW"  @keyup="listarSalidaMaterial(1,buscarSW,criterioSW)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscarSW == ''" @click="listarSalidaMaterial(1,buscarSW,criterioSW)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N° Salida</th>
                                                <th>Producto</th>
                                                <th>SAP</th>
                                                <th>Cantidad</th>
                                                <th>Unidad de Medida</th>
                                                <th>Fecha Registro</th>
                                                <th>Tipo de Producto</th>
                                                <th>Usuario</th>
                                                
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in (arraySalidaMaterial)" :key="salida.idProducto"  >
                                               
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td v-text="salida.ctdetsa_produDescri"></td>    
                                                <td v-text="salida.ctdetsa_sap"></td>
                                                <td v-text="salida.ctdetsa_cantidad"></td>
                                                <td v-text="salida.ctdetsa_undmdDescri"></td>
                                                <td v-text="salida.ctdetsa_fecha_reg"></td>
                                                <td v-text="salida.ctdetsa_descriTipo"></td>
                                                <td v-text="salida.ctdetsa_usuario"></td>
                                                <td >
                                                     <b-btn type="button" class="btn btn-danger btn-sm" @click="desactivarEquipo(salida.ctdetsa_indice)">
                                                        Liquidar
                                                     </b-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <nav aria-label="pagination example">
                                    <ul class="pagination pg-blue">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent ="cambiarPaginaMaterial(pagination.current_page-1,buscarSW,criterioSW)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(page,buscarSW,criterioSW)" v-text="page" ></a>
                                        </li>
                                    
                                        <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPaginaMaterial(pagination.current_page+1,buscarSW,criterioSW)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </b-tab>
                        </b-tabs>
                        </b-card>


                        

                    </div>
                    </template>
                    <template v-else>
                    <div class="card-body">
                        <div class="row m-2">
                            
                            <div class="col-md-4">
                                <label for="">Usuario
                                    
                                </label>
                                    <v-select
                                    :on-search="selectUsuario"
                                    :class="{
                                           stylosError:this.usuario_id=='',
                                           stylosCorrec:this.usuario_id!=''
                                           }"
                                    label="ctusuar_usuario" 
                                    :options="arrayUsuario"
                                    placeholder="Buscar usuarios..."
                                    
                                    :onChange="getDatosProducto"                                        
                                >
                                </v-select>
                                

                            </div>
                            <div class="col-md-4">
                                <label for="">Código SOT 
                                    <!-- <span style="color:red;"  v-show="codigo_sot==''">(*Rellene este campo)</span> -->
                                    
                                </label>
                                    <b-form-input   id="inputLive"
                                                    v-model.trim="codigo_sot"
                                                    type="number"
                                                    :state="sotState"
                                                    placeholder="">
                                    </b-form-input>
                                    <b-form-invalid-feedback v-show="codigo_sot==''" id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                    Rellene este campo
                                    </b-form-invalid-feedback>
                            </div>
                            <div class="col-md-4">
                                <label for="">Fecha de Llegada</label>
                                <datepicker v-model="fechaLlegada" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>

                            </div>
                        </div>     
                        
                            <hr class="my-1">
                                <div class="row">
                                    <div class="col-md-12">

                                        <button :disabled="arrayUsuario <1 || codigo_sot==''"  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                       
                                    </div>
                                </div>  
                            <hr class="my-1">

                                <!-- Modal -->
                                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Salida de Productos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                             
                                <div hidden="hidden" id="tabla" class="card m-2" ref="myModalRef" >
                                     <input type="text" placeholder="Texto a buscar">
                                 <div class="table-responsive">
                                    <table   class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                <th>SAP</th>
                                                <th>SERIE</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="salida in arraySalida" :key="salida.idProducto"  >
                                                <td v-text="salida.ctdetsa_sot" ></td>
                                                <td v-text="salida.ctdetsa_salid_nro"></td>
                                                <td>
                                                     <button :disabled="codigo_sot == ''" type="button" class="btn btn-primary m-2 float-right btn-sm" data-toggle="modal" data-target="#basicExampleModal1">Agregar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div> 
                                 
                                    <div class="modal-body">
                                        <b-card no-body>
                                        <b-tabs pills card >
                                            <b-tab title="Equipo" active>
                                              
                                                <!-- {{arraySAP}} -->
                                                <!-- {{arrayEquiEn}} -->
                                                    
                                                    
                                                    <!-- <input type="text"  ref="emailss"  v-model="buscar" @keyup="listarSAP(buscar,criterio1)" class="form-control" placeholder="Texto a buscar">
                                                    <span style="color:red;"  v-show="codigo_sot==''">(*Rellene Código SOT para registrar en este campo)</span>
                                                     -->
                                                     <div class="row">
                                                        <div class="col-md-10">
                                                            <label for="">Código SAP</label>
                                                            <div class="btn-group float-right" >
                                                                <button  class="btn-transparent  blue-text" @click.prevent="clearSap()" >
                                                                    <i class="fas fa-eraser"></i>
                                                                </button>
                                                        </div>
                                                            <input type="text" v-on:keyup.enter="listarProductoEncontrar(buscarSap02)"  v-model="buscarSap02"  class="form-control" >
                                                        </div>
                                                        <div class="col-md-2">
                                                           <br>
                                                            <button @click="listarProductoEncontrar(buscarSap02)"  :disabled="error22" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                <i  class="fas fa-dolly"></i>
                                                            </button>
                                                        </div>

                                                        <br>
                                                        <div class="col-md-12">
                                                        
                                                        
                                                        <div class="row">
                                                            <div class="col-1">
                                                                <br>
                                                                <i class="fas fa-barcode reds01 mt-2"></i>
                                                               
                                                            </div>
                                                            <div class="col-10">
                                                                <label for="">Número de Serie</label>
                                                                 <div class="btn-group float-right" >
                                                                    <button type="button" :disabled="ControlSer" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                                </div>
                                                                 <input type="text" :disabled="ControlSer"  v-model="buscar05" @keyup="buscarInfo()" class="form-control gres01" >  
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
                                                     
                                                     

                                                     <!-- <b-alert variant="danger"
                                                            dismissible
                                                            :show="showDismissibleAlert"
                                                            @dismissed="showDismissibleAlert=false">
                                                    Equipo no registrado

                                                    </b-alert> -->

                                                    <!-- {{arrayEquiEn}} -->
                                                    <!-- {{tasks}} -->

                                                    <div v-if="eqLis === 1">
                                                        <br>
                                                        <hr class="my-1">
                                                         <div class="btn-group float-right" >
                                                                <button @click.prevent="eqLis=2" class="btn-transparent red-text">
                                                                    <i class="fas fa-times"></i>
                                                                </button>   
                                                        </div>
                                                            <b-row>
                                                            <b-col md="6" class="my-1">
                                                                
                                                                <label for="">Busqueda</label>
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
                                                                            :items="(arrayEquiEn)"
                                                                            :fields="fields"
                                                                            :current-page="currentPage1"
                                                                            :per-page="perPage1"
                                                                            :filter="filter"
                                                                            :sort-by.sync="sortBy"
                                                                            :sort-desc.sync="sortDesc"
                                                                            :sort-direction="sortDirection"
                                                                            @filtered="onFiltered"
                                                                    >
                                                                    
                                                                    <template slot="opciones" slot-scope="row">
                                                                        <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
                                                                        <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)"  class="mr-1">
                                                                        Agregar
                                                                        </b-button>
                                                                    </template>
                                                                    
                                                                    </b-table>
                                                                    
                                                                    <b-row>
                                                                    <b-col md="6" class="my-1">
                                                                        <b-pagination :total-rows="this.arrayEquiEn.length" :per-page="perPage1" v-model="currentPage1" class="my-0" />
                                                                    </b-col>
                                                                    </b-row>
                                                                  
                                                                    <!-- Info modal -->
                                                            </div>
                                                    </div>
                                                    <div v-if="eqLis === 2" >
                                                        <br>
                                                        <b-container fluid>
                                                               
                                                        </b-container>
                                                    </div>
                                            </b-tab>
                                            <b-tab title="Materiales">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- {{arraySAPMate}} -->
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
                                                       <input type="text" v-model="buscar1" v-on:keyup.enter="listarMaterialB(buscar1,criterio2)" @keyup.enter="eqLisCanti=1"  class="form-control" placeholder="Texto a buscar">
                                                            
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  v-if="eqLisCanti ===1">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <label for="">Can.</label>
                                                                    <tr class="text-center" 
                                                                        style="font-weight:bolder ; top: 0px; right: 34px; position: absolute;" 
                                                                        v-for="ingreso in arraySAPMate" 
                                                                        :key="ingreso.pro" > 

                                                                        <label class="green-text" v-text="ingreso.ctproduc_stock" ></label> 
                                                                        <label  v-text="ingreso.ctundmd_desc" ></label>             
                                                                    </tr>
                                                                    
                                                                    <b-form-input   
                                                                                v-model="cantidadProductos"
                                                                                type="number"
                                                                                :disabled="buscar1 == ''||this.arraySAPMate ==''"
                                                                                :state="cantiState"
                                                                                
                                                                                >
                                                                    </b-form-input>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button  class="btn-transparent float-right red-text dispaly05" v-on:click="eqLisCanti=2" >
                                                                       <i class="fas fa-times"></i>
                                                                    </button>
                                                                    <br>
                                                                    <button @click="agregra()"  :disabled="buscar1 == ''||this.arraySAPMate ==''||ConCanti" v-on:click="eqLisCanti=2" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                        <i  class="fas fa-dolly"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div  v-if="eqLisCanti ===2">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                     <br>
                                                                <button @click="listarMaterialB(buscar1,criterio2) " v-on:click="eqLisCanti=1"  :disabled="buscar1 == ''" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                    <i  class="fas fa-dolly"></i>
                                                                </button>
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                        </div>
                                                        
                                                        <!-- <p class="">und. med: <span class="green-text">{{arraM02()}}</span> </p> -->
                                                    </div>
                                                    
                                                    
                                               
                                                   
                                                    <div class="col-md-12">
                                                        <div v-if="eqLis01 === 1">
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
                                                            <br>
                                                            <b-container fluid>
                                                                <div class="col-md-12"> 
                                                                </div>  
                                                            </b-container>
                                                        </div>
                                                    </div>

                                                </div>
                                            </b-tab>
                                        </b-tabs>
                                        </b-card>
                                    </div>
                                   
                                    </div>
                                </div>
                                </div>

           
                       
                            <div class="row">
                                <div class="col-md-4">
                                   <label for="">Paginación</label>
                                    <b-form-select :options="pageOptions" v-model="perPage" />
                                
                                </div>

                             <div class="col-md-8">
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <button type="button" :disabled="tasks.length == 0"  class="btn btn-primary btn-sm float-right" @click="registrarSalida()" >
                                            Registrar salida
                                        </button>
                                        <!-- <span v-if="errores.ctdetpr_serie" :class="['label label-danger']">{{ errores.ctdetpr_serie[0] }}</span> -->
        
                                        <button  v-b-tooltip.hover title="Descargar Reporte"  type="button" :disabled="tasks.length == 0"  @click="exportPdf" class="float-right btn red btn-sm " >
                                            <i class="fas fa-download white-text" id="icons"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>


                            </div>
                             <br>
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered " >
                                    <thead class="blue white-text">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">tipo</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Serie del Producto</th>
                                            
                                            <th  scope="col">Cantidad</th>
                                            <th>Unidad Medida</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr v-for=" (task,indice) in paginador(tasks) " :key="task.descripcion" >
                                                <td>{{indice+1}}</td>
                                                <td>

                                                    {{tipoDe(task.detaTi)}}
                                                    
                                                </td>
                                                <td>{{task.cate01}}</td>
                                                <td>{{task.prodescri}}</td>
                                                <td>{{task.prod01}}</td>
                                                
                                                <td class="retroCanti text-center">{{task.cantidadProducto}}</td>
                                                <td>{{task.unidadDescripcion}}</td>
                                                <td class="text-center ">
                                                    <div class="btn-group " >
                                                        <button type="button"  class=" btn-transparent red-text" @click="deleteTask(indice)">
                                                        <i class="fas fa-backspace"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            

                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                             <b-pagination size="md" align="center" :total-rows="this.tasks.length" v-model="currentPage" :per-page="perPage">
                            </b-pagination> 
                       
                        <br>
                        <hr>
                        <br>
                       
                   </div>
                    </template>
                </div>
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
                // finds: [],
                items: items, 
                fields: ['sap','Serie','opciones'],
                fields01: ['SAP','DESCRIPCION','STOCK','OPCIONES'],
                fields02 :['ctdetsa_sot',
                            'ctdetsa_salid_nro',
                            'ctdetsa_produDescri',
                            'ctdetsa_sap',
                            'ctdetsa_serie',
                            'ctdetsa_cantidad',
                            'ctdetsa_undmdDescri',
                            'ctdetsa_fecha_reg',
                            'ctdetsa_descriTipo',
                            'ctdetsa_usuario',
                            ],
                currentPage: 1,
                currentPage1: 1,
                currentPage2: 1,
                perPage: 10,
                perPage1:5,
                perPage2:5,
                totalRows: items.length,
                totalRows1: items.length,
                pageOptions1: [ 5, 10 ],
                pageOptions2: [ 5, 10 ],
                pageOptions: [ 5, 10, 15 ],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                modalInfo: { title: '', content: '' },


                eqLisCanti:2,
                eqLis:2, 
                usuario_id:0,
                codigo_sot:'',
                dateToFilter:moment(),
                fecha1:'',
                listado:1,
                descripcion:'',
                idcategoria:0,
                cantidad:0,
                cantidadMaterial:0, 
                unidadMedida:{},
                fechaRegistro:new Date(),
                fechaLlegada:new Date(),
                codigo:0,
                nombre_categoria:0,
                descripcion:'',
                caracteristicas:'',
                stock:0,
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
                userSelet:[],
                newCantidad:[]=1,
                offset:3,
                criterio:'ctdetsa_serie',
                criterio1:'ctdetpr_serie',
                criterio2:'sap',
                criterioSW:'ctdetsa_sap',
                buscar:'',
                buscar1:'',
                buscarSW:'',
                buscarSerie:'',
                arrayCategoria:[],
                arraySalida:[],
                arraySalidaMaterial:[],
                newTasks:[],
                tasks:[],
                tasks1:[],
                arrayProducto:[],
                arraySAP:[],
                arrayProducto1:[],
                arrayMedida:[],
                arraySerie:[],
                arrayUsuario:[],
                arraySAPMate:[],
                arrayEquiEn:[],
                arrayListarSerie:[],
               arrayMaterialSap:[],
                agUni:'',
                errorIngreso:0,
                col:0,
                pro:1,
                CatePro01:'',
                cantidadProductos:'',
                fechaActualizacion:new Date(),
                respuesta01:'',
                mostrartodo:[],
                eqLis01:2,
                errorEncon:'',
                buscar05:'',
                dismissSecs: 10,
                dismissCountDown: 0,
                showDismissibleAlert: false,
                buscarSap02:'',
                ControlSer:true,
                // ConCanti:true,
                
                
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
                return this.buscarSap02 != '' ? false: true
            },
            ConCanti(){
                return this.cantidadProductos <1 ? true : false
            },
            sotState () {
            return this.codigo_sot.length > 2 ? true : false
            },
            cantiState () {
                // if(this.cantidadProductos >this.arraySAPMate[0].ctproduc_stock){
                //     return false
                // }else{
                //     return true
                // }
                for (let index = 0; index < this.arraySAPMate.length; index++) {
                   return this.cantidadProductos > this.arraySAPMate[0].ctproduc_stock ? false : true
                    
                }
            
            },
            
            clear(){

                if(this.buscar1!=''){
                    this.buscar1='';
                    this.arraySAPMate='';
                }
                else{
                    return  this.buscar1='';
                }  
            },
            clearSap(){

                if (this.buscarSap02!='') {
                    this.buscarSap02='';
                    this.ControlSer=true;
                    this.eqLis=2;
                    
                }
                else{
                    this.buscarSap02='';
                }
                
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
            //calcula los elementos de la paginacion
            
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
                showAlert () {
                this.dismissCountDown = this.dismissSecs
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
               
                let doc = new jsPDF('p', 'pt');
                let columns = [
                    // {title: "#", dataKey: "1"},
                    {title: "Tipo", dataKey: "tipodescri"},
                    {title: "Código Sap", dataKey: "prod01"},
                    {title: "Categoria", dataKey: "cate01"},
                    {title: "Producto", dataKey: "prodescri"},
                    {title: "Serie del Producto", dataKey: "prod01"},
                    {title: "Cantidad", dataKey: "cantidadProducto"},
                    {title: "unidad Medida", dataKey: "unidadDescripcion"},
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

                    }
                }
                
                );
                doc.save('teste.pdf');
            },
            info (item, index, button) {
         
                           

                let me=this;
                var url='/serie/Equi?buscar=' + this.buscarSap02;
               axios.get(url).then(function (response) {
                    // handle success;
                    // console.log(response);
                    var respuesta1=response.data;
                   me.arrayEquiEn=respuesta1.series;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });

                   this.respuesta = `Row index: ${index}`
            // this.modalInfo.content = item.age
            // this.$root.$emit('bv::show::modal', 'modalInfo', button)
                this.buscar05=item.Serie;
                // this.eqLis=2;

                      for (let index = 0; index < this.arrayEquiEn.length; index++) {
                    const element = this.arrayEquiEn[index].Serie;
                   
                        if (element ==this.buscar05 ) 
                        {   
                            if (this.buscarArticulo(this.arrayEquiEn[index].Serie)) 
                            {
                                    swal({
                                        type:'error',
                                        title:'Error...',
                                        text:'Ya se encuentra agregado',
                                })
                            }
                            else{
                                this.tasks.push({
                                    // sap:this.arrayEquiEn[index],

                                    detaTi:this.arrayEquiEn[index].ctdetpr_tipro_code,
                                    tipodescri:this.arrayEquiEn[index].cttipro_desc,
                                    cantidadProducto:1,
                                    unidadDescripcion:'Unidad',
                                    cate01:this.arrayEquiEn[index].ctcatego_desc,
                                    prodescri:this.arrayEquiEn[index].ctproduc_nombre,
                                    prod01:this.arrayEquiEn[index].Serie,
                                    conte: this.arrayEquiEn[index].sap,
                                    uni:this .arrayEquiEn[index].ctundmd_code,
                                    idProduct:this.arrayEquiEn[index].ctproduc_id,
                                    
                                });
                                this.arrayListarSerie=='';
                                this.buscar05='';
                             }
                        }
                        else{
                            if(this.buscar05!='')
                            {
                                 this.timer = setTimeout(() => {
                                     this.showDismissibleAlert=true;
                                   
                                 }, 800);

                            }     
                        }
                }

                
            },
             info01 (item, index, button) {
            this.respuesta = `Row index: ${index}`
                    
                    this.buscar1=item.SAP;
                     this.eqLis01=2;
                    this.timer = setTimeout(() => {
                        let me=this;
                        var url='/materialIngre?buscar=' + this.buscar1 ;
                        axios.get(url).then(function (response) {
                                // handle success;
                                // console.log(response);
                                var respuesta=response.data;
                            me.arraySAPMate=respuesta.ingresos.data;
                            //  console.log(me.arraySAPMate);
                            })
                            .catch(function (error) {
                                // handle error 
                                console.log(error);
                            });
                            
                       
                 }, 800);
                
            },
            listarMaterialB(buscar){
                let me=this;
                
                var url='/materialIngre?buscar=' + buscar ;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arraySAPMate=respuesta.ingresos;
                //    console.log(respuesta);
                
                
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
 
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
            showModal () {
            this.refs.myModalRef.show()
            },
            hideModal () {
            this.refs.myModalRef.hide()
            },
            customFormatter(data) {

                    this.fecha1= moment(data).format('LLL');
                    return this.fecha1;   
            },
            deleteTask:function(indice){
                this.tasks.splice(indice,1);
            },
            restantes(val){

               this.docHo= moment(this.fechaActualizacion).format('L');
               // this.diasHO= moment(this.docHo).diff(val, 'days');
               // this.horasHO= moment(this.docHo).diff(val, 'hours');
               return moment(this.docHo).diff(val, 'days');
           },

             mostrarDetalle(){
                let me=this;
                this.listado=0;
                this.listarSerieEquipo();
                me.nroDocumento='';
                me.codigo_sot='';
                me.serie='';
                me.comprobante_id='';
                me.nombre_producto='';
                me.cantidad=0;
                me.precioUnitario=0;
                me.fechaVencimiento='';
                me.tasks=[];
                 me.cantidadProductos=this.cantidadProducto;
            },
            ocultarDetalle(){
                 let me=this;
                 if (me.codigo_sot !==''
                 ||me.serie !== ''||me.cantidad !==0||me.buscar1!==''
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


                // this.listado=1;
                // me.nroDocumento='';
                // me.codigo_sot='';
                // me.serie='';
                // me.comprobante_id='';
                // me.nombre_producto='';
                // me.cantidad=0;
                // me.precioUnitario=0;
                // me.fechaVencimiento='';
                // me.tasks1=[];
            },
            selectUsuario(search,loading){
                let me=this;
                loading(true)

                var url= '/user/selectUsuario?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayUsuario=respuesta.usuarios;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProducto(val1){
                let me=this;
                me.loading=true;
                me.usuario_id=val1.ctusuar_code
            },
             listarProducto(){
                let me=this;
                var url='/producto' ;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayProducto1=respuesta.productos.data;
                //   console.log(response);
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            listarSerieEquipo(){
                let me=this;
                var url='/serie/equipo' ;
               axios.get(url).then(function (response) {
                //    console.log(response);
                    // handle success;
                    var respuesta=response.data;
                   me.arrayListarSerie=respuesta.salidas;
                
                 
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            buscarArticulo(id){
                var sw=0;
                for (var i = 0; i < this.tasks.length; i++) {
                    if (this.tasks[i].prod01==id) {
                        sw=true;
                    }
                    
                }
                return sw;

            },
            tipoDe(val){
                if (val==1) {
                    return 'Equipo';
                }else if(val==2){
                    return 'Material';
                }
                else{
                    return '';
                }  
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
             
             buscarInfo(){
                for (let index = 0; index < this.arrayEquiEn.length; index++) {
                    const element = this.arrayEquiEn[index].Serie;
                   
                        if (element ==this.buscar05 ) 
                        {   
                            if (this.buscarArticulo(this.arrayEquiEn[index].Serie)) 
                            {
                                    swal({
                                        type:'error',
                                        title:'Error...',
                                        text:'Ya se encuentra agregado',
                                })
                            }
                            else{
                                this.tasks.push({
                                    // sap:this.arrayEquiEn[index],

                                    detaTi:this.arrayEquiEn[index].ctdetpr_tipro_code,
                                    tipodescri:this.arrayEquiEn[index].cttipro_desc,
                                    cantidadProducto:1,
                                    unidadDescripcion:'Unidad',
                                    cate01:this.arrayEquiEn[index].ctcatego_desc,
                                    prodescri:this.arrayEquiEn[index].ctproduc_nombre,
                                    prod01:this.arrayEquiEn[index].Serie,
                                    conte: this.arrayEquiEn[index].sap,
                                    uni:this .arrayEquiEn[index].ctundmd_code,
                                    idProduct:this.arrayEquiEn[index].ctproduc_id,
                                    
                                });
                                this.arrayListarSerie=='';
                                this.buscar05='';
                             }
                        }
                        else{
                            if(this.buscar05!='')
                            {
                                 this.timer = setTimeout(() => {
                                     this.showDismissibleAlert=true;
                                   
                                 }, 800);

                            }     
                        }
                }

            },
            buscarSap(id){
                var sw=0;
                for (var i = 0; i < this.tasks1.length; i++) {
                    if (this.tasks1[i].prod01==id) {
                        sw=true;
                    }
                    
                }
                return sw;

            },
            listarProductoEncontrar(buscarSap02){
                  let me=this;
                var url='/serie/Equi?buscar=' + buscarSap02;
               axios.get(url).then(function (response) {
                    // handle success;
                    // console.log(response);
                    var respuesta1=response.data;
                   me.arrayEquiEn=respuesta1.series;
                 me.ControlSer=false;
                  
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },

             listarSAPMate(buscar1,criterio2){
                let me=this;
                var url='/salida/despacharMateriales?buscar1=' + buscar1 + '&criterio2=' + criterio2;
               axios.get(url).then(function (response) {
                    // handle success;
                    // console.log(response);
                    var respuesta1=response.data;
                   me.arraySAPMate=respuesta1.series.data;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },

            agregra(){
                    this.timer = setTimeout(() => {
                        if (this.buscar1==this.arraySAPMate[0].sap ) {
                                 
                                if (this.cantidadProductos >=1) {
                                    if (this.cantidadProductos<=this.arraySAPMate[0].ctproduc_stock){
                                    
                                            this.tasks.push({
                                                cate01:this.arraySAPMate[0].ctcatego_desc,
                                                prodescri:this.arraySAPMate[0].ctproduc_nombre,

                                                // // CATEGORIA ID Y NOMBRE
                                                // categoriaDescripcion:this.arraySAPMate[0].ctcatego_desc,
                                                // categoriaID:this.arraySAPMate[0].ctcatego_id,
                                                // // PRODUCTO ID Y NOMBRE
                                                productoDescripcion:this.arraySAPMate[0].ctproduc_nombre,
                                                productoID:this.arraySAPMate[0].ctproduc_id,
                                                // // UNIDAD DE MEDIDA ID Y NOMBRE
                                                unidadDescripcion:this.arraySAPMate[0].ctundmd_desc,
                                                UnidadID:this.arraySAPMate[0].ctproduc_undMed,
                                                // // SAP DEL PRODUCTO
                                                prod01:'Ninguno',
                                                sapProducto:this.arraySAPMate[0].sap,
                                                // // STOCK DEL PRODUCTO
                                                // stockProducto:this.arraySAPMate[0].ctproduc_stock,
                                                // //TIPO DE PRODUCTO
                                                detaTi:this.arraySAPMate[0].ctproduc_tipro_code,
                                                tipodescri:this.arraySAPMate[0].cttipro_desc,
                                                
                                                // // CANTIDAD DE PRODUCTO QUE SALDRA DE ALMACEN
                                                cantidadProducto:this.cantidadProductos,
                                                // restar02:(this.arraySAPMate[0].ctproduc_stock)-(this.cantidadProductos)
    
                                        });
                                        this.buscar1='';
                                        this.cantidadProductos='';
                                        this.arraySAPMate='';
                                    }
                                    else{
                                       return this.cantidadProductos='';
                                    }
                                }
                           }  
                              //agregar validacion
                    }, 0);
                       
            },
             deleteTask1:function(indice){
                this.tasks1.splice(indice,1);
            },
             selectCategoria(){
                 let me=this;
                 var url='/categoria/selectCategoria';
               axios.get(url).then(function (response) {
                    // handle success;
                    //  console.log(response);
                   var respuesta=response.data;
                   me.arrayCategoria=respuesta.categorias;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            listarSalida(page,buscar,criterio){
                let me=this;
                var url='/salida/equipo?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arraySalida=respuesta.salidas.data;
                   me.pagination=respuesta.pagination;
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
                me.listarSalida(page,buscar,criterio);
            },
            listarSalidaMaterial(page,buscarSW,criterioSW){
                let me=this;
                var url='/salida/material?page=' + page + '&buscar='+ buscarSW + '&criterio=' + criterioSW;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arraySalidaMaterial=respuesta.salidas.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            cambiarPaginaMaterial(page1,buscarSW,criterioSW){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page1;
                //envia la peticion para visualizar la data de esa pagina
                me.listarSalidaMaterial(page1,buscarSW,criterioSW);
            },
            registrarSalida(){
                if (
                    this.codigo_sot=='') {

                    }else{
                let me=this;
                axios.post('/salida/registrar',{
                    'sot':this.codigo_sot,
                    'fechaLlegada':moment(this.fechaLlegada).format('YYYY-MM-DD hh:mm:ss'),
                    'usuario_id':this.usuario_id,
                    'data':this.tasks,
                    'data1':this.tasks1,
                    // 'prueba':this.cantidadProductos
                }).then(function (response) {
                   
                   
                   me.listarSalida(1,'','ctdetsa_serie');
                   me.listarSalidaMaterial(1,'','ctdetsa_serie');
                   me.tasks=[];
                   me.codigo_sot='';
                   me.label=null;
                    
                // console.log(response);
                })
                .catch(function (error) {
                    console.log(err);
                });
                }

            },
           
           
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idcategoria=0;
                this.descripcion='';
                this.codigo=0;
                this.caracteristicas='';
                this.stock=0;
                this.errorProducto=0;

            },
              cerrarModal1(){
                this.modal=0;
                this.tituloModal='';
                // this.tasks=[];
                // this.newTasks=[];
                this.errorProducto=0;
                

            },
         
            
        },
        mounted() {
            // this.listarProductoEncontrar(this.buscarSap02);
            this.listarMaterialSap(1,this.buscar,this.criterio);
            this.listarSalida(1,this.buscar,this.criterio);
            this.listarSalidaMaterial(1,this.buscarSW,this.criterioSW);
        },
        
    }
</script>
<style>
    .equiS{
        font-weight:bold;
        color: green;
    }
    .MateS{
        font-weight:bold;
        color: orange;
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
    .retroCanti{
        background: #cecdcc;
        color: black;
    }
     .card-header .nav.nav-tabs .nav-link, .card-header .nav.nav-tabs .navbar .dropdown-toggle {
        color: #f0f3f5;
    }
     .sim02{
        margin: 0;
        padding: 0;
    }
    .dispaly05{
        position: absolute;
        top:1px;
       right: 1px;

    }
   .gres01{
       background: #fbe7ac!important;
   }
   .reds01{
       font-size: 35px!important;
   }


</style>
