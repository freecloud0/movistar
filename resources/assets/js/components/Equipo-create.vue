<template>
        <main class="main">
            <!-- Breadcrumb -->
           
                        <b-btn class="float-right btn-sm" v-b-modal.modallg variant="primary" @click="abrirModal('categoria','registrar')">
                              <i class="icon-plus"></i>&nbsp;Añadir equipo
                        </b-btn>

                    
              
            <!--Inicio del modal agregar/actualizar-->
            
             <div>

                <b-modal v-model="modallg" id="modallg" size="lg" title="Equipo" tabindex="-1" :class="{'mostrar':modal}">
                    
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row"> 
                            <div class="col-md-4">
                                <label class="form-control-label" for="text-input">Código Sap 
                                </label>
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
                                        <label class=" form-control-label">Categoria
                                           
                                        </label>
                                        <b-form-select v-model="categoria" class="mb-3" :state="selectState">
                                            <option :value="0">Seleccione Categoria</option>
                                             <option v-for="categoria in arrayCategoria" :key="categoria.ctcatego_id" :value="categoria.ctcatego_id" v-text="categoria.ctcatego_desc"></option>
                                        </b-form-select>
                                        <b-form-invalid-feedback class="mn-t-01" v-show="categoria==0" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                         Rellene este campo
                                        </b-form-invalid-feedback>

                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-control-label" for="text-input">Nombre de Equipo
                                                
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
                                        <label class=" form-control-label" for="text-input">Descripción</label>
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción(Opcional)">
                                        
                                    </div>
                                        <div class="col-md-6">
                                        <label class="form-control-label" for="text-input">Fecha</label>
                                        <datepicker v-model="fechaActualizacion" format="dd/MM/yyyy" input-class="form-control">
                                        </datepicker>
                                    </div>

                                </div>
                            
                            </div>
                        </div>
                       
                        <div v-show="errorCategoria" class="form-group row div-error" >
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>  
                    </form>
                    
                        <div slot="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" :disabled="errorR" class="btn btn-primary btn-sm" @click="registrarEquipo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" :disabled="errorR" class="btn btn-primary btn-sm" @click="actualizarEquipo()">Actualizar</button>
                        </div>
                </b-modal>


                <b-modal v-model="modallg1" id="modallg1" size="lg" title="Lista de Productos" tabindex="-1" :class="{'mostrar':modal}">
                    
                        <div>
                            <b-row>
                               <b-col md="6" class="my-1">
                                   <b-form-group horizontal label="Busqueda" class="mb-0">
                                   <b-input-group>
                                       <b-form-input v-model="filter" placeholder="Buscar ..." />

                                   </b-input-group>
                                   </b-form-group>
                               </b-col>

                               <b-col md="6" class="my-1">
                                   <b-form-group horizontal label="Paginas" class="mb-0">
                                   <b-form-select :options="pageOptions" v-model="perPage" />
                                   </b-form-group>
                               </b-col>
                               </b-row>
                               <br>
                            <b-table show-empty
                                       class="table-bordered  "
                                       stacked="md"
                                       :items="arrayListarProducto"
                                       :fields="fields"
                                       :current-page="currentPage"
                                       :per-page="perPage"
                                       :filter="filter"
                                       :sort-by.sync="sortBy"
                                       :sort-desc.sync="sortDesc"
                                       :sort-direction="sortDirection"
                                       @filtered="onFiltered"
                               >
                               </b-table>
                               <b-row>
                               <b-col md="6" class="my-1">
                                   <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
                               </b-col>
                               </b-row>
                                
                   
                       
                        </div>
                        <div slot="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal1()">Cerrar</button>
                        
                        </div>
                </b-modal>

            </div>
            
           
            <!--Fin del modal-->
     
           
        </main>
</template>

