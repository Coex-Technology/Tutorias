<?php
    require_once "main.php";

    $grupo=limpiar_cadena($_POST['grupo']);
    $descripcion=limpiar_cadena($_POST['descripcion']);

    $fecha_inicial=limpiar_cadena($_POST['fecha_inicial']);
    $fecha_final=limpiar_cadena($_POST['fecha_final']);

    $hora_inicial=limpiar_cadena($_POST['hora_inicial']);
    $hora_final=limpiar_cadena($_POST['hora_final']);

    $dias=limpiar_cadena($_POST['dias']);

    $docente_ci=limpiar_cadena($_POST['docente_ci']);
    $administrador_ci=limpiar_cadena($_POST['administrador_ci']);
    $tutorias_tipos_id=limpiar_cadena($_POST['tutorias_tipos_id']);
    $activa="Activa";


    # Asignar ID #
    $numero_dias = ["01", "02", "03", "04", "05", "06", "07"];
    $numero_del_dia = date("w", strtotime($dias));
    $dias_id = $numero_dias[$numero_del_dia];

    $partes = explode(":", $hora_inicial);
    $hora_id = $partes[0] . str_replace(":", "", $partes[1]);

    $id = $docente_ci . $dias_id . $hora_id;


    // $fecha_dias = $dias;
    $nombre_dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    $posicion_del_dia = date("w", strtotime($dias));
    $dias = $nombre_dias[$posicion_del_dia];

    /*Verificando tutoria existente */
    $conexion = conexion();
    $verificar_tutoria_existente = $conexion->query("SELECT id FROM tutorias WHERE id = $id");
    

    if ($verificar_tutoria_existente->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Ya existe una tutoría con los mismos datos.
                <a href="index.php?vista=tutorship_list"> <br> Click aquí para ver la lista de tutorias existentes </a>
            </div>
        ';
        exit();

    } else {

        /*Verificando campos obligatorios*/
        if($grupo=="" || $fecha_inicial == "" || $fecha_final == "" || $hora_inicial == "" || $hora_final == "" || $dias=="" || $docente_ci=="" || $administrador_ci=="" || $tutorias_tipos_id==""){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos que son obligatorios
                </div>
            ';
            exit();
        }

        /*Verificando integridad de los datos*/
        if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-°* ]{3,50}",$grupo)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El nombre del GRUPO no coincide con el formato solicitado
                </div>
            ';
            exit();
        }
        
        if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,100}",$dias)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Los DIAS no coinciden con el formato solicitado
                </div>
            ';
            exit();
        }

        if($descripcion != ""){
            if(verificar_datos("a-zA-ZáéíóúÁÉÍÓÚ$@.-*0-9 ]{0,1000}",$descripcion)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La DESCRIPCIÓN no coincide con el formato solicitado
                    </div>
                ';
                exit();
            }
        }

        if($fecha_inicial != ""){
            if(verificar_datos("^\d{4}-\d{2}-\d{2}$",$fecha_inicial)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La FECHA DE INICIO no coincide con el formato solicitado
                    </div>
                ';
                exit();
            }
        }

        if($hora_inicial != ""){
            if(verificar_datos("^\d{2}:\d{2}$",$hora_inicial)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El HORARIO DE INCIO no coincide con el formato solicitado
                    </div>
                ';
                exit();
            }
        }


        if($fecha_final != ""){
            if(verificar_datos("^\d{4}-\d{2}-\d{2}$",$fecha_final)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La FECHA DE FINALIZACIÓN no coincide con el formato solicitado
                    </div>
                ';
                exit();
            }
        }

        if($hora_final != ""){
            if(verificar_datos("^\d{2}:\d{2}$",$hora_final)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El HORARIO DE FINALIZACIÓN no coincide con el formato solicitado
                    </div>
                ';
                exit();
            }
        }
        $check_tutoria=null;


        $guardar_tutoria=conexion();
        $guardar_tutoria=$guardar_tutoria->prepare ("INSERT INTO tutorias (id,docente_ci,administrador_ci,grupo,descripcion,dias,fecha_inicial,fecha_final,hora_inicial,hora_final,activa,tutorias_tipos_id) VALUES(:id,:docente_ci,:administrador_ci,:grupo,:descripcion,:dias,:fecha_inicial,:fecha_final,:hora_inicial,:hora_final,:activa,:tutorias_tipos_id)");

        $marcadores=[
            ":id"=>$id,
            ":docente_ci"=>$docente_ci,
            ":administrador_ci"=>$administrador_ci,
            ":grupo"=>$grupo,
            ":descripcion"=>$descripcion,
            ":dias"=>$dias,
            ":fecha_inicial"=>$fecha_inicial,
            ":fecha_final"=>$fecha_final,
            ":hora_inicial"=>$hora_inicial,
            ":hora_final"=>$hora_final,
            ":activa"=>$activa,
            ":tutorias_tipos_id"=>$tutorias_tipos_id,
        ];

        $guardar_tutoria->execute($marcadores);


        if ($guardar_tutoria->rowCount() == 1) {
            echo '
                <div class="notification is-info is-light">
                    <strong>¡TUTORÍA CREADA!</strong><br>
                    La tutoría se creó con éxito<br>
                    <a href="index.php?vista=tutorship_users&docente_ci=' . $docente_ci . '&dias=' . $dias . '&hora_inicial=' . $hora_inicial . '"> Click aquí para agregar estudiantes </a>
                </div>
            ';
        
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo registrar la tutoría, por favor intente nuevamente
                </div>
            ';
        }

    }

    $guardar_tutoria=null;
    $verificar_tutoria_existente = null;
?>