<div class="main-container has-background-light login_fondo">

	<form class="box login estilos_formulario_login" action="" method="POST" autocomplete="off">
		<div class="mt-3 mb-6">
			<h5 class="title is-5 has-text-centered"> TUTORÍAS UTU FLORIDA </h5>
		</div>

		<div class="field mb-5 ml-2 mr-2">
			<label class="label"> Documento </label>
			<div class="control">
				<input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
			</div>
		</div>

		<div class="field mb-6 ml-2 mr-2">
			<label class="label"> Contraseña </label>
			<div class="control">
				<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
			</div>
		</div>

		<p class="has-text-centered mb-3">
			<a href="index.php?vista=register" class="button is-primary is-rounded mr-6"> Registrarse </a>
			<button type="submit" class="button is-info is-rounded ml-5"> Iniciar sesion </button>
		</p>

		<?php
			if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
				require_once "./php/main.php";
				require_once "./php/iniciar_sesion.php";
			}
		?>
	</form>
	
</div>