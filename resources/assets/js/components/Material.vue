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
                        <i class="fa fa-align-justify"></i> Materiales
                        
                        <b-btn class="float-right btn-sm" v-b-modal.modallg variant="primary" @click="abrirModal('categoria','registrar')">
                              <i class="icon-plus"></i>&nbsp;Nuevo
                        </b-btn>
                    </div>
                    <div class="card-body">
                       
                            <div class="row">
                                <div class="col-md-3">
                                        <select class="form-control mt-2" v-model="criterio">
                                            <option value="ctproduc_nombre">Descripción</option>
                                            <option value="sap">SAP</option>
                                        </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="md-form input-group mt-0 mb-3">
                                        <input type="text" v-model="buscar"  @keyup="listarMaterial(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <div class="input-group-append">
                                            <button type="submit" :disabled="buscar == ''" @click="listarMaterial(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                Busqueda<i class="ml-2 fa fa-search"></i> 
                                        </button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <br>

                            <div v-if="success" class="flotante" :class="['label label-success']">
                                <b-alert :show="dismissCountDown"
                                        dismissible
                                        variant="success"
                                        @dismissed="dismissCountDown=0"
                                        @dismiss-count-down="countDownChanged">
                                <span  >Registrado Correctamente!</span>
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

                        <div class="table-responsive">
                            <table class="table table-bordered  table-sm">
                                <thead class="blue white-text text-center">
                                    <tr>
                                        <th>Categoria</th>
                                        <th>Producto</th>
                                        <th>Uni. Medida</th>
                                        <th>SAP</th>
                                        <th>Stock Disponible</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th v-if="CargoUser==1">Opciones</th>
                                        <th v-if="CargoUser==1">Estado</th>
                                    
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="material in arrayMaterial" :key="material.idCategoria"  >
                                        <!-- <td v-text="categoria.idCategoria" ></td> -->
                                        <td v-text="material.ctcatego_desc"></td>
                                        <td v-text="material.ctproduc_nombre"></td>
                                        <td v-text="material.ctundmd_desc"></td>
                                        <td v-text="material.sap"></td>
                                        <td class="text-center">
                                                {{material.ctproduc_stock}}
                                                <b-progress :value="material.ctproduc_stock"
                                                            :variant="estadoS(material.ctproduc_stock)">
                                                            
                                            
                                                </b-progress>
                                        </td>
                                        <td v-text="material.ctproduc_fecha_act"></td>
                                        <td v-text="material.ctproduc_usuario"></td>
                                        <td v-if="CargoUser==1">
                                            
                                            <b-btn v-b-modal.modallg variant="warning btn-sm" @click="abrirModal('categoria','actualizar',material)">
                                                    <i class="icon-pencil"></i>
                                            </b-btn>

                                            
                                            
                                        </td>
                                        
                                        <td v-if="CargoUser==1">
                                            <div v-if="material.estado">
                                                <button type="button" class="btn btn-success btn-sm" @click="desactivarMaterial(material.ctproduc_id)">
                                                        Activo
                                                </button>
                                            </div>
                                            <div v-else>
                                                <button type="button" class="btn btn-danger btn-sm" @click="activarMaterial(material.ctproduc_id)">
                                                        Inactivo
                                                </button>
                                            </div>
                                            
                                        </td>
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
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <b-modal v-model="modallg" id="modallg" size="lg" title="Materiales" tabindex="-1" :class="{'mostrar':modal}">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                        <div class="col-md-4">
                            <label class="form-control-label" for="text-input">Código Sap
                            </label>
                                <span v-if="errores.sap" :class="['label label-danger']">{{ errores.sap[0] }}</span>
                                <span v-if="success" :class="['label label-success']">Registrado Correctamente!</span>

                            <b-form-input   id="inputLive"
                                            v-model.trim="sap"
                                            type="text"
                                            :state="nameState"
                                            placeholder="">
                            </b-form-input>
                            <b-form-invalid-feedback v-show="sap==''" id="inputLiveFeedback">
                            <!-- This will only be shown if the preceeding input has an invalid state -->
                            Rellene este campo
                            </b-form-invalid-feedback>

                            <b-form-invalid-feedback v-if="errores.sap" id="inputLiveFeedback">
                            <!-- This will only be shown if the preceeding input has an invalid state -->
                            Ya existe este campo
                            </b-form-invalid-feedback>

                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label">Categoria
                                        
                                    </label>
                                    <b-form-select v-model="categoria" class="mb-3" :state="selectState">
                                        <option :value="0">Seleccione </option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.ctcatego_id" :value="categoria.ctcatego_id" v-text="categoria.ctcatego_desc"></option>
                                    </b-form-select>
                                    <b-form-invalid-feedback class="mn-t-01" v-show="categoria==0" id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                    </b-form-invalid-feedback>   
                                </div>

                                <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Nombre
                                </label>
                                    <b-form-input   id="inputLive"
                                                    v-model.trim="nombre"
                                                    type="text"
                                                    :state="equipoState"
                                                    placeholder="">
                                    </b-form-input>
                                    <b-form-invalid-feedback v-show="nombre==''" id="inputLiveFeedback">
                                    <!-- This will only be shown if the preceeding input has an invalid state -->
                                    Rellene este campo
                                    </b-form-invalid-feedback>

                                </div>

                                <div class="col-md-6">
                                        <label class="form-control-label">Unidad de medida
                                           
                                        </label>       
                                        <b-form-select v-model="undmedida" class="mb-3" :state="selUniState">
                                        <option :value="0">Seleccione</option>
                                            <option v-for="medida in arrayMedida" :key="medida.ctundmd_code" :value="medida.ctundmd_code" v-text="medida.ctundmd_desc"></option>
                                        </b-form-select>
                                        <b-form-invalid-feedback class="mn-t-01" v-show="undmedida==0" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                            Rellene este campo
                                        </b-form-invalid-feedback>  
                                </div>

                                <div class="col-md-6">
                                    <label class="form-control-label" for="text-input">Stock</label>
                                    <b-form-input   id="inputLive"
                                                    v-model.trim="stock"
                                                    type="number"
                                                    :state="stocktState"
                                                    placeholder="">
                                    </b-form-input>
                                    
                                </div>

                                <div class="col-md-6">
                                    <label class="form-control-label" for="text-input">Descripción</label>
                                    <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción(Opcional)">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-control-label" for="text-input">Fecha</label>
                                    <datepicker v-model="fecha" format="dd/MM/yyyy" input-class="form-control">
                                    </datepicker>
                                </div>  
                            </div>

                        </div>
                    </div>    
                </form>
                
                    <div slot="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" :disabled="errorR" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarMaterial()">Guardar</button>
                        <button type="button" :disabled="errorR" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarMaterial()">Actualizar</button>
                    </div>
            </b-modal>
            <!--Fin del modal-->
     
        </main>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        
        data(){
            return{
                success01:'success',
                warning01:'warning',
                danger:'danger',
                value:10,
                dismissSecs1: 5,
                dismissCountDown1: 0,
                dismissSecs: 5,
                dismissCountDown: 0,
                modallg:false,
                equipo_id:'',
                categoria:0,
                undmedida:0,
                descripcion:'',
                arrayMaterial:[],
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
                criterio:'ctproduc_nombre',
                buscar:'',
                arrayCategoria:[],
                arrayMedida:[],
                nombre:'',
                descripcion:'',
                fecha:'',
                sap:'',
                stock:'',
                undmedida:'',
                errores:[],
                 success:false,
                 successAct:false,
                 CargoUser:0
            }
        },
        components:{
            Datepicker
        },
        
        computed:{
            errorR(){

                if (this.nombre.length > 2 && 
                    this.sap.length > 2 &&
                    this.categoria > 0 &&
                    this.stock > 0 &&
                    this.undmedida > 0
                    ){
                    return false
                }
                else{
                    return true
                }
                // return this.sap > 2? false : true
            },
            equipoState () {
            return this.nombre.length > 2 ? true : false
            },
            nameState () {
            return this.sap.length > 2 ? true : false
            },
            selectState () {
            return this.categoria > 0 ? true : false
            },
            stocktState () {
            return this.stock > 0 ? true : false
            },
            selUniState () {
            return this.undmedida > 0 ? true : false
            },



            //otras
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
            estadoS(val){

                if(val<=10){
                    return 'danger'
                }
                else if(val>10 && val<=15){
                    return 'warning'
                }
                else{
                    return 'success'
                }

                // :variant="{danger01:material.ctproduc_stock<=10,
                // warning01:material.ctproduc_stock>10 && material.ctproduc_stock<=15,
                // success01:material.ctproduc_stock>15
            },
            //alertas tiempo
            countDownChanged (dismissCountDown) {
            this.dismissCountDown = dismissCountDown
            },
            countDownChanged1 (dismissCountDown1) {
            this.dismissCountDown1 = dismissCountDown1
            },
            showAlert () {
            this.dismissCountDown = this.dismissSecs
            },

            //otras
            listarMaterial(page,buscar,criterio){
                let me=this;
                var url='/producto/masterm?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.arrayMaterial=respuesta.produmaster.data;
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
                    // handle success;
                    //   console.log(response);
                   var respuesta=response.data;
                   me.arrayCategoria=respuesta.categorias;
                  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectMedida(){
                 let me=this;
                 var url='/medida/selectMedida';
               axios.get(url).then(function (response) {
                    // handle success;
                    //   console.log(response);
                   var respuesta=response.data;
                   me.arrayMedida=respuesta.medidas;
                  
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
                me.listarCategoria(page,buscar,criterio);
            },
            registrarMaterial(){
                if (
                    this.categoria==0
                    ||this.sap==''
                    ||this.nombre==''
                    ||this.undmedida==0) {

                    }else{
                let me=this;
                this.dismissCountDown = this.dismissSecs;

                axios.post('/producto/masterm/registrar',{
                    'sap':this.sap,
                    'nombre':this.nombre,
                    'descripcion':this.descripcion,
                    'categoria':this.categoria,
                    'unidadMedida':this.undmedida,
                    'stock':this.stock,
                    'fecha':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),

                }).then(function (response) {
                       me.success = true;
                       me.modallg=false;
                //    me.cerrarModal();
                   me.listarMaterial(1,'','ctproduc_desc');
                })
                .catch((error) => {
                         this.errores = error.response.data.errors;
                         this.success = false;
                    });
                    }
            },
            desactivarMaterial(idEquipo){
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
                            axios.patch('/producto/masterm/desactivar',{
                                
                                'idProducto':idEquipo
                            }).then(function (response) {
                           
                            me.listarMaterial(1,'','ctproduc_desc');
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
             activarMaterial(idEquipo){
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
                            axios.patch('/producto/masterm/activar',{
                                
                                'idProducto':idEquipo
                            }).then(function (response) {
                           
                            me.listarMaterial(1,'','ctproduc_desc');
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
              
                if (!this.descripcion) this.errorMostrarMsjCategoria.push("La descripción esta vacía,rellene por favor") ;
                if (this.errorMostrarMsjCategoria.length) this.errorCategoria=1; 
                return this.errorCategoria;
            },
            actualizarMaterial(){
                //  if (this.validarCategoria()){
                //     return;
                // }
                let me=this;
                this.dismissCountDown1 = this.dismissSecs1;
                axios.patch('/producto/masterm/actualizar',{
                     'sap':this.sap,
                    'nombre':this.nombre,
                    'descripcion':this.descripcion,
                    'categoria':this.categoria,
                    'unidadMedida':this.undmedida,
                    'stock':this.stock,
                    'fecha':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),
                    'idProducto':this.equipo_id
                }).then(function (response) {
                //    me.cerrarModal();
                   me.modallg=false;
                   me.successAct = response.data;
                   me.listarMaterial(1,'','ctproduc_desc');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){


                  if (this.categoria !==0||this.undmedida !==0
                 ||this.stock !== 0||this.sap !==''||this.nombre !=='') {
                      Swal({
                        title: '¿Seguro que quieres cerrar esta ventana?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                        if (result.value) {
                         this.modallg=false;
                         this.fecha=new Date();
                         this.errores=[];
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                           
                        }
                        })
                         
                    }else{
                       
                        this.modallg=false;
                         this.fecha=new Date();
                         this.errores=[];
                    }

                // this.modallg=false;
                // this.modal=0;
                // this.tituloModal='';
                // this.categoria=0;
                // this.undmedida=0;
                // this.stock=0;
                // this.sap='';
                // this.nombre='';
                // this.descripcion='';
                // this.fecha=new Date();
                // this.errores=[];
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "categoria":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Registrar Categoria'
                                    this.categoria=0;
                                    this.undmedida=0;
                                    this.stock=0;
                                    this.sap='';
                                    this.nombre='';
                                    this.descripcion='';
                                    this.fecha=new Date();
                                    this.tipoAccion=1;
                                    this.errores=[];
                                    break;
                                }
                                case 'actualizar':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Categoria'
                                    this.tipoAccion=2;
                                    this.sap=data['sap'];
                                    this.nombre=data['ctproduc_nombre'];
                                    this.descripcion=data['ctproduc_desc'];
                                    this.stock=data['ctproduc_stock'];
                                    this.equipo_id=data['ctproduc_id'];
                                    this.categoria=data['ctcatego_id'];
                                    this.undmedida=data['ctundmd_code'];
                                    this.descripcion=data['ctcatego_desc'];
                                    this.fecha=data['ctproduc_fecha_act'];
                                    break;
                                }
                              
                            }
                           
                        }  
                                     
                }
                this.selectMedida();
                this.selectCategoria();
            }
        },
        mounted() {
            this.listarCargo();
            this.listarMaterial(1,this.buscar,this.criterio);
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
     .flotante{
        right: 20px;
        position: absolute;
        top: 45px;
    }
</style>
