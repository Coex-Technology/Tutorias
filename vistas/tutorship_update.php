<?php
	require_once "./php/main.php";

    $id = (isset($_GET['user_ci_up'])) ? $_GET['user_ci_up'] : 0;
    $id = limpiar_cadena($ci);
?>


<div class="container pb-6 pt-6">
	<?php

		include "./inc/btn_back.php";

        /*Verificando usuario*/
    	$check_usuario=conexion();
    	$check_usuario=$check_usuario->query("SELECT * FROM tutorias WHERE id='$id'");

        if($check_usuario->rowCount()>0){
        	$datos=$check_usuario->fetch();
	?>

		<div class="form-rest mb-6 mt-6"></div>

		<form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

			<input type="hidden" name="ci" value="<?php echo $datos['ci']?>" required >

			<section class="ml-6 mr-6">
				<section>
					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Nombre </label>
								<input class="input" type="text" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['nombre']?>">
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> Apellido </label>
								<input class="input" type="text" name="apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['apellido']?>">
							</div>
						</div>
					</div>

					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Dirección </label>
								<input class="input" type="text" name="direccion" pattern="[a-zA-Z0-9]{3,20}" maxlength="20" value="<?php echo $datos['direccion']?>" required >
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> E-mail </label>
								<input class="input" type="email" name="email" maxlength="70" value="<?php echo $datos['email']?>">
							</div>
						</div>
					</div>
				</section>

				<section>
					<p class="separacion_user_update">
					Para actualizar la contraseña de este usuario complete ambos campos. En caso de no querer hacerlo, deje los campos vacíos.
					</p>

					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Contraseña </label>
								<input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> Confirmar contraseña </label>
								<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
							</div>
						</div>
					</div>
				</section>

				<section>
					<p class="separacion_user_update">
						Para actualizar los datos de este usuario por favor ingrese su Usuario y Contraseña.
					</p>

					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Usuario </label>
								<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> Contraseña </label>
								<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
							</div>
						</div>
					</div>
					<p class="has-text-centered">
						<button type="submit" class="button is-success is-rounded">Actualizar</button>
					</p>
				</section>
			</section>

		</form>

		<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_usuario=null;
		?>
	</div>

</body>
</html>