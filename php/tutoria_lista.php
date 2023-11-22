<?php
	$pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$home = (stripos($pagina_actual, 'home') !== false);
	$tutorship_list = stripos($pagina_actual, 'tutorship_list') !== false;
	$historial_tutorias = stripos($pagina_actual, 'historial_tutorias') !== false;

	if($home){
		$registros = 3;
	}else{
		$registros = 99;
	}
		
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";
	$ci_usuario = $_SESSION['ci'];
	$colspan = 9;

	if($home)
		$url = "index.php?vista=home&page=";
	if($tutorship_list)
		$url = "index.php?vista=home&page=";
	if($historial_tutorias)
		$url = "index.php?vista=tutorship_list";

	$administrador = $_SESSION['usuarios_tipos_id'] == 1;
	$docente = $_SESSION['usuarios_tipos_id'] == 2;
	$estudiante = $_SESSION['usuarios_tipos_id'] == 3;

	if($historial_tutorias){
		$consulta_activa = "'No Activa'";

	}else{
		$consulta_activa = "'Activa'";
	}


	if($administrador){
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
			WHERE tutorias.administrador_ci = $ci_usuario AND tutorias.activa = $consulta_activa
			ORDER BY nombre ASC LIMIT $inicio, $registros;";

		$consulta_total = "SELECT COUNT(*)
			FROM tutorias
			JOIN usuarios ON tutorias.administrador_ci = usuarios.ci
			JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
			WHERE usuarios.ci = $ci_usuario AND tutorias.activa = $consulta_activa;";	



	}elseif($docente){
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
			WHERE usuarios.ci = $ci_usuario AND tutorias.activa = $consulta_activa
			ORDER BY nombre ASC LIMIT $inicio, $registros;";

		$consulta_total = "SELECT COUNT(*)
			FROM tutorias
			JOIN usuarios ON tutorias.docente_ci = usuarios.ci
			JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
			WHERE usuarios.ci = $ci_usuario AND tutorias.activa = $consulta_activa;";


	}elseif($estudiante){
		$usuario_tipo = "";

		$consulta_datos = "SELECT
                (SELECT nombre FROM usuarios WHERE ci = tutorias.docente_ci) AS nombre_docente,
                (SELECT apellido FROM usuarios WHERE ci = tutorias.docente_ci) AS apellido_docente,
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
            FROM tutorias_estudiantes
            JOIN usuarios ON tutorias_estudiantes.estudiantes_ci = usuarios.ci
            JOIN tutorias ON tutorias_estudiantes.tutorias_id = tutorias.id
            JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
            WHERE tutorias_estudiantes.estudiantes_ci = $ci_usuario AND tutorias.activa = $consulta_activa
            ORDER BY nombre ASC LIMIT $inicio, $registros;";


		$consulta_total = "SELECT COUNT(*)
			FROM tutorias_estudiantes
			JOIN usuarios ON tutorias_estudiantes.estudiantes_ci = usuarios.ci
			JOIN tutorias ON tutorias_estudiantes.tutorias_id = tutorias.id
			JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id
			WHERE tutorias_estudiantes.estudiantes_ci = $ci_usuario AND tutorias.activa = $consulta_activa;";	

	}


	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();
	$Npaginas = ceil($total/$registros);

	if($home){
		if(!isset($_GET['page'])){
			$pagina=1;
		}else{
			$pagina=(int) $_GET['page'];
			if($pagina<=1){
				$pagina=1;
			}
		}
	}
	

	
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

		<div class="table-container">
			<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
				<thead>';

	if($home && $estudiante)
    $tabla.='		<tr class="has-text-centered is-vcentered tabla_encabezado">
						<th colspan="5"> <p class="tabla_titulo pt-1"> </p> </th>
					</tr>';

	if($home && !($estudiante))
    $tabla.='		<tr class="has-text-centered is-vcentered tabla_encabezado">
						<th colspan="7"> <p class="tabla_titulo pt-1"> </p> </th>
					</tr>';

	if($tutorship_list && !($estudiante))
    $tabla.='		<tr class="has-text-centered is-vcentered tabla_encabezado">
						<th colspan="11"> <p class="tabla_titulo"> Lista de Tutorías </p> </th>
					</tr>';

	if($tutorship_list && $estudiante)
	$tabla.='		<tr class="has-text-centered is-vcentered tabla_encabezado">
						<th colspan="9"> <p class="tabla_titulo"> Lista de Tutorías </p> </th>
					</tr>';

	if($historial_tutorias && !($estudiante))
    $tabla.='		<tr class="has-text-centered is-vcentered tabla_encabezado">
						<th colspan="9"> <p class="tabla_titulo"> Lista de Tutorías </p> </th>
					</tr>';


	$tabla.=' 		<tr class="has-text-centered">';
	
	if(($home) && (!($total>=1))){
		$tabla.='
						<th class="tabla_texto" colspan="7"> Usuario no Ingresado </th>';

	}elseif($home && !($estudiante))
	$tabla.='			<th class="tabla_texto"> Grupo </th>
						<th class="tabla_texto"> '.$usuario_tipo.'</th>
						<th class="tabla_texto"> Dias </th>
						<th class="tabla_texto"> Periodo </th>';


	if($home && $estudiante && ($total>=1))
	$tabla.='			<th class="tabla_texto"> Grupo </th>
						<th class="tabla_texto"> Admin. </th>
						<th class="tabla_texto"> Docente </th>
						<th class="tabla_texto"> Dias </th>
						<th class="tabla_texto"> Periodo </th>';
	

					
	if(($tutorship_list || $historial_tutorias) && $estudiante)
	$tabla.='			<th class="tabla_texto"> Grupo </th>
						<th class="tabla_texto"> Admin. </th>
						<th class="tabla_texto"> Docente </th>
						<th class="tabla_texto"> Dias </th>
						<th class="tabla_texto"> Comienza </th>
						<th class="tabla_texto"> Termina </th>
						<th class="tabla_texto"> Fecha de Inicio </th>
						<th class="tabla_texto"> Fecha Final </th>
						<th class="tabla_texto"> Periodo </th>';

	if(($tutorship_list || $historial_tutorias) && !($estudiante))
	$tabla.='			<th class="tabla_texto"> Grupo </th>
						<th class="tabla_texto"> '.$usuario_tipo.'</th>
						<th class="tabla_texto"> Dias </th>
						<th class="tabla_texto"> Comienza </th>
						<th class="tabla_texto"> Termina </th>
						<th class="tabla_texto"> Fecha de Inicio </th>
						<th class="tabla_texto"> Fecha Final </th>
						<th class="tabla_texto"> Periodo </th>';
			

	if($tutorship_list && !($estudiante))
	$tabla.=' 			<th class="tabla_texto" colspan="3"> Opciones </th>';

	if(($home) && ($total>=1) && !($estudiante))
	$tabla.=' 			<th class="tabla_texto" colspan="3"> Opciones </th>';

	if($historial_tutorias && !($estudiante))
	$tabla.=' 			<th class="tabla_texto" colspan="1"> Opciones </th>';

	$tabla.='
		</tr>
	</thead>
	<tbody>
	';
	$contador = 0;

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;

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


			if($administrador || $estudiante)
			$tabla .= '
				<td class="tabla_texto">'.$rows['nombre_docente'].' '.$rows['apellido_docente'].'</td>';

			if($docente || $estudiante)
			$tabla .= '
				<td class="tabla_texto">'.$rows['nombre_administrador'].' '.$rows['apellido_administrador'].'</td>';

			if($tutorship_list || $historial_tutorias)	
			$tabla .= '
					<td class="tabla_texto">'.$rows['dias'].'</td>
					<td class="tabla_texto">'.$hora_inicial.'</td>
                    <td class="tabla_texto">'.$hora_final.'</td>
					<td class="tabla_texto">'.$fecha_inicial.'</td>
                    <td class="tabla_texto">'.$fecha_final.'</td>
					<td class="tabla_texto">'.$rows['nombre_tipo'].'</td>';

			if($home)
				$tabla.='
                    <td class="tabla_texto">'.$rows['dias'].'</td>
                    <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>';
				
			if(($tutorship_list || $home) && !($estudiante))		
				$tabla.='
					<td class="tabla_texto is-fullwidth pl-2 pr-2">
						<div class="pr-1">
							<a href="index.php?vista=tutorship_update&id='. $rows['id'] .'" class="button is-success is-rounded is-small opciones"> Actualizar </a>
						</div>
					</td>
					<td class="tabla_texto is-fullwidth pl-2 pr-2">
						<div class="pr-1">
							<a href="index.php?vista=agregar_estudiante&id='. $rows['id'] .'" class="button is-black is-rounded is-small opciones"> Estudiantes </a>
						</div>
					</td>
					<td class="tabla_texto is-fullwidth pl-2 pr-2">
						<div class="pr-1">
							<a href="index.php?vista=tutoria_archivar&id='. $rows['id'] .'" class="button is-danger is-rounded is-small opciones"> Archivar </a>
						</div>
					</td>
				</tr>';

			if($historial_tutorias && !($estudiante))
			$tabla.='
				<td class="tabla_texto is-fullwidth pl-2 pr-2">
					<div class="pr-1">
						<a href="index.php?vista=historial_tutorias&page=1&id='.$rows['id'].'" class="button is-success is-rounded is-small"> Dar de Alta </a>
					</div>
				</td>';
		$contador++;

		}
		$pag_final=$contador-1;
		
	}else{
		if($tutorship_list && !($estudiante))
			$colspan = 11;
		if($tutorship_list && $estudiante)
			$colspan = 9;
		if($historial_tutorias)
			$colspan = 9;
		if($home)
			$colspan = 7;

		if(!($historial_tutorias)){
			if($total>=1){
				$tabla.='
					<tr class="has-text-centered" >
						<td colspan='.$colspan.'>
							<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
								Haga clic acá para recargar el listado
							</a>
						</td>
					</tr>
				';
			}else{
				if($estudiante){
					$tabla.='
						<tr class="has-text-centered" >
							<td colspan='.$colspan.'>
								<p> No hay tutorías relacionadas al usuario actual con la C.I. '.$ci_usuario.' </p>
								<p> Solicite a un administrador o docente referente que lo ingrese </p>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
							<td colspan='.$colspan.'>
								<p> No hay tutorías relacionadas al usuario actual con la C.I. '.$ci_usuario.' </p>
								<a href="index.php?vista=user_new" class="button is-link is-rounded is-small mt-4 mb-4">
									Haga clic aquí para agregarlo
								</a>
								<a href="index.php?vista=historial_usuarios" class="button is-link is-rounded is-small mt-4 mb-4">
									O aquí para ver el historial de usuarios
								</a>
							</td>
						</tr>
					';
				}
			}

		}else{
			if($total>=1){
				$tabla.='
					<tr class="has-text-centered" >
						<td colspan='.$colspan.'>
							<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
								Haga clic acá para recargar el listado
							</a>
						</td>
					</tr>
				';
			}else{
				$tabla.='
					<tr class="has-text-centered" >
						<td colspan='.$colspan.'>
							<p> No hay tutorías archivadas, si lo desea puede </p>
							<a href="index.php?vista=tutorship_list" class="button is-link is-rounded is-small mt-4 mb-4 mr-2">
								Listar las tutorías ingresadas
							</a>
							<a href="index.php?vista=tutorship_new" class="button is-link is-rounded is-small mt-4 mb-4 ml-2">
								O crear una nueva tutoría
							</a>
						</td>
					</tr>
				';
			}
		}
	}

	$tabla.='</tbody></table></div>';
	$inicio++;
	$contador--;

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando tutorías del <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;
	echo "<br>";

	if(!($tutorship_list || $historial_tutorias)){
		if($total>=1 && $pagina<=$Npaginas){
			echo paginador_tablas($pagina,$Npaginas,$url,5);
		}
	}
	

	if($tutorship_list || $historial_tutorias)
        echo "<br> <br>";

?>