<?php
require 'assets/php/conexion_be.php';

if (isset($_POST['delete'])) {
    $userId = $_POST['user_id'];
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>alert('Usuario eliminado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar usuario');</script>";
    }
    $stmt->close();
}

$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Gestionar Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <a href="index.html">Volver al Inicio</a>
    <form action="" method="post">
        <input type="text" name="search" placeholder="Buscar por nombre o correo" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Buscar</button>
    </form>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>#</th>
            <th>Nombre Completo</th>
            <th>Correo</th>
            <th>Acción</th>
        </tr>
        <?php
        $i = 1;
        if ($search) {
            $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombreCompleto LIKE ? OR correo LIKE ? ORDER BY id DESC");
            $searchTerm = '%' . $search . '%';
            $stmt->bind_param('ss', $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id DESC");
        }
        ?>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row["nombreCompleto"]); ?></td>
            <td><?php echo htmlspecialchars($row["correo"]); ?></td>
            <td>
                <form method="post" action="" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
