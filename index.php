<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <?php require "./inc/session_start.php"; 

        $url = $_SERVER['REQUEST_URI'];
        $ultimo_igual = substr(strrchr($url, '='), 1);

        if($ultimo_igual == ""){
            echo '<script>window.location.href = "index.php?vista=login";</script>';
            
        }

        include "./inc/head.php";

        if (empty($_GET['vista'])) {
            $_GET['vista'] = "login";
        }

        $vista = $_GET['vista'] . ".php";
        $directoriosPosibles = ["./doc/", "./page/", "./php/", "./upload/", "./routes/", "./vistas/"];
        $encontrado = false;

        foreach ($directoriosPosibles as $directorio) {
            $rutaArchivo = $directorio . $vista;

            if(is_file($rutaArchivo) && $_GET['vista']!="login" && $_GET['vista']!="register" && $_GET['vista']!="404"){
                if((!isset($_SESSION['ci']) || $_SESSION['ci']=="") || (!isset($_SESSION['usuarios_tipos_id']) || $_SESSION['usuarios_tipos_id']=="")){
                    include "./vistas/logout.php";
                    exit();
                }
            }
            
            if (is_file($rutaArchivo)) {
                if($_GET['vista'] != "login" && $_GET['vista'] != "register")
                include "./inc/navbar.php";

                include $rutaArchivo;
                include "./inc/script.php";
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            include "404.html";
        }

    ?>

</body>
</html>