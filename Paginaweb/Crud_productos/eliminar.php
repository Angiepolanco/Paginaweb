<?php
include ('connection.php');
$con = connection();

// Verificar si 'Id' está presente en el array $_GET
if(isset($_GET['Id'])) {
    $Id = $_GET['Id'];

    $sql = "DELETE FROM productos WHERE Id = '$Id'";
    
    $query = mysqli_query($con, $sql);

    if($query){
        header("Location: index2.php");
        exit(); // Importante para evitar que se ejecute más código después de la redirección
    } else {
        echo "Error al eliminar producto: " . mysqli_error($con);
    } // Aquí cierra el bloque del condicional `if`
} else {
    echo "No se proporcionó ningún ID de producto a eliminar.";
}
?>
 