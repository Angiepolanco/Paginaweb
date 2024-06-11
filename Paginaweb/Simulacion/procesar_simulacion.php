<?php
include 'conexion.php';

if(isset($_POST['valor_total_simulacion']) && isset($_POST['productos_temporales'])) {
    $conexion = connection();
    $productosTemporales = json_decode($_POST['productos_temporales'], true);
    
    // Obtener el valor total y la fecha actual
    $valorTotalSimulacion = $_POST['valor_total_simulacion'];
    $fechaSimulacion = date("Y-m-d");

    // Recorrer el arreglo de productos temporales
    foreach ($productosTemporales as $producto) {
        // Obtener los datos del producto temporal
        $idProducto = $producto['id']; // Modificado para obtener el ID del producto temporal
        $nombreProducto = $producto['nombre']; // Modificado para obtener el nombre del producto temporal
        $cantidadPeso = $producto['cantidadPeso']; // Acceder a la cantidad en peso del producto
        $cantidadUni = $producto['cantidadUni']; // Acceder a la cantidad en unidad del producto

        // Insertar simulación en la base de datos
        $query_insert = "INSERT INTO simulacion (id_producto, Nombre_pro, valortotal, cantidad_Peso, cantidad_Unitaria, fecha_pedido) VALUES ('$idProducto', '$nombreProducto', '$valorTotalSimulacion', '$cantidadPeso', '$cantidadUni', '$fechaSimulacion')";
        if (mysqli_query($conexion, $query_insert)) {
            // Actualizar las cantidades restantes del producto
            $query_stock_producto = "SELECT Cantidad_Uni, Cantidad_Peso FROM productos WHERE Id = '$idProducto'";
            $result_stock_producto = mysqli_query($conexion, $query_stock_producto);
            if ($row_stock_producto = mysqli_fetch_assoc($result_stock_producto)) {
                $cantidadDisponibleUni = $row_stock_producto['Cantidad_Uni'];
                $cantidadDisponiblePeso = $row_stock_producto['Cantidad_Peso'];

                // Verificar si la cantidad a restar es mayor que la cantidad disponible
                $cantidadRestanteUni = max(0, intval($cantidadDisponibleUni) - intval($cantidadUni));
                $cantidadRestantePeso = max(0, floatval($cantidadDisponiblePeso) - floatval($cantidadPeso));

                $query_update = "UPDATE productos SET Cantidad_Uni = '$cantidadRestanteUni', Cantidad_Peso = '$cantidadRestantePeso' WHERE Id = '$idProducto'";
                if (mysqli_query($conexion, $query_update)) {
                    echo "Datos actualizados correctamente.";
                } else {
                    echo "Error al actualizar las cantidades de productos: " . mysqli_error($conexion);
                }
            } else {
                echo "Error: No se pudo obtener la información del stock del producto.";
            }
        } else {
            echo "Error al insertar en la tabla simulacion: " . mysqli_error($conexion);
        }
    }

    // Construir el mensaje de WhatsApp
    $mensaje = "Cotización realizada:\n";
    foreach ($productosTemporales as $producto) {
        $mensaje .= "Producto: " . $producto['nombre'] . "\n";
        $mensaje .= "Cantidad en Unidad: " . $producto['cantidadUni'] . "\n";
        $mensaje .= "Cantidad en Peso: " . $producto['cantidadPeso'] . "\n";
    }
    $mensaje .= "Valor Total de la Cotización: $valorTotalSimulacion\n";

    // Construir el enlace de WhatsApp
    $numeroTelefono = "3136493451"; // Reemplaza esto con tu número de teléfono
    $enlaceWhatsApp = "https://wa.me/$numeroTelefono/?text=" . urlencode($mensaje);

    // Redirigir al usuario a WhatsApp
    header("Location: $enlaceWhatsApp");
    exit();

    mysqli_close($conexion);
} else {
    echo "Error: No se recibieron los datos esperados del formulario.";
}
?>
