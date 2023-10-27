<!DOCTYPE html>
<html>
<head>
  <title> Calendario </title>

  <!-- <link rel="stylesheet" href="../css/bulma.min.css">
  <link rel="stylesheet" href="../css/calendario.css"> -->
  <!-- <script src="../js/calendario.js"></script> -->

</head>

<body>
  
  <div class="container">
    <div class="column">
      <div class="calendario">
        <div class="mes">
          <a href="#" onclick="previousMonth()" class="button is-primary is-small is-rounded flecha_izquierda">&lt;</a>
            <span class="mes-anio" id="mes-anio"></span>
          <a href="#" onclick="nextMonth()" class="button is-primary is-small is-rounded flecha_derecha">&gt;</a>
        </div>

        <div class="dias-semana mt-6 mb-4">

          <div class="dia">Lunes</div>
          <div class="dia">Martes</div>
          <div class="dia">Miércoles</div>
          <div class="dia">Jueves</div>
          <div class="dia">Viernes</div>
          <div class="dia">Sábado</div>
          <div class="dia">Domingo</div>
        </div>

        <div class="dias" id="dias-container"></div>
      </div>
    </div>
  </div>

</body>