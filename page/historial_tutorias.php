<?php

    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $usuarios_tipos_nombre = $_SESSION['usuarios_tipos_nombre'];

    echo '
        <div class="mt-6"> </div>

        <div class="container is-fluid">
            <h1 class="has-text-centered title"> Historial de Tutorías </h1>
            <h2 class="has-text-centered subtitle"> Tutorías vinculadas a <br> '.$nombre.' '.$apellido.' ['.$usuarios_tipos_nombre.'] </h2>
        </div>
        
        <div class="container mt-5">  
    ';

    $estudiante = $_SESSION['usuarios_tipos_id'] == 3;

    if($estudiante)
        echo "<script> window.location.href='index.php?vista=home'; </script>";


    echo '<div class="container mt-5">' ;
    
    require_once "./php/main.php";

    /*Eliminar tutoria*/
    if(isset($_GET['user_ci_del'])){
        require_once "./php/tutoria_eliminar.php";
    }

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
    echo '<div class="mt-6"> </div>' ;


    # Paginador Tutorías #
    require_once "./php/tutoria_lista.php";

    echo '</div>';
?>