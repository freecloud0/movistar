<template>
        <main class="main">
            <!-- Breadcrumb -->
            <audio id="xyz" preload="auto"  src="audio/error.mp3" type="audio/mpeg" > </audio>
            <ol class="breadcrumb">
                <br>
            </ol>

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="">
                    <div class="card-header hedCa white-text">
                        <i class="fa fa-align-justify"></i> Categorías                     

                        
                        <button v-b-tooltip.hover title="Agregar Categoria" 
                                v-b-modal.modallg
                                @click="abrirModal('categoria','registrar')"
                                type="button" class="redondear2 btn-transparent whit-de float-right" >
                            <i class="fas fa-external-link-alt"></i> Nuevo
                        </button>
                        <!-- <div class="float-right mr-4">
                            <div class="lineaH"></div>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="row">  
                            <div class="col-md-6 busq p-2">
                                <div class="row">
                                    <div class="col-md-4">
                                    <select class="form-control " v-model="criterio">
                                        <option value="ctcatego_desc">Descripción</option>
                                        <option value="ctcatego_fecha_reg">Fecha de Registro</option>
                                        <option value="ctcatego_usuario">Usuario</option>
                                    </select>
                                </div>
                                <div class="my-4 visible-rE"></div>
                                <div class="col-md-7" >
                                    <input type="text" v-model="buscar" @keyup="listarCategoria(1,Activo,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                </div>
                                <div class="col-1 visible-wE">
                                    <button :disabled="buscar == ''" @click="listarCategoria(1,Activo,buscar,criterio)" type="button" class="psoFSal btn green btn-sm ">
                                        <i  class="fa fa-search"></i>
                                    </button>
                                </div>
                                </div>
                                
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 vista-C">
                                    <select class="form-control mt-2"  v-model="Activo" @change="listarCategoria(1,Activo,buscar,criterio)" >
                                        <option value="1">Activos</option>
                                        <option value="0">Inactivos</option>
                                    </select>
                            </div>
                        </div> 
 
                        <br>
                        
                            <div v-if="success" class="flotante" :class="['label label-success']">
                                <b-alert :show="dismissCountDown"
                                        dismissible
                                        variant="success"
                                        @dismissed="dismissCountDown=0"
                                        @dismiss-count-down="countDownChanged">

                                        <span>Registrado Correctamente!</span>
                                </b-alert>
                            </div>
                            
                            <div v-if="successAct" class="flotante">
                                <b-alert :show="dismissCountDown1"
                                        dismissible
                                        variant="warning"
                                        @dismissed="dismissCountDown1=0"
                                        @dismiss-count-down="countDownChanged1">

                                        <span>{{successAct}}</span>
                                </b-alert>
                            </div>

                        <div class="bg-grasy my-2 card"  v-for="(categoria,indice) in arrayCategoria" :key="categoria.idCategoria">
                            <div class="header-tableR">
                                <div class="row">
                                        <div class="col" >
                                            <div v-if="categoria.estado" class="triangulo_bottom_Activo">
                                                <div class="text-center b-01 white-text pt-2">
                                                    <i class="fas fa-ellipsis-v fl-rt"></i> {{indice+1}}
                                                </div> 
                                            </div>

                                            <div v-else class="triangulo_bottom_Inactivo">
                                                <div class="text-center b-01 white-text pt-2">
                                                    <i class="fas fa-ellipsis-v"></i> {{indice+1}}
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col" v-if="CargoUser==1">
                                            
                                            <div class="float-right" >

                                                <button v-if="CargoUser==1" v-b-tooltip.hover title="Opcion y edicion"  v-b-modal.modallg  @click="abrirModal('categoria','actualizar',categoria)" type="button" class=" btn-transparent iconOp" >
                                                    <i class="fas fa-cog"></i>
                                                </button>

                                            </div>
                                            <div class="float-right" v-if="CargoUser==1">
                                                <button v-b-tooltip.hover title="Desactivar producto?" v-if="categoria.estado"  @click="desactivarCategoria(categoria.ctcatego_id)" type="button" class=" btn-transparent iconOp" >
                                                    <i class="fas fa-toggle-on"></i>
                                                </button>
                                                <button v-b-tooltip.hover title="Activar producto?" v-else  @click="activarCategoria(categoria.ctcatego_id)" type="button" class=" btn-transparent iconOp" >
                                                    <i class="fas fa-toggle-off"></i>
                                                </button>
                                            </div>
                                            <div class="float-right">
                                                <div class="lineaH"></div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="body-tableR">
                                <div class="row">
                                    <div class="col-md">
                                        <i class="far fa-circle green-text"></i>
                                    
                                        <span class="b-01 ml-2 fontS-18">
                                            {{categoria.ctcatego_desc}}
                                        </span>
                                    
                                        <div class="div ml-4">
                                            <i class="b-01 icoC-text">Fecha Registro:</i>
                                            <span>{{categoria.ctcatego_fecha_reg}}</span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                            
                             
                        <!-- <div  class="table-responsive">
                        <table class=" table table-bordered table-striped table-sm">
                            <thead class="hedCa white-text text-center">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Descripcion</th>
                                    <th>Fecha de Registro</th>
                                    <th>Fecha de Actualización</th>
                                    
                                    <th v-if="CargoUser==1">Opciones</th>
                                    <th v-if="CargoUser==1">Estado</th>
                                   
                                   
                                   
                                </tr>
                            </thead> 
                            <tbody>

                                <tr v-for="(categoria,indice) in arrayCategoria" :key="categoria.idCategoria"  >
                                    
                                     <td>{{indice+1}}</td>
                                    <td v-text="categoria.ctcatego_desc"></td>
                                    <td v-text="categoria.ctcatego_fecha_reg"></td>
                                    <td v-text="categoria.ctcatego_fecha_act"></td>
                                    
                                   
                                    <td v-if="CargoUser==1" class="text-center">
                                        
                                        <b-btn :disabled="cargoUsuario"  v-b-modal.modallg variant="warning btn-sm" @click="abrirModal('categoria','actualizar',categoria)">
                                                Editar
                                        </b-btn>

                                        
                                        
                                    </td>
                                    
                                   
                                    <td v-if="CargoUser==1 "  class="text-center">
                                        <div v-if="categoria.estado">
                                            <button  type="button"
                                                   
                                                    class="btn btn-success btn-sm" 
                                                    @click="desactivarCategoria(categoria.ctcatego_id)">
                                                    Activo
                                            </button>
                                        </div>
                                        <div v-else>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm"
                                                   
                                                    @click="activarCategoria(categoria.ctcatego_id)">
                                                    Inactivo
                                            </button>
                                        </div>
                                        
                                    </td>
                                    
                                    
                                </tr>
                            </tbody>
                        </table>
                        
                        </div> -->
                      
                         <nav aria-label="pagination example">
                            <ul class="pagination pg-blue">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1,Activo,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,Activo,buscar,criterio)" v-text="page" ></a>
                                </li>
                             
                                <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,Activo,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
             <div>

            <b-modal  no-close-on-esc no-close-on-backdrop v-model="modallg" id="modallg"  title="Categoria" tabindex="-1" :class="{'mostrar':modal}" >
                
                        <form action="" method="post" enctype="multipart/form-data" @submit.prevent="onSubmit" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-8">
                                        <label class="form-control-label" for="text-input">Descripción
                                        </label>
                                    
                                        <b-form-input   id="inputLive"
                                                        v-model.trim="descripcion"
                                                        type="text"

                                                        :state="nameState"
                                                        aria-describedby="inputLiveHelp inputLiveFeedback"
                                                        placeholder=""
                                                        v-validate:numero="'maxlength: 15'">
                                                        
                                        </b-form-input>
                                        <b-form-invalid-feedback v-show="descripcion==''" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                        </b-form-invalid-feedback>

                                        <b-form-invalid-feedback v-if="errorResponse" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ya existe este campo
                                        </b-form-invalid-feedback>

                                </div>
                                <div class="col-md-4 ">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                        <datepicker v-model="fechaActualizacion" format="dd/MM/yyyy" input-class="form-control">
                                        </datepicker>
                                        <div v-show="errorCategoria" class="form-group row div-error" >
                                        <div class="text-center text-error">
                                        
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </form>
                
                    <div slot="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="submit" v-if="tipoAccion==1" :disabled="descripcion==''" class="btn btn-primary btn-sm" @click="registrarCategoria()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" :disabled="descripcion==''"  class="btn btn-primary btn-sm" @click="actualizarCategoria()">Actualizar</button>
                    </div>
            </b-modal>
             

            </div>
            
            <div>
                
            </div>
        </main>
