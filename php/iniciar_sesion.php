<?php
	/*Almacenando datos*/
    $ci=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']);

    echo '
        <div class="mt-5"> </div>
    ';


    /*Verificando campos obligatorios*/
    if($ci=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*Verificando integridad de los datos*/
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$ci)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La contraseña debe tener como minimo 4 caracteres
            </div>
        ';
        exit();
    }

    $check_user=conexion();
    $check_user=$check_user->query("SELECT * FROM usuarios WHERE ci='$ci'");


    if($check_user->rowCount()==1){

    	$check_user=$check_user->fetch();
        $registrado = $check_user['registrado'];

        if($registrado == "Registrado"){

            if($check_user['ci']==$ci && password_verify($clave, $check_user['clave'])){

                $_SESSION['ci'] = $check_user['ci'];
                $_SESSION['nombre'] = $check_user['nombre'];
                $_SESSION['apellido'] = $check_user['apellido'];
                $_SESSION['usuarios_tipos_id'] = $check_user['usuarios_tipos_id'];
                $_SESSION['registrado'] = $check_user['registrado'];

                if($_SESSION['usuarios_tipos_id'] == 1){
                    $_SESSION['usuarios_tipos_nombre'] = "Administrador";

                }elseif($_SESSION['usuarios_tipos_id'] == 2){
                    $_SESSION['usuarios_tipos_nombre'] = "Docente";

                }elseif($_SESSION['usuarios_tipos_id'] == 3){
                    $_SESSION['usuarios_tipos_nombre'] = "Estudiante";

                }

                if(headers_sent()){
                    echo "<script> window.location.href='index.php?vista=home'; </script>";
                }else{
                    header("Location: index.php?vista=home");
                }
                exit();

            }else{
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Usuario o contraseña incorrectos
                    </div>
                ';
            }

        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Sin permiso de acceso!</strong><br>
                Usted no es un usuario registrado, debe esperar a que un Administrador lo ingrese en el sistema
            </div>
            ';
        }

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o contraseña incorrectos
            </div>
        ';
    }

    $check_user=null;

    $ci = null;
    $clave = null;

?>