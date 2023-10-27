<section class="section seccion">
    <div class="columns">

        <div class="column is-three-fifths">
            <div class="is-bordered has-background-light is-fullwidth pt-6 pr-6 pb-6 pl-6">
                <div class="container is-fluid mb-6">
                    <h1 class="title"> Multimedia </h1>
                    <h2 class="subtitle"> Nuevo Archivo </h2>
                </div>

                <div class="container pt-2">    
                    <form action="./php/multimedia_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <label> Tema (Nombre del Archivo) <b class="asterisco">*</b> </label>
                                    <input class="input" type="text" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-° ]{1,50}" required>
                                </div>
                            </div>                            
                            <div class="column is-centered">
                                <label> <p class="has-text-centered"> Tutoría <b class="asterisco">*</b> </p> </label>

                                <div class="select is-rounded is-fullwidth">
                                    <select name="tutorias_datos" class="container">
                                        <option value="" selected="" class="has-text-centered"> Seleccionar Tutoría </option>
                                        <?php
                                            require_once "./php/main.php";
                                            
                                            if($_SESSION['usuarios_tipos_id'] == 2){
                                                $consulta_docente=conexion();
                                                $consulta_docente=$consulta_docente->query("SELECT tutorias.id AS id, tutorias.docente_ci AS docente_ci, tutorias.grupo AS grupo, tutorias.dias AS dias FROM tutorias INNER JOIN usuarios ON tutorias.docente_ci = usuarios.ci WHERE tutorias.docente_ci = '".$_SESSION['ci']."'");

                                                if($consulta_docente->rowCount()>0){
                                                    $consulta_docente=$consulta_docente->fetchAll();
                                                    foreach($consulta_docente as $row){
                                                        echo '<option class="has-text-centered" value="'.$row['id'].'|'.$row['docente_ci'].'"> Grupo: '.$row['grupo'].' --> Dias: '.$row['dias'].'</option>';
                                                    }
                                                }
                                            $consulta_docente=null;

                                            }
                                            
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <label> Fecha de Visualización <b class="asterisco">*</b></label>
                                    <input class="input" type="date" name="fecha_visualizacion" pattern="\d{4}-\d{2}-\d{2}" required>
                                </div>
                            </div>
                            <div class="column">
                                <div class="control">
                                    <label> Hora de Visualización </label>
                                    <input class="input" type="time" name="hora_visualizacion" pattern="\d{2}:\d{2}" required>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <label> Fecha de Eliminación <b class="asterisco">*</b></label>
                                    <input class="input" type="date" name="fecha_eliminacion" pattern="\d{4}-\d{2}-\d{2}" required>
                                </div>
                            </div>
                            <div class="column">
                                <div class="control">
                                    <label> Hora de Eliminación </label>
                                    <input class="input" type="time" name="hora_eliminacion" pattern="\d{2}:\d{2}" required>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <label> Subir Multimedia </label><br>
                                <div class="file is-small has-name">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="formulario_archivo" accept="">
                                        <span class="file-cta">
                                            <span class="file-label" id="tipoSeleccionado"> Imágenes </span>
                                        </span>
                                        <span class="file-name" id="tipoArchivo"> JPG, GIF, PNG (MAX 10MB) </span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="column is-flex is-justify-content-flex-end">
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
                            <button type="submit" class="button is-primary is-rounded mt-3 mb-2"> Subir Archivo </button>
                        </p>
                    
                </div>
            </div>
        </div>

        <div class="column is-two-fifths">
            <div class="contenedor_comentarios">
                <div class="comentarios">
                    <div class="comentarios_titulo">
                        <h1 class="title"> Comentarios </h1>
                    </div>
                        
                    <div class="comentarios_texto">
                        <div class="control">
                            <div id="editor-container">
                                <div id="editor"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="quill_content" id="quillContent" />
                </div>
            
                
                <div class="botones">
                    <div class="is-flex">
                        <div class="is-flex is-flex-direction-row botones_fijos">
                            <a href="index.php?vista=eliminar_archivo" class="button is-link eliminar">Eliminar</a>
                            <a href="index.php?vista=home" class="button is-dark is-rounded">Salir</a>
                        </div>
                    </div>
                    <div class="form-rest mt-6"></div>
                </div>
            </div>
        </div>

        </form>
    </div>
   
</section>