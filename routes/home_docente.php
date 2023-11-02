<nav class="panel">
    

    <p class="panel-heading dark">
        Docente
    </p>
    <div class="panel-block">
        <p class="control has-icons-left">
        <input class="input" type="text" placeholder="Buscar opciones">
        <span class="icon is-left">
            <i class="fas fa-search" aria-hidden="true"></i>
        </span>
        </p>
    </div>
    <p class="panel-tabs">
        <a data-toggle="tutorias" class="puntos_suspensivos"> Tutoría </a>
        <a data-toggle="estudiantes" class="puntos_suspensivos"> Estudiantes </a>
        <a data-toggle="opciones" class="puntos_suspensivos"> Otros </a>
    </p>


    <div class="panel-block hidden-opciones" data-option="tutorias">

        <a href="index.php?vista=tutorship_new" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Crear tutoría
        </a>

        <a href="index.php?vista=tutorship_list" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Mostrar lista de tutorías
        </a>

        <a href="index.php?vista=agregar_estudiante" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Agregar Estudiantes a Tutoría
        </a>

    </div>
    
    <div class="panel-block hidden-opciones" data-option="estudiantes">

        <a href="index.php?vista=user_search&buscar=false" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Buscar Estudiantes
        </a>
        <a href="index.php?vista=attendance&buscar=false" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Pasar Asistencia
        </a>
        <a href="index.php?vista=consult_attendance" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Consultar Asistencia
        </a>

    </div>

    <div class="panel-block hidden-opciones" data-option="opciones">
        
        <a href="index.php?vista=multimedia" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Subir Nueva Multimedia
        </a>

        <a href="index.php?vista=multimedia_subida" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Multimedia Subida
        </a>

    </div>

    <div class="panel-block">
        <button class="button is-success is-outlined is-fullwidth" id="recargar">
        Recargar Busqueda
        </button>
    </div>
</nav>

<script src="./js/menu_usuarios.js"></script>