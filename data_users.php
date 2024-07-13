<?php
require 'connection_img_user.php';

$search = '';
if (isset($_POST['search'])) {
  $search = $_POST['search'];
}
if (isset($_POST['delete_id'])) {
  $delete_id = $_POST['delete_id'];
  
  
  $stmt = $conn->prepare("SELECT image FROM img_usuarios WHERE id = ?");
  if (!$stmt) {
    die("Error: " . $conn->error);
  }
  $stmt->bind_param('i', $delete_id);
  $stmt->execute();
  $stmt->bind_result($image);
  $stmt->fetch();
  $stmt->close();

  
  $stmt = $conn->prepare("DELETE FROM img_usuarios WHERE id = ?");
  if (!$stmt) {
    die("Error: " . $conn->error);
  }
  $stmt->bind_param('i', $delete_id);
  $stmt->execute();
  $stmt->close();

  
  if (file_exists("img_users/$image")) {
    unlink("img_users/$image");
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
        $stmt = $conn->prepare("SELECT * FROM img_usuarios WHERE name LIKE ? ORDER BY id DESC");
        if (!$stmt) {
          die("Error: " . $conn->error);
        }
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
      } else {
        $result = mysqli_query($conn, "SELECT * FROM img_usuarios ORDER BY id DESC");
        if (!$result) {
          die("Error: " . $conn->error);
        }
      }
      ?>

      <?php while ($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($row["name"]); ?></td>
        <td><img src="img_users/<?php echo htmlspecialchars($row["image"]); ?>" width="200" title="<?php echo htmlspecialchars($row['image']); ?>"></td>
        <td>
          <form action="" method="post" style="display:inline-block;">
            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="delete-button" onclick="return confirm('Estás seguro de eliminar la imagen?');">Borrar</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
    <br>
    <a href="index_img.php">Subir Imagen</a>
  </body>
</html>