<script>
    const items = [
]
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        
        data(){
            return{
                
                dismissSecs1: 5,
                dismissCountDown1: 0,
                dismissSecs: 5,
                dismissCountDown: 0,
               items: items,
               fields: ['Número de Serie','Usuario'],
               currentPage: 1,
               perPage: 5,
               totalRows: items.length,
               pageOptions: [ 5, 10, 15 ],
               sortBy: null,
               sortDesc: false,
               sortDirection: 'asc',
               filter: null,
               modalInfo: { title: '', content: '' },
                modallg1:false,
                modallg:false,
                equipo_id:'',
                categoria:0,
                undmedida:0,
                descripcion:'',
                fechaActualizacion:new Date(),
                arrayEquipo:[],
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
                criterio1:'ctdetpr_sap',
                buscar:'',
                buscar1:'',
                arrayCategoria:[],
                arrayMedida:[],
                nombre:'',
                descripcion:'',
                fecha:'',
                sap:'',
                stock:'',
                undmedida:'',
                arrayListarProducto:[],
                errores:[],
                success:false,
                successAct:false,
                // errorR:''
            }
        },
        components:{
            Datepicker
        },
        
        computed:{
            errorR(){

                if (this.sap.length > 2 && 
                    this.categoria>0 &&
                    this.nombre.length >2 ){
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
            //alertas tiempo
            countDownChanged (dismissCountDown) {
            this.dismissCountDown = dismissCountDown
            },
            showAlert () {
            this.dismissCountDown = this.dismissSecs
            },
            countDownChanged1 (dismissCountDown1) {
            this.dismissCountDown1 = dismissCountDown1
            },

            info (item, index, button) {
               this.modalInfo.title = `Row index: ${index}`
               this.modalInfo.content = JSON.stringify(item, null, 2)
               this.$root.$emit('bv::show::modal', 'modalInfo', button)
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
                cargarPdf(){
                window.open('http://localhost:8000/producto/listarPdfE','_blank');
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
                        // console.log(response);
                        var respuesta=response.data;
                        me.arrayListarProducto=respuesta.produmaster;
                        
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                    // let me=this;
                    //         axios.patch('/producto/master/desactivar',{
                                
                    //             'idProducto':idEquipo
                    //         }).then(function (response) {
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
                me.listarEquipo(page,buscar,criterio); 
            },
            nombreui(){
                for (let index = 0; index < this.arrayEquipo.length; index++) {
                            const element = this.arrayEquipo[index].ctproduc_nombre;
                            
                            if (element == this.nombre) {
                                this.mesaFalNu=1;
                                
                                    this.mesaFalNu=0;
                                    

                                    swal({
                                            type:'error',
                                            title:'Error...',
                                            text:'Ya existe el Nombre de Equipo: '+this.nombre+'',
                                    })
                                    this.nombre="";
                            }
                    }
            },

            ncodeSap(){
                for (let index = 0; index < this.arrayEquipo.length; index++) {
                            const element = this.arrayEquipo[index].sap;
                            
                            if (element == this.sap) {
                                this.mesaSap=1;
                                
                                    this.mesaSap=0;
                                    

                                    swal({
                                            type:'error',
                                            title:'Error...',
                                            text:'Ya existe el Sap : '+this.sap+'',
                                            
                                    })
                                    this.sap="";
                            }
                    }
            },
            registrarEquipo(){
                    this.nombreui();
                    this.ncodeSap();

                  if (
                    this.categoria==0
                    ||this.sap==''
                    ||this.nombre=='') {
                       
                    }
                    else if (this.mesaFalNu== 1 ||this.mesaSap== 1) {
                            
                        }  
                  
                    else{
                    let me=this;
                    this.dismissCountDown = this.dismissSecs;

                    axios.post('/producto/master/registrar',{
                        'sap':this.sap,
                        'nombre':this.nombre,
                        'descripcion':this.descripcion,
                        'categoria':this.categoria,
                        'stock':this.stock,
                        'fecha':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),

                    }).then(function (response) {
                        me.success = true;
                        me.modallg=false;
                        me.listarEquipo(1,'','ctproduc_nombre');
                    })
                    .catch((error) => {

                         this.errores = error.response.data.errors;
                         this.success = false;
                    
                    });
              }
            },
            
            desactivarEquipo(idEquipo){
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
                            axios.patch('/producto/master/desactivar',{
                                
                                'idProducto':idEquipo
                            }).then(function (response) {
                           
                            me.listarEquipo(1,'','ctproduc_nombre');
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
             activarEquipo(idEquipo){
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
                            axios.patch('/producto/master/activar',{
                                
                                'idProducto':idEquipo
                            }).then(function (response) {
                           
                            me.listarEquipo(1,'','ctproduc_nombre');
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
            actualizarEquipo(){
                //  if (this.validarCategoria()){
                //     return;
                // }
                let me=this;
                this.dismissCountDown1 = this.dismissSecs1;
                axios.patch('/producto/master/actualizar',{
                     'sap':this.sap,
                    'nombre':this.nombre,
                    'descripcion':this.descripcion,
                    'categoria':this.categoria,
                    'unidadMedida':this.undmedida,
                    'stock':this.stock,
                    'fecha':moment(this.fecha).format('YYYY-MM-DD hh:mm:ss'),
                    'idProducto':this.equipo_id
                }).then(function (response) {
                   me.modallg=false;
                   me.successAct = response.data;
                   me.listarEquipo(1,'','ctproduc_nombre');
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
                
            },
            cerrarModal1(){
                 this.modallg1=false;
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
                // this.listarProducto(this.buscar1,this.criterio1)
            }
        },
        mounted() {
            this.listarCargo();
            // this.listarProducto(1,this.buscar1,this.criterio1);
            this.listarEquipo(1,this.buscar,this.criterio);
            
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
    .mn-t-01{
        margin-top: -10px!important;
    }
    .flotante{
        right: 20px;
        position: absolute;
        top: 45px;
    }
</style>
