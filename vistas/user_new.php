<?php 

    $pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if (stripos($pagina_actual, 'user_new') !== false){
        echo '
            <div class="container is-fluid mt-5 mb-6">
                <h1 class="title"> Usuarios </h1>
                <h2 class="subtitle"> Nuevo usuario </h2>  
        ';
        $usuario_registrado = "Registrado";

    }else if (stripos($pagina_actual, 'register') !== false){
        echo '            
            <div class="container is-fluid mt-5 mb-5">
                <h1 class="title"> Usuarios </h1>
                <h2 class="subtitle"> Registrar usuario </h2>           
        ';
        include "./inc/btn_back.php";
        $usuario_registrado = "Registrado";

    }

?>

<script src="./js/ajax.js"></script>
<script src="./js/nuevo_usuario.js"></script>

</div>

    <form action="./php/usuario_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">

        <div class="borde_registro">

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label> Nombre <b class="asterisco">*</b> </label>
                        <input class="input" type="text" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Apellido <b class="asterisco">*</b> </label>
                        <input class="input" type="text" name="apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}" maxlength="50" required>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label> Cédula de Identidad <b class="asterisco">*</b> </label>
                        <input class="input" type="text" name="ci" pattern="[0-9]{7,9}" maxlength="9" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Dirección </label>
                        <input class="input" type="text" name="direccion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,100}" maxlength="100">
                    </div>
                </div>
            </div>

            <div class="columns is-flex">
                <div class="column">
                    <div class="control">
                        <label> Numero de Contacto <b class="asterisco">*</b> </label>
                        <input class="input" type="text" id="telefono" name="telefono" pattern="[0-9]{8,9}" maxlength="9" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Email <b class="asterisco">*</b> </label>
                        <input class="input" type="text" name="email" pattern="[a-zA-Z0-9$@.-]{3,100}" maxlength="50">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label> Contraseña <b class="asterisco">*</b> </label>
                        <input class="input" type="password" name="clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Repetir contraseña <b class="asterisco">*</b> </label>
                        <input class="input" type="password" name="clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                    </div>
                </div>

                <div>
                    <div class="control">
                        <label> <b class="asterisco"></b> </label>
                        <input type="hidden" id="tipo" name="tipo" required>
                    </div>
                </div>
            </div>

            <div>
                <div class="control">
                    <label> <b class="asterisco"></b> </label>
                    <input type="hidden" name="registrado" value = "<?php echo htmlspecialchars($usuario_registrado); ?>">
                </div>
            </div>   

            <div class="dropdown is-hoverable is-pulled-left mt-4">
                <div class="dropdown-trigger">
                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu4">
                    <span> Tipo de Usuario</span>
                    <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                    </button>
                </div>

                <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                    <div class="dropdown-content">
                        <a href="#" id="administrativo" class="dropdown-item" onclick="mostrarMensaje('Administrador'); seleccionarTipo('1')"> Administrador </a>
                        <a href="#" id="docente" class="dropdown-item" onclick="mostrarMensaje('Docente'); seleccionarTipo('2')"> Docente </a>
                        <a href="#" id="estudiante" class="dropdown-item" onclick="mostrarMensaje('Estudiante'); seleccionarTipo('3')"> Estudiante </a>
                    </div>
                </div>
            </div>

            <div class="container is-relative contenedor_alerta">

                <div class="columns is-flex-touch">
                    <div class="column is-half-desktop">
                        <div class="container form-rest mensaje_alerta is-danger pt-5 pr-5 pb-5 pl-5">
                        </div>
                    </div>

                    <div class="column is-half-desktop">
                        <div class="notificacion">
                            <div id="mensaje" class="container notification is-absolute is-success is-hidden is-fixed register_confirmacion"></div>
                        </div>
                    </div>

                    <div class="column is-full-desktop">
                        <div class="section register_guardar">
                            <div class="has-text-centered">
                                <button class="container button is-danger is-rounded pt-5 pr-5 pb-5 pl-5">
                                    <p class="guardar"> Tipo de Usuario <br> no Seleccionado </p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>              

            </div>
        </div>
    </form>

    

</div>