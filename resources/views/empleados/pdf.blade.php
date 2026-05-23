<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        header { text-align: center; margin-bottom: 20px; }
        header img { width: 80px; height: auto; }
        h2 { margin: 5px 0; }
        .fecha { font-size: 10px; text-align: right; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #d3d3d3; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <header>
        @if(file_exists(public_path('logo.png')))
            <img src="{{ public_path('logo.png') }}" alt="Logo">
        @endif
        <h2>Lista de Empleados</h2>
    </header>

    <div class="fecha">
        Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>CI</th>
                <th>Celular</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>{{ $empleado->nombres }}</td>
                    <td>{{ $empleado->paterno }}</td>
                    <td>{{ $empleado->materno }}</td>
                    <td>{{ $empleado->ci }}</td>
                    <td>{{ $empleado->celular }}</td>
                    <td>{{ $empleado->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer style="position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px;">
        Página {PAGE_NUM} de {PAGE_COUNT}
    </footer>
</body>
</html>
