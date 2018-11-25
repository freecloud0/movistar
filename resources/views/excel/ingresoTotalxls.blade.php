<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
    </head>
<body>
    {{-- lista de ingresos  --}}
    <div>
    <h3>Lista de Ingresos</h3>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Indice</th>
                    <th>Número de Guia</th>
                    <th>Serie de Guia</th>
                    <th>Cod. Sap</th>
                    <th>Código del producto</th>
                    <th>Cantidad</th>
                    <th>Unidad de medida</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $key=> $ingreso)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$ingreso->ctdetgu_nro}}</td>
                    <td>{{$ingreso->ctdetgu_serie}}</td>
                    <td>{{$ingreso->ctdetgu_desc}}</td>
                    <td>{{$ingreso->ctdetgu_serieProduc}}</td>
                    <td>{{$ingreso->ctdetgu_cantidad}}</td>
                    <td>{{$ingreso->ctundmd_desc}}</td>
                    <td>{{$ingreso->ctdetgu_fecha_reg}}</td>
                   
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
     
</body>
</html>