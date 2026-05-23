<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 6px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        .header-info {
            margin-bottom: 10px;
        }
        .header-info span {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Lista de Usuarios</h2>

    <div class="header-info">
        <p><span>Mes:</span> {{ $mes ?? 'Todos' }} &nbsp;&nbsp; <span>Año:</span> {{ $anio ?? 'Todos' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->persona_id ? ($usuario->persona->nombres ?? '') . ' ' . ($usuario->persona->paterno ?? '') . ' ' . ($usuario->persona->materno ?? '') : '-' }}</td>
                    <td>{{ $usuario->usuario ?? '-' }}</td>
                    <td>{{ $usuario->email ?? '-' }}</td>
                    <td>{{ $usuario->rol ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
