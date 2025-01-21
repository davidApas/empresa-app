<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adelantos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Lista de Adelantos</h2>
    <table>
        <thead>
            <tr>
                <th>Persona</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Entregado Por</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adelantos as $adelanto)
                <tr>
                    <td>{{ $adelanto['Persona'] }}</td>
                    <td>{{ $adelanto['Fecha'] }}</td>
                    <td>{{ $adelanto['Monto'] }}</td>
                    <td>{{ $adelanto['Entregado Por'] }}</td>
                    <td>{{ $adelanto['Descripción'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
