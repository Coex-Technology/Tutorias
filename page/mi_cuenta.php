<?php
    $ci = $_SESSION['ci'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];

    $consulta_datos = "SELECT * FROM usuarios
    JOIN contactos ON usuarios.ci = contactos.ci
    WHERE usuarios.ci = '". $ci."' AND usuarios.activo = 'Activo'";

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    foreach($datos as $rows){
        if($rows['direccion']  == NULL){
            $rows['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
        }

        if($rows['email']  == NULL){
            $rows['email'] = "<i><u> [Email no ingresado] </u></i>";
        }

        if($rows['usuarios_tipos_id'] == 1){
            $rows['usuarios_tipos_id'] = "Administrador";

        }elseif($rows['usuarios_tipos_id'] == 2){
            $rows['usuarios_tipos_id'] = "Docente";
            
        }elseif($rows['usuarios_tipos_id'] == 3){
            $rows['usuarios_tipos_id'] = "Estudiante";
            
        }else{
            $rows['usuarios_tipos_id'] = "Rol no definido";
        }

        $ci = $rows['ci'];
        $nombre = $rows['nombre'];
        $apellido = $rows['apellido'];
        $direccion = $rows['direccion'];
        $telefono = $rows['telefono'];
        $email = $rows['email'];
        $usuarios_tipos_id = $rows['usuarios_tipos_id'];

        $ci = formatear_cedula($ci);
        $telefono = formatear_telefono($telefono);
    }

    $tabla_base = '
        <section class="section">
            <div class="container caja">
                <div class="columns">
                    <div class="column is-one-quarter">
                        <div class="foto_contenedor pl-4 pr-4">
                            <img src="/coex/tutorias/img/perfil.jpg" class="foto_perfil">
                            <p class="has-text-centered">' . $nombre . ' ' . $apellido . '</p>
                        </div>
                    </div>

                    <div class="column is-three-quarters">
                    <table class="table is-bordered is-hidden-mobile is-fullwidth ml-6">
                        <thead>
                        <tr>
                            <th colspan="1" class="has-text-centered"> Datos </th>
                            <th colspan="2" class="has-text-centered"> Descripción </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="has-text-centered contenedor_caja">
                            <div class="box has-text-centered ">
                                <span class="has-text-weight-bold"> Cedula </span>
                            </div>

                            <div class="box has-text-centered ">
                                <span class="has-text-weight-bold"> Dirección </span>
                            </div>

                            <div class="box has-text-centered ">
                                <span class="has-text-weight-bold"> Tipo de Usuario </span>
                            </div>

                            <div class="box has-text-centered ">
                                <span class="has-text-weight-bold"> Número </span>
                            </div>

                            <div class="box has-text-centered ">
                                <span class="has-text-weight-bold"> E-mail </span>
                            </div>


                            </td>

                            <td class="has-text-centered">
                            <div class="box has-text-centered contenedor_caja">
                                <span class="has-text-weight-bold"> '.$ci.' </span>
                            </div>
                            <div class="box has-text-centered contenedor_caja">
                                <span class="has-text-weight-bold"> '.$direccion.' </span>
                            </div>
                            <div class="box has-text-centered contenedor_caja">
                                <span class="has-text-weight-bold"> '.$usuarios_tipos_id.' </span>
                            </div>
                            <div class="box has-text-centered contenedor_caja">
                                <span class="has-text-weight-bold"> '.$telefono.' </span>
                            </div>
                            <div class="box has-text-centered contenedor_caja">
                                <span class="has-text-weight-bold"> '.$email.' </span>
                            </div>
                            </td>
                            </tr>
                        </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </section>';

        echo $tabla_base;
?>