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
                        <i class="fa fa-align-justify"></i> Cargos
                        <button type="button" @click="abrirModal('cargo','registrar')" class="btn btn-secondary float-right btn-sm"  >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                        <select class="form-control mt-2" v-model="criterio">
                                            <option value="ctcargo_nombre">Nombre</option>
                                        </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="md-form input-group mt-0 mb-3">
                                        <input type="text" v-model="buscar"  @keyup="listarCargo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <div class="input-group-append">
                                            <button type="submit" :disabled="buscar == ''" @click="listarCargo(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                Busqueda<i class="ml-2 fa fa-search"></i> 
                                        </button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                     <div v-if="success" class="flotante" :class="['label label-success']">
                                        <b-alert :show="dismissCountDown"
                                                dismissible
                                                variant="success"
                                                @dismissed="dismissCountDown=0"
                                                @dismiss-count-down="countDownChanged">
                                        <span  >Registrado Correctamente!</span>
                                        </b-alert>
                                    </div>

                                    <div v-if="successAct.length > 0" class="flotante">
                                        <b-alert :show="dismissCountDown1"
                                                dismissible
                                                variant="warning"
                                                @dismissed="dismissCountDown1=0"
                                                @dismiss-count-down="countDownChanged1">

                                                <span>{{successAct}}</span>
                                        </b-alert>
                                    </div>
                                </div>
                            </div>
                            <br>
                            

                            

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="text-center">
                                    <tr>
                                    
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Usuario</th>
                                        <th>Opciones</th>
                                        <th>Estado</th>
                                    
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- {{arrayCargo}} -->
                                    <tr v-for="cargo in arrayCargo" :key="cargo.idCargo"  >
                                        
                                        <td v-text="cargo.ctcargo_nombre"></td>
                                        <td v-text="cargo.ctcargo_desc"></td>
                                        <td v-text="cargo.ctcargo_usuario"></td>
                                        <td class="text-center">
                                            <button type="button" @click="abrirModal('cargo','actualizar',cargo)" class="btn btn-warning btn-sm" >
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;
                                            
                                            
                                        </td>
                                        
                                        <td class="text-center">
                                            <template v-if="cargo.estado">
                                                <button type="button" class="btn btn-success btn-sm" @click="desactivarCargo(cargo.ctcargo_code)">
                                                        Activo
                                                </button>
                                            </template>

                                            <template v-else>
                                                <button type="button" class="btn red btn-sm" @click="activarCargo(cargo.ctcargo_code)">
                                                        Inactivo
                                                </button>
                                            </template>
                                            
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
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               <div class="row">
                                   <div class="col-md-6">

                                       <label class="form-control-label" for="text-input">Descripción
                                        </label>
                                        <b-form-input   id="inputLive"
                                                        v-model.trim="descripcion"
                                                        type="text"
                                                        :state="descriState"
                                                        placeholder="">
                                        </b-form-input>
                                        <b-form-invalid-feedback v-show="descripcion==''" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                        </b-form-invalid-feedback>  
                                         <b-form-invalid-feedback v-show="unique.length > 0" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        {{unique}}
                                        </b-form-invalid-feedback>  
                                        <b-form-invalid-feedback v-if="errores.ctcargo_nombre" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ya existe este campo
                                        </b-form-invalid-feedback>
                                   </div>
                                   <div class="col-md-6">
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
                               </div>
                                     
                                                
                               
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                            <button type="button" :disabled="errorR" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarCargo()">Guardar</button>
                            <button type="button" :disabled="errorR" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarCargo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
          
           
        </main>
</template>

<script>
    export default {
        data(){
            return{
                observacion:'',
                cargo_id:0,
                descripcion:'',
                arrayCargo:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorCargo:0,
                errorMostrarMsjCargo:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },

                offset:3,
                criterio:'ctcargo_nombre',
                buscar:'',
                errores:[],
                success:false,
                successAct:'',
                dismissSecs1: 5,
                dismissCountDown1: 0,
                dismissSecs: 5,
                dismissCountDown: 0,
                unique:''
            }
        },
        computed:{
            errorR(){

                if (this.descripcion.length > 2 && 
                    this.observacion.length > 2
                 ){
                    return false
                }
                else{
                    return true
                }
               
            },
            descriState(){
                return this.descripcion.length > 2 ? true : false
            },
            descrpState(){
                    return this.observacion.length > 2 ? true : false
            },
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to  = this.pagination.last_page;
                }
                var pagesArray= [];
                    while (from <= 0) {
                        pagesArray.push(from);
                        from++;
                    }
                    return pagesArray;
                
            }
        },
        methods:{
            listarCargo(page,buscar,criterio){
                let me=this;
                var url='/cargo?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.arrayCargo=respuesta.cargos.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
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
            cambiarPagina(page,buscar,criterio){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarCargo(page,buscar,criterio);
            },
            registrarCargo(){
                let me=this;
                 this.dismissCountDown = this.dismissSecs;
                axios.post('/cargo/registrar',{
                    'ctcargo_nombre':this.descripcion,
                    'observacion':this.observacion

                }).then(function (response) {
                   me.cerrarModal();
                   me.listarCargo(1,'','ctcargo_nombre');
                   me.success = true;
                })
                .catch(function (error) {
                     me.errores = error.response.data.errors;
                    //  console.log(me.errores);
                     me.success = false;
                });
            },
            desactivarCargo(idCargo){
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
                            axios.patch('/cargo/desactivar',{
                                
                                'idCargo':idCargo
                            }).then(function (response) {
                           
                            me.listarCargo(1,'','ctcargo_nombre');
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
             activarCargo(idCargo){
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
                            axios.patch('/cargo/activar',{
                                
                                'idCargo':idCargo
                            }).then(function (response) {
                           
                            me.listarCargo(1,'','ctcargo_nombre');
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
            validarCargo(){
                this.errorCargo=0;
                this.errorMostrarMsjCargo=[];
              
                if (!this.descripcion) this.errorMostrarMsjCargo.push("La descripción esta vacía,rellene por favor") ;
                if (this.errorMostrarMsjCargo.length) this.errorCargo=1; 
                return this.errorCargo;
            },
            actualizarCargo(){
                
                let me=this;
                 this.dismissCountDown1 = this.dismissSecs1;
                axios.patch('/cargo/actualizar',{
                    'ctcargo_nombre':this.descripcion,
                    'observacion':this.observacion,
                    'ctcargo_code':this.cargo_id
                }).then(function (response) {
                   me.cerrarModal();
                   me.listarCargo(1,'','descripcion');
                   me.successAct = response.data;
                })
                .catch(function (error) {
                    me.unique=error.response.data.errors.ctcargo_nombre[0]
                });
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.descripcion='';
                this.observacion='';
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "cargo":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Registrar Cargo'
                                    this.descripcion='';
                                    this.observacion='';
                                    this.tipoAccion=1;
                                    break;
                                }
                                case 'actualizar':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Cargo'
                                    this.tipoAccion=2;
                                    this.cargo_id=data['ctcargo_code'];
                                    this.descripcion=data['ctcargo_nombre'];
                                    this.observacion=data['ctcargo_desc'];
                                    break;
                                }
                              
                            }
                        }                       
                }
            }
        },
        mounted() {
            this.listarCargo(1,this.buscar,this.criterio);
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
</style>
