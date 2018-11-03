<template>
    <main class="main">
            
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            Traffic &amp; Sales
            </div>
            <div class="card-body">
            <br>
            <div class="row">
                <!--Inicio Div Categoria  -->
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <button type="button" class=" btn-transparent dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-settings"></i>
                                </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        
                                        <a class="dropdown-item" v-b-modal.modallg3 href="#"><i class="fa fa-list"></i>   Lista</a>
                                    </div>
                            </div>
                            
                            <div><i class="fa fa-cube fa-lg mr-4 white-text"></i> Categoria</div>
                            
                        </div>
                        <div height="87" style="display: block; height: 70px; width: 190px;" width="237">
                            <div class="text-value" style="bottom: 6px; right: 6px; position: absolute;">
                                <span class="ml-4">
                                   Cantidad: {{categorias}}.
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIn div categoria  -->
                <!-- Inicio DIv Equipos -->
                <div class="col-md-4">
                    <div class="card text-white warning-color">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <button type="button" class=" btn-transparent dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-settings"></i>
                                </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        
                                        <a class="dropdown-item"   href="#"  ><i class="fa fa-list"></i>   Lista</a>
                                    </div>
                            </div>
                            
                            <div><i class="fa fa-cube fa-lg mr-4 white-text"></i> Equipo</div>
                            
                        </div>
                        <div height="87" style="display: block; height: 70px; width: 190px;" width="237">
                            <div class="text-value" style="bottom: 6px; right: 6px; position: absolute;">
                                <span class="ml-4">
                                    Cantidad: {{equipos}} unid.
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Div Equipo -->
                <!-- Inicio Div Material -->
                <div class="col-md-4">
                    <div class="card text-white danger-color">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <button type="button" class=" btn-transparent dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-settings"></i>
                                </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        
                                        <a class="dropdown-item" href="#"><i class="fa fa-list"></i>   Lista</a>
                                    </div>
                            </div>
                            
                            <div><i class="fa fa-cube fa-lg mr-4 white-text"></i> Materiales</div>
                            
                        </div>
                        <div height="87" style="display: block; height: 70px; width: 190px;" width="237">
                            <div class="text-value" style="bottom: 6px; right: 6px; position: absolute;">
                                <span class="ml-4">
                                   
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin div Material -->
                <!-- Inicio div Traslado Equipo-->
                <div class="col-md-4">
                    <div class="card text-white danger-color">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <button type="button" class=" btn-transparent dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-settings"></i>
                                </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div >
                                           
                                                <a class="dropdown-item" v-b-modal.modallg1><i class="fa fa-list"></i>Lista</a>
                                        </div>
                                    </div>
                            </div>
                            
                            <div><i class="fa fa-cube fa-lg mr-4 white-text"></i> REPORTE DE TRASLADO DE TECNICOS</div>
                            
                        </div>
                        <div height="87" style="display: block; height: 70px; width: 190px;" width="237">
                            <div class="text-value" style="bottom: 6px; right: 6px; position: absolute;">
                                <span class="ml-4">
                                   Se realizaron {{contarTrasladoDia}} traslados el día de hoy. 
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin div traslado Equipo  -->
                
                <!-- div Liquidacion -->
                <div class="col-md-4">
                    <div class="card text-white danger-color">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <button type="button" class=" btn-transparent dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-settings"></i>
                                </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div >
                                           
                                                <a class="dropdown-item" v-b-modal.modallg2><i class="fa fa-list"></i>Lista</a>
                                        </div>
                                    </div>
                            </div>
                            
                            <div><i class="fa fa-cube fa-lg mr-4 white-text"></i> LIQUIDACION DE PRODUCTOS</div>
                            
                        </div>
                        <div height="87" style="display: block; height: 70px; width: 190px;" width="237">
                            <div class="text-value" style="bottom: 6px; right: 6px; position: absolute;">
                                <span class="ml-4">
                                    Equipos vendidos el dia de hoy {{cantidadLiqui}} Und.
                                   
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin div Liquidacion -->
                
            </div>
            </div>
        </div>
    </div>

        <!-- Inicio Modal Traspaso Equipos -->
            <div>
                
                    <b-modal v-model="modallg1" id="modallg1" size="lg" title="Traslado de Técnicos" tabindex="-1" :class="{'mostrar':modal}">
                        
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
                                    <div class="table-responsive">
                                                    
                                <b-table show-empty
                                            class="table-bordered  "
                                            stacked="md"
                                            :items="arrayTequipo"
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
                                </div>
                                    <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
                                    </b-col>
                                    </b-row>
                                    
                        
                            
                            </div>
                             <datepicker    v-model="fecha"   format="dd/MM/yyyy" input-class="form-control">
                                        </datepicker>
                                        <button @click="listarTrasladoEquipo()" type="submit">buscar
                                           <span hidden="hidden"> {{fecha}}</span> 

                                        </button>
                                        
                            <div slot="modal-footer">
                                <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                            
                            </div>
                    </b-modal>
            </div>
            <!-- Fin Modal Traspaso Equipos -->
            <!--Inicio Modal Liquidacion  -->
            <div>
                
                    <b-modal v-model="modallg2" id="modallg2" size="lg" title="Traslado de Técnicos" tabindex="-1" :class="{'mostrar':modal}">
                        
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
                                    <div class="table-responsive">
                                                    
                                <b-table show-empty
                                            class="table-bordered  "
                                            stacked="md"
                                            :items="arrayLequipo"
                                            :fields="fields1"
                                            :current-page="currentPage"
                                            :per-page="perPage"
                                            :filter="filter"
                                            :sort-by.sync="sortBy"
                                            :sort-desc.sync="sortDesc"
                                            :sort-direction="sortDirection"
                                            @filtered="onFiltered"
                                    >
                                    </b-table>
                                </div>
                                    <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
                                    </b-col>
                                    </b-row>
                                    
                        
                            
                            </div>
                             <datepicker    v-model="fecha1"   format="dd/MM/yyyy" input-class="form-control">
                                        </datepicker>
                                        <button @click="listarLiquidacionequipo()" type="submit">buscar
                                           <span hidden="hidden"> {{fecha1}}</span> 

                                        </button>
                            <div slot="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            
                            </div>
                    </b-modal>
            </div>
            <!-- Fin Modal Liquidacion -->


             <!--Inicio Modal Categoria  -->
            <!-- <div>
                
                    <b-modal v-model="modallg3" id="modallg3" size="lg" title="Categorias" tabindex="-1" :class="{'mostrar':modal}">
                        
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
                                    <div class="table-responsive">
                                                    
                                <b-table show-empty
                                            class="table-bordered  "
                                            stacked="md"
                                            :items="arrayCategoria"
                                            :fields="fields2"
                                            :current-page="currentPage"
                                            :per-page="perPage"
                                            :filter="filter"
                                            :sort-by.sync="sortBy"
                                            :sort-desc.sync="sortDesc"
                                            :sort-direction="sortDirection"
                                            @filtered="onFiltered"
                                    >
                                    </b-table>
                                </div>
                                    <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
                                    </b-col>
                                    </b-row>
                                    
                        
                            
                            </div>
                            <div slot="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            
                            </div>
                    </b-modal>
            </div> -->
            <!-- Fin Modal Categoria -->

     </div>
           
        </main>
