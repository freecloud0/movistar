<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
</head>
<body>
    
    {{-- lista de materiales  --}}
    <div>
        <h3>Lista de Materiales</h3>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Sap</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Unidad de Medida</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materiales as $material)
                <tr>
                    <td>{{$material->sap}}</td>
                    <td>{{$material->ctproduc_nombre}}</td>
                    <td>{{$material->ctproduc_desc}}</td>
                    <td>{{$material->ctproduc_stock}}</td>
                    <td>{{$material->ctundmd_desc}}</td>
                    <td>{{$material->ctproduc_fecha_reg}}</td>
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
     
</body>
</html>