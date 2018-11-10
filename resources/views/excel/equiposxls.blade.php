<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
  
</head>
<body>
    {{-- lista de series con sus respectivos códigos sap  --}}
    <div>
    <h3>TOTAL:{{$total}}</h3>
    <h3> SAP:
        @foreach($series as $obj)
            {{ $obj->sap }}
            @break
        @endforeach
    </h3>
    </div>
    <div>
        <table >
            <thead>
                <tr>
                    <th>Indice</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Series</th>
                    <th>Fecha de Registro</th>
                    <th>Usuario Perteneciente</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($series as $key=> $serie)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$serie['ctproduc_nombre']}}</td>
                    <td>{{$serie['ctproduc_desc']}}</td>
                    <td>{{$serie['ctdetgu_serieProduc']}}</td>
                    <td>{{$serie['ctdetgu_fecha_reg']}}</td>
                    <td>{{$serie['ctdetgu_userSalida']}}</td>
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
     
</body>
</html>