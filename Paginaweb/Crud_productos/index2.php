<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if(isset($_SESSION['usuario_Id'])) {
    $usuario_Id = $_SESSION['usuario_Id'];
    echo "<header>
            <h1>¡Bienvenido Administrador!</h1>
            <div class='header-buttons'>
                <form action='Pedidos.php'>
                    <button type='submit'>Pedidos</button>
                </form>
                <form action='/Paginaweb/php-login/cerrar.php'>
                    <button type='submit'>Cerrar sesión</button>
                </form>
            </div>
          </header>";
}
?>

<?php 
include('connection.php');
$con = connection();
$sql = "SELECT * FROM productos";
$query = mysqli_query($con, $sql);

if (!$query) {
    die('Error en la consulta: ' . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>PRODUCTOS AVICOLA EL LEON</title>
</head>
<body>
    <div class="productos-form"> 
        <form action="inserte_producto.php" method="POST" enctype="multipart/form-data">
            <h1>Crear producto</h1>
            <input type="text" name="Nombre" placeholder="Nombre Producto">
            <input type="text" name="CantidadPeso" placeholder="Peso del producto" oninput="validacion(this)">
            <input type="text" name="CantidadUnidad" placeholder="Unidad del producto" oninput="validacion(this)">
            <input type="text" name="ValorUnitario" placeholder="Valor unitario del producto" oninput="validacion(this)">
            <input type="file" name="imagenProducto">

            <input type="submit" value="Agregar Producto">
        </form>
    </div>
    <div class="productos-table">
        <h2>Productos registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre Producto</th>
                    <th>Peso del producto</th>
                    <th>Unidad del producto</th>
                    <th>Valor unitario del producto</th>
                    <th>Imagen</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($query)): ?>
                <tr>
                    <th><?= $row['Id']?></th>
                    <th><?= $row['Nombre']?></th>
                    <th><?= $row['Cantidad_Peso']?></th>
                    <th><?= $row['Cantidad_Uni']?></th>
                    <th><?= $row['Valor_Uni']?></th>
                    <td><img src="<?= $row['Imagen'] ?>"  alt="Imagen del producto"></td>
                    <td><a href="editar.php?Id=<?= $row['Id']?>" class="productos-table--edit">Editar</a></td>
                    <td><a href="eliminar.php?Id=<?= $row['Id']?>" class="productos-table--delete">Eliminar</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function validacion(input) {
        var regex = /^\d*\.?\d*$/;
        if (!regex.test(input.value)) {
            var customAlert = document.createElement('div');
            customAlert.classList.add('custom-alert');
            customAlert.innerHTML = "Ingrese un valor válido.";
            document.body.appendChild(customAlert);

            input.value = '';

            setTimeout(function() {
                document.body.removeChild(customAlert);
            }, 1000);
        }
    }
    </script>
</body>
</html>
