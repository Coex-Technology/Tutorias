<?php

    $estudiante = $_SESSION['usuarios_tipos_id'] == 3;
    if($estudiante)
        echo "<script> window.location.href='index.php?vista=home'; </script>";
    
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $usuarios_tipos_nombre = $_SESSION['usuarios_tipos_nombre'];

    require_once "./inc/session_start.php";
	require_once "./php/main.php";

    $ci = (isset($_GET['user_ci'])) ? $_GET['user_ci'] : 0;
    $ci = limpiar_cadena($ci);
    $activo = "Activo";

    if (isset($ci) && $ci !== "") {
        $actualizar_datos_usuario = conexion()->prepare("UPDATE usuarios SET activo=:activo WHERE ci=:ci");

        $marcadores = [
            ":ci" => $ci,
            ":activo" => $activo,
        ];
        $actualizar_datos_usuario->execute($marcadores);
    }

    echo '
        <div class="mt-6"> </div>

        <div class="container is-fluid">
            <h1 class="has-text-centered title"> Historial de Usuarios </h1>
            <h2 class="has-text-centered subtitle"> Lista de usuario que han sido archivados </h2>
        </div>
        
        <div class="container mt-5">  
    ';

    if ($actualizar_datos_usuario->rowCount() > 0) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO INGRESADO!</strong><br>
                El USUARIO con la cedula '.$ci.' se ha dado de alta en el sistema
            </div>
        ';
    }


    echo '<div class="container mt-5">' ;
    
    require_once "./php/main.php";

    if(!isset($_GET['page'])){
        $pagina=1;
    }else{
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }
    }

    $pagina=limpiar_cadena($pagina);
    $busqueda="";
    $url="index.php?vista=historial_usuarios&page=";
    $registros=5;
    echo '<div class="mt-4"> </div>' ;


    # Paginador Usuario #
    require_once "./php/usuario_lista.php";

    echo '</div>';

    $actualizar_datos_usuario = null;
?>