<?php
    
    include 'conexion_be.php';
    
    $nombreCompleto = $_POST['nombreCompleto'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $query="INSERT INTO usuarios(nombreCompleto, correo, contrasena)
             VALUES('$nombreCompleto','$correo','$contrasena')";

    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");    

    if(mysqli_num_rows($verificar_correo) > 0){
        echo '
            <script>
                alert("Este correo ya está registrado, intenta con otro diferente");
                window.location = "../../login-intranet.html";
            </script>
        ';
        exit();
    }

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario almacenado exitosamente");
                window.location = "../../login-intranet.html";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Inténtalo de nuevo, usuario no almacaenado");
                window.location = "../../login-intranet.html";
            </script>
        ';
    }

    mysqli_close($conexion);
?>
