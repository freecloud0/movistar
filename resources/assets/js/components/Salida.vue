

<template>
        <main class="main">
            <!-- Breadcrumb -->
            <audio id="xyz" preload="auto"  src="audio/error.mp3" type="audio/mpeg" > </audio>
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
                                            <input type="text" v-model="buscar"  @keyup="listarSalida(buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscar == ''" @click="listarSalida(buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                  
                                            <div class="border p-2 mt-4">
                                                <h6>Total Equipos : {{contaTotalPr}}</h6>
                                            </div>
                                            
                                        
                                    </div>
                                    <div class="col-md">
                                           <button @click="pdfExportEquipo()" type="submit" class=" float-right psoFs btn red">
                                                pdf<i class=" ml-2 fas fa-box-open"></i>
                                           </button>
                                           <button @click="excelExportEquipo()"  type="submit" class=" float-right psoFs btn green">
                                                excel<i class=" ml-2 fas fa-box-open"></i>
                                           </button>
                                   </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="blue white-text text-center">
                                            <tr>
                                                
                                                <th>N°</th>
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
                                            <tr v-for="(salida,indice) in (arraySalida)" :key="salida.id" >
                                                
                                                <!-- <td v-text="salida.ctdetsa_salid_nro"></td> -->
                                                <td>{{indice+1}}</td>
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
                                            <input type="text" v-model="buscarSW"  @keyup="listarSalidaMaterial(buscarSW,criterioSW)" class="form-control" placeholder="Texto a buscar">
                                        <div class="input-group-append">
                                             <button type="submit" :disabled="buscarSW == ''" @click="listarSalidaMaterial(buscarSW,criterioSW)" class="btn green float-right mt-2 btn-sm">
                                                 Busqueda<i class="ml-2 fa fa-search"></i> 
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                  
                                            <div class="border p-2 mt-4">
                                                <h6>Total Materiales : {{contaTotalPrMate}}</h6>
                                            </div>
                                        
                                    </div>
                                     <div class="col-md">
                                           <button @click="pdfExportMaterial()" type="submit" class=" float-right psoFs btn red">
                                                pdf<i class=" ml-2 fas fa-dolly-flatbed"></i>
                                           </button>
                                           <button @click="excelExportMaterial()" type="submit" class=" float-right psoFs btn green">
                                                excel<i class=" ml-2 fas fa-dolly-flatbed"></i>
                                           </button>
                                   </div>
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
                                                <th>Usuarios</th>
                                                
                                            
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
                                                <!-- <td >
                                                     <b-btn type="button" class="btn btn-danger btn-sm" @click="desactivarEquipo(salida.ctdetsa_indice)">
                                                        Liquidar
                                                     </b-btn>
                                                </td> -->
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
                                <label for="">Fecha de Llegada</label>
                                <datepicker v-model="fechaLlegada" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>

                            </div>
                        </div>     
                        <!-- clase 4 si sirve -->
                            <hr class="my-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button :disabled="arrayUsuario.length < 1"  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                       
                                    </div>
                                </div>  
                            <hr class="my-1">

                                <!-- Modal -->
                            <div data-backdrop="static" data-keyboard="false" class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <b-tabs pills card >
                                            <b-tab title="Equipo" active>
                                                    
                                                <div class="row">
                                                    
                                                    <div class="col-12">
                                                
                                                        <b-card bg-variant="white"
                                                                text-variant="black"
                                                                header-bg-variant="primary"
                                                                border-variant="primary"
                                                                header="Número de Serie"
                                                                class="text-right">

                                                            <br>
                                                            <input type="text" v-model="buscar05"  @keyup="buscarInfo()" class="form-control " >

                                                            <!-- <span class="b-01" style="position:absolute ; left:20px; top:60px;">{{equipoName}}</span> -->
                                                            <!-- <input type="text"  v-model="buscar05"  @keyup="buscarInfo()" class="form-control " >  -->
                                                        </b-card>

                                                    </div>
                                                </div>

                                                <hr class="my-1">
                                                        
                                                <!-- <b-row>
                                                <b-col md="8" class="my-1">
                                                    
                                                    <label for="">Busqueda</label>
                                                    <b-input-group>
                                                        <b-form-input v-model="filter" placeholder="buscar..." />
                                                        <b-input-group-append>
                                                        
                                                        </b-input-group-append>
                                                    </b-input-group>
                                                    
                                                </b-col>
                                                        
                                                    <b-col md="4" class="my-1">
                                                            <label for="">Paginación</label>
                                                        <b-form-select :options="pageOptions1" v-model="perPage1" />
                                            
                                                    </b-col>
                                                </b-row>
                                                    <div class="table-responsive">
                                                            <br>
                                                           
                                                            <b-table show-empty
                                                                    stacked="md"
                                                                    :items="(listarEquipoSerie)"
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
                                                               
                                                                <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)"  class="mr-1">
                                                                Agregar
                                                                </b-button>
                                                            </template>
                                                            
                                                            </b-table>
                                                            
                                                            <b-row>
                                                            <b-col md="6" class="my-1">
                                                                <b-pagination :total-rows="this.listarEquipoSerie.length" :per-page="perPage1" v-model="currentPage1" class="my-0" />
                                                            </b-col>
                                                            </b-row>
                                                            
         
                                                    </div> -->
                                            
                                                   
                                            </b-tab>
                                            <b-tab title="Materiales">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row sm-0 sp-0">
                                                            <div class="col-md-4 sm-0 sp-0 mb-4">
                                                                <!-- <div class="bgMa">
                                                                    <div class="flex-center  ">
                                                                        <span class="white-text b-01 text-center">{{materialName}}</span>
                                                                    </div>
                                                                </div> -->
                                                                <div class="view">
                                                                    <div class="bgMa" style=" background-image: url(../img/constru.jpg);"></div>
                                                                    <div class="mask rgba-stylish-strong  flex-center p-2">
                                                                            <span class="white-text b-01 text-center">{{materialName}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 sm-0 sp-0">
                                                            <div class="row pl-d">
                                                            
                                                                <div class="col-10">
                                                                    
                                                                    <label for="">SAP</label>
                                                                    
                                                                    <input v-b-tooltip.hover title="Presione ''ENTER''' para la búsqueda " type="text" v-model="buscar1" v-on:keyup.enter="listarMaterialB(buscar1,criterio2)" @keyup.enter="eqLisCanti=1"  class="form-control" placeholder="Texto a buscar">
                                                                    
                                                                </div>
                                                                
                                                                    <div class="col-2">
                                                                        <button  class="psoF btn green btn-sm " @click="listarMaterialB(buscar1,criterio2)">
                                                                            <i  class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                             </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-8">
                                                                            <label for="">Can.</label>
                                                                            <tr class="text-center" 
                                                                                style="font-weight:bolder ; top: 0px; right: 34px; position: absolute;" 
                                                                                v-for="ingreso in arraySAPMate" 
                                                                                :key="ingreso.pro" > 

                                                                                <!-- <div v-if="stockMaterial"> -->
                                                                                 <label class="green-text" v-text="stockMaterial" ></label> 
                                                                                 <label  v-text="ingreso.ctundmd_desc" ></label>   
                                                                                <!-- </div>
                                                                                <div v-else>
                                                                                <label class="green-text" v-text="ingreso.ctproduc_stock" ></label>
                                                                                <label  v-text="ingreso.ctundmd_desc" ></label>    
                                                                                </div> -->
                                                                               
                                                                                          
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
                                                                        
                                                                            <br>
                                                                               <button @click="agregra()"  :disabled="buscar1 == ''||this.arraySAPMate ==''||ConCanti" v-on:click="eqLisCanti=2" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                                    <i  class="fas fa-dolly"></i>
                                                                                </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    

                                                    <div class="col-md-12">
                                                        <div >
                                                            <br>
                                                        <hr class="my-1">
                                                        
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
                                                                         <b-button size="sm" @click.stop="info01(row.item, row.index, $event.target)"  class="mr-1">
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
                                        
                                    </div>
                                   
                                    </div>
                                </div>
                                </div>

           
                       
                            <div class="row">
                                <div class="col-md-4">
                                  
                                        <div class="border p-2 mt-4">
                                            <h6>Total Equipos : {{contaTotal}}</h6>
                                        </div>
                                    
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
                                            <tr v-for=" (task,indice) in (tasks) " :key="task.descripcion" >
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
                messageUser: '',
                contaTotal:0,
                contaTotalPr:0,
                numcota:1,
                contaTotalPrMate:0,
                incrementar:'',
                listarEquipo:[],
                materialName:'Nombre de material',
                equipoName:'',
                listarEquipoSerie:[],
                stockMaterial:'',
                cantidad:'',
                suma:[],
                sumaTotal:0,
                usuarioName:'',
                tret:0,
                url:'http://www.eliniktech.com/'

                
                
                
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
                for (let index = 0; index < this.arraySAPMate.length; index++) {
                    if (this.arraySAPMate[0].ctproduc_stock>=this.cantidadProductos && this.cantidadProductos >0) {
                        this.stockMaterial=this.arraySAPMate[0].ctproduc_stock - this.cantidadProductos;
                        return
                    }else{
                         this.cantidadProductos ='';
                         this.stockMaterial=this.arraySAPMate[0].ctproduc_stock;
                         
                    }
                    
                }
            
            },
            clearSap:function(){

                if (this.buscarSap02!='') {
                    this.buscarSap02='';
                    this.ControlSer=true;
                    this.arrayEquiEn=[];
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

            incrementarGuia(){
                let me=this;
               var url='/incrementar-guia' ;
              axios.get(url).then(function (response) {
                   var respuesta=response.data;
                  me.incrementar=respuesta.numero;
               })
               .catch(function (error) {
                   console.log(error);
               });
            },
           exportPdf(){ 
                
                
                let vm = this;
                
        
                let userTo = vm.usuarioName;
                let contaArr = 1
                let imgData = 'data:image/png;base64,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'
                // let nomTec = vm.
                let guia= vm.incrementar;
                let fechaImp = moment(this.fechaRegistro).format('DD-MM-YYYY');
                let doc = new jsPDF('p', 'pt');
                let columns = [
                    // {title: "#", dataKey: "1"},
                    {title: "POSI", dataKey: "conta"},
                    
                    {title: "CÓDIGO", dataKey: "sapPdf"},
                    {title: "DESCRIPCIÓN", dataKey: "cate01"},
                    {title: "SERIE", dataKey: "descriPdf"}, 
                    // {title: "Categoria", dataKey: "cate01"},
                    // {title: "Producto", dataKey: "prodescri"},
                    
                    {title: "CANTIDAD", dataKey: "cantidadProducto"},
                    {title: "UDN", dataKey: "unidadDescripcion"},
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
                    margin: {top: 170},
                    
                    addPageContent: function(data) {

                        // rectangulo
                        doc.setDrawColor(0);
                        doc.setFillColor(255, 255, 255);
                        doc.roundedRect(410, 35, 140, 55, 3, 3, 'FD'); 

                      

                        // rectangulo FECHA(0,0,ANCHO, ALTURA)
                        doc.setDrawColor(0);
                        doc.setFillColor(255, 255, 255);
                        doc.roundedRect(370, 140, 184, 21, 3, 3, 'FD'); 

                       
                        // nombre tecnico
                        doc.setFontSize(11)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.text("Usuario técnico : "+userTo +"", 45, 155);

                        // fecha
                        doc.setFontSize(11)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.text("FECHA DE EMISIÓN : "+fechaImp +"", 375, 155);
                        // doc.text(fechaImp, 380, 50);
                       
                        // imagen[ 0,0, ancho, alto]
                        doc.addImage(imgData, 'JPEG', 45, 25, 355,80)

                        // ruc
                        doc.setFontSize(12)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.text("R.U.C. : 20600313844", 420, 50);

                        doc.setFontSize(13)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.text("GUIA DE REMISIÓN", 420, 65);
                        // guia
                        doc.text("0001 - "+guia, 420, 85);
                    }
                }
                
                );

                
                doc.save('ELINIKTECH-SALIDA.pdf');
            },
            listarSerie(){
                let me=this;
                var url='/todas-series'
               axios.get(url).then(function (response) {
                    var respuesta1=response.data;
                    me.arrayEquiEn=respuesta1.series;
                    me.listarEquipoSerie=respuesta1.series;
                   
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            info (item, index, button) {
         
                           
                    this.listarSerie();

                   this.respuesta = `Row index: ${index}`
            // this.modalInfo.content = item.age
            // this.$root.$emit('bv::show::modal', 'modalInfo', button)
                this.buscar05=item.Serie;
                // this.eqLis=2;

                      for (let index = 0; index < this.arrayEquiEn.length; index++) {
                    const element = this.arrayEquiEn[index].Serie;
                   const estado =this.arrayEquiEn[index].ctdetpr_esta_code;
                        if (element ==this.buscar05 ) 
                        {   
                          if (estado==1) {
                            if (this.buscarArticulo(this.arrayEquiEn[index].Serie)) 
                            {
                                 document.getElementById('xyz').play(); 
                                    swal({
                                        type:'error',
                                        title:'Error...',
                                        text:'Ya se encuentra agregado',
                                })
                            }
                            else{
                                this.tasks.push({
                                    // sap:this.arrayEquiEn[index],
                                    conta: this.numcota++,
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

                                    sapPdf: this.arrayEquiEn[index].sap,
                                    descriPdf:this.arrayEquiEn[index].Serie,
                                    // concatenacion
                                   
                                    
                                    
                                });
                                this.contaTotal= this.tasks.length
                                this.arrayListarSerie=='';
                                this.buscar05='';
                                this.materialName='Nombre de material';
                                this.arrayEquiEn;
                             }
                             }else{
                                  document.getElementById('xyz').play(); 
                                 swal({
                                     
                                        type:'error',
                                        title:'Error...',
                                        text:'Ya se encuentra despachado',
                                })
                                this.buscar05='';
                            }
                          } else{
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
                    this.cantidadProductos='';
                    this.arraySAPMate.length=0;
                    this.materialName='Nombre de material';
                
            },
            listarMaterialB(buscar){
                let me=this;
                
                var url='/materialIngre?buscar=' + buscar ;
               axios.get(url).then(function (response) {
                   
                    var respuesta=response.data;
                   me.arraySAPMate=respuesta.ingresos;
                   console.log(me.arraySAPMate);
                   if (me.arraySAPMate.length < 1) {
                       me.materialName = 'Material no encontrado';
                   } else {
                       me.materialName=me.arraySAPMate[0].ctproduc_nombre;
                   }
                })
                .catch(function (error) {
                    console.log(error);
                });
 
            },
            resetModal () {
            this.modalInfo.title = ''
            this.modalInfo.content = ''
            },
            onFiltered (filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
            },
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
                me.usuarioName=val1.ctusuar_usuario
            },
             listarProducto(){
                let me=this;
                var url='/producto' ;
               axios.get(url).then(function (response) {
                    var respuesta=response.data;
                   me.arrayProducto1=respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarSerieEquipo(){
                let me=this;
                var url='/serie/equipo' ;
               axios.get(url).then(function (response) {
                    var respuesta=response.data;
                   me.arrayListarSerie=respuesta.salidas;
                
                 
                })
                .catch(function (error) {
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
                    var respuesta=response.data;
                   me.arrayMaterialSap=respuesta.ingresos;
                })
                .catch(function (error) {
                    console.log(error);
                });
               
            },
             
             buscarInfo(){
                //  console.log(this.arrayEquiEn);
                for (let index = 0; index < this.arrayEquiEn.length; index++) {
                    const element = this.arrayEquiEn[index].Serie;
                    const estado =this.arrayEquiEn[index].ctdetpr_esta_code;
                    
                  
                        if (this.buscar05 == element) 
                            {   
                                // console.log(element);
                                
                                if (estado==1) {
                                    if (this.buscarArticulo(this.arrayEquiEn[index].Serie)) 
                                {
                                     document.getElementById('xyz').play(); 
                                        swal({
                                            type:'error',
                                            title:'Error...',
                                            text:'Ya se encuentra agregado',
                                    })
                                    this.buscar05='';
                                }
                                else{
                                    this.tasks.push({
                                        conta: this.numcota++,
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
                                        // concatenacion
                                    
                                        sapPdf: this.arrayEquiEn[index].sap,
                                        descriPdf:this.arrayEquiEn[index].Serie,
                                    });
                                    // contador
                                    this.contaTotal= this.tasks.length

                                    this.arrayListarSerie=='';
                                    this.buscar05='';
                                
                                }
                                }else{
                                    document.getElementById('xyz').play(); 
                                    swal({
                                            type:'error',
                                            title:'Error...',
                                            text:'Ya se encuentra despachado',
                                    })
                                    this.buscar05='';
                                }
                                
                            }
                        
                        
                        else{
                            if(this.buscar05!='')
                            {
                                //  this.timer = setTimeout(() => {
                                //      this.showDismissibleAlert=true;
                                   
                                //  }, 800);

                            }
                            this.timer = setTimeout(() => {
                                if(this.buscar05 != element && this.buscar05!='' ){
                                    this.buscar05='';
                                    document.getElementById('xyz').play(); 
                                   swal({
                                        type:'error',
                                        title:'Error...',
                                        text:'Producto no encontrado',
                                })
                                    
                                }
                            }, 800)     
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
            listarProductoEncontrar(){
                let me=this;
                var url='/serie/Equi';
               axios.get(url).then(function (response) {
                   
                    var respuesta1=response.data;
                   me.arrayEquiEn=respuesta1.series;
                //    console.log(me.arrayEquiEn);
                //    if (me.arrayEquiEn.length<1) {
                //        me.equipoName='';
                //    } else {
                //        me.equipoName=me.arrayEquiEn[0].ctproduc_nombre;
                //    }
                    
                 me.ControlSer=false;
                //  me.buscarInfo();
                 me.buscar05=''; 
                 me.materialName='Nombre de material'; 
                })
                .catch(function (error) {
                    console.log(error);
                 
                });
            },

             listarSAPMate(buscar1,criterio2){
                let me=this;
                var url='/salida/despacharMateriales?buscar1=' + buscar1 + '&criterio2=' + criterio2;
               axios.get(url).then(function (response) {
                    var respuesta1=response.data;
                   me.arraySAPMate=respuesta1.series.data;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
            pushMaterial(){
                for (let index = 0; index < this.arraySAPMate.length; index++) {
                       const element = this.arraySAPMate[index];


                       if (this.cantidadProductos<=this.arraySAPMate[index].ctproduc_stock){

                           this.tasks.push({
                               cate01:this.arraySAPMate[index].ctcatego_desc,
                               prodescri:this.arraySAPMate[index].ctproduc_nombre,
                               conta: this.numcota++,
                               // // CATEGORIA ID Y NOMBRE
                               // categoriaDescripcion:this.arraySAPMate[0].ctcatego_desc,
                               // categoriaID:this.arraySAPMate[0].ctcatego_id,
                               // // PRODUCTO ID Y NOMBRE
                               productoDescripcion:this.arraySAPMate[index].ctproduc_nombre,
                               productoID:this.arraySAPMate[index].ctproduc_id,
                               // // UNIDAD DE MEDIDA ID Y NOMBRE
                               unidadDescripcion:this.arraySAPMate[index].ctundmd_desc,
                               UnidadID:this.arraySAPMate[index].ctproduc_undMed,
                               // concatenacion
                               concaCaDes:(this.arraySAPMate[index].ctcatego_desc)+" | "+(this.arraySAPMate[index].ctproduc_nombre),
                               // // SAP DEL PRODUCTO
                                descriPdf:"ninguno",
                                sapPdf:this.arraySAPMate[index].sap,
                               prod01:this.arraySAPMate[index].sap,
                               sapProducto:this.arraySAPMate[index].sap,
                               // // STOCK DEL PRODUCTO
                               // stockProducto:this.arraySAPMate[0].ctproduc_stock,
                               // //TIPO DE PRODUCTO
                               detaTi:this.arraySAPMate[index].ctproduc_tipro_code,
                               tipodescri:this.arraySAPMate[index].cttipro_desc,

                               // // CANTIDAD DE PRODUCTO QUE SALDRA DE ALMACEN
                               cantidadProducto:this.cantidadProductos,
                               // restar02:(this.arraySAPMate[0].ctproduc_stock)-(this.cantidadProductos)
                                
                           });
                           this.buscar1='';
                           this.cantidadProductos='';
                           this.arraySAPMate='';
                       }
                       else{
                           document.getElementById('xyz').play(); 
                           swal({
                           type:'error',
                           title:'Error...',
                           text:'Cantidad de productos no suficientes',
                           })
                           return this.cantidadProductos='';
                       }
                   }
            },

            agregra(){
                     if (this.stockMate==''||this.stockMate <=0) {
                    
                }
                if (this.tasks.length<1) {
                    var stockMaterial=parseInt(this.arraySAPMate[0].ctproduc_stock) ;
                    var stock=parseInt(this.stockMate)+stockMaterial;
                
                    if (stock>stockMaterial) {
                        document.getElementById('xyz').play(); 
                        swal(`Intenta sobrepasar el limite de stock ${stockMaterial} por ${stock}`)
                        
                 }else{
                     this.pushMaterial();
                 }
                  
                }else{
                    for (let i = 0; i < this.tasks.length; i++) {
                        
                        if (this.tasks[i].prod01==this.buscar1) {
                             this.cantidad=parseInt(this.tasks[i].cantidadProducto)
                             this.sumaTotal+=this.cantidad
                             
                        }
                    }
                  var stockMaterial=parseInt(this.arraySAPMate[0].ctproduc_stock) ;
                  
                  var stock=parseInt(this.cantidadProductos)+parseInt(this.sumaTotal) ;
                 
                   this.sumaTotal=0 
                    if (stock>stockMaterial) {
                        document.getElementById('xyz').play(); 
                        swal(`Intenta sobrepasar el limite de stock ${stockMaterial} por ${stock}`)
                        // console.log(parseInt(this.cantidad),this.sumaTotal);
                 }else{
                        this.pushMaterial();
                        this.sumaTotal=0
                    }
                 }   
                /////////////////////////////////////////////////////////////////////////////////
                   
           },
             deleteTask1:function(indice){
                this.tasks1.splice(indice,1);
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
            listarSalida(buscar,criterio){
                let me=this;
                var url='/salida/equipo?buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arraySalida=respuesta.salidas;
                   me.contaTotalPr= me.arraySalida.length
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
           
           
         
            listarSalidaMaterial(buscarSW,criterioSW){
                let me=this;
                var url='/salida/material?buscar='+ buscarSW + '&criterio=' + criterioSW;
               axios.get(url).then(function (response) {
                    // handle success;
                    
                    var respuesta=response.data;
                   me.arraySalidaMaterial=respuesta.salidas;
                   me.contaTotalPrMate= me.arraySalidaMaterial.length
                  
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
          
            contarProducto(i) {
                 for (let i = 0; i <= this.tasks.length; i++) {
                        let element = this.tasks[i].length;
                        // console.log(element);
                    }
            },
            metodoRegistrarSalida() {
                 let me=this;
                 axios.post('/salida/registrar',{
                    // 'sot':this.codigo_sot,
                    'fechaLlegada':moment(this.fechaLlegada).format('YYYY-MM-DD hh:mm:ss'),
                    'usuario_id':this.usuario_id,
                    'data':this.tasks,
                    'incrementar':this.incrementar,
                    // 'prueba':this.cantidadProductos
                }).then(function (response) {
                    
                   me.listarSalida('','ctdetsa_serie');
                   me.listarSalidaMaterial('','ctdetsa_serie');
                //    me.tasks=[];
                   me.codigo_sot='';
                   me.label=null;
                   me.messageUser=me.arrayUsuario[0].ctusuar_usuario;
                   let cantidad =me.tasks.length;
                     toast({
                        type: 'success',
                        title: `Añadido ${cantidad} productos en almacén de ${me.usuarioName}`
                    })
                    me.contaTotal=0;
                    me.tasks=[];
                    me.incrementarGuia();
                    me.listarSerie();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarSalida(){
                let me=this;
                swal({
                    title: '¿Desea guardar este registro?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    }).then((result) => {
                    if (result.value==true) {
                        swal({
                            title: '<strong>¿Desea imprimir el registro?</strong>',
                            type: 'info',
                           
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText:
                                'Imprimir/Guardar',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                            cancelButtonText:
                                'Guardar',
                            cancelButtonAriaLabel: 'Thumbs down',
                            }).then((result) => {
                            if (result.value==true) {
                                //  console.log(result.value);
                                me.exportPdf()
                                me.numcota=1;
                                me.metodoRegistrarSalida();
                            } else if(result.dismiss=='cancel') {
                                me.metodoRegistrarSalida();
                                // console.log('cancelado');
                            } else {
                                console.log(result);
                            }
                            })
                           
                          
                    } else {
                        console.log(result);
                    }
                     
                          
                    })
               
                

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
          // Exportar En archivo excel metodo
            pdfExportEquipo(){
                 Swal({
                        title: '¿Desea imprimir?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        text:'Esto puede tardar'
                        }).then((result) => {
                        if (result.value) {
                        window.open(url+'pdf-salidas');
                        }
                    });
               
              
            },
            // Exportar En archivo excel metodo
            excelExportEquipo(){
                 Swal({
                        title: '¿Desea imprimir?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        text:'Esto puede tardar'
                        }).then((result) => {
                        if (result.value) {
                        window.open(url+'excel-salidas');
                        }
                    });
               
              
            },
            // Exportar En archivo excel metodo
            pdfExportMaterial(){
                 Swal({
                        title: '¿Desea imprimir?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        text:'Esto puede tardar'
                        }).then((result) => {
                        if (result.value) {
                        window.open(url+'pdf-salidasM');
                        }
                    });
               
              
            },
            // Exportar En archivo excel metodo
            excelExportMaterial(){
                 Swal({
                        title: '¿Desea imprimir?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        text:'Esto puede tardar'
                        }).then((result) => {
                        if (result.value) {
                        window.open(url+'excel-salidasM');
                        }
                    });
               
              
            },
            
        },
        mounted() {
            // this.listarProductoEncontrar(this.buscarSap02);
            this.listarProductoEncontrar();
            this.listarMaterialSap(1,this.buscar,this.criterio);
            this.listarSalida(this.buscar,this.criterio);
            this.listarSalidaMaterial(this.buscarSW,this.criterioSW);
            this.incrementarGuia();
            this.listarSerie();
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
   .sm-0{
      margin: 0!important;
  }
  .sp-0{
      padding: 0!important;
  }
  .b-01{
      font-weight: bold;
  }
 .bgMa{
      /* background: #5e6d79!important;
      height:100%; */
      width: 100%;
        height: 140px;
        background-size: cover!important;
        background-repeat: no-repeat!important;
        background-position: center center!important;
        padding-bottom: 0px;
  }
  .psoF{
      position: absolute;
      top: 25px;
      left: -20px;
      padding: 10px!important;
  }
  .pl-d{
      padding-left: 15px;
  }
  .filesx{
  width: 100%;
  margin-top: 0.25rem;
  font-size: 80%;
  color: #dc3545;
}
.brd{
  border: 1px solid #dc3545!important;
}
.werd{
  border: 1px solid #28a745!important;
}

.brd:focus{
  box-shadow: 0 0 0 0.2rem rgba(146, 15, 15, 0.25)!important;
}
.werd:focus{
  box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25)!important;
}


</style>
