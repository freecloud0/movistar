<template>
        <main class="main">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">       
            <li class="nav-item " >
                
                <a class="nav-link" aria-haspopup="true" aria-expanded="false" @click.prevent="equis=1" >
                    <!-- <i class="icon-bell" ></i> -->
                    <i class="fas fa-dolly" id="alC"></i>
                        <!-- <tr v-for="(almacen) in arrayAlmacen" 
                                    :key="almacen.idalmacen" >
                            <div v-if="restantes(almacen.ctdetsa_detgu_fecha_reg)>0">
                                 <span class="badge badge-pill red " id="col08"> . </span>
                            </div>        
                        </tr>    -->
                        <span class="badge badge-pill " :class="{red:this.cnf>1, white:this.cnf<1}" > {{cnf}} </span>
                </a>
                
            </li>

         
                <div class="" v-if="equis==1">
                <li class="nav-item ">
                    <div class="romer">
                        <div class="m-4">
                         
                                <h5 class="modal-title" >Notificaciones</h5>
                                <button type="button" class="close topCe" @click.prevent="equis=2" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                           <hr>
                            <div class="table-responsive p-2">
                                <table class=" table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>SAP</th>
                                        <th>Serie</th>
                                        <th>Dias</th>
                                        
                                        
                                        </tr>
                                    </thead>
                                    <!-- {{arrayNotificacion}} -->
                                    <tbody>
                                        <tr v-for="almacen in paginador(arrayNotificacion)" 
                                                :key="almacen.idalmacen"  
                                                :class="{
                                                    greenst: restantes(almacen.ctdetgu_fecha_reg) <= 8
                                                }"
                                        >
        
                                            <td v-text="almacen.ctdetgu_desc"></td>
                                        <td v-text="almacen.ctdetgu_serieProduc"></td>
                                            <!-- <td>{{moment(almacen.ctdetsa_fecha_reg).fromNow()}}</td> -->
                                            <td 
                                                :class="{ 
                                                    wards: restantes(almacen.ctdetgu_fecha_reg) == 8 || restantes(almacen.ctdetgu_fecha_reg) == 9,
                                                    reds: restantes(almacen.ctdetgu_fecha_reg) >= 10, 
                                                    greens: restantes(almacen.ctdetgu_fecha_reg) <= 4  
                                                    }">
                                                    
                                                    {{restantes(almacen.ctdetgu_fecha_reg)}}
                                                    <!-- {{moment(almacen.ctdetgu_fecha_reg)}} -->
                                            </td>
                                            <!-- <td> {{almacen.ctdetsa_detgu_fecha_reg}}</td> -->
                                            
                                        
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- <b-pagination size="md" align="center" :total-rows="this.arrayNotificacion.length" v-model="currentPage" :per-page="perPage">
                                    </b-pagination>  -->
                            </div>
                        
                            <nav v-show="contador()>0" aria-label="pagination example">
                                <ul class="pagination pg-blue">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page-1)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page" ></a>
                                    </li>

                                    <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1)">Sig</a>
                                    </li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </li>
                </div>
                <div class="" v-if="equis==2">

                </div>
        </main>
</template>

<script>
// var fecha1 = moment('2018-08-12');
// var fecha2 = moment(new Date());

