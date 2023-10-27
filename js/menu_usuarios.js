// Función para mostrar u ocultar opciones según la selección del panel
const tabs = document.querySelectorAll('.panel-tabs a');
const optionsContainers = document.querySelectorAll('.hidden-opciones');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const option = tab.getAttribute('data-toggle');
        optionsContainers.forEach(opt => {
            if (opt.getAttribute('data-option') === option) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });
    });
});



// Mostrar las opciones del tab activo por defecto (Tutorías)
optionsContainers[0].style.display = 'block';

// Obtén el botón por su ID
var botonRecargar = document.getElementById("recargar");

// Agrega un evento de clic al botón
botonRecargar.addEventListener("click", function() {
    // Utiliza location.reload() para recargar la página
    location.reload();
});



document.addEventListener('DOMContentLoaded', function () {
    // Obtén la entrada de búsqueda y los enlaces a los elementos a buscar
    const searchInput = document.querySelector('.input');
    const links = document.querySelectorAll('.panel-block');
    const panel = document.querySelector('.panel');
    
    // Variable para controlar si se debe realizar la búsqueda
    let shouldSearch = false;
    
    // Agrega un evento de escucha al input de búsqueda
    searchInput.addEventListener('input', function () {
        shouldSearch = true; // Marca que se debe realizar la búsqueda
    });
    
    // Agrega un evento de escucha al formulario para prevenir el envío por teclas diferentes de "Enter"
    searchInput.addEventListener('keydown', function (event) {
        if (event.key !== 'Enter') {
            shouldSearch = false; // No se debe realizar la búsqueda para otras teclas
        }
    });
    
    // Agrega un evento de escucha al formulario para realizar la búsqueda cuando se presiona "Enter"
    searchInput.addEventListener('keyup', function (event) {
        if (event.key === 'Enter' && shouldSearch) {
            // Realiza la búsqueda cuando se suelta "Enter"
            const searchTerm = searchInput.value.toLowerCase();
            links.forEach(function (link) {
                const text = link.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    link.style.display = 'block';
                } else {
                    link.style.display = 'none';
                }
            });
            
            // Crear y agregar el botón "Recargar Búsqueda" al final de la búsqueda
            const recargarDiv = document.createElement('div');
            recargarDiv.className = 'panel-block';
            const recargarButton = document.createElement('button');
            recargarButton.className = 'button is-success is-outlined is-fullwidth';
            recargarButton.id = 'recargar';
            recargarButton.textContent = 'Recargar Búsqueda';
            recargarButton.addEventListener('click', function () {
                location.reload(); // Recargar la página cuando se hace clic en el botón
            });
            recargarDiv.appendChild(recargarButton);
            panel.appendChild(recargarDiv); // Agregar al final del panel
        }
    });
});
