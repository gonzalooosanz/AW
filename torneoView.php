<?php 
require_once("includes/control/SessionControl.php"); 
require_once("includes/configuration/Definitions.php"); 
require_once("includes/model/DAOs/DAOTorneo.php");
require_once("includes/model/DAOs/DAOImagenes.php");
require_once("includes/model/DAOs/Torneo.php"); 
require_once("includes/model/DAOs/Imagen.php");
require_once("includes/forms/UserEntrySecurity.php"); 
require_once("includes/control/TorneosControl.php");
require_once("includes/control/Errores.php"); 


?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<meta charset = "UTF-8">
	<title> Padel2u: Torneos </title>
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/torneo.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/layout_plural.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/parejas.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	<script src = "includes/js/provinciasypoblaciones.js"></script>
	<script src = "includes/js/torneo.js"></script>
	<script src = "includes/js/parejas.js"></script>
	<script src = "includes/js/partidos_torneo.js"></script>
	
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_TORNEO);
	require("includes/common/cabecera.php");
	?>

	<div class = "main">
		<?php
		$id = $_GET["id"];
		$torneo = DAOTorneo::selectById($id);
		if($torneo != NULL){
		$imagen = DAOImagenes::selectPrimeraImagenByTorneo($id);
		$tipoSesion = SessionControl::tipoUsuarioLogeado();
		$idSesion = SessionControl::getIdSesion();
		$efectividadSesion = SessionControl::getEfectividadSesion();
		SessionControl::setIdRecurso($id); 
		echo SessionControl::getFeedbackEntrante();
		?>

		<div class="separator">

			<h1> <?php echo ''.$torneo->getNombre().''?></h1>

		</div>

		<div class="separator">
			<div class = "photo_wrapper">
				<?php 
				if($imagen != NULL){ /* El torneo tiene insertada una imagen */ 
					echo '<img src = "'.$imagen->getLocalizacionCargador().'" alt = "Imagen del torneo">'; 
				}
				else{ /* El torneo no tiene ninguna imagen de caratula */ 
					?>
					<img src = "img/caratula_torneo.jpg"  alt = "Imagen del torneo">
				<?php }?>
			</div>


			<h2>Información general</h2>
			<div class ="info_wrapper" id = "ubicacion_torneo">
				<div class = "info_general_wrapper">
				<?php 
				echo '<p>Fecha límite de inscripción: '.$torneo->getFechaInscripcion().'</p>';
				echo '<p>Premio: '.$torneo->getPremio().'</p>';
				echo '<a class = "boton azul medio" id = "localizacion_button" onclick = "cargarLocalizacionTorneo('.$id.')"> Ver Localizacion </a>';
				?>
				</div>
				<div class = "buttons_wrapper" id = "localizacion_wrapper">
				</div>
				<div class = "buttons_wrapper">
				<?php 
				echo '<a class = "boton rojo medio" id = "cerrar_localizacion_button" onclick = "ocultarLocalizacionTorneo()"> Ocultar Localizacion </a>';
				?>
				</div>
			</div>

			<div class="button_wrapper">
				<?php 
				if($tipoSesion == USUARIO_NORMAL || $tipoSesion == USUARIO_ARBITRO){

					/* --------------- APUNTARSE A TORNEO ------------------- */ 
					$comprobacion = TorneosControl::comprobarApuntarseTorneo($id, $idSesion); 
					switch($comprobacion){
						case COMPROBACION_CORRECTA: 
						echo '<a class = "boton azul medio" href = "apuntarmeTorneo.php?id='.$id.'"> Apuntarme </a>'; 
						break; 
						case ERROR_USUARIO_APUNTADO_TORNEO: 
						echo '<a class = "boton rojo medio" href = "desapuntarmeTorneo.php?id='.$id.'"> Desapuntarme </a>'; 
						break; 
						case ERROR_EFECTIVIDAD_INSUFICIENTE: 
						echo '<p class = "parrafo_pequeño rojo"> Tu efectividad('.$efectividadSesion.') es inferior a la requerida ('.$torneo->getEfectividadRequerida().'). </p>'; 
						break; 
						case ERROR_TORNEO_CERRADO: 
						echo '<p class = "parrafo_pequeño rojo"> Torneo cerrado </p>'; 
						break; 
						case ERROR_TORNEO_LLENO: 
						echo '<p class = "parrafo_pequeño rojo"> Torneo lleno </p>'; 
						break; 
						case ERROR_USUARIO_PENDIENTE_ACEPTACION_TORNEO: 
						echo '<p class = "parrafo_pequeño rojo"> Esperando a la aceptacion de tu pareja de juego. </p>'; 
						echo '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/AnularSolicitudPareja.php?id='.$id.'"> Anular Solicitud de Pareja </a>'; 
						break; 
						case ERROR_USUARIO_PENDIENTE_ACEPTAR_SOLICITUD_PAREJA: 
						echo '<p class = "parrafo_pequeño rojo"> Te han solicitado formar pareja para este torneo, ¿Qué deseas hacer? (para mas informacion ver la notificacion). </p>'; 
						echo '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/AnularSolicitudPareja.php?id='.$id.'"> Rechazar Solicitud de Pareja </a>'; 
						echo '<a class = "boton verde medio" href = "includes/peticionesAjaxYRedirecciones/AceptarSolicitudPareja.php?id='.$id.'"> Aceptar Solicitud de Pareja </a>'; 
						break; 
						case ARBITRO_EDITAR_TORNEO:
						    echo '<a class = "boton verde medio" href = "editarTorneo.php?id='.$id.'"> Editar Torneo </a>';
						    break; 
					}
				}
				?>

			</div>
		</div>
	
		<?php 
		  echo '<div class = "separator continuacion" onclick = "datosPartidosTorneo('.$id.')">';
		?>
			<h3>Partidos del torneo</h3>
			<h4 id = "partidos_torneo_button"> Hacer click para desplegar </h4>
			
		<?php echo '</div>'; ?>
		<div class = "resultados_wrapper disabled" id = "resultados_torneo">
		</div>
		<?php 
		 echo '<a class = "boton rojo medio disabled" id = "ocultar_partidos_torneo_button" onclick = "datosPartidosTorneo('.$id.')"> Ocultar Partidos del Torneo</a>'; 
		 ?>
		<?php echo '<div class = "separator continuacion" onclick = "parejasInscritasTorneo('.$id.')">';
		?>
			<h3> Parejas Inscritas en el Torneo </h3>
			<h4 id = "parejas_inscritas_button"> Hacer click para desplegar </h4>
			
		<?php echo '</div>'; ?>
		<div class = "parejas_wrapper disabled" id = "parejas_inscritas_torneo">
		</div>
		<div class = "buttons_wrapper">
			<?php 
			 echo '<a class = "boton rojo medio disabled" id = "ocultar_inscritos_torneo" onclick = "parejasInscritasTorneo('.$id.');"> Ocultar Parejas Inscritas </a>'; 
			?>
		</div>
		
		<?php 
		  echo '<div class = "separator continuacion" onclick = "imagenesTorneo('.$id.');">';
		?>
			<h3>Imágenes</h3>
		<?php echo '</div>'; ?>
	
	
		<div class="separator">
			<h3>Patrocinadores</h3>
		</div>
	
	
			
	<?php }
	else{
	    $opciones = array();
	    $enlace = '<a href = "torneosView.php" class = "boton azul medio"> Volver al catalogo de Torneos. </a>';
	    $error = "Vaya, parece que no puedes ver este torneo";
	    $opciones[] = "1. El torneo no exista actualmente en Padel2u. ";
	    $opciones[] = "2. Para ver un torneo debes haber iniciado sesion en Padel2U. ";
	    
	    echo Errores::generarPantallaInaccesible($error,$opciones, $enlace); 
	}
	?>
	</div>
	<?php 
	   require("includes/common/pie.php");
	?>
</body>
</html>