<?php
session_start();
include 'conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consulta para obtener el usuario con el correo proporcionado
    $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);

        // Verificar si la contraseña es correcta
        if ($contrasena == $usuario['contrasena']) {
            $_SESSION['correo'] = $correo;
            header('Location: dashboard.php'); // Redirigir a la página de inicio o dashboard
            exit();
        } else {
            echo '
                <script>
                    alert("Contraseña incorrecta");
                    window.location = "../../login-intranet.html";
                </script>
            ';
        }
    } else {
        echo '
            <script>
                alert("Usuario no encontrado");
                window.location = "../../login-intranet.html";
            </script>
        ';
    }
} else {
    echo "Método de solicitud no permitido";
}

mysqli_close($conexion);
?>
