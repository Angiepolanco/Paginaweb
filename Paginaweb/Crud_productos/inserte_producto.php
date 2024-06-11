<?php
include('connection.php');
$con = connection();

// Obtener los datos del formulario
$Nombre = $_POST['Nombre'];
$CantidadPeso = $_POST['CantidadPeso'];
$CantidadUnidad = $_POST['CantidadUnidad'];
$ValorUnitario = $_POST['ValorUnitario'];
$nombreArchivo = $_FILES["imagenProducto"]["name"]; // Obtener el nombre del archivo de la imagen
 
// Mover el archivo temporal al directorio de imágenes en el servidor
move_uploaded_file($_FILES["imagenProducto"]["tmp_name"], "C:/xampp/htdocs/Paginaweb/imagenes_productos/" . $nombreArchivo);
$rutaImagen = "imagenes_productos/" . $nombreArchivo;

// Insertar los datos del producto en la base de datos
$sql = "INSERT INTO productos (Nombre, Cantidad_Peso, Cantidad_Uni, Valor_Uni, Imagen) VALUES ('$Nombre', '$CantidadPeso', '$CantidadUnidad', '$ValorUnitario', '$rutaImagen')";
$query = mysqli_query($con, $sql);

if($query) {
    header("Location: index2.php");
    exit(); // Importante para evitar que se ejecute más código después de la redirección
} else {
    echo "Error al insertar producto: " . mysqli_error($con);
}
?>
