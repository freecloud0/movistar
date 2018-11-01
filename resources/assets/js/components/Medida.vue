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
                        <i class="fa fa-align-justify"></i> Unidades de Medida
                        <b-btn  class="float-right btn-sm" 
                                v-b-modal.modallg variant="primary"
                                v-b-tooltip.hover title="Agregar Unidad" 
                                @click="abrirModal('medida','registrar')">
                              <i class="icon-plus mr-2"></i>&nbsp;Nuevo
                        </b-btn>

                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                        <select class="form-control mt-2" v-model="criterio">
                                            <option value="ctundmd_desc">Descripción</option>
                                        </select>
                                </div>
                                <div class="col-md-5">
                                    <div class="md-form input-group mt-0 mb-3">
                                        <input type="text" v-model="buscar"  @keyup="listarMedida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <div class="input-group-append">
                                            <button type="submit" :disabled="buscar == ''" @click="listarMedida(1,buscar,criterio)" class="btn green float-right mt-2 btn-sm">
                                                Busqueda<i class="ml-2 fa fa-search"></i> 
                                        </button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <br>
                        <div class="table-reponsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Descripcion</th>
                                    <th>Fecha de registro</th>
                                    <th>Usuario</th>
                                    <th>Opciones</th>
                                    <th>Estado</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>
                              
                                <tr v-for="medida in arrayMedida" :key="medida.idUndMed"  >
                                     
                                    <td v-text="medida.ctundmd_desc"></td>
                                    <td v-text="medida.ctundmd_fecha_act"></td>
                                    <td v-text="medida.ctundmd_usuario"></td>
                                    <td class="text-center">
                                        
                                        <b-btn v-b-modal.modallg variant="warning btn-sm" @click="abrirModal('medida','actualizar',medida)">
                                                Editar
                                        </b-btn>
                                    </td>
                                    <td class="text-center">
                                        <template v-if="medida.estado">
                                            <button type="button" class="btn btn-success btn-sm" @click="desactivarMedida(medida.ctundmd_code)">
                                                    activo
                                            </button>
                                        </template>

                                        <template v-else>
                                            <button type="button" class="btn red btn-sm" @click="activarMedida(medida.ctundmd_code)">
                                                    inactivo
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


            <div>

            <b-modal v-model="modallg" id="modallg" size="lg" title="Unidad de Medida" tabindex="-1" :class="{'mostrar':modal}">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               
                        <div class="row">
                            <div class="col-md-6">
                                
                                <span v-if="success" :class="['label label-success']">Registrado Correctamente!</span>

                                <b-form-group 
                                                label="Descripción"
                                                label-class="text-sm-right"
                                                label-for="nestedState">

                                                <b-form-input   id="inputLive"
                                                            v-model.trim="descripcion"
                                                            type="text"
                                                            :state="desPState"
                                                            placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="descripcion==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>

                                    </b-form-group>
                            </div>

                            <div class="col-md-6">
                                <label class=" form-control-label" for="text-input">Fecha</label>
                                    <datepicker v-model="fecha" format="dd/MM/yyyy" input-class="form-control">
                                    </datepicker>
                            </div>
              
                        </div>      
                    </form>
                
                    <div slot="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="submit" :disabled="errorR02" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarMedida()">Guardar</button>
                        <button type="button" :disabled="errorR02" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarMedida()">Actualizar</button>
                    </div>
            </b-modal>
             

            </div>

        
           
        </main>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        data(){
            return{
                modallg:false,
                medida_id:0,
                descripcion:'',
                fecha:'',
                fechaact:new Date(),
                arrayMedida:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorMedida:0,
                errorMostrarMsjMedida:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },

                offset:3,
                criterio:'ctundmd_desc',
                buscar:'',
                errores:[],
                success:false
            }
        },
         components:{
            Datepicker
        },
        computed:{
            errorR02(){

                if (this.descripcion.length > 2 
                 ){
                    return false
                }
                else{
                    return true
                }
               
            },
            desPState(){
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

            }
        },
        methods:{
            listarMedida(page,buscar,criterio){
                let me=this;
                var url='/medida?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.arrayMedida=respuesta.medidas.data;
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
                me.listarMedida(page,buscar,criterio);
            },
            registrarMedida(){
                if (
                    this.descripcion=='') {

                    }else{
                let me=this;
                axios.post('/medida/registrar',{
                    'ctundmd_desc':this.descripcion,
                    'fecha':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),

                }).then(function (response) {
                   me.cerrarModal();
                   me.listarMedida(1,'','ctundmd_desc');
                   me.errores=[];
                })
                 .catch((error) => {

                         this.errores = error.response.data.errors;
                         this.success = false;
                    
                    });
                    }
            },
            desactivarMedida(idMedida){
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
                            axios.patch('/medida/desactivar',{
                                
                                'idUndMed':idMedida
                            }).then(function (response) {
                           
                            me.listarMedida(1,'','ctundmd_desc');
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
             activarMedida(idMedida){
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
                            axios.patch('/medida/activar',{
                                
                                'idUndMed':idMedida
                            }).then(function (response) {
                           
                            me.listarMedida(1,'','ctundmd_desc');
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
            validarMedida(){
                this.errorMedida=0;
                this.errorMostrarMsjMedida=[];
              
                if (!this.descripcion) this.errorMostrarMsjMedida.push("La descripción esta vacía,rellene por favor") ;
                if (this.errorMostrarMsjMedida.length) this.errorMedida=1; 
                return this.errorMedida;
            },
            actualizarMedida(){
                 if (this.validarMedida()){
                    return;
                }
                let me=this;
                axios.patch('/medida/actualizar',{
                    'descripcion':this.descripcion,
                    'fecha':moment(this.fechaact).format('YYYY-MM-DD hh:mm:ss'),
                    'idUndMed':this.medida_id
                }).then(function (response) {
                   me.cerrarModal();
                   me.listarMedida(1,'','ctundmd_desc');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modallg=false;
                this.modal=0;
                this.tituloModal='';
                this.descripcion='';
                this.fecha=new Date();
                this.errores=[];
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "medida":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Registrar Medida'
                                    this.descripcion='';
                                    this.fecha=new Date();
                                    this.tipoAccion=1;
                                    this.errores=[];
                                    break;
                                }
                                case 'actualizar':{
                                    this.modal=1;
                                    this.tituloModal='Actualizar Medida'
                                    this.tipoAccion=2;
                                    this.medida_id=data['ctundmd_code'];
                                    this.descripcion=data['ctundmd_desc'];
                                    this.fecha=data['ctundmd_fecha_act'];
                                    this.fechaact=new Date();
                                    break;
                                }
                              
                            }
                        }                       
                }
            }
        },
        mounted() {
            this.listarMedida(1,this.buscar,this.criterio);
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
