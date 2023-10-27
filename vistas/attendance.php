<?php

    echo '
        <div class="container is-fluid mb-6">
            <h1 class="title"> Asistencia </h1>
            <h2 class="subtitle"> Pasar Lista </h2>
        </div>
    <div class="container pt-3">';

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

    $conexion=conexion();     

    # Verificando asistencias #
    $check_asistencias=conexion();
    $check_asistencias=$check_asistencias->query("SELECT * FROM asistencias WHERE usuarios_ci='$ci'");

    # Verificando tutorias (docente) #
    $check_tutorias_docente=conexion();
    $check_tutorias_docente=$check_tutorias_docente->query("SELECT usuarios.*, tutorias.* FROM usuarios, tutorias WHERE tutorias.docente_ci = usuarios.ci AND docente_ci = '$ci'");
    $tutorias_docente_datos=$check_tutorias_docente->fetchAll(PDO::FETCH_ASSOC);


   

    $consulta_datos = "SELECT * FROM usuarios JOIN contactos ON usuarios.ci = contactos.ci WHERE usuarios.ci != '".$_SESSION['ci']."' AND usuarios.activo = 'Activo' ORDER BY usuarios.ci ASC LIMIT $inicio, $registros";

    $datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

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

			if($rows['email']  === NULL){
				$rows['email'] = "<i><u> [Email no ingresado] </u></i>";
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
			$telefono = $rows['telefono'];
			$email = $rows['email'];
			$usuarios_tipos_id = $rows['usuarios_tipos_id'];

			if(isset($busqueda) && $busqueda!=""){
				$busqueda_minusculas = strtolower($busqueda);

				$ci = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['ci']);
				$nombre = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['nombre']);
				$apellido = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['apellido']);
				$direccion = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['direccion']);
				$telefono = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['telefono']);
				$email = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['email']);
				$usuarios_tipos_id = preg_replace("/($busqueda_minusculas)/iu", '<strong>$1</strong>', $rows['usuarios_tipos_id']);
			
			}

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
    


    // if($total>=0 && $pagina<=$Npaginas){
    // 	echo paginador_tablas($pagina,$Npaginas,$url,7);
    // }
?>