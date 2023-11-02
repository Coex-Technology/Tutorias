<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    /* Verifica si los campos del formulario se enviaron correctamente */
    if (!isset($_POST['id'], $_POST['ci'], $_POST['fecha'], $_POST['inasistencias_justificadas'], $_POST['inasistencias_injustificadas'])) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Los campos del formulario no se enviaron correctamente.
            </div>
        ';
        exit();
    }

    /* Almacenando datos */
    $id = limpiar_cadena($_POST['id']);
    $ci = limpiar_cadena($_POST['ci']);
    $fecha = limpiar_cadena($_POST['fecha']);

    $inasistencias_justificadas = limpiar_cadena($_POST['inasistencias_justificadas']);
    $inasistencias_injustificadas = limpiar_cadena($_POST['inasistencias_injustificadas']);


    /* Verificar la Asistencia */
    $check_asistencias = conexion()->query("SELECT tutorias_id, estudiantes_ci, fecha
    FROM asistencias
    WHERE tutorias_id='$id' AND estudiantes_ci='$ci' AND fecha='$fecha'");

    if ($check_asistencias->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La asistencia ingresada no existe en el sistema
            </div>
        ';
        exit();
    }

    $check_tutoria = null;


    /* Verificando integridad de los datos */
    if (verificar_datos("[0-9]", $inasistencias_justificadas)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La inasistencia justificada ingresada no coincide con el formato esperado
            </div>
        ';
        exit();
    }


    if (verificar_datos("[0-9]", $inasistencias_injustificadas)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La inasistencia injustificada ingresada no coincide con el formato esperado
            </div>
        ';
        exit();
    }


    /* Actualizar datos */
    $actualizar_asistencia = conexion()->prepare("UPDATE asistencias
    SET inasistencias_justificadas=:inasistencias_justificadas,inasistencias_injustificadas=:inasistencias_injustificadas
    WHERE tutorias_id=:tutorias_id AND estudiantes_ci=:estudiantes_ci AND fecha=:fecha");

    $marcadores = [
        ":tutorias_id" => $id,
        ":estudiantes_ci" => $ci,
        ":fecha" => $fecha,
        ":inasistencias_justificadas" => $inasistencias_justificadas,
        ":inasistencias_injustificadas" => $inasistencias_injustificadas,
    ];

    $actualizar_asistencia->execute($marcadores);


    if ($actualizar_asistencia->rowCount() > 0) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡ASISTENCIA ACTUALIZADA!</strong><br>
                La asistencia se actualizó con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-white is-light">
                <strong>¡VERIFICA LOS DATOS!</strong><br>
                No se ha seleccionado ningun dato para modificar
            </div>
        ';
    }

    $actualizar_tutoria2 = null;
    $actualizar_tutoria = null;
?>
