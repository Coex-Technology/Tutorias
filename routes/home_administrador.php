<nav class="panel is-link">
    

    <p class="panel-heading">
        Administrador
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
        <a data-toggle="docente" class="puntos_suspensivos"> Docente </a>
    </p>


    <div class="panel-block hidden-opciones" data-option="tutorias">

        <a href="index.php?vista=tutorship_new" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Crear tutoría
        </a>
        <a href="index.php?vista=historial_tutorias" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Historial de Tutorias
        </a>      
        <a href="index.php?vista=tutorship_list" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Mostrar lista completa de tutorías
        </a>
        

    </div>
    
    <div class="panel-block hidden-opciones" data-option="estudiantes">

        <a href="index.php?vista=user_search&buscar=false" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Buscar Estudiantes
        </a>
        <a href="index.php?vista=historial_usuarios" class="panel-block">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Historial de Usuarios
        </a>

    </div>

    <div class="panel-block hidden-opciones" data-option="docente">
        
        <a href="index.php?vista=consult_attendance" class="panel-block is-active">
            <span class="panel-icon">
            <i class="fas fa-book" aria-hidden="true"></i>
            </span>
            Consultar Asistencia Ingresada
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