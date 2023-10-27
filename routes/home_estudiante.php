<nav class="panel is-success hidden">
    

    <p class="panel-heading">
        Estudiante
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
        <a data-toggle="tutorias" class="puntos_suspensivos mr-4"> Tutorías </a>
        <a data-toggle="estudiantes" class="puntos_suspensivos mr-4"> Estudiantes </a>
        <a data-toggle="docente" class="puntos_suspensivos"> Docente </a>
    </p>


    <div class="panel-block hidden-opciones" data-option="tutorias">

        <a href="index.php?vista=chat_administrador" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Solicitar Nueva Tutoría
        </a>
        <a href="index.php?vista=tutorship_list" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Mostrar lista completa de tutorías
        </a>

    </div>
    
    <div class="panel-block hidden-opciones" data-option="estudiantes">

        <a href="index.php?vista=user_list" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Lista de Estudiantes
        </a>
        <a href="index.php?vista=consult_attendance" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Consultar mi Asistencia
        </a>

    </div>
    <div class="panel-block hidden-opciones" data-option="docente">

        <a href="index.php?vista=chat_docente" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Enviar Mensaje al Docente
        </a>

        <a href="index.php?vista=multimedia_subida" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Multimedia
        </a>
    </div>

    <div class="panel-block">
        <button class="button is-link is-outlined is-fullwidth puntos_suspensivos" id="recargar">
        Recargar Busqueda
        </button>
    </div>
</nav>

<script src="./js/menu_usuarios.js"></script>