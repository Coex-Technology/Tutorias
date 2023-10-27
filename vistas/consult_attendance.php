<?php

    echo '
        <div class="container is-fluid mb-6">
            <h1 class="title"> Asistencia </h1>
            <h2 class="subtitle"> Lista de usuarios </h2>
        </div>
    <div class="container pb-6 pt-6">';

    include "./php/main.php";

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
     

    # Verificando asistencias #
    $check_asistencias=conexion();
    $check_asistencias=$check_asistencias->query("SELECT * FROM asistencias WHERE usuarios_ci='$ci'");

    # Verificando contactos #
    $check_contactos=conexion();
    $check_contactos=$check_contactos->query("SELECT * FROM contactos WHERE ci='$ci'");

    # Verificando tutorias (docente) #
    $check_tutorias_docente=conexion();
    $check_tutorias_docente=$check_tutorias_docente->query("SELECT usuarios.*, tutorias.* FROM usuarios, tutorias WHERE tutorias.docente_ci = usuarios.ci AND docente_ci = '$ci'");
    $tutorias_docente_datos=$check_tutorias_docente->fetchAll(PDO::FETCH_ASSOC);


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
                        <th colspan="8"> <p class="tabla_titulo"> Asistencia </p> </th>
                    </tr>
                    <tr class="has-text-centered">
                        <th class="tabla_texto"> <p class="tabla_titulo"> Tutoría </p> </th>
                        <th class="tabla_texto"> <p class="tabla_titulo"> Docente </p> </th>
                        <th class="tabla_texto"> <p class="tabla_titulo"> Fecha </p> </th>
                        <th class="tabla_texto"> <p class="tabla_titulo"> Asistencias </p> </th>
                        <th class="tabla_texto"> Inasistencias Justificadas</th>
                        <th class="tabla_texto"> Inasistencias Injustificadas</th>
                        <th class="tabla_texto" colspan="2"> <p class="tabla_titulo"> Opciones </p> </th>
                    </tr>
                </thead>
                <tbody>
    ';

    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;

        foreach($tutorias_docente_datos as $rows_tutorias_docente){
            foreach($check_asistencias as $rows_asistencias){
    
                if($rows_asistencias['asistencias']  == NULL){
                    $rows_asistencias['asistencias'] = "<i><u> [Asistencias no ingresadas] </u></i>";
                }

                if($rows_asistencias['inasistencias_justificadas']  == NULL){
                    $rows_asistencias['inasistencias_justificadas'] = "<i><u> [Inasistencias no ingresadas] </u></i>";
                }

                if($rows_asistencias['inasistencias_injustificadas']  == NULL){
                    $rows_asistencias['inasistencias_injustificadas'] = "<i><u> [Inasistencias no ingresadas] </u></i>";
                }

                $fecha = $rows_asistencias['fecha'];
                $fecha = date("d/m/Y", strtotime($fecha));
                
                $tabla.='
                    <tr class="has-text-centered" >
                        <td class="tabla_texto">'.$rows_tutorias_docente['tutoria'].'</td>
                        <td class="tabla_texto">'.$rows_tutorias_docente['usuario'].'</td>
                        <td class="tabla_texto">'.$fecha.'</td>
                        <td class="tabla_texto">'.$rows_asistencias['asistencias'].'</td>
                        <td class="tabla_texto">'.$rows_asistencias['inasistencias_justificadas'].'</td>
                        <td class="tabla_texto">'.$rows_asistencias['inasistencias_injustificadas'].'</td>
                        <td class="tabla_texto">
                            <a href="index.php?vista=user_update&user_ci_up='.$rows_asistencias['ci'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td class="tabla_texto">
                            <a href="'.$url.$pagina.'&user_ci_del='.$rows_asistencias['ci'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                        </td>
                    </tr>
                ';
                $contador++;
            }
        }
        $pag_final=$contador-1;
        
    }else{
        if($total1>=1){
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

    echo $tabla;
    echo "<br>";

    // if($total>=0 && $pagina<=$Npaginas){
    // 	echo paginador_tablas($pagina,$Npaginas,$url,7);
    // }
?>