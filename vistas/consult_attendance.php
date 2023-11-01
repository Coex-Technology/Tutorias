<?php

    echo '
        <div class="container is-fluid mb-6">
            <h1 class="title"> Asistencia </h1>
            <h2 class="subtitle"> Lista de usuarios </h2>
        </div>
    <div class="container pb-6 pt-6">';


    $url="index.php?vista=user_list&page=";
    $registros=7;
    $busqueda="";
    $total=1;
    $pagina=1;
    $Npaginas=1;
    $conexion = conexion();

    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    $ci = $_SESSION['ci'];
    $id = 0;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
     

    # Verificando asistencias #
    $check_asistencias=conexion();
    $check_asistencias=$check_asistencias->query("SELECT COUNT(*) FROM asistencias WHERE docente_ci='$ci' AND tutorias_id = '$id'");


    $consulta_asistencias = "SELECT 
        usuarios.ci AS ci,
        usuarios.nombre AS nombre,
        usuarios.apellido AS apellido,
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
        tutorias_tipos.nombre_tipo AS nombre_tipo,
        asistencias.fecha AS fecha,
        asistencias.inasistencias_justificadas AS inasistencias_justificadas,
        asistencias.inasistencias_injustificadas AS inasistencias_injustificadas
    FROM tutorias
    JOIN usuarios ON tutorias.docente_ci = usuarios.ci
    JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
    JOIN asistencias ON asistencias.tutorias_id = tutorias.id
    WHERE tutorias.id = $id AND usuarios.ci = $ci
    ORDER BY fecha ASC";

    $datos_asistencias = $conexion->query($consulta_asistencias);
    $datos_asistencias = $datos_asistencias->fetchAll();


    $contar_asistencia = conexion();
    $contar_asistencia = $contar_asistencia->prepare("SELECT COUNT(*)
    FROM tutorias
    JOIN usuarios ON tutorias.docente_ci = usuarios.ci
    JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
    JOIN tutorias_estudiantes ON tutorias_estudiantes.tutorias_id = tutorias.id
    WHERE tutorias.id = $id AND usuarios.ci = $ci;");

    $contar_asistencia->execute();
    $datos_contar = $contar_asistencia->fetch(PDO::FETCH_ASSOC);
    $total = $datos_contar["COUNT(*)"];

    $tabla="";

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
        </style>';

    $tabla.='			
        <div class="table-container mt-3">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered is-vcentered tabla_encabezado">
                        <th colspan="7"> <p class="tabla_titulo"> Asistencia </p> </th>
                    </tr>
                    <tr class="has-text-centered">
                        <th class="tabla_texto"> <p class="tabla_titulo"> Tutoría </p> </th>
                        <th class="tabla_texto"> <p class="tabla_titulo"> Docente </p> </th>
                        <th class="tabla_texto"> <p class="tabla_titulo"> Fecha </p> </th>
                        <th class="tabla_texto"> Inasistencias Justificadas</th>
                        <th class="tabla_texto"> Inasistencias Injustificadas</th>
                        <th class="tabla_texto" colspan="2"> <p class="tabla_titulo"> Opciones </p> </th>
                    </tr>
                </thead>
                <tbody>
    ';

    if($total>=1){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;

        foreach($datos_asistencias as $rows){

            if($rows['inasistencias_justificadas']  == NULL){
                $rows['inasistencias_justificadas'] = "<i><u> [Inasistencias no ingresadas] </u></i>";
            }

            if($rows['inasistencias_injustificadas']  == NULL){
                $rows['inasistencias_injustificadas'] = "<i><u> [Inasistencias no ingresadas] </u></i>";
            }

            $fecha = $rows['fecha'];
            $fecha = date("d/m/Y", strtotime($fecha));
            
            $tabla.='
                <tr class="has-text-centered" >
                    <td class="tabla_texto">'.$rows['grupo'].'</td>
                    <td class="tabla_texto">'.$rows['nombre'].'</td>
                    <td class="tabla_texto">'.$fecha.'</td>
                    <td class="tabla_texto">'.$rows['inasistencias_justificadas'].'</td>
                    <td class="tabla_texto">'.$rows['inasistencias_injustificadas'].'</td>
                    <td class="tabla_texto">
                        <a href="index.php?vista=user_update&user_ci_up='.$rows['ci'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td class="tabla_texto">
                        <a href="'.$url.$pagina.'&user_ci_del='.$rows['ci'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
        
    }else{
        if($total1>=1){
            $tabla.='
                <tr class="has-text-centered" >
                    <td colspan="9">
                        <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        }else{
            $tabla.='
                <tr class="has-text-centered" >
                    <td colspan="9">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }
            
    $tabla.='</tbody></table></div>';

    if($total>0 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Mostrando lista de asistencias del <strong>'.$pag_inicio.'</strong> al <strong>'.$total.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    echo $tabla;
    echo "<br>";
?>