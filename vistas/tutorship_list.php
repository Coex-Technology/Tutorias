<?php

    $pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $usuarios_tipos_nombre = $_SESSION['usuarios_tipos_nombre'];

    if (stripos($pagina_actual, 'tutorship_list') !== false){
        echo '
            <div class="mt-6"> </div>

            <div class="container is-fluid">
                <h1 class="has-text-centered title"> Tutorías  </h1>
                <h2 class="has-text-centered subtitle"> Lista de tutorías vinculadas al <br> '.$usuarios_tipos_nombre.' '.$nombre.' '.$apellido.'  </h2>
            </div>
            
            <div class="container mt-5">  
        ';

    }else if (stripos($pagina_actual, 'home') !== false){
        echo '            
            <div class="container is-fluid">
                <h1 class="has-text-centered title"> Tutorías  </h1>
                <h2 class="has-text-centered subtitle"> Lista de tutorías </h2>
            </div>             
        ';

    }
    echo '<div class="container mt-5">' ;
    
    require_once "./php/main.php";

    # Archivar tutoria #
    if(isset($_GET['user_ci_del'])){
        require_once "./php/tutoria_archivar.php";
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

    if (stripos($pagina_actual, 'home') !== false) {
        $url="index.php?vista=home&page=";
        $registros=3;

    }elseif (stripos($pagina_actual, 'tutorship_list') !== false){
        $url="index.php?vista=tutorship_list&page=";
        $registros=8;
        echo '<div class="mt-6"> </div>' ;

    }

    # Paginador tutoria #
    require_once "./php/tutoria_lista.php";

    echo '</div>';
?>