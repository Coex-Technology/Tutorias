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

    $url="index.php?vista=attendance";
    $registros=15;

    $tabla="";
    if(!(isset($_GET['id']) && isset($_GET['id']) != "")){
        echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Asistencia </h1>
                <h2 class="subtitle"> Pasar Lista </h2>
            </div>

            <div class="container pt-3"> 
        ';

        $usuario_ci = $_SESSION['ci'];
        

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
                WHERE usuarios.ci = $usuario_ci;";


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
                WHERE usuarios.ci = $usuario_ci;";	
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
                            <th class="tabla_texto"> '.$usuario_tipo.'</th>
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


            if($_SESSION['usuarios_tipos_id'] == 1)
            $tabla .= '
                <td class="tabla_texto">'.$rows['nombre_docente'].' '.$rows['apellido_docente'].'</td>';

            if($_SESSION['usuarios_tipos_id'] == 2)
            $tabla .= '
                <td class="tabla_texto">'.$rows['nombre_administrador'].' '.$rows['apellido_administrador'].'</td>';

            $tabla .= '
                <td class="tabla_texto">'.$rows['dias'].'</td>
                <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>
                <td class="tabla_texto is-fullwidth">
                    <a href="'.$url.'&id='.$rows['id'].'" class="button is-success is-rounded is-small"> Seleccionar </a>
                </td>
            </tr>';

        }

        $tabla.='</tbody></table></div>';
        $conexion=null;
        echo $tabla;

    
    }else{

        #---------------------------------------- Pasar Asistencia (Tabla) ----------------------------------------#

        echo '
            <div class="container is-fluid mt-5 mb-4">
                <h1 class="title"> Asistencia </h1>
                <h2 class="subtitle"> Pasar Lista </h2>
            </div>

            <div class="container pt-3"> 
        ';


        echo '<div class="container pt-3">';


        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=user_list&page=";
        $registros=7;
        $busqueda="";
        $total=1;
        $pagina=1;
        $Npaginas=1;

        $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
        $ci = $_SESSION['ci'];

        $conexion=conexion();     

        # Verificando asistencias #
        $check_asistencias=conexion();
        $check_asistencias=$check_asistencias->query("SELECT * FROM asistencias WHERE usuarios_ci='$ci'");

        # Verificando tutorias (docente) #
        $check_tutorias_docente=conexion();
        $check_tutorias_docente=$check_tutorias_docente->query("SELECT usuarios.*, tutorias.* FROM usuarios, tutorias WHERE tutorias.docente_ci = usuarios.ci AND docente_ci = '$ci'");
        $tutorias_docente_datos=$check_tutorias_docente->fetchAll(PDO::FETCH_ASSOC);



        $consulta_datos = "SELECT * FROM usuarios WHERE ci != '".$_SESSION['ci']."' AND activo = 'Activo' ORDER BY ci ASC LIMIT $inicio, $registros";

        $datos = $conexion->query($consulta_datos);
        $datos = $datos->fetchAll();


        if((isset($_GET['id']) && !empty($_GET['id'])) && ($_GET['id']) != "") {
            $tutorias_id = $_GET['id'];

            $consulta_datos2 = "SELECT * FROM tutorias WHERE id != '".$tutorias_id."' ORDER BY grupo ASC LIMIT $inicio, $registros";

            $datos2 = $conexion->query($consulta_datos2);
            $datos2 = $datos2->fetchAll();

            foreach($datos2 as $rows){
                if($rows['id']  == NULL)

            }

            $opcionSeleccionada = $_GET['id'];
            echo 'La tutoría seleccionada es: ' . $opcionSeleccionada;
        

            echo '
                <form action="./php/asistencia_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
                    <div class="columns">
                        <div class="column">
                            <div class="control">
                                <label> Ingresar Fecha </label>
                                <input class="input" type="date" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}" min="0" maxlength="50" required>
                            </div>
                        </div>
                    </div>';


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

            $tabla.='			
                <div class="table-container mt-3">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                            <tr class="has-text-centered is-vcentered tabla_encabezado">
                                <th colspan="5"> <p class="tabla_titulo"> Asistencia </p> </th>
                            </tr>
                            <tr class="has-text-centered">
                            <th class="tabla_texto"> Cedula </th>
                            <th class="tabla_texto"> Nombre </th>
                            <th class="tabla_texto"> Apellido </th>
                            <th class="tabla_texto"> Inasistencias <br> Justificadas </th>
                            <th class="tabla_texto"> Inasistencias <br> Injustifificadas </th>
            ';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;

                foreach($datos as $rows){

                    if($rows['direccion']  === NULL){
                        $rows['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
                    }

                    if($rows['usuarios_tipos_id'] === 1){
                        $rows['usuarios_tipos_id'] = "Administrativo";

                    }elseif($rows['usuarios_tipos_id'] === 2){
                        $rows['usuarios_tipos_id'] = "Docente";
                        
                    }elseif($rows['usuarios_tipos_id'] === 3){
                        $rows['usuarios_tipos_id'] = "Estudiante";
                        
                    }else{
                        $rows['usuarios_tipos_id'] = "Rol no definido";
                    }

                    $ci = $rows['ci'];
                    $nombre = $rows['nombre'];
                    $apellido = $rows['apellido'];
                    $direccion = $rows['direccion'];
                    $usuarios_tipos_id = $rows['usuarios_tipos_id'];


                    $tabla.='
                        <tr class="has-text-centered" >
                            <td class="tabla_texto">'.$ci.'</td>
                            <td class="tabla_texto">'.$nombre.'</td>
                            <td class="tabla_texto">'.$apellido.'</td>
                    ';
                    $tabla.='
                        <td>
                            <div class="columns">
                                <div class="column">
                                    <div class="control">
                                        <label> Ingresar </label>
                                        <input class="input" type="number" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}" min="0" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                        </td>
                    ';
                    $tabla.='
                        <td>
                            <div class="columns">
                                <div class="column">
                                    <div class="control">
                                        <label> Ingresar </label>
                                        <input class="input" type="number" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,50}" min="0" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                        </td>
                    ';

                    $tabla .= '</td>';

                    $contador++;
                }
                $pag_final=$contador-1;
                
            }else{
                if($total>=1){
                    $tabla.='
                        <tr class="has-text-centered" >
                            <td colspan="9">
                                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                                    Haga clic acá para recargar el listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla.='
                        <tr class="has-text-centered" >
                            <td colspan="9">
                                No hay registros en el sistema
                            </td>
                        </tr>
                    ';
                }
            }
                    
            $tabla.='</tbody></table></div>';

            if($total>0 && $pagina<=$Npaginas){
                $tabla.='<p class="has-text-right">Mostrando lista de asistencias del <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            }

            $tabla.='<form>';
            echo $tabla;
            echo "<br>";
            
            if($total>=0 && $pagina<=$Npaginas){
                echo paginador_tablas($pagina,$Npaginas,$url,7);

            }


        } else {
            echo 'No se ha seleccionado ninguna tutoría.';
        }

    }
        
?>