<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/style.css">
    <script>
        function validacion(input) {
            var regex = /^\d*\.?\d*$/;
            if (!regex.test(input.value)) {
                // Crear una ventana emergente personalizada
                var customAlert = document.createElement('div');
                customAlert.innerHTML = "Ingrese un valor válido.";
                customAlert.style.backgroundColor = "#F5F30E";
                customAlert.style.color = "Black";
                customAlert.style.padding = "10px";
                customAlert.style.borderRadius = "5px";
                customAlert.style.position = "fixed";
                customAlert.style.top = "50%";
                customAlert.style.left = "50%";
                customAlert.style.transform = "translate(-50%, -50%)";
                customAlert.style.zIndex = "9999";
                customAlert.style.textAlign = "center";
                document.body.appendChild(customAlert);

                // Limpiar el campo si no es válido
                input.value = '';

                // Desaparecer la ventana emergente después de unos segundos
                setTimeout(function() {
                    document.body.removeChild(customAlert);
                }, 1000);
            }
        }
    </script>
    <title>Editar Producto</title>
</head> 
<body>
    <h1>Editar Producto</h1>
    <div class="productos-form">
        <form action="editar_productos.php" method="POST" enctype="multipart/form-data">
            <?php 
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
                    // Mostrar los campos con los valores del producto seleccionado
                    ?>
                    <input type="hidden" name="Id" value="<?= $row['Id']?>">
                    <input type="text" name="Nombre" placeholder="Nombre Producto" value="<?= isset($row['Nombre']) ? $row['Nombre'] : '' ?>">
                    <input type="text" name="CantidadPeso" placeholder="Peso del producto" value="<?= isset($row['Cantidad_Peso']) ? $row['Cantidad_Peso'] : '' ?>" onblur="validacion(this)">
                    <input type="text" name="CantidadUnidad" placeholder="Unidad del producto" value="<?= isset($row['Cantidad_Uni']) ? $row['Cantidad_Uni'] : '' ?>" onblur="validacion(this)">
                    <input type="text" name="ValorUnitario" placeholder="Valor unitario del producto" value="<?= isset($row['Valor_Unitario']) ? $row['Valor_Unitario'] : '' ?>" onblur="validacion(this)">
                    <?php if(isset($row['Imagen']) && !empty($row['Imagen'])): ?>
                        <img src="<?= $row['Imagen'] ?>" alt="Imagen actual del producto"> <!-- Mostrar imagen actual del producto -->
                    <?php endif; ?>
                    <input type="file" name="imagenProducto"> <!-- Campo para seleccionar la nueva imagen -->
                    <input type="submit" value="Actualizar">
                    <?php
                } else {
                    // Manejar el caso donde no se encuentra ningún producto con el ID proporcionado
                    // Por ejemplo, redireccionar al usuario o mostrar un mensaje de error
                    echo "<p>No se encontró ningún producto con el ID proporcionado.</p>";
                }
            } else {
                // Manejar el caso donde 'Id' no está presente en la URL
                // Por ejemplo, redireccionar al usuario o mostrar un mensaje de error
                echo "<p>No se proporcionó ningún ID de producto.</p>";
            }
            ?>
        </form>
    </div>
</body>
</html>
