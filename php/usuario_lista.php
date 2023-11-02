<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";
	$pagina_actual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$user_list = stripos($pagina_actual, 'user_list') !== false;
	$historial_usuarios = stripos($pagina_actual, 'historial_usuarios') !== false;

	$conexion=conexion();

	if(isset($busqueda) && $busqueda!=""){

		$busqueda = str_replace("Ñ", "ñ", $busqueda);

		$consulta_datos = "SELECT *
		FROM usuarios
		JOIN contactos ON usuarios.ci = contactos.ci
		WHERE (usuarios.ci != '".$_SESSION['ci']."')
			AND (
					LOWER(usuarios.ci) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(usuarios.nombre) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(usuarios.apellido) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(usuarios.direccion) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(contactos.telefono) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(contactos.email) LIKE '%" . strtolower($busqueda) . "%'
				)
		ORDER BY usuarios.ci ASC LIMIT $inicio, $registros";

		$consulta_total = "SELECT COUNT(usuarios.ci)
		FROM usuarios
		JOIN contactos ON usuarios.ci = contactos.ci
		WHERE (usuarios.ci != '".$_SESSION['ci']."')
			AND (
					LOWER(usuarios.ci) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(usuarios.nombre) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(usuarios.apellido) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(usuarios.direccion) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(contactos.telefono) LIKE '%" . strtolower($busqueda) . "%'
					OR LOWER(contactos.email) LIKE '%" . strtolower($busqueda) . "%'
				)";

	}else{

		if(stripos($pagina_actual, 'user_list') !== false){
			$consulta_datos = "SELECT * FROM usuarios JOIN contactos ON usuarios.ci = contactos.ci WHERE usuarios.ci != '".$_SESSION['ci']."' AND usuarios.activo = 'Activo' ORDER BY usuarios.ci ASC LIMIT $inicio, $registros";

			$consulta_total = "SELECT COUNT(usuarios.ci) FROM usuarios JOIN contactos ON usuarios.ci = contactos.ci WHERE usuarios.ci != '".$_SESSION['ci']."'";
		

		}elseif(stripos($pagina_actual, 'historial_usuarios') !== false){
			$consulta_datos = "SELECT * FROM usuarios JOIN contactos ON usuarios.ci = contactos.ci WHERE usuarios.ci != '".$_SESSION['ci']."' AND usuarios.activo = 'No Activo' ORDER BY usuarios.ci ASC LIMIT $inicio, $registros";
	
			$consulta_total = "SELECT COUNT(usuarios.ci) FROM usuarios JOIN contactos ON usuarios.ci = contactos.ci WHERE usuarios.ci != '".$_SESSION['ci']."' AND usuarios.activo = 'No Activo' ORDER BY usuarios.ci ASC LIMIT $inicio, $registros";
		}
		
	}


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

	if($historial_usuarios){	
		$tabla.='
				<tr class="has-text-centered is-vcentered tabla_encabezado">
					<th colspan="8"> <p class="tabla_titulo"> Lista de Usuarios </p> </th>
				</tr>';
	}

	$tabla.='
                <tr class="has-text-centered">
                	<th class="tabla_texto"> Cedula </th>
                    <th class="tabla_texto"> Nombre </th>
                    <th class="tabla_texto"> Apellido </th>
                    <th class="tabla_texto"> Teléfono </th>
                    <th class="tabla_texto"> Email </th>
                    <th class="tabla_texto"> Dirección </th>
                    <th class="tabla_texto"> Tipo de Usuario </th>
					';


	if($user_list){
		$tabla.='
						<th colspan="2">Opciones</th>
					</tr>
				</thead>
				<tbody>
		';
	}

	if($historial_usuarios){
		$tabla.='
						<th colspan="1">Opciones</th>
					</tr>
				</thead>
				<tbody>
		';
	}

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;

		foreach($datos as $rows){

			if($rows['direccion']  == NULL){
				$rows['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
			}

			if($rows['email']  == NULL){
				$rows['email'] = "<i><u> [Email no ingresado] </u></i>";
			}

			if($rows['usuarios_tipos_id'] == 1){
				$rows['usuarios_tipos_id'] = "Administrador";

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
					<td>'.$ci.'</td>
                    <td>'.$nombre.'</td>
                    <td>'.$apellido.'</td>
                    <td>'."0".$telefono.'</td>
                    <td>'.$email.'</td>
                    <td>'.$direccion.'</td>
                    <td>'.$usuarios_tipos_id.'</td>';

			if($user_list){
				$tabla.='
						<td>
							<a href="index.php?vista=user_update&user_ci_up='.$rows['ci'].'" class="button is-success is-rounded is-small"> Actualizar </a>
						</td>
						<td>
							<a href="'.$url.$pagina.'&user_ci_del='.$rows['ci'].'" class="button is-danger is-rounded is-small"> Archivar </a>
						</td>
					</tr>
				';
			}
			if($historial_usuarios){
				$tabla.='
						<td>
							<a href="'.$url.$pagina.'&user_ci='.$rows['ci'].'" class="button is-success is-rounded is-small"> Dar de Alta </a>
						</td>
					</tr>
				';
			}
			$contador++;
		}
		$pag_final=$contador-1;
		 
	}else{
		$colspan = 8;
			

		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="'.$colspan.'">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="'.$colspan.'">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando usuarios del <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;
	echo "<br>";

	if($total>=0 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}

	echo "<br><br>";

?>