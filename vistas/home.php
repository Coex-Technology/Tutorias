<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <link rel="stylesheet" href="./css/home.css">
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</head>

<body>

    <section class="cartel_home">
        <div class="contenedor_edututor">
            <img src="./img/edututor.jpg" class="img_edututor">
        </div> 

        <div class="container is-fluid">
            <h1 class="title">Home</h1>
            <h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
        </div>
    </section>
        
    <?php
        require_once "./php/main.php";

        if(!(isset($_SESSION['ci']) && strpos($url, "index.php?vista") !== false)) {
		    echo "<script> window.location.href='index.php?vista=login'; </script>";
            exit();

        }
        
    ?>

    <main class="main">
        <div class="columns">
            <section class="column is-one-quarter bajar_tabla_opciones">

                <div class="dropdown is-hoverable menu-ancho">

                    <div class="menu-ancho ml-5" id="dropdown-menu4" role="menu">
                        <div class="dropdown-content">
                            <div class="dropdown-item">
                                <?php
                                    $consulta_datos="SELECT ci, usuarios_tipos_id FROM usuarios WHERE ci='".$_SESSION['ci']."'"."ORDER BY nombre";
                                    $conexion=conexion();
                                    $datos = $conexion->query($consulta_datos);
                                    $datos = $datos->fetchAll();

                                    foreach($datos as $rows){
                                        $rows['ci'];
                                        $rows['usuarios_tipos_id'];

                                        $usuario = $rows['usuarios_tipos_id'];
                                    }

                                    if($usuario != ""){

                                        if($usuario == 1){
                                            include "./routes/home_administrador.php";

                                        }elseif($usuario == 2){
                                            include "./routes/home_docente.php";

                                        }elseif($usuario == 3){
                                            include "./routes/home_estudiante.php";
                                        }
                                    }  
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="column is-three-quarters bajar_tabla_tutorias container">

                <?php include_once "tutorship_list.php"; ?>

            </section>
            
        </div>
    </main>

</body>
</html>