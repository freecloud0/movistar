<template>
        <main class="main">
            
            <b-btn  class="float-right btn-sm" 
                                v-b-modal.modallg variant="primary"
                                v-b-tooltip.hover title="Agregar Categoria" 
                                @click="abrirModal('categoria','registrar')">
                              <i class="icon-plus mr-2"></i>&nbsp;Añadir Categoria
                        </b-btn>

                <b-modal  data-backdrop="static" data-keyboard="false" v-model="modallg" id="modallg" size="lg" title="Categoria" tabindex="-1" :class="{'mostrar':modal}" >
                    
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

                                            <b-form-invalid-feedback v-if="errores.ctcatego_desc" id="inputLiveFeedback">
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
             

            <div>
                
            </div>


            <!--Fin del modal-->
     
           
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
                 CargoUser:0

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

            listarCategoria(page,buscar,criterio){
                let me=this;
                var url='/categoria?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.arrayCategoria=respuesta.categorias.data;
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
                me.listarCategoria(page,buscar,criterio);
            },
            nombreCate(){
                for (let index = 0; index < this.arrayCategoria.length; index++) {
                            const element = this.arrayCategoria[index].ctcatego_desc;
                            
                            if (element == this.descripcion) {
                                this.mesaFalNu=1;
                                
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
                   me.listarCategoria(1,'','ctcatego_desc');
                   me.success = true;
                   me.descripcion='';
                   me.errores=[];
                   
                   
                })
                
                .catch((error) => {

                         this.errores = error.response.data.errors;
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
                           
                            me.listarCategoria(1,'','ctcatego_desc');
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
                           
                            me.listarCategoria(1,'','ctcatego_desc');
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
                  
                   me.listarCategoria(1,'','ctcatego_desc');
                   me.descripcion='';
                   me.successAct = response.data;
                    // console.log( me.successAct);
                })
                .catch(function (error) {
                     
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
            this.listarCategoria(1,this.buscar,this.criterio);
            
            
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important ;
        position: absolute !important;
    }
    /* .mostrar{
        display: list-item !important;
        opacity: 1 !important ;
        position: absolute !important ;
        background-color: #3c29297a !important;
    } */
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
