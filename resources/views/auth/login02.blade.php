<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Sistema </title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <!-- Icons -->
  <link href="css/plantilla.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
  
</head>
  <body class="app flex-row align-items-center" id="login02">



   
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group">
                    
                        <div class="card p-4">
                            <div class="card-body">
                                <form class="form-horizontal was-validated" action="{{route('login')}}" method="post">
                                    {{csrf_field()}}  
                                    <h1 class="tel01">Login</h1>
                                    <p class="text-muted">Iniciar sesión en su cuenta</p>
                                    <div class="input-group mb-3{{$errors->has('ctusuar_usuario' ? 'has-error' : '' )}}">
                                            <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                            </span>
                            
                                            <input  type="text" 
                                                    value="{{old('usuario')}}" 
                                                    name="usuario" 
                                                    id="usuario" 
                                                    class="form-control" 
                                                    placeholder="Usuario"
                                                    required autofocus>
                                                    
                                                    {!!$errors->first('ctusuar_usuario','
                                                    

                                                    <div class="alert alert-warning alert-dismissible fade show cuer01" role="alert">
                                                        <strong><i class="fas fa-exclamation-triangle"></i> Datos incorrectos!</strong> 
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    
                                                    ')!!}
                                                    @if (session('msj'))
                                                    <div class="alert alert-warning alert-dismissible fade show cuer01" role="alert">
                                                            <strong><i class="fas fa-exclamation-triangle"></i> Usuario no registrado!</strong> 
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    @if (session('msj1'))
                                                    <div class="alert alert-warning alert-dismissible fade show cuer01" role="alert">
                                                        <strong><i class="fas fa-exclamation-triangle"></i> Usuario Inactivo!</strong> 
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    @endif
                                                   
                                    </div>
                                    
                                    
                                    <div class="input-group mb-4{{$errors->has('password' ? 'is-invalid' : '' )}}">
                                        <span class="input-group-addon">
                                            <i class="icon-lock"></i></span>
                                        <input  type="password" 
                                                name="password" 
                                                id="password" 
                                                class="form-control" 
                                                placeholder="Password">
                            
                                                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Acceder</button>
                                        </div>
                                        {{-- <div class="col-6 text-right">
                                            <button class="btn btn-link px-0" type="button">Forgot password?</button>
                                        </div> --}}
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                            <div class="card-body text-center">
                                <div>
                                <h2>Sign up</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                {{-- <button class="btn btn-primary active mt-3" type="button">Register Now!</button> --}}
                                <div class="imgcontainer">
                                      
                                        <img src="img/avatars/img_avatar.png    " alt="Avatar" class="avatar">
                                        </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>  
   


    </body>
  <style>
      .body{
          background: #5b6a7d!important;
      }
  </style>


<!-- <body class="app flex-row align-items-center">
  <div class="container">
    @yield('login')
  </div>
</body> -->
  <!-- Bootstrap and necessary plugins -->
  <script src="js/plantilla.js"></script>
  <script>
        $('.alert').alert()
    </script>

</html>