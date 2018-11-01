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
  <body id="top" class="app flex-row align-items-center  pace-done">



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="clearfix">
                    <!-- <h1 class="float-left display-3 mr-4">404</h1>
                    <h4 class="pt-3">Oops! You're lost.</h4>
                    <p class="text-muted">The page you are looking for was not found.</p> -->
                    <div class="error-box">
                        <div class="error-body text-center">
                            <h1 class="error-title text-danger">404</h1>
                            <h3 class="text-uppercase text-Sub">PÁGINA NO ENCONTRADA !</h3>
                            <p class="text-muted m-t-30 m-b-30">USTED PARECE ESTAR TRATANDO DE ENCONTRAR OTRA PAGINA</p>
                            <a href="{{ url('/') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Regresar a Inicio</a> </div>
                            <div class="logFre">

                            </div>
                        </div>
                </div>
            
            </div>
        </div>
    </div>



    

    
     
  </body>
<style>
  

    .text-danger {
            color: #da542e!important;
        }
    .text-Sub{
        color: #3e5569!important;
        
    }

    .btn-rounded {
    border-radius: 60px;
    padding: 7px 18px;
}

    .btn-danger {
        color: #fff;
        background-color: #da542e;
        border-color: #da542e;
    }

.logFre{
    
 
    display: inline-block;
    width: 155px;
    height: 55px;
    margin-top: 30px;
    margin-right: 0;
    background-image: url(../img/logo.svg);
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 70px auto;

}

@media (min-width: 768px) {
    .error-box .error-title
         {
            font-size: 210px;
            font-weight: 900;
            text-shadow: 4px 4px 0 #fff, 6px 6px 0 #343a40;
            line-height: 210px;
        }
}

@media (max-width: 768px) {
    .error-box .error-title
         {
            font-size: 100px;
            font-weight: 900;
            text-shadow: 4px 4px 0 #fff, 6px 6px 0 #343a40;
            line-height: 210px;
        }
}

</style>

  <script src="js/plantilla.js"></script>

</html>