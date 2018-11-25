<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
              <br>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="">
                    <div class="card-header hedCa white-text">
                        <i class="fa fa-align-justify"></i> Almacén 

                    </div>
                    <div class="card-body">

                        <div class="row mb-4">
                            <div class="col-md-6 p-2 busq">
                                <div class="row">
                                    <div class="col-md-4 ">
                                            <select class="form-control " v-model="criterio">
                                                <option value="sap">SAP</option>
                                            </select>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div  v-show="cargoUser==1||cargoUser==2">
                                            <input type="text" v-model="buscar"  @keyup="listarAlmacen(1,buscar,criterio,user)" class="form-control" placeholder="Texto a buscar">
                                        </div>
                                        <div v-show="cargoUser!=1 && cargoUser!=2">
                                            <input type="text" v-model="buscar"  @keyup="listarAlmacenTecnico(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-2">
                                <div v-show="cargoUser==1||cargoUser==2">
                                    <select  class="form-control" v-model="user" @change="listarAlmacen(1,buscar,criterio,user);">
                                      <option value=0>Todos los usuarios</option>
                                     <option v-for="usuario in usuarioArray" :key="usuario.ctcatego_id" :value="usuario.ctusuar_code" v-text="usuario.ctusuar_usuario"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-grasy my-2" v-for="(almacen,indice) in arrayAlmacen" :key="almacen.idalmacen" >
                            <div class="header-tableR">
                                <div class="row">
                                    <div class="col" >
                                        <div  class="triangulo_bottom_Activo">
                                            <div class="text-center b-01 white-text pt-2">
                                                <i class="fas fa-ellipsis-v fl-rt"></i> {{indice+1}}
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col" >
                                        
                                        <div class="float-right mr-4" >
                                            <i class="ml-2 far fa-user-circle green-text fontS-17"></i>
                                            <span class="b-01 ml-2 fontS-18">
                                                {{almacen.ctdetsa_traspaso}}
                                            </span>
                                        </div>
                                        
                                        <div class="float-right">
                                            <div class="lineaH"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body-tableR">
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="far fa-circle green-text"></i>
                                        <span class="b-01 ml-2 fontS-18">
                                            {{almacen.ctdetsa_sap}}
                                        </span>
                                    </div>
                                    <div class="col-md">
                                        <i class="b-01 icoC-text ml-2">Producto:</i>
                                        <span class="b-01 black-text">
                                            {{almacen.ctdetsa_produDescri}}
                                        </span>
                                    </div>
                                    <div class="col-md">
                                        <i class="b-01 icoC-text ml-2">Cantidad :</i>
                                        <span class="b-01 black-text">{{almacen.ctdetsa_cantidad}}</span>
                                        <span class="b-01 green-text">
                                            {{almacen.ctdetsa_undmdDescri}}
                                        </span>
                                    </div>
                                    <div class="col-md">
                                        <i class="b-01 icoC-text ml-2">Fecha :</i>
                                        <span class="b-01 black-text">{{almacen.ctdetsa_fecha_act}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comentado Posibles usos en la versin 2.0 -->

                        <!-- <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        
                                        <th>Usuario</th>
                                        <th>SAP</th>
                                        <th>Cantidad</th>
                                        <th>Unidad de Medida</th>
                                        <th>Fecha Registro</th>
                                        <th>Traslado</th>
                                        <th>Reporte de Materiales</th>
                                        <th>Liquidacion de Materiales</th>
                                    
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="almacen in arrayAlmacen" :key="almacen.idalmacen"  >
                                        <td v-text="almacen.ctdetsa_traspaso"></td>
                                        <td v-text="almacen.ctdetsa_sap"></td>
                                        <td v-text="almacen.ctdetsa_cantidad"></td>
                                        <td v-text="almacen.ctdetsa_undmdDescri"></td>
                                        <td v-text="almacen.ctdetsa_fecha_act"></td>
                                        
                                        <td>
                                            <b-btn v-b-modal.modallg class="btn btn-sm green" variant="primary" @click="abrirModal('producto','traslado',almacen)">
                                                Nuevo
                                            </b-btn>
                                        </td>

                                        <td>
                                            <b-btn v-b-modal.modallg1  class="btn btn-sm" variant="success"  @click="abrirModal('producto','reporte',almacen)">
                                                Reportar
                                            </b-btn>
                                        </td>

                                        <td>
                                            <b-btn v-b-modal.modallg2  class="btn btn-sm" variant="warning  " @click="abrirModal('producto','liquidar',almacen)">
                                                Liquidar
                                            </b-btn>
                                        </td>
                                    
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->

                        <div v-if="cargoUser==1 ||cargoUser==2">
                            <nav aria-label="pagination example">
                            <ul class="pagination pg-blue">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1,buscar,criterio,user)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,user)" v-text="page" ></a>
                                </li>
                             
                                <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio,user)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                        </div>
                        <div v-else>
                            <nav aria-label="pagination example">
                            <ul class="pagination pg-blue">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent ="cambiarPaginaTecnico(pagination.current_page-1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaTecnico(page,buscar,criterio,user)" v-text="page" ></a>
                                </li>
                             
                                <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaTecnico(pagination.current_page+1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                        </div>
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
             <div>

                <b-modal v-model="modallg" id="modallg" size="lg" title="Traslado de Materiales" tabindex="-1" :class="{'mostrar':modal}">
                    
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6">
                             <b-card border-variant="Light" >
                                <div class="form-group ">
                                    <label class=" form-control-label" for="text-input">Código Sap</label>
                                        <input disabled type="text" v-model="sap1" class="form-control" >
                                </div>

                                <div class="form-group ">
                                    <label class=" form-control-label" for="text-input">Cantidad</label>
                                        <input disabled type="number" v-model="cantidad"  class="form-control" >
                                </div>
                                <div class="form-group ">
                                    <label class="form-control-label" for="text-input">Restantes en almácen</label>
                                        <input disabled type="number" step='0.01' value='0.00' placeholder='0.00' v-model="nuevo"  class="form-control" >
                                </div>

                            </b-card>
                            <b-card border-variant="Light" >
                                <div class="form-group ">
                                    <label class="form-control-label" for="text-input">Fecha</label>
                                        <datepicker disabled v-model="fechaActualizacion" format="dd/MM/yyyy" input-class="form-control">
                                        </datepicker>
                                </div>   
                            </b-card> 
                        </div>
                        <div class="col-md-6">
                            <b-card border-variant="Light" >
                                <div class="form-group ">
                                <label class="form-control-label" for="text-input">Usuario</label>
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

                                <div class="form-group ">
                                    <label class="form-control-label" for="text-input">Cantidad de Traspaso</label>
                                        <input  type="number" step='0.01' value='0.00' placeholder='0.00' v-model="cantidadTraspaso" @keyup="restarCantidad()" class="form-control" >
                                </div>
                                <!-- <b-form-group 
                                                label="Cantidad de Traspaso"
                                                label-class="text-sm-right"
                                                label-for="nestedCountry">

                                                <b-form-input   id="inputLive3"
                                                                v-model.trim="cantidadTraspaso"
                                                                @keyup="restarCantidad()"
                                                                type="number"
                                                                :state="cantiState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="cantidadTraspaso<= 0" id="inputLiveFeedback">
                                               
                                                Agregar cantidad
                                                </b-form-invalid-feedback>
                                                <b-form-invalid-feedback v-show="cantidadTraspaso > cantidad" id="inputLiveFeedback1">
                                               
                                                No exeder del stock
                                                </b-form-invalid-feedback>

                                               
                                    
                                    </b-form-group> -->
                                    <!-- <button :disabled="errorCanti">
                                        add
                                    </button> -->
                                    

                                 <div class="form-group ">
                                  
                                    <!--   <textarea v-model="observacion" cols="45" rows="5"></textarea> -->
                                    <b-form-textarea 
                                        v-model="observacion"
                                        id="inputLive"
                                        :state="descrpState"
                                        placeholder="ESCRIBA OBLIGATORIAMENTE"
                                        :rows="5"
                                        aria-describedby="inputLiveHelp inputLiveFeedback"
                                        :max-rows="6">
                                    </b-form-textarea>

                                    
                                    <b-form-invalid-feedback id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                    Ingrese más de 10 caracteres
                                    </b-form-invalid-feedback>
                                </div>
                            </b-card>
                        </div>
                    </div>

                           
                        
                                             

                    </form>
                    
                        <div slot="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarEquipo()">Guardar</button>
                                <button :disabled="errorCanti"  type="button" v-if="tipoAccion==2" class="btn-sm btn btn-primary" @click="actualizarTecnico()">Trasladar</button>
                           
                            
                            
                        </div>
                </b-modal>

                <b-modal v-model="modallg1" id="modallg1" size="lg" title="Reportar Materiales" tabindex="-1" :class="{'mostrar':modal}">
                    
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código Sap</label>
                                    <div class="col-md-9">
                                        <input disabled type="text" v-model="sap1" class="form-control" >
                                       
                                    </div>
                                </div>
                                 <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                        <div class="col-md-9">
                                            <input disabled type="number" v-model="cantidad"  class="form-control" >
                                        
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Restantes en almácen</label>
                                        <div class="col-md-9">
                                            <input disabled type="number" step='0.01' value='0.00' placeholder='0.00' v-model="nuevo"  class="form-control" >
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad que Utilizaste</label>
                                        <div class="col-md-9">
                                            <input  type="number" step='0.01' value='0.00' placeholder='0.00' v-model="cantidadTraspaso" @keyup="restarCantidad()" class="form-control" >
                                        
                                        </div>
                                    </div>
                               
                            </form>
                    
                        <div slot="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarEquipo()">Guardar</button>
                            <button :disabled=" cantidadTraspaso==0.00"  type="button" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="reporteMaterial()">Reportar</button>
                        </div>
                </b-modal>

                <!-- liquidar -->
                 <b-modal v-model="modallg2" id="modallg2" size="lg" title="Liquidar" tabindex="-1" :class="{'mostrar':modal}">
                    
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código Sap</label>
                                    <div class="col-md-9">
                                        <input disabled type="text" v-model="sap1" class="form-control" >
                                       
                                    </div>
                                </div>
                                 <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                        <div class="col-md-9">
                                            <input disabled type="number" v-model="cantidad"  class="form-control" >
                                        
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Restantes en almácen</label>
                                        <div class="col-md-9">
                                            <input disabled type="number" step='0.01' value='0.00' placeholder='0.00' v-model="nuevo"  class="form-control" >
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad a liquidar</label>
                                        <div class="col-md-9">
                                            <input  type="number" step='0.01' value='0.00' placeholder='0.00' v-model="cantidadTraspaso" @keyup="restarCantidad()" class="form-control" >
                                        
                                        </div>
                                    </div>
                               
                            </form>
                    
                        <div slot="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarEquipo()">Guardar</button>
                            <button :disabled=" cantidadTraspaso==0.00"  type="button" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="liquidarMaterial()">Liquidar</button>
                        </div>
                </b-modal>

            </div>
            
           
            <!--Fin del modal-->    
     
           
        </main>
</template>

<script>
// var fecha1 = moment('2018-08-12');
// var fecha2 = moment(new Date());

// console.log(fecha2.diff(fecha1, 'days'), ' dias de diferencia');

    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    import vSelect from 'vue-select';
    export default {
        
        data(){
            return{
                modallg:false,
                modallg1:false,
                modallg2:false,
                moment:moment,
                usuario:0,
                idSalida:0,
                observacion:'',
                categoria_id:0,
                descripcion:'',
                fechaActualizacion:new Date(),
                arrayAlmacen:[],
                arrayUsuario:[],
                usuario_id:'',
                serie:'',
                sap:'',
                sap1:'',
                cantidad:'',
                nuevo:0,
                cantidadTraspaso:'',
                modal:0,
                tituloModal:'',
                tipoAccion:0, 
                errorCategoria:0,
                errorMostrarMsjCategoria:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },

                offset:3,
                criterio:'sap',
                buscar:'',
                docHo:'',
                indice:'',
                sot:'',
                idProducto:'',
                unidadMedida:'',
                descripcionMedida:'',
                TipoDeProducto:'',
                tipodescri:'',
                produdescri:'',
                msj:'',
                msjUser:'',
                msjCantidad:'',
                fechaInicio:'',
                Canti:1,
                usuarioArray:[],
                user:0,
                cargoUser:''

            }
        },
        components:{
            Datepicker,
            vSelect
        },
        
        computed:{
             descrpState(){
                    return this.observacion.length > 2 ? true : false
            },
           errorCanti(){
                if(this.cantidadTraspaso <= this.cantidad && this.observacion.length > 10 && this.cantidadTraspaso !==''  ){
                   
                            return false
                    
                }
                else{
                    return true;
                }
            },

            cantiState(){
                return this.cantidadTraspaso > 0 ? true : false
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
            selectUser(){
                 let me=this;
                 var url='/user/selectUser';
               axios.get(url).then(function (response) {
                   var respuesta=response.data;
                   me.usuarioArray=respuesta.usuarios;
                  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            restantes(val){

                this.docHo= moment(this.fechaActualizacion).format('L');
                // this.diasHO= moment(this.docHo).diff(val, 'days');
                // this.horasHO= moment(this.docHo).diff(val, 'hours');
                return moment(this.docHo).diff(val, 'days');
            },

            listarAlmacen(page,buscar,criterio,user){
                let me=this;
                var url='/almacentecmate?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio+'&user='+user;
               axios.get(url).then(function (response) {
                   var respuesta=response.data;
                   me.arrayAlmacen=respuesta.almacen.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
             listarAlmacenTecnico(page,buscar,criterio){
                let me=this;
                var url='/almacentecmate?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                   var respuesta=response.data;
                   me.arrayAlmacen=respuesta.almacen.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
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
             restarCantidad(){
                    //  if(this.cantidadTraspaso>0&&this.cantidadTraspaso!=null){
                     this.nuevo=this.cantidad-this.cantidadTraspaso;
                    
                         
                        if(this.nuevo<0){
                            this.nuevo=this.cantidad;
                            this.cantidadTraspaso='';
                            
                        }
                    //  } 
                    
                   
             },
            cambiarPagina(page,buscar,criterio,user){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarAlmacen(page,buscar,criterio,user);
            },
            cambiarPaginaTecnico(page,buscar,criterio){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarAlmacenTecnico(page,buscar,criterio);
            },
            
            desactivarCategoria(idCategoria){
                swal({
                    title: '¿Desea desactivar este registro?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Desactivar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {

                        let me=this;
                            axios.patch('/categoria/desactivar',{
                                
                                'idCategoria':idCategoria
                            }).then(function (response) {
                           
                            me.listarCategoria(1,'','ctdetsa_serie');
                                   swal(
                                    'Desactivado!',
                                    'Registro desactivado',
                                    'success'
                                    )       
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        
                    }
                    })
            },
             activarCategoria(idCategoria){
                swal({
                    title: '¿Desea activar este registro?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Activar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {

                        let me=this;
                            axios.patch('/categoria/activar',{
                                
                                'idCategoria':idCategoria
                            }).then(function (response) {
                           
                            me.listarCategoria(1,'','ctdetsa_serie');
                                   swal(
                                    'Activado!',
                                    'Registro Activado.',
                                    'success'
                                    )       
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        
                    }
                    })
            },
            actualizarTecnico(){
                if (
                    this.observacion==''||this.cantidadTraspaso ==0.00
                   ) {
                       this.msjCantidad='La cantidad de traspaso no puede ser cero';
                    }else{
                let me=this;
                axios.patch('/salida/actualizarM',{
                    'fechaInicio':this.fechaInicio,
                    'indiceSalida':this.indice,
                    'idSalida':this.idSalida,
                    'idUsuario':this.usuario_id,
                    'tipodescri':this.tipodescri,
                    'produdescri':this.produdescri,
                    'sot':this.sot,
                    'idProducto':this.idProducto,
                    'unidadMedida':this.unidadMedida,
                    'descripcionMedida':this.descripcionMedida,
                    'TipoDeProducto':this.TipoDeProducto,

                    'sap':this.sap1,
                    'cantidadnueva':this.nuevo,
                    'cantidadtraspaso':this.cantidadTraspaso,
                    'observacion':this.observacion,
                    'fecha':moment(this.fechaActualizacion).format('YYYY-MM-DD hh:mm:ss'),
                }).then(function (response) {
                 let respuesta = response.data;
                 let respuesta1 = response.data;
                    if (respuesta = respuesta.msj) {
                        let respuesta = response.data;
                          me.msj=respuesta.msj;
                        //  console.log(me.msj);
                        
                    }else if(respuesta1 = respuesta1.msjUser){
                            let respuesta1 = response.data;
                             me.msjUser=respuesta1.msjUser;
                            //  console.log(me.msjUser);
                    }
                    else{
                        me.cerrarModal();
                        me.listarAlmacen(1,'','ctdetsa_serie',0);
                    }
                })
                .catch(function (error) {
                      let swalErrorMessage=error.response.data.error;
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: swalErrorMessage
                        })
                });
                    }
            },
            reporteMaterial(){
                if (
                    this.cantidadTraspaso ==0.00
                   ) {
                       this.msjCantidad='La cantidad de traspaso no puede ser cero';
                    }else{
                let me=this;
                axios.patch('/Material/Almacen',{
                    'fechaInicio':this.fechaInicio,
                    'indiceSalida':this.indice,
                    'idSalida':this.idSalida,
                    'idUsuario':this.usuario_id,
                    'tipodescri':this.tipodescri,
                    'produdescri':this.produdescri,
                    'sot':this.sot,
                    'idProducto':this.idProducto,
                    'unidadMedida':this.unidadMedida,
                    'descripcionMedida':this.descripcionMedida,
                    'TipoDeProducto':this.TipoDeProducto,

                    'sap':this.sap1,
                    'cantidadnueva':this.nuevo,
                    'cantidadtraspaso':this.cantidadTraspaso,
                    'observacion':this.observacion,
                    'fecha':moment(this.fechaActualizacion).format('YYYY-MM-DD hh:mm:ss'),
                }).then(function (response) {
                 let respuesta = response.data;
                 let respuesta1 = response.data;
                    if (respuesta = respuesta.msj) {
                        let respuesta = response.data;
                          me.msj=respuesta.msj;
                        //  console.log(me.msj);
                        
                    }else if(respuesta1 = respuesta1.msjUser){
                            let respuesta1 = response.data;
                             me.msjUser=respuesta1.msjUser;
                            //  console.log(me.msjUser);
                    }
                    else{
                        me.cerrarModal();
                        me.listarAlmacen(1,'','ctdetsa_serie',0);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
                    }
            },

            liquidarMaterial(){
                if (
                    this.cantidadTraspaso ==0.00
                   ) {
                       this.msjCantidad='La cantidad de traspaso no puede ser cero';
                    }else{
                let me=this;
                axios.patch('/Material/liquidar',{
                    'fechaInicio':this.fechaInicio,
                    'indiceSalida':this.indice,
                    'idSalida':this.idSalida,
                    'idUsuario':this.usuario_id,
                    'tipodescri':this.tipodescri,
                    'produdescri':this.produdescri,
                    'sot':this.sot,
                    'idProducto':this.idProducto,
                    'unidadMedida':this.unidadMedida,
                    'descripcionMedida':this.descripcionMedida,
                    'TipoDeProducto':this.TipoDeProducto,

                    'sap':this.sap1,
                    'cantidadnueva':this.nuevo,
                    'cantidadtraspaso':this.cantidadTraspaso,
                    'observacion':this.observacion,
                    'fecha':moment(this.fechaActualizacion).format('YYYY-MM-DD hh:mm:ss'),
                }).then(function (response) {
                 let respuesta = response.data;
                 let respuesta1 = response.data;
                    if (respuesta = respuesta.msj) {
                        let respuesta = response.data;
                          me.msj=respuesta.msj;
                        //  console.log(me.msj);
                        
                    }else if(respuesta1 = respuesta1.msjUser){
                            let respuesta1 = response.data;
                             me.msjUser=respuesta1.msjUser;
                            //  console.log(me.msjUser);
                    }
                    else{
                        me.cerrarModal();
                        me.listarAlmacen(1,'','ctdetsa_serie',0);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
                    }
            },
            cerrarModal(){
                this.modallg=false;
                this.modallg1=false;
                this.modallg2=false,
                this.modal=0;
                this.tituloModal='';
                this.sap1='';
                this.cantidad='';
                this.nuevo=this.cantidad;
                this.cantidadTraspaso='';
                this.observacion='';
                this.ctusuar_code=null;
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "producto":
                        {
                            switch (accion) {
                             
                                case 'traslado':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Categoria'
                                    this.tipoAccion=2;
                                    this.indice=data['ctdetsa_indice'];
                                    this.idProducto=data['ctdetsa_roduc_id'];
                                    this.unidadMedida=data['ctdetsa_undmd_code'];
                                    this.descripcionMedida=data['ctdetsa_undmdDescri'];
                                    this.sot=data['ctdetsa_sot'];
                                    this.tipodescri=data['ctdetsa_descriTipo'];
                                    this.produdescri=data['ctdetsa_produDescri'];
                                    this.sot=data['ctdetsa_sot'];
                                    this.TipoDeProducto=data['ctdetsa_tipro_code'];
                                    this.idSalida=data['ctdetsa_salid_nro'];
                                    this.fechaInicio=data['ctdetsa_fecha_reg'];
                                    
                                    this.cantidad=data['ctdetsa_cantidad'];
                                    this.sap1=data['ctdetsa_sap'];
                                    this.nuevo=this.cantidad;
                                    this.ctusuar_code=null;
                                  
                               
                                    break;
                                }
                                case 'reporte':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Categoria'
                                    this.tipoAccion=2;
                                    this.indice=data['ctdetsa_indice'];
                                    this.idProducto=data['ctdetsa_roduc_id'];
                                    this.unidadMedida=data['ctdetsa_undmd_code'];
                                    this.descripcionMedida=data['ctdetsa_undmdDescri'];
                                    this.sot=data['ctdetsa_sot'];
                                    this.tipodescri=data['ctdetsa_descriTipo'];
                                    this.produdescri=data['ctdetsa_produDescri'];
                                    this.sot=data['ctdetsa_sot'];
                                    this.TipoDeProducto=data['ctdetsa_tipro_code'];
                                    this.idSalida=data['ctdetsa_salid_nro'];
                                    this.fechaInicio=data['ctdetsa_fecha_reg'];
                                    
                                    this.cantidad=data['ctdetsa_cantidad'];
                                    this.sap1=data['ctdetsa_sap'];
                                    this.nuevo=this.cantidad;
                                    this.ctusuar_code=null;
                                  
                               
                                    break;
                                }

                                case 'liquidar':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Categoria'
                                    this.tipoAccion=2;
                                    this.indice=data['ctdetsa_indice'];
                                    this.idProducto=data['ctdetsa_roduc_id'];
                                    this.unidadMedida=data['ctdetsa_undmd_code'];
                                    this.descripcionMedida=data['ctdetsa_undmdDescri'];
                                    this.sot=data['ctdetsa_sot'];
                                    this.tipodescri=data['ctdetsa_descriTipo'];
                                    this.produdescri=data['ctdetsa_produDescri'];
                                    this.sot=data['ctdetsa_sot'];
                                    this.TipoDeProducto=data['ctdetsa_tipro_code'];
                                    this.idSalida=data['ctdetsa_salid_nro'];
                                    this.fechaInicio=data['ctdetsa_fecha_reg'];
                                    
                                    this.cantidad=data['ctdetsa_cantidad'];
                                    this.sap1=data['ctdetsa_sap'];
                                    this.nuevo=this.cantidad;
                                    this.ctusuar_code=null;
                                  
                               
                                    break;
                                }
                              
                            }
                        }  
                        
                        // this.selectTablaTec(this.criterio);                  
                }
            },
            userCargo(){
                let me=this;
                 var url='/user/cargo';
               axios.get(url).then(function (response) {
                   me.cargoUser=response.data.cargo;
                   
                  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
        },
        mounted() {
            this.userCargo();
            if (this.cargoUser==1||this.cargoUser==2) {
                 this.listarAlmacen(1,this.buscar,this.criterio,0);
            }else{
                 this.listarAlmacenTecnico(1,this.buscar,this.criterio);
            }
           
            this.selectUser();
        
              
        }
    }
</script>
<style>
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
    .red{
        text-align: center;
         font-weight:bold;
       
    }

</style>
