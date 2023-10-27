<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Multimedia </title>

    <link rel="stylesheet" href="./css/bulma.min.css">
    <link rel="stylesheet" href="./css/multimedia.css">

    <script src="./js/subir_archivo.js"></script>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

</head>    
  
<body>

    <?php
        require_once "./php/main.php";
		$consulta_datos="SELECT ci, usuarios_tipos_id FROM usuarios WHERE ci='".$_SESSION['ci']."'"."ORDER BY nombre";

        $conexion=conexion();
        $datos_usuario = $conexion->query($consulta_datos);
        $datos_usuario = $datos_usuario->fetchAll();
    
        foreach($datos_usuario as $rows){
            $rows['ci'];
            $rows['usuarios_tipos_id'];

            $usuario = $rows['usuarios_tipos_id'];
        }

        if($usuario != ""){
            if($usuario == 1){
                include "./routes/multimedia_administrador.php";

            }elseif($usuario == 2){
                include "./routes/multimedia_docente.php";

            }elseif($usuario == 3){
                include "./routes/multimedia_estudiante.php";
            }
        }  
        
    $datos_usuario = NULL;
    $conexion = NULL;

    ?>
</body>
</html>