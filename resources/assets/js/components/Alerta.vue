<template>
        <main class="main">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">       
            <li class="nav-item " >
                
                <a class="nav-link" aria-haspopup="true" aria-expanded="false" @click.prevent="equis=1" >
                    <!-- <i class="icon-bell" ></i> -->
                    <i class="fas fa-dolly" id="alC"></i>
                        <span class="badge badge-pill red">{{arrayDias.length}}</span>
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
                           <b-col md="12" class="my-1">
                                <b-form-group horizontal label="Paginas" class="mb-0">
                                <b-form-select :options="pageOptions" v-model="perPage" />
                                </b-form-group>
                            </b-col>
                           <b-col md="6" class=" disBl" >
                                <b-form-group horizontal label="Sort" class="mb-0">
                                <b-input-group>
                                    <b-form-select  v-model="sortBy" :options="sortOptions">
                                    <option slot="first" :value="null">-- none --</option>
                                    </b-form-select>
                                    <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                    <option :value="true">Asc</option>
                                    <option :value="false">Desc</option>
                                    </b-form-select>
                                </b-input-group>
                                </b-form-group>
                            </b-col>
                          <div class="table-responsive p-2">
                                <b-table show-empty
                                       class="table-bordered  "
                                       stacked="md"
                                       :items="arrayDias"
                                       :fields="fields"
                                       :current-page="currentPage"
                                       :per-page="perPage"
                                       :filter="filter"
                                       :sort-by.sync="sortBy"
                                       :sort-desc.sync="sortDesc"
                                       :sort-direction="sortDirection"
                                       @filtered="onFiltered"
                               >
                               <template slot="Fecha" slot-scope="data">
                                      <span :class="{redt:data.item.dias>9}"> {{data.item.dias}}</span> 
                                    
                                </template>

                               </b-table>
                                
                                <b-row>
                               <b-col md="6" class="my-1">
                                   <b-pagination :total-rows="this.arrayDias.length" :per-page="perPage" v-model="currentPage" class="my-0" />
                               </b-col>
                               </b-row>
                            </div>

                        </div>
                    </div>
                </li>
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
                dismissSecs1: 5,
                dismissCountDown1: 0,
                dismissSecs: 5,
                dismissCountDown: 0,
                items: items, 
                fields: ['sap','series','Fecha'],
                currentPage: 1,
                perPage: 10,
                totalRows: items.length,
                pageOptions: [  10, 15,20 ],

                equis:2,
                sortBy:'dias',
                sortDesc: true,
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
               arrayDias:[]
               
            }
            
        },
        computed:{
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
        },
        methods:{
            countDownChanged (dismissCountDown) {
            this.dismissCountDown = dismissCountDown
            },
            showAlert () {
            this.dismissCountDown = this.dismissSecs
            },
            countDownChanged1 (dismissCountDown1) {
            this.dismissCountDown1 = dismissCountDown1
            },

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
                this.docHo=arrayDias.length;  

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
        getDias(){
            let me=this;
               var url='/dias';
              axios.get(url).then(function (response) {
                   // handle success;
                   me.arrayDias=response.data.data;
                   let limiteDias=me.arrayDias.length;
                //    toast({
                //         type: 'warning',
                //         title: `Recuerde tiene ${limiteDias} productos pendientes `
                //     })
               })
               .catch(function (error) {
                   // handle error
                   console.log(error);
               });   
        }
            
        },
         mounted() {
             this.getDias()
             this.AdminNotificacion(1)
            this.productsCount= this.arrayDias.length;
            this.listarAlmacen(1,this.buscar,this.criterio);
            // setInterval(()=>this.getDias(),3000);
              
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
    .esDis{
        display: block;
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
    .disBl{
        display: none;
    }
    .redt{
        color: red;
        font-weight: bold;
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
