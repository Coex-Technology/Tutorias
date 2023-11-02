<?php

    $estudiante = $_SESSION['usuarios_tipos_id'] == 3;
    if($estudiante)
        echo "<script> window.location.href='index.php?vista=home'; </script>";
    

    require_once "./inc/session_start.php";
	require_once "./php/main.php";

    $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    $id = limpiar_cadena($id);
    $activa = "Activa";

    if (isset($id) && $id !== "") {
        $actualizar_datos_tutoria = conexion()->prepare("UPDATE tutorias SET activa=:activa WHERE id=:id");

        $marcadores = [
            ":id" => $id,
            ":activa" => $activa,
        ];
        $actualizar_datos_tutoria->execute($marcadores);
    }

    echo '
        <div class="mt-6"> </div>

        <div class="container is-fluid">
            <h1 class="has-text-centered title"> Historial de tutorias </h1>
            <h2 class="has-text-centered subtitle"> Lista de tutoria que han sido archivados </h2>
        </div>
        
        <div class="container mt-5">  
    ';

    if ($actualizar_datos_tutoria->rowCount() > 0) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡TUTORÍA INGRESADA!</strong><br>
                El tutoría se ha dado de alta en el sistema
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
    $url="index.php?vista=historial_tutorias&page=";
    $registros=5;
    echo '<div class="mt-4"> </div>' ;


    # Paginador tutoria #
    require_once "./php/tutoria_lista.php";

    echo '</div>';

    $actualizar_datos_tutoria = null;
?>