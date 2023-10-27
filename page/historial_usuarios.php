<?php

    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $usuarios_tipos_nombre = $_SESSION['usuarios_tipos_nombre'];

    echo '
        <div class="mt-6"> </div>

        <div class="container is-fluid">
            <h1 class="has-text-centered title"> Historial de Usuarios </h1>
            <h2 class="has-text-centered subtitle"> Usuarios vinculados a <br> '.$nombre.' '.$apellido.' ['.$usuarios_tipos_nombre.'] </h2>
        </div>
        
        <div class="container mt-5">  
    ';


    echo '<div class="container mt-5">' ;
    
    require_once "./php/main.php";

    /*Eliminar tutoria*/
    if(isset($_GET['user_ci_del'])){
        require_once "./php/usuario_eliminar.php";
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
    $url="index.php?vista=historial_usuarios&page=";
    $registros=5;
    echo '<div class="mt-6"> </div>' ;


    # Paginador Usuario #
    require_once "./php/usuario_lista.php";

    echo '</div>';
?>