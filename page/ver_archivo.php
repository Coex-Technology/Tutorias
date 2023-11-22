<div class="container is-fluid">
	<h1 class="title"> Materiales</h1>
	<h2 class="subtitle"> Visualizar Archivo Subido </h2>
</div>

<div class="container pb-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$archivo_id = (isset($_GET['archivo'])) ? $_GET['archivo'] : 0;
		$tutorias_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
		$usuarios_ci = (isset($_GET['ci'])) ? $_GET['ci'] : 0;
        $g = "_";
        $id_completo = $archivo_id.$g.$tutorias_id.$g.$usuarios_ci;


		# Verificando repositorios #
    	$check_repositorios=conexion();
    	$check_repositorios=$check_repositorios->query("SELECT * FROM repositorios WHERE id_archivo='$archivo_id' AND usuarios_ci='$usuarios_ci' AND tutorias_id = $tutorias_id AND activo = 'Activo'");

        if($check_repositorios->rowCount()>0){
        	$datos=$check_repositorios->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<div class="columns">
		<div class="column is-two-fifths">
			<?php if(is_file("./multimedia/".$datos['nombre'])){ ?>

			<figure class="image mb-6">
			  	<img src="./multimedia/<?php echo $datos['nombre']; ?>">
			</figure>
			<form class="FormularioAjax" action="./php/repositorios_img_eliminar.php" method="POST" autocomplete="off" >

				<input type="hidden" name="img_del_id" value="<?php echo $id_completo; ?>">

			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img src="./img/repositorios.png">
			</figure>
			<?php } ?>
		</div>
		<div class="column">
			<div class="mb-6 has-text-centered FormularioAjax">

				<h4 class="title is-4 mb-4"><?php echo "Tema: " . $datos['tema']; ?></h4>
				
				<label> Vista del Archivo Subido </label><br><br><br>

				<input type="hidden" name="img_up_id" value="<?php echo $id_completo; ?>">

				<p class="has-text-centered">
					<?php
						$consulta_datos = "SELECT
						repositorios.id_archivo AS archivo_id,
						repositorios.usuarios_ci AS usuarios_ci,
						repositorios.tutorias_id AS tutorias_id,
						repositorios.tema AS tema,
						repositorios.nombre AS nombre_archivo,
						repositorios.comentarios AS comentarios,
						repositorios.tipo_archivo AS tipo_archivo,
						repositorios.fecha_visualizacion AS fecha_visualizacion,
						repositorios.hora_visualizacion AS hora_visualizacion,
						repositorios.fecha_eliminacion AS fecha_eliminacion,
						repositorios.hora_eliminacion AS hora_eliminacion,
						repositorios.activo AS activo,
						usuarios.nombre AS nombre,
						usuarios.apellido AS apellido,
						usuarios.usuarios_tipos_id AS usuarios_tipos_id,
						tutorias.grupo AS grupo,
						tutorias.dias AS dias,
						tutorias.fecha_inicial AS fecha_inicial,
						tutorias.fecha_final AS fecha_final,
						tutorias.hora_inicial AS hora_inicial,
						tutorias.hora_final AS hora_final
						FROM repositorios
						JOIN usuarios ON repositorios.usuarios_ci=usuarios.ci
						JOIN tutorias ON repositorios.tutorias_id=tutorias.id
						WHERE tutorias_id = $tutorias_id AND repositorios.activo = 'Activo'";

						$conexion=conexion();
						$datos = $conexion->query($consulta_datos);
						$datos = $datos->fetchAll();

						foreach($datos as $rows){
							if($archivo_id == $rows['archivo_id']){
								$contador = 1;
								$fecha_1 = $rows['fecha_visualizacion'];
								$fecha_visualizacion = date("d/m/Y", strtotime($fecha_1));
								$fecha_2 = $rows['fecha_eliminacion'];
								$fecha_eliminacion = date("d/m/Y", strtotime($fecha_2));
			
								$hora_1 = $rows['hora_visualizacion'];
								$hora_visualizacion = date("H:i", strtotime($hora_1));
								$hora_2 = $rows['hora_eliminacion'];
								$hora_eliminacion = date("H:i", strtotime($hora_2));

								echo '<p>
									<strong>Publicado por '.$rows['nombre'].' '.$rows['apellido'].'</strong><br>
									<strong>Se subio el:</strong> '.$fecha_visualizacion.' al las '.$hora_visualizacion.'<br>
									<strong>Se Elimina el:</strong> '.$fecha_eliminacion.' al las '.$hora_eliminacion.'<br>
								</p>';
							}
						}
					?>
				</p>
			</div>
		</div>
	</div>
	<?php 
		}else{
			echo "<script> window.location.href='index.php?vista=home'; </script>";
		}
		$check_repositorios=null;
	?>
</div>