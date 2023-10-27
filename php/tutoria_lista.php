<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";
	$ci_usuario = $_SESSION['ci'];
	$colspan = 9;
	$pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$home = stripos($pagina_actual, 'home') !== false;
	$tutorship_list = stripos($pagina_actual, 'tutorship_list') !== false;
	$historial_tutorias = stripos($pagina_actual, 'historial_tutorias') !== false;
	


	if(isset($busqueda) && $busqueda!=""){

		$consulta_datos="SELECT * FROM tutorias WHERE (grupo LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%' OR email LIKE '%$busqueda%' OR direccion LIKE '%$busqueda%') ORDER BY nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(ci) FROM tutorias WHERE (grupo LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%' OR email LIKE '%$busqueda%' OR direccion LIKE '%$busqueda%')";

	}else{
		
		if(stripos($pagina_actual, 'tutorship_list') || stripos($pagina_actual, 'home') !== false){
			$consulta_datos = "SELECT * FROM tutorias JOIN usuarios ON usuarios.ci = tutorias.docente_ci OR usuarios.ci = tutorias.administrador_ci JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id WHERE ci = $ci_usuario ORDER BY grupo ASC LIMIT $inicio, $registros";

			$consulta_total = "SELECT COUNT(*) AS cantidad_resultados FROM tutorias JOIN usuarios ON usuarios.ci = tutorias.docente_ci OR usuarios.ci = tutorias.administrador_ci JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id WHERE ci = $ci_usuario ORDER BY grupo ASC LIMIT $inicio, $registros";
		

		}elseif(stripos($pagina_actual, 'historial_tutorias') !== false){
			$consulta_datos = "SELECT * FROM tutorias JOIN usuarios ON usuarios.ci = tutorias.docente_ci OR usuarios.ci = tutorias.administrador_ci JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id WHERE ci = $ci_usuario ORDER BY grupo ASC LIMIT $inicio, $registros";

			$consulta_total = "SELECT COUNT(*) AS cantidad_resultados FROM tutorias JOIN usuarios ON usuarios.ci = tutorias.docente_ci OR usuarios.ci = tutorias.administrador_ci JOIN tutorias_tipos ON tutorias.tutorias_tipos_id = tutorias_tipos.id WHERE ci = $ci_usuario ORDER BY grupo ASC LIMIT $inicio, $registros";
		}
		
	}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();
	$Npaginas = ceil($total/$registros);

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

	if($historial_tutorias)
    $tabla.='	
					<tr class="has-text-centered is-vcentered tabla_encabezado">
						<th colspan="10"> <p class="tabla_titulo"> Lista de Tutorías </p> </th>
					</tr>';

	$tabla.=' 		<tr class="has-text-centered">';
	
	if($historial_tutorias)
	$tabla.='
						<th class="tabla_texto"> Administrador </th>
						<th class="tabla_texto"> Docente </th>';

	$tabla.='
						<th class="tabla_texto"> Tutoría </th>
						<th class="tabla_texto"> Dias </th>
						<th class="tabla_texto"> Tipo </th>
						<th class="tabla_texto"> Fecha de Inicio </th>
						<th class="tabla_texto"> Fecha de Finalización </th>
						<th class="tabla_texto"> Hora de Inicio </th>
						<th class="tabla_texto"> Hora de Finalización </th>';
			

	if($tutorship_list || $home)
	$tabla.=' 			<th class="tabla_texto" colspan="2"> Opciones </th>';

	if($historial_tutorias)
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
				<tr class="has-text-centered">';

			if($historial_tutorias)
			$tabla .= '
					<td class="tabla_texto">'.$rows['nombre'].'</td>
					<td class="tabla_texto">'.$rows['nombre'].'</td>';

			$tabla.='
                    <td class="tabla_texto">'.$rows['grupo'].'</td>
                    <td class="tabla_texto">'.$rows['dias'].'</td>
                    <td class="tabla_texto">'.$rows['nombre_tipo'].'</td>
                    <td class="tabla_texto">'.$fecha_inicial.'</td>
                    <td class="tabla_texto">'.$fecha_final.'</td>
					<td class="tabla_texto">'.$hora_inicial.'</td>
                    <td class="tabla_texto">'.$hora_final.'</td>
                    <td class="tabla_texto is-fullwidth">';
				
			if($tutorship_list || $home)		
			$tabla.='
				<div>
					<div class="contenedor_opciones pr-1">
						<a href="index.php?vista=tutorship_update&docente_ci='. $rows['docente_ci'] .'&dias='. $rows['dias']. '&hora_inicial='. $rows['hora_inicial'] .'" class="button is-success is-rounded is-small opciones"> Actualizar </a>
					</div>
				</td>
				<td class="tabla_texto is-fullwidth pr-4">
					<div class="contenedor_opciones pr-1">
						<a href="index.php?vista=tutorship_delete&docente_ci='. $rows['docente_ci'] .'&dias='. $rows['dias']. '&hora_inicial='. $rows['hora_inicial'] .'" class="button is-danger is-rounded is-small opciones"> Archivar </a>
					</div>
				</td>
			</tr>';

			if($historial_tutorias)
			$tabla.='
				<div>
					<div class="contenedor_opciones pr-1">
						<a href="index.php?vista=tutorship_update&docente_ci='. $rows['id'] .'" class="button is-success is-rounded is-small opciones"> Dar de Alta </a>
					</div>
				</td>';
		$contador++;

		}
		$pag_final=$contador-1;
		
	}else{
		if($historial_tutorias)
			$colspan = 10;

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
						No hay tutorías ingresadas con este usuario
					</td>
				</tr>
			';
		}
	}

	$tabla.='</tbody></table></div>';
	$inicio++;
	$contador--;

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando tutorías del <strong>'.$inicio.'</strong> al <strong>'.$contador.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;
	echo "<br>";

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}

	if($tutorship_list)
        echo "<br> <br>";

?>