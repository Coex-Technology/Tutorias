function mostrarMensaje(usuario) {
  var mensajeElement = document.getElementById('mensaje');
  mensajeElement.innerHTML = 'Usuario seleccionado:<br> ' + usuario;
  mensajeElement.classList.remove('is-hidden');

  setTimeout(function() {

    // Configuración del difuminado
    mensajeElement.style.opacity = '1';
    var duration = 1000;    // Duración de la animación
    var interval = 50;      // Intervalo de actualización de la animación
    var steps = duration / interval;  // Número de pasos de la animación
    var opacityStep = 1 / steps;     // Paso de cambio de opacidad por cada paso
    
    // Función de animación
    var fadeOutAnimation = setInterval(function() {
      mensajeElement.style.opacity -= opacityStep;
      
      // Comprobar si se ha alcanzado la opacidad mínima (0)
      if (mensajeElement.style.opacity <= 0) {
        clearInterval(fadeOutAnimation);
        mensajeElement.classList.add('is-hidden');
        mensajeElement.style.opacity = '1';    // Restaurar la opacidad original
      }
    }, interval);
  }, 3000);    // Retraso antes de comenzar la animación

  setTimeout(function() {
    mensajeElement.classList.add('is-hidden');
  }, 4000);    // Duración del mensaje
}


function seleccionarTipo(tipo) {

  document.getElementById("tipo").value = tipo;
  
  // Actualiza el texto seleccionado
  document.getElementById("tipoSeleccionado").textContent = tipo;
}

function cambiarTextoGuardar() {
  var guardarElement = document.querySelector(".guardar");
  
  // Verificar si se ha seleccionado un elemento del listado
  var elementoSeleccionado = document.querySelector(".dropdown-item.active");
  
  if (elementoSeleccionado) {
      guardarElement.textContent = "Guardar";
  } else {
      guardarElement.textContent = "Tipo de Usuario\nno Seleccionado";
  }
}


document.addEventListener("DOMContentLoaded", function () {
  // Obtiene el botón "Guardar" y el párrafo de la clase "guardar"
  var guardarButton = document.querySelector(".button.is-danger.is-rounded");
  var guardarText = document.querySelector(".guardar");

  var textoOriginal = guardarText.textContent;

  document.querySelectorAll(".dropdown-item").forEach(function (item) {
    item.addEventListener("click", function () {

      guardarText.textContent = "Guardar Usuario";
      guardarButton.classList.remove("is-danger");
      guardarButton.classList.add("is-info");

      guardarButton.disabled = false;
    });
  });

  guardarButton.disabled = true;
});


document.addEventListener('DOMContentLoaded', function () {
  const selectPais = document.getElementById('pais');
  const inputTelefono = document.getElementById('telefono');

  selectPais.value = "UY";
  
  const codigoPais = selectPais.options[selectPais.selectedIndex].getAttribute('data-codigo');
  
  // Establece el valor inicial del campo de teléfono
  inputTelefono.value = codigoPais;
});

function updateTelefono() {
  const selectPais = document.getElementById('pais');
  const inputTelefono = document.getElementById('telefono');
  
  // Obtén el valor seleccionado en el select
  const paisSeleccionado = selectPais.value;
  
  // Obtén el código de país del atributo data
  const codigoPais = selectPais.options[selectPais.selectedIndex].getAttribute('data-codigo');
  
  // Actualiza el valor del input con el valor del país seleccionado
  inputTelefono.value = codigoPais;
}