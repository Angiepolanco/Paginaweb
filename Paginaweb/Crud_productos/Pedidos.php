<?php
include("./connection.php");

// Establecer la conexión
$connection = connection();

$sql = "SELECT * FROM simulacion";
$ejecutar = mysqli_query($connection, $sql);

// Verificar si la consulta tuvo éxito
if (!$ejecutar) {
    die("Error en la consulta: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Pedidos</title>
    <link rel="stylesheet" href="CSS/style.css"> <!-- Asegúrate de que la ruta del archivo CSS sea correcta -->
</head>
<body>
    <header>
        <h1>Pedidos</h1>
    </header>
    <div class="pedidos-table">
        <table>
            <tr>
                <th>Identificador Pedido</th>
                <th>Id producto</th>
                <th>Nombre producto</th>
                <th>Valor total</th>
                <th>Cantidad peso</th>
                <th>Cantidad unidad</th>
                <th>Fecha</th>
            </tr>
            <?php
            while($fila = mysqli_fetch_array($ejecutar)) {
            ?>
            <tr>
                <td><?php echo $fila[0]?></td>
                <td><?php echo $fila[1]?></td>
                <td><?php echo $fila[2]?></td>
                <td><?php echo $fila[3]?></td>
                <td><?php echo $fila[4]?></td>
                <td><?php echo $fila[5]?></td>
                <td><?php echo $fila[6]?></td>
            </tr>
            <?php }?>
        </table>
        <br><br>
        <a href="./excel.php" class="btn-small blue">Descargar reporte excel</a>
    </div>
</body>
</html>
