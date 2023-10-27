function mostrarMensaje(tutoria) {
  var mensajeElement = document.getElementById('mensaje');
  mensajeElement.innerHTML = 'Tipo de Tutoría:<br>' + tutoria;
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
