<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./css/estilos.css">
  <link rel="stylesheet" href="./css/cuenta.css">

</head>
<body>

  <nav class="navbar is-info mb-5" role="navigation" aria-label="dropdown navigation">
    <div class="navbar-brand">

      <a role="button" class="navbar-item is-fixed" href="index.php?vista=logout">
        <img src="./img/logo.jpg" width="40px" height="100%">
      </a>

      <a role="button" class="navbar-item is-fixed" href="https://www.utu.edu.uy/node/1512">
        <img src="./img/logo_utu.jpg" width="40px" height="100%">
      </a>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>


    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

          <div class="navbar-start">
              <a href="index.php?vista=home" class="navbar-item"> Home </a>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link"> Usuarios </a>

              <div class="navbar-dropdown">
                  

                  <?php
                    require_once "./php/main.php";
                    $consulta_datos="SELECT ci, usuarios_tipos_id FROM usuarios WHERE ci='".$_SESSION['ci']."'"."ORDER BY nombre";
                        $conexion=conexion();
                        $datos_usuario = $conexion->query($consulta_datos);
                        $datos_usuario = $datos_usuario->fetchAll();

                        foreach($datos_usuario as $rows){
                            $rows['ci'];
                            $rows['usuarios_tipos_id'];
                            $usuario = $rows['usuarios_tipos_id'];
                        }

                        if($usuario != ""){
                          if($usuario == 1 || $usuario == 2)
                            echo '<a href="index.php?vista=user_new" class="navbar-item menu"> Nuevo </a>';
                        }
                  ?>

                  <a href="index.php?vista=user_list" class="navbar-item is-hoverable menu"> Lista </a>                    
                  <a href="index.php?vista=user_search&buscar=false" class="navbar-item menu">Buscar</a>
              </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link"> Materiales </a>

              <div class="navbar-dropdown">
                  <?php
                    if($usuario != ""){
                      if($usuario == 2)
                        echo '<a href="index.php?vista=multimedia" class="navbar-item menu"> Agregar Multimedia </a>';
                    }
                  ?>
                  <a href="index.php?vista=multimedia_subida" class="navbar-item menu"> Multimedia Subida </a>
                  <a href="index.php?vista=horarios_tutorias" class="navbar-item menu"> Horarios de Tutoría </a>
              </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link"> Contactos </a>

              <div class="navbar-dropdown">

                  <a href="tel:43522280" class="navbar-item is-flex justify-content-center">

                    <img src="./img/telefono.jpg" width="20" height="20"> <span style="margin-left: 10px"> </span>
                    <p class="is-flex justify-content-center menu"> Teléfono </p> </a>


                  <a href="https://www.facebook.com/profile.php?id=100081470277547" class="navbar-item is-flex justify-content-center">
                    <img src="./img/facebook.jpg" width="20" height="20"> <span style="margin-left: 10px;"> </span>
                    <p class="is-flex justify-content-center menu"> Facebook </p> </a>


                  <a href="mailto:comunicados.utu@gmail.com" class="navbar-item is-flex justify-content-center">
                    <img src="./img/gmail.jpg" width="20" height="20"> <span style="margin-left: 10px"> </span>
                    <p class="is-flex justify-content-center menu"> Gmail </p> </a>

            </div>
        </div>
      </div>

      <div class="navbar-end">
        <div class="navbar-item has-dropdown">

          <div class="navbar-brand">
            <a role="button" class="navbar-item is-fixed" href="index.php?vista=mi_cuenta">
              <img src="./img/perfil_redondo.jpg" width="40px" height="100%">
            </a>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a href="index.php?vista=mi_cuenta" class="button is-light is-rounded boton_mi_cuenta"> Mi Cuenta </a>

            <div class="navbar-dropdown is-right">
              <a href="index.php?vista=mi_cuenta" class="navbar-item menu"> Perfil <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?> </a>

              <hr class="navbar-divider">
              <a href="index.php?vista=logout" class="navbar-item menu"> Cerrar Sesión </a>
            </div>
              
          </div>  
        </div>
      </div>

  </nav>

</body>
</html>