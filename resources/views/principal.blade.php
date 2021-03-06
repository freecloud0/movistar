<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <link rel="shortcut icon" href="img/favicon.png">
    <title></title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons -->
    <style>

        .centr{
            margin-left: 31%;
        }
    </style>
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="logoT ml-4" ><i class="fas fa-lock icoEr"></i> ELINIK <span class="stLo">TECH</span></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        {{-- <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        </ul> --}}
        <ul class="nav navbar-nav ml-auto">
            {{-- <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Notificaciones</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o"></i> Ingresos
                        <span class="badge badge-success">3</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-tasks"></i> Ventas
                        <span class="badge badge-danger">2</span>
                    </a>
                </div>
            </li> --}}
            @if (Auth::user()->ctusuar_cargo_code==1 || Auth::user()->ctusuar_cargo_code==2 )
            {{-- {{Auth::user()->cargo->ctcargo_nombre}} --}}
            <template>
                <Alerta></Alerta>
            </template>
            @else
            {{-- {{Auth::user()->cargo->ctcargo_nombre}} --}}
            {{-- {{$data}} --}}
            {{-- <p id="app">{{ $message }}</p> --}}
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/avatars/8.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none">{{Auth::user()->ctusuar_usuario}} 
                    <h1 hidden="hidden">{{Auth::user()->ctusuar_code}}</h1>  
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    
                   
                <a class="dropdown-item" href="{{route('logout')}}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Cerrar sesión</a>

                <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none;">
                    {{csrf_field()}}
                </form>
                    
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        @if (Auth::check())
            @if (Auth::user())
                 @include('plantilla.sidebar')
            {{-- @elseif (Auth::user()->idCargo==2)
                 @include('plantilla.sidebaralmacenero')
            @else
            @endif --}}
           
            @endif
        @endif
        {{-- @include('plantilla.sidebar') --}}
        <!-- Contenido Principal -->
        @yield('contenido')
        <!-- /Fin del contenido principal -->
    </div>  
    
        <div class="RetW">
            <router-view></router-view>
        </div>

    </div>
    <footer class="app-footer">
        
    </footer>
    <style>
     
    </style>

    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    <script>
        $(document).ready(function(){
            $( "ul"  ).click(function() {
                window.location.href='/main#/';
            });

        });
        </script>

</body>

</html>