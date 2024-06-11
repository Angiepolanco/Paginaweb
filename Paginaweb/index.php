<?php 
// Incluir el archivo de conexión
include 'Crud_productos/connection.php';

// Establecer la conexión a la base de datos
$conn = connection();

// Consulta SQL para seleccionar los productos
$query = mysqli_query($conn, "SELECT * FROM productos");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avícola El León</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">

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

    <header>
        <div class="menu container">
            
            <label for="menu">
                <img src="imagenes/listaDesplegable.png" class="menu-icono" alt="Menu">
            </label>
            <nav class="navbar">
    <div class="menu-1">
        <ul>
            <li><a href="php-login/inicio.php"><img src="imagenes/icono.png" alt="Inicio de sesión administrador" class="icon"></a></li>
        </ul>
    </div>

    <div class="menu-2">
        <ul>
            <li><a href="#"><img src="imagenes/whatsapp.png" alt="WhatsApp" class="icon"></a></li>
        </ul>
    </div>
</nav>

                   
        </div>

        <div class="header-content container">
            <div class="swiper mySwiper-1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slider">
                            <div class="slider-txt">
                                <h1>Avícola El León</h1>
                                <p>"Los mejores por calidad y precio"</p>
                                <div class="botones">
    <button class="btn-1" onclick="window.location.href='Simulacion/simulacion.php'">Cotización de Productos</button>
</div>

                            </div>
                            <div class="slider-img">
                                <img src="imagenes/logo.jpeg" alt="Logo de Avícola El León">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="products">
    <div class="search-container container">
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Buscar producto">
        </form>
    </div>
        <div class="tabs container">
            <input type="radio" name="tabs" id="tab1" checked="checked" class="tabInput" value="1">
            <label for="tab1">Productos</label>
            <div class="tab">
                <div class="swiper mySwiper-2" id="swiper1">
                    <div class="swiper-wrapper">
                        <?php 
                        // Verificar si hay resultados en la consulta
                        if(mysqli_num_rows($query) > 0): 
                            // Iterar a través de cada fila de resultados
                            while($row = mysqli_fetch_array($query)): ?>
                                <div class="swiper-slide">
                                    <div class="product">
                                        <div class="product-img">
                                            <?php 
                                            // Verificar si hay una imagen definida para el producto
                                            if(!empty($row['Imagen'])): ?>
                                    <img src="Crud_productos/<?= $row['Imagen'] ?>" alt="Imagen del producto">
                                                  <?php endif; ?>
                                        </div>
                                        <div class="product-txt">
                                            <h4><?= $row['Nombre'] ?></h4>
                                            <?php 
                                            // Verificar y mostrar la cantidad de peso si está definida
                                            if(isset($row['Cantidad_Peso']) && !empty($row['Cantidad_Peso'])): ?>
                                                <p><?= $row['Cantidad_Peso'] ?></p>
                                            <?php endif; ?>
                                            <?php 
                                            // Verificar y mostrar la cantidad de unidad si está definida
                                            if(isset($row['Cantidad_Uni']) && !empty($row['Cantidad_Uni'])): ?>
                                                <p><?= $row['Cantidad_Uni'] ?></p>
                                            <?php endif; ?>
                                            <?php 
                                            // Verificar y mostrar el valor unitario si está definido
                                            if(isset($row['Valor_Uni']) && !empty($row['Valor_Uni'])): ?>
                                                <span class="price">$<?= $row['Valor_Uni'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <p>No se encontraron productos.</p>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-button-next"></div> <!-- Asegúrate de que este botón esté dentro del contenedor correcto -->
        <div class="swiper-button-prev"></div> <!-- Asegúrate de que este botón esté dentro del contenedor correcto -->
   
                  </div>
            </div>
        </div>
    </main>

    <section class="info container">
        <div class="info-img">
            <img src="imagenes/avicola.png" alt="Avicola">
        </div>
        <div class="info-txt">
            <h2>NOSOTROS</h2>
            <p>MISIÓN -> En Avícola El León, nos dedicamos apasionadamente a proporcionar a nuestros clientes productos avícolas y artículos complementarios esenciales para el hogar de la más alta calidad. Nuestra misión es satisfacer las necesidades de alimentación y conveniencia de las familias, ofreciendo productos frescos, seguros y deliciosos que mejoren su calidad de vida. Nos esforzamos por mantener la confianza de nuestros clientes mediante la excelencia operativa, el servicio al cliente excepcional y el compromiso con la innovación.</p>
            <p>VISIÓN -> Nos visualizamos como líderes indiscutibles en el mercado avícola y de alimentos complementarios, reconocidos por nuestra calidad inigualable, servicio excepcional y compromiso con la comunidad. Aspiramos a expandir nuestra presencia geográfica, ofreciendo nuestros productos de calidad a más hogares y comunidades, mientras mantenemos nuestra integridad y valores fundamentales. Nos esforzamos por ser un modelo de excelencia en la industria, impulsando el crecimiento y contribuyendo al bienestar de nuestros clientes, empleados y sociedad en general.</p>
            
        </div>
    </section>

    <section class="horario">
        <div class="horario-info container">
            <h2>Información de contacto</h2>
            <div class="horario-txt">
                <div class="txt">
                    <h4>DIRECCION</h4>
                    <p>Calle 23 con carrera 31 y 32</p>
                    <p>Barrio Santa Helena.</p>
                </div>
                <div class="txt">
                    <h4>CORREO ELECTRONICO</h4>
                    <p>avi_elleon@hotmail.com</p>
                </div>
                <div class="txt">
                    <h4>CELULAR</h4>
                    <p>316 525 02 81</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <iframe class="map"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.6821055124356!2d-76.52355922653173!3d3.4273604513825866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30a70765087c4d%3A0x3778e0839598626f!2sGaler%C3%ADa%20de%20Santa%20Elena!5e0!3m2!1ses!2sco!4v1712192779710!5m2!1ses!2sco"
            width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <footer class="footer container">
        <img class="logo-2" src="imagenes/logo.jpeg" alt="Logo de Avícola El León">
        <div class="PieDePagina">
            <h4>AVÍCOLA EL LEÓN</h4>
        </div>
    </footer>

    <!-- Script de busqueda-->

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('search-input');
        const products = document.querySelectorAll('.product');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Evita que el formulario se envíe

            const searchTerm = searchInput.value.toLowerCase();

            products.forEach(function (product) {
                const productName = product.querySelector('.product-txt h4').innerText.toLowerCase();
                
                // Oculta o muestra el producto según si coincide con el término de búsqueda
                if (productName.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Para búsqueda en tiempo real mientras se escribe
        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();

            products.forEach(function (product) {
                const productName = product.querySelector('.product-txt h4').innerText.toLowerCase();
                
                // Oculta o muestra el producto según si coincide con el término de búsqueda
                if (productName.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>