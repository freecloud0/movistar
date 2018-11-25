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
    <h3>STOCK EN ALMACEN:{{$stockAlmacen}}</h3>
    <h3>EQUIPOS EN  USO:{{$stockUso}}</h3>
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
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($series as $key=> $serie)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$serie['ctproduc_nombre']}}</td>
                    <td>{{$serie['ctproduc_desc']}}</td>
                    <td>{{$serie['ctdetpr_serie']}}</td>
                    <td>{{$serie['ctdetpr_fecha_reg']}}</td>
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