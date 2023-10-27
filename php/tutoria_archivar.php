<?php

	/*Almacenando datos*/
    $tutoria_id_delete=limpiar_cadena($_GET['tutoria_id_delete']);

    /*Verificando tutoria*/
    $check_tutoria=conexion();
    $check_tutoria=$check_tutoria->query("SELECT id FROM tutorias WHERE id='$tutoria_id_delete'");
    
    if($check_tutoria->rowCount()==1){
	
	    $eliminar_tutoria=conexion();
	    $eliminar_tutoria=$eliminar_tutoria->prepare("DELETE FROM tutorias WHERE id=:id");

	    $eliminar_tutoria->execute([":ci"=>$tutoria_id_delete]);

	    if($eliminar_tutoria->rowCount()==1){
		    echo '
		        <div class="notification is-info is-light">
		            <strong>¡TUTORÍA ELIMINADA!</strong><br>
		            Los datos de la tutoría se eliminaron con exito
		        </div>
		    ';
		}else{
		    echo '
		        <div class="notification is-danger is-light">
		            <strong>¡Ocurrio un error inesperado!</strong><br>
		            No se pudo eliminar la tutoría, por favor intente nuevamente
		        </div>
		    ';
		}
		$eliminar_tutoria=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La TUTORÍA que intenta eliminar no existe
            </div>
        ';

    }	
    $check_tutoria=null;
?>