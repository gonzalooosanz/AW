<?php 
    require_once("includes/control/SessionControl.php"); 
    require_once("includes/model/DAOs/DAOUsuario.php"); 
     require_once("includes/model/DAOs/DAONotificaciones.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 
    require_once("includes/control/Errores.php"); 

?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Pagina Mi Perfil</title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/perfil.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<!-- <link rel = "stylesheet" type = "text/css" href = "estilos/layout_plural.css"> -->
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/usuario.js"></script>
	<script src = "includes/js/vista.js"></script>
	<script src = "includes/js/provinciasypoblaciones.js"></script>
</head>

<body>
	<?php 
	/* Fija la seccion en la que nos encontramos */ 
	SessionControl::setSeccion(SECCION_PERFIL); 
	require("includes/common/cabecera.php");
	
	 echo SessionControl::getFeedbackEntrante(); 
	 $idUsuarioSesion = SessionControl::getIdSesion(); 
	 $usuarioSesion = DAOUsuario::selectById($idUsuarioSesion);
	 if($usuarioSesion != NULL){
	?>
	<div class = "main">  		
		<div class = "account_info_wrapper">
			<div class = "photo_wrapper">
				<?php 
				if($usuarioSesion->getPerfil() != NULL){
				    echo '<img src = "'.$usuarioSesion->getPerfil().'" alt = "Imagen de perfil de'.$usuarioSesion->getNombre().'">'; 
				}
				else{
				    echo '<img src = "img/user_icon.png" alt = "Imagen de perfil de'.$usuarioSesion->getNombre().'">'; 
				}
				?>
			</div>
			<div class = "info_wrapper">
				<?php 
					echo '<h3>Nombre: '.$usuarioSesion->getNombre().'</h3>';
					echo '<h3>Primer Apellido: '.$usuarioSesion->getApellido1().'</h3>';
					echo '<h3>Segundo Apellido: '.$usuarioSesion->getApellido2().'</h3>';
				?>
			</div>
			
			<div class = "buttons_wrapper">
				<div class = "editar_perfil_wrapper">
					<a href = "formulariosPerfil.php" class = "boton vacio"> Editar Perfil</a>
				</div>
			</div>
			</div>
			
			<?php 
			 echo '<div class = "separator continuacion" onclick = "datosYEstadisticasUsuario('.$idUsuarioSesion.', estadisticas)">'; 
			?>
			<h3> Informacion personal y mis estadisticas </h3>
			<h4 id = "estadisticas_usuario_button"> Hacer click para desplegar </h4>
			<?php echo '</div>'; ?>
			<div class = "estadisticas_usuario_wrapper disabled" id = "estadisticas_usuario">
			</div>
			
			
			<?php echo '<div class = "separator continuacion" onclick = "cargarNotificacionesUsuario('.$idUsuarioSesion.')">'; ?>
			<h3> Mis notificaciones  </h3>
			<h4 id = "notificaciones_usuario_button"> Hacer click para desplegar </h4>
			<?php  echo '</div>'; ?>
			<div class = "notificaciones_usuario_wrapper disabled" id = "notificaciones_usuario">
			</div>
			
			<?php 
			/*
			<h1>Notificaciones del usuario</h1>
			<div class="separator">
				<?php
					$mostradas = array();
					$mostradas = DAONotificaciones::notifyByUser($idUsuarioSesion);
					$indice = 0;
					if($mostradas == NULL || $mostradas == 0) echo '<h2>No hay notificaciones en este momento</h2>';
					else{
						foreach ($mostradas as $key => $value) {
							echo '<h2>Notificación('.($indice+1).')</h2>';
							echo '<h2>'.$mostradas[$indice]->getTexto().'</h2>';
							if($mostradas[$indice]->getTipo() == NOTIFICACION_SOLICITUD_PAREJA){
							    echo '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/AnularSolicitudPareja.php?id='.$mostradas[$indice]->getIdTorneoEnlazado().'"> Rechazar Solicitud de Pareja </a>';
							    echo '<a class = "boton verde medio" href = "includes/peticionesAjaxYRedirecciones/AceptarSolicitudPareja.php?id='.$mostradas[$indice]->getIdTorneoEnlazado().'"> Aceptar Solicitud de Pareja </a>';
							}
							$indice++;
						}
					}
				?>
			</div>
			*/
			?>
			<div class = "popUpPartido_wrapper disabled" id = "popUp">
			</div>
			<?php 
	 }
	 /*
	 <div class="separator">
	 <div class = "recomendaciones_wrapper">
	 <h3>Empieza a aprovechar Padel2U al máximo</h3>
	 <a href = "torneosView.php" class = "boton azul medio"> Apuntate a algún torneo. </a>
	 <a href = "partidosView.php" class = "boton azul medio"> Apuntate a algún partido. </a>
	 </div>
	 </div>*/
	 
	 else{
	     $opciones = array();
	     $enlace = '<a href = "index.php" class = "boton azul medio"> Volver a la pagina principal. </a>';
	     $error = "Vaya, parece que este usuario no existe";
	     $opciones[] = "1. No hayas iniciado sesion correctamente. ";
	     $opciones[] = "2. Estemos teniendo actualmente algun problema en las Bases de Datos de la aplicación. Por favor, vuelva a intentarlo más tarde. ";
	     
	     echo Errores::generarPantallaInaccesible($error,$opciones, $enlace); 
	 }
		?>
	</div>
	<?php 
			 require("includes/common/pie.php"); 
			?>
	
</body>
</html>
	
	