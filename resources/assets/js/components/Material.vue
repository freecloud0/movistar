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
                        <i class="fa fa-align-justify"></i> Materiales

                        <div class="visible-wE float-right">
                            
                            
                            <button v-b-tooltip.hover title="Imprimir Excel" 
                                    @click="excelExport()"
                                    type="button" class="redondear2 btn-transparent whit-de" >
                                    <i class=" fas fa-file-excel mr-2"></i>Excel
                            </button>
                            <button v-b-tooltip.hover title="Imprimir Pdf" 
                                    @click="pdfExport()"
                                    type="button" class=" redondear2 btn-transparent whit-de" >
                                    <i class=" fas fa-file-pdf mr-2"></i>Pdf
                            </button>
                            <button v-b-tooltip.hover title="Agregar Material" 
                                v-b-modal.modallg
                                @click="abrirModal('categoria','registrar')"
                                type="button" class="redondear2 btn-transparent whit-de " >
                                <i class="fas fa-external-link-alt"></i> Nuevo
                            </button>
                            
                        </div>
                        <div class="visible-rE float-right">
                         
                            <div class="d-flex flex-column text-md-center">

                                <button v-if="vme==0" @click="vme=1"   
                                        type="button" class=" redondear2 btn-transparent" >
                                    <i class="fas fa-cog"></i>
                                </button>
                                <button v-if="vme==1" @click="vme=0"   
                                        type="button" class=" redondear2 btn-transparent" >
                                    <i class="fas fa-cog"></i>
                                </button>
                                

                            </div>

                        </div>


                        
                    </div>
                    <div v-if="vme==1" class="visible-rE  triangulo_eq">

                    </div>
                    <div v-if="vme==1"  class="bg-mee w-100 redondear2 visible-rE mt-2 mb-2 p-2">
                        <div class="mb-2 text-center">
                            <button 
                                    @click="excelExport()"
                                    type="button" class="redondear2 btn-transparent whit-de" >
                                    <i class=" fas fa-file-excel mr-2"></i>Excel
                            </button>
                            <button 
                                    @click="pdfExport()"
                                    type="button" class=" redondear2 btn-transparent whit-de" >
                                    <i class=" fas fa-file-pdf mr-2"></i>Pdf
                            </button>
                            <button 
                                v-b-modal.modallg
                                @click="abrirModal('categoria','registrar')"
                                type="button" class="redondear2 btn-transparent whit-de " >
                                <i class="fas fa-external-link-alt"></i> Nuevo
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">  


                            <div class="col-md-6 busq p-2">
                                <div class="row">
                                    <div class="col-md-4">
                                    <select class="form-control" v-model="criterio">
                                            <option value="ctproduc_nombre">Descripción</option>
                                            <option value="sap">SAP</option>
                                        </select>
                                </div>
                                <div class="my-4 visible-rE"></div>
                                <div class="col-md-7" >
                                    <input type="text" v-model="buscar" @keyup="listarMaterial(1,Activo,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                </div>
                                <div class="col-1 visible-wE">
                                    <button :disabled="buscar == ''" @click="listarMaterial(1,Activo,buscar,criterio)" type="button" class="psoFSal btn green btn-sm ">
                                        <i  class="fa fa-search"></i>
                                    </button>
                                </div>
                                </div>
                                
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 vista-C">
                                    <select class="form-control mt-2"  v-model="Activo" @change="listarMaterial(1,Activo,buscar,criterio)" >
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

                        <div  v-for="(material,Indice) in arrayMaterial" :key="material.idCategoria">
                            
                            <div class="mb-2 bg-grasy card">
                                <div class="header-tableR" >
                                    
                                    <div class="row">
                                        <div class="col">
                                            <div v-if="material.estado" class="triangulo_bottom_Activo">
                                                <div class="text-center b-01 white-text pt-2">
                                                    <i class="fas fa-ellipsis-v fl-rt"></i> {{Indice+1}}
                                                </div> 
                                            </div>

                                            <div v-else class="triangulo_bottom_Inactivo">
                                                <div class="text-center b-01 white-text pt-2">
                                                    <i class="fas fa-ellipsis-v fl-rt"></i> {{Indice+1}}
                                                </div> 
                                            </div>
                                        </div>
                                       
                                        <div class="col" v-show="CargoUser==1">
                                            
                                            <div class="float-right">
                                                <button v-b-tooltip.hover title="Opcion y edicion"  v-b-modal.modallg   @click="abrirModal('categoria','actualizar',material)" type="button" class=" btn-transparent iconOp" >
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                            </div>
                                            <div class="float-right">
                                                <button v-b-tooltip.hover title="Desactivar producto?" v-if="material.estado"  @click="desactivarMaterial(material.ctproduc_id)" type="button" class=" btn-transparent iconOp" >
                                                    <i class="fas fa-toggle-on"></i>
                                                </button>
                                                <button v-b-tooltip.hover title="Activar producto?" v-else  @click="activarMaterial(material.ctproduc_id)" type="button" class=" btn-transparent iconOp" >
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
                                        <div class="col-md-4">
                                            <i class="far fa-circle green-text"></i>
                                            <span class="b-01 ml-2 fontS-18">
                                                {{material.ctproduc_nombre}}
                                            </span>
                                            <div class="ml-4">
                                                <i class="b-01 icoC-text">Sap:</i>
                                                    <span>{{material.sap}}</span>
                                            </div>

                                            
                                        </div>
                                        <div class="col-md-6 text-center">
                                        
                                            {{material.ctproduc_stock}} / 
                                                <span  class="blue-text b-01">{{material.stockMaximo}}
                                                    <a>
                                                    <i class=" ml-2 fas fa-box-open " @click="metodoacStock(material.ctproduc_id,material)"></i>
                                                    </a>
                                                </span>

                                                <span class="green-text b-01">
                                                    {{material.ctundmd_desc}}
                                                </span>
                                               <!-- <b-progress :value="material.ctproduc_stock+tdoT0" -->
                                               <b-progress :value="controlT(material.stockMaximo,material.ctproduc_stock)"
                                                           :variant="estadoS(material.stockMaximo,material.ctproduc_stock)">

                                               </b-progress>
                                        </div>
                                        <div class="col-md-2">
                                           <span>En Uso : </span> {{material.ctproduc_stock_uso}} 
                                           
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <br>

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
                <!-- <label>File Preview
        <input type="file" id="file" ref="file" accept="image/*" v-on:change="handleFileUpload()"/>
      </label> -->
      <!-- <img v-bind:src="imagePreview" v-show="showPreview"/>
      <button v-on:click="submitFile()">Submit</button> -->
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->

            <b-modal no-close-on-esc no-close-on-backdrop v-model="modallg" id="modallg"  title="Materiales" tabindex="-1" :class="{'mostrar':modal}">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Código Sap
                            </label>
                                <!-- <span v-if="errorResponse" :class="['label label-danger']">{{ errorResponse }}</span>
                                <span v-if="success" :class="['label label-success']">Registrado Correctamente!</span> -->

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

                            <b-form-invalid-feedback v-if="errorResponse" id="inputLiveFeedback">
                            <!-- This will only be shown if the preceeding input has an invalid state -->
                            Ya existe este campo
                            </b-form-invalid-feedback>

                        </div>
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
                        <div class="col-md-12">
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
                            <label class="form-control-label" for="text-input">Stock Máximo</label>
                            <b-form-input   id="inputLive"
                                            v-model.trim="stock"
                                            type="number"
                                            :state="stocktState"
                                            placeholder="">
                            </b-form-input>
                            
                        </div>
                        <div class="col-md-12">
                            <label class="form-control-label" for="text-input">Descripción</label>
                            <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción(Opcional)">
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Fecha</label>
                            <datepicker v-model="fecha" format="dd/MM/yyyy" input-class="form-control">
                            </datepicker>
                        </div> 

                    </div>    
                </form>
                
                    <div slot="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" :disabled="errorR" v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="registrarMaterial()">Guardar</button>
                        <button type="button" :disabled="errorR" v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarMaterial()">Actualizar</button>
                    </div>
            </b-modal>
            <!-- <div @click="listaralertas()" id="demo">
               <p>Hola</p>
            </div> -->
            <!-- <ListComment></ListComment> -->
            <!--Fin del modal-->
            <!-- MODAL ACTUALIZAR STOCK -->
            <!-- <b-modal v-model="modalShow">
                <input v-model="stockMactual" type="text">
            </b-modal> -->
            
            <!-- FIN MODAL -->
        </main>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    import ListComment from '../components/Alerta'

    export default {
        
        data(){
            return{
                success01:'success',
                warning01:'warning',
                danger:'danger',
                show:false,
                value:10,
                dismissSecs1: 5,
                dismissCountDown1: 0,
                dismissSecs: 5,
                dismissCountDown: 0,
                modallg:false,
                text1:0,
                vme:0,
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
                CargoUser:0,
                Activo:1,
                stockDisponible:0,
                errorResponse:'',
                dres:0,
                modalShow:false,
                  file: '',
    showPreview: false,
    imagePreview: ''
               
            }
        },
        components:{
            Datepicker,
            ListComment
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
             submitFile(){
        /*
                Initialize the form data
            */
            let formData = new FormData();

            /*
                Add the form data we need to submit
            */
            formData.append('file', this.file);

        /*
          Make the request to the POST /single-file URL
        */
           
            axios.post('importar',{
                    'data':formData,

                }).then(function (response) {
                })
                .catch((error) => {
                     });
                    
            },
            handleFileUpload(){
                /*
                Set the local file variable to what the user has selected.
                */
                this.file = this.$refs.file.files[0];

                /*
                Initialize a File Reader object
                */
                let reader  = new FileReader();

                /*
                Add an event listener to the reader that when the file
                has been loaded, we flag the show preview as true and set the
                image to be what was read from the reader.
                */
                reader.addEventListener("load", function () {
                this.showPreview = true;
                this.imagePreview = reader.result;
                }.bind(this), false);

                /*
                Check to see if the file is not empty.
                */
                if( this.file ){
                /*
                    Ensure the file is an image file.
                */
                if ( /\.(jpe?g|png|gif|xls)$/i.test( this.file.name ) ) {
                    /*
                    Fire the readAsDataURL method which will read the file in and
                    upon completion fire a 'load' event which we will listen to and
                    display the image in the preview.
                    */
                    reader.readAsDataURL( this.file );
                }
                }
            },
            listaralertas(){
                console.log(ListComment.methods);
            },
            RestSt(material,Indice){
                this.dres=1
                this.text1= Indice+1
                
            },
            editAra(material){
                material.editing =true;
            },
            

            controlT(val,val2){
               let resul = 0
           //  return val-val2;
               resul= val2 *100/val ;
               return resul;

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
            estadoS(val,val2){
               let resul = 0
           //  return val-val2;
               resul= val2 *100/val ;



               if(resul<=15){
                   return 'danger'
               }
               else if(resul>15 && resul<=35){
                   return 'warning'
               }
               else{
                   return 'success'
               }

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
            listarMaterial(page,activo,buscar,criterio){
                let me=this;
                var url='/producto/masterm?page=' + page +'&activo='+activo+ '&buscar='+ buscar + '&criterio=' + criterio;
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
            metodoacStock(id,data=[]){
                var stockMactual=data['stockMaximo'];
                var codigoSap=data['sap'];
                var stockDActual=data['ctproduc_stock'];
                var productoid=data['ctproduc_id'];
                swal.mixin({
                            input: 'text',
                            text:`Stock Máximo Actual: ${stockMactual}`,
                            confirmButtonText: 'Actualizar',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            }).queue([
                            {
                                title: 'Stock Máximo',
                            },
                            ]).then((result) => {
                                if (result.value) {
                                    let cantidad=parseInt(result.value);
                                    if (cantidad>=stockDActual) {
                                        let me=this;
                                            axios.patch('/stock-material-actualizar',{
                                                'idProducto':productoid,
                                                'sap':codigoSap,
                                                'stockA':cantidad

                                            }).then(function (response) {
                                        
                                             me.listarMaterial(1,me.Activo,'','ctproduc_desc');
                                                swal(
                                                    'Actualizado!',
                                                    'Registro Actualizado.',
                                                    'success'
                                                    )       
                                            })
                                            .catch(function (error) {
                                                console.log(error);
                                            });
                                    }else{
                                        document.getElementById('xyz').play();
                                         swal(
                                        'Error!',
                                        `El stock debe ser mayor a ${stockDActual}`,
                                        'error'
                                        ) 
                                    }
                                     
                                }
                            })
                // this.modalShow=true;
                // this.dres=1;
                // this.stockMactual=data['stockMaximo'];
                // // this.stockDisponible=data['ctproduc_stock'];
                // this.equipo_id=data['ctproduc_id'];
                // console.log(id);
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
            cambiarPagina(page,activo,buscar,criterio){
                let me=this;
                //actualiza la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarMaterial(page,activo,buscar,criterio); 
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
                   me.listarMaterial(1,1,'','ctproduc_desc');
                })
                .catch((error) => {
                         let interval = setInterval(function(){
                             me.errorResponse=error.response.data.errors.sap[0]
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
                           
                            me.listarMaterial(1,1,'','ctproduc_desc');
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
                           
                            me.listarMaterial(1,0,'','ctproduc_desc');
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
                 if (this.stock<this.stockDisponible){
                     document.getElementById('xyz').play();
                    swal(`El stock máximo debe ser mayor a ${this.stockDisponible}`)
                }else{
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
                   me.listarMaterial(1,me.Activo,'','ctproduc_desc');
                })
                .catch(function (error) {
                    let interval = setInterval(function(){
                             me.errorResponse=error.response.data.errors.sap[0]
                        }, 0);
                        setTimeout(function(){ 
                            clearInterval(interval); 
                            me.errorResponse='';
                        }, 2000);
                    console.log(error);
                    
                });
             }
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
                                    this.stock=data['stockMaximo'];
                                    this.stockDisponible=data['ctproduc_stock'];
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
            },
             // Exportar En archivo excel metodo
            excelExport(){
                 Swal({
                        title: '¿Desea imprimir?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                        if (result.value) {
                        window.open('/excel-material');
                        }
                    });
               
              
            },
            // Exportar En pdf  metodo
            pdfExport(){
                 Swal({
                        title: '¿Desea imprimir?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        text:'Esto puede tardar por la cantidad de registros'
                        }).then((result) => {
                        if (result.value) {
                        window.open('/materialPDF');
                        }
                    });
               
              
            },

        },
        
        mounted() {
            this.listarCargo();
            this.listarMaterial(1,1,this.buscar,this.criterio);
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
