<?php
	
	# Conexion a la base de datos #
	function conexion(){
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=tutorias', 'root', '', array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_spanish2_ci",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			));
			return $pdo;
		} catch (PDOException $e) {
			echo 'Error al conectarse a la base de datos: ' . $e->getMessage();
			die();
		}
	}
	
	
	# Verificar datos #
	function verificar_datos($filtro, $cadena){
		if(preg_match("/^".$filtro."$/", $cadena)){
			return false;
		} else {
			return true;
		}
	}
	

	# Limpiar cadenas de texto #
	function limpiar_cadena($cadena){
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		$cadena=str_ireplace("<script>", "", $cadena);
		$cadena=str_ireplace("</script>", "", $cadena);
		$cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena);
		$cadena=str_ireplace("SELECT * FROM", "", $cadena);
		$cadena=str_ireplace("DELETE FROM", "", $cadena);
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena);
		$cadena=str_ireplace("DROP DATABASE", "", $cadena);
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena);
		$cadena=str_ireplace("?>", "", $cadena);
		$cadena=str_ireplace("--", "", $cadena);
		$cadena=str_ireplace("^", "", $cadena);
		$cadena=str_ireplace("<", "", $cadena);
		$cadena=str_ireplace("[", "", $cadena);
		$cadena=str_ireplace("]", "", $cadena);
		$cadena=str_ireplace("==", "", $cadena);
		$cadena=str_ireplace(";", "", $cadena);
		$cadena=str_ireplace("::", "", $cadena);
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		return $cadena;
	}

	# Funcion renombrar archivos #
	function renombrar_archivos($nombre){
		$nombre=str_ireplace(" ", "_", $nombre);
		$nombre=str_ireplace("/", "_", $nombre);
		$nombre=str_ireplace("#", "_", $nombre);
		$nombre=str_ireplace("-", "_", $nombre);
		$nombre=str_ireplace("$", "_", $nombre);
		$nombre=str_ireplace(".", "_", $nombre);
		$nombre=str_ireplace(",", "_", $nombre);
		return $nombre;
		
		#$nombre=$nombre."_".rand(0,100);#
	}

	# Funcion paginador de tablas #
	function paginador_tablas($pagina,$Npaginas,$url,$botones){
		$tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		if($pagina<=1){
			$tabla.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a>
			<ul class="pagination-list">';
		}else{
			$tabla.='
			<a class="pagination-previous" href="'.$url.($pagina-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}

		$ci=0;
		for($i=$pagina; $i<=$Npaginas; $i++){
			if($ci>=$botones){
				break;
			}
			if($pagina==$i){
				$tabla.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$tabla.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}

		if($pagina==$Npaginas){
			$tabla.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Siguiente</a>
			';
		}else{
			$tabla.='
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($pagina+1).'" >Siguiente</a>
			';
		}

		$tabla.='</nav>';
		return $tabla;
	}

	function formatear_cedula($ci) {
		$ci = preg_replace("/[^0-9]/", "", $ci);
	
		if (strlen($ci) == 7) {
			return substr($ci, 0, 3) . '.' . substr($ci, 3, 3) . '-' . substr($ci, 6, 1);
		} elseif (strlen($ci) == 8) {
			return substr($ci, 0, 1) . '.' . substr($ci, 1, 3) . '.' . substr($ci, 4, 3) . '-' . substr($ci, 7, 1);
		} elseif (strlen($ci) == 9) {
			return substr($ci, 0, 2) . '.' . substr($ci, 2, 3) . '.' . substr($ci, 5, 3) . '-' . substr($ci, 8, 1);
		}
	
		return $ci;
	}

	function formatear_telefono($telefono) {
		$telefono = preg_replace("/[^0-9]/", "", $telefono);
	
		if (substr($telefono, 0, 1) == "9") {
			return "0" . substr($telefono, 0, 2) . '.' . substr($telefono, 2, 3) . '.' . substr($telefono, 5, 3);
		}else{
			return substr($telefono, 0, 4) . '.' . substr($telefono, 4, 4);
		}
		return $telefono;
	}	

?>