<?php
    if(isset($_GET['user_ci_del'])){
        echo '
            <div class="container is-fluid">
                <h1 class="title"> Usuarios </h1>
                <h2 class="subtitle"> Revisar datos del Usuario </h2>

            <div class="container is-relative pb-3">
        ';
        include "./inc/btn_back.php";

        echo '</div>
        <div class="container pb-6">';

        echo '<div class="mb-3"> </div>';

    }else{
        echo '
            <div class="container is-fluid mb-6">
                <h1 class="title"> Usuarios </h1>
                <h2 class="subtitle"> Lista de usuarios </h2>
            </div>
        <div class="container">';

    }

    require_once "./php/main.php";

    # Archivar usuario #
    if(isset($_GET['user_ci_del'])){
        require_once "./php/usuario_archivar.php";
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
    $url="index.php?vista=user_list&page=";
    $registros=7;
    $busqueda="";

    # Paginador usuario #
    if(!(isset($_GET['user_ci_del']) && $_GET['user_ci_del'] != ""))
        require_once "./php/usuario_lista.php";

    echo '</div>';

?>