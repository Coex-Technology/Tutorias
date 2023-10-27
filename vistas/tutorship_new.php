<div class="container is-fluid mb-6">
    <h1 class="title"> Tutorías </h1>
    <h2 class="subtitle"> Nueva Tutoría </h2>

    <script src="./js/ajax.js"></script>
    <script src="./js/nueva_tutoria.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</div>

    <form action="./php/tutoria_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">

        <div class="borde_registro">

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label> Grupo <b class="asterisco">*</b> </label>
                        <input class="input" type="text" name="grupo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-°* ]{3,50}" maxlength="50" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Descripción </label>
                        <input class="input" type="text" name="descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚ0-9$@.-* ]{0,1000}" maxlength="1000">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label> Fecha de Inicio <b class="asterisco">*</b> </label>
                        <input class="input" type="date" name="fecha_inicial" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Fecha de Finalización <b class="asterisco">*</b> </label>
                        <input class="input" type="date" name="fecha_final" required>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label> Horario de Inicio <b class="asterisco">*</b> </label>
                        <input class="input" type="time" name="hora_inicial" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label> Horario de Finalización <b class="asterisco">*</b> </label>
                        <input class="input" type="time" name="hora_final" required>
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

            <div class="container is-relative contenedor_alerta">

                <div class="columns is-flex-touch">
                    <div class="column is-half-desktop">
                        <div class="container form-rest mensaje_alerta is-danger pt-5 pr-5 pb-5 pl-5">
                        </div>
                    </div>

                    <div class="column is-half-desktop">
                        <div class="notificacion">
                            <div id="mensaje" class="container notification is-absolute is-success is-hidden is-fixed register_confirmacion"></div>
                        </div>
                    </div>

                    <div class="column is-full-desktop">
                        <div class="section register_guardar">
                            <div class="has-text-centered tutoria_guardar">
                                <button class="container button is-link is-rounded pt-5 pr-5 pb-5 pl-5">
                                    <p class="guardar"> Guardar </p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>              

            </div>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".FormularioAjax");
        const submitButton = form.querySelector("button[type='submit']");

        form.addEventListener("submit", function(event) {
            submitButton.disabled = true;
        });
        });
    </script>

</div>
