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

<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= Pedidos.xls");
?>

<table>
    <tr>
        <th>Identificador Pedido</th>
        <th>Id producto</th>
        <th>Nombre de producto</th>
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
