<?php

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

	# Almacenando datos #
    $user_ci_del=limpiar_cadena($_GET['user_ci_del']);
	$tabla1 = "";

    # Verificando usuario #
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE ci='$user_ci_del'");
	$usuarios_datos = $check_usuario->fetchAll(PDO::FETCH_ASSOC);

    
    if($check_usuario->rowCount()==1){

		# Verificando asistencias #
		$check_asistencias=conexion();
		$check_asistencias=$check_asistencias->query("SELECT * FROM asistencias WHERE usuarios_ci='$user_ci_del'");

		# Verificando contactos #
		$check_contactos=conexion();
		$check_contactos=$check_contactos->query("SELECT * FROM contactos WHERE ci='$user_ci_del'");

		# Verificando tutorias #
		$check_tutorias=conexion();
		$check_tutorias=$check_tutorias->query("SELECT * FROM tutorias WHERE docente_ci='$user_ci_del'");
		$tutorias_datos = $check_tutorias->fetchAll(PDO::FETCH_ASSOC);

		# Verificando tutorias (docente) #
		$check_tutorias_docente=conexion();
		$check_tutorias_docente=$check_tutorias_docente->query("SELECT usuarios.*, tutorias.* FROM usuarios, tutorias WHERE tutorias.docente_ci = usuarios.ci AND docente_ci = '$user_ci_del'");
		$tutorias_docente_datos = $check_tutorias_docente->fetchAll(PDO::FETCH_ASSOC);

		# Verificando tutorias_usuarios #
		$check_tutorias_usuarios=conexion();
		$check_tutorias_usuarios=$check_tutorias_usuarios->query("SELECT * FROM tutorias_estudiantes WHERE estudiantes_ci='$user_ci_del'");
		$tutorias_usuarios_datos = $check_tutorias_usuarios->fetchAll(PDO::FETCH_ASSOC);


		if (isset($user_ci_del) && $user_ci_del !== "") {
			$archivar_usuario=conexion();
			$archivar_usuario=$archivar_usuario->prepare("UPDATE usuarios SET activo = 'No Activo' WHERE ci = :ci;
			");

			$archivar_usuario->execute([":ci"=>$user_ci_del]);
		}

		if($archivar_usuario->rowCount()==1){
			echo '
				<div class="has-text-centered notification is-info is-light">
					<strong>¡USUARIO ARCHIVADO!</strong><br>
					El usuario se archivo con exito <br>
					<a href="index.php?vista=historial_usuarios"> Si desea deshacer esta acción acceda a esta página </a>
				</div>
			';
		}else{
			echo '
				<div class="has-text-centered notification is-light">
					<strong>¡USUARIO ARCHIVADO!</strong><br>
					El usuario se archivo con exito <br>
					Si desea deshacer esta acción acceda al <a href="index.php?vista=historial_usuarios"> historial </a>
				</div>
			';
		}


		if ($check_asistencias->rowCount() > 0 || $check_contactos->rowCount() > 0 || $check_tutorias->rowCount() > 0 || $check_tutorias_usuarios->rowCount() > 0) {

			foreach($usuarios_datos as $rows_usuario){
				if($rows_usuario['usuarios_tipos_id'] === 1){
					$usuarios_tipos_id = "Administrador";

				}elseif($rows_usuario['usuarios_tipos_id'] === 2){
					$usuarios_tipos_id = "Docente";
					
				}elseif($rows_usuario['usuarios_tipos_id'] === 3){
					$usuarios_tipos_id = "Estudiante";
					
				}else{
					$usuarios_tipos_id = "Rol no definido";
				}
				$nombre_usuario = $rows_usuario['nombre'];
				$apellido_usuario = $rows_usuario['apellido'];
			}
		}

		if ($check_contactos->rowCount() > 0) {


			// ------------------------------- # Crear Tabla 1 (Datos del Usuario) # -------------------------------
			$tabla1.='
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

			$tabla2 = $tabla1;
			$tabla3 = $tabla1;
			
			$tabla1.='			
			<div class="table-container mt-6">
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr class="has-text-centered is-vcentered tabla_encabezado">
							<th colspan="6"> <p class="tabla_titulo"> Datos del Usuario - [ '.$usuarios_tipos_id.' ] </p> </th>
						</tr>
						<tr class="has-text-centered">
							<th class="tabla_texto"> Cedula de Identidad </th>
							<th class="tabla_texto"> Nombre </th>
							<th class="tabla_texto"> Apellido </th>
							<th class="tabla_texto"> Teléfono </th>
							<th class="tabla_texto"> Email </th>
							<th class="tabla_texto"> Dirección </th>
						</tr>
					</thead>
					<tbody>
			';
		
			foreach($usuarios_datos as $rows_usuario){
				foreach($check_contactos as $rows_contactos){
				
					if($rows_usuario['direccion']  === NULL){
						$rows_usuario['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
					}
		
					if($rows_contactos['email']  === NULL){
						$rows_contactos['email'] = "<i><u> [Email no ingresado] </u></i>";
					}

					
					$tabla1.='
						<tr class="has-text-centered" >
							<td class="tabla_texto">'.$rows_usuario['ci'].'</td>
							<td class="tabla_texto">'.$rows_usuario['nombre'].'</td>
							<td class="tabla_texto">'.$rows_usuario['apellido'].'</td>
							<td class="tabla_texto">'.$telefono = $rows_contactos['telefono'].'</td>
							<td class="tabla_texto">'.$rows_contactos['email'].'</td>
							<td class="tabla_texto">'.$rows_usuario['direccion'].'</td>
						</tr>
					';
				}
			}
				 
		
			$tabla1.='</tbody></table></div>';
		
			echo $tabla1;
			echo "<br>";
		}

		if ($check_tutorias->rowCount() > 0 || $check_tutorias_usuarios->rowCount() > 0) {

			// ------------------------------- # Crear Tabla 2 (Tutorias a las que concurre) # -------------------------------

			$tabla2.='			
			<div class="table-container mt-1">
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr class="has-text-centered is-vcentered tabla_encabezado">
							<th colspan="6"> <p class="tabla_titulo"> Tutorias asociadas al '.$usuarios_tipos_id.' '.$nombre_usuario.' '.$apellido_usuario.' </p> </th>
						</tr>
						<tr class="has-text-centered">
							<th class="tabla_texto"> Tutoría </th>
							<th class="tabla_texto"> Docente </th>
							<th class="tabla_texto"> Estudiantes </th>
							<th class="tabla_texto"> Días </th>
							<th class="tabla_texto"> Horario de Inicio </th>
							<th class="tabla_texto"> Horario de Finalización </th>
						</tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
		
				foreach($tutorias_docente_datos as $rows_tutorias_docente){
		
					if($rows_usuario['direccion']  === NULL){
						$rows_usuario['direccion'] = "<i><u> [Direccion no ingresada] </u></i>";
					}
		
					if($rows_contactos['email']  === NULL){
						$rows_contactos['email'] = "<i><u> [Email no ingresado] </u></i>";
					}

					$hora_inicial = $rows_tutorias_docente['hora_inicial'];
					$hora_final = $rows_tutorias_docente['hora_final'];

					$hora_inicial = preg_replace('/^0/', '', substr($hora_inicial, 0, 5));
					$hora_final = preg_replace('/^0/', '', substr($hora_final, 0, 5));

					
					$tabla2.='
						<tr class="has-text-centered" >
							<td class="tabla_texto">'.$rows_tutorias_docente['grupo'].'</td>
							<td class="tabla_texto">'.$usuarios_tipos_id.'</td>
							<td class="tabla_texto">'.$rows_contactos['telefono'].'</td>
							<td class="tabla_texto">'.$rows_tutorias_docente['dias'].'</td>
							<td class="tabla_texto">'.$hora_inicial.'</td>
							<td class="tabla_texto">'.$hora_final.'</td>
						</tr>
					';
					$contador++;
				}

				$pag_final=$contador-1;
				 
			}else{
				if($total1>=1){
					$tabla2.='
						<tr class="has-text-centered" >
							<td colspan="7">
								<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla2.='
						<tr class="has-text-centered" >
							<td colspan="7">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}
		
			$tabla2.='</tbody></table></div>';
		
			echo $tabla2;
			echo "<br>";
		}

		if($check_asistencias->rowCount() > 0) {


			// ------------------------------- # Crear Tabla 3 (Datos de Asistencia) # -------------------------------
			$tabla3.='			
			<div class="table-container mt-3">
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr class="has-text-centered is-vcentered tabla_encabezado">
							<th colspan="6"> <p class="tabla_titulo"> Asistencia </p> </th>
						</tr>
						<tr class="has-text-centered">
							<th class="tabla_texto"> <p class="tabla_titulo"> Tutoría </p> </th>
							<th class="tabla_texto"> <p class="tabla_titulo"> Docente </p> </th>
							<th class="tabla_texto"> <p class="tabla_titulo"> Fecha </p> </th>
							<th class="tabla_texto"> <p class="tabla_titulo"> Asistencias </p> </th>
							<th class="tabla_texto"> Inasistencias Justificadas</th>
							<th class="tabla_texto"> Inasistencias Injustificadas</th>
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
						
						$tabla3.='
							<tr class="has-text-centered" >
								<td class="tabla_texto">'.$rows_tutorias_docente['tutoria'].'</td>
								<td class="tabla_texto">'.$rows_tutorias_docente['usuario'].'</td>
								<td class="tabla_texto">'.$fecha.'</td>
								<td class="tabla_texto">'.$rows_asistencias['asistencias'].'</td>
								<td class="tabla_texto">'.$rows_asistencias['inasistencias_justificadas'].'</td>
								<td class="tabla_texto">'.$rows_asistencias['inasistencias_injustificadas'].'</td>
							</tr>
						';
						$contador++;
					}
				}
				$pag_final=$contador-1;
				 
			}else{
				if($total1>=1){
					$tabla3.='
						<tr class="has-text-centered" >
							<td colspan="7">
								<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla3.='
						<tr class="has-text-centered" >
							<td colspan="7">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}
		
			$tabla3.='</tbody></table></div>';
		
			if($total>0 && $pagina<=$Npaginas){
				$tabla3.='<p class="has-text-right">Mostrando lista de asistencias del <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
			}
		
			echo $tabla3;
			echo "<br>";
		
			// if($total>=0 && $pagina<=$Npaginas){
			// 	echo paginador_tablas($pagina,$Npaginas,$url,7);
			// }
			
		}else{
			if($total>=1){
				$tabla2.='
					<tr class="has-text-centered" >
						<td colspan="7">
							<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
								Haga clic acá para recargar el listado
							</a>
						</td>
					</tr>
				';
			}else{
				$tabla2.='
					<tr class="has-text-centered" >
						<td colspan="7">
							No hay registros en el sistema
						</td>
					</tr>
				';
			}
		}
		

		$check_asistencias = null;
		$check_contactos = null;
		$check_tutorias = null;
		$check_tutorias_docente = null;
		$check_tutorias_usuarios = null;
		
	
	}else{
		echo '
			<div class="notification is-danger is-light">
				<strong>¡Ocurrio un error inesperado!</strong><br>
				El USUARIO que intenta archivar no existe
			</div>
		';

	}	

	$archivar_usuario=null;
    $check_usuario=null;
	$usuarios_datos = null;
	$tutorias_datos = null;
	$tutorias_docente_datos = null;
	$tutorias_usuarios_datos = null;
?>