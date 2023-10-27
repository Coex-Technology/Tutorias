<?php
    require_once "main.php";

    $nombre = limpiar_cadena($_POST['nombre']);
    $tutorias_datos = limpiar_cadena($_POST['tutorias_datos']);    

    $fecha_visualizacion = limpiar_cadena($_POST['fecha_visualizacion']);
    $hora_visualizacion = limpiar_cadena($_POST['hora_visualizacion']);

    $hora_eliminacion = limpiar_cadena($_POST['hora_eliminacion']);
    $fecha_eliminacion = limpiar_cadena($_POST['fecha_eliminacion']);

    $formulario_tipo_archivo = limpiar_cadena($_POST['formulario_tipo_archivo']);
    $comentarios = limpiar_cadena($_POST["quill_content"]);


    $datos_divididos = explode("|", $tutorias_datos);
    $tutorias_id = $datos_divididos[0];
    $usuarios_ci = $datos_divididos[1];


    # Crear ID del Archivo #
    $fecha_visualizacion_id = str_replace("-", "", $fecha_visualizacion);
    $hora_visualizacion_id = str_replace(":", "", $hora_visualizacion);
    $id_archivo = $fecha_visualizacion_id . $hora_visualizacion_id;
    $tipo_archivo = $formulario_tipo_archivo;
    

    # Verificando campos obligatorios #
    if($nombre=="" || $tutorias_id=="" || $fecha_visualizacion=="" || $fecha_eliminacion=="" || $formulario_tipo_archivo==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    if($quillContent = ""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Comentario Vacio
            </div>
        ';
        exit();
    }

    # Verificando integridad de los datos #
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-° ]{1,50}",$nombre)){
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

    if($hora_visualizacion == NULL)
        $hora_visualizacion = "08:00:00";

    if($hora_eliminacion == NULL)
        $hora_eliminacion = "23:59:00";

    

    /* ------------------------------------------ Directorios de imagenes ------------------------------------------ */ 

    // $conexion=conexion();
    // $consulta_datos = "SELECT * FROM usuarios WHERE ci != $usuarios_ci AND activo = 'Activo'";
    // $datos = $conexion->query($consulta_datos);
	// $datos = $datos->fetchAll();
    // $veificar_usuario = $datos;

    // foreach($veificar_usuario as $rows){

    //     if($rows['usuarios_tipos_id']  == "1"){
    //         $directorio='../multimedia/administrador/';
        
    //     }elseif($rows['usuarios_tipos_id']  == "2"){
    //         $directorio='../multimedia/docente/';
        
    //     }elseif($rows['usuarios_tipos_id']  == "3"){
    //         $directorio='../multimedia/estudiante/';
    //     }


    // }

    $consulta_datos="SELECT ci, usuarios_tipos_id FROM usuarios WHERE ci = '$usuarios_ci' ORDER BY nombre";

    $conexion=conexion();
    $datos_usuario = $conexion->query($consulta_datos);
    $datos_usuario = $datos_usuario->fetchAll();

    foreach($datos_usuario as $rows){
        $rows['ci'];
        $rows['usuarios_tipos_id'];

        $usuario = $rows['usuarios_tipos_id'];
    }

    if($usuario != ""){
        if($usuario == 1){
            $directorio='../multimedia/administrador/';

        }elseif($usuario == 2){
            $directorio='../multimedia/docente/';

        }elseif($usuario == 3){
            $directorio='../multimedia/estudiante/';
        }
    }


    if($formulario_tipo_archivo == "Imagenes")
        $directorio .= "imagenes";

    if($formulario_tipo_archivo == "Textos")
        $directorio .= "textos";

    if($formulario_tipo_archivo == "Audios")
        $directorio .= "audios";

    if($formulario_tipo_archivo == "Videos")
        $directorio .= "videos";


	# Comprobando si se ha Seleccionado un Archivo #
    if(isset($_FILES['formulario_archivo']) && $_FILES['formulario_archivo']['error'] == 0) {

        if($_FILES['formulario_archivo']['name']!="" && $_FILES['formulario_archivo']['size']>0){

            /* Creando directorio */
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

            /* Comprobando el Formato */
            /*if(mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['formulario_archivo']['tmp_name'])!="image/png"){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El Archivo que ha seleccionado es de un formato que no está permitido
                    </div>
                ';
                exit();
            }*/


            # Comprobando que el archivo no supere el peso maximo permitido de 10 MB #
            if(($_FILES['formulario_archivo']['size']/1024) > 10240){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El Archivo que ha seleccionado supera el límite de peso permitido
                    </div>
                ';
                exit();
            }


            /* extencion de las imagenes */
            switch(mime_content_type($_FILES['formulario_archivo']['tmp_name'])){
                case 'image/jpeg':
                $img_ext=".jpg";
                break;
                case 'image/png':
                $img_ext=".png";
                break;
            }

            /* Cambiando permisos al directorio */
            chmod($directorio, 0777);

            /* Nombre de la imagen */
            $img_nombre=renombrar_archivos($nombre);

            /* Nombre final de la imagen */
            //$foto=$img_nombre.$img_ext;
            $foto=$img_nombre;

            /* Moviendo imagen al directorio */
            if(!move_uploaded_file($_FILES['formulario_archivo']['tmp_name'], $directorio.$foto)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
                    </div>
                ';
                exit();
            }

        }else{
            $foto="";
        }
    }

    # Verificando lista de repositorios #
    $check_repositorios=conexion();
    $check_repositorios=$check_repositorios->query("SELECT id_archivo, usuarios_ci, tutorias_id FROM repositorios WHERE id_archivo = '$id_archivo' AND usuarios_ci = '$usuarios_ci' AND tutorias_id = '$tutorias_id'");

    if($check_repositorios->rowCount() > 0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No esta permitido subir dos archivo con la misma fecha y hora de visualizacion, por favor modifique los datos
            </div>
        ';
        exit();
    }
    $check_repositorios=null;


    # Guardando datos #
    $guardar_datos_repositorio=conexion();
    $guardar_datos_repositorio=$guardar_datos_repositorio->prepare("INSERT INTO repositorios(id_archivo,usuarios_ci,tutorias_id,nombre,comentarios,tipo_archivo,fecha_visualizacion,hora_visualizacion,fecha_eliminacion,hora_eliminacion) VALUES(:id_archivo,:usuarios_ci,:tutorias_id,:nombre,:comentarios,:tipo_archivo,:fecha_visualizacion,:hora_visualizacion,:fecha_eliminacion,:hora_eliminacion)");

    $marcadores_repositorios=[
        ":id_archivo"=>$id_archivo,
        ":usuarios_ci"=>$usuarios_ci,
        ":tutorias_id"=>$tutorias_id,
        ":nombre"=>$nombre,
        ":comentarios"=>$comentarios,
        ":tipo_archivo"=>$tipo_archivo,
        ":fecha_visualizacion"=>$fecha_visualizacion,
        ":hora_visualizacion"=>$hora_visualizacion,
        ":fecha_eliminacion"=>$fecha_eliminacion,
        ":hora_eliminacion"=>$hora_eliminacion,
    ];

    $guardar_datos_repositorio->execute($marcadores_repositorios);


    if($guardar_datos_repositorio->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>Archivo REGISTRADO!</strong><br>
                El archivo se subio correctamente
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo guardar los datos del archivo, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_datos_repositorio=null;
?>