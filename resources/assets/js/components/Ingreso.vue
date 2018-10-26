
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
                        <i class="fa fa-align-justify"></i> Ingresos
                        
                        
                        <template v-if="listado">
                            <button type="button" @click="mostrarDetalle()" class="btn orange float-right  btn-sm"  >
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
                        <div class="row">
                            
                            <div class="col-md-3">
                                    <select class="form-control mt-2" v-model="criterio">
                                        <option value="ctdetgu_fecha_act">Fecha</option>
                                        <option value="ctdetgu_nro">Nro de Guia</option>
                                        <option value="ctdetgu_serie">Nro de serie(Guia)</option>
                                        <option value="ctdetgu_serieProduc">Serie del producto </option>
                                    </select>
                            </div>
                            <div class="col-md-5">
                                <div class="md-form input-group mt-0 mb-3">
                                 <input type="text" v-model="buscar" @keyup="listarEntrada(buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <div class="input-group-append">
                                   <button type="button" :disabled="buscar == ''"  @click="listarEntrada(buscar,criterio)" class="btn green float-right mt-2 btn-sm"  >
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
                        </div>

                            <br>
                            
                         <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="blue white-text text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Nro de Guia</th>
                                    <th>Serie Guia</th>
                                    <th>Cod. SAP</th>
                                    <th>Código del producto</th>
                                    <th>Cantidad</th>
                                    <th>Unidad de Medida</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>
                              
                                <tr v-for="(entrada,index) in (arrayEntrada)" :key="entrada.idProducto"  >
                                    <td>{{index+1}}</td>
                                     <td v-text="entrada.ctdetgu_nro" ></td>
                                     <td v-text="entrada.ctdetgu_serie"></td>
                                     <td v-text="entrada.ctdetgu_desc"></td> 
                                     <td v-text="entrada.ctdetgu_serieProduc"></td> 
                                     <td v-text="entrada.ctdetgu_cantidad"></td>
                                     <td v-text="entrada.ctundmd_desc"></td>
                                     <td v-text="entrada.ctdetgu_fecha_reg"></td>
                                     <td v-text="entrada.ctdetgu_usuario"></td>
                                </tr>
                            </tbody>
                        </table>
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
                                                <label for="">Serie Comprobante
                                                  
                                                </label>
                                               
                                                <b-form-input   id="inputLive1"
                                                                v-model.trim="serie"
                                                                type="number"
                                                                :@keyup="correEs()"
                                                                
                                                                :state="serieState"
                                                                placeholder="">
                                                </b-form-input>
                                               

                                                <b-form-invalid-feedback v-show="serie==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>
                                                <b-form-invalid-feedback v-show="mesaFal == 1" id="inputLiveFeedback4">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Serie ya Registrada
                                                </b-form-invalid-feedback>

                                                <b-form-invalid-feedback v-show="serie.length>4 " id="inputLiveFeedback1">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                No exeder de 4
                                                </b-form-invalid-feedback>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">N° de Comprobante
                                                    <!-- <span style="color:red;"  v-show="nroComprobante==''">(*)</span> -->
                                                </label>
                                             
                                                <b-form-input   id="inputLive"
                                                                v-model.trim="nroComprobante"
                                                                type="number"
                                                                :@keyup="NumCom()"
                                                                :state="nComState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="nroComprobante==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>
                                                <b-form-invalid-feedback v-show="mesaFalNu == 1" id="inputLiveFeedback4">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Comprobante ya Registrada
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

                                        <button id="boton" class=" btn green btn-sm " @click="abrirCategoria">Agregar Categoria</button>
                                        <button id="boton1" class=" btn red btn-sm " @click="cerrarCategoria">Cerrar Categoria</button>
                                        <button id="boton2" class=" btn green btn-sm " @click="abrirEquipo">Agregar Equipo</button>
                                        <button id="boton3" class=" btn red btn-sm " @click="cerrarEquipo">Cerrar Equipo</button>
                                    
                                        <button v-b-tooltip.hover title="Agregar Equipos a Lista" :disabled="nroComprobante == ''||serie==''||NumCom()||serie.length>4 "  type="button" class="btn orange btn-sm float-right" data-toggle="modal" data-target="#basicExampleModal">
                                            <i class="icon-plus"></i>&nbsp; Ingresar
                                        </button>
                                    </div>
                                </div>       
                                    <!-- Modal -->
                                    <div data-backdrop="static" data-keyboard="false" class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <button v-b-tooltip.hover title="Buscar Código" type="button" class=" btn-transparent dropdown-toggle orange-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                                            <button v-b-tooltip.hover title="Limpiar Código" class="btn-transparent  blue-text" @click.prevent="clear01()" >
                                                                                <i class="fas fa-eraser"></i>
                                                                            </button>
                                                                    </div>
                                                                    <input type="text" 
                                                                            :class="{brd:this.arraySAP == ''||error22 , werd:this.arraySAP!='' }" 
                                                                            :maxlength="maxCSap" 
                                                                            :disabled="nroComprobante == ''||serie==''" 
                                                                            ref="emailss" 
                                                                            v-model="buscar" 
                                                                            @keyup.enter="listarSAP(buscar,criterio1)" 
                                                                            class="form-control" placeholder="Texto a buscar">  
                                                                    
                                                                    <div class="filesxPos " :class="{disNo:this.arraySAP == ''||error22 , disBlo:this.arraySAP!=''}">Datos encontrados</div>

                                                                </div>
                                                                <div class="col-md-2">
                                                                
                                                                    <br>
                                                                    <button v-b-tooltip.hover title="Comprobar" @click="listarSAP(buscar,criterio1)"  :disabled="error22" type="button" class="mt-2 float-right btn btn-primary btn-sm ">
                                                                        <i  class="fas fa-dolly"></i>
                                                                    </button>
                                                            
                                                                </div>
                                                                <!-- {{arrayEquipoSap}} -->
                                                                <div class="col-md-6"> 
                                                                <label for="">Número de Serie</label>
                                                                    <input   :disabled="this.arraySAP == ''||error22" type="text" class="form-control" placeholder="Texto a buscar" v-model="newTasks" @keyup="addBarra"  >
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
                                   <!-- <label for="">Paginación</label>
                                <b-form-select :options="pageOptions" v-model="perPage" /> -->
                            </div>
                            <div class="col-md-8">
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <button v-b-tooltip.hover title="Registrar Equipos en Almacen" type="button" :disabled="tasks.length == 0"  class="btn btn-primary btn-sm float-right" @click="registrarProducto()" >
                                            Registrar entrada
                                        </button>
                                        <!-- <span v-if="errores.ctdetpr_serie" :class="['label label-danger']">{{ errores.ctdetpr_serie[0] }}</span> -->
        
                                        <button  v-b-tooltip.hover title="Descargar Reporte"  type="button" :disabled="tasks.length == 0"  @click="exportPdf" class="float-right btn red btn-sm " >
                                            <i class="fas fa-download white-text" id="icons"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>
                                        
                                <div class="col-md-4">
                                    <div class="border p-2">
                                        <h6>Total Equipos : {{contaTotal}}</h6>
                                    </div>
                                </div>
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
                                                    <tr v-for=" (task,indice) in (tasks) " :key="task.descripcion" >
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

