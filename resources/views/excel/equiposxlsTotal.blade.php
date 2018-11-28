<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
    </head>
<body>
    {{-- lista Equipos  --}}
    <div>
    <h3>Lista de Equipos</h3>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Indice</th>
                    <th>Sap</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Fecha de Registro</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipos as $key=> $equipo)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$equipo->sap}}</td>
                    <td>{{$equipo->ctproduc_nombre}}</td>
                    <td>{{$equipo->ctproduc_desc}}</td>
                    <td>{{$equipo->ctproduc_stock}}</td>
                    <td>{{$equipo->ctproduc_fecha_reg}}</td>
                    <td>{{$equipo->ctproduc_usuario}}</td>
                   
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
    {{-- lista de series con sus respectivos códigos sap  --}}
    <div>
            <h3>Lista de Series</h3>
            </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Indice</th>
                            <th>Sap</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Serie</th>
                            <th>Fecha de Registro</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($series as $key=> $serie)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$serie->sap}}</td>
                            <td>{{$serie->ctproduc_nombre}}</td>
                            <td>{{$serie->ctproduc_desc}}</td>
                            <td>{{$serie->ctdetpr_serie}}</td>
                            <td>{{$serie->ctdetpr_fecha_reg}}</td>
                            <td>
                            @if ($serie->ctdetpr_esta_code==1)
                                    En Almácen
                                @endif
                            @if ($serie->ctdetpr_esta_code==2)
                                Despachado
                            @endif
                            </td>
                           
                        </tr>
                        @endforeach                                
                    </tbody>
                </table>
            </div>
     
</body>
</html>