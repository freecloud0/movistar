<div class="sidebar  blue-grey darken-4">
    <nav class="sidebar-nav" >
        <ul class="nav" id="home">
            <li @click="menu=0" class="nav-item">
                <a  class="nav-link active nobo" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
           
            <li class="nav-title">
                Mantenimiento
            </li>
            {{-- <li @click="menu=16" class="nav-item">
                    <a class=" nav-link white-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span ><i class="icon-bag"></i> Reporte</span> 
                    </a>
            </li> --}}

            <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
               
                
                <a class="nobo nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Almacén</a>
                <ul class="nav-dropdown-items   white ">
                @if (Auth::check())
                    {{-- {{Auth::user()->permiso->categoria}} --}}
                    @if (Auth::user()->permiso->categoria==1)
                    <li @click="menu=1" class="nav-item">
                        <a class=" nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                             <span class="ml-2"><i class="icon-bag"></i> Categorías</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->equipo==1)
                    <li @click="menu=2" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag"></i> Equipos</span> 
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->material==1)
                    <li @click="menu=3" class="nav-item">
                        <a class=" nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag"></i> Material</span>  
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->ingreso==1)
                    <li @click="menu=4" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Ingresos </span>   
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->salida==1)
                    <li @click="menu=6" class="nav-item">
                        <a class="nobo  nav-link black-text" data-toggle="pill" role="   " aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Salidas</span>    
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->liquidacion==1)
                    <li @click="menu=10" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Liquidacion</span>    
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                <a class="nobo nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Almacen Técnico</a>
                <ul class="nav-dropdown-items white">
                    @if (Auth::user()->permiso->equipoTecnico==1)
                    <li @click="menu=13" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i>Equipos Técnico </span>  
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->materialTecnico==1)
                    <li @click="menu=14" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag"></i> Materiales Técnico</span>   
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                <a class="nobo nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Compras</a>
                <ul class="nav-dropdown-items white">
                    {{-- <li @click="menu=4" class="nav-item">
                        <a class="nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Ingresos</span>   
                        </a>
                    </li> --}}
                    @if (Auth::user()->permiso->proveedor==1)
                    <li @click="menu=5" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Proveedores</span>   
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            {{-- <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i>Despacho</a>
                <ul class="nav-dropdown-items white">
                    <li @click="menu=6" class="nav-item">
                        <a class=" nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Salidas</span>    
                        </a>
                    </li>
                   
                </ul>
            </li> --}}
            <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                <a class=" nobo nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                <ul class="nav-dropdown-items white">
                    @if (Auth::user()->permiso->usuario==1)
                    <li @click="menu=8" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                            <span class="ml-2"><i class="icon-bag"></i> Usuarios</span> 
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->permiso->rol==1)
                    <li @click="menu=9" class="nav-item">
                        <a class="nobo nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag"></i> Cargo</span> 
                            </a>
                    </li>
                    @endif
                </ul>
            </li>

            <li class="nav-item nav-dropdown nav-pills" id="v-pills-tab">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Configuración</a>
                <ul class="nav-dropdown-items white">
                    @if (Auth::user()->permiso->unidadMedida==1)
                    <li @click="menu=12" class="nav-item">
                        <a class=" nav-link black-text" data-toggle="pill" role="tab" aria-selected="false" href="#">
                                <span class="ml-2"><i class="icon-bag"></i> Unidad de Medida</span> 
                        </a>
                    </li>
                    @endif
                    {{-- <li @click="menu=13" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ventas</a>
                    </li> --}}
                </ul>
            </li>
            
            @endif
           
            
            {{-- <li @click="menu=14" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
            </li> --}}
        </ul>
    </nav>
    {{-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> --}}
</div>