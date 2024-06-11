<?php
include('connection.php');
$con = connection();

$Id= $_POST['Id'];
$Nombre= $_POST['Nombre'];
$CantidadPeso= $_POST['CantidadPeso'];
$CantidadUnidad= $_POST['CantidadUnidad'];
$ValorUnitario= $_POST['ValorUnitario'];
$nombreArchivo = $_FILES["imagenProducto"]["name"]; // Obtener el nombre del archivo

if(!empty($nombreArchivo)) {
    move_uploaded_file($_FILES["imagenProducto"]["tmp_name"], "C:/xampp/htdocs/Paginaweb/Crud_productos/imagenes_productos/" . $nombreArchivo);
    $rutaImagen = "imagenes_productos/" . $nombreArchivo;
    $sql = "UPDATE productos SET Nombre='$Nombre', Cantidad_Peso='$CantidadPeso', Cantidad_Uni='$CantidadUnidad', Valor_Uni='$ValorUnitario', Imagen='$rutaImagen' WHERE Id='$Id'";
} else {
    // Si no se cargó una nueva imagen, actualizar solo los demás campos
    $sql = "UPDATE productos SET Nombre='$Nombre', Cantidad_Peso='$CantidadPeso', Cantidad_Uni='$CantidadUnidad', Valor_Uni='$ValorUnitario' WHERE Id='$Id'";
}

$query = mysqli_query($con, $sql);

if($query){
    header("Location: index2.php");
    exit();
} else {
    echo "Error al editar producto: " . mysqli_error($con);
}

if($query){
    header("Location: index2.php");
    exit(); // Importante para evitar que se ejecute más código después de la redirección
} else {
    echo "Error al insertar producto: " . mysqli_error($con);
}
?>  funcion editar.php <?php
include ('connection.php');
$con = connection();

// Verificar si 'Id' está presente en el array $_GET
if(isset($_GET['Id'])) { 
    $Id = $_GET['Id'];

    $sql = "SELECT * FROM productos WHERE Id = '$Id'";
    $query = mysqli_query($con, $sql);

    // Verificar si se encontraron resultados
    if($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
    } else {
        // Manejar el caso donde no se encuentra ningún producto con el ID proporcionado
        // Por ejemplo, redireccionar al usuario o mostrar un mensaje de error
        echo "No se encontró ningún producto con el ID proporcionado.";
        exit; // Detener la ejecución
    }
} else {
    // Manejar el caso donde 'Id' no está presente en la URL
    // Por ejemplo, redireccionar al usuario o mostrar un mensaje de error
    echo "No se proporcionó ningún ID de producto.";
    exit; // Detener la ejecución
}

?>

