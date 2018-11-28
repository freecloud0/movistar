<template>
            <main class="main">
                <audio id="xyz" preload="auto"  src="audio/error.mp3" type="audio/mpeg" > </audio>
            <!-- Breadcrumb -->
              <ol class="breadcrumb">
                <br>
               
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="">
                    <div class="card-header hedCa white-text">
                        <i class="fa fa-align-justify"></i> Liquidacion
                        <button v-b-tooltip.hover title="Agregar Orden" 
                                @click="abrirModal('orden','registrar')"
                            type="button" class=" redondear2 btn-transparent whit-de float-right" >
                            <i class="fas fa-external-link-alt"></i> Nuevo
                        </button>
                       
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 ">
                                <div class="row">
                                    <div class="col-6 sp-0 sm-0">
                                        <img src="img/img_avatar.png" alt="Avatar" style="width:100%">
                                    </div>
                                    <div class="col-6 sp-0 sm-0">
                                        <div class="hed-Li b-01 pr-2">
                                            {{inputOrden}}   
                                        </div>
                                        <div class="body-LI text-center pt-4">
                                            <input v-model="inputOrden" style="display:none" disabled="disabled" type="text">
                                            <span class=" b-01">Técnico:</span> 
                                            
                                            <p class="">{{userName}}</p>
                                        </div>
                                        
                                    </div>
                                </div>   
                            </div>
                            <div class="col-md-3">
                                <label>N° Orden</label>
                                <v-select  v-model="selected"
                                 :on-search="getOrden"
                                                label="ctorden_numorden" 
                                                :options="arrayOrden"
                                                placeholder="Buscar orden..."
                                                :onChange="getDatosProducto"
                                                >
                                
                                </v-select>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Código Sap</label>
                                        <v-select
                                        :disabled="inputOrden == ''"
                                            v-model="vselect"
                                            :on-search="getSap"
                                            label="sap" 
                                            :options="arraySap"
                                            placeholder="Buscar sap..."
                                            
                                            :onChange="getDatosSap"                                        
                                        >
                                        
                                        </v-select>
                                    </div>
                                    <div class="col-md-6">
                                        <div v-show="tipo==1||tipo==0">
                                            <label>Serie del Producto</label>
                                            <input class="form-control" v-model="serie"  type="text">
                                            <button  class="btn blue btn-sm float-right" type="submit" @click="agregarlista(sap,serie,cantidad,medidaumd)" >Agregar a lista</button>
                                        </div>
                                        <div v-show="tipo==2||tipo==0">
                                            <label>Cantidad</label>
                                            <input class="form-control" v-model="cantidad"  type="text">
                                            <button  class="btn blue btn-sm float-right" type="submit" @click="agregarlista(sap,serie,cantidad,medidaumd)" >Agregar a lista</button>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                
                            </div>
                         
                        </div>
                        <hr class="my-4">

                        
                        <b-tabs pills card>
                            <b-tab title="Lista de Orden" active>
                                <!-- tabla de ordenes -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center hedCa white-text">
                                            <tr>
                                                <th>Indice</th>
                                                <th>Orden</th>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>Dirección</th>
                                                <th>Usuario Asignado</th>
                                                <th v-if="CargoUser==1">Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        <!-- {{arrayCargo}} -->
                                            <tr v-for="(ordenn,index) in arrayOrdenes" :key="ordenn.idor"  >
                                                <td>{{index+1}}</td>
                                                <td v-text="ordenn.ctorden_numorden"></td>
                                                <td v-text="ordenn.ctorden_codigo"></td>
                                                <td v-text="ordenn.ctorden_cliente"></td>
                                                <td v-text="ordenn.ctorden_direccliente"></td>
                                                <td v-text="ordenn.ctusuar_usuario"></td>
                                                <td v-if="CargoUser==1">
                                                    <b-btn variant="warning btn-sm"  @click="abrirModal('orden','actualizar',ordenn)">
                                                            Editar 
                                                    </b-btn>
                                                </td>
                                                
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </b-tab>
                            <b-tab title="Liquidación" >

                                <div class="my-2 menuLiqu" v-if="arraylista!=''">
                                    <button v-b-tooltip.hover title="Borrar Lista" 
                                        @click="limpiarTablalista()"
                                        type="button" class=" btn-transparent white-text float-right" >
                                        <i class="fas fa-external-link-alt"></i> Limpiar todo
                                    </button>
                                    <button v-b-tooltip.hover title="Liquidacion de los productos" 
                                        :disabled="inputOrden == ''"
                                        @click="liquidarProducto()"
                                        type="button" class=" btn-transparent white-text float-right" >
                                        <i class="fas fa-external-link-alt"></i> Liquidar
                                    </button>
                                    
                                    
                                </div>
                                <div class="mt-2" v-for="(lista,index) in arraylista" :key="lista.idlista">
                                    <div class="bg-grasy">
                                            <div class="cerraLis" @click="eliminarIndexLista(index)">
                                                <i class="fas fa-times white-text"></i>
                                            </div>
                                        <div class="header-tableR">
                                            <div  class="triangulo_bottom_Activo">
                                                <div class="text-center b-01 white-text pt-2">
                                                    <i class="fas fa-ellipsis-v fl-rt"></i> {{index+1}}
                                                </div> 
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="body-tableR">
                                            <div class="row sm-0 sp-0">
                                                <div class="col-md-4 sp-0">
                                                    <i class="far fa-circle green-text"></i>
                                                
                                                    <span class="b-01 ml-2 fontS-18">
                                                        {{lista.saplista}}
                                                    </span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="d-flex flex-row">
                                                        <div class="div">
                                                            <i class="b-01 icoC-text">Serie:</i>
                                                            <span class="ml-2">{{lista.serielista}}</span>
                                                        </div>
                                                        <div class="div">
                                                            <div class="lineaC"></div>
                                                        </div>
                                                        <div class="div">
                                                            <i class="b-01 icoC-text ml-2">Can.:</i>
                                                            <span class="ml-2">{{lista.cantidadlista}}</span>
                                                            <span class="green-text b-01">{{lista.medidalista}}</span>
                                                        </div> 
                                                    </div>  
                                                </div>
        
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </b-tab>
                            
                            <b-tab title="Registro">
                                    <!-- AGREGADO RECIENTEMENTE -->
                                    <div class="row my-4">
                                        <div class="col md-4">
                                            <input class="form-control" v-model="fecha" @change="selectFecha(fecha,userLiquidacion)" type="date">
                                        </div>
                                        <div class="col md-4">
                                            <select class="form-control" v-model="userLiquidacion" @change="selectFecha(fecha,userLiquidacion)">
                                                <option value="0">Usuario</option>
                                                <option v-for="usuario in usuarioArray" :key="usuario.ctcatego_id" :value="usuario.ctusuar_code" v-text="usuario.ctusuar_usuario"></option>
                                            </select> 
                                        </div>
                                        <div class="col md-4">
                                            <!-- OBTENER TODAS LAS ORDENES DEL USUARIO -->
                                            <select class="form-control" v-model="userOrden" @change=" getOrdenUser(fecha,userLiquidacion,userOrden)">
                                                <option value="0">Orden</option>
                                                <option v-for="orden in ordenUserArray" :key="orden.ctorden_id" :value="orden.ctorden_id" v-text="orden.ctorden_numorden"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="my-4">
                                        <div v-if="cliente" class="body-tableR">
                                            <div class="row">
                                                <div class="col-md-4 sp-0">
                                                    <!-- <i class="ml-2 far fa-circle green-text"></i> -->
                                                    <i class="ml-2 far fa-user-circle green-text fontS-17"></i>
                                                    <span class="b-01 ml-2 fontS-18">
                                                        {{cliente}}

                                                    </span>
                                                     
                                                    <div class="ml-4">
                                                        <i class="b-01 icoC-text ml-2">Dirección: </i>
                                                        <span>{{direcliente}}</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div v-if="arrayEUser.length>0" >
                                                <div class="menuLiqu">
                                                    <span class="b-01 p-2 white-text">EQUIPOS</span>
                                                    <span class="float-right p-2 white-text">
                                                        Total: {{totalEquiUser}}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-2"  v-for="(userequi,index) in arrayEUser" :key="userequi.iduserequi" >
                                                    <div class="bg-grasy">
                                                        <div  class="tri_liqi">
                                                            <div class="text-center b-01 white-text pt-2">
                                                                <i class="fas fa-ellipsis-v fl-rt"></i> {{index+1}}
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="body-tableR">
                                                        <div class="row">
                                                            <div class="col-md-4 sp-0">
                                                                <i class="ml-2 far fa-circle green-text"></i>
                                                            
                                                                <span class="b-01 ml-2 fontS-18">
                                                                    {{userequi.ctliquid_sap}}
                                                                </span>
                                                            </div>
                                                            <div class="col-md">
                                                                <i class="b-01 icoC-text ml-2">N° Serie : </i>
                                                                <span>{{userequi.ctliquid_serie}}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div v-if="arrayMUser.length>0">
                                                <div class="menuLiqu">
                                                    <span class="b-01 p-2 white-text">MATERIALES</span>
                                                    
                                                </div>
                                                
                                                <div class="mt-2"  v-for="(usermate,index) in arrayMUser" :key="usermate.idusermate">
                                                    <div class="bg-grasy">
                                                        <div  class="tri_liqi">
                                                            <div class="text-center b-01 white-text pt-2">
                                                                <i class="fas fa-ellipsis-v fl-rt"></i> {{index+1}}
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="body-tableR">
                                                        <div class="row">
                                                            <div class="col-md-4 sp-0">
                                                                <i class="ml-2 far fa-circle green-text"></i>
                                                            
                                                                <span class="b-01 ml-2 fontS-18">
                                                                    {{usermate.ctliquid_sap}}
                                                                </span>
                                                            </div>
                                                            <div class="col-md">
                                                                <i class="b-01 icoC-text ml-2">Cantidad: </i>
                                                                <span>{{usermate.ctliquid_cantidad}}</span>
                                                                <span class="green-text b-01">{{usermate.ctundmd_desc}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                            </div>

                                        </div>  
                                    </div>  
                            </b-tab>
                            
                        </b-tabs>

                    </div>
                            
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            

            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog  " role="document">
                    <div class="modal-content">
                        <div class="modal-header hedCa white-text">
                            <h4 class="modal-title b-01" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true" class="white-text">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               <div class="row">
                                   <div class="col-md-6">
                                       <label class="form-control-label" for="text-input">USUARIO
                                        </label>
                                        <select v-model="user" class="form-control" >
                                            <option value="0">Eliga Usuario</option>
                                            <option v-for="usuario in usuarioArray" :key="usuario.ctcatego_id" :value="usuario.ctusuar_code" v-text="usuario.ctusuar_usuario"></option>
                                        </select>
                                   </div>
                                   <div class="col-md-6">

                                       <label class="form-control-label" for="text-input">CODIGO
                                        </label>
                                        <b-form-input   id="inputLive"
                                                        v-model.trim="codigo"
                                                        type="text"
                                                        placeholder="">
                                        </b-form-input>
                                     
                                   </div>
                                   <div class="col-md-6"></div>
                                    <div class="col-md-6">

                                       <label class="form-control-label" for="text-input">ORDEN
                                        </label>
                                        <b-form-input   id="inputLive"
                                                        v-model.trim="orden"
                                                        type="text"
                                                        :class="{brd:ordenError }"
                                                        placeholder="">
                                        </b-form-input>
                                         <span class="filesx" >{{ordenError}}</span>
                                       
                                   </div>
                                   
                                   <div class="col-md-12">

                                       <label class="form-control-label" for="text-input">DATOS DEL CLIENTE
                                        </label>
                                        <b-form-input   id="inputLive"
                                                        v-model.trim="cliente"
                                                        type="text"
                                                        placeholder="">
                                        </b-form-input>
                                       
                                        
                                   </div>
                                    <div class="col-md-12">

                                       <label class="form-control-label" for="text-input">DIRECCION
                                        </label>
                                        <b-form-input   id="inputLive"
                                                        v-model.trim="direccion"
                                                        type="text"
                                                        placeholder="">
                                        </b-form-input>
                                       
                                   </div>
                                   
                               </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn red btn-sm" @click="cerrarModal()">Cerrar</button>
                            <button type="button" :disabled="guarLi"  v-if="tipoAccion==1" class="btn btn-primary btn-sm" @click="guardarorden()">Guardar</button>
                            <button type="button"  v-if="tipoAccion==2" class="btn btn-primary btn-sm" @click="actualizarorden()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
            <!--Fin del modal-->
          
           
        </main>
</template>

<script>
//AGREGADO RECIENTEMENTE
import moment from "moment";
 import vSelect from 'vue-select';
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
                unique:'',
                usuarioArray:[],
                ordenAid:0,
                codigo:'',
                orden:'',
                cliente:'',
                direccion:'',
                user:0,
                arrayOrden:[] ,
                listaorden:0 ,
                arraylista:[],
                inputOrden:'',
                userID:0,
                userName:'',
                loading:false,
                sap:'',
                arraySap:[],
                serie:'',
                cantidad:'',
                medidaumd:'',
                vselect:'',
                tipo:0,
                idMedida:0,
                seriesD:[],
                stockmaterial:0,
                cantidadTotal:0,
                cantidadTotalSuma:0,
                ordenID:0,
                descMaterial:'',
                //AGREGADO RECIENTEMENTE
                fecha:moment(new Date).format('YYYY-MM-DD'),
                userLiquidacion:0,
                arraylistaliquidacion:[],
                arrayOrdenes:[],
                ordenError:'',
                ordenUserArray:[],
                userOrden:0,
                errorUser:'',
                arrayMUser:[],
                arrayEUser:[],
                totalEquiUser:0,
                cliente:'',
                direcliente:'',
                CargoUser:0,
                selected:null

            }
        },
        components:{
            vSelect
        },
        computed:{
            guarLi(){
                
                if(this.codigo!='' && this.orden!='' && this.user!=0){
                    return false
                }else{
                    return true
                }
                
                
            }
          
        },
        methods:{
            
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
            selectUser(){
                    let me=this;
                    var url='/user/selectUser';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.usuarioArray=respuesta.usuarios;
                    
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                },
            
              getOrden(search,loading){
                let me=this;
                loading(true)

                var url= '/get-orden?filtro='+search;
                axios.get(url).then(function (response) {
                    q: search
                    me.arrayOrden=response.data.orden;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getSeriesDespachados(userid){
                let me=this;
                 var url='/series-despachado?userid='+userid;
               axios.get(url).then(function (response) {
                   
                   var respuesta=response.data;
                   me.seriesD=respuesta.series;
                  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getSapmaterial(sap,user){
                let me=this;
                 var url='/sap-stock?sap='+sap+'&userid='+user;
               axios.get(url).then(function (response) {
                   if (response.data.stockSap==0) {
                       me.stockmaterial=0;
                   }else{
                        me.stockmaterial=parseInt(response.data.stockSap[0].ctdetsa_cantidad) ;
                        me.descMaterial=response.data.stockSap[0].ctdetsa_produDescri;
                   }
                  
                  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getDatosProducto(val1){

                let me=this;
                 me.loading=true;
                 if (me.inputOrden==val1.ctorden_numorden) {
                    me.inputOrden=val1.ctorden_numorden;
                    me.userID=val1.ctorden_userID
                    me.userName=val1.ctusuar_usuario
                    me.ordenID=val1.ctorden_id
                    
                    
                }else{
                    if (me.inputOrden.length<1) {
                     me.inputOrden=val1.ctorden_numorden;
                     me.userID=val1.ctorden_userID
                     me.userName=val1.ctusuar_usuario
                     me.ordenID=val1.ctorden_id

                     console.log(me.ordenID);
                }else{
                     Swal({
                        title: '¿Desea reemplazar el dato? '+me.inputOrden,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            
                        if (result.value) {
                          me.inputOrden=val1.ctorden_numorden;
                          me.userID=val1.ctorden_userID
                          me.userName=val1.ctusuar_usuario
                          me.limpiarTablalista();
                          me.serie=''
                          me.cantidad=''
                          me.getSapmaterial(me.sap,me.userID);
                          me.getSeriesDespachados(me.userID);
                          
                        } 
                        })
                }
                }
                me.getSapmaterial(me.sap,me.userID);
               me.getSeriesDespachados(me.userID);
               
            },
            // GET SAP
            getSap(search,loading){
                let me=this;
                loading(true)

                var url= '/get-sap?filtro='+search;
                axios.get(url).then(function (response) {
                    q: search
                    me.arraySap=response.data.sap;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosSap(val1){

                let me=this;
                 me.loading=true;
                 me.sap=val1.sap;
                 me.tipo=val1.ctproduc_tipro_code;
                 me.medidaumd=val1.ctundmd_desc;
                 me.idMedida=val1.ctproduc_undMed;
                 me.verificaTipo();
                 me.getSapmaterial(me.sap,me.userID);
                 
            },
            buscarsaplista(serie){
                var sw=0;
                for (let i = 0; i < this.arraylista.length; i++) {
                    if (this.arraylista[i].serielista==serie) {
                         sw = true;
                    }
                }
                return sw;
            },
            serieEquipo(serie){
                var sw=0;
                for (let i = 0; i < this.seriesD.length; i++) {
                    if (this.seriesD[i].ctdetsa_serie == serie) {
                         sw = true;
                    }
                    
                }
                return sw;
            },
            cantidadMaterial(){
                    this.cantidadTotalSuma=0;
                      for (let i = 0; i < this.arraylista.length; i++) {
                        const element=this.arraylista[i].saplista;
                        if (element==this.sap ) {
                                this.cantidadTotal=parseInt(this.arraylista[i].cantidadlista) ;
                                
                            this.cantidadTotalSuma+=this.cantidadTotal;
                            
                        }
                        
                    }
                    
                    return this.cantidadTotalSuma;
              
            },
            agregarlista(sap,serie,cantidad,medida){
                let me = this;
                if (me.tipo==1) {
                    if (serie !=''&& me.serieEquipo(serie) ) {
                     if (me.buscarsaplista(serie)) {
                         document.getElementById('xyz').play();
                         swal({      
                            type:'error',
                            title:'Error...',
                            text:`Esta Serie ya se encuentra en la lista`,
                        })
                         me.serie='';
                         return
                     }   
                         me.arraylista.push({
                        saplista:sap,
                        serielista:serie,
                        cantidadlista:1,
                        medidalista:medida,
                        medidaID:me.idMedida,
                        tipoID:me.tipo
                    })
                    me.serie='';
                    }else if(me.userName==''){
                        document.getElementById('xyz').play();
                        swal({      
                            type:'error',
                            title:'Error...',
                            text:`No existe orden`,
                        })
                    }
                    else{
                        document.getElementById('xyz').play();
                        swal({      
                            type:'error',
                            title:'Error...',
                            text:`Esta Serie no se encuentra en el almácen de ${me.userName}`,
                        })
                    }
                }else if(me.tipo==2){
                    if (me.inputOrden=='') {
                        document.getElementById('xyz').play();
                         swal({      
                            type:'error',
                            title:'Error...',
                            text:`No existe orden`,
                        })
                    }else{
                        me.cantidadMaterial()
                    if (cantidad!=0 && cantidad!='') {
                        var suma=parseInt(me.cantidadTotalSuma)+parseInt(me.cantidad); 
                        if (suma>me.stockmaterial) {
                            document.getElementById('xyz').play();
                            swal({      
                            type:'error',
                            title:'Error...',
                            text:`stock en almacen de ${me.userName}: ${me.stockmaterial}  `,
                        })
                        }else{
                            me.arraylista.push({
                        saplista:sap,
                        serielista:'Ninguno',
                        cantidadlista:cantidad,
                        medidalista:medida,
                        medidaID:me.idMedida,
                        tipoID:me.tipo
                        })
                        
                         me.cantidad='';
                        
                        }
                    }
                    }
                     
                   
                }
              
            },
            
             eliminarIndexLista: function (index) {
               this.arraylista.splice(index, 1);
            },
            limpiarTablalista(){
                let me = this;
                me.arraylista=[];
            },
            verificaTipo(){
                let me=this;
                me.tipo=me.tipo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.codigo='';
                this.orden='';
                this.user=0;
                this.cliente='';
                this.direccion='';
                this.errorUser='';
            },
            guardarorden(){
                let me=this;
                axios.post('/liquidar-create',{
                        'codigo':me.codigo,
                        'orden':me.orden,
                        // AGREGADO RECIENTEMENTE
                        'idUser':me.user,
                        'cliente':me.cliente,
                        'direccion':me.direccion,

                    }).then(function (response) {
                       me.cerrarModal();
                        me.getOrdenes();
                        me.ordenError='';
                         toast({
                                type: 'success',
                                title: `Orden Registrada`
                            })
                       
                    })
                    .catch((error) => {
                        this.ordenError=error.response.data.data;
                       
                    });
            },
            actualizarorden(){
                let me=this;
                axios.patch('/patch-orden',{
                    'codigo':me.codigo,
                    'orden':me.orden,
                    'idUser':me.user,
                    'cliente':me.cliente,
                    'direccion':me.direccion,
                    'ordenid':me.ordenAid
                }).then(function (response) {

                   me.cerrarModal();
                   me.getOrdenes();
                   me.ordenError='';
                    toast({
                                type: 'success',
                                title: `Orden Actualizada`
                            })
                  
                })
                .catch(function (error) {
                    
                    if (error.response.data.error) {
                        document.getElementById('xyz').play();
                        // swal(error.response.data.error)
                          Swal({
                        title: error.response.data.error,
                        text:'¿Desea reemplazarlo?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            
                        if (result.value) {
                           axios.patch('/patch-orden-user',{
                                'codigo':me.codigo,
                                'orden':me.orden,
                                'idUser':me.user,
                                'cliente':me.cliente,
                                'direccion':me.direccion,
                                'ordenid':me.ordenAid
                            }).then(function (response) {
                            me.activarclase();
                            me.cerrarModal();
                            me.getOrdenes();
                            me.ordenError='';
                                toast({
                                            type: 'success',
                                            title: `Orden Actualizada`
                                        })
                            
                            }).catch(function (error) {

                            })
                            } 
                        })
                    }else if (error.response.data.error_data) {
                        me.ordenError=error.response.data.error_data;
                    }
                     
                    // console.log(error.response);
                });
            },
            activarclase(){
                let me=this;
                me.arrayOrden=[];
                me.userName='';
            },
            abrirModal(modelo,accion,data=[]){
                switch (modelo) {
                    case "orden":
                        {
                            switch (accion) {
                                case 'registrar':{
                                    this.modal=1;
                                    this.tituloModal='Orden'
                                    this.tipoAccion=1;
                                    this.codigo='';
                                    this.orden='';
                                    this.user=0;
                                    this.cliente='';
                                    this.direccion='';
                                    break;
                                }
                                case 'actualizar':{
                                    this.modal=1;
                                    this.ordenError='';
                                    this.tituloModal='Actualizar Orden'
                                    this.tipoAccion=2;
                                    this.ordenAid=data['ctorden_id'];
                                    this.cliente=data['ctorden_cliente'];
                                    this.codigo=data['ctorden_codigo'];
                                    this.direccion=data['ctorden_direccliente'];
                                    this.orden=data['ctorden_numorden'];
                                    this.user=data['ctorden_userID'];
                                    break;
                                }
                              
                            }
                        }                       
                }
            },
            liquidarProducto(){
                let me =this;
                if (me.arraylista.length<1) {
                    document.getElementById('xyz').play();
                     swal({      
                            type:'error',
                            title:'Error...',
                            text:`Lista vacía`,
                        })
                }else{
                     swal({
                    title: '¿Desea liquidar estos productos?',
                    
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    }).then((result) => {
                    if (result.value==true) {
                         axios.post('/liquidar-productos',{
                         'idUsuario':me.userID,
                         'orden':me.ordenID,
                         'lista':me.arraylista
                     }).then(function (response) {
                        me.getSeriesDespachados(me.userID);
                        me.getSapmaterial(me.sap,me.userID);
                        me.limpiarTablalista();
                        
                        if (me.arraylista.length==0) {
                            toast({
                                type: 'success',
                                title: `Productos Liquidados`
                            })
                        }
                     })
                    .catch(function (error) {
                        console.log(error);
                    });
                     }
                    })
                    
                }
               
            },
            metodoLimpiar(){
                let me=this;
                me.userOrden=0;
                me.arrayEUser=[];
                me.arrayMUser=[];
                me.totalEquiUser=0;
                me.cliente='';
                me.direcliente='';
            },
            // AGREGADO RECIENTEMENTE
            selectFecha(value,usuario){
                let me=this;
                me.metodoLimpiar();
                var url='/get-liquidacion?fecha='+value+'&usuario='+usuario;
               axios.get(url).then(function (response) {
                    //  me.arraylistaliquidacion=response.data.lista;
                         me.ordenUserArray=response.data.ordenUser;
                     
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            getOrdenUser(value,usuario,orden){
                  let me=this;
                var url='/get-ordenEM?fecha='+value+'&usuario='+usuario+'&ordenID='+orden;
               axios.get(url).then(function (response) {
                    // handle success;
                    me.arrayEUser=response.data.Equipos;
                    me.arrayMUser=response.data.Materiales;
                    me.totalEquiUser=response.data.total;
                    me.cliente=response.data.cliente[0].ctorden_cliente;
                    me.direcliente=response.data.cliente[0].ctorden_direccliente
                     
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            metodoexistdata(){
                 let me=this;
                var url='/get-ordenCount';
               axios.get(url).then(function (response) {
                    // handle success;
                    if (response.data==0) {
                      toast({
                        type: 'warning',
                        title: `Aun no existe ordenes`
                    })
                    }
                    
                   
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            getOrdenes(){
                 let me=this;
                var url='/get-ordenes-master';
               axios.get(url).then(function (response) {
                   me.arrayOrdenes=response.data.ordenes;
                    
                   
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
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
        },
        mounted() {
            this.metodoexistdata();
            this.listarCargo();
            this.getOrdenes();
            // this.selectFecha(this.fecha,0);
            this.selectUser();
            this.getOrden();
            
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
    .lista{
        border-style:dotted;
    }
    .disabled {
      pointer-events:none;
      color: #bfcbd9;
      cursor: not-allowed;
      background-image: none;
      background-color: #eef1f6;
      border-color: #d1dbe5; 
      display:none;  
    }
</style>