// console.log(fecha2.diff(fecha1, 'days'), ' dias de diferencia');


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
                items: items,  
                fields: ['SAP','DESCRIPCION','STOCK','OPCIONES'],
                fields01: ['SAP','DESCRIPCION','STOCK','OPCIONES'],
                currentPage: 1,
                currentPage1:1,
                perPage: 5,
                perPage1: 5,
                totalRows: items.length,
                pageOptions: [ 5, 10, 15 ],
                pageOptions1: [ 5, 10, 15 ],
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
                criterio:'ctdetgu_fecha_act',
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
                maxCSap:14,
                maxCom:3,
                numcota:1,
                contaTotal:0,
                contaTotalPr:0,
                mesaFal:0,
                mesaFalNu:0,
                CodigoSap:[],

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
              
               
                
            return this.serie.length > 0 &&this.serie.length <=4  ? true : false
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
            abrirCategoria: function() {
               window.location.href='/main#/categoria-create';
               // var modal= $('#basicExampleModal');
               var boton = $('#boton').hide();
               var boton1 = $('#boton1').show();
               if ($('#boton3').show()) {
                   $('#boton3').hide();
                   $('#boton2').show();
               }
           },
           cerrarCategoria: function() {
               window.location.href='/main#/';
               // var modal= $('#basicExampleModal');
               var boton1 = $('#boton1').hide();
               var boton = $('#boton').show();
           },
            abrirEquipo: function() {
               window.location.href='/main#/equipo-create';
               // var modal= $('#basicExampleModal');
               var boton2 = $('#boton2').hide();
               var boton3 = $('#boton3').show();
               if ($('#boton1').show()) {
                   $('#boton1').hide();
                   $('#boton').show();
               }
           },
           cerrarEquipo: function() {
               window.location.href='/main#/';
               // var modal= $('#basicExampleModal');
               var boton2 = $('#boton2').show();
               var boton3 = $('#boton3').hide();
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
                let serieComp = vm.serie;
                let fecha= moment(this.fecha).format('LLL');
                let fechaImp = moment(this.fecha).format('DD-MM-YYYY');
                
                let imgData = 'data:image/png;base64,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'

                let doc = new jsPDF('p', 'pt');
                let columns = [
                    // {title: "#", dataKey: "1"},
                    {title: "POSI", dataKey: "conta"},
                    {title: "Tipo", dataKey: "detaTi"},
                    {title: "Código Sap", dataKey: "prod01"},
                    // {title: "Categoria", dataKey: "cate01"},
                    // {title: "Producto", dataKey: "nompro01"},
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
                    margin: {top: 130},
                    
                    addPageContent: function(data) {
                            //(v(x)-h(y))

                        doc.setFontSize(11);
                        // doc.text("Número Comprobante", 40, 40);

                        // rectangulo
                        doc.setDrawColor(0);
                        doc.setFillColor(255, 255, 255);
                        doc.roundedRect(410, 35, 140, 55, 3, 3, 'FD'); 

                      

                        // rectangulo FECHA(0,0,ANCHO, ALTURA)
                        doc.setDrawColor(0);
                        doc.setFillColor(255, 255, 255);
                        doc.roundedRect(370, 100, 184, 21, 3, 3, 'FD'); 

                        doc.setDrawColor(0);
                        doc.setFillColor(255, 255, 255);
                        doc.roundedRect(370, 100, 120, 21, 3, 3, 'FD'); 

                        // fecha
                        doc.setFontSize(11)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.text("FECHA DE EMISIÓN : "+fechaImp +"", 375, 115);
                        // doc.text(fechaImp, 380, 50);

                        // ruc
                        doc.setFontSize(12)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.text("R.U.C. : 2060313844", 420, 50);

                        doc.setFontSize(13)
                        doc.setFont('helvetica')
                        doc.setFontType('bold')
                        doc.setTextColor(205, 0, 0)
                        doc.text("GUIA DE REMISIÓN", 420, 65);
                        // num Compro
                        doc.setTextColor(38, 86, 167)
                        doc.text(serieComp+ " -", 428, 80);
                        doc.setTextColor(205, 0, 0)
                        doc.text("N° "+nCompro+"", 465, 80);
                            
                        // imagen[ 0,0, ancho, alto]
                        doc.addImage(imgData, 'JPEG', 45, 35, 185,80)
                        
                    }
                }
                
                );
                doc.save('ELINIKTECH-INGRESO '+fecha+'.pdf');
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
                            me.arraySAP=respuesta.ingresos;
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
                    
                    this.timer = setTimeout(() => {
                        if (element == this.serie) {
                            this.mesaFal=1;
                            this.timer = setTimeout(() => {
                                this.mesaFal=0;
                                this.serie="";
                            }, 2000);
                        }
                    }, 2000);
                   
                }
                
            },
             NumCom(){
                for (let index = 0; index < this.arrayEntrada.length; index++) {
                    const element = this.arrayEntrada[index].ctdetgu_nro;
                    this.timer = setTimeout(() => {
                        if (element == this.nroComprobante) {
                            this.mesaFalNu=1;
                            this.timer = setTimeout(() => {
                                this.mesaFalNu=0;
                                this.nroComprobante="";
                             }, 2000);
                        }
                    }, 2000);
                    
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
                        //    console.log(respuesta);
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
                    console.log(response);
                    // handle success;
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

            
             buscarSap(sap){
               var sw=0;
               for (var i = 0; i < this.CodigoSap.length; i++) {
                   if (this.CodigoSap[i].sap==sap) {
                       sw=true;
                   }

               }

               return sw;

           },
           CodigoSapFunction(){
                 let me=this;
               var url='/codigo-sap' ;
              axios.get(url).then(function (response) {
               //    console.log(response);
                   // handle success;
                   var respuesta=response.data;
                  me.CodigoSap=respuesta.sap;
               console.log(me.CodigoSap);

               })
               .catch(function (error) {
                   // handle error
                   console.log(error);
               });
           },

          addBarra: function(){



               this.timer = setTimeout(() => {
                   if (this.newTasks==''){}
                   else if (this.newTasks.length<10){

                       this.newTasks='';
                   }
                   else if (this.buscarArticuloBD(this.newTasks)) {
                       swal({
                           type:'error',
                           title:'Error...',
                           text:'La serie del equipo ya se encuentra en la Base de datos',
                       });
                       this.newTasks='';
                   }
                   else if (this.buscarArticulo(this.newTasks)) {
                       swal({
                           type:'error',
                           title:'Error...',
                           text:'Ya se encuentra agregado a la lista',
                       });
                       this.newTasks='';
                   }
                   else if (this.buscarSap(this.newTasks)) {
                       swal({
                           type:'error',
                           title:'Error...',
                           text:'Un codigo sap no puede ser serie',
                       });
                       this.newTasks='';
                   }
                   else{
                       this.tasks.push({
                               conta: this.numcota++,
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
                       this.newTasks='';
                       // contador
                        this.contaTotal= this.tasks.length
                   }
               }, 200);
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
                //    console.log(respuesta);
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
                    // handle success;
                    // console.log(response);
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
                    // handle success;
                    //   console.log(response);
                   var respuesta=response.data;
                   me.arrayProveedor=respuesta.proveedores;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
          
            listarEntrada(buscar,criterio){
                let me=this;
                var url='/productoEntrada?buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayEntrada=respuesta.productos;
                    me.contaTotalPr= me.arrayEntrada.length
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
            cambiarPagina(page,buscar,criterio){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarEntrada(buscar,criterio);
            },
            registrarProducto(){
                if (
                    this.categoria==0
                    ||this.nroComprobante==''
                    ||this.serie==''
                    ||this.arraySAP==this.tasks) {
                     console.log(':)');
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
                   me.listarEntrada('','ctdetgu_fecha_act');
                 
                   me.nroComprobante='';
                   me.serie='';
                   me.errores=[];
                   me.arraySAP=[];
                   me.newTasks='';
                   me.buscar='';
                    let cantidad=me.tasks.length;
                   toast({
                        type: 'success',
                        title: `Añadido ${cantidad} productos en almacén `
                    })
                        me.contaTotal=0;
                        me.tasks=[];
                // console.log(response);
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
                        console.log(response);
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
            this.listarEntrada(this.buscar,this.criterio);
            this.listarSerieEquipo();
            this.listarGuias();
            this.CodigoSapFunction();
            
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

    
   </style>
