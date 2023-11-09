<?php

    # Tutorship List #
    $pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $registros=99;
    $inicio = 0;
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $usuarios_tipos_nombre = $_SESSION['usuarios_tipos_nombre'];
    $conexion=conexion();


    require_once "./php/main.php";


    #---------------------------------------- Tutoría Seleccionada (Tabla) ----------------------------------------#

    $url="index.php?vista=multimedia_subida";
    $registros=15;

    $tabla="";
    if(!(isset($_GET['id']) && isset($_GET['id']) != "")){
        echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Materiales </h1>
                <h2 class="subtitle"> Multimedia Subida </h2>
            </div>

            <div class="container pt-3 b barra_asistencia"> 
        ';

        $usuario_ci = $_SESSION['ci'];
        
        if($_SESSION['usuarios_tipos_id'] == 2){
            $consulta_datos = "SELECT 
                    (SELECT nombre FROM usuarios WHERE ci = tutorias.administrador_ci) AS nombre,
                    (SELECT apellido FROM usuarios WHERE ci = tutorias.administrador_ci) AS apellido,
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
                $usuario_tipo = "Docente";
        
        }else if($_SESSION['usuarios_tipos_id'] == 3){
            $consulta_datos = "SELECT 
                u.nombre AS nombre,
                u.apellido AS apellido,
                u.direccion AS direccion,
                u.registrado AS registrado,
                u.activo AS activo,
                t.id AS id,
                t.docente_ci AS docente_ci,
                t.administrador_ci AS administrador_ci,
                t.grupo AS grupo,
                t.descripcion AS descripcion,
                t.dias AS dias,
                t.fecha_inicial AS fecha_inicial,
                t.fecha_final AS fecha_final,
                t.hora_inicial AS hora_inicial,
                t.hora_final AS hora_final,
                t.activa AS activa,
                tt.id AS tutorias_tipos_id,
                tt.nombre_tipo AS nombre_tipo
            FROM tutorias_estudiantes te
            JOIN usuarios u ON te.estudiantes_ci = u.ci
            JOIN tutorias t ON te.tutorias_id = t.id
            JOIN tutorias_tipos tt ON t.tutorias_tipos_id = tt.id
            WHERE u.ci = $usuario_ci;";
            $usuario_tipo = "Estudiante";
    
        }else{
            $consulta_datos = "SELECT 
                    (SELECT nombre FROM usuarios WHERE ci = tutorias.docente_ci) AS nombre,
                    (SELECT apellido FROM usuarios WHERE ci = tutorias.docente_ci) AS apellido,
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
                WHERE usuarios.ci = $usuario_ci;";
                $usuario_tipo = "Docente";
        }
        

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
                            <th class="tabla_texto"> '.$usuario_tipo.' </th>
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
                <td class="tabla_texto">'.$rows['nombre'].' '.$rows['apellido'].'</td>
                <td class="tabla_texto">'.$rows['dias'].'</td>
                <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>';

            $tabla .= '<td class="tabla_texto is-fullwidth">
                    <a href="'.$url.'&id='.$rows['id'].'&sel=true" class="button is-success is-rounded is-small"> Seleccionar </a>
                </td>
            </tr>';
        }

        $tabla.='</tbody></table></div>';
        $conexion=null;
        echo $tabla;

    
    }else{

    #---------------------------------------- Tabla de Datos ----------------------------------------#

        if(isset($_GET['id']))
            $tutorias_id = $_GET['id'];

        $consulta_grupo = "SELECT grupo
                FROM tutorias
                WHERE id = $tutorias_id;";

        $datos_grupo = $conexion->query($consulta_grupo);
        $datos_grupo = $datos_grupo->fetchAll();

        foreach($datos_grupo as $rows){
            $grupo = $rows['grupo'];
        }

        echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Materiales </h1>
                <h2 class="subtitle"> Material Subido a la Tutoría<br> '.$grupo.' </h2>
            </div>
            

            <div class="container "> 
        ';

        echo '<div class="mb-6">
            <p class="has-text-right">
                <a href="index.php?vista=home" class="button is-link is-rounded btn-back"><- Regresar </a>
            </p>
            <p class="has-text-left">
                <a href="index.php?vista=multimedia_guardada&id='.$tutorias_id.'&sel=true" class="button is-success is-rounded btn-back is-small"> Consultar Archivos Subidos </a>
            </p>
        </div>';



        $verificar_id = "SELECT COUNT(id) FROM tutorias WHERE id = $tutorias_id";
        $contar = $conexion->query($verificar_id);
        $contar = (int) $contar->fetchColumn();

        if($contar != 1)
            echo "<script> window.location.href='index.php?vista=home'; </script>";


        # Eliminar Archivo #
        if(isset($_GET['archivo_id_del'])){
            require_once "./php/archivo_eliminar.php";
        }


        # Lista de Archivos #
        if($tutorias_id != ""){
            $tabla="";

            $consulta_datos = "SELECT
                repositorios.id_archivo AS archivo_id,
                repositorios.usuarios_ci AS usuarios_ci,
                repositorios.tutorias_id AS tutorias_id,
                repositorios.tema AS tema,
                repositorios.nombre AS nombre_archivo,
                repositorios.comentarios AS comentarios,
                repositorios.tipo_archivo AS tipo_archivo,
                repositorios.fecha_visualizacion AS fecha_visualizacion,
                repositorios.hora_visualizacion AS hora_visualizacion,
                repositorios.fecha_eliminacion AS fecha_eliminacion,
                repositorios.hora_eliminacion AS hora_eliminacion,
                repositorios.activo AS activo,
                usuarios.nombre AS nombre,
                usuarios.apellido AS apellido,
                usuarios.usuarios_tipos_id AS usuarios_tipos_id,
                tutorias.grupo AS grupo,
                tutorias.dias AS dias,
                tutorias.fecha_inicial AS fecha_inicial,
                tutorias.fecha_final AS fecha_final,
                tutorias.hora_inicial AS hora_inicial,
                tutorias.hora_final AS hora_final
            FROM repositorios
            JOIN usuarios ON repositorios.usuarios_ci=usuarios.ci
            JOIN tutorias ON repositorios.tutorias_id=tutorias.id
            WHERE tutorias_id = $tutorias_id AND repositorios.activo = 'Activo' ORDER BY repositorios.nombre ASC";


            $consulta_total="SELECT COUNT(*) FROM repositorios WHERE tutorias_id = $tutorias_id AND activo = 'Activo'";

            $conexion=conexion();
            $datos = $conexion->query($consulta_datos);
            $datos = $datos->fetchAll();

            $total = $conexion->query($consulta_total);
            $total = (int) $total->fetchColumn();

            if($total>=1){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;

                foreach($datos as $rows){
                    $fecha_1 = $rows['fecha_visualizacion'];
                    $fecha_visualizacion = date("d/m/Y", strtotime($fecha_1));
                    $fecha_2 = $rows['fecha_eliminacion'];
                    $fecha_eliminacion = date("d/m/Y", strtotime($fecha_2));

                    $hora_1 = $rows['hora_visualizacion'];
                    $hora_visualizacion = date("H:i", strtotime($hora_1));
                    $hora_2 = $rows['hora_eliminacion'];
                    $hora_eliminacion = date("H:i", strtotime($hora_2));


                    $tabla.='
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-64x64">';
                                if(is_file("./multimedia/".$rows['nombre_archivo'])){
                                    $tabla.='<img src="./multimedia/'.$rows['nombre_archivo'].'">';

                                }else{
                                    $tabla.='<img src="./img/archivo.png">';
                                }

                    $tabla.='</p>
                            </figure>
                            <div class="media-content">
                                <div class="content">
                                <p>
                                    <strong>'.$contador.' - Subido por '.$rows['nombre'].' '.$rows['apellido'].'</strong><br>
                                    <strong>Tema:</strong> '.$rows['tema'].'<br>
                                    <strong>Subido el:</strong> '.$fecha_visualizacion.' al las '.$hora_visualizacion.'<br>
                                    <strong>Se Elimina el:</strong> '.$fecha_eliminacion.' al las '.$hora_eliminacion.'<br>
                                </p>
                                </div>
                                <div class="has-text-right">
                                    <a href="index.php?vista=ver_archivo&archivo='.$rows['archivo_id'].'&id='.$rows['tutorias_id'].'&ci='.$rows['usuarios_ci'].'" class="button is-success is-rounded is-small">Imagen</a>';

                    if($_SESSION['usuarios_tipos_id'] != 3)
                        $tabla.='
                                        <a href="'.$url.'&archivo_borrar='.$rows['archivo_id'].'&id='.$rows['tutorias_id'].'&ci='.$rows['usuarios_ci'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                                    </div>
                                </div>
                            </article>

                            <hr>
                        ';
                    $contador++;
                }
                $pag_final=$contador-1;
            }else{
                if($total>=1){
                    $tabla.='
                        <p class="has-text-centered" >
                            <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </p>
                    ';
                }else{
                    $tabla.='
                        <p class="has-text-centered"> No hay registros en el sistema</p>
                    ';
                }
            }

            if($total>0){
                $tabla.='<p class="has-text-right">Mostrando archivos multimedia del <strong>'.$pag_inicio.'</strong> al <strong>'.$total.'</strong> de un <strong> total de '.$total.'</strong></p> <br><br>';

            }

            $conexion=null;
            echo $tabla;
        }
    }

    if(isset($_GET['archivo_borrar'])){
        $id_archivo = $_GET['archivo_borrar'];
        $usuarios_ci = $_GET['ci'];
        $tutorias_id = $_GET['id'];

        $actualizar_repositorios = conexion()->prepare("UPDATE repositorios SET activo='No Activo'
        WHERE id_archivo=:id_archivo AND usuarios_ci=:usuarios_ci AND tutorias_id=:tutorias_id");

        $marcadores = [
            ":id_archivo" => $id_archivo,
            ":usuarios_ci" => $usuarios_ci,
            ":tutorias_id" => $tutorias_id,
        ];
    
        $actualizar_repositorios->execute($marcadores);
    }
?>