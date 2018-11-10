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
                        <i class="fa fa-align-justify"></i> Proveedores
                        <b-btn v-b-modal.modallg variant="primary" class="float-right btn-sm"  @click="abrirModal('proveedor','registrar')">
                              <i class="icon-plus"></i>&nbsp;Nuevo
                        </b-btn>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                        <select class="form-control mt-2" v-model="criterio">
                                            <option value="ctprove_nro_ruc">RUC</option>
                                            <option value="ctprove_razon_social">Nombre</option>
                                        </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="md-form input-group mt-0 mb-3">
                                        <input type="text" v-model="buscar"  @keyup="listarProveedor(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <div class="input-group-append">
                                            <button type="submit" :disabled="buscar == ''" @click="listarProveedor(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                Busqueda<i class="ml-2 fa fa-search"></i> 
                                        </button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <br>

                        <div>
                         <div class="table-responsive">
                            <b-table class="table  table-bordered table-striped " :items="(arrayProveedor)" :fields="fields">
                                <template slot="DETALLES" slot-scope="row">
                                <!-- we use @click.stop here to prevent emitting of a 'row-clicked' event  -->
                                <b-button size="sm" @click.stop="row.toggleDetails" class="mr-2">
                                {{ row.detailsShowing ? 'ocultar' : 'Mostrar'}} DETALLES
                                </b-button>
                                
                                <!-- <b-form-checkbox @click.native.stop @change="row.toggleDetails" v-model="row.detailsShowing">
                                    Details via check
                                </b-form-checkbox> -->
                                </template>
                                <template slot="row-details" slot-scope="row">
                                <b-card> 
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Dirección</th>
                                                    <th>Email</th>
                                                    <th>Fecha Registro</th>
                                                    <th>Fecha Actualizado </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ row.item.ctprove_direccion }}</td>
                                                    <td>{{ row.item.ctprove_email }}</td>
                                                    <td>{{ row.item.ctprove_fecha_reg }}</td>
                                                    <td>{{ row.item.ctprove_fecha_act }}</td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </b-card>
                                </template>
                                <template slot="OPCIONES" slot-scope="row">
                                        <b-btn v-b-modal.modallg variant="warning btn-sm" @click="abrirModal('proveedor','actualizar',row.item)">
                                                Editar
                                        </b-btn>
                                </template>
                                <template slot="ESTADO" slot-scope="row">
                                    <div v-if="row.item.estado">
                                            <button type="button" class="btn green btn-sm" @click="desactivarProveedor(row.item.ctprove_code)">
                                                    Activo
                                            </button>
                                        </div>
                                        <div v-else>
                                            <button type="button" class="btn red btn-sm" @click="activarProveedor(row.item.ctprove_code)">
                                                    Inactivo
                                            </button>
                                        </div>
                                </template>
                            </b-table>
                        </div>

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
                <!-- Fin ejemplo de tabla Listado -->
            </div>

        <b-modal v-model="modallg" id="modallg" size="lg" title="Proveedor" tabindex="-1" :class="{'mostrar':modal}">
        <!--Inicio del modal agregar/actualizar-->

                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                    <div class="row">
                        <div class="col-6">
                            <b-card bg-variant="light">
                            <label for="">Proveedor
                                
                            </label>
                           
                             <b-form-input  id="inputLive"
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

                                        <b-form-invalid-feedback v-if="errores.ctprove_razon_social" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ya existe este Proveedor
                                        </b-form-invalid-feedback>
                            <br>

                            <label for="">RUC
                                
                            </label>
                         
                            <b-form-input  id="inputLive1"
                                            v-model.trim="ruc"
                                            type="number"

                                            :state="rucState"
                                            aria-describedby="inputLiveHelp1 inputLiveFeedback1"
                                            placeholder=""
                                            v-validate:numero="'maxlength: 15'">
                                            
                            </b-form-input>
                                        <b-form-invalid-feedback v-show="ruc==''" id="inputLiveFeedback1">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                        </b-form-invalid-feedback>

                                        <b-form-invalid-feedback v-if="errores.ctprove_nro_ruc" id="inputLiveFeedback1">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ya existe este ruc
                                        </b-form-invalid-feedback>
                            </b-card>
                            <b-card bg-variant="light" class="mt-2">
                                <label for="">Fecha de Registro</label>
                                <datepicker v-model="fecha" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>
                            </b-card>
                           
                        </div>
                        <div class="col-6">
                            <b-card bg-variant="light">
                                <label for="">Dirección</label>
                                <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                <br>
                                <label for="">teléfono</label>
                                <input type="number" v-model="telefono" class="form-control" placeholder="Teléfono">
                                <span v-if="errores.ctprove_telefono" :class="['label label-danger']">{{ errores.ctprove_telefono[0] }}</span>
                                
                                <br>
                                <label for="">Email</label>
                                <input type="text" v-model="email" class="form-control" placeholder="Email">
                                <span v-if="errores.ctprove_email" :class="['label label-danger']">{{ errores.ctprove_email[0] }}</span>
                                <br>
                                
                            </b-card>
                        </div>
                    </div>

                    <div v-show="errorProveedor" class="form-group row div-error" >
                        <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjProveedor" :key="error" v-text="error">

                            </div>
                        </div>
                    </div>  
                </form>  
                <div slot="modal-footer">
                    <button type="button"  class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                    <button type="button" :disabled="errorR" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarProveedor()">Guardar</button>
                    <button type="button" :disabled="errorR" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarProveedor()">Actualizar</button>
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
              
                fields: [ 'NOMBRE','RUC','TELEFONO','DETALLES','OPCIONES','ESTADO'],
                modallg:false,
                proveedor_id:0,
                descripcion:'',
                ruc:'',
                direccion:'',
                telefono:'',
                fecha:'',
                fechaact:new Date(),
                email:'',
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorProveedor:0,
                errorMostrarMsjProveedor:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },

                offset:3,
                criterio:'ctprove_nro_ruc',
                
                buscar:'',
                arrayCategoria:[],
                arrayProveedor:[],
                errores:[],
                success:false
            }
        },
        computed:{
            errorR(){

                if (this.descripcion.length > 2 && (
                    this.ruc.length > 11 && this.ruc.length <= 23)
                     ){
                    return false
                }
                else{
                    return true
                }
                // return this.sap > 2? false : true
            },
            nameState () {
            return this.descripcion.length > 2 ? true : false
            },
            rucState () {
            return this.ruc.length > 11 && this.ruc.length <= 23 ? true : false
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
        components:{
            Datepicker,
        },
         
        
        methods:{
            listarProveedor(page,buscar,criterio){
                let me=this;
                var url='/proveedor?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    var respuesta=response.data;
                   me.arrayProveedor=respuesta.proveedores.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
             cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProveedor(page,buscar,criterio);
            },
             registrarProveedor(){
                if (
                    this.categoria==0
                    ||this.descripcion==''
                    ||this.ruc=='') {

                    }else{
                let me=this;
                axios.post('/proveedor/registrar',{
                    'ctprove_razon_social':this.descripcion,
                    'ctprove_nro_ruc':this.ruc,
                    'direccion':this.direccion,
                    'ctprove_telefono':this.telefono,
                    'ctprove_email':this.email,
                    'fechatualizacion':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),

                  
                }).then(function (response) {
                   me.cerrarModal();
                   me.listarProveedor(1,'','ctprove_nro_ruc');
                   me.errores=[];
                })
                .catch((error) => {

                         this.errores = error.response.data.errors;
                         this.success = false;
                    
                    });
                }
            },
              desactivarProveedor(idProveedor){
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
                            axios.patch('/proveedor/desactivar',{
                                
                                'ctprove_code':idProveedor
                            }).then(function (response) {
                           
                            me.listarProveedor(1,'','ctprove_nro_ruc');
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
             activarProveedor(idProveedor){
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
                            axios.patch('/proveedor/activar',{
                                
                                'ctprove_code':idProveedor
                            }).then(function (response) {
                           
                            me.listarProveedor(1,'','ctprove_nro_ruc');
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
            
            validarProveedor(){
                this.errorProveedor=0;
                this.errorMostrarMsjProveedor=[];
              
                if (!this.descripcion) this.errorMostrarMsjProveedor.push("La descripción esta vacía,rellene por favor") ;
                if (!this.ruc) this.errorMostrarMsjProveedor.push("El RUC esta vació,rellene por favor") ;
                if (this.idddpartamento==0) this.errorMostrarMsjProveedor.push("Seleccione un Departamento") ;
                if (this.idprovincia==0) this.errorMostrarMsjProveedor.push("Seleccione una Provincia") ;
                if (this.iddistrito==0) this.errorMostrarMsjProveedor.push("Seleccione un Distrito ") ;
                if (this.errorMostrarMsjProveedor.length) this.errorProveedor=1; 
                return this.errorProveedor;
            },
             actualizarProveedor(){
                //  if (this.validarProveedor()){
                //     return;
                // }
                let me=this;
                axios.patch('/proveedor/actualizar',{
                    'ctprove_code':this.proveedor_id,
                    'descripcion':this.descripcion,
                    'ruc':this.ruc,
                    'email':this.email,
                    'direccion':this.direccion,
                    'telefono':this.telefono,
                    'fecha':moment(this.fechaact).format('YYYY-MM-DD hh:mm:ss'),
                    
                }).then(function (response) {
                   me.cerrarModal();
                   me.listarProveedor(1,'','ctprove_nro_ruc');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             cerrarModal(){
                this.modal=0;
                this.descripcion='';
                this.ruc='';
                this.direccion='';
                this.email='';
                this.fecha= new Date();
                this.telefono='';
                this.modallg=false;
                this.errores=[];
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "proveedor":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Registrar Proveedor'
                                    this.descripcion='';
                                    this.ruc='';
                                    this.direccion='';
                                    this.email='';
                                    this.fecha= new Date();
                                    this.telefono='';
                                    this.tipoAccion=1;
                                    this.errores=[];
                                    break;
                                }
                                case 'actualizar':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Proveedor'
                                    this.proveedor_id=data['ctprove_code'];
                                    this.descripcion=data['NOMBRE'];
                                    this.ruc=data['RUC'];
                                    this.direccion=data['ctprove_direccion'];
                                    this.telefono=data['TELEFONO'];
                                    this.email=data['ctprove_email'];
                                    this.fecha=data['ctprove_fecha_act'];
                                    
                                    this.tipoAccion=2;
                                    
                                    
                                    break;
                                }
                              
                            }
                        }                       
                }
                
            }
           
        },
        
        
         
        mounted() {
            this.listarProveedor(1,this.buscar,this.criterio);
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
