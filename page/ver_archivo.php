<div class="container is-fluid">
	<h1 class="title"> Materiales</h1>
	<h2 class="subtitle"> Actualizar Archivo Subido </h2>
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

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img src="./img/repositorios.png">
			</figure>
			<?php } ?>
		</div>
		<div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="./php/repositorios_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<h4 class="title is-4 mb-4"><?php echo $datos['tema']; ?></h4>
				
				<label> Foto o imagen a actualizar </label><br>

				<input type="hidden" name="img_up_id" value="<?php echo $id_completo; ?>">

				<div class="file has-name is-horizontal is-justify-content-center mb-6">
				  	<label class="file-label mt-5 ml-6">
				    	<input class="file-input" type="file" name="repositorios_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 10MB)</span>
				  	</label>
					<div class="column is-centered">
						<div>
							<label> &nbsp; Tipo de Archivo <b class="asterisco">*</b></label><br>
								
							<div class="select is-rounded">
								<select name="formulario_tipo_archivo" onchange="mostrarInformacion(this)">
									<option> <p class="option"> Imágenes </p> </option>
									<option> <p class="option"> Textos </p> </option>
									<option> <p class="option"> Audios </p> </option>
									<option> <p class="option"> Videos </p> </option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar</button>
				</p>
			</form>
		</div>
	</div>
	<?php 
		}else{
			echo "<script> window.location.href='index.php?vista=home'; </script>";
		}
		$check_repositorios=null;
	?>
</div>