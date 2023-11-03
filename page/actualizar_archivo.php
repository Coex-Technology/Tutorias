<div class="container is-fluid mb-4">
	<h1 class="title"> Materiales</h1>
	<h2 class="subtitle"> Actualizar multimedia </h2>
</div>

<div class="container">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$tutorias_id = $_GET['id'];
		$id_archivo = $_GET['archivo'];

		/*== Verificando repositorios ==*/
    	$check_repositorios=conexion();
    	$check_repositorios=$check_repositorios->query("SELECT * FROM repositorios
		WHERE tutorias_id='$tutorias_id' AND id_archivo='$id_archivo'");

        if($check_repositorios->rowCount()>0){
        	$datos=$check_repositorios->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>
	
	<h2 class="title has-text-centered"><?php echo $datos['tema']; ?></h2>

	<form action="./php/repositorios_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="repositorios_id" value="<?php echo $datos['id_archivo'] ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label> Tema </label>
				  	<input class="input" type="text" name="tema" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $datos['tema']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label> Ocultar </label>
				  	<input class="input" type="text" name="repositorios_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['repositorios_nombre']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código de barra</label>
				  	<input class="input" type="text" name="tema" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $datos['tema']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="repositorios_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['repositorios_nombre']; ?>" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_repositorios=null;
	?>
</div>