var swiper = new Swiper(".mySwiper-2", {
    slidesPerView:3,
    spaceBetween: 20,
    loop:true,
    loopFillGroupWithBlank:true,

    navigation:{
        nextEl:".swiper-button-next",
        prevEl:".swiper-button-prev", // Corregir aquí
    },
    breakpoints : {
        0: {
            slidesPerView:1,
        },
        520:{
            slidesPerView:2,
        },
        950:{
            slidesPerView:3,
        }
    }
});



let tabInputs = document.querySelectorAll(".tabInput");
tabInputs.forEach(function(input){
    input.addEventListener('change', function(){
        let id = input.ariaValueMax;
        let thisSwiper = document.getElementById('swiper' + id);
        thisSwiper.swiper.update();
    })
});

$(document).ready(function() {
    // Función para actualizar la lista de productos
    function actualizarProductos() {
        $.ajax({
            url: 'index.php', // URL del script PHP que maneja la actualización de productos
            type: 'GET', // Método de solicitud
            dataType: 'html', // Tipo de datos esperado en la respuesta
            success: function(data) {
                // Actualizar la sección de productos con los datos recibidos del servidor
                $('.products').html(data);
            },
            error: function(xhr, status, error) {
                // Manejar errores de Ajax
                console.error('Error en la solicitud Ajax: ' + status + ' - ' + error);
            }
        });
    }

    // Llamar a la función de actualización al cargar la página
    actualizarProductos();

    // Agregar eventos de actualización cuando se realicen acciones de CRUD
    // Por ejemplo, después de agregar un nuevo producto
    // Puedes llamar a actualizarProductos() aquí
});




