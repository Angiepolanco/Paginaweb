<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización de productos</title>
    <link rel="stylesheet" href="CSS/style.css">
    <!-- Hotjar Tracking Code for http://localhost/Paginaweb/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:5019364,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>

<body>
    <div class="container">
        <h1>Cotización de productos</h1>
        <form action="procesar_simulacion.php" method="POST" id="simulacionForm">
        <label for="producto">Buscar y seleccionar Producto:</label>
        <select name="producto" id="producto" onchange="mostrarInformacionProducto(); limpiarCamposCantidad()">
            <option value="">-- Buscar y seleccionar un producto --</option> <!-- Esta línea agrega la opción predeterminada -->
                <?php
                include 'conexion.php';
                $conexion = connection();
                $query = "SELECT * FROM productos";
                $result = mysqli_query($conexion, $query);

                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['Id']."'>".$row['Nombre']."</option>";
                }

                mysqli_close($conexion);
                ?>
            </select><br><br>
            <div id="info-producto">
                <!-- Aquí se mostrará la información del producto seleccionado -->
            </div>
            <br>
            <label for="cantidaduni">Cantidad en Unidad:</label>
            <input type="number" name="cantidaduni" id="cantidaduni" min="1" step="1"><br><br>
            <label for="cantidadpeso">Cantidad en Peso:</label>
            <input type="number" name="cantidadpeso" id="cantidadpeso" min="0.1" step="0.01"><br><br>
            <!-- Botón para agregar más productos -->
            <button type="button" onclick="agregarProducto()">Agregar Producto</button>
            <br><br>
            <!-- Tabla para mostrar los productos -->
            <table>
                <thead>
                    <tr>
                        <th>ID del Producto</th> <!-- Nueva columna para mostrar el ID del producto -->
                        <th>Nombre del Producto</th>
                        <th>Cantidad en Unidad</th>
                        <th>Cantidad en Peso</th>
                        <th>Valor Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tabla-productos">
                    <!-- Aquí se mostrarán los productos agregados -->
                </tbody>
            </table>
            <br>
            <label for="valor_total_simulacion">Valor Total de la Simulación:</label>
            <input type="text" name="valor_total_simulacion" id="valor_total_simulacion" readonly><br><br>
            <input type="hidden" name="productos_temporales" id="productos_temporales_input">
            <input type="hidden" name="id_producto" id="id_producto">
            <input type="hidden" name="nombre_producto" id="nombre_producto">
            <input type="submit" value="Realizar Cotización">
        </form>
    </div>
    <!-- Script para el manejo de productos temporales -->
    <script>
        var productosTemporales = [];
        
        function agregarProducto() {
    var productoSeleccionado = document.getElementById("producto");
    var idProducto = productoSeleccionado.value; // Obtener el ID del producto seleccionado
    var nombreProducto = productoSeleccionado.options[productoSeleccionado.selectedIndex].text;
    var cantidadUni = document.getElementById("cantidaduni").value;
    var cantidadPeso = document.getElementById("cantidadpeso").value;

    // Validar que se haya seleccionado un producto y se haya ingresado al menos una cantidad
    if (productoSeleccionado.value === "" || (cantidadUni === "" && cantidadPeso === "")) {
        alert("Por favor, selecciona un producto y proporciona al menos una cantidad.");
        return;
    }

    // Verificar si el producto ya existe en el arreglo temporal
    var productoExistenteIndex = productosTemporales.findIndex(function(item) {
        return item.id === idProducto;
    });

    if (productoExistenteIndex !== -1) {
        // Actualizar las cantidades del producto existente
        productosTemporales[productoExistenteIndex].cantidadUni = cantidadUni;
        productosTemporales[productoExistenteIndex].cantidadPeso = cantidadPeso;
    } else {
        // Obtener el valor unitario y el stock disponible del producto
        var valorUnitario = parseFloat(document.getElementById("info-producto").getAttribute("data-valorunitario"));
        var stockDisponibleUni = parseFloat(document.getElementById("info-producto").getAttribute("data-stockuni"));
        var stockDisponiblePeso = parseFloat(document.getElementById("info-producto").getAttribute("data-stockpeso"));

        // Calcular el valor total basado en la cantidad ingresada
        var valorTotal = 0;
        if (cantidadUni !== "") {
            valorTotal = parseFloat(cantidadUni) * valorUnitario;
            cantidadPeso = ""; // Reiniciar la cantidad en peso si se ingresó cantidad en unidad
        } else if (cantidadPeso !== "") {
            valorTotal = parseFloat(cantidadPeso) * valorUnitario;
            cantidadUni = ""; // Reiniciar la cantidad en unidad si se ingresó cantidad en peso
        }

        // Verificar si hay suficiente stock
        if (cantidadUni !== "" && parseFloat(cantidadUni) > stockDisponibleUni) {
            alert("No hay suficiente stock disponible en unidades para este producto.");
            return;
        }
        if (cantidadPeso !== "" && parseFloat(cantidadPeso) > stockDisponiblePeso) {
            alert("No hay suficiente stock disponible en peso para este producto.");
            return;
        }

        // Establecer los valores de los campos ocultos
        document.getElementById("id_producto").value = idProducto;
        document.getElementById("nombre_producto").value = nombreProducto;

        // Agregar nuevo producto al arreglo temporal
        productosTemporales.push({ id: idProducto, nombre: nombreProducto, cantidadUni: cantidadUni, cantidadPeso: cantidadPeso, valorTotal: valorTotal });
    }

    // Limpiar tabla y mostrar productos temporales
    mostrarProductosTemporales();

    // Calcular y mostrar valor total
    calcularValorTotal();
}


        // Función para mostrar la información del producto seleccionado
        function mostrarInformacionProducto() {
            var productoSeleccionado = document.getElementById("producto").value;
            
            // Realizar la solicitud AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var productoInfo = JSON.parse(this.responseText);
                    if (productoInfo.error) {
                        alert(productoInfo.error);
                    } else {
                        // Mostrar la información del producto en la interfaz
                        var infoProducto = document.getElementById("info-producto");
                        infoProducto.innerHTML = "<p><strong>Nombre:</strong> " + productoInfo.Nombre + "</p>" +
                                                 "<p><strong>Valor Unitario:</strong> $" + productoInfo.Valor_Uni + "</p>";
                        if (productoInfo.Cantidad_Uni) {
                            infoProducto.innerHTML += "<p><strong>Cantidad Disponible (Unidad):</strong> " + productoInfo.Cantidad_Uni + "</p>";
                        }
                        if (productoInfo.Cantidad_Peso) {
                            infoProducto.innerHTML += "<p><strong>Cantidad Disponible (Peso):</strong> " + productoInfo.Cantidad_Peso + "</p>";
                        }

                        // Almacenar el valor unitario y el stock disponible en atributos data del elemento info-producto
                        infoProducto.setAttribute("data-valorunitario", productoInfo.Valor_Uni);
                        infoProducto.setAttribute("data-stockuni", productoInfo.Cantidad_Uni);
                        infoProducto.setAttribute("data-stockpeso", productoInfo.Cantidad_Peso);
                    }
                }
            };
            xhttp.open("GET", "obtener_informacion_producto.php?id=" + productoSeleccionado, true);
            xhttp.send();
        }

        // Función para limpiar los campos de cantidad
        function limpiarCamposCantidad() {
            document.getElementById("cantidaduni").value = "";
            document.getElementById("cantidadpeso").value = "";
        }

        // Función para mostrar los productos temporales en la tabla
        function mostrarProductosTemporales() {
            var tablaProductos = document.getElementById("tabla-productos");
            tablaProductos.innerHTML = "";
            for (var i = 0; i < productosTemporales.length; i++) {
                var producto = productosTemporales[i];
                var fila = "<tr><td>" + producto.id + "</td><td>" + producto.nombre + "</td><td>" + (producto.cantidadUni || "") + "</td><td>" + (producto.cantidadPeso || "") + "</td><td>" + producto.valorTotal.toFixed(2) + "</td><td><button onclick='eliminarProducto(" + i + ")'>Eliminar</button></td></tr>";
                tablaProductos.innerHTML += fila;
            }
        }

        // Función para eliminar un producto de la lista temporal
        function eliminarProducto(index) {
            productosTemporales.splice(index, 1); // Eliminar el producto del arreglo
            mostrarProductosTemporales(); // Actualizar la tabla de productos
            calcularValorTotal(); // Recalcular el valor total
        }

        // Función para calcular el valor total de la simulación
        function calcularValorTotal() {
            var valorTotalSimulacion = 0;
            for (var i = 0; i < productosTemporales.length; i++) {
                valorTotalSimulacion += productosTemporales[i].valorTotal;
            }
            document.getElementById("valor_total_simulacion").value = valorTotalSimulacion.toFixed(2);
            document.getElementById("productos_temporales_input").value = JSON.stringify(productosTemporales);
        }

        // Agregar un event listener al evento submit del formulario
        document.getElementById("simulacionForm").addEventListener("submit", function(event) {
            // Verificar si no se ha agregado ningún producto
            if (productosTemporales.length === 0) {
                alert("Por favor, agregue al menos un producto antes de realizar la cotización.");
                event.preventDefault(); // Detener el envío del formulario
            }
        });

        function searchProducts() {
            var input, filter, select, option, i;
            input = document.getElementById("producto");
            filter = input.value.toUpperCase();
            select = document.getElementById("producto");
            option = select.getElementsByTagName("option");

            for (i = 0; i < option.length; i++) {
                txtValue = option[i].textContent || option[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    option[i].style.display = "";
                } else {
                    option[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
