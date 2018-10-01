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
                        <i class="fa fa-align-justify"></i> Usuarios
                     
                       
                        <button type="button" v-b-modal.modallg01 @click="abrirModal('usuario','registrar')" class="btn btn-primary btn-sm float-right">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>

                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                    <select class="form-control" v-model="criterio">
                                      <option value="ctcolab_dni">DNI</option>
                                      <option value="ctcolab_ap_paterno">Apellidos</option>
                                    </select>
                            </div>
                            <div class="col-md-4">
                               
                                    <input type="text" v-model="buscar" @keyup="listarUsuario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="float-right btn-sm btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                            <div class="col-md-4">
                               
                            </div>
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
                        </div>
                        
                            <div class="table-responsive">
                                <b-table class=" table table-bordered table-striped " :items="(arrayUsuario)" :fields="fields">
                                    <template slot="Detalles" slot-scope="row">
                                    <!-- we use @click.stop here to prevent emitting of a 'row-clicked' event  -->
                                    <b-button size="sm" @click.stop="row.toggleDetails" class="mr-2">
                                    {{ row.detailsShowing ? 'ocultar' : 'Mostrar'}} Detalles
                                    </b-button>
                                    
                                    <!-- <b-form-checkbox @click.native.stop @change="row.toggleDetails" v-model="row.detailsShowing">
                                        Details via check
                                    </b-form-checkbox> -->
                                    </template>
                                
                                    <template slot="row-details" slot-scope="row">
                                    <b-card>
                                        <div class="row">
                                            <div class="col-6">
                                                <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-right"><b>DNI:</b></b-col>
                                                <b-col>{{ row.item.ctcolab_dni }}</b-col>
                                                </b-row>

                                                <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-right"><b>Teléfono:</b></b-col>
                                                <b-col>{{ row.item.ctcolab_telefono }}</b-col>
                                                </b-row>

                                                <b-row class="mb-2">
                                                <b-col sm="3" class="text-sm-right"><b>Celular:</b></b-col>
                                                <b-col>{{ row.item.ctcolab_celular }}</b-col>
                                                </b-row>
                                            </div>
                                            <div class="col-6">
                                                <label for=""> <b>Dirección : </b>{{ row.item.ctcolab_direccion }}</label>
                                                <br>
                                                <label for=""><b>Email-Usuario: </b>{{ row.item.ct}} </label>
                                                
                                            </div>
                                        </div>
                                    </b-card>
                                    </template>
                                    <template slot="Opciones" slot-scope="row">
                                        <!-- <b-btn  data-toggle="modal" data-target="#basicExampleModal" @click="abrirModal('usuario','actualizar',row.item)">
                                            Editar
                                        </b-btn> -->
                                        <button type="button" v-b-modal.modallg01 @click="abrirModal('usuario','actualizar',row.item)" class="btn orange btn-sm" >
                                            Editar
                                        </button>
                                        
                                    </template>
                                    <template slot="estado" slot-scope="row">
                                            <div v-if="row.item.estado">
                                            <button v-b-modal class="btn green btn-sm" @click="desactivarUsuario( row.item.ctusuar_code)">
                                                    Activo
                                            </button>
                                        </div>
                                        <div v-else>
                                            <button v-b-modal class="btn btn-danger btn-sm" @click="activarUsuario( row.item.ctusuar_code)">
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
          
    
                    
              
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!-- Button trigger modal -->

    <b-modal v-model="modallg01"  size="lg"
             title="REGISTRO DE USUARIOS"
             >

        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

            <div v-if="step === 1">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <b-card border-variant="Light"  class="mdb-color lighten-4">
                                <b-form-group 
                                            label="Cargo"
                                            label-class="text-sm-right"
                                            label-for="nestedStreet">
                                            
                                            <b-form-select v-model="idCargo" class="mb-3" :state="selectState">
                                                <option :value="0">Seleccione Categoria</option>
                                                <option v-for="cargo in arrayCargo" :key="cargo.ctcargo_code" :value="cargo.ctcargo_code" v-text="cargo.ctcargo_nombre"></option>
                                            </b-form-select>
                                            <b-form-invalid-feedback class="mn-t-01" v-show="idCargo==0" id="inputLiveFeedback">
                                            <!-- This will only be shown if the preceeding input has an invalid state -->
                                            Selecione un campo
                                            </b-form-invalid-feedback>

                                
                                </b-form-group>
                                    
                                <div v-show="idCargo!=0" >
                                    <hr>

                                    <div class="row">
                                        <div class="col-6">
                                            <b-form-group class="" >
                                            <template slot="label">
                                                <b>Almacen</b><br>
                                                
                                            </template>
                                      
                                            <b-form-checkbox 
                                                v-model="categoriaChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Categoria
                                            </b-form-checkbox>
                                           
                                            <b-form-checkbox 
                                                v-model="equipoChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Equipo
                                            </b-form-checkbox>
                                            
                                            <b-form-checkbox 
                                                v-model="materialChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Material
                                            </b-form-checkbox>
                                         
                                            <b-form-checkbox 
                                                v-model="ingresoChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Ingreso
                                            </b-form-checkbox>
                                           
                                            <b-form-checkbox 
                                                v-model="salidaChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Salida
                                            </b-form-checkbox>
                                            
                                            </b-form-group>
                                        </div>

                                        <div class="col-6">
                                            <b-form-group >
                                                <label for="">
                                                    <b>Almacen Tecnico</b>
                                                </label>
                                       
                                            <b-form-checkbox 
                                                v-model="equipoTecnicoChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Equipo Técnico
                                            </b-form-checkbox>
                                            
                                            <b-form-checkbox 
                                                v-model="materialTecnicoChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Material Técnico
                                            </b-form-checkbox>
                                            </b-form-group>
                                            <hr>
                                            <b-form-group >
                                                <label for="">
                                                    <b>Compras</b>
                                                </label>
                                          
                                            <b-form-checkbox 
                                                v-model="proveedorChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Proveedor
                                            </b-form-checkbox>
                                            </b-form-group>
                                            <hr>
                                            <b-form-group >
                                                <label for="">
                                                    <b>Configuraciones</b>
                                                </label>
                                            
                                            <b-form-checkbox 
                                                v-model="unidadMedidaChecked"
                                                :value="restic"
                                                unchecked-value=0
                                                :disabled="idCargo==1"
                                                >
                                                Und. Medida
                                            </b-form-checkbox>
                                            </b-form-group>
                                        </div>
                                    </div>

                                </div>

                            </b-card>
                        </div>
                        <div class="col-md-6">
                            <b-card bg-variant="light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b-form-group 
                                                label="Apellido Paterno"
                                                label-class="text-sm-right"
                                                label-for="nestedStreet">
                                                
                                                <b-form-input   id="inputLive1"
                                                                v-model.trim="apePater"
                                                                type="text"
                                                                :state="apePState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="apePater==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="col-md-6">
                                            <b-form-group 
                                                label="Apellido Materno"
                                                label-class="text-sm-right"
                                                label-for="nestedCity">

                                                <b-form-input   id="inputLive2"
                                                                v-model.trim="apeMater"
                                                                type="text"
                                                                :state="apeMState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="apeMater==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>
                                    
                                             </b-form-group>
                                        </div>
                                    </div>

                                    <b-form-group 
                                                label="Nombres"
                                                label-class="text-sm-right"
                                                label-for="nestedState">

                                                <b-form-input   id="inputLive"
                                                            v-model.trim="nombres"
                                                            type="text"
                                                            :state="nomState"
                                                            placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="nombres==''" id="inputLiveFeedback">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene este campo
                                                </b-form-invalid-feedback>

                                    </b-form-group>
                                    <b-form-group 
                                                label="DNI"
                                                label-class="text-sm-right"
                                                label-for="nestedCountry">

                                                <b-form-input   id="inputLive3"
                                                                v-model.trim="dni"
                                                                type="number"
                                                                aria-describedby="inputLiveHelp1 inputLiveFeedback1"
                                                                :state="dniState"
                                                                placeholder="">
                                                </b-form-input>
                                                <b-form-invalid-feedback v-show="dni.length != 8" id="inputLiveFeedback1">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Rellene con 8 digitos
                                                </b-form-invalid-feedback>

                                                <b-form-invalid-feedback v-if="errores.ctcolab_dni" id="inputLiveFeedback1">
                                                <!-- This will only be shown if the preceeding input has an invalid state -->
                                                Ya existe este campo
                                                </b-form-invalid-feedback>
                                    
                                    </b-form-group>

                            </b-card>
                        </div> 
                    </div>
               
            </div>
            <div v-if="step === 2">
                <div class="row">
                    <div class="col-md-6">
                        <b-card bg-variant="light">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class=" form-control-label" for="text-input">Direccion</label>
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Av.nom## " >
                                </div>
                                <div class="col-6">
                                    <label class="form-control-label" for="text-input">Teléfono</label>
                                        <input type="text" v-model="telefono" class="form-control"  placeholder="">
                                        <span v-if="errores.ctcolab_telefono" :class="['label label-danger']">{{ errores.ctcolab_telefono[0] }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="form-control-label" for="text-input">Celular</label>
                                        

                                        <b-form-input   id="inputLive5"
                                                        v-model.trim="celular"
                                                        type="text"
                                                        :state="cellState"
                                                        placeholder="">
                                        </b-form-input>
                                        <b-form-invalid-feedback v-show="celular.length===8" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ingrese 9 digitos
                                        </b-form-invalid-feedback>
                                        <b-form-invalid-feedback v-if="errores.ctcolab_celular" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ya existe este Número
                                        </b-form-invalid-feedback>
                                        
                                </div>
                            </div>
                        </b-card>
                        <br>
                        <b-card bg-variant="light">
                            <div class="col-md-12">
                                <label for="">Fecha de Registro</label>
                                <datepicker v-model="fechareg" format="dd/MM/yyyy" input-class="form-control">
                                </datepicker>
                            </div>
                        </b-card>
                    </div>
                    <div class="col-md-6">
                        <b-card bg-variant="light">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class=" form-control-label" for="text-input">Nombre de Usuario</label>
                                    
                                        <b-form-input   id="inputLive5"
                                                        v-model.trim="usuario"
                                                        type="text"
                                                        :state="userState"
                                                        placeholder="">
                                        </b-form-input>
                                        <b-form-invalid-feedback v-show="usuario==''" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                        </b-form-invalid-feedback>
                                        <b-form-invalid-feedback v-if="errores.ctusuar_usuario" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Ya existe este Usuario
                                        </b-form-invalid-feedback>
                                </div>

                                <div class="col-md-12">
                                    <label class=" form-control-label" for="text-input">Email</label>
                                        
                                        <!-- <span v-if="errores.ctusuar_email" :class="['label label-danger']">{{ errores.ctcolab_celular[0] }}</span> -->
                                        <b-form-input   id="inputLive6"
                                                        v-model.trim="emailC"
                                                        type="email"
                                                        :state="mailState"
                                                        placeholder="">
                                        </b-form-input>
                                        <b-form-invalid-feedback v-show="emailC==''" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                        </b-form-invalid-feedback>
                                </div>
                                
                                <div class="col-md-12">
                                    <label class=" form-control-label" for="text-input">Contraseña</label>
                                        <b-form-input   id="inputLive7"
                                                        v-model.trim="password"
                                                        type="password"
                                                        :state="contraState"
                                                        placeholder="">
                                        </b-form-input>
                                        <b-form-invalid-feedback v-show="password==''" id="inputLiveFeedback">
                                        <!-- This will only be shown if the preceeding input has an invalid state -->
                                        Rellene este campo
                                        </b-form-invalid-feedback>
                                </div>
                               
                            </div>
                        </b-card>
                    </div>
                </div>    
                    
                
            </div>
        
        </form>

        <div v-if="step01 === 1" slot="modal-footer" class="w-100">
            <p class="red-text mr-2" v-if="tipoAccion==1">{{nell}}</p>   
            <button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btn-sm float-right" :disabled="errorR" @click.prevent="next()">Siguiente</button>
        </div>
        <div v-if="step01 === 2" slot="modal-footer" class="w-100">
            <button type="button" class="btn btn-secondary btn-sm float-left" @click.prevent="prev()">Atras</button>
            <button type="button" v-if="tipoAccion==2" :disabled="errorR02" class="btn btn-primary btn-sm float-right" @click="actualizarUsuario()">Actualizar</button>
            <button type="button" v-if="tipoAccion==1" :disabled="errorR02" class="btn btn-primary btn-sm float-right" @click="registrarUsuario()">Guardar</button>
        </div>
        <!-- <div v-if="step01 === 3" slot="modal-footer" class="w-100">
            <button type="button" class="btn btn-secondary btn-sm float-left" @click.prevent="prev()">Atras</button>
            <button type="button" v-if="tipoAccion==2" class="btn btn-primary btn-sm float-right" @click="actualizarUsuario()">Actualizar</button>
            <button type="button" v-if="tipoAccion==1" class="btn btn-primary btn-sm float-right" @click="registrarUsuario()">Guardar</button>
        </div> -->

    </b-modal>
 
                
        </main>
        
</template>


<script>





    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        data(){
            return{
                
                dismissSecs: 5,
                dismissCountDown: 0,
                dismissSecs1: 5,
                dismissCountDown1: 0,
                step:1,
                step01:1,
                animate: true,
                dismissSecs: 5,
                dismissCountDown: 0,
                fields: [ 'DATOS' ,'ctusuar_email','USUARIO','CARGO', 'Detalles','Opciones','estado'],
                modallg01:false,
                user_id:0,
                apePater:'',
                apeMater:'',
                nombres:'',              
                dni:0,
                direccion:'',
                telefono:0,
                celular:0,
                emailP:'',
                emailC:'',
                fechareg:'',
                idCargo:0,
                usuario:'',
                idEmpleado:0,
                password:'', 
                
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorUsuario:0,
                errorMostrarMsjUsuario:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },

                eqLis:2,
                offset:3,
                criterio:'ctcolab_dni',
                buscar:'',
                arrayCargo:[],
                arrayUsuario:[],
                arrayDistrito:[],
                arrayDepartamento:[],
                arrayProvincia:[],
                errores:[],
                success:false,
                 nell:'',
                 successAct:'',

                //check
                // flavours: ['Categoria', 'Equipos', 'Materiales', 'Ingresos', 'Salidas'],
                // options:['Equipo','Material'],
                // options01:['Proveedor'],
                // options02:['Uni. Medida'],
                // selected: [],
                // selected1: [],
                // allSelected: false,
                // indeterminate: false
                categoriaChecked:0,
                equipoChecked:0,
                materialChecked:0,
                ingresoChecked:0,
                salidaChecked:0,
                equipoTecnicoChecked:0,
                materialTecnicoChecked:0,
                proveedorChecked:0,
                usuarioChecked:0,
                rolChecked:0,
                unidadMedidaChecked:0,
                liquidacionChecked:0,
                idPermiso:''
                
            }
    
        },
         components:{
            Datepicker,
        },
         computed:{
             restic(){
                 if (this.idCargo==1) {
                     return 0 ,
                    this.categoriaChecked=0,
                    this.categoriaChecked=0,
                    this.equipoChecked=0,
                    this.materialChecked=0,
                    this.ingresoChecked=0,
                    this.salidaChecked=0,
                    this.equipoTecnicoChecked=0,
                    this.materialTecnicoChecked=0,
                    this.proveedorChecked=0,
                    this.usuarioChecked=0,
                    this.rolChecked=0,
                    this.unidadMedidaChecked=0
                     
                 }
                 else if(this.idCargo>1) {
                     return 1;
                 }
             },
             errorR(){

                if (this.apePater.length > 2&& 
                    this.apeMater.length > 2 &&
                    this.nombres.length > 2 &&
                    this.dni.length > 7 &&
                    this.idCargo > 0 
                 ){
                    return false
                }
                else{
                    return true
                }
               
            },
            errorR02(){

                if (this.usuario.length > 2 && 
                    this.emailC.length > 2 &&
                    this.celular.length ==9 &&
                    this.password !=='' 
                 
                 ){
                    return false
                }
                else{
                    return true
                }
               
            },
            cellState () {
            return this.celular.length >8 && this.celular.length <10 ? true : false
            },
            apePState(){
            return this.apePater.length > 2 ? true : false
            },
            apeMState () {
            return this.apeMater.length > 2 ? true : false
            },
            nomState () {
            return this.nombres.length > 2 ? true : false
            },
            dniState () {
            return this.dni.length >7 && this.dni.length <9? true : false
            },
            selectState () {
            return this.idCargo > 0 ? true : false
            },
            userState () {
            return this.usuario.length > 2 ? true : false
            },
            mailState () {
            return this.emailC.length > 2 ? true : false
            },
            contraState () {
            return this.password !=='' ? true : false
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
            //check
             toggleAll (checked) {
            this.selected = checked ? this.flavours.slice() : []
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


            prev() {
                this.step-- , 
                this.step01--;
                
                
            },
            next() {

                    this.step01++,
                    this.step++  
                     
            },

            listarUsuario(page,buscar,criterio){
                let me=this;
                var url='/user?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
               axios.get(url).then(function (response) {
                    // handle success;
                    //  console.log(response);
                    var respuesta=response.data;
                   me.arrayUsuario=respuesta.personas.data;
                   me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },
       
            selectCargo(){
                 let me=this;
                 var url='/cargo/selectCargo';
               axios.get(url).then(function (response) {
                    // handle success;
                    //  console.log(response);
                   var respuesta=response.data;
                   me.arrayCargo=respuesta.cargos;
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
                me.listarUsuario(page,buscar,criterio);
            },
            registrarUsuario(){
                if (
                    this.idCargo==0
                    ||this.apePater==''
                    ||this.apeMater==''
                    ||this.nombres==''
                    ||this.dni==''
                    ||this.usuario==''
                    ||this.celular=='' ) {

                    }else{
                let me=this;
                this.dismissCountDown = this.dismissSecs;
                
                
                    
                
                axios.post('/user/registrar',{
                    // check
                    'categoriaChecked':this.categoriaChecked,
                    'equipoChecked':this.equipoChecked,
                    'materialChecked':this.materialChecked,
                    'ingresoChecked':this.ingresoChecked,
                    'salidaChecked':this.salidaChecked,
                    'equipoTecnicoChecked':this.equipoTecnicoChecked,
                    'materialTecnicoChecked':this.materialTecnicoChecked,
                    'proveedorChecked':this.proveedorChecked,
                    'usuarioChecked':this.usuarioChecked,
                    'rolChecked':this.rolChecked,
                    'unidadMedidaChecked':this.unidadMedidaChecked,
                    
                    // fin check
                    'apePater':this.apePater,
                    'apeMater':this.apeMater,
                    'nombres':this.nombres,
                    'ctcolab_dni':this.dni,
                    'direccion':this.direccion,
                    'ctcolab_telefono':this.telefono,
                    'ctcolab_celular':this.celular,
                    'emailP':this.emailP,
                    'emailC':this.emailC,
                    'fechareg':moment(this.fechareg).format('YYYY-MM-DD hh:mm:ss'),
                    'idCargo':this.idCargo,                   
                    'ctusuar_usuario':this.usuario,
                    'password':this.password,
                    
                }).then(function (response) {
                   me.cerrarModal();
                    me.success = true;
                   me.listarUsuario(1,'','ctcolab_dni');
                   me.errores=[];
                // console.log(response);
                     this.timer = setTimeout(() => {

                      this.step = 1; 
                      this.step01 = 1; 

                    }, 800);

                })
                 .catch((error) => {

                         this.errores = error.response.data.errors;
                         this.success = false;
                    
                    });
                   
                    
                    }
            },
            desactivarUsuario(idUsuario){
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
                            axios.patch('/user/desactivar',{
                                
                                'idUsuario':idUsuario
                            }).then(function (response) {
                           
                            me.listarUsuario(1,'','ctcolab_dni');
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
             activarUsuario(idUsuario){
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
                            axios.patch('/user/activar',{
                                
                                'idUsuario':idUsuario
                            }).then(function (response) {
                           
                            me.listarUsuario(1,'','ctcolab_dni');
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
            
            actualizarUsuario(){
                let me=this;
                this.dismissCountDown1 = this.dismissSecs1;
                axios.patch('/user/actualizar',{
                 // check
                    'categoriaChecked':this.categoriaChecked,
                    'equipoChecked':this.equipoChecked,
                    'materialChecked':this.materialChecked,
                    'ingresoChecked':this.ingresoChecked,
                    'salidaChecked':this.salidaChecked,
                    'equipoTecnicoChecked':this.equipoTecnicoChecked,
                    'materialTecnicoChecked':this.materialTecnicoChecked,
                    'proveedorChecked':this.proveedorChecked,
                    'usuarioChecked':this.usuarioChecked,
                    'rolChecked':this.rolChecked,
                    'unidadMedidaChecked':this.unidadMedidaChecked,
                    'liquidacionChecked':this.liquidacionChecked,

                    // fin check
                'apePater':this.apePater,
                'apeMater':this.apeMater,
                'nombres':this.nombres,
                'dni':this.dni,
                'direccion':this.direccion,
                'telefono':this.telefono,
                'celular':this.celular,
                'emailP':this.emailP,
                'emailC':this.emailC,
                'fechareg':moment(this.fechareg).format('YYYY-MM-DD hh:mm:ss'),
                'idCargo':this.idCargo,                   
                'usuario':this.usuario,
                'password':this.password,
                'idEmpleado':this.idEmpleado,
                'idUsuario':this.user_id,
                'idPermiso':this.idPermiso
                }).then(function (response) {
                   me.cerrarModal();
                   me.listarUsuario(1,'','ctcolab_dni');
                   me.successAct = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                if (this.timer) {
                        clearTimeout(this.timer);
                        this.timer = null;
                    }
                    this.timer = setTimeout(() => {

                      this.step = 1; 
                      this.step01 = 1; 

                    }, 1000);
                
                this.modallg01 =false,
                this.tituloModal='';
                this.apePater='',
                this.apeMater='',
                this.nombres='',               
                this.dni='',
                this.emailP=''
                this.emailC=''
                this.direccion='',
                this.telefono='',
                this.celular='',
                this.fechareg=new Date(),
                this.idCargo=0,
                this.usuario='',
                this.idEmpleado=0,
                this.password='',
                this.errorUsuario=0;
                // CHECKECK 0
                this.categoriaChecked=0,
                this.equipoChecked=0,
                this.materialChecked=0,
                this.ingresoChecked=0,
                this.salidaChecked=0,
                this.equipoTecnicoChecked=0,
                this.materialTecnicoChecked=0,
                this.proveedorChecked=0,
                this.usuarioChecked=0,
                this.rolChecked=0,
                this.unidadMedidaChecked=0,
                this.errores=[];
               

            },
            abrirModal(modelo,accion,data=[]){

                   

                this.modallg01=true;
                
                switch (modelo) {
                    case "usuario":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    
                                    this.modal=1;
                                    this.tituloModal='Registrar Usuario'
                                    this.apePater='',
                                    this.apeMater='',
                                    this.nombres='',               
                                    this.dni='',
                                    this.emailP=''
                                    this.emailC=''
                                    this.direccion='',
                                    this.telefono='',
                                    this.celular='',
                                    this.fechareg=new Date(),
                                    this.idCargo=0,
                                    this.usuario='',
                                    this.idEmpleado=0,
                                    this.password='',
                                    this.errores=[];
                                    
                                    this.tipoAccion=1;
                                    break;
                                }
                                case 'actualizar':{
                                    'DATOS' ,'EMAIL','USUARIO','CARGO'
                                    this.modal=1;
                                    this.tituloModal='Actualizar Usuario'
                                    this.user_id=data['ctusuar_code'];
                                    this.apePater=data['ctcolab_ap_paterno'],
                                    this.apeMater=data['ctcolab_ap_materno'],
                                    this.nombres=data['ctcolab_nombres'],               
                                    this.dni=data['ctcolab_dni'],
                                    this.emailP=data['EMAIL']
                                    this.emailC=data['ctusuar_email']
                                    this.direccion=data['ctcolab_direccion'],
                                    this.telefono=data['ctcolab_telefono'],
                                    this.celular=data['ctcolab_celular'],
                                    this.fechareg=data['ctusuar_fecha_act'],
                                    this.idCargo=data['ctcargo_code'],
                                    this.usuario=data['USUARIO'],
                                    this.idEmpleado=data['ctcolab_id'],
                                    this.password=data['password'],
                                    // Devolviendo CHECK DE PERMISOS
                                    this.categoriaChecked=data['categoria'],
                                    this.equipoChecked=data['equipo'],
                                    this.materialChecked=data['material'],
                                    this.ingresoChecked=data['ingreso'],
                                    this.salidaChecked=data['salida'],
                                    this.equipoTecnicoChecked=data['equipoTecnico'],
                                    this.materialTecnicoChecked=data['materialTecnico'],
                                    this.proveedorChecked=data['proveedor'],
                                    this.usuarioChecked=data['usuario'],
                                    this.rolChecked=data['rol'],
                                    this.unidadMedidaChecked=data['unidadMedida'],
                                    this.idPermiso=data['idPermiso'],
                                    // FIN CHECK PERMISOS
                                    this.tipoAccion=2;
                                    
                                    
                                    break;
                                }
                              
                            }
                        }                       
                }
                this.selectCargo();
            }
        },
         watch: {
            selected (newVal, oldVal) {
            // Handle changes in individual flavour checkboxes
            if (newVal.length === 0) {
                this.indeterminate = false
                this.allSelected = false
            } else if (newVal.length === this.flavours.length) {
                this.indeterminate = false
                this.allSelected = true
            } else {
                this.indeterminate = true
                this.allSelected = false
            }
        }},
        
        mounted() {
            this.listarUsuario(1,this.buscar,this.criterio);
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
    .btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
}

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}
.linea{
    width: 70px;
    height: 5px;
    background: red;
    position: relative;
    
}
</style>
