<?php
    require_once "main.php";

    $nombre=limpiar_cadena($_POST['nombre']);
    $apellido=limpiar_cadena($_POST['apellido']);

    $ci=limpiar_cadena($_POST['ci']);
    $direccion=limpiar_cadena($_POST['direccion']);

    $telefono=limpiar_cadena($_POST['telefono']);
    $email=limpiar_cadena($_POST['email']);

    $clave_1=limpiar_cadena($_POST['clave_1']);
    $clave_2=limpiar_cadena($_POST['clave_2']);

    $usuarios_tipos_id=limpiar_cadena($_POST['tipo']);    
    $registrado=limpiar_cadena($_POST['registrado']);
    $activo="Activo";
    

    # Verificando campos obligatorios #
    if($nombre=="" || $apellido=="" || $ci=="" || $telefono=="" || $clave_1=="" || $clave_2==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    # Verificando integridad de los datos #
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9]{7,9}",$ci)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CEDULA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,100}",$direccion) && $direccion != NULL){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La DIRECCIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9]{8,9}",$telefono)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NÚMERO DE CONTACTO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{3,100}",$email) && $email != NULL){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CORREO ELECTRONICO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CONTRASEÑAS no coinciden con el formato solicitado
            </div>
        ';
        exit();
    }


    # Verificando email #
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

            $query =
            "SELECT usuarios.ci, contactos.ci
            FROM usuarios
            JOIN contactos ON usuarios.ci = contactos.ci 
            WHERE contactos.ci = '$ci' AND contactos.email = '$email'";

            $check_email=conexion();
            $check_email=$check_email->query($query);


            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado en este usuario, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;

        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
            exit();
        } 
    }


    # Verificando usuario #
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT ci FROM usuarios WHERE ci='$ci'");
    if($check_usuario->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_usuario=null;


    # Verificando claves #
    if($clave_1!=$clave_2){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CONTRASEÑAS ingresadas no coinciden
            </div>
        ';
        exit();
    }else{
        $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['formulario_enviado'])) {
            
            $guardar_usuario=conexion();
            $guardar_usuario=$guardar_usuario->prepare("INSERT INTO usuarios(ci,clave,nombre,apellido,direccion,registrado,activo,usuarios_tipos_id)
            VALUES(:ci,:clave,:nombre,:apellido,:direccion,:registrado,:activo,:usuarios_tipos_id)");

            $marcadores_usuario=[
                ":ci"=>$ci,
                ":clave"=>$clave,
                ":nombre"=>$nombre,
                ":apellido"=>$apellido,
                ":direccion"=>$direccion,
                ":registrado"=>$registrado,
                ":activo"=>$activo,
                ":usuarios_tipos_id"=>$usuarios_tipos_id,
            ];

            $guardar_usuario->execute($marcadores_usuario);


            # Verificar que no existan los datos #
            $check_contacto=conexion();
            $check_contacto=$check_contacto->prepare("SELECT * FROM contactos WHERE ci = $ci AND telefono = $telefono;");
            $check_contacto->execute();

            if($check_contacto->rowCount()>0){
                echo'
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El contacto ingresado ya existe, por favor ingrese otro
                    </div>
                ';
                exit();
            }

            $_SESSION['formulario_enviado'] = true;
        }
    }

    # Guardando contacto #
    $guardar_contacto=conexion();
    $guardar_contacto=$guardar_contacto->prepare("INSERT INTO contactos (ci,telefono,email)
    VALUES(:ci,:telefono,:email)");

    $marcadores_contacto=[
        ":ci"=>$ci,
        ":telefono"=>$telefono,
        ":email"=>$email,
    ];

    $guardar_contacto->execute($marcadores_contacto);
    

    if(($guardar_usuario->rowCount()==1) && ($guardar_contacto->rowCount()==1)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO REGISTRADO!</strong><br>
                El usuario se registro con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el usuario, por favor intente nuevamente
            </div>
        ';
    }


    $guardar_contacto=null;
    $guardar_usuario=null;
?>