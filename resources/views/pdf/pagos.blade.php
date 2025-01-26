<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 14px;
            color: #343a40;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<h2>Lista de Pagos</h2>

<table>
    <thead>
        <tr>
            <th>Persona</th>
            <th>Fecha</th>
            <th>Tipo Pago</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagos as $pago)
        <tr>
            <td>{{ $pago['Persona'] }}</td>
            <td>{{ $pago['Fecha'] }}</td>
            <td>{{ $pago['Tipo Pago'] }}</td>
            <td>{{ $pago['Cantidad'] }}</td>
            <td>{{ $pago['Precio Unitario'] }}</td>
            <td>{{ $pago['Total'] }}</td>
            <td>{{ $pago['Descripción'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Generado por el sistema de pagos.</p>
    <p>&copy; {{ date('Y') }} Todos los derechos reservados.</p>
</div>

</body>
</html>
