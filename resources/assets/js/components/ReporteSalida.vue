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
                        <i class="fa fa-align-justify"></i> Cargos
                        <button type="button" @click="abrirModal('cargo','registrar')" class="btn btn-secondary float-right btn-sm"  >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                               
                                <input v-model="fecha" @change="selectFecha(fecha)" type="date">
                                <br>
                                <div  v-for="user in dataUser" :key="user.iduser" >
                                    <div class="flip-card"  >
                                <div class="flip-card-inner" >
                                    <div class="flip-card-front" >
                                    <h1>{{user.ctreportesa_user}}</h1> 
                                    </div>
                                    <div class="flip-card-back" @click="arrayFecha()">
                                    <h2>{{user.ctreportesa_fechatime}}</h2>
                                    <p>SAP: {{user.sap}}</p>
                                    <p>Serie: {{user.ctreportesa_serie}}</p>
                                    <p>Cantidad: {{user.ctreportesa_cantidad}}</p>
                                    <p>Unidad de medida: {{user.ctundmd_desc}}</p>
                                    </div>
                                    
                                </div>
                                </div>
                                </div>
                                
                                </div>
                                </div>
                                </div>
                                </div>


                            

                       
          
           
        </main>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
    import moment from "moment";
    export default {
        data(){
            return{
                fecha:moment(new Date).format('YYYY-MM-DD'),
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
                dataUser:'',
                array:[]
            }
        },
        components:{
            Datepicker,
            // DraggableCal
        },
        computed:{
            
        },
        methods:{
            selectFecha(value){
                let me=this;
                var url='/fecha-reporte?fecha='+value;
               axios.get(url).then(function (response) {
                    // handle success;
                    // console.log(response);
                    me.dataUser=response.data;
                    
                    // console.log(me.dataUser);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            arrayFecha(){
                this.dataUser.forEach(element => {
                    if (element.ctreportesa_fechatime=="2018-11-14 15:49:22") {
                        this.array.push({
                            fecha:element.ctreportesa_fechatime
                        })
                        console.log(this.array);
                    }
                });
            }
           
        },
        mounted() {
            this.selectFecha(this.fecha);
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
    /*  */
    .flip-card {
  background-color: transparent;
  width: 300px;
  height: 200px;
  border: 1px solid #f1f1f1;
  perspective: 1000px; /* Remove this if you don't want the 3D effect */
}

/* This container is needed to position the front and back side */
.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s;
  transform-style: preserve-3d;
}

/* Do an horizontal flip when you move the mouse over the flip box container */
.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}

/* Position the front and back side */
.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
}

/* Style the front side (fallback if image is missing) */
.flip-card-front {
  background-color: #bbb;
  color: black;
}

/* Style the back side */
.flip-card-back {
  background-color: dodgerblue;
  color: white;
  transform: rotateY(180deg);
}
</style>