</template>

<script>
 const items = [
]
const items1 = [
]
const items2 = [
]


    import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        


        data(){
            return{
                // Vue-modal TRASPASO EQUIPOS
                 dismissSecs1: 5,
                dismissCountDown1: 0,
                dismissSecs: 5,
                dismissCountDown: 0,
               items: items,
               fields: ['Usuario','Usuario Recepción','ctdetsa_sap','ctdetsa_serie','ctdetsa_observacion','ctdetsa_fecha_traspaso',
               'ctdetsa_cantidad_traspaso','ctdetsa_cantidad'],
            //    Liquidacion
                items1: items1,
                fields1: ['ctdetpr_serie','ctdetpr_sap','ctproduc_nombre'
                ,'ctdetpr_esta_equi','ctproduc_stock'],

                 //    Categoria
                items2: items2,
                fields2: ['ctcatego_desc','ctcatego_fecha_reg'],

               currentPage: 1,
               perPage: 5,
               totalRows: items.length,
               pageOptions: [ 5, 10, 15 ],
               sortBy: null,
               sortDesc: false,
               sortDirection: 'asc',
               filter: null,
               modalInfo: { title: '', content: '' },
                modal:0,
               slide: 0,
            //    fin vue-modal TRASPASO EQUIPOS
            // modal traspaso
                modallg1:false,
                // modal Liquidacion
                modallg2:false,
                // modal Categoria
                modallg3:false,
                sliding: null,
                categorias:'',
                equipos:'',
                contarTrasladoDia:'',
                cantidadLiqui:'',
                eqLis:2,
                fecha:new Date(),
                fecha1:new Date(),

                

                arrayTequipo:[],
                arrayLequipo:[],
                arrayCategoria:[],
            }
        },
        components:{
            Datepicker,
            // DraggableCal
        },
        
        computed:{},  
        methods:{

             onFiltered (filteredItems) {
               // Trigger pagination to update the number of buttons/pages due to filtering
               this.totalRows = filteredItems.length
               this.currentPage = 1
               },
            next() {
                this.eqLis=1
   
            },
            onSlideStart (slide) {
                this.sliding = true
            },
            onSlideEnd (slide) {
            this.sliding = false
            },
            contarCategoria(){
                let me=this;
                 var url='/contar/categoria';
               axios.get(url).then(function (response) {
                    // handle success;
                    //   console.log(response);
                   var respuesta=response.data;
                   me.categorias=respuesta.contarCate;
                //    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            contarEquipo(){
                let me=this;
                 var url='/contar/equipo';
               axios.get(url).then(function (response) {
                    // handle success;
                    //   console.log(response);
                   var respuesta=response.data;
                   me.equipos=respuesta.contarEqui;
                //    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
          
            
             listarTrasladoEquipo(fecha){
                let me=this;
                var url='/reporte/traspaso/equipo?fecha='+moment(this.fecha).format('YYYY-MM-DD');
               axios.get(url).then(function (response) {
                   
                    // handle success;
                    var respuesta=response.data;
                   me.arrayTequipo=respuesta.almacen;
                   me.contarTrasladoDia=respuesta.contarEqui;
                   console.log(me.arrayTequipo);
                 
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },  

            listarLiquidacionequipo(fecha1){
                let me=this;
                var url='/reporte/liquidacion/equipo?fecha1='+moment(this.fecha1).format('YYYY-MM-DD');
               axios.get(url).then(function (response) {
                   console.log(response);
                    // handle success;
                    var respuesta=response.data;
                   me.arrayLequipo=respuesta.almacen;
                   me.cantidadLiqui=respuesta.contarLiqui;
                
                 
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            }, 
            listarCategoria(){
                let me=this;
                var url='/reporte/categoria' ;
               axios.get(url).then(function (response) {
                   console.log(response);
                    // handle success;
                    var respuesta=response.data;
                   me.arrayCategoria=respuesta.categorias;
                
                 
                })
                .catch(function (error) {
                    // handle error 
                    console.log(error);
                });
            },  
            cerrarModal(){
                if (this.modallg1==true) {
                    this.modallg1=false;
                }else if (this.modallg2==true) {
                    this.modallg2=false;
                }else if (this.modallg3==true) {
                    this.modallg3=false;
                } 
            },
            // fin metodos
        },

         
        
       mounted() {
             
              this.contarCategoria();
              this.contarEquipo();
              this.listarTrasladoEquipo();
              this.listarLiquidacionequipo();
              this.listarCategoria();
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
