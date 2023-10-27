var fechaActual = new Date();
var year = fechaActual.getFullYear();
var month = fechaActual.getMonth();

function updateCalendar() {
  var fechaInicio = new Date(year, month, 1);
  var primerDia = fechaInicio.getDay();

  var diasAntes = (primerDia >= 1) ? primerDia - 1 : 6; // Días antes del primer día de la semana

  fechaInicio.setDate(fechaInicio.getDate() - diasAntes);

  var fechaFin = new Date(fechaInicio);
  fechaFin.setDate(fechaFin.getDate() + 6 * 7 - 1);

  var mesAnioElement = document.getElementById('mes-anio');
  mesAnioElement.textContent = getMonthName(month) + ' ' + year;

  var diasContainer = document.getElementById('dias-container');
  diasContainer.innerHTML = '';

  var fecha = new Date(fechaInicio);
  while (fecha <= fechaFin) {
    var diaElement = document.createElement('div');
    var dia = fecha.getDate();
    diaElement.textContent = dia;
    diaElement.classList.add('dia');
    if (fecha.getFullYear() === fechaActual.getFullYear() && fecha.getMonth() === fechaActual.getMonth() && dia === fechaActual.getDate()) {
      diaElement.classList.add('hoy');
    }
    if (fecha.getMonth() !== month) {
      diaElement.classList.add('otro-mes');
    }
    diasContainer.appendChild(diaElement);

    fecha.setDate(fecha.getDate() + 1);
  }
}

function getMonthName(month) {
  var nombresMeses = [
    'Enero del', 'Febrero del', 'Marzo del', 'Abril del', 'Mayo del', 'Junio del', 
    'Julio del', 'Agosto del', 'Septiembre del', 'Octubre del', 'Noviembre del', 'Diciembre del'];
  return nombresMeses[month];
}

function previousMonth() {
  month--;
  if (month < 0) {
    month = 11;
    year--;
  }
  updateCalendar();
}

function nextMonth() {
  month++;
  if (month > 11) {
    month = 0;
    year++;
  }
  updateCalendar();
}

// Actualizar el calendario al cargar la página
updateCalendar();
