<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    /* Verifica si los campos del formulario se enviaron correctamente */
    if (!isset($_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['email'], $_POST['usuario_clave_1'], $_POST['usuario_clave_2'], $_POST['ci'], $_POST['administrador_usuario'], $_POST['administrador_clave'])) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Los campos del formulario no se enviaron correctamente.
            </div>
        ';
        exit();
    }

    /* Almacenando datos */
    $nombre = limpiar_cadena($_POST['nombre']);
    $apellido = limpiar_cadena($_POST['apellido']);

    $direccion = limpiar_cadena($_POST['direccion']);
    $email = limpiar_cadena($_POST['email']);

    $telefono = limpiar_cadena($_POST['telefono']);
    $usuarios_tipos_id = limpiar_cadena($_POST['usuarios_tipos_id']);

    $usuario_clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
    $usuario_clave_2 = limpiar_cadena($_POST['usuario_clave_2']);
    $ci = limpiar_cadena($_POST['ci']);

    /* Verificar el usuario */
    $check_usuario = conexion()->query("SELECT ci FROM usuarios WHERE ci='$ci'");
    $check_clave = conexion()->query("SELECT clave FROM usuarios WHERE clave='$usuario_clave_1'");

    if ($check_usuario->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El USUARIO no existe en el sistema
            </div>
        ';
        exit();
    } else {
        $datos = $check_usuario->fetch();
        $datos_clave = $check_clave->fetch();
    }

    $check_usuario = null;
    $check_clave = null;

    $admin_usuario = limpiar_cadena($_POST['administrador_usuario']);
    $admin_clave = limpiar_cadena($_POST['administrador_clave']);

    /* Verificando campos obligatorios */
    if ($admin_usuario == "" || $admin_clave == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE
            </div>
        ';
        exit();
    }

    /* Verificando integridad de los datos */
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Su USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $admin_clave)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Su CLAVE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /* Verificando admin */
    $check_admin = conexion()->query("SELECT ci, clave FROM usuarios WHERE ci='$admin_usuario' AND ci='" . $_SESSION['ci'] . "'");

    if ($check_admin->rowCount() == 1) {
        $check_admin_data = $check_admin->fetch();

        if ($check_admin_data['ci'] != $admin_usuario || !password_verify($admin_clave, $check_admin_data['clave'])) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    DOCUMENTO1 o CLAVE de administrador incorrectos
                </div>
            ';
            exit();
        }
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                DOCUMENTO2 o CLAVE de administrador incorrectos
            </div>
        ';
        exit();
    }

    $check_admin = null;

    /* Verificando campos obligatorios */
    if ($nombre == "" || $apellido == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /* Verificando integridad de los datos */
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /* Verificando email */
    if ($email != "") {
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no válido
                </div>
            ';
            exit();
        }
    }

    /* Verificando claves */
    if ($usuario_clave_1 != "" || $usuario_clave_2 != "") {
        if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $usuario_clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $usuario_clave_2)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Las CLAVES no coinciden con el formato solicitado
                </div>
            ';
            exit();
        } else {
            if ($usuario_clave_1 != $usuario_clave_2) {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        Las CLAVES que ha ingresado no coinciden
                    </div>
                ';
                exit();
            } else {
                $clave = password_hash($usuario_clave_1, PASSWORD_BCRYPT, ["cost" => 10]);
            }
        }
    } else {
        // $clave = $datos_clave['clave'];
        $clave = password_hash($usuario_clave_1, PASSWORD_BCRYPT, ["cost" => 10]);

    }

    /* Actualizar datos */
    $actualizar_usuario = conexion()->prepare("UPDATE usuarios SET ci=:ci,nombre=:nombre,apellido=:apellido,direccion=:direccion,usuarios_tipos_id=:usuarios_tipos_id WHERE ci=:ci");

    $marcadores = [
        ":ci" => $ci,
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":direccion" => $direccion,
        ":usuarios_tipos_id" => $usuarios_tipos_id,
    ];

    $actualizar_usuario->execute($marcadores);


    $actualizar_usuario2 = conexion()->prepare("UPDATE contactos SET ci=:ci,telefono=:telefono,email=:email WHERE ci=:ci AND telefono=:telefono");

    $marcadores2 = [
        ":ci" => $ci,
        ":telefono" => $telefono,
        ":email" => $email,
    ];

    $actualizar_usuario2->execute($marcadores2);

    if ($actualizar_usuario->rowCount() > 0 || $actualizar_usuario2->rowCount() > 0) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO ACTUALIZADO!</strong><br>
                El USUARIO se actualizó con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-white is-light">
                <strong>¡VERIFICA LOS DATOS!</strong><br>
                No se ha seleccionado ningun dato para modificar
            </div>
        ';
    }

    $actualizar_usuario2 = null;
    $actualizar_usuario = null;
?>
