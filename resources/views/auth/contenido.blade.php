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
  <body id="body-01" >
      <div class="site-wrapper">
        <div class="site-wrapper-inner">
          <div class="cover-container">
            <div class="masthead clearfix">
              <div class="inner">
                <h3 class="masthead-brand">Coming Soon</h3>
                <nav class="nav nav-masthead">
                  <a class="nav-link nav-social" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  <a class="nav-link nav-social" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                  <a class="nav-link nav-social" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                  <a class="nav-link nav-social" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </nav>
              </div>
            </div><br>      <div class="inner cover">
              <h1 class="cover-heading">The adventure Begins</h1>
              <p class="lead cover-copy">Hold tight as we get our working robots together and produce the most astonishing product ever.</p>
              <p class="lead">
                {{-- <button type="button" class="btn btn-lg btn-default btn-notify" data-toggle="modal" data-target="#subscribeModal">Acceder </button> --}}
                <a href="{{ url('iniciar-sesion') }}"><button type="button" class="btn btn-lg btn-default btn-notify" >Acceder </button></a>
              </p>
            </div>
            <div class="mastfoot">
              <div class="inner">
                <p>&copy; Your Company. Design: <a href="https://github.com/Mikisbell/free-developers-01" target="_blank">TemplateFlip</a>.</p>
              </div>
            </div>

            <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">


     
                    <!-- <form>
                      <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Enter you e-mail to get notified when we launch</label>
                        <input type="text" class="form-control" id="recipient-name" placeholder="your-name@example.com">
                      </div>
                    </form> -->
                    {{-- @yield('login') --}}


              <form class="form-horizontal was-validated" action="{{route('iniciar-sesion')}}" method="post">
                      {{csrf_field()}}
                    <div class="card-body">
          
                      
                    <div class="modal-header">
                        <h1>Acceder</h1>
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
          
                      <div class="input-group mb-3{{$errors->has('ctusuar_email' ? 'is-invalid' : '' )}}">
                        <span class="input-group-addon">
                          <i class="icon-user"></i>
                        </span>
          
                        <input  type="text" 
                                value="{{old('ctusuar_email')}}" 
                                name="usuario" 
                                id="usuario" 
                                class="form-control" 
                                placeholder="Usuario">
          
                                {!!$errors->first('ctusuar_email','<div class="cuer" ><i class="fas fa-exclamation-triangle"></i>:message</div>')!!}
                                
                         <style>
                           .cuer{
                            display:block;
                            color: #da9c6e;
                            margin-top: 4px;
                           }
                         </style>
                                
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
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Acceder</button>
                      </div>
          
                    </div>
            </form>


       


                </div>
              </div>
          </div>

        </div>
      </div>
     
  </body>


<!-- <body class="app flex-row align-items-center">
  <div class="container">
    @yield('login')
  </div>
</body> -->

  <!-- Bootstrap and necessary plugins -->
  <script src="js/plantilla.js"></script>
  <style>
    
  </style>

</html>