<!DOCTYPE html>
<html class="barra_desplazamiento">
<head>
    <title> Fecha del Examen </title>
    <link rel="stylesheet" href="./css/bulma.min.css">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="./css/calendario.css">
</head>

<body>
    
    <div class="columns horarios_tabla">

        <div class="column mt-4">

            <div class="column mt-5">
                <table class="table is-bordered is-hidden-mobile is-fullwidth">
                    <thead>
                    <tr>
                        <th colspan="2"> <p class="ml-5"> Nombre </p> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="contenedor_caja">
                        <td class="has-text-centered">
                        <div class="box has-text-centered">
                            <span class="has-text-weight-bold"> "Nombre y área" </span>
                        </div>

                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="column mt-5">
                <table class="table is-bordered is-hidden-mobile is-fullwidth">
                    <thead>
                    <tr>
                        <th colspan="2"> <p class="ml-5"> Descripción </p> </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="contenedor_caja">
                            <td class="has-text-centered">
                            <div class="box has-text-centered">
                                <span class="has-text-weight-bold"> "Descripcion del recordatorio" </span>
                            </div>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            
                

        <div class="column">
            <?php include "./vistas/calendar.php" ?> 
            <link rel="stylesheet" href="./css/calendario.css">
            <script src="./js/calendario.js"></script>
        </div>

    </div>

    <div class="column examen_tabla">
            <table class="table is-bordered is-hidden-mobile is-fullwidth">
                <thead>
                    <tr>
                        <th colspan="2"> <p class="ml-5"> Examen </p> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="contenedor_caja">
                        <td class="has-text-centered">
                        <div class="box has-text-centered">
                            <span class="has-text-weight-bold"> "Temas del Examen" </span>
                        </div>

                    </tr>
                </tbody>
            </table>
        </div>
</body>
</html>