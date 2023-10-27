<?php
    require_once "./page/tutorias.php";

    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    $tabla="";

    if(isset($busqueda) && $busqueda!=""){

        $consulta_datos="SELECT * FROM tutorias WHERE ((ci!='".$_SESSION['ci']."') AND (nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%' OR email LIKE '%$busqueda%' OR direccion LIKE '%$busqueda%')) ORDER BY nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(ci) FROM usuarios WHERE ((ci!='".$_SESSION['ci']."') AND (nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%' OR email LIKE '%$busqueda%' OR direccion LIKE '%$busqueda%'))";

    }else{

        $consulta_datos="SELECT * FROM usuarios WHERE ci!='".$_SESSION['ci']."' ORDER BY nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(ci) FROM usuarios WHERE ci!='".$_SESSION['ci']."'";
        
    }

    $conexion=conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas =ceil($total/$registros);

    $tabla.='
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
    ';

    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
            $tabla.='
                <tr class="has-text-centered" >
                    <td>'.$rows['ci'].'</td>
                    <td>'.$rows['nombre'].'</td>
                    <td>'.$rows['apellido'].'</td>
                    <td>'.$rows['email'].'</td>
                    <td>
                        <a href="index.php?vista=user_update&user_ci_up='.$rows['ci'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_ci_del='.$rows['ci'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
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
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }


    $tabla.='</tbody></table></div>';

    if($total>0 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Mostrando tutorías del <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    $conexion=null;
    echo $tabla;

    if($total>=1 && $pagina<=$Npaginas){
        echo paginador_tablas($pagina,$Npaginas,$url,7);
    }

?>