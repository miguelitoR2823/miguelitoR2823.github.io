<?php
    $mysqli = new mysqli("localhost","root","","table_cbx");

    if ($mysqli->connect_error) {
        echo "Error en la conexión " . $mysqli->connect_error;
        exit;
    }
?>