</template>

<script>
    import VeeValidate from 'vee-validate';
        Vue.use(VeeValidate);
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        
        data(){
            return{
                dismissSecs: 5,
                dismissCountDown: 0,
                dismissSecs1: 5,
                dismissCountDown1: 0,
                modallg:false,
                categoria_id:0,
                descripcion:'',
                fechaActualizacion:new Date(),
                arrayCategoria:[],
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
                criterio:'ctcatego_desc',
                buscar:'',
                 email: '',
                 errores:[],
                 success:false,
                 successAct:'',
                 CargoUser:0,
                 mesaFalNu:0,
                 categoriasActivos:[],
                 criterioAI:'1',
                 Activo:1,
                 paginar:'0',
                 errorResponse:''

            }
        },
        components:{
            Datepicker,

        },
        
        
        computed:{
            nameState () {
            return this.descripcion.length > 2 ? true : false
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

            },
            cargoUsuario(){
                if (this.CargoUser !=1) {
                    return true;
                }else {
                    return false;
                }
            },
        },
        methods:{
             traerCategoria(id){
                // console.log(id);
                 let me=this;
                var url='/categoria-activo?idActivo='+id;
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data[1];
                   me.categoriasActivos=respuesta;
                //    console.log(me.categoriasActivos);
                   
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            countDownChanged (dismissCountDown) {
            this.dismissCountDown = dismissCountDown
            },
            countDownChanged1 (dismissCountDown1) {
            this.dismissCountDown1 = dismissCountDown1
            },

            showAlert () {
            this.dismissCountDown = this.dismissSecs
            },
            listarCargo(){
                let me=this;
                var url='/user/cargo';
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.CargoUser=respuesta.cargo;
                   
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

        register () {

            this.$validator.validateAll().then(() => {
              
            }).catch(() => {
                alert(this.errors.all())
            })

            },

            listarCategoria(page,activo,buscar,criterio){
                let me=this;
                var url='/categoria?page=' + page +'&idActivo='+activo +'&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.arrayCategoria=respuesta.categorias.data;
                   me.pagination=respuesta.pagination;
                   console.log(me.pagination);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,activo,buscar,criterio){
                // console.log(page,activo,buscar,criterio);
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarCategoria(page,activo,buscar,criterio);
            },
            nombreCate(){
                for (let index = 0; index < this.arrayCategoria.length; index++) {
                            const element = this.arrayCategoria[index].ctcatego_desc;
                            
                            if (element == this.descripcion) {
                                this.mesaFalNu=1;
                                    document.getElementById('xyz').play();
                                    this.mesaFalNu=0;
                                    swal({
                                            type:'error',
                                            title:'Error...',
                                            text:'Ya existe el Nombre de Categoria: '+this.descripcion+'',
                                    })
                                    this.descripcion="";
                            }
                    }
            },

            registrarCategoria(){

                this.nombreCate()

                if (
                    this.descripcion=='') {

                    }
                else if(this.mesaFalNu==1){}
                
                else{
                    let me=this;
                    this.dismissCountDown = this.dismissSecs;

                axios.post('/categoria/registrar',{
                    'ctcatego_desc':this.descripcion,
                    'fechatualizacion':moment(this.fechaActualizacion).format('YYYY-MM-DD hh:mm:ss'),

                })
                
                .then(function (response) {
                //    me.cerrarModal();
                    me.descripcion='';
                   me.modallg=false;
                   me.listarCategoria(1,1,'','ctcatego_desc');
                   me.success = true;
                   me.descripcion='';
                   me.errores=[];
                   
                   
                })
                
                .catch((error) => {

                    let interval = setInterval(function(){
                        me.errorResponse=error.response.data.errors.ctcatego_desc[0]
                        }, 0);
                        setTimeout(function(){ 
                            clearInterval(interval); 
                            me.errorResponse='';
                        }, 2000);
                    console.log(error);
                    this.success = false;

                    });

                
                }

                
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
                           
                            me.listarCategoria(1,1,'','ctcatego_desc');
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
                           
                            me.listarCategoria(1,0,'','ctcatego_desc');
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
            validarCategoria(){
                this.errorCategoria=0;
                this.errorMostrarMsjCategoria=[];
              
                if (!this.descripcion)
                 this.errorMostrarMsjCategoria.push("La descripción esta vacía,rellene por favor") ;
                this.$validator.validateAll().then(() => {})
                if (this.errorMostrarMsjCategoria.length) this.errorCategoria=1; 
                return this.errorCategoria;
            },


            actualizarCategoria(){
                 if (this.validarCategoria()){
                    return;
                }
                let me=this;
                this.dismissCountDown1 = this.dismissSecs1;
                axios.patch('/categoria/actualizar',{
                    'ctcatego_desc':this.descripcion,
                    'idCategoria':this.categoria_id
                }).then(function (response) {
                //    me.cerrarModal();
                   me.modallg=false;
                  
                   me.listarCategoria(1,me.Activo,'','ctcatego_desc');
                   me.descripcion='';
                   me.successAct = response.data;
                    // console.log( me.successAct);
                })
                .catch(function (error) {
                    let interval = setInterval(function(){
                        me.errorResponse=error.response.data.errors.ctcatego_desc[0]
                        }, 0);
                        setTimeout(function(){ 
                            clearInterval(interval); 
                            me.errorResponse='';
                        }, 2000);
                    console.log(error);
                });
            },
            cerrarModal(){
                
                 if (this.descripcion !=='') {
                      Swal({
                        title: '¿Seguro que quieres cerrar esta ventana?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                        if (result.value) {
                        this.modallg=false;
                        this.modal=0;
                        this.tituloModal='';
                        this.descripcion='';
                        this.errores=[];
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                           
                        }
                        })
                         
                    }else{
                        this.modallg=false;
                        this.modal=0;
                        this.tituloModal='';
                        this.descripcion='';
                        this.errores=[];
                    }
                  
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "categoria":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Registrar Categoria'
                                    this.descripcion='';
                                    this.tipoAccion=1;
                                    this.errores=[];
                                    break;
                                }
                                case 'actualizar':{
                                    
                                    this.modal=1;
                                    this.tituloModal='Actualizar Categoria'
                                    this.tipoAccion=2;
                                    this.categoria_id=data['ctcatego_id'];
                                    this.descripcion=data['ctcatego_desc'];
                                    break;
                                }
                              
                            }
                        }                       
                }
            }
        },
        mounted() {
            this.listarCargo();
            this.listarCategoria(1,1,this.buscar,this.criterio);
            // this.traerCategoria(this.Activo);
            
            
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
    .alert-danger {
    color: red;
    }
    .has-error {
    border-color: red;
    }
    .flotante{
        right: 20px;
        position: absolute;
        top: 45px;
    }
   
</style>
