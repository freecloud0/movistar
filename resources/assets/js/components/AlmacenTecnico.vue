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
                        <i class="fa fa-align-justify"></i> Almacén 
                        
                    </div>
                    <div class="card-body">



                            <div class="row">
                                <div class="col-md-3">
                                        <select class="form-control mt-2" v-model="criterio">
                                            <option value="ctdetsa_traspaso">Usuario</option>
                                        </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="md-form input-group mt-0 mb-3">
                                        <input type="text" v-model="buscar"  @keyup="listarAlmacen(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <div class="input-group-append">
                                            <button type="submit" :disabled="buscar == ''" @click="listarAlmacen(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
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
                                <thead>
                                    <tr>
                                        <th>Sot</th>
                                        <th>Usuario</th>
                                        <th>SAP</th>
                                        <th>Serie</th>
                                        <th>Cantidad</th>
                                        <th>Fecha Registro</th>
                                        <th>Dias</th>
                                        <th>Traslado</th>
                                        <th>Liquidación</th>
                                        <th>Devolución</th>
                                    
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="almacen in arrayAlmacen" :key="almacen.idalmacen"  >
                                        <!-- <td v-text="categoria.idCategoria" ></td> -->
                                        <td v-text="almacen.ctdetsa_sot"></td>
                                        <td v-text="almacen.ctdetsa_traspaso"></td>
                                        <td v-text="almacen.ctdetsa_sap"></td>
                                        <td v-text="almacen.ctdetsa_serie"></td>
                                        <td v-text="almacen.ctdetsa_cantidad"></td>
                                        <td v-text="almacen.ctdetsa_detgu_fecha_reg"></td>
                                        <!-- <td>{{moment(almacen.ctdetsa_fecha_reg).fromNow()}}</td> -->
                                        <td 
                                            :class="{ 
                                                reds: restantes(almacen.ctdetsa_detgu_fecha_reg) >= 4, 
                                                greens: restantes(almacen.ctdetsa_detgu_fecha_reg) <= 4  
                                                }">
                                                
                                                {{restantes(almacen.ctdetsa_detgu_fecha_reg)}}
                                        </td>
                                        <td>
                                            <b-btn v-b-modal.modallg class="btn-sm" variant="primary" @click="abrirModal('producto','traslado',almacen)">
                                                Traslado
                                            </b-btn>
                                        </td>
                                        <td>
                                            
                                                <b-btn type="button" class="btn btn-danger btn-sm" @click="desactivarEquipo(almacen.ctdetsa_indice)">
                                                        Liquidar
                                                </b-btn>
                                        
                                        
                                        </td>
                                        <td>
                                            <b-btn type="button" class="btn btn-danger btn-sm" @click="devolverEquipo(almacen.ctdetsa_indice)">
                                                        Devolver
                                                </b-btn>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         <nav aria-label="pagination example">
                            <ul class="pagination pg-blue">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                        </div>
                    </div>
                </div>
                <!-- <h3>{{arrayAlmacen}}</h3> -->
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
             <div>

                <b-modal v-model="modallg" id="modallg" size="lg" title="Traslado de equipos" tabindex="-1" :class="{'mostrar':modal}">
                    
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-4">
                                <div role="group">
                                    <label for="inputLive">Serie:</label>
                                    <b-form-input id="inputLive"
                                                disabled
                                                v-model.trim="serie"
                                                type="text"
                                                >
                                    </b-form-input>
                                    
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-12">
                                    <label class=" form-control-label" for="text-input">Usuario</label>
                                  
                                                    <span class="red-text">{{msjUser}}</span>
                                    <!-- <p>{{msj}}</p>  -->
                                    
                                   
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
                                <div class="col-md-12">
                                     <label class="form-control-label" for="text-input">Observacion
                                        <!-- <span style="color:red;"  v-show="observacion==''">(*Rellene este campo)</span> -->
                                    </label>
                                  
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
                                <div class="col-md-12">
                                    <label class=" form-control-label" for="text-input">Fecha</label>
                                    <datepicker disabled v-model="fechaActualizacion" format="dd/MM/yyyy" input-class="form-control">
                                    </datepicker>
                                </div>
                            </div>
                        </div>

                              
                    </form>
                    
                    <div slot="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarEquipo()">Guardar</button>
                        <button type="button" :disabled="observacion == '' || usuario_id ==''" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarTecnico()">Trasladar</button>
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
                moment:moment,
                usuario:0,
                observacion:'',
                categoria_id:0,
                descripcion:'',
                fechaActualizacion:new Date(),
                arrayAlmacen:[],
                arrayUsuario:[],
                usuario_id:'',
                serie:'',
                sap:'',
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
                criterio:'ctdetsa_traspaso',
                buscar:'',
                docHo:'',
                indice:'',
                msj:'',
                msjUser:'',
                indice:'',
            }
        },
        components:{
            Datepicker,
            vSelect
        },
        
        computed:{
             descrpState () {
                return this.observacion.length > 10 ? true : false
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

            restantes(val){

                this.docHo= moment(this.fechaActualizacion).format('L');
                // this.diasHO= moment(this.docHo).diff(val, 'days');
                // this.horasHO= moment(this.docHo).diff(val, 'hours');
                return moment(this.docHo).diff(val, 'days');
            },

            listarAlmacen(page,buscar,criterio){
                let me=this; 
                var url='/almacentec?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
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
             
            cambiarPagina(page,buscar,criterio){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarAlmacen(page,buscar,criterio);
            },
            
            desactivarEquipo(idEquipo){
                swal({
                    title: '¿Desea Sacar este producto de su inventario?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {

                        let me=this;
                            axios.patch('/Equipo/desactivar',{
                                
                                'idEquipo':idEquipo
                            }).then(function (response) {
                           
                            me.listarAlmacen(1,'','ctdetsa_traspaso');
                                   swal(
                                    'Eliminado!',
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
            devolverEquipo(idEquipo1){
                swal({
                    title: '¿Desea devolver este producto al almacén General?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Devolver',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {

                        let me=this;
                            axios.patch('/Equipo/devolver',{
                                
                                'idEquipo':idEquipo1
                            }).then(function (response) {
                           
                            me.listarAlmacen(1,'','ctdetsa_traspaso');
                                   swal(
                                     'Equipo Trasladado',
                                    'El equipo ya no se encuetra en su almacén',
                                    'success'
                                    )       
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        
                    }
                    })
            },
           
            validarCategoria(){
                this.errorCategoria=0;
                this.errorMostrarMsjCategoria=[];
              
                if (!this.descripcion) this.errorMostrarMsjCategoria.push("La descripción esta vacía,rellene por favor") ;
                if (this.errorMostrarMsjCategoria.length) this.errorCategoria=1; 
                return this.errorCategoria;
            },
            actualizarTecnico(){
                if (
                    this.observacion==''
                   ) {

                    }else{
                let me=this;
                axios.patch('/salida/actualizar',{
                    'indice':this.indice,
                    'idUsuario':this.usuario_id,
                    'serie':this.serie,
                    'observacion':this.observacion,
                    'fecha':moment(this.fechaActualizacion).format('YYYY-MM-DD hh:mm:ss'),
                }).then(function (response) {
                    let respuesta = response.data;
                     let respuesta1 = response.data;
                    if (respuesta = respuesta.msj ) {
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
                        me.listarAlmacen(1,'','ctdetsa_traspaso');
                    }
                    
                     
                  
                })
                .catch(function (error) {
                    me.msj=respuesta.msj.data;
                    console.log(me.msj);
                    // console.log(error);
                    this.arrayUsuario='';
                    
                });
                    }
            },
            cerrarModal(){

                this.modallg=false;
                this.modal=0;
                this.tituloModal='';
                this.serie='';
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
                                    this.serie=data['ctdetsa_serie'];
                                    this.ctusuar_code=null;
                                    // this.usuario=0;
                                    // console.log(this.categoria_id);
                                    // this.descripcion=data['descripcion'];
                                    break;
                                }
                               
                              
                            }
                        }  
                        
                        // this.selectTablaTec(this.criterio);                  
                }
            }
        },
        mounted() {
            this.listarAlmacen(1,this.buscar,this.criterio);
              
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
    .reds{
        text-align: center;
         font-weight:bold;
        color: red;
    }
    .greens{
        text-align: center;
        color: green;
    }
   
</style>
