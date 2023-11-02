<?php
    # echo '<pre>';
    # print_r($_POST);
    # echo '</pre>';

    require_once "main.php";

    $docente_ci = limpiar_cadena($_POST['ci']);
    $tutorias_id = limpiar_cadena($_POST['id']);
    $fecha = limpiar_cadena($_POST['fecha']);
    $fecha_ingreso = date('Y-m-d');
    $inasistencias_justificadas = $_POST['inasistencias_justificadas'];
    $inasistencias_injustificadas = $_POST['inasistencias_injustificadas'];
    $conexion = conexion();

    $estudiantes_ci = " ";

    # Verificando campos obligatorios #
    if ($estudiantes_ci == "" || $tutorias_id == "" || $docente_ci == "" || $fecha_ingreso == "" || $fecha == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    $verificar = "SELECT COUNT(*) FROM asistencias WHERE tutorias_id = '".$tutorias_id."' AND fecha = '".$fecha."'";

    $verificacion = $conexion->query($verificar);
	$verificacion = (int) $verificacion->fetchColumn();

    $fecha_verificar = false;

    if(isset($_GET['fecha']))
        $fecha_verificar = true;

    if($verificacion > 0) {
        if (!isset($_SESSION['formulario_enviado'])) {

            foreach ($inasistencias_justificadas as $estudiante_ci => $falta) {
                $marcadores_asistencia = [
                    ":tutorias_id" => $tutorias_id,
                    ":estudiantes_ci" => $estudiante_ci,
                    ":docente_ci" => $docente_ci,
                    ":fecha" => $fecha,
                    ":fecha_ingreso" => $fecha_ingreso,
                    ":inasistencias_justificadas" => $falta,
                ];
            
                $guardar_asistencia = $conexion->prepare("UPDATE asistencias
                    SET fecha = :fecha,
                        docente_ci = :docente_ci,
                        inasistencias_justificadas = :inasistencias_justificadas
                    WHERE tutorias_id = :tutorias_id
                        AND estudiantes_ci = :estudiantes_ci
                        AND fecha = :fecha;");
                
                $guardar_asistencia->execute($marcadores_asistencia);
            } 

            foreach ($inasistencias_injustificadas as $estudiante_ci => $falta) {
                $marcadores_asistencia = [
                    ":tutorias_id" => $tutorias_id,
                    ":estudiantes_ci" => $estudiante_ci,
                    ":docente_ci" => $docente_ci,
                    ":fecha" => $fecha,
                    ":fecha_ingreso" => $fecha_ingreso,
                    ":inasistencias_injustificadas" => $falta,
                ];
            
                $guardar_asistencia = $conexion->prepare("UPDATE asistencias
                    SET fecha = :fecha,
                        docente_ci = :docente_ci,
                        inasistencias_injustificadas = :inasistencias_injustificadas
                    WHERE tutorias_id = :tutorias_id
                        AND estudiantes_ci = :estudiantes_ci
                        AND fecha = :fecha;");
                
                $guardar_asistencia->execute($marcadores_asistencia);
            }            

            if ($guardar_asistencia !== null && $guardar_asistencia->rowCount() == 1) {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡ASISTENCIA REGISTRADA!</strong><br>
                        La asistencia se registró con éxito,
                        <a href="index.php?vista=consult_attendance&id='.$tutorias_id.'"> puede consultarla aquí </a>
                    </div>
                ';
            } else {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡ASISTENCIA REGISTRADA!</strong><br>
                        La asistencia se registró con éxito,
                        <a href="index.php?vista=consult_attendance&id='.$tutorias_id.'"> puede consultarla aquí </a>
                    </div>
                ';
            }
        }



    
    }else{
        if (!isset($_SESSION['formulario_enviado'])) {
            $guardar_asistencia = $conexion;

            foreach ($inasistencias_justificadas as $estudiante_ci => $falta) {
                $marcadores_asistencia = [
                    ":tutorias_id" => $tutorias_id,
                    ":estudiantes_ci" => $estudiante_ci,
                    ":docente_ci" => $docente_ci,
                    ":fecha" => $fecha,
                    ":fecha_ingreso" => $fecha_ingreso,
                    ":inasistencias_justificadas" => $falta,
                ];

                $guardar_asistencia = $conexion->prepare("INSERT INTO asistencias(tutorias_id,estudiantes_ci,docente_ci,fecha,fecha_ingreso,inasistencias_justificadas) VALUES (:tutorias_id,:estudiantes_ci,:docente_ci,:fecha,:fecha_ingreso,:inasistencias_justificadas)");
                $guardar_asistencia->execute($marcadores_asistencia);
            }

            foreach ($inasistencias_injustificadas as $estudiante_ci => $falta) {
                $marcadores_asistencia = [
                    ":tutorias_id" => $tutorias_id,
                    ":estudiantes_ci" => $estudiante_ci,
                    ":fecha" => $fecha,
                    ":fecha_ingreso" => $fecha_ingreso,
                    ":inasistencias_injustificadas" => $falta,
                ];

                $guardar_asistencia = $conexion->prepare("UPDATE asistencias SET fecha = :fecha, fecha_ingreso = :fecha_ingreso, inasistencias_injustificadas = :inasistencias_injustificadas WHERE tutorias_id = :tutorias_id AND estudiantes_ci = :estudiantes_ci AND fecha = :fecha");
                $guardar_asistencia->execute($marcadores_asistencia);
            }

            if ($guardar_asistencia !== null && $guardar_asistencia->rowCount() == 1) {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡ASISTENCIA REGISTRADA!</strong><br>
                        La asistencia se registró con éxito,
                        <a href="index.php?vista=consult_attendance&id='.$tutorias_id.'"> puede consultarla aquí </a>
                    </div>
                ';
            } else {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡ASISTENCIA REGISTRADA!</strong><br>
                        La asistencia se registró con éxito,
                        <a href="index.php?vista=consult_attendance&id='.$tutorias_id.'"> puede consultarla aquí </a>
                    </div>
                ';
            }
        }
    
    }

    $guardar_asistencia = null;
?>
