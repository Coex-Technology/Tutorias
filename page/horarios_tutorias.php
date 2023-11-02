<?php
    echo '<section class="sin_barra_horarios">';
    $tabla = '';

    if(!(isset($_GET['id']) && isset($_GET['id']) != "")){
        echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Asistencia </h1>
                <h2 class="subtitle"> Pasar Lista </h2>
            </div>

            <div class="container pt-3 b barra_asistencia"> 
        ';

        $usuario_ci = $_SESSION['ci'];
        
        if($_SESSION['usuarios_tipos_id'] == 2){
            $consulta_datos = "SELECT 
                    (SELECT nombre FROM usuarios WHERE ci = tutorias.administrador_ci) AS nombre,
                    (SELECT apellido FROM usuarios WHERE ci = tutorias.administrador_ci) AS apellido,
                    usuarios.direccion AS direccion,
                    usuarios.registrado AS registrado,
                    usuarios.activo AS activo,
                    tutorias.id AS id,
                    tutorias.docente_ci AS docente_ci,
                    tutorias.administrador_ci AS administrador_ci,
                    tutorias.grupo AS grupo,
                    tutorias.descripcion AS descripcion,
                    tutorias.dias AS dias,
                    tutorias.fecha_inicial AS fecha_inicial,
                    tutorias.fecha_final AS fecha_final,
                    tutorias.hora_inicial AS hora_inicial,
                    tutorias.hora_final AS hora_final,
                    tutorias.activa AS activa,
                    tutorias_tipos.id AS tutorias_tipos_id,
                    tutorias_tipos.nombre_tipo AS nombre_tipo
                FROM tutorias
                JOIN usuarios ON tutorias.docente_ci = usuarios.ci
                JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
                WHERE tutorias.docente_ci = $usuario_ci;";
                $usuario_tipo = "Docente";
        
        }else if($_SESSION['usuarios_tipos_id'] == 3){
            $consulta_datos = "SELECT 
                u.nombre AS nombre,
                u.apellido AS apellido,
                u.direccion AS direccion,
                u.registrado AS registrado,
                u.activo AS activo,
                t.id AS id,
                t.docente_ci AS docente_ci,
                t.administrador_ci AS administrador_ci,
                t.grupo AS grupo,
                t.descripcion AS descripcion,
                t.dias AS dias,
                t.fecha_inicial AS fecha_inicial,
                t.fecha_final AS fecha_final,
                t.hora_inicial AS hora_inicial,
                t.hora_final AS hora_final,
                t.activa AS activa,
                tt.id AS tutorias_tipos_id,
                tt.nombre_tipo AS nombre_tipo
            FROM tutorias_estudiantes te
            JOIN usuarios u ON te.estudiantes_ci = u.ci
            JOIN tutorias t ON te.tutorias_id = t.id
            JOIN tutorias_tipos tt ON t.tutorias_tipos_id = tt.id
            WHERE u.ci = $usuario_ci;";
            $usuario_tipo = "Estudiante";

        }else{
            $consulta_datos = "SELECT 
                    (SELECT nombre FROM usuarios WHERE ci = tutorias.docente_ci) AS nombre,
                    (SELECT apellido FROM usuarios WHERE ci = tutorias.docente_ci) AS apellido,
                    usuarios.direccion AS direccion,
                    usuarios.registrado AS registrado,
                    usuarios.activo AS activo,
                    tutorias.id AS id,
                    tutorias.docente_ci AS docente_ci,
                    tutorias.administrador_ci AS administrador_ci,
                    tutorias.grupo AS grupo,
                    tutorias.descripcion AS descripcion,
                    tutorias.dias AS dias,
                    tutorias.fecha_inicial AS fecha_inicial,
                    tutorias.fecha_final AS fecha_final,
                    tutorias.hora_inicial AS hora_inicial,
                    tutorias.hora_final AS hora_final,
                    tutorias.activa AS activa,
                    tutorias_tipos.id AS tutorias_tipos_id,
                    tutorias_tipos.nombre_tipo AS nombre_tipo
                FROM tutorias
                JOIN usuarios ON tutorias.administrador_ci = usuarios.ci
                JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
                WHERE usuarios.ci = $usuario_ci;";
                $usuario_tipo = "Docente";
        }
        

        $datos = $conexion->query($consulta_datos);
        $datos = $datos->fetchAll();

        $tabla.='
            <style>
            .table.is-fullwidth {
                table-layout: fixed;
                width: 100%;
            }

            .table.is-fullwidth th,
            .table.is-fullwidth td {
                width: auto;
                white-space: normal;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            </style>

            <div class="table-container ml-5 mr-5">
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered is-vcentered tabla_encabezado">
                            <th colspan="5"> <p class="tabla_titulo"> Seleccionar Tutoría </p> </th>
                        </tr>

                        <tr class="has-text-centered">
                            <th class="tabla_texto"> Grupo </th>
                            <th class="tabla_texto"> '.$usuario_tipo.' </th>
                            <th class="tabla_texto"> Dias </th>
                            <th class="tabla_texto"> Tipo </th>
                            <th class="tabla_texto"> Opciones </th>
                        </tr>
                    </thead>
                <tbody>
        ';


        foreach($datos as $rows){

            if($rows['grupo']  == NULL)
                $rows['grupo'] = "<i><u> [Grupo no especificado] </u></i>";

            if($rows['descripcion']  == NULL)
                $rows['descripcion'] = "<i><u> [No se ingreso] </u></i>";

            if($rows['dias']  == NULL)
                $rows['dias'] = "<i><u> [No se ingresaron los dias] </u></i>";

            if($rows['nombre_tipo']  == NULL)
                $rows['nombre_tipo'] = "<i><u> [Tipo no especificado] </u></i>";

            if($rows['fecha_inicial']  == NULL)
                $rows['fecha_inicial'] = "<i><u> [Fecha no ingresada] </u></i>";

            if($rows['fecha_final']  == NULL)
                $rows['fecha_final'] = "<i><u> [Fecha no ingresada] </u></i>";

            if($rows['hora_inicial']  == NULL)
                $rows['hora_inicial'] = "<i><u> [Hora no ingresada] </u></i>";

            if($rows['hora_final']  == NULL)
                $rows['hora_final'] = "<i><u> [Hora no ingresada] </u></i>";

            $hora_inicial = $rows['hora_inicial'];
            $hora_final = $rows['hora_final'];
            $hora_inicial = preg_replace('/^0/', '', substr($hora_inicial, 0, 5));
            $hora_final = preg_replace('/^0/', '', substr($hora_final, 0, 5));

            $fecha_inicial = $rows['fecha_inicial'];
            $fecha_inicial = date("d/m/Y", strtotime($fecha_inicial));
            $fecha_final = $rows['fecha_final'];
            $fecha_final = date("d/m/Y", strtotime($fecha_final));
            
            $tabla.='
                <tr class="has-text-centered">
                    <td class="tabla_texto">'.$rows['grupo'].'</td>';

            $tabla .= '
                <td class="tabla_texto">'.$rows['nombre'].' '.$rows['apellido'].'</td>
                <td class="tabla_texto">'.$rows['dias'].'</td>
                <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>';

            $tabla .= '<td class="tabla_texto is-fullwidth">
                    <a href="'.$url.'&id='.$rows['id'].'&sel=true" class="button is-success is-rounded is-small"> Seleccionar </a>
                </td>
            </tr>';
        }

        $tabla.='</tbody></table></div>';
        $conexion=null;
        echo $tabla;


    }else{

        #---------------------------------- Imprimir Datos ----------------------------------#

        $id = $_GET['id'];

        $consulta_tutorias = "SELECT *
            FROM tutorias
            WHERE id = $id";

        $datos = $conexion->query($consulta_tutorias);
        $datos = $datos->fetchAll();

        foreach($datos as $rows){
            $grupo = $rows['grupo'];
            $dias = $rows['dias'];
            $hora_inicial = $rows['hora_inicial'];
            $hora_inicial = date("H:i", strtotime($hora_inicial));
            $hora_final = $rows['hora_final'];
            $hora_final = date("H:i", strtotime($hora_final));

        }


        echo
        ' <div class="column bajar_contenido">
            <div class="column ">

                <link rel="stylesheet" href="./css/calendario.css">';
                include "./vistas/calendar.php";

        echo '
                <div class="columns is-centered column is-narrow mover_actualizar_derecha">
                    <a href="#" onclick="actualizarPagina()" class="button is-link is-rounded ajustar_boton_actualizar"> Actualizar Calendario </a>
                </div>
            </div>
        </div>

        <h1 class="title has-text-centered"> Recordatorios </h1>

        <div class="columns horarios_tabla">
            <div class="column column is-two-quarters">

                <div class="column recordatorios section">
                    <table class="table is-bordered is-hidden-mobile is-fullwidth">
                            <thead>
                            <tr>
                                <th colspan="3" class="has-text-centered"> <p id="tipoSeleccionado"> Datos de la Tutoría </p> </th>
                            </tr>
                            <tr>
                                <th class="has-text-centered"> Dias </th>
                                <th class="has-text-centered"> Hora </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="contenedor_caja">
                                <td class="has-text-centered">
                                <div class="box has-text-centered">
                                    <span class="has-text-weight-bold"> '.$dias.' </span>
                                </div>

                                <td class="has-text-centered">
                                <div class="box has-text-centered">
                                    <span class="has-text-weight-bold"> '.$hora_inicial.' a '.$hora_final.'</span>
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
                                    <span class="has-text-weight-bold"> '.$grupo.' </span>
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

                        <link rel="stylesheet" href="./css/reloj.css">';
                        include "./vistas/clock.php";
                        echo '

                    </div>
                </div>
            </div>
        </div>';
    }

    echo '</section>';
?>

<script src="./js/actualizar_pagina.js"></script>
<script src="./js/calendario.js"></script>
<script src="./js/reloj.js"></script>