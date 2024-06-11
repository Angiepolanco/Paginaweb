<?php 

function connection(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "directorio"; 

    $connect = mysqli_connect($host, $user, $pass, $db); 

    if (!$connect) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    return $connect;
}

?>
