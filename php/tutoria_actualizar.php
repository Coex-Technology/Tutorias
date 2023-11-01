<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    /* Verifica si los campos del formulario se enviaron correctamente */
    if (!isset($_POST['grupo'], $_POST['descripcion'], $_POST['fecha_inicial'], $_POST['fecha_final'], $_POST['tutoria_clave_1'], $_POST['tutoria_clave_2'], $_POST['ci'], $_POST['administrador_tutoria'], $_POST['administrador_clave'])) {
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
    $tutorias_tipos_id = limpiar_cadena($_POST['tutorias_tipos_id']);

    $tutoria_clave_1 = limpiar_cadena($_POST['tutoria_clave_1']);
    $tutoria_clave_2 = limpiar_cadena($_POST['tutoria_clave_2']);
    $ci = limpiar_cadena($_POST['ci']);

    /* Verificar el tutoria */
    $check_tutoria = conexion()->query("SELECT ci FROM tutorias WHERE ci='$ci'");
    $check_clave = conexion()->query("SELECT clave FROM tutorias WHERE clave='$tutoria_clave_1'");

    if ($check_tutoria->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El tutoria no existe en el sistema
            </div>
        ';
        exit();
    } else {
        $datos = $check_tutoria->fetch();
        $datos_clave = $check_clave->fetch();
    }

    $check_tutoria = null;
    $check_clave = null;

    $admin_tutoria = limpiar_cadena($_POST['administrador_tutoria']);
    $admin_clave = limpiar_cadena($_POST['administrador_clave']);

    /* Verificando campos obligatorios */
    if ($admin_tutoria == "" || $admin_clave == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios, que corresponden a su tutoria y CLAVE
            </div>
        ';
        exit();
    }

    /* Verificando integridad de los datos */
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Su tutoria no coincide con el formato solicitado
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
    $check_admin = conexion()->query("SELECT ci, clave FROM tutorias WHERE ci='$admin_tutoria' AND ci='" . $_SESSION['ci'] . "'");

    if ($check_admin->rowCount() == 1) {
        $check_admin_data = $check_admin->fetch();

        if ($check_admin_data['ci'] != $admin_tutoria || !password_verify($admin_clave, $check_admin_data['clave'])) {
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
    if ($tutoria_clave_1 != "" || $tutoria_clave_2 != "") {
        if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $tutoria_clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $tutoria_clave_2)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Las CLAVES no coinciden con el formato solicitado
                </div>
            ';
            exit();
        } else {
            if ($tutoria_clave_1 != $tutoria_clave_2) {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        Las CLAVES que ha ingresado no coinciden
                    </div>
                ';
                exit();
            } else {
                $clave = password_hash($tutoria_clave_1, PASSWORD_BCRYPT, ["cost" => 10]);
            }
        }
    } else {
        // $clave = $datos_clave['clave'];
        $clave = password_hash($tutoria_clave_1, PASSWORD_BCRYPT, ["cost" => 10]);

    }

    /* Actualizar datos */
    $actualizar_tutoria = conexion()->prepare("UPDATE tutorias SET ci=:ci,nombre=:nombre,apellido=:apellido,direccion=:direccion,tutorias_tipos_id=:tutorias_tipos_id WHERE ci=:ci");

    $marcadores = [
        ":ci" => $ci,
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":direccion" => $direccion,
        ":tutorias_tipos_id" => $tutorias_tipos_id,
    ];

    $actualizar_tutoria->execute($marcadores);


    $actualizar_tutoria2 = conexion()->prepare("UPDATE contactos SET ci=:ci,telefono=:telefono,email=:email WHERE ci=:ci AND telefono=:telefono");

    $marcadores2 = [
        ":ci" => $ci,
        ":telefono" => $telefono,
        ":email" => $email,
    ];

    $actualizar_tutoria2->execute($marcadores2);

    if ($actualizar_tutoria->rowCount() > 0 || $actualizar_tutoria2->rowCount() > 0) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡TUTORÍA ACTUALIZADA!</strong><br>
                La tutoría se actualizó con éxito
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

    $actualizar_tutoria2 = null;
    $actualizar_tutoria = null;
?>
