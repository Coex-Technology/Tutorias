<!DOCTYPE html>
<html>
<head>
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="./css/bulma.min.css">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="./css/cuenta.css">

</head>

<body>

    <?php
        # Verificando repositorios #
        $ci = $_SESSION['ci'];
        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $check_repositorios=conexion();
        $check_repositorios=$check_repositorios->query("SELECT * FROM repositorios WHERE usuarios_ci = $ci");

        if($check_repositorios->rowCount()>0){
            $datos=$check_repositorios->fetch();
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
                            <div class="foto_contenedor is-flex is-align-items-center">
                                <p class="has-text-centered"> Opciones </p>
                            </div>
                            <div class="foto_contenedor is-flex is-align-items-center has-text-centered">
                                <p class="has-text-centered"> Cambiar Imagen </p>
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
                                    <span class="has-text-weight-bold"> Nombre </span>
                                </div>

                                <div class="box has-text-centered ">
                                    <span class="has-text-weight-bold"> Apllido </span>
                                </div>

                                <div class="box has-text-centered ">
                                    <span class="has-text-weight-bold"> Número </span>
                                </div>

                                <div class="box has-text-centered ">
                                    <span class="has-text-weight-bold"> E-mail </span>
                                </div>

                                <div class="box has-text-centered ">
                                    <span class="has-text-weight-bold"> Nombre </span>
                                </div>

                                </td>

                                <td class="has-text-centered">
                                <div class="box has-text-centered contenedor_caja">
                                    <span class="has-text-weight-bold"> "Descripción" </span>
                                </div>
                                <div class="box has-text-centered contenedor_caja">
                                    <span class="has-text-weight-bold"> "Descripción" </span>
                                </div>
                                <div class="box has-text-centered contenedor_caja">
                                    <span class="has-text-weight-bold"> "Descripción" </span>
                                </div>
                                <div class="box has-text-centered contenedor_caja">
                                    <span class="has-text-weight-bold"> "Descripción" </span>
                                </div>
                                <div class="box has-text-centered contenedor_caja">
                                    <span class="has-text-weight-bold"> "Descripción" </span>
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


    
</body>
</html>
