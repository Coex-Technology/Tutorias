<?php
    $url="index.php?vista=consult_attendance";
    $registros=99;
    $tabla="";
    $usuario_ci = $_SESSION['ci'];

    if(!(isset($_GET['id']) && isset($_GET['id']) != "")){
        echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Asistencia </h1>
                <h2 class="subtitle"> Pasar Lista </h2>
            </div>

            <div class="container pt-3 b barra_asistencia"> 
        ';
        
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
        $url="index.php?vista=consult_attendance";
        $registros=7;
        $busqueda="";
        $total=1;
        $pagina=1;
        $Npaginas=1;
        $conexion = conexion();

        $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
        $ci = $_SESSION['ci'];
        $id = 0;

        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        

        # Verificando asistencias #
        $check_asistencias=conexion();
        $check_asistencias=$check_asistencias->query("SELECT COUNT(*) FROM asistencias WHERE docente_ci='$ci' AND tutorias_id = '$id'");

        
        $consulta_asistencias = "SELECT 
            usuarios.ci AS ci,
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
            asistencias.fecha AS fecha,
            asistencias.fecha_ingreso AS fecha_ingreso,
            asistencias.inasistencias_justificadas AS inasistencias_justificadas,
            asistencias.inasistencias_injustificadas AS inasistencias_injustificadas
        FROM asistencias
        JOIN usuarios ON asistencias.estudiantes_ci = usuarios.ci
        JOIN tutorias ON asistencias.tutorias_id = tutorias.id
        WHERE tutorias.id = $id
        ORDER BY fecha ASC";

        $datos_asistencias = $conexion->query($consulta_asistencias);
        $datos_asistencias = $datos_asistencias->fetchAll();

        if(!($_SESSION['usuarios_tipos_id'] == 3)){
            $contar_asistencia = conexion();
            $contar_asistencia = $contar_asistencia->prepare("SELECT COUNT(*)
            FROM asistencias
            JOIN usuarios ON asistencias.estudiantes_ci = usuarios.ci
            JOIN tutorias ON asistencias.tutorias_id = tutorias.id
            WHERE tutorias.id = $id
            ORDER BY fecha ASC;");

            $contar_asistencia->execute();
            $datos_contar = $contar_asistencia->fetch(PDO::FETCH_ASSOC);
            $total = $datos_contar["COUNT(*)"];

        }else{
            $total = 0;
            foreach($datos_asistencias as $rows){

                if($rows['inasistencias_justificadas'] == 0 && $rows['inasistencias_injustificadas'] == 0){
                    $total++;
                }
            }
        }

        $tabla="";

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
            </style>';

        if(!($_SESSION['usuarios_tipos_id'] == 3)){
            $tabla.='			
                <div class="table-container mt-3">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                            <tr class="has-text-centered is-vcentered tabla_encabezado">
                                <th colspan="7"> <p class="tabla_titulo"> Asistencia </p> </th>
                            </tr>
                            <tr class="has-text-centered">
                                <th class="tabla_texto"> <p class="tabla_titulo"> Nombre </p> </th>
                                <th class="tabla_texto"> <p class="tabla_titulo"> Fecha </p> </th>
                                <th class="tabla_texto"> <p class="tabla_titulo"> Fecha de Ingreso </p> </th>
                                <th class="tabla_texto"> Inasistencias Justificadas</th>
                                <th class="tabla_texto"> Inasistencias Injustificadas</th>
                                <th class="tabla_texto" colspan=2> <p class="tabla_titulo"> Opciones </p> </th>
                            </tr>
                        </thead>
                        <tbody>
            ';
        }else{
            $tabla.='			
                <div class="table-container mt-3">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                            <tr class="has-text-centered is-vcentered tabla_encabezado">
                                <th colspan="5"> <p class="tabla_titulo"> Asistencia </p> </th>
                            </tr>
                            <tr class="has-text-centered">
                                <th class="tabla_texto"> <p class="tabla_titulo"> Nombre </p> </th>
                                <th class="tabla_texto"> <p class="tabla_titulo"> Fecha </p> </th>
                                <th class="tabla_texto"> <p class="tabla_titulo"> Fecha de Ingreso </p> </th>
                                <th class="tabla_texto"> Inasistencias Justificadas</th>
                                <th class="tabla_texto"> Inasistencias Injustificadas</th>
                            </tr>
                        </thead>
                        <tbody>
            ';
        }

        if($total>=1){
            $contador=$inicio+1;
            $pag_inicio=$inicio+1;

            foreach($datos_asistencias as $rows){
                $grupo = $rows['grupo'];

                if($rows['inasistencias_justificadas']  == NULL){
                    $rows['inasistencias_justificadas'] = "0";
                }

                if($rows['inasistencias_injustificadas']  == NULL){
                    $rows['inasistencias_injustificadas'] = "0";
                }

                if($_SESSION['usuarios_tipos_id'] == 3){
                    if($_SESSION['ci'] == $rows['ci']){

                        if(!($rows['inasistencias_justificadas'] == 0 && $rows['inasistencias_injustificadas'] == 0)){
                            $fecha = $rows['fecha'];
                            $fecha = date("d/m/Y", strtotime($fecha));
                            $fecha_ingreso = $rows['fecha_ingreso'];
                            $fecha_ingreso = date("d/m/Y", strtotime($fecha_ingreso));
                            
                            $tabla.='
                                <tr class="has-text-centered" >
                                    <td class="tabla_texto">'.$rows['nombre'].' '.$rows['apellido'].'</td>
                                    <td class="tabla_texto">'.$fecha.'</td>
                                    <td class="tabla_texto">'.$fecha_ingreso.'</td>
                                    <td class="tabla_texto">'.$rows['inasistencias_justificadas'].'</td>
                                    <td class="tabla_texto">'.$rows['inasistencias_injustificadas'].'</td>
                                </tr>
                            ';
                            $contador++;
                        }
                    }

                }else{
                    if(!($rows['inasistencias_justificadas'] == 0 && $rows['inasistencias_injustificadas'] == 0)){
                        $fecha = $rows['fecha'];
                        $fecha = date("d/m/Y", strtotime($fecha));
                        $fecha_ingreso = $rows['fecha_ingreso'];
                        $fecha_ingreso = date("d/m/Y", strtotime($fecha_ingreso));
                        
                        $tabla.='
                            <tr class="has-text-centered" >
                                <td class="tabla_texto">'.$rows['nombre'].' '.$rows['apellido'].'</td>
                                <td class="tabla_texto">'.$fecha.'</td>
                                <td class="tabla_texto">'.$fecha_ingreso.'</td>
                                <td class="tabla_texto">'.$rows['inasistencias_justificadas'].'</td>
                                <td class="tabla_texto">'.$rows['inasistencias_injustificadas'].'</td>
                                <td class="tabla_texto">
                                    <a href="index.php?vista=attendance&id='.$rows['id'].'&ci='.$rows['ci'].'&fecha='.$rows['fecha'].'" class="button is-success is-rounded is-small">Actualizar</a>
                                </td>
                                <td class="tabla_texto">
                                    <a href="index.php?vista=attendance&id='.$rows['id'].'&ci='.$rows['ci'].'&fecha='.$rows['fecha'].'&del=true" class="button is-danger is-rounded is-small">Eliminar</a>
                                </td>
                            </tr>
                        ';
                        $contador++;
                    }
                }

                
            }
            $pag_final=$contador-1;
            
        }else{
            if($total>=1){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td colspan="7">
                            <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </td>
                    </tr>
                ';
            }else{
                $tabla.='
                    <tr class="has-text-centered" >
                        <td colspan="7">
                            No se ha pasado asistencia aun a esta tutoría
                        </td>
                    </tr>
                ';
            }
        }
                
        $tabla.='</tbody></table></div>';

        if($total>0){
            $tabla.='<p class="has-text-right">Mostrando lista de asistencias del <strong>'.$pag_inicio.'</strong> al <strong>'.$total.'</strong> de un <strong>total de '.$total.'</strong></p>';
        }

        if($total>0){
            echo '
                <div class="container is-fluid mb-6">
                    <h1 class="title"> Asistencia </h1>
                    <h2 class="subtitle"> Lista de Asistencias del Grupo <br> '.$grupo.'</h2>
                </div>
            <div class="container pb-6">';

        }else{
            echo '
                <div class="container is-fluid mb-6">
                    <h1 class="title"> Asistencia </h1>
                    <h2 class="subtitle"> Lista de Asistencias <br> </h2>
                </div>
            <div class="container pb-6">';
        }

        echo $tabla;
        echo "<br>";
    }
?>