// console.log(fecha2.diff(fecha1, 'days'), ' dias de diferencia');
    
    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    const items = []

    export default {
        
        data(){
            return{
                items: items, 
                fields: ['sap','ctdetpr_serie','opciones'],
                fields01: ['SAP','DESCRIPCION','STOCK','OPCIONES'],
                fields02 :['ctdetsa_sot',
                            'ctdetsa_salid_nro',
                            'ctdetsa_produDescri',
                            'ctdetsa_sap',
                            'ctdetsa_serie',
                            'ctdetsa_cantidad',
                            'ctdetsa_undmdDescri',
                            'ctdetsa_fecha_reg',
                            'ctdetsa_descriTipo',
                            'ctdetsa_usuario',
                            ],
                currentPage: 1,
                perPage: 5,
                totalRows: items.length,
                pageOptions: [ 5, 10, 15 ],

                equis:2,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                contador04:0,
                arrayNotificacion:[],
                notifications: [],
                ades:0,
                moment:moment,
                fechaActualizacion:new Date(),
                docHo:'',
                arrayAlmacen:[],
                criterio:'ctdetsa_usuario',
                buscar:'',
                ctdetsa_fecha_reg:'',
                productsCount: 0,
                element:0,
                asss:12,
                remid:[],
                pagination:{
                   'total':0,
                   'current_page':0,
                   'per_page':0,
                   'last_page':0,
                   'from':0,
                   'to':0,
               },

               offset:3,
               conteNF:0,
               cnf:0,
               
            }
            
        },
        computed:{
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
        },
        methods:{

            cambiarPagina(page,buscar,criterio){
               let me=this;
               //actualiza la pagina actual
               me.pagination.current_page=page;
               //envia la peticion para visualizar la data de esa pagina
               me.AdminNotificacion(page);
           },
             paginador(val) {
                const indiceInicio = (this.currentPage - 1) * this.perPage;
                const indiceFinal =
                    indiceInicio + this.perPage > val.length
                    ? val.length
                    : indiceInicio  + this.perPage;
                return val.slice(indiceInicio , indiceFinal );
                },

            contador(){

                    this.docHo= moment(this.fechaActualizacion).format('L');
                    let a=0;
                   for (let index = 0; index < this.arrayNotificacion.length; index++) {
                       
                       const element = this.arrayNotificacion[index].ctdetgu_fecha_reg;
                        if((moment(new Date()).diff(element, 'days'))>5){
                             
                             
                             return 1
                        }  
                        
                        else{
                            return 0;
                        }    
                       
                   }
                   if (this.arrayNotificacion.ctdetgu_fecha_reg) {
                        console.log(this.arrayNotificacion);
                   }else{
                       console.log('dsfff');
                   }
                  
                   

            },    

            noti(){

                this.docHo= moment(this.fechaActualizacion).format('L');
                


             for (var i = 0; i < this.arrayNotificacion.length ; i++) {
                     
                    // return this.arrayAlmacen[i]
                    // return moment(this.docHo).diff(this.arrayAlmacen[i].ctdetsa_fecha_reg, 'days');
       
                }
                return '';

            },
            AdminNotificacion(page){
               let me=this;
               var url='/admin/notificacion?page=' + page ;
              axios.get(url).then(function (response) {
                   // handle success;
                  var respuesta1=response.data;
                  me.arrayNotificacion=respuesta1.productos.data;
                  me.pagination=respuesta1.pagination;
               })
               .catch(function (error) {
                   // handle error
                   console.log(error);
               });
           },
            restantes(val){

                this.docHo= moment(this.fechaActualizacion).format('L');
                // this.diasHO= moment(this.docHo).diff(val, 'days');
                // this.horasHO= moment(this.docHo).diff(val, 'hours');
                return moment(new Date()).diff(val, 'days');
            },
            
            listarAlmacen(page,buscar,criterio){
                let me=this;

                var url='/almacentec?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    // handle success;
                   var respuesta=response.data;
                   me.arrayAlmacen=respuesta.almacen.data;
                   me.pagination=respuesta.pagination;
                   me.conteNF=me.arrayNotificacion.length
                   
                   var b=0;
                   
                    for (let index = 0; index < me.arrayNotificacion.length; index++) {
                        var tem2 = moment(new Date()).diff((me.arrayNotificacion[index].ctdetgu_fecha_reg), 'days'); 
                        
                        if (tem2>8) {
                            me.cnf++
                           
                        } 
                        
                            
                    }
                    // console.log(me.cnf);
                    

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            
        },
         mounted() {
             this.AdminNotificacion(1)
            this.productsCount= this.arrayNotificacion.length;
            this.listarAlmacen(1,this.buscar,this.criterio);
              
        },

           
        
    }
</script>
<style>
    .redes{
        top: -10px;
        left: 40px;
        position: absolute;
        color: black;
    }
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
    .reds{
        text-align: center;
         font-weight:bold;
        color: red;
    }
    .greenst{
        display: none;
    }
    .greens{
        color: green;
    }
      .wards{
        text-align: center;
         font-weight:bold;
        color: orange;
    }
    #col08{
        color: #f44336!important;
    }
    #alC{
        margin-top: 18px;
        margin-right: 10px;
        font-size: 20px;
    }
   
    .topCe{
            position: absolute;
            top: 5px;
            right: 5px;
        }

    @media screen and (min-width: 769px) {
       .romer{
            position: absolute;
            top:20px;
            right:15px;
            background: white;
            width:auto;
            border-style: solid;
    border-color: #263238;
            /* height: 200px; */
        }
    }
    
    @media screen and (max-width: 768px) {
         .romer{
            position: absolute;
            top:20px;
            right:-70px;
            background: white;
            width: auto;
            border-style: solid;
    border-color: #4285f4;
            /* height: 200px; */
        }
    }

</style>
