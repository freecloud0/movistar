<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
    </head>
<body>
    {{-- lista de salidas  --}}
    <div>
            <h3>Lista de Salidas(Material) </h3>
        </div>
        <div>
            <table>
                    <thead>
                        <tr>
                            <th>Indice</th>
                            <th>Producto</th>
                            <th>Sap</th>
                            <th>Cantidad</th>
                            <th>Unidad de Medida</th>
                            <th>Fecha de Registro</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salidas as $key=> $salida)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$salida->ctdetsa_produDescri}}</td>
                            <td>{{$salida->ctdetsa_sap}}</td>
                            <td>{{$salida->ctdetsa_cantidad}}</td>
                            <td>{{$salida->ctdetsa_undmdDescri}}</td>
                            <td>{{$salida->ctdetsa_fecha_reg}}</td>
                            <td>{{$salida->ctdetsa_traspaso}}</td>
                            
                        </tr>
                        @endforeach                                
                    </tbody>
            </table>
        </div>
</body>
</html>