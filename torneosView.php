<?php 
require_once("includes/control/SessionControl.php"); 
require_once("includes/configuration/Definitions.php"); 
require_once("includes/model/DAOs/DAOTorneo.php");
require_once("includes/model/DAOs/DAOImagenes.php");
require_once("includes/model/DAOs/Torneo.php"); 
require_once("includes/model/DAOs/Imagen.php");
require_once("includes/forms/UserEntrySecurity.php"); 
require_once("includes/control/TorneosControl.php");


?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<meta charset = "UTF-8">
	<title> Padel2u: Torneos </title>
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/layout_plural.css">
	<script src = "includes/js/provinciasypoblaciones.js"></script>
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_TORNEO); 
	require("includes/common/cabecera.php");
	?>
	
	<?php 
	/* Captacion de datos necesarios */ 
	
	// Permite generar los partidos del torneo si está cerrado y ha pasado la fecha de inscripcion. 
	TorneosControl::eventosPeriodicosTorneos(); 
	// Obtiene el tipo de usuario que ha iniciado sesion en la pagina. (arbitro, normal o no ha iniciado sesion). 
	$tipoSesion = SessionControl::tipoUsuarioLogeado(); 
	$idSesion = SessionControl::getIdSesion(); 
	$efectividadSesion = SessionControl::getEfectividadSesion(); 
	// Siempre que el DAO nos devuelva varios resultados tenemos que inicializar la variable que los recoja a array (sino no podemos recorrerla)
	$torneos = array(); 
	$torneos = DAOTorneo::selectTorneos(); 
	echo SessionControl::getFeedbackEntrante();
	
	?>
	<div class = "main">
		<!--  1. Boton de crear torneo  -->
		<?php 
		if($tipoSesion == USUARIO_ARBITRO){
			?>
			<div class = "button_wrapper">
				<a href = "crearTorneo.php" class = "boton verde grande"> Crear Torneo </a>
			</div>
			
		<?php } // Fin seccion crear torneo ?>
		
		<!-- 2. Catalogo de torneos  -->
		
		<div class = "torneos_wrapper">
			<?php 
			if(count($torneos) > 0){
				foreach($torneos as &$index){
					$imagen = new Imagen(); 
					$imagen = DAOImagenes::selectPrimeraImagenByTorneo($index->getIdTorneo()); 
					if($index != NULL){
						?>
						<div class = "torneo_wrapper">
							<div class = "photo_wrapper">
								<?php 
								if($imagen != NULL){ /* El torneo tiene insertada una imagen */ 
									echo 'img class = "imagen" src = "'.$imagen->getLocalizacionCargador().'" alt = "Imagen del torneo"'; 
								}
								else{ /* El torneo no tiene ninguna imagen de caratula */ 
									?>
									<img src = "img/caratula_torneo.jpg" class = "imagen" alt = "Imagen de torneo">
								<?php }?>
							</div>
							<div class = "datos_wrapper">
								<h2> <?php echo ''.$index->getNombre().''?></h2>
								<p> Se pueden apuntar <?php echo''.$index->getMaxParejas() - $index->getNumParejas().''?>
							parejas más. </p>
							<p class = "rojo"> Fecha límite de inscripción: <?php echo ''.$index->getFechaInscripcion().''?></p>
						</div>
						<div class = "buttons_wrapper">
							<?php 
							// USADO SOLO SI EL USUARIO HA INICIADO SESION, muestra si el usuario puede apuntarse al torneo, desapuntarse, aceptar solicitud de pareja... 
							if($tipoSesion == USUARIO_NORMAL || $tipoSesion == USUARIO_ARBITRO){
								
								echo '<a class = "boton gris medio" href = "torneoView.php?id='.$index->getIdTorneo().'"> + Info </a>';
								/* --------------- APUNTARSE A TORNEO ------------------- */ 
								$comprobacion = TorneosControl::comprobarApuntarseTorneo($index->getIdTorneo(), $idSesion); 
								switch($comprobacion){
									case COMPROBACION_CORRECTA: 
									echo '<a class = "boton azul medio" href = "apuntarmeTorneo.php?id='.$index->getIdTorneo().'"> Apuntarme </a>'; 
									break; 
									case ERROR_USUARIO_APUNTADO_TORNEO: 
									echo '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/DesapuntarmeTorneo.php?id='.$index->getIdTorneo().'"> Desapuntarme </a>'; 
									break; 
									case ERROR_EFECTIVIDAD_INSUFICIENTE: 
									echo '<p class = "parrafo_pequeño rojo"> Tu efectividad('.$efectividadSesion.') es inferior a la requerida ('.$index->getEfectividadRequerida().'). </p>'; 
									break; 
									case ERROR_TORNEO_CERRADO: 
									echo '<p class = "parrafo_pequeño rojo"> Torneo cerrado </p>'; 
									break; 
									case ERROR_TORNEO_LLENO: 
									echo '<p class = "parrafo_pequeño rojo"> Torneo lleno </p>'; 
									break; 
									case ERROR_USUARIO_PENDIENTE_ACEPTACION_TORNEO: 
									echo '<p class = "parrafo_pequeño rojo"> Esperando a la aceptación de tu pareja de juego. </p>'; 
									echo '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/AnularSolicitudPareja.php?id='.$index->getIdTorneo().'"> Anular Solicitud de Pareja </a>'; 
									break; 
									case ERROR_USUARIO_PENDIENTE_ACEPTAR_SOLICITUD_PAREJA: 
									echo '<p class = "parrafo_pequeño rojo"> Te han solicitado formar pareja para este torneo, ¿Qué deseas hacer? (para mas informacion ver la notificacion). </p>'; 
									echo '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/AnularSolicitudPareja.php?id='.$index->getIdTorneo().'"> Rechazar Solicitud de Pareja </a>'; 
									echo '<a class = "boton verde medio" href = "includes/peticionesAjaxYRedirecciones/AceptarSolicitudPareja.php?id='.$index->getIdTorneo().'"> Aceptar Solicitud de Pareja </a>'; 
									break; 
									case ARBITRO_EDITAR_TORNEO: 
									    echo '<a class = "boton verde medio" href = "editarTorneo.php?id='.$index->getIdTorneo().'"> Editar Torneo </a>';
									    break; 
								}
							}
							
							?>
							
							
						</div>
					</div>
					<?php 
		    } // Fin if ($torneos[$index] != NULL)
		} // Fin foreach
		} // fin if (count($torneos) > 0)
		else{
			?>
			<h2> No existen torneos creados, para poder crear uno necesitas ser arbitro. </h2>
		<?php }
		?>
		
		
	</div>
	
</div>


<?php 
require("includes/common/pie.php");
?>

</body>

</html>