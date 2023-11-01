<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Buscar usuario</h2>
</div>
<div class="container pt-4 pb-6">

    <?php

        $sesionExiste = isset($_SESSION['busqueda_usuario']);

        if(isset($_GET['buscar']) && isset($_SESSION['busqueda_usuario'])){
            $_SESSION['busqueda_usuario'] = null;
        }

        require_once "./php/main.php";

        if(isset($_POST['modulo_buscador'])){
            require_once "./php/buscador.php";
        }

        if(!isset($_SESSION['busqueda_usuario']) && empty($_SESSION['busqueda_usuario'])){

    ?>

    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="usuario">   
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                        <input type="hidden" name="buscar" value="true">
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit"> Buscar </button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <?php }else{
        if (!isset($_POST['buscar']) && empty($_POST['buscar'])) {
        }   
    ?>

    <div class="columns">
        <div class="column">
            <form id="form2" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="usuario">   
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ@ ]{1,30}" maxlength="30" value="<?php echo isset($_SESSION['busqueda_usuario']) ? htmlspecialchars($_SESSION['busqueda_usuario']) : ''; ?>">
                        <input type="hidden" name="buscar" value="true">
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit"> Buscar </button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <form class="has-text-centered " action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="usuario"> 
                <input type="hidden" name="archivar_buscador" value="usuario">
                <br>
            </form>
        </div>
    </div>
    <?php
            # Archivar usuario #
            if(isset($_GET['user_id_del'])){
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
            $url="index.php?vista=user_search&page=";
            $registros=6;
            $busqueda=$_SESSION['busqueda_usuario'];

            # Paginador usuario #
            require_once "./php/usuario_lista.php";
        } 
    ?>

</div>