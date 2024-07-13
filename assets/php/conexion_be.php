<?php

    $conexion = mysqli_connect("localhost","root","","login_register_db");

    if($conexion){
        echo 'Conectado Exitosamente a la BDD';
    }else{
        echo 'No se ha podido conectar a la BDD';
    }
?>