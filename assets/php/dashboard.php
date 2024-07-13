<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); // Redirige al login si no está autenticado
    exit();
}

$nombreUsuario = $_SESSION['correo'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 600px;
        }

        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .button-container button {
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            background-color: turquoise;
            border-color: chocolate;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-container button a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .button-container button:hover {
            background-color: #43c7c2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <?php echo "Bienvenido, " . $nombreUsuario; ?>
        </div>
        <div class="button-container">
            <button><a href="../../index_img.php">Registrar Imágenes Para Pedidos</a></button>
            <button><a href="../../modificar_Usuario.php">Modificar Usuario</a></button>
            <button><a href="../../index_img_user.php">Registrar Imágenes de Usuarios</a></button>
            <button><a href="../../index_CBX.php">Filtrar Productos por Precios</a></button>
            <button><a href="../../index_CBX_Servicios.php">Filtrar Servicios por Nombres</a></button>
        </div>
    </div>
</body>
</html>
