@extends('auth.contenido')

@section('login')




  <form class="form-horizontal was-validated" action="{{route('login')}}" method="post">
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
                  

                  
      

@endsection
