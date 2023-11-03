<?php

	/*Almacenando datos*/
    $id=limpiar_cadena($_GET['id']);
	$activa="No Activa";

    /*Verificando tutoria*/
    $check_tutoria=conexion();
    $check_tutoria=$check_tutoria->query("SELECT id FROM tutorias WHERE id='$id'");
    
    if($check_tutoria->rowCount()==1){
	
	    $archivar_tutoria=conexion();
	    $archivar_tutoria=$archivar_tutoria->prepare("UPDATE tutorias SET activa=:activa WHERE id=:id");
		
		$marcadores = [
			":activa" => $activa,
			":id" => $id,
		];
	    $archivar_tutoria->execute($marcadores);

		$check_tutoria2=conexion();
    	$check_tutoria2=$check_tutoria2->query("SELECT id FROM tutorias WHERE id='$id'");

		$archivar_tutoria=null;

		/* 
	    if($check_tutoria2->rowCount()==1){
		    echo '
		        <div class="notification is-info is-light">
		            <strong>¡TUTORÍA ARCHIVADA!</strong><br>
		            Los datos de la tutoría se archivaron con exito <br>
					Puede seguir visualizandola en esta sección
					<a href="index.php?vista=historial_tutorias&id='.$id.'"></a>
		        </div>
		    ';
		}else{
		    echo '
		        <div class="notification is-danger is-light">
		            <strong>¡Ocurrio un error inesperado!</strong><br>
		            No se pudo archivar la tutoría, por favor intente nuevamente
		        </div>
		    ';
		}
		*/
    }
	/*
	else{
		
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La TUTORÍA que intenta archivar no existe
            </div>
        ';
    }	
	*/
    $check_tutoria=null;

	echo "<script> window.location.href='index.php?vista=home'; </script>";
?>