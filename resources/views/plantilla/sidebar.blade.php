<div class="sidebar  darJK darken-4">
    <nav class="sidebar-nav" >
        <ul class="nav" id="home">
            {{-- <li @click="menu=0" class="nav-item">
                <a  class="nav-link active nobo" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li> --}}

            <li class="nav-item pt-4 pb-4 strongR ">

                <div class="centr">
                        <img src="img/avatars/8.jpg" class="img-avatar imatrs" alt="admin@bootstrapmaster.com">
                </div>
                <div class="text-center mt-2">
                        <span class="b-01">{{Auth::user()->ctusuar_usuario}} </span>
                        <div class="">{{Auth::user()->cargo->ctcargo_nombre}}</div>
                </div>
                <div class="text-center">
                        <button class="btn-transparent  white-text" >
                            <i class="fas fa-cog"></i>
                        </button>
                        <button class="btn-transparent  white-text" >
                            <i class="far fa-envelope"></i>
                        </button>
                        <a href="{{route('logout')}}">
                        <button class="btn-transparent  white-text" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                            <i class="fas fa-power-off"></i>
                        </button>
                        </a>
                        
                    <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none;">
                        {{csrf_field()}}
                    </form>
                </div>

            </li>
            {{-- <li class="nav-item">
                    <div class="view">
                           <div class="strongR"></div>
                            <div class="mask grSt ">
                                    <div class="mt-2 centr">
                                            <img src="img/avatars/8.jpg" class="img-avatar imatrs" alt="admin@bootstrapmaster.com">
                                    </div>
                                    <div class="text-center mt-2">
                                            <span class="">{{Auth::user()->ctusuar_usuario}} 
                                            <div class="b-01">Administrador</div>
                                    </div>
                                    <div class="text-center">
                                            <button class="btn-transparent  white-text" >
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <button class="btn-transparent  white-text" >
                                                <i class="far fa-envelope"></i>
                                            </button>
                                            <a href="{{route('logout')}}">
                                            <button class="btn-transparent  white-text" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                            </a>
                                            
                                        <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none;">
                                            {{csrf_field()}}
                                        </form>
                                    </div>
                            </div>
                        </div>
            </li> --}}
           
            {{-- <li class="nav-title text-center">
                Mantenimiento
            </li> --}}
            {{-- <li @click="menu=16" class="nav-item">
                    <a class=" nav-link white-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span ><i class="icon-bag"></i> Reporte</span> 
                    </a>
            </li> --}}
            @if (Auth::check())
                @if (Auth::user()->permiso->categoria==1||Auth::user()->permiso->equipo==1||Auth::user()->permiso->material==1||
                        Auth::user()->permiso->ingreso==1||Auth::user()->permiso->salida==1||Auth::user()->permiso->liquidacion==1)
                    <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                    
                        
                        <a class="nav-link nav-dropdown-toggle nav-rE " href="#">
                            <i class="icon-bag"></i> Almacén
                        </a>
                        <ul class="nav-dropdown-items   ">
                    
                            {{-- {{Auth::user()->permiso->categoria}} --}}
                            @if (Auth::user()->permiso->categoria==1)
                            
                            <li @click="menu=1" class="nav-item mt-2">
                                <a class=" ml-4 nav-link " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                    <span class="ml-2"><i class="icon-bag white-text"></i> Categorías</span>
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->permiso->equipo==1)
                            <li @click="menu=2" class="nav-item">
                                <a class="ml-4 nav-link " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                        <span class="ml-2"><i class="icon-bag white-text"></i> Equipos</span> 
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->permiso->material==1)
                            <li @click="menu=3" class="nav-item">
                                <a class=" ml-4 nav-link " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                        <span class="ml-2"><i class="icon-bag white-text"></i> Material</span>  
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->permiso->ingreso==1)
                            <li @click="menu=4" class="nav-item">
                                <a class="ml-4 nav-link " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                    <span class="ml-2"><i class="icon-bag white-text"></i> Ingresos </span>   
                                </a>
                            </li>
                            @endif
                            @if (Auth::user()->permiso->salida==1)
                            <li @click="menu=6" class="nav-item">
                                <a class="ml-4  nav-link " data-toggle="pill" role="   " aria-selected="false" href="#">
                                    <span class="ml-2"><i class="icon-bag white-text"></i> Salidas</span>    
                                </a>
                            </li>
                            @endif
                            
                            @if (Auth::user()->permiso->liquidacion==1)
                            <li @click="menu=20" class="nav-item">
                                <a class="ml-4 nav-link " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                    <span class="ml-2"><i class="icon-bag white-text"></i> Liquidacion</span>    
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
            @endIf
            @if (Auth::user()->permiso->equipoTecnico==1||Auth::user()->permiso->materialTecnico==1)    
                <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                    <a class="nav-rE nav-link nav-dropdown-toggle " href="#"><i class="icon-pie-chart"></i> Almacen Técnico</a>
                    <ul class="nav-dropdown-items ">
                        @if (Auth::user()->permiso->equipoTecnico==1)
                        <li @click="menu=13" class="nav-item mt-2">
                            <a class="ml-4 nav-link " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag white-text"></i>Equipos T. </span>  
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->permiso->materialTecnico==1)
                        <li @click="menu=14" class="nav-item">
                            <a class="ml-4 nav-link" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                    <span class="ml-2"><i class="icon-bag white-text"></i> Materiales T.</span>   
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->permiso->proveedor==1)
                <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                    <a class="nav-rE nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Compras</a>
                    <ul class="nav-dropdown-items ">
                        @if (Auth::user()->permiso->proveedor==1)
                        <li @click="menu=5" class="nav-item mt-2">
                            <a class="nobo nav-link ml-4 " data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag white-text"></i> Proveedores</span>   
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->permiso->usuario==1||Auth::user()->permiso->rol==1)
                <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                    <a class=" nav-rE nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                    <ul class="nav-dropdown-items ">
                        @if (Auth::user()->permiso->usuario==1)
                        <li @click="menu=8" class="nav-item mt-2">
                            <a class="nobo nav-link ml-4" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag white-text"></i> Usuarios</span> 
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->permiso->rol==1)
                        <li @click="menu=9" class="nav-item">
                            <a class="nobo nav-link ml-4" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                    <span class="ml-2"><i class="icon-bag white-text"></i> Cargo</span> 
                                </a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->permiso->unidadMedida==1)
            <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                <a class=" nav-rE nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Configuración</a>
                <ul class="nav-dropdown-items ">
                    @if (Auth::user()->permiso->unidadMedida==1)
                    <li @click="menu=12" class="nav-item mt-2">
                        <a class="nobo nav-link ml-4" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag white-text"></i> Und. Medida</span> 
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </li>
            @endif

            @endif
           
        </ul>
    </nav>
    <!-- Footer -->
<footer class=" font-small ">

    <hr >
    <!-- Copyright -->
    <div class="footer-copyright text-center  pt-2 pb-2 grey-text">
        © 2018 Copyright:
        <div class="white-text text-center">Freecloud <span><img class="logoFr" src="img/logoFree.svg" alt=""></span></div>
        
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
    {{-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> --}}
</div>