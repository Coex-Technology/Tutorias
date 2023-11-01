<?php
	require_once "./php/main.php";

    $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    $id = limpiar_cadena($id);
?>

<div class="container is-fluid mb-6">
    <h1 class="title"> Tutorías </h1>
    <h2 class="subtitle"> Actualizar Tutoría </h2>

    <script src="./js/ajax.js"></script>
    <script src="./js/nueva_tutoria.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</div>


<div class="container pb-6">
	<?php

        /*Verificando usuario*/
    	$check_usuario=conexion();
    	$check_usuario=$check_usuario->query("SELECT * FROM tutorias WHERE id='$id'");

        if($check_usuario->rowCount()>0){
        	$datos=$check_usuario->fetch();
	?>

		<div class="form-rest mb-6 mt-6"></div>

		<form action="./php/tutoria_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

			<input type="hidden" name="id" value="<?php echo $datos['id']?>" required >

			<section class="ml-6 mr-6">
				<section>
					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Grupo </label>
								<input class="input" type="text" name="grupo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-°* ]{3,50}" maxlength="50" required value="<?php echo $datos['grupo']?>">
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> Descripcion </label>
								<input class="input" type="text" name="descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚ0-9$@.-* ]{0,1000}" maxlength="1000" value="<?php echo $datos['descripcion']?>">
							</div>
						</div>
					</div>

					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Fecha de Incio </label>
								<input class="input" type="date" name="fecha_inicial" required value="<?php echo $datos['fecha_inicial']?>">
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> Fecha de Finalización </label>
								<input class="input" type="date" name="fecha_final" required value="<?php echo $datos['fecha_final']?>">
							</div>
						</div>
					</div>

					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Horario de Incio </label>
								<input class="input" type="time" name="hora_inicial" required value="<?php echo $datos['hora_inicial']?>">
							</div>
						</div>
						<div class="column">
							<div class="control">
								<label> Horario de Finalización </label>
								<input class="input" type="time" name="hora_final" required value="<?php echo $datos['hora_final']?>">
							</div>
						</div>
					</div>

					<div class="columns">
						<div class="column">
							<div class="control">
								<label> Seleccione el Primer día de Tutoría <b class="asterisco">*</b> </label>
								<input class="input" type="date" name="dias" required>
							</div>
						</div>
						<div class="column is-flex is-justify-content-center">
							<div class="columns">
								<div class="column is-centered">
									<label> <p class="has-text-centered"> Administrador <b class="asterisco">*</b> </p> </label>

									<div class="select is-rounded is-fullwidth">
										<select name="administrador_ci">
											<option value="" selected="" class="has-text-centered"> Seleccionar </option>
											<?php
												require_once "./php/main.php";
												$conexion=conexion();
												$conexion=$conexion->query("SELECT ci, nombre, apellido, usuarios_tipos_id FROM usuarios WHERE usuarios_tipos_id=1");
												if($conexion->rowCount()>0){
													$conexion=$conexion->fetchAll();
													foreach($conexion as $row){
														echo '<option style="padding-left: 0px" class="has-text-centered" value="'.$row['ci'].'"> (CI: '.$row['ci'].") - ".$row['nombre']." ".$row['apellido'].'</option>';
													}
												}
												$conexion=null;
											?>
										</select>
									</div>
								</div>

								<div class="column is-centered">
									<label> <p class="has-text-centered"> Docente <b class="asterisco">*</b> </p> </label>

									<div class="select is-rounded is-fullwidth">
										<select name="docente_ci">
											<option value="" selected="" class="has-text-centered"> Seleccionar </option>
											<?php
												require_once "./php/main.php";
												$conexion=conexion();
												$conexion=$conexion->query("SELECT ci, nombre, apellido, usuarios_tipos_id FROM usuarios WHERE usuarios_tipos_id=2");
												if($conexion->rowCount()>0){
													$conexion=$conexion->fetchAll();
													foreach($conexion as $row){
														echo '<option style="padding-left: 0px" class="has-text-centered" value="'.$row['ci'].'"> (CI: '.$row['ci'].") - ".$row['nombre']." ".$row['apellido'].'</option>';
													}
												}
												$conexion=null;
											?>
										</select>
									</div>
								</div>
								
								<div class="column is-centered">
									<label> <p class="has-text-centered"> Tipo de Tutoría <b class="asterisco">*</b> </p> </label>

									<div class="select is-rounded is-fullwidth">
										<select name="tutorias_tipos_id" >
											<option value="" selected="" class="has-text-centered"> Seleccionar </option>
											<?php
												require_once "./php/main.php";
												$conexion=conexion();
												$conexion=$conexion->query("SELECT id, nombre_tipo FROM tutorias_tipos");
												if($conexion->rowCount()>0){
													$conexion=$conexion->fetchAll();
													foreach($conexion as $row){
														echo '<option class="has-text-centered" value="'.$row['id'].'" >'.$row['nombre_tipo'].'</option>';
													}
												}
												$conexion=null;
											?>
										</select>
									</div>
								</div>                    
							</div>                    
						</div>
					</div>             
				</section>

				<section>
					<p class="separacion_user_update">
						Para actualizar los datos de esta tutoría por favor ingrese su Usuario y Contraseña.
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