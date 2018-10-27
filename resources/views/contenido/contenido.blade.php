    @extends('principal')
    @section('contenido')
    {{-- @if (Auth::check())
        @if (Auth::user()->idCargo==1) --}}
            <template v-if="menu==0">
                <Escritorio></Escritorio>      
            </template>

            <template v-if="menu==1">
                <Categoria>
                    
                </Categoria>
            </template>

            <template v-if="menu==2">
                <Equipo></Equipo>
            </template>

            <template v-if="menu==3">
                <Material></Material>
            </template>

            <template v-if="menu==4">
                <Ingreso></Ingreso>
            </template>

            <template v-if="menu==5">
                <Proveedor></Proveedor>
            </template>

            <template v-if="menu==6">
                <Salida></Salida>
            </template>

            <template v-if="menu==7">
                <h1>Contenido del menú 7</h1>
            </template>

            <template v-if="menu==8">
                <User></User>
            </template>

            <template v-if="menu==9">
                <Cargo></Cargo>
            </template>

            <template v-if="menu==10">
               <Liquidacion></Liquidacion>
            </template>

            <template v-if="menu==11">
                <h1>Contenido del menú 11</h1>
            </template>

            <template v-if="menu==12">
                <Medida></Medida>
            </template>
            <template v-if="menu==13">
                <AlmacenTecnico></AlmacenTecnico>
            </template>
            <template v-if="menu==14">
                <AlmacenTecnicoM></AlmacenTecnicoM>
            </template>
            <template v-if="menu==15">
                <h1>Contenido del menú 15</h1>
            </template>

            <template v-if="menu==16">
                <Reporte></Reporte>
            </template>
            {{-- @elseif (Auth::user()->idCargo==2)
            <template v-if="menu==1">
                <Categoria></Categoria>
            </template>
    
            <template v-if="menu==2">
                <Equipo></Equipo>
            </template>
    
            <template v-if="menu==3">
                <Material></Material>
            </template>
    
            <template v-if="menu==4">
                <Ingreso></Ingreso>
            </template>
    
            <template v-if="menu==5">
                <Proveedor></Proveedor>
            </template>
            @else
            @endif
        @endif --}}

    
       
        
    @endsection
    