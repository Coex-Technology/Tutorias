<!DOCTYPE html>
<html class="barra_desplazamiento">
<head>
    <title> Horarios </title>

    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="./css/reloj.css">
    
</head>

<body>


    <div class="column bajar_contenido">
        <div class="column ">

            <link rel="stylesheet" href="./css/calendario.css">
            <?php include "./vistas/calendar.php" ?>
            <script src="./js/calendario.js"></script>

            <div class="columns is-centered column is-narrow mover_actualizar_derecha">
                <a href="#" onclick="actualizarPagina()" class="button is-link is-rounded ajustar_boton_actualizar"> Actualizar Calendario </a>
            </div>
        </div>
    </div>

    <h1 class="title has-text-centered"> Recordatorios </h1>

    <div class="columns horarios_tabla mt-6">
        <div class="column column is-two-quarters">

            <div class="column">
                <table class="table is-bordered is-hidden-mobile is-fullwidth">
                        <thead>
                        <tr>
                            <th colspan="3" class="has-text-centered"> <p id="tipoSeleccionado"> Ingresar Recordatorio </p> </th>
                        </tr>
                        <tr>
                            <th class="has-text-centered"> Nombre </th>
                            <th class="has-text-centered"> Fecha y hora </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="contenedor_caja">
                            <td class="has-text-centered">
                            <div class="box has-text-centered">
                                <span class="has-text-weight-bold"> "Nombre" </span>
                            </div>

                            <td class="has-text-centered">
                            <div class="box has-text-centered">
                                <span class="has-text-weight-bold"> "Fecha" </span>
                            </div>
                            </td>

                        </tr>

                        <table class="table is-bordered is-hidden-mobile is-fullwidth">
                        <thead>
                        <tr>
                            <th colspan="2"> <p class="ml-4"> Descripción </p> </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="has-text-centered contenedor_caja">
                            <div class="box has-text-centered">
                                <br>
                                <span class="has-text-weight-bold"> "Descripción del recordatorio" </span>
                                <br> <br>
                            </div>

                        </tr>
                        </tbody>
                    </table>
                    </tbody>
                </table>    
            </div>

        </div>
            
        <div class="column column is-two-quarters">
            <div class="columns is-flex-direction-column">
                <div class="column fondo">

                    <link rel="stylesheet" href="./css/reloj.css">
                    <?php include "./vistas/clock.php" ?>
                    <script src="./js/reloj.js"></script>

                </div>
            </div>
        </div>
    </div>

    <script src="./js/actualizar_pagina.js"></script>
    
</body>
</html>