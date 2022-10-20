<?php 

    $servidor = "localhost";
    $usuario = "alba";
    $password = "1234";
    $bd = "daw2";

    session_start();

    try {
        $conn = mysqli_connect(
            $servidor,
            $usuario,
            $password,
            $bd);
    } catch (Exception $e) {
        die("Error de conexión: ".$e -> getMessage());
    }

?>