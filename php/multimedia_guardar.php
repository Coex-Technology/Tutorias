<?php
    require_once "main.php";

    $tema = limpiar_cadena($_POST['tema']);
    $tutorias_id = limpiar_cadena($_POST['tutorias_id']);    

    $fecha_visualizacion = limpiar_cadena($_POST['fecha_visualizacion']);
    $hora_visualizacion = limpiar_cadena($_POST['hora_visualizacion']);

    $hora_eliminacion = limpiar_cadena($_POST['hora_eliminacion']);
    $fecha_eliminacion = limpiar_cadena($_POST['fecha_eliminacion']);

    #$formulario_tipo_archivo = limpiar_cadena($_POST['formulario_tipo_archivo']);
    $formulario_tipo_archivo = "Imagenes";
    $comentarios = limpiar_cadena($_POST["quill_content"]);
    $usuarios_ci = limpiar_cadena($_POST['usuarios_ci']);


    # Crear ID del Archivo #
    $fecha_visualizacion_id = str_replace("-", "", $fecha_visualizacion);
    $hora_visualizacion_id = str_replace(":", "", $hora_visualizacion);
    $id_archivo = $fecha_visualizacion_id . $hora_visualizacion_id;
    $tipo_archivo = $formulario_tipo_archivo;

    $fecha_actual = date('Y-m-d');
    $fecha_visualizacion_formato = date('d/m/Y', strtotime($fecha_visualizacion));
    $hora_actual = date('H:i:s');
    $hora_visualizacion_formato = date('H:i', strtotime($hora_visualizacion));
    $g = "_";

    

    # Verificando campos obligatorios #
    if($tema=="" || $tutorias_id=="" || $fecha_visualizacion=="" || $fecha_eliminacion=="" || $formulario_tipo_archivo==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    # Verificando integridad de los datos #
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-° ]{1,50}",$tema)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE DEL ARCHIVO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("\d{4}-\d{2}-\d{2}",$fecha_visualizacion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La FECHA DE VISUALIZACIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("\d{2}:\d{2}",$hora_visualizacion) && $hora_visualizacion != NULL){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La HORA DE VISUALIZACIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();

    }

    if(verificar_datos("\d{4}-\d{2}-\d{2}",$fecha_eliminacion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La FECHA DE ELIMINACIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("\d{2}:\d{2}",$hora_eliminacion) && $hora_eliminacion != NULL){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
               La HORA DE ELIMINACIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if ($fecha_eliminacion < $fecha_actual) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>¡Verifique los datos!</strong><br>
                    La FECHA DE ELIMINACIÓN no puede ser menor a la fecha actual
                </div>
            ';
            exit();
    }

    if($hora_visualizacion == NULL)
        $hora_visualizacion = "08:00:00";

    if($hora_eliminacion == NULL)
        $hora_eliminacion = "23:59:00";

    

    /* ------------------------------------------ Directorios de Archivos ------------------------------------------ */ 

    /* $conexion=conexion();
    $consulta_datos = "SELECT * FROM usuarios WHERE ci != $usuarios_ci AND activo = 'Activo'";
    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();
    $veificar_usuario = $datos;

    foreach($veificar_usuario as $rows){

        if($rows['usuarios_tipos_id']  == 1){
            $directorio='../multimedia/administrador/';
        
        }elseif($rows['usuarios_tipos_id']  == 2){
            $directorio='../multimedia/docente/';
        
        }
    } */

    $directorio='../multimedia/';


	# Comprobando si se ha Seleccionado un Archivo #
    if(isset($_FILES['formulario_archivo']) && $_FILES['formulario_archivo']['error'] == 0) {

        if($_FILES['formulario_archivo']['name']!="" && $_FILES['formulario_archivo']['size']>0){

            # Creando directorio #
            if(!file_exists($directorio)){
                if(!mkdir($directorio,0777)){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            Error al crear el directorio
                        </div>
                    ';
                    exit();
                }
            }

            # Comprobando el Formato de las Imagenes #
            if($formulario_tipo_archivo == "Imagenes"){

                if(mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="image/gif" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="image/png"){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            La imagen que ha seleccionado es de un formato que no está permitido
                        </div>
                    ';
                    exit();
                }
            }

            # Comprobando el Formato de los Textos #
            if($formulario_tipo_archivo == "Textos"){

                if(mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="application/msword" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="application/pdf" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="application/vnd.ms-powerpoint"){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            El texto que ha seleccionado es de un formato que no está permitido
                        </div>
                    ';
                    exit();
                }
            }

            # Comprobando el Formato de los Audios #
            if($formulario_tipo_archivo == "Audios"){

                if(mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="audio/mpeg" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="audio/wav" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="audio/flac"){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            El audio que ha seleccionado es de un formato que no está permitido
                        </div>
                    ';
                    exit();
                }
            }

            # Comprobando el Formato de los Videos #
            if($formulario_tipo_archivo == "Videos"){

                if(mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="video/mp4" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="video/x-msvideo" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="video/x-flv"){
                    echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            El video que ha seleccionado es de un formato que no está permitido
                        </div>
                    ';
                    exit();
                }
            }


            # Comprobando que el archivo no supere el peso maximo permitido de 10 MB #
            if(($_FILES['formulario_archivo']['size']/1024) > 10240){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El Archivo que ha seleccionado supera el límite de 10MB
                    </div>
                ';
                exit();
            }

            # Extencion de los Archivos #
            switch(mime_content_type($_FILES['formulario_archivo']['tmp_name'])){
                case 'image/jpeg':
                $extension=".jpg";
                break;
                case 'image/gif':
                $extension=".gif";
                break;
                case 'image/png':
                $extension=".png";
                break;

                case 'application/msword':
                $extension=".doc";
                break;
                case 'application/pdf':
                $extension=".pdf";
                break;
                case 'application/vnd.ms-powerpoint':
                $extension=".ppt";
                break;

                case 'audio/mpeg':
                $extension=".mp3";
                break;
                case 'audio/wav':
                $extension=".wav";
                break;
                case 'audio/flac':
                $extension=".flac";
                break;

                case 'video/mp4':
                $extension=".mp4";
                break;
                case 'video/x-msvideo':
                $extension=".avi";
                break;
                case 'video/x-flv':
                $extension=".flv";
                break;
            }

        # Cambiando permisos al directorio #
            chmod($directorio, 0777);

            # Nombre el archivo #
            $archivo_nombre=renombrar_archivos($tema);

            # Nombre final del archivo #
            $archivo_nombre_final=$archivo_nombre;
            $direccion_final = $directorio.$archivo_nombre_final.$g.$id_archivo.$g.$usuarios_ci.$g.$tutorias_id.$extension;

            # Moviendo archivo al directorio #
            if(!move_uploaded_file($_FILES['formulario_archivo']['tmp_name'], $direccion_final)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        No podemos subir el archivo al sistema en este momento, por favor intente nuevamente
                    </div>
                ';
                exit();
            }

        }else{
            $archivo_nombre_final="";
        }
    

        # Verificando lista de repositorios #
        $check_repositorios=conexion();
        $check_repositorios=$check_repositorios->query("SELECT id_archivo, usuarios_ci, tutorias_id FROM repositorios WHERE id_archivo = '$id_archivo' AND usuarios_ci = '$usuarios_ci' AND tutorias_id = '$tutorias_id'");

        if($_FILES['formulario_archivo']['name']!="" && $_FILES['formulario_archivo']['size']>0){
            if(file_exists($direccion_final)){
                if($check_repositorios->rowCount() > 0){
                    if(($fecha_visualizacion <= $fecha_actual) && ($hora_visualizacion <= $hora_actual)){
                        echo '
                            <div class="notification is-info is-light">
                                <strong>¡ARCHIVO SUBIDO!</strong> <br>
                                El archivo se subio correctamente <br>
                                Puede visualizarlo en <a href="index.php?vista=multimedia_subida&id='.$tutorias_id.'"> Materiales </a> 
                            </div>';

                    }else{      
                        echo '
                            <div class="notification is-info is-light">
                                <strong>¡ARCHIVO SUBIDO!</strong><br>
                                El archivo estara disponible para su visualización el '.$fecha_visualizacion_formato.' a las '.$hora_visualizacion_formato.'
                            </div>';
                    }
                    exit();
                }
            }
        }
        $check_repositorios=null;

        $nombre = $archivo_nombre_final.$g.$id_archivo.$g.$usuarios_ci.$g.$tutorias_id.$extension;
        $activo = "Activo";

        # Guardando datos #
        $guardar_datos_repositorio=conexion();
        $guardar_datos_repositorio=$guardar_datos_repositorio->prepare("INSERT INTO repositorios(id_archivo,usuarios_ci,tutorias_id,tema,nombre,comentarios,tipo_archivo,fecha_visualizacion,hora_visualizacion,fecha_eliminacion,hora_eliminacion,activo) VALUES(:id_archivo,:usuarios_ci,:tutorias_id,:tema,:nombre,:comentarios,:tipo_archivo,:fecha_visualizacion,:hora_visualizacion,:fecha_eliminacion,:hora_eliminacion,:activo)");

        $marcadores_repositorios=[
            ":id_archivo"=>$id_archivo,
            ":usuarios_ci"=>$usuarios_ci,
            ":tutorias_id"=>$tutorias_id,
            ":tema"=>$tema,
            ":nombre"=>$nombre,
            ":comentarios"=>$comentarios,
            ":tipo_archivo"=>$tipo_archivo,
            ":fecha_visualizacion"=>$fecha_visualizacion,
            ":hora_visualizacion"=>$hora_visualizacion,
            ":fecha_eliminacion"=>$fecha_eliminacion,
            ":hora_eliminacion"=>$hora_eliminacion,
            ":activo"=>$activo,
        ];

        if(file_exists($direccion_final))
            $guardar_datos_repositorio->execute($marcadores_repositorios);

        $guardar_datos_repositorio=null;
    }
?>