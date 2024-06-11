<?php
include 'conexion.php';

if(isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    $conexion = connection();
    $query_select = "SELECT Nombre, Valor_Uni, Cantidad_Uni, Cantidad_Peso FROM productos WHERE Id = $producto_id";
    $result_select = mysqli_query($conexion, $query_select);

    if (!$result_select) {
        die("Error en la consulta SQL: " . mysqli_error($conexion));
    }

    if ($row = mysqli_fetch_assoc($result_select)) {
        // Devolver los datos del producto en formato JSON
        echo json_encode($row);
    } else {
        echo json_encode(array("error" => "No se encontró el producto con el ID proporcionado."));
    }

    mysqli_close($conexion);
} else {
    echo json_encode(array("error" => "Error: No se recibió el ID del producto."));
}
?>


