<?php

    # Tutorship List #
	$pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $usuarios_tipos_nombre = $_SESSION['usuarios_tipos_nombre'];

    
    echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Tutorías </h1>
                <h2 class="subtitle"> Agregar Estudiantes </h2>
            </div>

            <div class="container pt-3"> 
        ';

    
    require_once "./php/main.php";


    # Agregar Estudiante #

    #---------------------------------------- Tutoría Seleccionada (Tabla) ----------------------------------------#

	$tabla="";
    if(isset($_GET['id']) && isset($_GET['id']) != ""){
        $ci_usuario = $_SESSION['ci'];
        $colspan = 9;

        if(isset($_GET['id']) && isset($_GET['id']) != ""){
            $id = $_GET['id'];
            $tutorias_id = $id;

            $verificar_id = "SELECT COUNT(id) FROM tutorias WHERE id = $id";
            $contar = $conexion->query($verificar_id);
            $contar = (int) $contar->fetchColumn();

            if($contar != 1)
                echo "<script> window.location.href='index.php?vista=home'; </script>";
        


            if($_SESSION['usuarios_tipos_id'] == 1){
                $usuario_tipo = "Docente";

                $consulta_datos = "SELECT
                        (SELECT nombre FROM usuarios WHERE ci = tutorias.docente_ci) AS nombre_docente,
                        (SELECT apellido FROM usuarios WHERE ci = tutorias.docente_ci) AS apellido_docente,
                        usuarios.direccion AS direccion,
                        usuarios.registrado AS registrado,
                        usuarios.activo AS activo,
                        tutorias.id AS id,
                        tutorias.docente_ci AS docente_ci,
                        tutorias.administrador_ci AS administrador_ci,
                        tutorias.grupo AS grupo,
                        tutorias.descripcion AS descripcion,
                        tutorias.dias AS dias,
                        tutorias.fecha_inicial AS fecha_inicial,
                        tutorias.fecha_final AS fecha_final,
                        tutorias.hora_inicial AS hora_inicial,
                        tutorias.hora_final AS hora_final,
                        tutorias.activa AS activa,
                        tutorias_tipos.id AS tutorias_tipos_id,
                        tutorias_tipos.nombre_tipo AS nombre_tipo
                    FROM tutorias
                    JOIN usuarios ON tutorias.administrador_ci = usuarios.ci
                    JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
                    WHERE tutorias.id = $id;";


            }elseif($_SESSION['usuarios_tipos_id'] == 2){
                $usuario_tipo = "Admin.";

                $consulta_datos = "SELECT 
                        (SELECT nombre FROM usuarios WHERE ci = tutorias.administrador_ci) AS nombre_administrador,
                        (SELECT apellido FROM usuarios WHERE ci = tutorias.administrador_ci) AS apellido_administrador,
                        usuarios.direccion AS direccion,
                        usuarios.registrado AS registrado,
                        usuarios.activo AS activo,
                        tutorias.id AS id,
                        tutorias.docente_ci AS docente_ci,
                        tutorias.administrador_ci AS administrador_ci,
                        tutorias.grupo AS grupo,
                        tutorias.descripcion AS descripcion,
                        tutorias.dias AS dias,
                        tutorias.fecha_inicial AS fecha_inicial,
                        tutorias.fecha_final AS fecha_final,
                        tutorias.hora_inicial AS hora_inicial,
                        tutorias.hora_final AS hora_final,
                        tutorias.activa AS activa,
                        tutorias_tipos.id AS tutorias_tipos_id,
                        tutorias_tipos.nombre_tipo AS nombre_tipo
                    FROM tutorias
                    JOIN usuarios ON tutorias.docente_ci = usuarios.ci
                    JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
                    WHERE tutorias.id = $id;";	
            }

        }

        $conexion=conexion();

        $datos = $conexion->query($consulta_datos);
        $datos = $datos->fetchAll();

        $tabla.='
            <style>
            .table.is-fullwidth {
                table-layout: fixed;
                width: 100%;
            }

            .table.is-fullwidth th,
            .table.is-fullwidth td {
                width: auto;
                white-space: normal;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            </style>

            <div class="table-container ml-5 mr-5">
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered is-vcentered tabla_encabezado">
                            <th colspan="4"> <p class="tabla_titulo"> Tutoría Seleccionada </p> </th>
                        </tr>

                        <tr class="has-text-centered">
                            <th class="tabla_texto"> Grupo </th>
                            <th class="tabla_texto"> '.$usuario_tipo.'</th>
                            <th class="tabla_texto"> Dias </th>
                            <th class="tabla_texto"> Periodo </th>
                        </tr>
                    </thead>
                <tbody>
        ';


        foreach($datos as $rows){

            if($rows['grupo']  == NULL)
                $rows['grupo'] = "<i><u> [Grupo no especificado] </u></i>";

            if($rows['descripcion']  == NULL)
                $rows['descripcion'] = "<i><u> [No se ingreso] </u></i>";

            if($rows['dias']  == NULL)
                $rows['dias'] = "<i><u> [No se ingresaron los dias] </u></i>";

            if($rows['nombre_tipo']  == NULL)
                $rows['nombre_tipo'] = "<i><u> [Tipo no especificado] </u></i>";

            if($rows['fecha_inicial']  == NULL)
                $rows['fecha_inicial'] = "<i><u> [Fecha no ingresada] </u></i>";

            if($rows['fecha_final']  == NULL)
                $rows['fecha_final'] = "<i><u> [Fecha no ingresada] </u></i>";

            if($rows['hora_inicial']  == NULL)
                $rows['hora_inicial'] = "<i><u> [Hora no ingresada] </u></i>";

            if($rows['hora_final']  == NULL)
                $rows['hora_final'] = "<i><u> [Hora no ingresada] </u></i>";

            $hora_inicial = $rows['hora_inicial'];
            $hora_final = $rows['hora_final'];
            $hora_inicial = preg_replace('/^0/', '', substr($hora_inicial, 0, 5));
            $hora_final = preg_replace('/^0/', '', substr($hora_final, 0, 5));

            $fecha_inicial = $rows['fecha_inicial'];
            $fecha_inicial = date("d/m/Y", strtotime($fecha_inicial));
            $fecha_final = $rows['fecha_final'];
            $fecha_final = date("d/m/Y", strtotime($fecha_final));
            
            $tabla.='
                <tr class="has-text-centered">
                    <td class="tabla_texto">'.$rows['grupo'].'</td>';


            if($_SESSION['usuarios_tipos_id'] == 1)
            $tabla .= '
                <td class="tabla_texto">'.$rows['nombre_docente'].' '.$rows['apellido_docente'].'</td>';

            if($_SESSION['usuarios_tipos_id'] == 2)
            $tabla .= '
                <td class="tabla_texto">'.$rows['nombre_administrador'].' '.$rows['apellido_administrador'].'</td>';

            $tabla .= '
                <td class="tabla_texto">'.$rows['dias'].'</td>
                <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>
            </tr>';

        }

        $tabla.='</tbody></table></div>';

        $conexion=null;

    }else{
        $usuario_ci = $_SESSION['ci'];
        

        $usuario_tipo = "Docente";
        $consulta_datos = "SELECT 
                usuarios.nombre AS nombre,
                usuarios.apellido AS apellido,
                usuarios.direccion AS direccion,
                usuarios.registrado AS registrado,
                usuarios.activo AS activo,
                tutorias.id AS id,
                tutorias.docente_ci AS docente_ci,
                tutorias.administrador_ci AS administrador_ci,
                tutorias.grupo AS grupo,
                tutorias.descripcion AS descripcion,
                tutorias.dias AS dias,
                tutorias.fecha_inicial AS fecha_inicial,
                tutorias.fecha_final AS fecha_final,
                tutorias.hora_inicial AS hora_inicial,
                tutorias.hora_final AS hora_final,
                tutorias.activa AS activa,
                tutorias_tipos.id AS tutorias_tipos_id,
                tutorias_tipos.nombre_tipo AS nombre_tipo
            FROM tutorias
            JOIN usuarios ON tutorias.docente_ci = usuarios.ci
            JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
            WHERE tutorias.docente_ci = $usuario_ci;";


        $datos = $conexion->query($consulta_datos);
        $datos = $datos->fetchAll();


        $tabla.='
            <style>
            .table.is-fullwidth {
                table-layout: fixed;
                width: 100%;
            }

            .table.is-fullwidth th,
            .table.is-fullwidth td {
                width: auto;
                white-space: normal;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            </style>

            <div class="table-container ml-5 mr-5">
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered is-vcentered tabla_encabezado">
                            <th colspan="5"> <p class="tabla_titulo"> Seleccionar Tutoría </p> </th>
                        </tr>

                        <tr class="has-text-centered">
                            <th class="tabla_texto"> Grupo </th>
                            <th class="tabla_texto"> Docente </th>
                            <th class="tabla_texto"> Dias </th>
                            <th class="tabla_texto"> Tipo </th>
                            <th class="tabla_texto"> Opciones </th>
                        </tr>
                    </thead>
                <tbody>
        ';


        foreach($datos as $rows){

            if($rows['grupo']  == NULL)
                $rows['grupo'] = "<i><u> [Grupo no especificado] </u></i>";

            if($rows['descripcion']  == NULL)
                $rows['descripcion'] = "<i><u> [No se ingreso] </u></i>";

            if($rows['dias']  == NULL)
                $rows['dias'] = "<i><u> [No se ingresaron los dias] </u></i>";

            if($rows['nombre_tipo']  == NULL)
                $rows['nombre_tipo'] = "<i><u> [Tipo no especificado] </u></i>";

            if($rows['fecha_inicial']  == NULL)
                $rows['fecha_inicial'] = "<i><u> [Fecha no ingresada] </u></i>";

            if($rows['fecha_final']  == NULL)
                $rows['fecha_final'] = "<i><u> [Fecha no ingresada] </u></i>";

            if($rows['hora_inicial']  == NULL)
                $rows['hora_inicial'] = "<i><u> [Hora no ingresada] </u></i>";

            if($rows['hora_final']  == NULL)
                $rows['hora_final'] = "<i><u> [Hora no ingresada] </u></i>";

            $hora_inicial = $rows['hora_inicial'];
            $hora_final = $rows['hora_final'];
            $hora_inicial = preg_replace('/^0/', '', substr($hora_inicial, 0, 5));
            $hora_final = preg_replace('/^0/', '', substr($hora_final, 0, 5));

            $fecha_inicial = $rows['fecha_inicial'];
            $fecha_inicial = date("d/m/Y", strtotime($fecha_inicial));
            $fecha_final = $rows['fecha_final'];
            $fecha_final = date("d/m/Y", strtotime($fecha_final));
            
            $tabla.='
                <tr class="has-text-centered">
                    <td class="tabla_texto">'.$rows['grupo'].'</td>';


            $tabla .= '
                <td class="tabla_texto">'.$rows['nombre'].' '.$rows['apellido'].'</td>';


            $consulta_fecha = "SELECT fecha
            FROM asistencias
            WHERE tutorias_id = ".$rows['id'].";";

            $datos_fecha = $conexion->query($consulta_fecha);
            $datos_fecha = $datos_fecha->fetchAll();

            foreach($datos_fecha as $rows2){
                $fecha = $rows2['fecha'];
            }
            

            $tabla .= '
                <td class="tabla_texto">'.$rows['dias'].'</td>
                <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>
                <td class="tabla_texto is-fullwidth">
                    <a href="index.php?vista=agregar_estudiante&id='.$rows['id'].'" class="button is-success is-rounded is-small"> Seleccionar </a>
                </td>
            </tr>';

        }

        $tabla.='</tbody></table></div>';
        $conexion=null;
        echo $tabla;

    
    }

    #---------------------------------------- Lista de Estudiantes (Tabla 2) ----------------------------------------#

    if(isset($_GET['id']) && isset($_GET['id']) != ""){

        $tabla2="";
        if($tabla2==""){
            $registros=99;
            $inicio = 0;
            $url="index.php?vista=agregar_estudiante&id=$id";
            $conexion=conexion();


            if(isset($_GET['ci']) && isset($_GET['ci']) != ""){
                $estudiantes_ci = $_GET['ci'];

                $verificar_ci = "SELECT COUNT(ci) FROM usuarios WHERE ci = $estudiantes_ci AND usuarios_tipos_id = 3";
                $contar2 = $conexion->query($verificar_ci);
                $contar2 = (int) $contar2->fetchColumn();

                if($contar2 == 0)
                    echo "<script> window.location.href='index.php?vista=home'; </script>";
                
                $agregar_estudiante_tutoria=$conexion;
                $agregar_estudiante_tutoria=$agregar_estudiante_tutoria->prepare ("INSERT INTO tutorias_estudiantes (estudiantes_ci,tutorias_id)
                VALUES(:estudiantes_ci,:tutorias_id)");

                $marcadores=[
                    ":estudiantes_ci"=>$estudiantes_ci,
                    ":tutorias_id"=>$tutorias_id,
                ];

                $verificar = $conexion->query("SELECT * FROM tutorias_estudiantes WHERE tutorias_id = $tutorias_id AND estudiantes_ci = $estudiantes_ci"); 
                $estudiantes_ci = "";   
                
                if($verificar->rowCount() == 0){
                    $agregar_estudiante_tutoria->execute($marcadores);
                }
                
            }
            
            $consulta_datos = "";
            $consulta_datos_usuarios = "SELECT * FROM usuarios WHERE usuarios.activo = 'Activo' AND usuarios_tipos_id = 3 ORDER BY usuarios.ci ASC LIMIT $inicio, $registros";

            $consulta_total = "SELECT COUNT(usuarios.ci) FROM usuarios WHERE usuarios.activo = 'Activo' AND usuarios_tipos_id = 3 ORDER BY usuarios.ci";

            echo '<div class="mb-5">
                    <p class="has-text-right">
                        <a href="index.php?vista=home" class="button is-link is-rounded btn-back"><- Regresar </a>
                    </p>
                </div>';

            $datos = $conexion->query($consulta_datos_usuarios);
            $datos = $datos->fetchAll();

            $total = $conexion->query($consulta_total);
            $total = (int) $total->fetchColumn();

            $tabla2.='
                <style>
                .table.is-fullwidth {
                    table-layout: fixed;
                    width: 100%;
                }

                .table.is-fullwidth th,
                .table.is-fullwidth td {
                    width: auto;
                    white-space: normal;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                </style>

                    <div class="table-container mt-3 ml-5 mr-5">
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <thead>
                                <tr class="has-text-centered is-vcentered tabla_encabezado">
                                    <th colspan="4"> <p class="tabla_titulo"> Lista de Estudiantes en el Sistema </p> </th>
                                </tr>
                                <tr class="has-text-centered">
                                    <th class="tabla_texto"> Cedula </th>
                                    <th class="tabla_texto"> Nombre </th>
                                    <th class="tabla_texto"> Apellido </th>
                                    <th class="tabla_texto"> Opciones </th>
                                </tr>
                            </thead>
                            <tbody>
                ';


            if($total>=1){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;

                foreach($datos as $rows){

                    if($rows['direccion']  == NULL){
                        $rows['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
                    }

                    if($rows['usuarios_tipos_id'] == 1){
                        $rows['usuarios_tipos_id'] = "Administrativo";

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
                    $usuarios_tipos_id = $rows['usuarios_tipos_id'];

                    $tabla2.='
                        <tr class="has-text-centered" >
                            <td>'.$ci.'</td>
                            <td>'.$nombre.'</td>
                            <td>'.$apellido.'</td>
                            <td>
                                <a href="'.$url.'&ci='.$rows['ci'].'" class="button is-success is-rounded is-small"> Agregar </a>
                            </td>
                        </tr>
                    ';
                    $contador++;
                }

            $pag_final=$contador-1;
                
            }else{
                if($total>=1){
                    $tabla2.='
                        <tr class="has-text-centered" >
                            <td colspan="4">
                                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                                    Haga clic acá para recargar el listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla2.='
                        <tr class="has-text-centered" >
                            <td colspan="4">
                                No hay registros en el sistema
                            </td>
                        </tr>
                    ';
                }
            }

            $conexion=null;
            $tabla2.='</tbody></table></div>';

            if($total>0){
                $tabla2.='<p class="has-text-right pr-5">Mostrando estudiantes del <strong>'.$pag_inicio.'</strong> al <strong>'.$total.'</strong> de un <strong>total de '.$total.'</strong></p>';
            }
        }

        #---------------------------------------- Lista de Tutorías - Estudiantes (Tabla 3) ----------------------------------------#

        $tabla3="";
        if($tabla3==""){

            $registros=99;
            $inicio = 0;
            $url="index.php?vista=agregar_estudiante&id=$id";
            $conexion=conexion();

            if(isset($_GET['quitar']) && isset($_GET['quitar']) != ""){
                $estudiantes_ci = $_GET['quitar'];

                $verificar_quitar = "SELECT COUNT(*) FROM tutorias_estudiantes WHERE tutorias_id = $tutorias_id AND estudiantes_ci = $estudiantes_ci";
                $contar3 = $conexion->query($verificar_quitar);
                $contar3 = (int) $contar3->fetchColumn();


                # Quitar Estudiante de Tutoría #
                $quitar_estudiante = conexion()->prepare("DELETE FROM tutorias_estudiantes WHERE tutorias_id = :tutorias_id AND estudiantes_ci = :estudiantes_ci;");

                $marcadores = [
                    ":tutorias_id" => $tutorias_id,
                    ":estudiantes_ci" => $estudiantes_ci,
                ];

                $quitar_estudiante->execute($marcadores);

                if($contar3 == 0){
                    echo "<script> window.location.href='index.php?vista=home'; </script>";
                }
            }
            
            $consulta_datos = "";
            $consulta_datos_usuarios = "SELECT * FROM usuarios, tutorias_estudiantes WHERE usuarios.ci = tutorias_estudiantes.estudiantes_ci AND tutorias_estudiantes.tutorias_id = $tutorias_id AND tutorias_estudiantes.tutorias_id = $tutorias_id";

            $consulta_total = "SELECT COUNT(*) FROM usuarios, tutorias_estudiantes WHERE usuarios.ci = tutorias_estudiantes.estudiantes_ci AND tutorias_estudiantes.tutorias_id = $tutorias_id AND tutorias_estudiantes.tutorias_id = $tutorias_id";
            


            $datos = $conexion->query($consulta_datos_usuarios);
            $datos = $datos->fetchAll();

            $total = $conexion->query($consulta_total);
            $total = (int) $total->fetchColumn();

            $tabla3.='
                <style>
                .table.is-fullwidth {
                    table-layout: fixed;
                    width: 100%;
                }

                .table.is-fullwidth th,
                .table.is-fullwidth td {
                    width: auto;
                    white-space: normal;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                </style>

                    <div class="table-container mt-3 ml-5 mr-5">
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <thead>
                                <tr class="has-text-centered is-vcentered tabla_encabezado">
                                    <th colspan="4"> <p class="tabla_titulo"> Lista de Estudiantes en la Tutoría </p> </th>
                                </tr>
                                <tr class="has-text-centered">
                                    <th class="tabla_texto"> Cedula </th>
                                    <th class="tabla_texto"> Nombre </th>
                                    <th class="tabla_texto"> Apellido </th>
                                    <th class="tabla_texto"> Opciones </th>
                                </tr>
                            </thead>
                            <tbody>
                ';


            if($total>=1){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;

                foreach($datos as $rows){

                    if($rows['direccion']  == NULL){
                        $rows['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
                    }

                    if($rows['usuarios_tipos_id'] == 1){
                        $rows['usuarios_tipos_id'] = "Administrativo";

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
                    $usuarios_tipos_id = $rows['usuarios_tipos_id'];

                    $tabla3.='
                        <tr class="has-text-centered" >
                            <td>'.$ci.'</td>
                            <td>'.$nombre.'</td>
                            <td>'.$apellido.'</td>
                            <td>
                                <a href="'.$url.'&quitar='.$rows['ci'].'" class="button is-danger is-rounded is-small"> Quitar </a>
                            </td>
                        </tr>
                    ';
                    $contador++;
                }

            $pag_final=$contador-1;
                
            }else{
                if($total>=1){
                    $tabla3.='
                        <tr class="has-text-centered" >
                            <td colspan="4">
                                <a href="'.$url.'" class="button is-link is-rounded is-small mt-4 mb-4">
                                    Haga clic acá para recargar el listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla3.='
                        <tr class="has-text-centered" >
                            <td colspan="4">
                                Aún no hay estudiantes en esta tutoría
                            </td>
                        </tr>
                    ';
                }
            }

            $conexion=null;
            $tabla3.='</tbody></table></div>';

            if($total>0){
                $tabla3.='<p class="has-text-right pr-5">Mostrando estudiantes del <strong>'.$pag_inicio.'</strong> al <strong>'.$total.'</strong> de un <strong>total de '.$total.'</strong></p>';
            }
        }



        # Imprimir Tablas #

        echo $tabla; 
        echo '<div class="columns is-gapless">';
        echo '<div class="column">';
        echo $tabla2;
        echo '<br> <br> </div>';
        echo '<div class="column">';
        echo $tabla3;
        echo '<br> </div>';
        echo '</div>';

    }

?>