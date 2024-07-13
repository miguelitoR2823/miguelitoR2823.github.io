<?php
require 'connection_img.php';
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    
    // Obtener el nombre de la imagen antes de eliminarla
    $image = '';
    $stmt = $conn->prepare("SELECT image FROM tb_upload WHERE id = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    // Eliminar la entrada de la base de datos
    $stmt = $conn->prepare("DELETE FROM tb_upload WHERE id = ?");
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    $stmt->close();

    // Verificar y eliminar el archivo de imagen si existe
    $image_path = "img/" . htmlspecialchars($image);
    if (!empty($image) && file_exists($image_path)) {
        unlink($image_path);
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Data</title>
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
        a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
        .delete-button {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<a href="index.html">Volver al Inicio</a>
<form action="" method="post">
    <input type="text" name="search" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Imagen</th>
        <th>Accion</th>
    </tr>
    <?php
    $i = 1;
    if ($search) {
        $stmt = $conn->prepare("SELECT * FROM tb_upload WHERE name LIKE ? ORDER BY id DESC");
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = mysqli_query($conn, "SELECT * FROM tb_upload ORDER BY id DESC");
    }
    ?>

    <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($row["name"]); ?></td>
        <td><img src="img/<?php echo htmlspecialchars($row["image"]); ?>" width="200" title="<?php echo htmlspecialchars($row['image']); ?>"></td>
        <td>
            <form action="" method="post" style="display:inline-block;">
                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="delete-button" onclick="return confirm('Estás seguro de eliminar esta imagen?');">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="index_img.php">Subir Imagen</a>
<br><br>
<form action="generate_pdf.php" method="post">
    <button type="submit" class="pdf-button">Descargar PDF</button>
</form>
</body>
</html>
