<section class="section">
    <div class="columns">

        <div class="column is-three-fifths caja_gris">
            <div class="is-bordered has-background-light is-fullwidth pt-6 pr-6 pb-6 pl-6">
                <div class="container is-fluid">
                    <h1 class="title"> Multimedia </h1>
                    <h2 class="subtitle"> Materiales subidos </h2>
                </div>

                <div class="container">
                    <?php
                        require_once "./php/main.php";
                        include "./vistas/tutorship_list.php";
                    ?>

                    <div class="form-rest mb-6 mt-6"></div>

                    <form action="./upload/multimedia_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <label> Nombre <b class="asterisco">*</b></label>
                                    <input class="input" type="text" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-° ]{1,50}" maxlength="70" required >
                                </div>
                            </div>
                            <div class="column">
                                <div class="control">
                                    <label> Seleccionar Tutoría <b class="asterisco">*</b></label>
                                    <input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,20}" maxlength="70" required >
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <label>Fecha de Visualización <b class="asterisco">*</b></label>
                                    <input class="input" type="date" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required >
                                </div>
                            </div>
                            <div class="column">
                                <div class="control">
                                    <label>Hora de Visualización</label>
                                    <input class="input" type="date" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required >
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <label>Fecha de Eliminación <b class="asterisco">*</b></label>
                                    <input class="input" type="time" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required >
                                </div>
                            </div>
                            <div class="column">
                                <div class="control">
                                    <label>Hora de Eliminación</label>
                                    <input class="input" type="time" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required >
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <label>Subir Multimedia</label><br>
                                <div class="file is-small has-name">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg">
                                        <span class="file-cta">
                                            <span class="file-label" id="tipoSeleccionado"> Imágen </span>
                                        </span>
                                        <span class="file-name" id="tipoArchivo">JPG, JPEG, PNG (MAX 10MB)</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="column">
                                <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tipo de Tutoría <b class="asterisco">*</b> </label> <br>

                                <div class="select is-rounded">
                                    <select name="tutorias_tipos_id" >
                                        <option value="" selected="" class="has-text-centered">Seleccione una opción</option>
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
                        <p class="has-text-centered">
                            <button type="submit" class="button is-primary is-rounded mt-3"> Subir Archivo </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div class="column is-two-fifths">
            <div class="comentarios">
                <div class="comentarios_titulo">
                    <h1 class="title"> Comentarios </h1>
                </div>
                    
                <div class="estudiantes_texto">
                    <div class="control">
                        <div id="editor-container">
                            <div id="editor"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>