<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <style>
        body { font-family: Georgia, serif; font-size: 12px; }
        h3 { text-align: center; margin-bottom: 15px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
        }

        p {
            font-weight: bold;
        }
    </style>
</head>
<body>
<h3 style="font-family: Georgia, serif; text-align:center; font-weight:bold;">
    LISTA DE CLIENTES
</h3>



<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Paterno</th>
            <th>Materno</th>
            <th>CI</th>
            <th>Celular</th>
            <th>Email</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>

    <tbody>
        @foreach($clientes as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->nombres }}</td>
            <td>{{ $c->paterno }}</td>
            <td>{{ $c->materno }}</td>
            <td>{{ $c->ci }}</td>
            <td>{{ $c->celular }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->created_at ? $c->created_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>