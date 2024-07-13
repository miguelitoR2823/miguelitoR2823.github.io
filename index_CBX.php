<?php
    // Incluir archivo de conexión a la base de datos
    require 'conexion_CBX.php';

    // Consultar los precios disponibles
    $precios = $mysqli->query("SELECT DISTINCT precio FROM cbx_productos ORDER BY precio ASC");

    // Variable para almacenar el precio seleccionado
    $precioSeleccionado = isset($_POST['precio']) ? $_POST['precio'] : '';

    // Consultar productos filtrados por precio seleccionado
    if (!empty($precioSeleccionado)) {
        $query = "SELECT id, nombre, descripcion, precio FROM cbx_productos WHERE precio = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $precioSeleccionado);
        $stmt->execute();
        $productos = $stmt->get_result();

        // Consultar la cantidad de productos por precio seleccionado
        $query_count = "SELECT precio, COUNT(*) as cantidad FROM cbx_productos WHERE precio = ? GROUP BY precio";
        $stmt_count = $mysqli->prepare($query_count);
        $stmt_count->bind_param('s', $precioSeleccionado);
        $stmt_count->execute();
        $result_count = $stmt_count->get_result();
        $data = [];
        while ($row_count = $result_count->fetch_assoc()) {
            $data[$row_count['precio']] = $row_count['cantidad'];
        }
    } else {
        // Si no se ha seleccionado ningún precio, mostrar todos los productos
        $productos = $mysqli->query("SELECT id, nombre, descripcion, precio FROM cbx_productos");

        // Consultar la cantidad de productos por todos los precios
        $query_count = "SELECT precio, COUNT(*) as cantidad FROM cbx_productos GROUP BY precio ORDER BY precio ASC";
        $result_count = $mysqli->query($query_count);
        $data = [];
        while ($row_count = $result_count->fetch_assoc()) {
            $data[$row_count['precio']] = $row_count['cantidad'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Productos por Precio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        select {
            padding: 5px;
            font-size: 16px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        canvas {
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
        }
    </style>
</head>
<body>
    <h2>Selección de Productos por Precio</h2>
    <form action="" method="post">
        <label for="precio">Precio:</label>
        <select name="precio" id="precio" onchange="this.form.submit()">
            <option value="">Seleccionar</option>
            <?php while($row = $precios->fetch_assoc()){ ?>
                <option value="<?php echo $row['precio']; ?>" <?php if($precioSeleccionado == $row['precio']) echo 'selected'; ?>><?php echo $row['precio']; ?></option>
            <?php } ?>
        </select>
    </form>

    <h2>Lista de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $productos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if (!empty($data)) { ?>
        <h2>Cantidad de Productos por Precio</h2>
        <canvas id="myChart" width="400" height="200"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Obtener datos para el gráfico desde PHP
            var precios = <?php echo json_encode(array_keys($data)); ?>;
            var cantidades = <?php echo json_encode(array_values($data)); ?>;

            // Configurar el contexto del gráfico
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: precios,
                    datasets: [{
                        label: 'Cantidad de Productos',
                        data: cantidades,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });
        </script>
    <?php } ?>

</body>
</html>

<?php
    // Cerrar consulta y conexión al finalizar
    if(isset($stmt)) {
        $stmt->close();
    }
    if(isset($stmt_count)) {
        $stmt_count->close();
    }
    $mysqli->close();
?>
